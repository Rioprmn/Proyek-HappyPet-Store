@extends('layouts.app')

@section('content')
<div class="order-hero">
    <div class="order-hero-content">
        <h1 class="order-hero-title">🐾 Lacak Pesanan Anda</h1>
        <p class="order-hero-subtitle">Pantau status pesanan dan riwayat belanja Anda</p>
    </div>
    <div class="order-hero-pattern"></div>
</div>

<div class="order-container">
    <div class="order-search-section">
        <h2 class="section-title">Cari Pesanan</h2>
        <form action="{{ route('order.history') }}" method="GET" class="search-form">
            <input type="text" name="phone" value="{{ $phone }}" placeholder="Masukkan Nomor WhatsApp (0812...)" 
                   class="search-input" required>
            <button type="submit" class="search-button">Cari Pesanan</button>
        </form>
    </div>

    @if($phone)
        @forelse($orders as $order)
            <div class="order-card" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="order-header">
                    <div class="order-info">
                        <span class="order-id">#HP-{{ $order->id }}</span>
                        <h3 class="order-name">{{ $order->name }}</h3>
                        <p class="order-date">📅 {{ $order->created_at->format('d M Y') }} — ⏰ {{ $order->created_at->format('H:i') }}</p>
                    </div>
                    <div class="order-total">
                        <span class="total-label">Total Pembayaran</span>
                        <span class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="order-status">
                    <span class="status-badge {{ $order->status }}">
                        ● {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>

                <div class="order-items">
                    <p class="items-title">📦 Rincian Produk</p>
                    <div class="items-list">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                <span class="item-name">
                                    <strong class="item-qty">{{ $item['quantity'] }}x</strong> {{ $item['name'] }}
                                </span>
                                <span class="item-price">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($order->status == 'pending')
                    <div class="order-action">
                        <a href="{{ route('checkout.index', ['order_id' => $order->id]) }}" class="btn-upload">
                            ⚠️ Upload Bukti Pembayaran
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">🔎</div>
                <h2>Tidak Ada Pesanan</h2>
                <p>Tidak ditemukan pesanan untuk nomor WhatsApp ini.</p>
                <a href="{{ route('product.index') }}" class="btn-start-shopping">Mulai Belanja</a>
            </div>
        @endforelse
    @else
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <h2>Masukkan Nomor WhatsApp</h2>
            <p>Silakan masukkan nomor WhatsApp Anda untuk melihat riwayat pesanan</p>
        </div>
    @endif
</div>
@endsection
