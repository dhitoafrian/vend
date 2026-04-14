<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        [$tanggalMulai, $tanggalSelesai] = $this->resolvePeriode($request);

        $peminjaman = Peminjaman::with('user')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal_pinjam', '>=', $tanggalMulai->toDateString()))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal_pinjam', '<=', $tanggalSelesai->toDateString()))
            ->latest('tanggal_pinjam')
            ->get();

        $pengembalian = Pengembalian::with('peminjaman.user')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal_kembali', '>=', $tanggalMulai->toDateString()))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal_kembali', '<=', $tanggalSelesai->toDateString()))
            ->latest('tanggal_kembali')
            ->get();

        return view('petugas.laporan.index', compact('peminjaman', 'pengembalian', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function print(Request $request): View
    {
        [$tanggalMulai, $tanggalSelesai] = $this->resolvePeriode($request);

        $peminjaman = Peminjaman::with('user')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal_pinjam', '>=', $tanggalMulai->toDateString()))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal_pinjam', '<=', $tanggalSelesai->toDateString()))
            ->latest('tanggal_pinjam')
            ->get();

        $pengembalian = Pengembalian::with('peminjaman.user')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal_kembali', '>=', $tanggalMulai->toDateString()))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal_kembali', '<=', $tanggalSelesai->toDateString()))
            ->latest('tanggal_kembali')
            ->get();

        return view('petugas.laporan.print', compact('peminjaman', 'pengembalian', 'tanggalMulai', 'tanggalSelesai'));
    }

    private function resolvePeriode(Request $request): array
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['nullable', 'date_format:Y-m-d'],
            'tanggal_selesai' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $tanggalMulai = ! empty($validated['tanggal_mulai'])
            ? Carbon::createFromFormat('Y-m-d', $validated['tanggal_mulai'])
            : null;
        $tanggalSelesai = ! empty($validated['tanggal_selesai'])
            ? Carbon::createFromFormat('Y-m-d', $validated['tanggal_selesai'])
            : null;

        if ($tanggalMulai && $tanggalSelesai && $tanggalSelesai->lt($tanggalMulai)) {
            throw ValidationException::withMessages([
                'tanggal_selesai' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.',
            ]);
        }

        return [$tanggalMulai, $tanggalSelesai];
    }
}
