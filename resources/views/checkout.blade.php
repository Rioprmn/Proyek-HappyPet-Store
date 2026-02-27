@extends('layouts.app')

@section('content')
<div class="checkout-container">
    <div class="checkout-header">
        <h1>🛒 Checkout</h1>
        <p>Selesaikan pembelian Anda</p>
    </div>

    @if(isset($order))
        {{-- Order Summary --}}
        <div class="checkout-content">
            <div class="order-summary">
                <h2>📦 Ringkasan Pesanan</h2>
                
                <div class="order-details">
                    <div class="detail-row">
                        <span>Nama Pemesan:</span>
                        <strong>{{ $order->name }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Alamat Pengiriman:</span>
                        <strong>{{ $order->address }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>No. WhatsApp:</span>
                        <strong>{{ $order->whatsapp }}</strong>
                    </div>
                </div>

                <div class="items-list">
                    <h3>Produk yang Dipesan:</h3>
                    @foreach($order->items as $item)
                        <div class="item">
                            <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                            <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="total-section">
                    <div class="total-row">
                        <span>Total Pembayaran:</span>
                        <strong class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>

                {{-- Payment Methods --}}
                <div class="payment-section">
                    <h3>💳 Metode Pembayaran</h3>
                    <a href="{{ route('checkout.payment-method', $order->id) }}" class="btn-pay-method">
                        Pilih Metode Pembayaran
                    </a>
                </div>
            </div>
        </div>

        <style>
            .checkout-container {
                max-width: 800px;
                margin: 60px auto;
                padding: 0 20px;
            }

            .checkout-header {
                text-align: center;
                margin-bottom: 40px;
                animation: slideInDown 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .checkout-header h1 {
                font-size: 2rem;
                font-weight: 800;
                color: #1e293b;
                margin-bottom: 8px;
            }

            .checkout-header p {
                color: #64748b;
                font-size: 0.95rem;
            }

            .checkout-content {
                animation: fadeInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .order-summary {
                background: white;
                padding: 30px;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                border: 2px solid #e2e8f0;
            }

            .order-summary h2 {
                font-size: 1.3rem;
                color: #1e293b;
                margin-bottom: 20px;
                font-weight: 700;
            }

            .order-details {
                background: #f8fafc;
                padding: 20px;
                border-radius: 12px;
                margin-bottom: 25px;
            }

            .detail-row {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #e2e8f0;
            }

            .detail-row:last-child {
                border-bottom: none;
            }

            .detail-row span {
                color: #64748b;
                font-weight: 500;
            }

            .detail-row strong {
                color: #1e293b;
                font-weight: 700;
            }

            .items-list {
                margin-bottom: 25px;
            }

            .items-list h3 {
                font-size: 1.1rem;
                color: #1e293b;
                margin-bottom: 15px;
                font-weight: 700;
            }

            .item {
                display: flex;
                justify-content: space-between;
                padding: 12px;
                background: #f1f5f9;
                border-radius: 8px;
                margin-bottom: 10px;
                font-size: 0.95rem;
            }

            .item span:first-child {
                color: #1e293b;
                font-weight: 600;
            }

            .item span:last-child {
                color: #2c9a94;
                font-weight: 700;
            }

            .total-section {
                background: linear-gradient(135deg, #f8fafc 0%, #f0f4f8 100%);
                padding: 20px;
                border-radius: 12px;
                margin-bottom: 25px;
                border: 2px solid #e2e8f0;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .total-row span {
                font-size: 1.1rem;
                color: #1e293b;
                font-weight: 700;
            }

            .total-amount {
                font-size: 1.5rem;
                color: #2c9a94;
            }

            .payment-section {
                margin-bottom: 30px;
            }

            .payment-section h3 {
                font-size: 1.1rem;
                color: #1e293b;
                margin-bottom: 15px;
                font-weight: 700;
            }

            .btn-pay-method {
                display: inline-block;
                width: 100%;
                padding: 14px;
                background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-weight: 700;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                text-align: center;
                text-decoration: none;
                box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
            }

            .btn-pay-method:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
            }

            @keyframes slideInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 768px) {
                .checkout-header h1 {
                    font-size: 1.5rem;
                }

                .order-summary {
                    padding: 20px;
                }
            }
        </style>
    @else
        {{-- Cart Items Display --}}
        <div class="checkout-form">
            <h2>📋 Data Pengiriman</h2>
            <form action="{{ route('checkout.process') }}" method="POST" class="form">
                @csrf
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" placeholder="Masukkan alamat pengiriman" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label>No. WhatsApp</label>
                    <input type="tel" name="phone" placeholder="08xx xxxx xxxx" required>
                </div>

                <button type="submit" class="btn-checkout">Lanjut ke Pembayaran</button>
            </form>
        </div>

        <style>
            .checkout-form {
                background: white;
                padding: 30px;
                border-radius: 16px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                border: 2px solid #e2e8f0;
                max-width: 600px;
                margin: 0 auto;
            }

            .checkout-form h2 {
                font-size: 1.3rem;
                color: #1e293b;
                margin-bottom: 25px;
                font-weight: 700;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 8px;
            }

            .form-group input,
            .form-group textarea {
                width: 100%;
                padding: 12px;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.95rem;
                font-family: inherit;
                transition: all 0.3s ease;
                box-sizing: border-box;
            }

            .form-group input:focus,
            .form-group textarea:focus {
                outline: none;
                border-color: #2c9a94;
                box-shadow: 0 0 0 3px rgba(44, 154, 148, 0.1);
            }

            .btn-checkout {
                width: 100%;
                padding: 14px;
                background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
                color: white;
                border: none;
                border-radius: 10px;
                font-weight: 700;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
            }

            .btn-checkout:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
            }
        </style>
    @endif
</div>
@endsection
