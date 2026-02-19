<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Ini penting agar Product::create() di Seeder tadi berhasil.
     */
    protected $fillable = [
        'name',
        'category',
        'price',
        'image',
        'description',
        'stock',
    ];

    /**
     * Opsional: Jika kamu ingin harga selalu diformat otomatis 
     * atau ada logika khusus, bisa ditambahkan di bawah sini.
     */
}