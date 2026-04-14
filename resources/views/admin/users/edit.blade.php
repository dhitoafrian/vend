<x-layouts.dashboard title="Edit Petugas">
    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded shadow p-4 space-y-3">
            @csrf @method('PUT')
            <input name="name" value="{{ old('name', $user->name) }}" placeholder="Nama" class="w-full border rounded px-3 py-2">
            <input name="email" type="email" value="{{ old('email', $user->email) }}" placeholder="Email" class="w-full border rounded px-3 py-2">
            <input name="password" type="password" placeholder="Password baru (opsional)" class="w-full border rounded px-3 py-2">
            <input name="password_confirmation" type="password" placeholder="Konfirmasi password baru" class="w-full border rounded px-3 py-2">
            <button class="bg-slate-900 text-white rounded px-4 py-2">Update</button>
        </form>
    </div>
</x-layouts.dashboard>
