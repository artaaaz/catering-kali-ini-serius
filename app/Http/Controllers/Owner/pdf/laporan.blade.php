<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemesanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; }
        h2 { color: #111827; }
    </style>
</head>
<body>
    <h2>Laporan Pemesanan Catering</h2>
    <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanans as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nama_pelanggan }}</td>
                <td>{{ date('d/m/Y', strtotime($p->created_at)) }}</td>
                <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                <td>{{ $p->status_pesan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

