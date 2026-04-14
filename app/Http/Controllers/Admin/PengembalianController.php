<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(Request $request): View
    {
        $pengembalian = Pengembalian::with('peminjaman.user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function print(Request $request): View
    {
        $pengembalian = Pengembalian::with('peminjaman.user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('id')
            ->get();

        return view('admin.pengembalian.print', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian): View
    {
        $pengembalian->load('peminjaman.user');

        return view('admin.pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_kembali' => ['required', 'date'],
            'denda' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:tepat,terlambat'],
        ]);

        $pengembalian->update($validated);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => 'Admin mengedit pengembalian ID: ' . $pengembalian->id,
        ]);

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengembalian $pengembalian): RedirectResponse
    {
        DB::transaction(function () use ($request, $pengembalian) {
            $loan = Peminjaman::with('detailPeminjaman')->find($pengembalian->peminjaman_id);

            if ($loan) {
                if ($loan->status === 'selesai') {
                    foreach ($loan->detailPeminjaman as $detail) {
                        $alat = Alat::find($detail->alat_id);
                        if ($alat) {
                            if ($alat->stok < $detail->jumlah) {
                                throw new \RuntimeException("Stok {$alat->nama_alat} tidak cukup untuk rollback pengembalian.");
                            }
                            $alat->decrement('stok', $detail->jumlah);
                        }
                    }
                }

                $loan->update(['status' => 'disetujui']);
            }

            $pengembalian->delete();

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => 'Admin menghapus pengembalian ID: ' . $pengembalian->id,
            ]);
        });

        return redirect()
            ->route('admin.pengembalian.index')
            ->with('success', 'Data pengembalian berhasil dihapus.');
    }
}
