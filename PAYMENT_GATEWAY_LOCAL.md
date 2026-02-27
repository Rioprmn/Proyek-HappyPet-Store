# Payment Gateway Lokal - Happy Pet Store

## Deskripsi
Payment gateway lokal yang sederhana tanpa menggunakan pihak ketiga seperti Midtrans. Sistem ini menggunakan transfer bank manual dengan verifikasi admin.

## Fitur
- ✅ Transfer Bank Manual
- ✅ Upload Bukti Pembayaran
- ✅ Verifikasi Admin
- ✅ Status Pesanan Real-time
- ✅ Notifikasi WhatsApp (opsional)

## Alur Pembayaran

### 1. Customer Membuat Pesanan
```
Checkout → Isi Data Pengiriman → Proses Pesanan
```

### 2. Pilih Metode Pembayaran
```
Halaman Payment Method
├── Transfer Bank (Lihat Rekening Toko)
└── Upload Bukti Transfer
```

### 3. Transfer Bank
Customer melakukan transfer ke rekening toko yang tertera:
- **Bank BCA**: 1234567890 (Happy Pet Store)
- **Bank Mandiri**: 0987654321 (Happy Pet Store)

### 4. Upload Bukti Pembayaran
Customer upload screenshot/foto bukti transfer

### 5. Verifikasi Admin
Admin menerima notifikasi dan memverifikasi pembayaran di admin panel

### 6. Pesanan Diproses
Setelah verifikasi, status berubah menjadi "completed"

## Status Pesanan

| Status | Deskripsi |
|--------|-----------|
| `pending` | Pesanan baru, menunggu pembayaran |
| `waiting_verification` | Bukti pembayaran sudah diunggah, menunggu verifikasi admin |
| `completed` | Pembayaran terverifikasi, siap dikirim |
| `cancelled` | Pesanan dibatalkan |

## File-File Penting

### Controllers
- `app/Http/Controllers/CheckoutController.php` - Menangani checkout dan payment

### Views
- `resources/views/checkout.blade.php` - Halaman checkout
- `resources/views/payment-method.blade.php` - Pilihan metode pembayaran

### Routes
```php
// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Payment Method
Route::get('/payment/{id}', [CheckoutController::class, 'paymentMethod'])->name('checkout.payment-method');
Route::post('/payment/transfer/{id}', [CheckoutController::class, 'processTransfer'])->name('checkout.process-transfer');
Route::post('/payment/proof/{id}', [CheckoutController::class, 'processPaymentProof'])->name('checkout.process-payment-proof');

// Order History
Route::get('/my-orders', [CheckoutController::class, 'history'])->name('order.history');
```

## Konfigurasi

### 1. Database
Pastikan tabel `orders` sudah ada dengan kolom:
```sql
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    address TEXT,
    whatsapp VARCHAR(20),
    total_price DECIMAL(10, 2),
    items JSON,
    status VARCHAR(50) DEFAULT 'pending',
    payment_receipt VARCHAR(255) NULLABLE,
    payment_method VARCHAR(50) NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### 2. Folder Receipts
Buat folder untuk menyimpan bukti pembayaran:
```bash
mkdir public/receipts
chmod 755 public/receipts
```

### 3. Update Rekening Toko
Edit file `resources/views/payment-method.blade.php` dan ubah rekening:
```php
<div class="bank-item">
    <strong>Bank BCA</strong>
    <p>No. Rekening: YOUR_ACCOUNT_NUMBER</p>
    <p>Atas Nama: YOUR_NAME</p>
</div>
```

## Testing

### 1. Buat Pesanan
- Buka `/shop`
- Tambah produk ke cart
- Klik checkout
- Isi data pengiriman
- Klik "Lanjut ke Pembayaran"

### 2. Pilih Metode Pembayaran
- Lihat halaman payment method
- Pilih "Transfer Bank" atau "Upload Bukti Transfer"

### 3. Upload Bukti
- Klik "Upload Bukti"
- Pilih gambar bukti transfer
- Klik "Upload Bukti"

### 4. Verifikasi Admin
- Login sebagai admin
- Buka `/admin/orders`
- Lihat pesanan dengan status "waiting_verification"
- Verifikasi pembayaran

## Admin Panel

### Verifikasi Pembayaran
1. Buka `/admin/orders`
2. Cari pesanan dengan status "waiting_verification"
3. Klik tombol verifikasi
4. Status berubah menjadi "completed"

### Lihat Bukti Pembayaran
- Klik tombol "Lihat Bukti" untuk melihat screenshot bukti transfer

## Keamanan

### Best Practices
1. ✅ Validasi file upload (hanya image)
2. ✅ Limit ukuran file (max 2MB)
3. ✅ Simpan file di folder public/receipts
4. ✅ Rename file dengan timestamp
5. ✅ Verifikasi manual oleh admin

### Rekomendasi
- Gunakan HTTPS di production
- Backup folder receipts secara berkala
- Audit log untuk setiap verifikasi pembayaran
- Notifikasi email/WhatsApp untuk customer

## Troubleshooting

### File Upload Gagal
- Pastikan folder `public/receipts` sudah ada
- Pastikan permission folder 755
- Pastikan file size < 2MB

### Pesanan Tidak Muncul
- Cek database orders
- Pastikan session cart tidak kosong
- Cek error log di `storage/logs/`

### Status Tidak Berubah
- Refresh halaman
- Cek database status pesanan
- Pastikan admin sudah verifikasi

## Pengembangan Lebih Lanjut

### Fitur Tambahan
- [ ] Notifikasi WhatsApp otomatis
- [ ] Email konfirmasi pembayaran
- [ ] QR Code untuk transfer
- [ ] Integrasi dengan payment gateway (Midtrans, Stripe)
- [ ] Reminder pembayaran otomatis
- [ ] Laporan pembayaran harian

### Integrasi Payment Gateway
Jika ingin menambah payment gateway di masa depan:
1. Buat method baru di CheckoutController
2. Tambah route baru
3. Buat view untuk payment gateway
4. Update payment-method.blade.php

## Support
Untuk pertanyaan atau masalah, hubungi admin melalui WhatsApp atau email.
