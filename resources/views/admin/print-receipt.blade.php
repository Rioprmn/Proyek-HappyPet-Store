<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk_HappyPet_{{ $order->id }}</title>
    <style>
        /* Pengaturan Kertas Otomatis */
        @page {
            margin: 0;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 100%; /* Menyesuaikan lebar printer */
            max-width: 400px; /* Batas maksimal agar tidak terlalu lebar di layar PC */
            margin: 0 auto;
            padding: 10px;
            color: #000;
            font-size: 13px;
            line-height: 1.4;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        .header { margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; font-size: 11px; }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .info-table, .item-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td { font-size: 11px; padding: 1px 0; }

        .item-table th { border-bottom: 1px dashed #000; padding: 5px 0; text-align: left; }
        .item-table td { padding: 5px 0; vertical-align: top; }

        .total-section {
            margin-top: 10px;
            width: 100%;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
        }

        /* Sembunyikan tombol saat cetak */
        @media print {
            .no-print { display: none; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header text-center">
        <h2>HAPPYPET STORE</h2>
        <p>Jl. Pet Shop No. 88, Bandung</p>
        <p>WA: 0812-XXXX-XXXX</p>
    </div>

    <div class="divider"></div>

    <table class="info-table">
        <tr>
            <td>No. Order</td>
            <td>: #HP-{{ $order->id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $order->created_at->format('d/m/y H:i') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>: {{ $order->name }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="item-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item['name'] }} <br>
                    <small>{{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', '.') }}</small>
                </td>
                <td class="text-right">
                    {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="total-section">
        <tr>
            <td class="bold">TOTAL TAGIHAN</td>
            <td class="text-right bold" style="font-size: 16px;">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        <p class="bold">TERIMA KASIH</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
        <p>🐾 Happy Pet, Happy Life! 🐾</p>
    </div>

    <div class="no-print" style="margin-top: 30px; display: flex; gap: 10px;">
        <button onclick="window.print()" style="flex: 1; padding: 10px; background: #2c9a94; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="flex: 1; padding: 10px; background: #64748b; color: white; border: none; border-radius: 5px; cursor: pointer;">Tutup</button>
    </div>

</body>
</html>