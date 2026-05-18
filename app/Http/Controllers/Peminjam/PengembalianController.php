<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(Request $request): View
    {
        $myPengembalian = Pengembalian::with('peminjaman.detailPeminjaman.alat')
            ->whereHas('peminjaman', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->latest('id')
            ->paginate(10);

        $myActiveLoans = Peminjaman::where('user_id', $request->user()->id)
            ->whereIn('status', ['disetujui', 'tunda_pengembalian'])
            ->with('detailPeminjaman.alat')
            ->with('pengembalian')
            ->latest()
            ->limit(100)
            ->get();

        return view('peminjam.pengembalian.index', compact('myPengembalian', 'myActiveLoans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'peminjaman_id' => ['required', 'exists:peminjamen,id'],
        ]);

        $loan = Peminjaman::where('id', $validated['peminjaman_id'])
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($loan->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum bisa diajukan untuk pengembalian.');
        }

        if ($loan->pengembalian()->exists()) {
            return back()->with('error', 'Pengembalian untuk peminjaman ini sudah diajukan.');
        }

        $tanggalKembali = Carbon::today();
        $rencanaKembali = Carbon::parse($loan->tanggal_kembali_rencana);
        $telatHari = max(0, $rencanaKembali->diffInDays($tanggalKembali, false));

        $status = $telatHari > 0 ? 'terlambat' : 'tepat';
        $denda = $telatHari * 5000;

        $pengembalian = DB::transaction(function () use ($loan, $validated, $denda, $status, $request, $tanggalKembali) {
            $created = Pengembalian::create([
                'peminjaman_id' => $loan->id,
                'tanggal_kembali' => $tanggalKembali->toDateString(),
                'denda' => $denda,
                'status' => $status,
            ]);

            $loan->update(['status' => 'tunda_pengembalian']);

            LogAktivitas::create([
                'user_id' => $request->user()->id,
                'aktivitas' => "Mengajukan pengembalian untuk peminjaman #{$loan->id}",
            ]);

            return $created;
        });

        // Broadcast real-time ke petugas
        broadcast(new \App\Events\PengembalianDiajukan($pengembalian));

        return back()->with('success', 'Pengajuan pengembalian berhasil dibuat.');
    }
}
