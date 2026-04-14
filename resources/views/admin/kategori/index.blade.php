<x-layouts.dashboard title="Kelola Kategori">
    <div class="bg-white rounded shadow p-4">
        <div class="flex justify-between mb-4">
            <form method="GET"><input name="q" value="{{ request('q') }}" placeholder="Cari kategori" class="border rounded px-3 py-2"></form>
            <a href="{{ route('admin.kategori.create') }}" class="bg-blue-600 text-white rounded px-3 py-2">+ Tambah Kategori</a>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Nama Kategori</th><th class="text-right">Aksi</th></tr></thead>
            <tbody>
                @forelse ($kategori as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->nama_kategori }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.kategori.edit', $item) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.kategori.destroy', $item) }}" class="inline">@csrf @method('DELETE')
                                <button class="text-red-600" onclick="return confirm('Hapus kategori?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="py-2 text-center text-gray-500">Data kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $kategori->links() }}</div>
    </div>
</x-layouts.dashboard>
