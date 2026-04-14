<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang bisa disetujui.');
        }

        DB::transaction(function () use ($request, $peminjaman) {
            $peminjaman->load('detailPeminjaman');

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);

                if ($alat->stok < $detail->jumlah) {
                    throw new \RuntimeException("Stok {$alat->nama_alat} tidak mencukupi.");
                }

                $alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'disetujui']);

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => "Menyetujui peminjaman #{$peminjaman->id}",
            ]);
        });

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang bisa ditolak.');
        }

        $peminjaman->update(['status' => 'ditolak']);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Menolak peminjaman #{$peminjaman->id}",
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
}
