<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $myPeminjaman = Peminjaman::with('detailPeminjaman.alat')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('peminjam.peminjaman.index', compact('myPeminjaman'));
    }

    public function create(Request $request): View
    {
        $alat = Alat::orderBy('nama_alat')->limit(100)->get();

        return view('peminjam.peminjaman.create', compact('alat'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alat_id' => ['required', 'exists:alat,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        $peminjaman = Peminjaman::create([
            'user_id' => $request->user()->id,
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $validated['tanggal_kembali_rencana'],
            'status' => 'pending',
        ]);

        DetailPeminjaman::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $validated['alat_id'],
            'jumlah' => $validated['jumlah'],
        ]);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Mengajukan peminjaman #{$peminjaman->id}",
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }
}
