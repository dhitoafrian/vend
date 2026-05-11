<x-layouts.dashboard title="Daftar Alat">

    <div class="mb-8">
        <div class="max-w-xl">
            <form method="GET" class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input name="q" value="{{ request('q') }}"
                    placeholder="Cari nama alat atau kategori..."
                    class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all shadow-sm">
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($alat as $item)
            <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
                
                <!-- FOTO -->
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <img src="{{ $item->foto
                        ? asset('storage/' . $item->foto)
                        : 'https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?q=80&w=400&auto=format&fit=crop' }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <!-- BADGE STATUS -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm backdrop-blur-md
                            {{ $item->status === 'tersedia'
                                ? 'bg-emerald-500/90 text-white'
                                : 'bg-rose-500/90 text-white' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                </div>

                <!-- INFO -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="mb-4">
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">
                            {{ $item->kategori?->nama_kategori ?? 'Tanpa Kategori' }}
                        </p>
                        <h3 class="font-bold text-slate-800 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $item->nama_alat }}</h3>
                        <div class="mt-2 flex items-center gap-2">
                            <div class="flex flex-1 items-center gap-1.5">
                                <div class="w-1.5 h-1.5 rounded-full {{ $item->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                <p class="text-xs text-slate-500">Stok: <span class="font-bold text-slate-700">{{ $item->stok }} unit</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- AKSI -->
                    <div class="mt-auto">
                        @if ($item->status === 'tersedia' && $item->stok > 0)
                            <a href="{{ route('peminjam.peminjaman.create', ['alat_id' => $item->id]) }}"
                               class="flex items-center justify-center gap-2 w-full bg-slate-900 hover:bg-blue-600 text-white text-sm font-bold py-3 rounded-2xl transition-all shadow-lg shadow-slate-200">
                               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                               Pinjam Sekarang
                            </a>
                        @else
                            <button disabled
                                class="w-full bg-slate-100 text-slate-400 text-sm font-bold py-3 rounded-2xl cursor-not-allowed border border-slate-200">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <p class="text-slate-500 font-medium">Belum ada data alat yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $alat->links() }}
    </div>

</x-layouts.dashboard>
