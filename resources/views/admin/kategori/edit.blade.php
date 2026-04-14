<x-layouts.dashboard title="Edit Kategori">
    <form method="POST" action="{{ route('admin.kategori.update', $kategori) }}" class="bg-white rounded shadow p-4 space-y-3">
        @csrf @method('PUT')
        <input name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" placeholder="Nama kategori" class="w-full border rounded px-3 py-2">
        <button class="bg-slate-900 text-white rounded px-4 py-2">Update</button>
    </form>
</x-layouts.dashboard>
