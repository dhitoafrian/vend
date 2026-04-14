<x-layouts.dashboard title="Kelola Pengembalian">
    <div class="bg-white rounded shadow p-4">
        <div class="mb-4">
            <form method="GET" class="flex items-center gap-2">
                <select name="status" class="border rounded px-3 py-2">
                    <option value="">Semua status</option>
                    @foreach (['tepat', 'terlambat'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="bg-slate-900 text-white rounded px-3 py-2">Filter</button>
                <a target="_blank" href="{{ route('admin.pengembalian.print', request()->query()) }}" class="bg-blue-600 text-white rounded px-3 py-2">Cetak</a>
            </form>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Peminjam</th><th>Tanggal Kembali</th><th>Denda</th><th>Status</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>
                @forelse ($pengembalian as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->peminjaman?->user?->name }}</td>
                        <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                        <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td>
                            <span class="inline-block px-2 py-1 text-xs rounded {{ $item->status === 'terlambat' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.pengembalian.edit', $item) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.pengembalian.destroy', $item) }}" class="inline ml-2" onsubmit="return confirm('Hapus data pengembalian ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-2 text-center text-gray-500">Data kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $pengembalian->links() }}</div>
    </div>
</x-layouts.dashboard>
