<x-layouts.dashboard title="Tambah Peminjaman">
    <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="bg-white rounded shadow p-4 space-y-3">
        @csrf
        <select name="user_id" class="w-full border rounded px-3 py-2">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected((string) old('user_id') === (string) $user->id)>{{ $user->name }} - {{ $user->email }}</option>
            @endforeach
        </select>
        <select name="alat_id" class="w-full border rounded px-3 py-2">
            @foreach ($alat as $item)
                <option value="{{ $item->id }}" @selected((string) old('alat_id') === (string) $item->id)>{{ $item->nama_alat }}</option>
            @endforeach
        </select>
        <input name="jumlah" type="number" min="1" value="{{ old('jumlah', 1) }}" class="w-full border rounded px-3 py-2" placeholder="Jumlah">
        <input name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam') }}" class="w-full border rounded px-3 py-2">
        <input name="tanggal_kembali_rencana" type="date" value="{{ old('tanggal_kembali_rencana') }}" class="w-full border rounded px-3 py-2">
        <select name="status" class="w-full border rounded px-3 py-2">
            @foreach (['pending', 'disetujui', 'tunda_pengembalian', 'ditolak', 'selesai'] as $status)
                <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="bg-slate-900 text-white rounded px-4 py-2">Simpan</button>
    </form>
</x-layouts.dashboard>
