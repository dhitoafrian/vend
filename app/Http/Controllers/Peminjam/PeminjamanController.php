<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Carbon\Carbon;
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
            'alat_id' => ['required', 'exists:alats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_pinjam' => ['required', 'date_format:Y-m-d'],
            'tanggal_kembali_rencana' => ['required', 'date_format:Y-m-d'],
        ]);

        $tanggalPinjam = Carbon::createFromFormat('Y-m-d', $validated['tanggal_pinjam']);
        $tanggalKembaliRencana = Carbon::createFromFormat('Y-m-d', $validated['tanggal_kembali_rencana']);

        if ($tanggalKembaliRencana->lt($tanggalPinjam)) {
            return back()
                ->withErrors(['tanggal_kembali_rencana' => 'Tanggal kembali rencana harus setelah atau sama dengan tanggal pinjam.'])
                ->withInput();
        }

        $alat = Alat::findOrFail($validated['alat_id']);

        if ($validated['jumlah'] > $alat->stok) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (' . $alat->stok . ')'])
                ->withInput();
        }

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
