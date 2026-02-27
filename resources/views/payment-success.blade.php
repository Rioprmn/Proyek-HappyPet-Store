@extends('layouts.app')

@section('content')
<div class="success-container">
    <div class="success-content">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <h1>Pembayaran Berhasil Diunggah!</h1>
        <p class="success-message">Bukti pembayaran Anda telah kami terima</p>

        <div class="order-details">
            <div class="detail-item">
                <span>Nomor Pesanan:</span>
                <strong>#{{ $order->id }}</strong>
            </div>
            <div class="detail-item">
                <span>Total Pembayaran:</span>
                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
            </div>
            <div class="detail-item">
                <span>Status:</span>
                <strong class="status-badge">Menunggu Verifikasi</strong>
            </div>
            <div class="detail-item">
                <span>Waktu Upload:</span>
                <strong>{{ now()->format('d M Y H:i') }}</strong>
            </div>
        </div>

        <div class="info-box">
            <h3>📋 Apa Selanjutnya?</h3>
            <ul class="info-list">
                <li>Admin kami akan memverifikasi bukti pembayaran Anda</li>
                <li>Proses verifikasi biasanya memakan waktu 1x24 jam</li>
                <li>Anda akan menerima notifikasi WhatsApp setelah verifikasi</li>
                <li>Pesanan akan segera diproses dan dikirim</li>
            </ul>
        </div>

        <div class="action-buttons">
            <a href="{{ route('order.history') }}" class="btn-primary">
                📦 Lihat Pesanan Saya
            </a>
            <a href="{{ route('product.index') }}" class="btn-secondary">
                🛍️ Lanjut Belanja
            </a>
        </div>

        <div class="contact-info">
            <p>Pertanyaan? Hubungi kami via WhatsApp: <strong>{{ $order->whatsapp }}</strong></p>
        </div>
    </div>
</div>

<style>
.success-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0fdf4 0%, #e8f5f3 100%);
    padding: 20px;
}

.success-content {
    background: white;
    border-radius: 16px;
    padding: 50px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    text-align: center;
    animation: slideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.success-icon {
    font-size: 4rem;
    color: #10b981;
    margin-bottom: 20px;
    animation: bounce 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.success-content h1 {
    font-size: 2rem;
    color: #1e293b;
    margin-bottom: 10px;
    font-weight: 800;
}

.success-message {
    color: #64748b;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.order-details {
    background: #f8fafc;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    border: 2px solid #e2e8f0;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item span {
    color: #64748b;
    font-weight: 500;
}

.detail-item strong {
    color: #1e293b;
    font-weight: 700;
}

.status-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white !important;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.info-box {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 2px solid #fcd34d;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    text-align: left;
}

.info-box h3 {
    color: #92400e;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    color: #78350f;
    padding: 8px 0;
    padding-left: 25px;
    position: relative;
    line-height: 1.6;
}

.info-list li:before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #d97706;
    font-weight: bold;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 30px;
}

.btn-primary, .btn-secondary {
    padding: 14px 24px;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
}

.btn-secondary {
    background: #f1f5f9;
    color: #2c9a94;
    border: 2px solid #2c9a94;
}

.btn-secondary:hover {
    background: #e2e8f0;
    transform: translateY(-3px);
}

.contact-info {
    color: #64748b;
    font-size: 0.95rem;
    padding-top: 20px;
    border-top: 2px solid #e2e8f0;
}

.contact-info strong {
    color: #2c9a94;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

@media (max-width: 768px) {
    .success-content {
        padding: 30px 20px;
    }

    .success-icon {
        font-size: 3rem;
    }

    .success-content h1 {
        font-size: 1.5rem;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>
@endsection
