<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'address', 
        'whatsapp', 
        'total_price', 
        'items', 
        'status',
        'payment_receipt', // Tambahan untuk simpan nama file struk
        'payment_method'   // Tambahan untuk info metode bayar
    ];

    /**
     * Cast kolom items agar otomatis menjadi array saat dipanggil,
     * dan otomatis menjadi JSON saat disimpan ke database.
     */
    protected $casts = [
        'items' => 'array',
    ];

    /**
     * Helper untuk mendapatkan warna badge berdasarkan status
     */
    public function getStatusColor()
    {
        return match($this->status) {
            'pending' => '#f59e0b',              // Orange
            'waiting_verification' => '#3b82f6',  // Blue
            'completed' => '#10b981',            // Green
            'cancelled' => '#ef4444',            // Red
            default => '#64748b',
        };
    }
}