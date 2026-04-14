<x-layouts.dashboard title="Dashboard Peminjam">
    <div class="bg-white rounded shadow p-6 text-gray-700">
        Selamat datang, {{ auth()->user()->name }}.
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('peminjam.peminjaman.index') }}" class="inline-block bg-slate-900 text-white rounded px-4 py-2">Ajukan Peminjaman</a>
            <a href="{{ route('peminjam.pengembalian.index') }}" class="inline-block bg-blue-600 text-white rounded px-4 py-2">Ajukan Pengembalian</a>
        </div>
    </div>
</x-layouts.dashboard>
