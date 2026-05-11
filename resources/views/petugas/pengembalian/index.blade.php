<x-layouts.dashboard title="Verifikasi Pengembalian">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <select name="status" class="border border-slate-300 rounded-xl px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all bg-white">
                    <option value="">Semua status</option>
                    @foreach (['tepat', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Peminjam</th>
                        <th class="px-6 py-3 font-semibold">Alat</th>
                        <th class="px-6 py-3 font-semibold">Tanggal Kembali</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Denda</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pengembalian as $item)
                        @php($detail = $item->peminjaman?->detailPeminjaman?->first())
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $item->peminjaman?->user?->name }}</td>
                            <td class="px-6 py-4">{{ $detail?->alat?->nama_alat }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-rose-600 font-semibold">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('petugas.pengembalian.verify', $item) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="aksi" value="setujui">
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Setujui</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengembalian->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $pengembalian->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
