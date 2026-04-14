<x-layouts.dashboard title="Tambah Petugas">
    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white rounded shadow p-4 space-y-3">
            @csrf
            <input name="name" value="{{ old('name') }}" placeholder="Nama" class="w-full border rounded px-3 py-2">
            <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded px-3 py-2">
            <input name="password" type="password" placeholder="Password" class="w-full border rounded px-3 py-2">
            <input name="password_confirmation" type="password" placeholder="Konfirmasi password" class="w-full border rounded px-3 py-2">
            <button class="bg-slate-900 text-white rounded px-4 py-2">Simpan</button>
        </form>
    </div>
</x-layouts.dashboard>
