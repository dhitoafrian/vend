<x-layouts.dashboard title="Kelola Alat">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header Actions -->
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between gap-4 border-b border-slate-100">
            <form method="GET" class="grid sm:grid-cols-3 gap-3 w-full sm:max-w-2xl">
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input name="q" value="{{ request('q') }}" placeholder="Cari alat..." class="w-full border border-slate-300 rounded-xl pl-9 pr-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                </div>
                <select name="kategori_id" class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all appearance-none bg-white">
                    <option value="">Semua kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" @selected((string) request('kategori_id') === (string) $item->id)>{{ $item->nama_kategori }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">Terapkan Filter</button>
            </form>
            <a href="{{ route('admin.alat.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Alat
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Foto</th>
                        <th class="px-6 py-3 font-semibold">Nama Alat</th>
                        <th class="px-6 py-3 font-semibold">Kategori</th>
                        <th class="px-6 py-3 font-semibold">Stok</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($alat as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3">
                                @if ($item->foto)
                                    <div class="h-10 w-10 rounded-lg overflow-hidden border border-slate-200">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_alat }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->nama_alat }}</td>
                            <td class="px-6 py-4">{{ $item->kategori?->nama_kategori ?? '-' }}</td>
                            <td class="px-6 py-4"><span class="font-medium">{{ $item->stok }}</span> unit</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.alat.edit', $item) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('admin.alat.destroy', $item) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium" onclick="return confirm('Hapus alat ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data alat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($alat->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $alat->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
