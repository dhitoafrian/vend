<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUser' => User::count(),
            'totalKategori' => Kategori::count(),
            'totalAlat' => Alat::count(),
            'totalPeminjaman' => Peminjaman::count(),
            'totalPengembalian' => Pengembalian::count(),
        ]);
    }
}
