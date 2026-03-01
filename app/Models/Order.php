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
        'payment_receipt',
        'payment_method'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function getStatusColor()
    {
        return match($this->status) {
            'pending' => '#f59e0b',
            'waiting_payment' => '#8b5cf6',
            'waiting_verification' => '#3b82f6',
            'completed' => '#10b981',
            'cancelled' => '#ef4444',
            default => '#64748b',
        };
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
