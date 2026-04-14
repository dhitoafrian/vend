<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->when($request->filled('status'), fn ($q) =>
                $q->where('status', $request->status)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function print(Request $request): View
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        return view('admin.peminjaman.print', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman): View
    {
        $peminjaman->load('detailPeminjaman');

        $users = User::where('role', 'peminjam')->orderBy('name')->get();
        $alat = Alat::orderBy('nama_alat')->get();

        $detail = $peminjaman->detailPeminjaman->first();

        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'alat', 'detail'));
    }

    public function update(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status === 'selesai') {
            return back()->withErrors('Data sudah selesai, tidak bisa diubah.');
        }

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'alat_id' => ['required', 'exists:alats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date_format:Y-m-d'],
            'tanggal_kembali_rencana' => ['required', 'date_format:Y-m-d'],
            'status' => ['required', 'in:pending,disetujui,tunda_pengembalian,ditolak,selesai'],
        ]);

        $tanggalPinjam = Carbon::createFromFormat('Y-m-d', $validated['tanggal_pinjam']);
        $tanggalKembaliRencana = Carbon::createFromFormat('Y-m-d', $validated['tanggal_kembali_rencana']);

        if ($tanggalKembaliRencana->lt($tanggalPinjam)) {
            return back()
                ->withErrors(['tanggal_kembali_rencana' => 'Tanggal kembali rencana harus setelah atau sama dengan tanggal pinjam.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $peminjaman, $request) {
            $detail = $peminjaman->detailPeminjaman()->first();
            $oldStatus = $peminjaman->status;
            $newStatus = $validated['status'];
            $oldAffectsStock = in_array($oldStatus, ['disetujui', 'tunda_pengembalian'], true);
            $newAffectsStock = in_array($newStatus, ['disetujui', 'tunda_pengembalian'], true);

            if ($detail) {
                if ($oldAffectsStock) {
                    $alatLama = Alat::find($detail->alat_id);
                    if ($alatLama) {
                        $alatLama->increment('stok', $detail->jumlah);
                    }
                }

                if ($newAffectsStock) {
                    $alatBaru = Alat::findOrFail($validated['alat_id']);
                    if ($alatBaru->stok < $validated['jumlah']) {
                        throw new \Exception('Stok alat tidak cukup.');
                    }
                    $alatBaru->decrement('stok', $validated['jumlah']);
                }

                $detail->update([
                    'alat_id' => $validated['alat_id'],
                    'jumlah' => $validated['jumlah'],
                ]);

            } else {
                if ($newAffectsStock) {
                    $alat = Alat::findOrFail($validated['alat_id']);
                    if ($alat->stok < $validated['jumlah']) {
                        throw new \Exception('Stok alat tidak cukup.');
                    }
                    $alat->decrement('stok', $validated['jumlah']);
                }

                $detail = DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $validated['alat_id'],
                    'jumlah' => $validated['jumlah'],
                ]);
            }

            $peminjaman->update([
                'user_id' => $validated['user_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
                'status' => $newStatus,
            ]);

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => 'Admin mengedit peminjaman ID: ' . $peminjaman->id,
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function destroy(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        DB::transaction(function () use ($peminjaman, $request) {
            $shouldRestoreStock = in_array($peminjaman->status, ['disetujui', 'tunda_pengembalian'], true);

            if ($shouldRestoreStock) {
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    $alat = Alat::find($detail->alat_id);
                    if ($alat) {
                        $alat->increment('stok', $detail->jumlah);
                    }
                }
            }

            $peminjaman->delete();

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => 'Admin menghapus peminjaman ID: ' . $peminjaman->id,
            ]);
        });

        return redirect()
            ->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
