<x-layouts.dashboard title="Edit Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.peminjaman.update', $peminjaman) }}" class="p-6 space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Peminjam</label>
                <select name="user_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string) old('user_id', $peminjaman->user_id) === (string) $user->id)>{{ $user->name }} - {{ $user->email }}</option>
                    @endforeach
                </select>
                @error('user_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alat</label>
                <select name="alat_id" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach ($alat as $item)
                        <option value="{{ $item->id }}" @selected((string) old('alat_id', $detail?->alat_id) === (string) $item->id)>{{ $item->nama_alat }}</option>
                    @endforeach
                </select>
                @error('alat_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah</label>
                <input name="jumlah" type="number" min="1" value="{{ old('jumlah', $detail?->jumlah ?? 1) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('jumlah')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pinjam</label>
                <input name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam?->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_pinjam')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Rencana Kembali</label>
                <input name="tanggal_kembali_rencana" type="date" value="{{ old('tanggal_kembali_rencana', $peminjaman->tanggal_kembali_rencana?->format('Y-m-d')) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('tanggal_kembali_rencana')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    @foreach (['pending', 'disetujui', 'tunda_pengembalian', 'ditolak', 'selesai'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $peminjaman->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Simpan Perubahan</button>
                <a href="{{ route('admin.peminjaman.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
