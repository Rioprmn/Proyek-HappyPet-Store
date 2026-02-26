@extends('layouts.app')

@section('content')
<div class="cart-hero">
    <div class="cart-hero-content">
        <h1 class="cart-hero-title">🛒 Keranjang Belanja</h1>
        <p class="cart-hero-subtitle">Periksa dan selesaikan pembelian Anda</p>
    </div>
    <div class="cart-hero-pattern"></div>
</div>

<div class="cart-container">
    @if(session('cart') && count(session('cart')) > 0)
        <div class="cart-content">
            <div class="cart-items-section">
                <h2 class="section-title">Produk Anda</h2>
                <div class="cart-items">
                    @php $total = 0; $itemCount = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php 
                            $subtotal = $details['price'] * $details['quantity'];
                            $total += $subtotal;
                            $itemCount++;
                        @endphp
                        <div class="cart-item" style="animation-delay: {{ $itemCount * 0.1 }}s">
                            <div class="item-image">
                                <img src="{{ asset('assets/img/products/' . ($details['image'] ?? 'default.png')) }}" alt="{{ $details['name'] }}">
                            </div>
                            <div class="item-details">
                                <h3>{{ $details['name'] }}</h3>
                                <p class="item-price">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="item-quantity">
                                <span class="qty-label">Jumlah:</span>
                                <span class="qty-value">{{ $details['quantity'] }}</span>
                            </div>
                            <div class="item-subtotal">
                                <span class="subtotal-label">Subtotal:</span>
                                <span class="subtotal-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST" class="item-remove">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn-remove" title="Hapus dari keranjang">
                                    <span>🗑️</span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="cart-summary">
                <div class="summary-card">
                    <h2 class="summary-title">Ringkasan Pesanan</h2>
                    
                    <div class="summary-row">
                        <span>Jumlah Item:</span>
                        <span class="summary-value">{{ $itemCount }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Ongkir:</span>
                        <span class="summary-value">Rp 0</span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button onclick="window.location.href='{{ route('checkout.index') }}'" class="btn-checkout">
                        Lanjut ke Pembayaran
                    </button>

                    <button onclick="window.location.href='{{ route('product.index') }}'" class="btn-continue-shopping">
                        Lanjut Belanja
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <div class="empty-icon">🛒</div>
            <h2>Keranjang Anda Kosong</h2>
            <p>Belum ada produk di keranjang. Yuk mulai belanja sekarang!</p>
            <a href="{{ route('product.index') }}" class="btn-start-shopping">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
