<x-layouts.dashboard title="Tambah Alat">
    <form method="POST" action="{{ route('admin.alat.store') }}" enctype="multipart/form-data"
        class="bg-white rounded shadow p-4 space-y-3">
        @csrf
        <input name="nama_alat" value="{{ old('nama_alat') }}" placeholder="Nama alat"
            class="w-full border rounded px-3 py-2">
        <select name="kategori_id" class="w-full border rounded px-3 py-2">
            @foreach ($kategori as $item)
                <option value="{{ $item->id }}" @selected((string) old('kategori_id') === (string) $item->id)>{{ $item->nama_kategori }}</option>
            @endforeach
        </select>
        <input name="stok" type="number" min="0" value="{{ old('stok', 0) }}" placeholder="Stok"
            class="w-full border rounded px-3 py-2">
        <input name="foto" type="file" accept="image/*" class="w-full border rounded px-3 py-2">
        <select name="status">
            <option value="tersedia" @selected(old('status', $alat->status ?? '') == 'tersedia')>
                Tersedia
            </option>
            <option value="rusak" @selected(old('status', $alat->status ?? '') == 'rusak')>
                Rusak
            </option>
        </select>
        <button class="bg-slate-900 text-white rounded px-4 py-2">Simpan</button>
    </form>
</x-layouts.dashboard>
