<x-layouts.dashboard title="Daftar Alat">
    <div class="bg-white rounded shadow p-4">
        <form method="GET" class="mb-4">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama alat" class="border rounded px-3 py-2 w-full md:w-80">
        </form>

        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left">
                    <th class="py-2">Foto</th>
                    <th class="py-2">Nama Alat</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alat as $item)
                    <tr class="border-b">
                        <td class="py-2">
                            @if ($item->img)
                                <img src="{{ asset('storage/'.$item->img) }}" alt="{{ $item->nama_alat }}" class="h-12 w-12 object-cover rounded border">
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $item->nama_alat }}</td>
                        <td>{{ $item->kategori?->nama_kategori }}</td>
                        <td>{{ $item->stok }}</td>
                        <td class="text-right">
                            <a href="{{ route('peminjam.peminjaman.create', ['alat_id' => $item->id]) }}" class="text-blue-600">Pinjam Alat</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-2 text-center text-gray-500">Belum ada data alat.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $alat->links() }}</div>
    </div>
</x-layouts.dashboard>
