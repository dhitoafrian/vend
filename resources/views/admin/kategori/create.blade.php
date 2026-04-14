<x-layouts.dashboard title="Tambah Kategori">
    <form method="POST" action="{{ route('admin.kategori.store') }}" class="bg-white rounded shadow p-4 space-y-3">
        @csrf
        <input name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Nama kategori" class="w-full border rounded px-3 py-2">
        <button class="bg-slate-900 text-white rounded px-4 py-2">Simpan</button>
    </form>
</x-layouts.dashboard>
