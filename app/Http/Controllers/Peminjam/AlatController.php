<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlatController extends Controller
{
    public function index(Request $request): View
    {
        $alat = Alat::with('kategori')
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where('nama_alat', 'like', '%'.$request->q.'%');
            })
            ->orderBy('nama_alat')
            ->paginate(10)
            ->withQueryString();

        return view('peminjam.alat.index', compact('alat'));
    }
}
