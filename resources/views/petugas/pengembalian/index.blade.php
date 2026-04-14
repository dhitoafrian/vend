<x-layouts.dashboard title="Verifikasi Pengembalian">
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
            <thead>
                <tr class="border-b text-left">
                    <th class="py-2">Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    @php($detail = $item->peminjaman?->detailPeminjaman?->first())
                    <tr class="border-b">
                        <td class="py-2">{{ $item->peminjaman?->user?->name }}</td>
                        <td>{{ $detail?->alat?->nama_alat }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>
                            <span class="inline-block px-2 py-1 text-xs rounded {{ $item->status === 'terlambat' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('petugas.pengembalian.verify', $item) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="aksi" value="setujui">
                                <button class="text-green-600">Setujui</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-2 text-center text-gray-500">Belum ada data pengembalian.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $pengembalian->links() }}</div>
    </div>
</x-layouts.dashboard>
