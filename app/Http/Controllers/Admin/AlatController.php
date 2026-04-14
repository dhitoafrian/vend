<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AlatController extends Controller
{
    public function index(Request $request): View
    {
        $alat = Alat::with('kategori')
            ->when(
                $request->kategori_id,
                fn($q) =>
                $q->where('kategori_id', $request->kategori_id)
            )
            ->when(
                $request->q,
                fn($q) =>
                $q->where('nama_alat', 'like', "%{$request->q}%")
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();


        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.index', compact('alat', 'kategori'));
    }

    public function create(): View
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.create', compact('kategori'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:150'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'stok' => ['required', 'integer', 'min:0'],
            'foto' => ['required', 'image', 'max:2048'],
            'status' => ['required', 'in:tersedia,rusak'],
        ]);

        if ($validated['status'] === 'rusak') {
            $validated['stok'] = 0;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }


        $alat = Alat::create($validated);

        $this->logAction($request, 'Menambah alat: ' . $alat->nama_alat);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat): View
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    public function update(Request $request, Alat $alat): RedirectResponse
    {
        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:150'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'stok' => ['required', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:tersedia,rusak'],
        ]);

        if ($request->hasFile('foto')) {
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }

            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($validated);

        $this->logAction($request, 'Memperbarui alat: ' . $alat->nama_alat);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Request $request, Alat $alat): RedirectResponse
    {
        if ($alat->peminjaman()->exists()) {
            return back()->withErrors('Alat sedang digunakan, tidak bisa dihapus.');
        }

        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $nama = $alat->nama_alat;

        $alat->delete();

        $this->logAction($request, 'Menghapus alat: ' . $nama);

        return redirect()
            ->route('admin.alat.index')
            ->with('success', 'Alat berhasil dihapus.');
    }

    private function logAction(Request $request, string $activity): void
    {
        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => $activity,
        ]);
    }
}
