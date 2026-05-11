<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = Kategori::when($request->filled('q'), fn($query) => $query->where('nama_kategori', 'like', '%' . $request->string('q') . '%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'denda_per_hari' => 'required|integer|min:5000',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'denda_per_hari' => $request->denda_per_hari,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return view('admin.kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'denda_per_hari' => 'required|integer|min:5000',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'denda_per_hari' => $request->denda_per_hari,
        ]);


        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
