<x-layouts.dashboard title="Tambah Pengembalian">
    <form method="POST" action="{{ route('admin.pengembalian.store') }}" class="bg-white rounded shadow p-4 space-y-3">
        @csrf
        <select name="peminjaman_id" class="w-full border rounded px-3 py-2">
            @foreach ($peminjaman as $item)
                <option value="{{ $item->id }}" @selected((string) old('peminjaman_id') === (string) $item->id)>
                    {{ $item->user?->name }} - {{ $item->tanggal_pinjam?->format('Y-m-d') }}
                </option>
            @endforeach
        </select>
        <input name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali') }}" class="w-full border rounded px-3 py-2">
        <input name="denda" type="number" min="0" value="{{ old('denda', 0) }}" class="w-full border rounded px-3 py-2">
        <select name="status" class="w-full border rounded px-3 py-2">
            @foreach (['tepat', 'terlambat'] as $status)
                <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="bg-slate-900 text-white rounded px-4 py-2">Simpan</button>
    </form>
</x-layouts.dashboard>
