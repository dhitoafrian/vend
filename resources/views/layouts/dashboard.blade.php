<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'VEND') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen md:flex">
        <aside class="w-full md:w-64 bg-slate-900 text-slate-100">
            <div class="p-4 border-b border-slate-800">
                <p class="font-semibold text-lg">VEND</p>
                <p class="text-xs text-slate-300">{{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
            </div>
            @include('layouts.partials.sidebar-menu')
        </aside>

        <div class="flex-1">
            <header class="bg-white border-b px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-slate-800">{{ $title ?? 'Dashboard' }}</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
                </form>
            </header>

            <main class="p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-2 text-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-md bg-red-100 text-red-800 px-4 py-2 text-sm">{{ session('error') }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
