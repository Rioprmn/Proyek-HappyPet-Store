@extends('layouts.app')

@section('content')
<div class="payment-container">
    <div class="payment-hero">
        <h1>Pilih Metode Pembayaran</h1>
        <p>Pesanan #{{ $order->id }} - Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>

    <div class="payment-methods">
        <!-- Transfer Bank -->
        <div class="payment-card">
            <div class="payment-icon">
                <i class="fas fa-university"></i>
            </div>
            <h3>Transfer Bank</h3>
            <p>Transfer langsung ke rekening toko</p>
            <form action="{{ route('checkout.process-transfer', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-payment">Pilih Metode Ini</button>
            </form>
        </div>

        <!-- Upload Bukti Pembayaran -->
        <div class="payment-card">
            <div class="payment-icon">
                <i class="fas fa-receipt"></i>
            </div>
            <h3>Upload Bukti Transfer</h3>
            <p>Jika sudah melakukan transfer</p>
            <button type="button" class="btn-payment" onclick="openUploadModal()">Upload Bukti</button>
        </div>
    </div>

    <!-- Bank Account Info -->
    <div class="bank-info">
        <h3>Rekening Toko</h3>
        <div class="bank-details">
            <div class="bank-item">
                <strong>Bank BCA</strong>
                <p>No. Rekening: 1234567890</p>
                <p>Atas Nama: Happy Pet Store</p>
            </div>
            <div class="bank-item">
                <strong>Bank Mandiri</strong>
                <p>No. Rekening: 0987654321</p>
                <p>Atas Nama: Happy Pet Store</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUploadModal()">&times;</span>
        <h2>Upload Bukti Pembayaran</h2>
        
        <form action="{{ route('checkout.process-payment-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Pilih Gambar Bukti Transfer</label>
                <div class="file-upload">
                    <input type="file" name="receipt" id="receipt" accept="image/*" required>
                    <label for="receipt" class="file-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Klik atau drag gambar di sini</span>
                    </label>
                </div>
                @error('receipt')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-submit">Upload Bukti</button>
        </form>
    </div>
</div>

<style>
.payment-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 20px;
}

.payment-hero {
    text-align: center;
    margin-bottom: 50px;
}

.payment-hero h1 {
    font-size: 2.5rem;
    color: #2c9a94;
    margin-bottom: 10px;
}

.payment-hero p {
    font-size: 1.1rem;
    color: #666;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
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

.btn-payment {
    background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-payment:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(44, 154, 148, 0.3);
}

.bank-info {
    background: linear-gradient(135deg, #f5f5f5 0%, #fafafa 100%);
    border-radius: 12px;
    padding: 30px;
    margin-top: 40px;
}

.bank-info h3 {
    color: #2c9a94;
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.bank-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.bank-item {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #2c9a94;
}

.bank-item strong {
    display: block;
    color: #2c9a94;
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.bank-item p {
    color: #666;
    margin: 5px 0;
    font-size: 0.95rem;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

.modal-content h2 {
    color: #2c9a94;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    color: #333;
    font-weight: 500;
}

.file-upload {
    position: relative;
}

#receipt {
    display: none;
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
    transition: all 0.3s ease;
    background: #f9f9f9;
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
    color: #666;
    font-size: 0.95rem;
}

.btn-submit {
    width: 100%;
    background: linear-gradient(135deg, #2c9a94 0%, #1a7a75 100%);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(44, 154, 148, 0.3);
}

.error {
    color: #e74c3c;
    font-size: 0.9rem;
    display: block;
    margin-top: 5px;
}

@media (max-width: 768px) {
    .payment-hero h1 {
        font-size: 1.8rem;
    }

    .payment-methods {
        grid-template-columns: 1fr;
    }

    .bank-details {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function openUploadModal() {
    document.getElementById('uploadModal').style.display = 'block';
}

function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('uploadModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Drag and drop
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
</script>
@endsection
