<x-layouts.dashboard title="Pengembalian Alat">
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Peminjaman Aktif</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Alat</th>
                            <th class="px-6 py-3 font-semibold">Rencana Kembali</th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($myActiveLoans as $item)
                            @php($detail = $item->detailPeminjaman->first())
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                                <td class="px-6 py-4">{{ $item->tanggal_kembali_rencana?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-right">
                                    @if ($item->status === 'disetujui')
                                        <form method="POST" action="{{ route('peminjam.pengembalian.store') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg px-3 py-1.5 transition-colors">Ajukan Kembali</button>
                                        </form>
                                    @else
                                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg">Menunggu verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Tidak ada peminjaman aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-black text-slate-800">Riwayat Pengembalian</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-600">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Tanggal</th>
                            <th class="px-6 py-3 font-semibold">Ketepatan</th>
                            <th class="px-6 py-3 font-semibold">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($myPengembalian as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'terlambat' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-rose-600 font-semibold">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($myPengembalian->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $myPengembalian->links() }}
            </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
