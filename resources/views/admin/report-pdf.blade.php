<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan HappyPet</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #2c9a94; color: white; }
        .total-box { background: #f8fafc; padding: 15px; border: 1px solid #2c9a94; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
    <h2>LAPORAN PENJUALAN HAPPYPET</h2>
    <p>Periode: {{ $title }}</p>
    </div>

    <div class="total-box">
        <strong>Ringkasan Bulan Ini:</strong><br>
        Total Pesanan Selesai: {{ $totalOrders }} Pesanan<br>
        Total Omzet: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#HP-{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ $order->name }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 50px;">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
        <br><br>
        <p>___________________</p>
        <p>Admin HappyPet</p>
    </div>
</body>
</html>