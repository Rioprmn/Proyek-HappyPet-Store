@extends('layouts.app')

@section('content')
<div class="transfer-container">
    <div class="transfer-header">
        <h1>💳 Informasi Transfer Bank</h1>
        <p>Pesanan #{{ $order->id }}</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="transfer-content">
        <div class="order-card">
            <h2>📦 Ringkasan Pesanan</h2>
            <div class="order-info">
                <div class="info-row">
                    <span>Nama:</span>
                    <strong>{{ $order->name }}</strong>
                </div>
                <div class="info-row">
                    <span>Total Bayar:</span>
                    <strong class="amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        <div class="bank-card">
            <h2>🏦 Rekening Toko</h2>
            <p class="bank-note">Silakan transfer ke salah satu rekening di bawah ini:</p>
            
            <div class="bank-list">
                <div class="bank-item">
                    <div class="bank-header">
                        <span class="bank-name">Bank BCA</span>
                        <button type="button" class="btn-copy" onclick="copyToClipboard('1234567890')">📋 Salin</button>
                    </div>
                    <div class="bank-details">
                        <p><strong>No. Rekening:</strong> 1234567890</p>
                        <p><strong>Atas Nama:</strong> Happy Pet Store</p>
                    </div>
                </div>

                <div class="bank-item">
                    <div class="bank-header">
                        <span class="bank-name">Bank Mandiri</span>
                        <button type="button" class="btn-copy" onclick="copyToClipboard('0987654321')">📋 Salin</button>
                    </div>
                    <div class="bank-details">
                        <p><strong>No. Rekening:</strong> 0987654321</p>
                        <p><strong>Atas Nama:</strong> Happy Pet Store</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="upload-card">
            <h2>📸 Upload Bukti Pembayaran</h2>
            <p class="upload-note">Setelah melakukan transfer, silakan upload bukti pembayaran Anda</p>
            
            <form action="{{ route('checkout.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
                @csrf
                
                <div class="form-group">
                    <label>Pilih Gambar Bukti Transfer</label>
                    <div class="file-upload-area">
                        <input type="file" name="receipt" id="receipt" accept="image/*" required>
                        <label for="receipt" class="file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Klik atau drag gambar di sini</span>
                            <small>Format: JPEG, PNG, JPG | Max: 2MB</small>
                        </label>
                    </div>
                    @error('receipt')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">✅ Upload Bukti Pembayaran</button>
            </form>
        </div>

        <div class="instructions-card">
            <h2>📋 Petunjuk Pembayaran</h2>
            <ol class="instructions-list">
                <li>Salin nomor rekening toko di atas</li>
                <li>Buka aplikasi mobile banking Anda</li>
                <li>Pilih menu "Transfer" atau "Kirim Uang"</li>
                <li>Masukkan nomor rekening dan jumlah: <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></li>
                <li>Masukkan keterangan: "Pesanan #{{ $order->id }}"</li>
                <li>Konfirmasi dan selesaikan transaksi</li>
                <li>Screenshot bukti transfer</li>
                <li>Upload bukti di form di atas</li>
                <li>Admin akan memverifikasi dalam 1x24 jam</li>
            </ol>
        </div>
    </div>
</div>

<style>
.transfer-container {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 20px;
}

.transfer-header {
    text-align: center;
    margin-bottom: 40px;
}

.transfer-header h1 {
    font-size: 2rem;
    color: #2c9a94;
    margin-bottom: 10px;
}

.transfer-header p {
    color: #666;
    font-size: 1.1rem;
}

.transfer-content {
    display: grid;
    gap: 30px;
}

.order-card, .bank-card, .upload-card, .instructions-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    border: 2px solid #e0e0e0;
}

.order-card h2, .bank-card h2, .upload-card h2, .instructions-card h2 {
    color: #2c9a94;
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.order-info {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row span {
    color: #666;
    font-weight: 500;
}

.info-row strong {
    color: #333;
    font-weight: 700;
}

.amount {
    color: #2c9a94 !important;
    font-size: 1.2rem;
}

.bank-note, .upload-note {
    color: #666;
    margin-bottom: 20px;
    font-size: 0.95rem;
}

.bank-list {
    display: grid;
    gap: 20px;
}

.bank-item {
    background: linear-gradient(135deg, #f0fdf4 0%, #f0fdf4 100%);
    border: 2px solid #86efac;
    border-radius: 8px;
    padding: 20px;
}

.bank-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.bank-name {
    font-weight: 700;
    color: #2c9a94;
    font-size: 1.1rem;
}

.btn-copy {
    background: #2c9a94;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-copy:hover {
    background: #1a7a75;
    transform: scale(1.05);
}

.bank-details p {
    color: #333;
    margin: 8px 0;
    font-size: 0.95rem;
}

.bank-details strong {
    color: #2c9a94;
}

.file-upload-area {
    position: relative;
    margin-bottom: 15px;
}

#receipt {
    display: none;
}

.file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 50px;
    border: 2px dashed #2c9a94;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9f9f9;
}

.file-label:hover {
    background: #f0f0f0;
    border-color: #1a7a75;
}

.file-label i {
    font-size: 2.5rem;
    color: #2c9a94;
    margin-bottom: 10px;
}

.file-label span {
    color: #333;
    font-weight: 600;
    margin-bottom: 5px;
}

.file-label small {
    color: #999;
    font-size: 0.85rem;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.error-text {
    color: #e74c3c;
    font-size: 0.9rem;
    display: block;
    margin-top: 5px;
}

.btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(44, 154, 148, 0.2);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
}

.instructions-list {
    list-style: decimal;
    padding-left: 20px;
    color: #333;
    line-height: 2;
}

.instructions-list li {
    margin-bottom: 10px;
}

.instructions-list strong {
    color: #2c9a94;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-error {
    background: #fee;
    border: 2px solid #e74c3c;
    color: #c0392b;
}

@media (max-width: 768px) {
    .transfer-header h1 {
        font-size: 1.5rem;
    }

    .order-card, .bank-card, .upload-card, .instructions-card {
        padding: 20px;
    }

    .file-label {
        padding: 30px;
    }

    .bank-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .btn-copy {
        width: 100%;
    }
}
</style>

<script>
const fileInput = document.getElementById('receipt');
const fileLabel = document.querySelector('.file-label');

fileLabel.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileLabel.style.background = '#e8f5f3';
});

fileLabel.addEventListener('dragleave', () => {
    fileLabel.style.background = '#f9f9f9';
});

fileLabel.addEventListener('drop', (e) => {
    e.preventDefault();
    fileInput.files = e.dataTransfer.files;
    fileLabel.style.background = '#f9f9f9';
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Nomor rekening berhasil disalin!');
    });
}
</script>
@endsection
