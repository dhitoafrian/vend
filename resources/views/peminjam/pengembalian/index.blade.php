<x-layouts.dashboard title="Ajukan Pengembalian">
    <div class="grid lg:grid-cols-2 gap-4">
        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Form Pengembalian</h2>
            <form method="POST" action="{{ route('peminjam.pengembalian.store') }}" class="space-y-3">
                @csrf
                <select name="peminjaman_id" class="w-full border rounded px-3 py-2">
                    @forelse ($myApprovedLoans as $loan)
                        @php($detail = $loan->detailPeminjaman->first())
                        <option value="{{ $loan->id }}">{{ $detail?->alat?->nama_alat }} - pinjam {{ $loan->tanggal_pinjam?->format('Y-m-d') }}</option>
                    @empty
                        <option value="">Tidak ada peminjaman yang bisa dikembalikan</option>
                    @endforelse
                </select>
                <input name="tanggal_kembali" type="date" value="{{ old('tanggal_kembali') }}" class="w-full border rounded px-3 py-2">
                <button class="bg-slate-900 text-white rounded px-4 py-2" @disabled($myApprovedLoans->isEmpty())>Ajukan Pengembalian</button>
            </form>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h2 class="font-semibold mb-3">Riwayat Pengembalian Saya</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b text-left"><th class="py-2">Tanggal Kembali</th><th>Status</th><th>Denda</th></tr></thead>
                    <tbody>
                        @forelse ($myPengembalian as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                                <td>{{ ucfirst($item->status) }}</td>
                                <td>{{ $item->denda }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-center text-gray-500">Belum ada pengembalian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $myPengembalian->links() }}</div>
        </div>
    </div>
</x-layouts.dashboard>
