<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingPeminjaman = Peminjaman::with('detailPeminjaman.alat')
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('peminjam.dashboard', compact('pendingPeminjaman'));
    }
}
