<x-layouts.dashboard title="Pengembalian Alat">
    <div class="grid lg:grid-cols-2 gap-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Peminjaman Aktif</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2">Alat</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myActiveLoans as $item)
                            @php($detail = $item->detailPeminjaman->first())
                            <tr class="border-b">
                                <td class="py-2">{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                                <td>{{ $item->tanggal_kembali_rencana?->format('Y-m-d') }}</td>
                                <td>
                                    @if ($item->status === 'tunda_pengembalian')
                                        <span class="text-amber-600">Menunggu verifikasi</span>
                                    @else
                                        <span class="text-green-600">Sedang dipinjam</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if ($item->status === 'disetujui')
                                        <form method="POST" action="{{ route('peminjam.pengembalian.store') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                            <button class="text-blue-600">Ajukan Pengembalian</button>
                                        </form>
                                    @else
                                        <button disabled class="text-gray-400 cursor-not-allowed">Sudah diajukan</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 text-center text-gray-500">Tidak ada peminjaman aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Riwayat Pengembalian Saya</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="py-2">Tanggal Kembali</th>
                            <th>Ketepatan</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($myPengembalian as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                                <td>
                                    <span class="inline-block px-2 py-1 text-xs rounded {{ $item->status === 'terlambat' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-2 text-center text-gray-500">Belum ada pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $myPengembalian->links() }}</div>
        </div>
    </div>
</x-layouts.dashboard>
