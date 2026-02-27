@extends('layouts.app')

@section('content')
<div class="checkout-container">
    <div class="checkout-header">
        <h1>🛒 Checkout & Pembayaran</h1>
        <p>Isi data pengiriman dan upload bukti pembayaran</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data" class="checkout-form">
        @csrf

        <!-- SECTION 1: DATA PENGIRIMAN -->
        <div class="form-section">
            <h2>📋 Data Pengiriman</h2>
            
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" placeholder="Contoh: Jl. Merdeka No. 123, Kelurahan Sukamaju, Kecamatan Cikarang, Bekasi" rows="4" required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>No. WhatsApp</label>
                <input type="text" name="phone" placeholder="Contoh: 08123456789 atau +6281234567890" value="{{ old('phone') }}" required>
                <small class="help-text">Format: 08xx, +62xx, atau 62xx (10-15 digit)</small>
                @error('phone')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- SECTION 2: INFORMASI PEMBAYARAN -->
        <div class="form-section">
            <h2>💳 Informasi Pembayaran</h2>
            
            <div class="bank-info">
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
        </div>

        <!-- SECTION 3: UPLOAD BUKTI PEMBAYARAN -->
        <div class="form-section">
            <h2>📸 Upload Bukti Pembayaran</h2>
            
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
        </div>

        <!-- SECTION 4: RINGKASAN PESANAN -->
        <div class="form-section">
            <h2>📦 Ringkasan Pesanan</h2>
            
            <div class="items-list">
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <div class="item-row">
                        <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

            <div class="total-row">
                <span>Total Pembayaran:</span>
                <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>

        <!-- BUTTON KONFIRMASI -->
        <button type="submit" class="btn-confirm">✅ Konfirmasi Pesanan & Pembayaran</button>
    </form>
</div>

<style>
.checkout-container {
    max-width: 700px;
    margin: 60px auto;
    padding: 0 20px;
}

.checkout-header {
    text-align: center;
    margin-bottom: 40px;
}

.checkout-header h1 {
    font-size: 2rem;
    color: #2c9a94;
    margin-bottom: 10px;
}

.checkout-header p {
    color: #666;
    font-size: 1rem;
}

.checkout-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.form-section {
    padding: 30px;
    border-bottom: 1px solid #e0e0e0;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section h2 {
    font-size: 1.2rem;
    color: #2c9a94;
    margin-bottom: 20px;
    font-weight: 700;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 700;
    color: #333;
    margin-bottom: 8px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.95rem;
    font-family: inherit;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2c9a94;
    box-shadow: 0 0 0 3px rgba(44, 154, 148, 0.1);
}

.help-text {
    display: block;
    color: #64748b;
    font-size: 0.85rem;
    margin-top: 5px;
}

.error-text {
    color: #e74c3c;
    font-size: 0.9rem;
    display: block;
    margin-top: 5px;
}

.bank-note {
    color: #666;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.bank-list {
    display: grid;
    gap: 15px;
}

.bank-item {
    background: #f0fdf4;
    border: 2px solid #86efac;
    border-radius: 8px;
    padding: 15px;
}

.bank-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.bank-name {
    font-weight: 700;
    color: #2c9a94;
}

.btn-copy {
    background: #2c9a94;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-copy:hover {
    background: #1a7a75;
    transform: scale(1.05);
}

.bank-details p {
    color: #333;
    margin: 5px 0;
    font-size: 0.9rem;
}

.bank-details strong {
    color: #2c9a94;
}

#receipt {
    display: none;
}

.file-upload-area {
    position: relative;
}

.file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
    border: 2px dashed #2c9a94;
    border-radius: 8px;
    cursor: pointer;
    background: #f9f9f9;
    transition: all 0.3s ease;
}

.file-label:hover {
    background: #f0f0f0;
    border-color: #1a7a75;
}

.file-label i {
    font-size: 2rem;
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

.items-list {
    background: #f8fafc;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
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

.btn-confirm {
    width: calc(100% - 60px);
    margin: 30px;
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

.btn-confirm:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(44, 154, 148, 0.3);
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
    .checkout-header h1 {
        font-size: 1.5rem;
    }

    .form-section {
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

    .btn-confirm {
        width: calc(100% - 40px);
        margin: 20px;
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
