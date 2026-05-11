<x-layouts.dashboard title="Laporan Peminjaman dan Pengembalian">
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="border border-slate-300 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="border border-slate-300 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                </div>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">Filter</button>
                <a target="_blank" href="{{ route('petugas.laporan.print', request()->query()) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">Cetak Laporan</a>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Data Peminjaman</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Peminjam</th>
                            <th class="px-6 py-3 font-semibold">Tanggal Pinjam</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($peminjaman as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $item->user?->name }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status === 'disetujui' ? 'bg-blue-100 text-blue-700' : ($item->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700')) }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">Data peminjaman kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Data Pengembalian</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Peminjam</th>
                            <th class="px-6 py-3 font-semibold">Tanggal Kembali</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pengembalian as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $item->peminjaman?->user?->name }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-rose-600 font-semibold">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">Data pengembalian kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
