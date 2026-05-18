<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(Request $request): View
    {
        $pengembalian = Pengembalian::with('peminjaman.user', 'peminjaman.detailPeminjaman.alat')
            ->whereHas('peminjaman', fn ($q) => $q->where('status', 'tunda_pengembalian'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.pengembalian.index', compact('pengembalian'));
    }

    public function verify(Request $request, Pengembalian $pengembalian): RedirectResponse
    {
        $validated = $request->validate([
            'aksi' => ['required', 'in:setujui'],
        ]);

        $loan = $pengembalian->peminjaman;

        if (! $loan || $loan->status !== 'tunda_pengembalian') {
            return back()->with('error', 'Pengajuan pengembalian ini tidak bisa diverifikasi lagi.');
        }

        DB::transaction(function () use ($validated, $loan, $pengembalian, $request) {
            $loan->load('detailPeminjaman');

            foreach ($loan->detailPeminjaman as $detail) {
                $alat = Alat::find($detail->alat_id);
                if ($alat) {
                    $alat->increment('stok', $detail->jumlah);
                }
            }

            $loan->update(['status' => 'selesai']);

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => "Menyetujui pengembalian peminjaman #{$loan->id}",
            ]);
        });

        // Broadcast real-time ke peminjam
        broadcast(new \App\Events\PengembalianDiverifikasi($pengembalian));

        return back()->with('success', 'Verifikasi pengembalian berhasil diproses.');
    }
}
