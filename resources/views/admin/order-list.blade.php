@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-order.css') }}">
@endpush

@section('content')
<div class="order-header">
    <div class="header-content">
        <div>
            <h1 class="order-title">🛒 Pesanan Masuk</h1>
            <p class="order-subtitle">Kelola transaksi pelanggan di sini</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">📋 Daftar Pesanan</h3>
        <span class="order-count">{{ $orders->count() }} pesanan</span>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Waktu</th>
                    <th>Alamat</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="order-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <td>
                            <div class="customer-info">
                                <span class="customer-name">{{ $order->name }}</span>
                                <span class="customer-phone">{{ $order->whatsapp }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="order-time">
                                <div class="time-value">{{ $order->created_at->format('H:i') }}</div>
                                <div class="time-date">{{ $order->created_at->format('d/m/Y') }}</div>
                            </div>
                        </td>
                        
                        <td>
                            <span class="order-address">{{ $order->address }}</span>
                        </td>
                        
                        <td>
                            <div class="order-price">
                                <span class="price-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                <a href="{{ route('admin.order.print', $order->id) }}" target="_blank" class="btn-print">
                                    🖨️ Cetak
                                </a>
                            </div>
                        </td>

                        <td>
                            <div class="status-section">
                                @if($order->payment_receipt)
                                    <a href="{{ asset('receipts/' . $order->payment_receipt) }}" target="_blank" class="btn-receipt">
                                        🖼️ Bukti TF
                                    </a>
                                @endif
                                
                                @if($order->status === 'waiting_verification')
                                    <form action="{{ route('admin.order.verify', $order->id) }}" method="POST" class="verify-form">
                                        @csrf
                                        <button type="submit" class="btn-verify">✅ Verifikasi</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" class="status-form">
                                        @csrf @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="status-select {{ $order->status }}">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                            <option value="waiting_payment" {{ $order->status == 'waiting_payment' ? 'selected' : '' }}>MENUNGGU TRANSFER</option>
                                            <option value="waiting_verification" {{ $order->status == 'waiting_verification' ? 'selected' : '' }}>VERIFIKASI</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </td>

                        <td class="action-cell">
                            <div class="action-buttons">
                                <a href="https://wa.me/{{ $order->whatsapp }}?text=Halo%20{{ $order->name }},%20pesanan%20Anda%20sedang%20kami%20proses!" 
                                   target="_blank" 
                                   class="btn-action btn-whatsapp"
                                   title="Hubungi via WhatsApp">
                                    💬
                                </a>
                                <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">📦</div>
                                <h3>Belum ada pesanan</h3>
                                <p>Pesanan pelanggan akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.btn-verify {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-verify:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.verify-form {
    display: inline;
}
</style>
@endsection
