<x-layouts.dashboard title="Peminjaman Saya">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 flex justify-end border-b border-slate-100">
            <a href="{{ route('peminjam.alat.index') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Pinjam Alat
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Alat</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($myPeminjaman as $item)
                        @php($detail = $item->detailPeminjaman->first())
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-700' : ($item->status === 'disetujui' ? 'bg-blue-100 text-blue-700' : ($item->status === 'ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700')) }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada pengajuan peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($myPeminjaman->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $myPeminjaman->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
