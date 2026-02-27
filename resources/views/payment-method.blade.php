@extends('layouts.app')

@section('content')
<div class="payment-container">
    <div class="payment-header">
        <h1>💳 Pilih Metode Pembayaran</h1>
        <p>Pesanan #{{ $order->id }} - Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>

    <div class="payment-methods">
        <div class="payment-card">
            <div class="payment-icon">
                <i class="fas fa-university"></i>
            </div>
            <h3>Transfer Bank</h3>
            <p>Transfer langsung ke rekening toko</p>
            <ul class="payment-features">
                <li>✓ Aman dan terpercaya</li>
                <li>✓ Proses cepat</li>
                <li>✓ Tanpa biaya tambahan</li>
            </ul>
            <form action="{{ route('checkout.select-transfer', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-payment">Pilih Metode Ini</button>
            </form>
        </div>
    </div>

    <div class="order-summary">
        <h3>📦 Ringkasan Pesanan</h3>
        <div class="items-list">
            @foreach($order->items as $item)
                <div class="item-row">
                    <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                    <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        <div class="total-row">
            <span>Total:</span>
            <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
        </div>
    </div>
</div>

<style>
.payment-container {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 20px;
}

.payment-header {
    text-align: center;
    margin-bottom: 40px;
}

.payment-header h1 {
    font-size: 2rem;
    color: #2c9a94;
    margin-bottom: 10px;
}

.payment-header p {
    color: #666;
    font-size: 1.1rem;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.payment-card {
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
}

.payment-card:hover {
    border-color: #2c9a94;
    box-shadow: 0 8px 24px rgba(44, 154, 148, 0.15);
    transform: translateY(-5px);
}

.payment-icon {
    font-size: 3rem;
    color: #2c9a94;
    margin-bottom: 15px;
}

.payment-card h3 {
    font-size: 1.3rem;
    color: #333;
    margin-bottom: 10px;
}

.payment-card p {
    color: #999;
    margin-bottom: 20px;
}

.payment-features {
    list-style: none;
    padding: 0;
    margin-bottom: 20px;
    text-align: left;
}

.payment-features li {
    color: #666;
    padding: 8px 0;
    font-size: 0.95rem;
}

.btn-payment {
    width: 100%;
    background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
}

.btn-payment:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
}

.order-summary {
    background: white;
    border-radius: 12px;
    padding: 30px;
    border: 2px solid #e0e0e0;
}

.order-summary h3 {
    color: #2c9a94;
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.items-list {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
    color: #333;
}

.item-row:last-child {
    border-bottom: none;
}

.item-row span:last-child {
    color: #2c9a94;
    font-weight: 700;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-top: 2px solid #e0e0e0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
}

.total-row strong {
    color: #2c9a94;
}

@media (max-width: 768px) {
    .payment-header h1 {
        font-size: 1.5rem;
    }

    .payment-methods {
        grid-template-columns: 1fr;
    }

    .order-summary {
        padding: 20px;
    }
}
</style>
@endsection
