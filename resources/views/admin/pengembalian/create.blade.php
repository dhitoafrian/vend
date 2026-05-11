<x-layouts.dashboard title="Tambah Pengembalian">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.pengembalian.store') }}" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Peminjaman</label>
                <select name="peminjaman_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach ($peminjaman as $item)
                        <option value="{{ $item->id }}" @selected((string) old('peminjaman_id') === (string) $item->id)>
                            {{ $item->user?->name }} - {{ $item->tanggal_pinjam?->format('Y-m-d') }}
                        </option>
                    @endforeach
                </select>
                @error('peminjaman_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kembali</label>
                <input name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_kembali')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Denda (Rp)</label>
                <input name="denda" type="number" min="0" value="{{ old('denda', 0) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('denda')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach (['tepat', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Simpan</button>
                <a href="{{ route('admin.pengembalian.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
