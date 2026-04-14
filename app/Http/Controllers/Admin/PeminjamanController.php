<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\User;
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
            'alat_id' => ['required', 'exists:alat,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'status' => ['required', 'in:pending,disetujui,ditolak,selesai'],
        ]);

        DB::transaction(function () use ($validated, $peminjaman, $request) {
            $peminjaman->update([
                'user_id' => $validated['user_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
                'status' => $validated['status'],
            ]);

            $detail = $peminjaman->detailPeminjaman()->first();

            if ($detail) {

                $alatLama = Alat::find($detail->alat_id);
                if ($alatLama) {
                    $alatLama->stok += $detail->jumlah;
                    $alatLama->save();
                }

                $alatBaru = Alat::findOrFail($validated['alat_id']);

                if ($alatBaru->stok < $validated['jumlah']) {
                    throw new \Exception('Stok alat tidak cukup.');
                }

                $alatBaru->stok -= $validated['jumlah'];
                $alatBaru->save();

                $detail->update([
                    'alat_id' => $validated['alat_id'],
                    'jumlah' => $validated['jumlah'],
                ]);

            } else {
                $alat = Alat::findOrFail($validated['alat_id']);

                if ($alat->stok < $validated['jumlah']) {
                    throw new \Exception('Stok alat tidak cukup.');
                }

                $alat->stok -= $validated['jumlah'];
                $alat->save();

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $validated['alat_id'],
                    'jumlah' => $validated['jumlah'],
                ]);
            }

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

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = Alat::find($detail->alat_id);
                if ($alat) {
                    $alat->stok += $detail->jumlah;
                    $alat->save();
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
