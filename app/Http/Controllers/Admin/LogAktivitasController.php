<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogAktivitasController extends Controller
{
    public function index(Request $request): View
    {
        $logs = LogAktivitas::query()
            ->with('user')
            ->when($request->filled('q'), fn ($query) => $query->where('aktivitas', 'like', '%'.$request->string('q').'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.log-aktivitas.index', compact('logs'));
    }
}
