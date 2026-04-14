<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingPeminjaman = Peminjaman::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $pendingPengembalian = Peminjaman::with('user')
            ->where('status', 'tunda_pengembalian')
            ->latest()
            ->limit(5)
            ->get();

        $totalPending = Peminjaman::where('status', 'pending')->count();
        $totalDipinjam = Peminjaman::where('status', 'disetujui')->count();
        $totalSelesai = Peminjaman::where('status', 'selesai')->count();

        return view('petugas.dashboard', compact(
            'pendingPeminjaman',
            'pendingPengembalian',
            'totalPending',
            'totalDipinjam',
            'totalSelesai'
        ));
    }
}
