<x-layouts.dashboard title="Log Aktivitas">
    <div class="bg-white rounded shadow p-4">
        <form method="GET" class="mb-4">
            <input name="q" value="{{ request('q') }}" placeholder="Cari aktivitas" class="border rounded px-3 py-2 w-full md:w-80">
        </form>
        <table class="w-full text-sm">
            <thead><tr class="border-b text-left"><th class="py-2">Waktu</th><th>User</th><th>Aktivitas</th></tr></thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b">
                        <td class="py-2">{{ $log->created_at?->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user?->name }}</td>
                        <td>{{ $log->aktivitas }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-2 text-center text-gray-500">Belum ada log aktivitas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-layouts.dashboard>
