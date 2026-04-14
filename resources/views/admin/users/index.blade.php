<x-layouts.dashboard title="Kelola Petugas">
    <div class="max-w-5xl mx-auto">
    <div class="bg-white rounded shadow p-4">
        <form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
            <input name="q" value="{{ request('q') }}" placeholder="Cari nama/email" class="border rounded px-3 py-2 w-full md:w-72">
            <button class="bg-slate-900 text-white rounded px-4 py-2">Filter</button>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white rounded px-4 py-2">+ Tambah Petugas</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-left border-b"><th class="py-2">Nama</th><th>Email</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse ($users as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="text-right space-x-2">
                            <a href="{{ route('admin.users.edit', $item) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $item) }}" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus user ini?')" class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-3 text-center text-gray-500">Data petugas kosong.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
    </div>
</x-layouts.dashboard>
