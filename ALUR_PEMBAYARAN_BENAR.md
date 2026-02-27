# Alur Pembayaran yang Benar - Happy Pet Store

## ✅ Alur Pembayaran (Sudah Diperbaiki)

```
STEP 1: CHECKOUT
├─ URL: /checkout
├─ Isi: Nama, Alamat, WhatsApp
└─ Tombol: "Lanjut ke Pembayaran"
   ↓
STEP 2: PILIH METODE PEMBAYARAN
├─ URL: /checkout/payment/{id}
├─ Tampil: Pilihan metode (Transfer Bank)
└─ Tombol: "Pilih Metode Ini"
   ↓
STEP 3: INFORMASI TRANSFER BANK
├─ URL: /checkout/transfer-info/{id}
├─ Tampil: Rekening toko + Form upload bukti
└─ Tombol: "Upload Bukti Pembayaran"
   ↓
STEP 4: SUKSES PEMBAYARAN
├─ URL: /checkout/success/{id}
├─ Tampil: Halaman sukses
└─ Status: waiting_verification
```

## 🔧 Perbaikan yang Dilakukan

### 1. Payment Method View
- ✅ Tambah form dengan method POST
- ✅ Form submit ke `checkout.select-transfer`
- ✅ Tombol "Pilih Metode Ini" berfungsi

### 2. Transfer Info View
- ✅ Tampilkan rekening toko
- ✅ Form upload bukti dengan enctype multipart
- ✅ Drag & drop support
- ✅ Validasi file

### 3. CheckoutController
- ✅ selectTransfer() update status ke waiting_payment
- ✅ uploadProof() handle file upload
- ✅ paymentSuccess() tampilkan halaman sukses

## 🚀 Testing Alur Pembayaran

### Test 1: Checkout
```
1. Buka /checkout
2. Isi form (nama, alamat, WhatsApp)
3. Klik "Lanjut ke Pembayaran"
4. Redirect ke payment method ✓
```

### Test 2: Pilih Metode Pembayaran
```
1. Lihat halaman payment method
2. Klik "Pilih Metode Ini"
3. Redirect ke transfer-info ✓
4. Status order = waiting_payment ✓
```

### Test 3: Upload Bukti Pembayaran
```
1. Lihat halaman transfer-info
2. Lihat rekening toko
3. Pilih file gambar
4. Klik "Upload Bukti Pembayaran"
5. File terupload ke public/receipts/ ✓
6. Redirect ke payment-success ✓
7. Status order = waiting_verification ✓
```

### Test 4: Halaman Sukses
```
1. Lihat halaman payment-success
2. Tampil nomor pesanan
3. Tampil total pembayaran
4. Tampil status "Menunggu Verifikasi"
5. Tombol "Lihat Pesanan Saya" ✓
```

## 📁 File yang Diperbaiki

- ✅ `payment-method.blade.php` - Form dengan POST ke selectTransfer
- ✅ `transfer-info.blade.php` - Form upload dengan enctype multipart
- ✅ `CheckoutController.php` - Sudah benar

## 🔐 Validasi di Setiap Step

### Step 1: Checkout
- ✅ Nama: required, max 255
- ✅ Alamat: required, min 10
- ✅ WhatsApp: required, 10-15 digit

### Step 2: Pilih Metode
- ✅ Order status = pending
- ✅ Update payment_method = transfer
- ✅ Update status = waiting_payment

### Step 3: Upload Bukti
- ✅ Order status = waiting_payment
- ✅ File: required, image, max 2MB
- ✅ Update payment_receipt = filename
- ✅ Update status = waiting_verification

### Step 4: Sukses
- ✅ Order status = waiting_verification
- ✅ Tampilkan halaman sukses

## 📝 Catatan Penting

1. **Alur Harus Berurutan**: Jangan skip step
2. **Form POST**: Setiap step harus punya form POST
3. **Validasi Status**: Cek status order sebelum aksi
4. **File Upload**: Gunakan enctype multipart/form-data
5. **Redirect**: Redirect ke halaman berikutnya setelah sukses

## 🎯 Jika Ada Masalah

### Masalah: Tidak bisa pilih metode pembayaran
- Cek: Form di payment-method.blade.php
- Cek: Route checkout.select-transfer ada
- Cek: Method selectTransfer di controller

### Masalah: Tidak bisa upload bukti
- Cek: Form enctype="multipart/form-data"
- Cek: Input type="file" name="receipt"
- Cek: Folder public/receipts/ ada
- Cek: Permission folder 755

### Masalah: Redirect ke order history
- Cek: Status order di database
- Cek: payment_method di database
- Cek: Validasi status di controller

---

**Status**: ✅ Alur Pembayaran Sudah Diperbaiki
**Versi**: 1.0
**Tanggal**: 2024
