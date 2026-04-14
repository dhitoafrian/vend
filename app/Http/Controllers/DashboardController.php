<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $routeName = match ($request->user()->role) {
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            default => 'peminjam.dashboard',
        };

        return redirect()->route($routeName);
    }
}
