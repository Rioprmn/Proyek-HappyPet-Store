<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['order_id', 'phone', 'status', 'message', 'type', 'sent', 'sent_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
