<x-layouts.dashboard title="Dashboard Admin">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded shadow p-4"><p class="text-sm text-gray-500">User</p><p class="text-2xl font-bold">{{ $totalUser }}</p></div>
        <div class="bg-white rounded shadow p-4"><p class="text-sm text-gray-500">Kategori</p><p class="text-2xl font-bold">{{ $totalKategori }}</p></div>
        <div class="bg-white rounded shadow p-4"><p class="text-sm text-gray-500">Alat</p><p class="text-2xl font-bold">{{ $totalAlat }}</p></div>
        <div class="bg-white rounded shadow p-4"><p class="text-sm text-gray-500">Peminjaman</p><p class="text-2xl font-bold">{{ $totalPeminjaman }}</p></div>
        <div class="bg-white rounded shadow p-4"><p class="text-sm text-gray-500">Pengembalian</p><p class="text-2xl font-bold">{{ $totalPengembalian }}</p></div>
    </div>
</x-layouts.dashboard>
