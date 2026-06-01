<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar | VEND</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind Config & Vite Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Centering wrapper that allows full scroll on overflow -->
    <div class="min-h-screen w-full flex flex-col items-center justify-center py-10 px-4 sm:px-6">
        
        <!-- Main Container -->
        <div class="w-full max-w-md">

            <!-- Header Brand -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    VEND
                </h1>
                <p class="text-xs text-slate-500 mt-1">Sistem Manajemen & Peminjaman Alat</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-6">
                    Daftar Akun Baru
                </h2>

                <!-- Auth Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 text-xs font-semibold space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name Input -->
                    <div class="space-y-1">
                        <label for="name" class="block text-xs font-semibold text-slate-500">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                            placeholder="Nama Anda">
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-1">
                        <label for="email" class="block text-xs font-semibold text-slate-500">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                            placeholder="nama@email.com">
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1">
                        <label for="password" class="block text-xs font-semibold text-slate-500">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                            placeholder="Minimal 8 karakter">
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-500">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                            placeholder="Ulangi password">
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <a class="text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors" href="{{ route('login') }}">
                            Sudah punya akun? Masuk
                        </a>
                        <button type="submit" 
                            class="bg-slate-900 hover:bg-blue-600 font-bold text-white text-sm rounded-xl px-6 py-2.5 transition-colors shadow-sm">
                            Daftar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <p class="text-center text-[10px] text-slate-400 mt-8">
                VEND &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
