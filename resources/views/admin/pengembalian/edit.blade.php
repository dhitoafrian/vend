<x-layouts.dashboard title="Edit Pengembalian">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.pengembalian.update', $pengembalian) }}" class="p-6 space-y-6">
            @csrf @method('PUT')
            <div class="text-sm text-slate-600 bg-slate-50 rounded-xl px-4 py-3">
                Peminjam: <span class="font-semibold text-slate-800">{{ $pengembalian->peminjaman?->user?->name ?? '-' }}</span>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kembali</label>
                <input name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali', $pengembalian->tanggal_kembali?->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_kembali')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Denda (Rp)</label>
                <input name="denda" type="number" min="0" value="{{ old('denda', $pengembalian->denda) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('denda')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach (['tepat', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $pengembalian->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.pengembalian.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
