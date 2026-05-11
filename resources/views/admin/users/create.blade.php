<x-layouts.dashboard title="Tambah Petugas">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                <input name="name" value="{{ old('name') }}" placeholder="Masukkan nama petugas" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan email" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('email')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <input name="password" type="password" placeholder="Masukkan password" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                @error('password')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                <input name="password_confirmation" type="password" placeholder="Ulangi password" class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 transition-colors">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm px-4 py-2.5 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
