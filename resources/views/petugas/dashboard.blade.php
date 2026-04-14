<x-layouts.dashboard title="Dashboard Petugas">
    <div class="bg-white rounded shadow p-6 text-gray-700">
        Selamat datang, {{ auth()->user()->name }}.
        Fokus utama petugas adalah memproses persetujuan peminjaman dan verifikasi pengembalian.
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('petugas.peminjaman.index') }}" class="inline-block bg-slate-900 text-white rounded px-4 py-2">Buka Persetujuan Peminjaman</a>
            <a href="{{ route('petugas.pengembalian.index') }}" class="inline-block bg-blue-600 text-white rounded px-4 py-2">Buka Verifikasi Pengembalian</a>
        </div>
    </div>
</x-layouts.dashboard>
