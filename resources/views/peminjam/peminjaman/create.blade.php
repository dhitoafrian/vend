<x-layouts.dashboard title="Form Peminjaman Alat">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alat</label>
                <select name="alat_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach ($alat as $item)
                        <option value="{{ $item->id }}" @selected((string) old('alat_id', request('alat_id')) === (string) $item->id)>{{ $item->nama_alat }} (stok: {{ $item->stok }})</option>
                    @endforeach
                </select>
                @error('alat_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Pinjam</label>
                <input name="jumlah" type="number" min="1" value="{{ old('jumlah', 1) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('jumlah')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pinjam</label>
                <input name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_pinjam')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Rencana Kembali</label>
                <input name="tanggal_kembali_rencana" type="date" value="{{ old('tanggal_kembali_rencana') }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_kembali_rencana')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Ajukan Peminjaman</button>
                <a href="{{ route('peminjam.alat.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Kembali</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
