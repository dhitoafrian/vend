<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | VEND</title>

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
        <div class="w-full max-w-4xl">

            <!-- Header Brand -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    VEND
                </h1>
                <p class="text-xs text-slate-500 mt-1">Sistem Manajemen & Peminjaman Alat</p>
            </div>

            <!-- 2-Card Layout Split: Left Login, Right Account -->
            <div class="flex flex-col md:flex-row gap-6 items-start">
                
                <!-- Left Card: Standard Login Form -->
                <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm w-full">
                    <h2 class="text-lg font-bold text-slate-900 mb-6">
                        Masuk ke Akun
                    </h2>

                    <!-- Session Status Alert -->
                    @if (session('status'))
                        <div class="mb-4 p-4 rounded-xl bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Auth Errors -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 border border-rose-100 text-xs font-semibold space-y-1">
                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Email Input -->
                        <div class="space-y-1">
                            <label for="email" class="block text-xs font-semibold text-slate-500">Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                                placeholder="nama@email.com">
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-semibold text-slate-500">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full bg-white border border-slate-300 focus:border-slate-500 focus:ring-1 focus:ring-slate-500 text-slate-800 rounded-xl px-4 py-2.5 transition-all outline-none placeholder-slate-400 text-sm" 
                                placeholder="Sandi Anda">
                        </div>

                        <!-- Remember Me & Register Link -->
                        <div class="flex items-center justify-between pt-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-white text-slate-800 focus:ring-0 focus:ring-offset-0 transition-colors">
                                <span class="ms-2 text-xs text-slate-500 font-medium">Ingat saya</span>
                            </label>
                            @if (Route::has('register'))
                                <a class="text-xs font-semibold text-slate-600 hover:text-blue-600 transition-colors" href="{{ route('register') }}">
                                    Daftar akun baru
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="btn-login" 
                            class="w-full bg-slate-900 hover:bg-blue-600 font-bold text-white text-sm rounded-xl py-3 transition-colors shadow-sm">
                            Masuk
                        </button>
                    </form>
                </div>

                <!-- Right Card: Demo Accounts / Quick Access -->
                <div class="flex-1 bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col shadow-sm w-full">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-2">
                            Akun Demo
                        </h2>
                        <p class="text-xs text-slate-500 leading-relaxed mb-6">
                            Gunakan akun simulasi di bawah untuk mengisi formulir login secara otomatis.
                        </p>

                        <!-- Vertical Account Buttons -->
                        <div class="space-y-4">
                            
                            <!-- Admin Selection -->
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Administrator</h4>
                                    <p class="text-[10px] text-slate-500 mt-1">Email: admin@vend.test</p>
                                    <p class="text-[10px] text-slate-500">Password: password</p>
                                </div>
                                <button type="button" onclick="quickFill('admin@vend.test', 'password')" 
                                    class="bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg px-3 py-1.5 transition-colors shadow-sm w-full sm:w-auto text-center">
                                    Pilih
                                </button>
                            </div>

                            <!-- Petugas Selection -->
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Petugas / Verifikator</h4>
                                    <p class="text-[10px] text-slate-500 mt-1">Email: petugas@vend.test</p>
                                    <p class="text-[10px] text-slate-500">Password: password</p>
                                </div>
                                <button type="button" onclick="quickFill('petugas@vend.test', 'password')" 
                                    class="bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg px-3 py-1.5 transition-colors shadow-sm w-full sm:w-auto text-center">
                                    Pilih
                                </button>
                            </div>

                            <!-- Peminjam Selection -->
                            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Peminjam / Anggota</h4>
                                    <p class="text-[10px] text-slate-500 mt-1">Email: budi111@gmail.com</p>
                                    <p class="text-[10px] text-slate-500">Password: password</p>
                                </div>
                                <button type="button" onclick="quickFill('budi111@gmail.com', 'password')" 
                                    class="bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg px-3 py-1.5 transition-colors shadow-sm w-full sm:w-auto text-center">
                                    Pilih
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 text-[10px] text-slate-400 font-medium">
                        * Klik "Pilih" untuk mengisi field email dan password otomatis.
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <p class="text-center text-[10px] text-slate-400 mt-8">
                VEND &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

    <!-- Quick Fill Script (No Chimes, No Auto-Submit) -->
    <script>
        function quickFill(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (!emailInput || !passwordInput) return;

            // Instantly fill values, standard behavior
            emailInput.value = email;
            passwordInput.value = password;
        }
    </script>
</body>
</html>
