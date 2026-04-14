<x-layouts.dashboard title="Dashboard Petugas">

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="text-xl font-bold">{{ $totalPending }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Sedang Dipinjam</p>
            <p class="text-xl font-bold">{{ $totalDipinjam }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Selesai</p>
            <p class="text-xl font-bold">{{ $totalSelesai }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">

        <!-- Pending Peminjaman -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-3">Pengajuan Peminjaman</h2>
            @forelse ($pendingPeminjaman as $item)
                <div class="border-b py-2">
                    <p class="text-sm font-medium">{{ $item->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $item->created_at->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-400">Tidak ada pengajuan</p>
            @endforelse
        </div>

        <!-- Pending Pengembalian -->
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-3">Pengembalian</h2>
            @forelse ($pendingPengembalian as $item)
                <div class="border-b py-2">
                    <p class="text-sm font-medium">{{ $item->user->name }}</p>
                    <p class="text-xs text-gray-500">Menunggu verifikasi</p>
                </div>
            @empty
                <p class="text-sm text-gray-400">Tidak ada pengembalian</p>
            @endforelse
        </div>

    </div>

</x-layouts.dashboard>
