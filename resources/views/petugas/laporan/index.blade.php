<x-layouts.dashboard title="Laporan Peminjaman dan Pengembalian">
    <div class="bg-white rounded shadow p-4 mb-4">
        <form method="GET" class="flex flex-wrap items-end gap-2">
            <div>
                <label class="text-sm text-gray-600">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="border rounded px-3 py-2">
            </div>
            <div>
                <label class="text-sm text-gray-600">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="border rounded px-3 py-2">
            </div>
            <button class="bg-slate-900 text-white rounded px-4 py-2">Filter</button>
            <a target="_blank" href="{{ route('petugas.laporan.print', request()->query()) }}" class="bg-blue-600 text-white rounded px-4 py-2">Cetak Laporan</a>
        </form>
    </div>

    <div class="bg-white rounded shadow p-4 mb-4">
        <h2 class="font-semibold mb-3">Data Peminjaman</h2>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Peminjam</th><th>Tanggal Pinjam</th><th>Status</th></tr></thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->user?->name }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-2 text-center text-gray-500">Data peminjaman kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded shadow p-4">
        <h2 class="font-semibold mb-3">Data Pengembalian</h2>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Peminjam</th><th>Tanggal Kembali</th><th>Status</th><th>Denda</th></tr></thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->peminjaman?->user?->name }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>{{ $item->denda }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-2 text-center text-gray-500">Data pengembalian kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.dashboard>
