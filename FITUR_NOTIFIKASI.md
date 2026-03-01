# Fitur Notifikasi WhatsApp

## Overview
Sistem notifikasi otomatis yang mengirim pesan WhatsApp ke customer saat status pesanan berubah.

## Alur Notifikasi

### 1. Saat Order Dibuat (Checkout)
- Status: `waiting_verification`
- Pesan: "Pesanan Anda telah diterima! Kami sedang memverifikasi bukti pembayaran Anda. Terima kasih telah berbelanja di Happy Pet Store."
- Trigger: `CheckoutController::process()`

### 2. Saat Admin Verifikasi Pembayaran
- Status: `completed`
- Pesan: "Pesanan Anda telah dikonfirmasi! Silakan tunggu pengiriman. Terima kasih telah berbelanja di Happy Pet Store."
- Trigger: `AdminController::verifyPayment()`

### 3. Saat Admin Update Status Pesanan
- Status: `completed` atau `cancelled`
- Pesan: Sesuai dengan status yang dipilih
- Trigger: `AdminController::orderUpdateStatus()`

## Database Schema

### Tabel: notifications
```
- id (primary key)
- order_id (foreign key ke orders)
- phone (nomor WhatsApp customer)
- status (status pesanan saat notifikasi dikirim)
- message (isi pesan)
- type (default: 'whatsapp')
- sent (boolean, default: true)
- sent_at (timestamp kapan notifikasi dikirim)
- created_at, updated_at
```

## File-File yang Terlibat

### Models
- `app/Models/Notification.php` - Model untuk tabel notifications
- `app/Models/Order.php` - Ditambahkan relasi `notifications()`

### Services
- `app/Services/WhatsAppService.php` - Service untuk mengirim notifikasi

### Controllers
- `app/Http/Controllers/CheckoutController.php` - Kirim notifikasi saat order dibuat
- `app/Http/Controllers/AdminController.php` - Kirim notifikasi saat verify/update status

### Migrations
- `database/migrations/2026_02_25_000000_create_notifications_table.php`

## Implementasi WhatsApp API

Saat ini, notifikasi hanya disimpan ke database. Untuk mengirim ke WhatsApp, integrasikan dengan salah satu provider:

### Opsi 1: Twilio
```php
use Twilio\Rest\Client;

$twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
$twilio->messages->create(
    $order->whatsapp,
    ['from' => env('TWILIO_PHONE_NUMBER')],
    ['body' => $message]
);
```

### Opsi 2: Fonnte
```php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'target' => $order->whatsapp,
        'message' => $message
    ]),
    CURLOPT_HTTPHEADER => ['Authorization: ' . env('FONNTE_TOKEN')]
));
$response = curl_exec($curl);
```

## Testing

Untuk test notifikasi:
1. Buat order baru → Cek tabel `notifications` apakah ada record baru
2. Verify payment di admin → Cek tabel `notifications` apakah ada record dengan status `completed`
3. Update status order → Cek tabel `notifications` apakah ada record dengan status baru

## Future Enhancement
- [ ] Integrate dengan WhatsApp API provider
- [ ] Retry mechanism jika pengiriman gagal
- [ ] Template pesan yang customizable
- [ ] Notification history di customer dashboard
- [ ] SMS fallback jika WhatsApp gagal
