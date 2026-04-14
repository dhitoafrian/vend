<x-layouts.dashboard title="Daftar Alat">

    <div class="mb-4">
        <form method="GET">
            <input name="q" value="{{ request('q') }}"
                placeholder="Cari alat..."
                class="border rounded px-3 py-2 w-full md:w-80">
        </form>
    </div>

    <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-4">

        @forelse ($alat as $item)
            <div class="bg-white rounded shadow p-3 flex flex-col">

                <!-- FOTO -->
                <div class="h-40 mb-3">
                    <img src="{{ $item->foto
                        ? asset('storage/' . $item->foto)
                        : 'https://via.placeholder.com/150' }}"
                        class="w-full h-full object-cover rounded">
                </div>

                <!-- INFO -->
                <div class="flex-1">
                    <h3 class="font-semibold text-sm">{{ $item->nama_alat }}</h3>
                    <p class="text-xs text-gray-500">
                        {{ $item->kategori?->nama_kategori }}
                    </p>

                    <p class="text-xs mt-1">
                        Stok: <span class="font-medium">{{ $item->stok }}</span>
                    </p>

                    <!-- STATUS -->
                    <span class="inline-block mt-2 px-2 py-1 text-xs rounded
                        {{ $item->status === 'tersedia'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <!-- AKSI -->
                <div class="mt-3">
                    @if ($item->status === 'tersedia' && $item->stok > 0)
                        <a href="{{ route('peminjam.peminjaman.create', ['alat_id' => $item->id]) }}"
                           class="block text-center bg-blue-600 text-white text-sm rounded py-2">
                           Pinjam
                        </a>
                    @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 text-sm rounded py-2 cursor-not-allowed">
                            Tidak Tersedia
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <p class="text-gray-500">Belum ada data alat.</p>
        @endforelse

    </div>

    <div class="mt-6">
        {{ $alat->links() }}
    </div>

</x-layouts.dashboard>
