<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan SIPAT</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h1, h2 { margin: 0 0 8px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <h1>Laporan SIPAT</h1>
    <p>Periode: {{ $tanggalMulai?->format('Y-m-d') ?? '-' }} s/d {{ $tanggalSelesai?->format('Y-m-d') ?? '-' }}</p>

    <h2>Data Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $item)
                <tr>
                    <td>{{ $item->user?->name }}</td>
                    <td>{{ $item->tanggal_pinjam?->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Data kosong.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Data Pengembalian</h2>
    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengembalian as $item)
                <tr>
                    <td>{{ $item->peminjaman?->user?->name }}</td>
                    <td>{{ $item->tanggal_kembali?->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->denda }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Data kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
