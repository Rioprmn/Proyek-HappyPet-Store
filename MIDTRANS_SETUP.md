# MIDTRANS PAYMENT GATEWAY SETUP

## Langkah-langkah Integrasi Midtrans:

### 1. Install Midtrans PHP Library
```bash
composer require midtrans/midtrans-php
```

### 2. Tambahkan Environment Variables ke .env
```
MIDTRANS_SERVER_KEY=your_server_key_here
MIDTRANS_CLIENT_KEY=your_client_key_here
MIDTRANS_IS_PRODUCTION=false
```

### 3. Update Routes (routes/web.php)
Tambahkan routes berikut di dalam middleware 'auth':

```php
// --- SISTEM CHECKOUT & PAYMENT (USER) ---
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/snap-token/{id}', [CheckoutController::class, 'getSnapToken'])->name('checkout.snap_token');
Route::get('/checkout/finish', [CheckoutController::class, 'finish'])->name('checkout.finish');
Route::get('/checkout/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');
Route::get('/checkout/error', [CheckoutController::class, 'error'])->name('checkout.error');
Route::post('/order/upload/{id}', [CheckoutController::class, 'uploadReceipt'])->name('order.upload_receipt');
Route::get('/my-orders', [CheckoutController::class, 'history'])->name('order.history');
```

### 4. Update Checkout View
Tambahkan Midtrans Snap script dan button pembayaran di checkout.blade.php:

```html
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<button id="pay-button" class="btn-pay">Bayar dengan Midtrans</button>

<script>
document.getElementById('pay-button').addEventListener('click', function() {
    fetch('/checkout/snap-token/{{ $order->id }}')
        .then(response => response.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("checkout.finish") }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("checkout.pending") }}';
                },
                onError: function(result) {
                    window.location.href = '{{ route("checkout.error") }}';
                }
            });
        });
});
</script>
```

### 5. Dapatkan Credentials dari Midtrans
1. Daftar di https://dashboard.midtrans.com
2. Buat akun merchant
3. Ambil Server Key dan Client Key dari dashboard
4. Masukkan ke .env file

### 6. Payment Methods yang Tersedia
- Credit Card
- Debit Card
- Bank Transfer
- E-Wallet (GCash, OVO, DANA, LinkAja)
- Convenience Store (Indomaret, Alfamart)
- Cicilan (Installment)

### 7. Testing Mode
Gunakan MIDTRANS_IS_PRODUCTION=false untuk testing
Gunakan kartu test: 4811 1111 1111 1114 (Visa)

### 8. Production Mode
Setelah testing selesai, ubah MIDTRANS_IS_PRODUCTION=true

## Features yang Sudah Diimplementasikan:
✅ Config file untuk Midtrans
✅ CheckoutController dengan Midtrans integration
✅ Snap Token generation
✅ Payment callbacks (finish, pending, error)
✅ Order status tracking

## Catatan:
- Pastikan HTTPS digunakan di production
- Simpan Server Key dengan aman
- Jangan expose Client Key di backend
- Test semua payment methods sebelum go live
