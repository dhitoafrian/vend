<x-layouts.dashboard title="Kelola Peminjaman">
    <div class="bg-white rounded shadow p-4">
        <div class="mb-4">
            <form method="GET">
                <select name="status" class="border rounded px-3 py-2">
                    <option value="">Semua status</option>
                    @foreach (['pending', 'disetujui', 'ditolak', 'selesai'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="bg-slate-900 text-white rounded px-3 py-2">Filter</button>
            </form>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Peminjam</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Status</th><th>Detail</th></tr></thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    @php($detail = $item->detailPeminjaman->first())
                    <tr class="border-b">
                        <td class="py-2">{{ $item->user?->name }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                        <td>{{ $item->tanggal_kembali_rencana?->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ $detail?->alat?->nama_alat }} ({{ $detail?->jumlah }})</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-2 text-center text-gray-500">Data kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $peminjaman->links() }}</div>
    </div>
</x-layouts.dashboard>
