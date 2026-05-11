<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VEND') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: window.innerWidth > 768 }">
    <div class="min-h-screen flex relative">
        
        <!-- Overlay Mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition opacity-ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity-ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-slate-100 z-50 transform transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">
            
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-800 flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="font-black text-2xl tracking-tighter text-white uppercase italic">VEND</p>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mt-1 truncate">
                        {{ auth()->user()->role }} Area
                    </p>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden p-2 -mr-2 text-slate-400 hover:text-white transition-colors bg-slate-800 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1 overflow-y-auto py-4">
                @include('layouts.partials.sidebar-menu')
            </div>

            <!-- Sidebar Footer -->
            <div class="p-6 border-t border-slate-800 bg-slate-950/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-900/20">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-200 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out" :class="sidebarOpen ? 'md:ml-72' : 'md:ml-0'">
            
            <!-- Navbar / Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-4 md:px-8 py-4 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <!-- Hamburger / Toggle Button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-200 flex items-center gap-2 group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest md:hidden">Menu</span>
                    </button>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight truncate">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-bold text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition-all group">
                            <span class="hidden sm:inline text-rose-600">Logout</span>
                            <div class="p-1 rounded-lg bg-slate-100 group-hover:bg-rose-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </div>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="p-4 md:p-8 flex-1">
                @if (session('success'))
                    <div class="mb-8 flex items-center gap-4 rounded-[1.5rem] bg-emerald-50 text-emerald-800 border border-emerald-100 p-5 shadow-sm animate-in fade-in slide-in-from-top-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 flex items-center gap-4 rounded-[1.5rem] bg-rose-50 text-rose-800 border border-rose-100 p-5 shadow-sm animate-in fade-in slide-in-from-top-4">
                        <div class="w-10 h-10 rounded-xl bg-rose-500 flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
