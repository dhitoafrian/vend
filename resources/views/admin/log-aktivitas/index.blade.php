<x-layouts.dashboard title="Log Aktivitas">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100">
            <form method="GET" class="w-full sm:max-w-xs relative">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input name="q" value="{{ request('q') }}" placeholder="Cari aktivitas..." class="w-full border border-slate-300 rounded-xl pl-9 pr-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Waktu</th>
                        <th class="px-6 py-3 font-semibold">User</th>
                        <th class="px-6 py-3 font-semibold">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $log->user?->name }}</td>
                            <td class="px-6 py-4">{{ $log->aktivitas }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">Belum ada log aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
