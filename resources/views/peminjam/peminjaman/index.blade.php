<x-layouts.dashboard title="Peminjaman Saya">
    <div class="bg-white rounded shadow p-4">
        <div class="flex justify-end mb-3">
            <a href="{{ route('peminjam.alat.index') }}" class="bg-blue-600 text-white rounded px-4 py-2">+ Pinjam Alat</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b text-left"><th class="py-2">Tanggal</th><th>Alat</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($myPeminjaman as $item)
                        @php($detail = $item->detailPeminjaman->first())
                        <tr class="border-b">
                            <td class="py-2">{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                            <td>{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                            <td>{{ ucfirst($item->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-2 text-center text-gray-500">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $myPeminjaman->links() }}</div>
    </div>
</x-layouts.dashboard>
