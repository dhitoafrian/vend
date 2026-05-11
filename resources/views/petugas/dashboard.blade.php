<x-layouts.dashboard title="Dashboard Petugas">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Card Pending -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalPending }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card Dipinjam -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dipinjam</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalDipinjam }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card Selesai -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 border-l-4 border-l-emerald-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalSelesai }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pending Peminjaman -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-black text-slate-800 tracking-tight">Antrean Pengajuan</h2>
                <a href="{{ route('petugas.peminjaman.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse ($pendingPeminjaman as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs uppercase">
                                {{ substr($item->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->user->name }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-medium tracking-tighter">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-widest">Pending</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-slate-400">Tidak ada pengajuan baru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Pengembalian -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-black text-slate-800 tracking-tight">Verifikasi Kembali</h2>
                <a href="{{ route('petugas.pengembalian.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse ($pendingPengembalian as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:bg-white hover:shadow-md transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs uppercase">
                                {{ substr($item->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $item->user->name }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-medium tracking-tighter">Menunggu Verifikasi</p>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-slate-400">Semua pengembalian sudah diverifikasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>
