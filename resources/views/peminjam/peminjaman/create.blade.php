<x-layouts.dashboard title="Form Peminjaman Alat">
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('peminjam.peminjaman.store') }}" class="bg-white rounded shadow p-4 space-y-3">
            @csrf
            <select name="alat_id" class="w-full border rounded px-3 py-2">
                @foreach ($alat as $item)
                    <option value="{{ $item->id }}" @selected((string) old('alat_id', request('alat_id')) === (string) $item->id)>{{ $item->nama_alat }} (stok: {{ $item->stok }})</option>
                @endforeach
            </select>
            <input name="jumlah" type="number" min="1" value="{{ old('jumlah', 1) }}" class="w-full border rounded px-3 py-2" placeholder="Jumlah pinjam">
            <input name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam') }}" class="w-full border rounded px-3 py-2">
            <input name="tanggal_kembali_rencana" type="date" value="{{ old('tanggal_kembali_rencana') }}" class="w-full border rounded px-3 py-2">
            <div class="flex gap-2">
                <button class="bg-slate-900 text-white rounded px-4 py-2">Ajukan Peminjaman</button>
                <a href="{{ route('peminjam.alat.index') }}" class="bg-gray-200 rounded px-4 py-2">Kembali ke daftar alat</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
