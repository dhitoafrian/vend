<x-layouts.dashboard title="Edit Pengembalian">
    <form method="POST" action="{{ route('admin.pengembalian.update', $pengembalian) }}" class="bg-white rounded shadow p-4 space-y-3">
        @csrf @method('PUT')
        <div class="text-sm text-gray-600">
            Peminjam: <span class="font-medium">{{ $pengembalian->peminjaman?->user?->name ?? '-' }}</span>
        </div>
        <input name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali', $pengembalian->tanggal_kembali?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2">
        <input name="denda" type="number" min="0" value="{{ old('denda', $pengembalian->denda) }}" class="w-full border rounded px-3 py-2">
        <select name="status" class="w-full border rounded px-3 py-2">
            @foreach (['tepat', 'terlambat'] as $status)
                <option value="{{ $status }}" @selected(old('status', $pengembalian->status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="bg-slate-900 text-white rounded px-4 py-2">Update</button>
    </form>
</x-layouts.dashboard>
