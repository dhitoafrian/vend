<x-layouts.dashboard title="Kelola Petugas">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between gap-4 border-b border-slate-100">
            <form method="GET" class="w-full sm:max-w-xs relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input name="q" value="{{ request('q') }}" placeholder="Cari nama/email..." class="w-full border border-slate-300 rounded-xl pl-9 pr-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
            </form>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Petugas
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($users as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $item->email }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $item) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $item) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Hapus petugas ini?')" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">Data petugas kosong.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
