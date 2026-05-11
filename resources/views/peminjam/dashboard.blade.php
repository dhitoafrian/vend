<x-layouts.dashboard title="Dashboard Saya">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 mb-8">
        <div class="max-w-2xl">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 mb-3 tracking-tight">
                Halo, <span class="text-blue-600">{{ auth()->user()->name }}</span>!
            </h2>
            <p class="text-slate-500 text-base mb-6 leading-relaxed">
                Selamat datang kembali di VEND. Kelola peminjaman dan pengembalian alat dengan mudah.
            </p>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('peminjam.alat.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all active:scale-95 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Lihat & Pinjam Alat
                </a>
                <a href="{{ route('peminjam.peminjaman.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all active:scale-95 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Peminjaman
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-black text-slate-800">Alat Menunggu Persetujuan</h3>
            @if ($pendingPeminjaman->count() > 0)
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">{{ $pendingPeminjaman->count() }} menunggu</span>
            @endif
        </div>

        <div class="space-y-3">
            @forelse ($pendingPeminjaman as $item)
                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex-1 min-w-0 mr-3">
                        <p class="text-sm font-bold text-slate-800 truncate">
                            {{ $item->detailPeminjaman->first()?->alat?->nama ?? 'Alat tidak tersedia' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                        </p>
                    </div>
                    <span class="shrink-0 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-wider">Pending</span>
                </div>
            @empty
                <div class="text-center py-10">
                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-slate-400">Tidak ada alat yang menunggu persetujuan</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.dashboard>
