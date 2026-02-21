@extends('layouts.admin')

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Pesanan Masuk</h1>
    <p style="color: #64748b;">Kelola transaksi pelanggan di sini.</p>
</div>

<div class="table-container" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b;">
                <th style="padding: 12px;">Pelanggan</th>
                <th>Alamat</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px;">
                        <span style="font-weight: 600; display: block;">{{ $order->name }}</span>
                        <small style="color: #2c9a94;">{{ $order->phone }}</small>
                    </td>
                    <td style="font-size: 14px; color: #475569;">{{ $order->address }}</td>
                    <td style="font-weight: 700; color: #1e293b;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span style="background: #fef3c7; color: #92400e; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="https://wa.me/{{ $order->phone }}" target="_blank" title="Hubungi via WA" style="text-decoration: none;">🟢 WA</a>
                            <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Hapus data pesanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none; border:none; cursor:pointer; color: #ef4444;">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada pesanan masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection