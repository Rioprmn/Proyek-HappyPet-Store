<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message', '');
        
        $reply = $this->generateReply($message);
        
        return response()->json(['reply' => $reply]);
    }

    private function generateReply($message)
    {
        $message = strtolower($message);
        
        if (preg_match('/(produk|product|barang|item)/i', $message)) {
            return 'Kami menyediakan berbagai produk hewan peliharaan berkualitas. Silakan kunjungi halaman Shop untuk melihat koleksi lengkap kami.';
        }
        
        if (preg_match('/(harga|price|biaya|cost)/i', $message)) {
            return 'Harga produk kami sangat kompetitif. Kunjungi Shop untuk melihat detail harga setiap produk.';
        }
        
        if (preg_match('/(pengiriman|delivery|ongkir|shipping)/i', $message)) {
            return 'Kami menyediakan layanan pengiriman ke seluruh Indonesia. Biaya pengiriman akan dihitung saat checkout berdasarkan lokasi Anda.';
        }
        
        if (preg_match('/(pembayaran|payment|bayar|transfer)/i', $message)) {
            return 'Kami menerima pembayaran melalui transfer bank. Silakan ikuti instruksi pembayaran yang akan ditampilkan saat checkout.';
        }
        
        if (preg_match('/(artikel|blog|berita|news)/i', $message)) {
            return 'Kami memiliki blog dengan berbagai artikel menarik tentang perawatan hewan peliharaan. Kunjungi halaman Blog untuk membacanya.';
        }
        
        if (preg_match('/(kontak|contact|hubungi|call)/i', $message)) {
            return 'Anda dapat menghubungi kami melalui halaman Contact. Tim kami siap membantu Anda.';
        }
        
        if (preg_match('/(terima kasih|thanks|thank you|makasih)/i', $message)) {
            return 'Sama-sama! Ada yang bisa saya bantu lagi?';
        }
        
        if (preg_match('/(halo|hi|hello|pagi|siang|malam)/i', $message)) {
            return 'Halo! Selamat datang di HappyPet Store. Ada yang bisa saya bantu?';
        }
        
        return 'Terima kasih atas pertanyaannya! Untuk informasi lebih detail, silakan hubungi tim kami melalui halaman Contact atau kunjungi Shop kami.';
    }
}
