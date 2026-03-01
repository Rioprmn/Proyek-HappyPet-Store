<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;

class WhatsAppService
{
    public static function sendOrderNotification(Order $order, string $status)
    {
        $messages = [
            'waiting_verification' => "Pesanan Anda telah diterima! Kami sedang memverifikasi bukti pembayaran Anda. Terima kasih telah berbelanja di Happy Pet Store.",
            'completed' => "Pesanan Anda telah dikonfirmasi! Silakan tunggu pengiriman. Terima kasih telah berbelanja di Happy Pet Store.",
            'cancelled' => "Maaf, pesanan Anda telah dibatalkan. Silakan hubungi kami untuk informasi lebih lanjut."
        ];

        $message = $messages[$status] ?? "Status pesanan Anda telah berubah menjadi: $status";

        $notification = Notification::create([
            'order_id' => $order->id,
            'phone' => $order->whatsapp,
            'status' => $status,
            'message' => $message,
            'type' => 'whatsapp',
            'sent' => true,
            'sent_at' => now()
        ]);

        // TODO: Integrate dengan WhatsApp API (Twilio, Fonnte, dll)
        // Untuk sekarang hanya menyimpan ke database
        
        return $notification;
    }
}
