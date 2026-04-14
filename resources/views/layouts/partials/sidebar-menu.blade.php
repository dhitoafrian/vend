@php
    $role = auth()->user()->role;
    $menus = match ($role) {
        'admin' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Petugas', 'route' => 'admin.users.index'],
            ['label' => 'Kategori', 'route' => 'admin.kategori.index'],
            ['label' => 'Alat', 'route' => 'admin.alat.index'],
            ['label' => 'Peminjaman', 'route' => 'admin.peminjaman.index'],
            ['label' => 'Pengembalian', 'route' => 'admin.pengembalian.index'],
            ['label' => 'Log Aktivitas', 'route' => 'admin.log-aktivitas.index'],
        ],
        'petugas' => [
            ['label' => 'Dashboard', 'route' => 'petugas.dashboard'],
            ['label' => 'Persetujuan Peminjaman', 'route' => 'petugas.peminjaman.index'],
            ['label' => 'Verifikasi Pengembalian', 'route' => 'petugas.pengembalian.index'],
            ['label' => 'Laporan', 'route' => 'petugas.laporan.index'],
        ],
        default => [
            ['label' => 'Dashboard', 'route' => 'peminjam.dashboard'],
            ['label' => 'Lihat Alat', 'route' => 'peminjam.alat.index'],
            ['label' => 'Peminjaman Saya', 'route' => 'peminjam.peminjaman.index'],
            ['label' => 'Ajukan Pengembalian', 'route' => 'peminjam.pengembalian.index'],
        ],
    };
@endphp

<nav class="p-3 space-y-1">
    @foreach ($menus as $menu)
        <a href="{{ route($menu['route']) }}"
            class="block rounded px-3 py-2 text-sm {{ request()->routeIs(str_replace('.index', '.*', $menu['route'])) ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-800' }}">
            {{ $menu['label'] }}
        </a>
    @endforeach
</nav>
