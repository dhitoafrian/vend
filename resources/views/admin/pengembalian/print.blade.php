<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Pengembalian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h1 { margin: 0 0 12px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">
    <h1>Data Pengembalian</h1>
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
                    <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Data kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
