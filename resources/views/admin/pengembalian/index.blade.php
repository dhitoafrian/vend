<x-layouts.dashboard title="Kelola Pengembalian">
    <div class="bg-white rounded shadow p-4">
        <div class="mb-4">
            <form method="GET">
                <select name="status" class="border rounded px-3 py-2">
                    <option value="">Semua status</option>
                    @foreach (['tepat', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="bg-slate-900 text-white rounded px-3 py-2">Filter</button>
            </form>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Peminjam</th><th>Tanggal Kembali</th><th>Denda</th><th>Status</th></tr></thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->peminjaman?->user?->name }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>{{ $item->denda }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-2 text-center text-gray-500">Data kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $pengembalian->links() }}</div>
    </div>
</x-layouts.dashboard>
