<x-layouts.dashboard title="Kelola Alat">
    <div class="bg-white rounded shadow p-4">
        <form method="GET" class="grid md:grid-cols-4 gap-2 mb-4">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama alat" class="border rounded px-3 py-2">
            <select name="kategori_id" class="border rounded px-3 py-2">
                <option value="">Semua kategori</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" @selected((string) request('kategori_id') === (string) $item->id)>{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
            <button class="bg-slate-900 text-white rounded px-3 py-2">Filter</button>
            <a href="{{ route('admin.alat.create') }}" class="bg-blue-600 text-center text-white rounded px-3 py-2">+
                Tambah Alat</a>
        </form>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b text-left">
                    <th class="py-2">Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alat as $item)
                    <tr class="border-b">
                        <td class="py-2">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_alat }}"
                                    class="h-12 w-12 object-cover rounded border">
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-2">{{ $item->nama_alat }}</td>
                        <td>{{ $item->kategori?->nama_kategori }}</td>
                        <td>{{ $item->stok }}</td>
                        <td class="py-2">
                            <span
                                class="px-2 py-1 rounded text-xs {{ $item->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.alat.edit', $item) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.alat.destroy', $item) }}" class="inline">@csrf
                                @method('DELETE')
                                <button class="text-red-600" onclick="return confirm('Hapus alat?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-2 text-center text-gray-500">Data kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $alat->links() }}</div>
    </div>
</x-layouts.dashboard>
