@extends('layouts.admin')

@section('content')
{{-- Letakkan di bawah .header-section --}}
@if(session('success'))
    <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
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
                <small style="color: #2c9a94;">{{ $order->whatsapp }}</small>
            </td>
            <td style="font-size: 14px; color: #475569;">{{ $order->address }}</td>
            <td style="font-weight: 700; color: #1e293b;">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                <br>
                {{-- TOMBOL LIHAT DETAIL BARANG --}}
                <small style="color: #64748b; font-weight: normal; cursor: pointer;" onclick="alert('Barang: {{ is_array($order->items) ? implode(', ', array_column($order->items, 'name')) : 'Cek Database' }}')">
                    🔍 Detail Barang
                </small>
            </td>
            <td>
                {{-- LIHAT BUKTI TRANSFER --}}
                {{-- Update bagian ini di file admin kamu --}}
                @if($order->payment_receipt)
                    <a href="{{ asset('receipts/' . $order->payment_receipt) }}" target="_blank" ...>
                        🖼️ Lihat Struk
                    </a>
                @endif
                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; font-size: 12px; font-weight: 600; cursor: pointer;
                        {{ $order->status == 'completed' ? 'background: #dcfce7; color: #166534;' : '' }}
                        {{ $order->status == 'waiting_verification' ? 'background: #e0f2fe; color: #075985;' : '' }}
                        {{ $order->status == 'pending' ? 'background: #fef3c7; color: #92400e;' : '' }}">
                        
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                        <option value="waiting_verification" {{ $order->status == 'waiting_verification' ? 'selected' : '' }}>VERIFIKASI</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                    </select>
                </form>
            </td>
            <td>
                <div style="display: flex; gap: 10px;">
                    <a href="https://wa.me/{{ $order->whatsapp }}?text=Halo%20{{ $order->name }},%20pesanan%20Anda%20sedang%20kami%20proses!" target="_blank" style="text-decoration: none;">🟢 WA</a>
                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
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