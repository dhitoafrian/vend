@php
    $role = auth()->user()->role;
    
    // Mapping Icon untuk tiap menu
    $icons = [
        'Dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
        'Petugas' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
        'Kategori' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>',
        'Alat' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-6 8a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zm12 0a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1z"></path></svg>',
        'Peminjaman' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>',
        'Persetujuan Peminjaman' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'Lihat Alat' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>',
        'default' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
    ];

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

<nav class="p-4 space-y-2">
    @foreach ($menus as $menu)
        @php
            $isActive = request()->routeIs(str_replace('.index', '.*', $menu['route']));
        @endphp
        <a href="{{ route($menu['route']) }}"
            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all duration-200 group
            {{ $isActive 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' 
                : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
            
            <span class="{{ $isActive ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}">
                {!! $icons[$menu['label']] ?? $icons['default'] !!}
            </span>
            
            <span>{{ $menu['label'] }}</span>
        </a>
    @endforeach
</nav>
