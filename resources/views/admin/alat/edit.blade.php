<x-layouts.dashboard title="Edit Alat">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.alat.update', $alat) }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Alat</label>
                    <input name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" placeholder="Masukkan nama alat" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    @error('nama_alat')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}" @selected((string) old('kategori_id', $alat->kategori_id) === (string) $item->id)>{{ $item->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Stok</label>
                    <input name="stok" type="number" min="0" value="{{ old('stok', $alat->stok) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    @error('stok')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                        <option value="tersedia" @selected(old('status', $alat->status) === 'tersedia')>Tersedia</option>
                        <option value="rusak" @selected(old('status', $alat->status) === 'rusak')>Rusak</option>
                    </select>
                    @error('status')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Foto Alat</label>
                    @if ($alat->foto)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="h-24 w-24 object-cover rounded-xl border border-slate-200">
                        </div>
                    @endif
                    <input name="foto" type="file" accept="image/*" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    @error('foto')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.alat.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
