<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Ini penting supaya Laravel mengizinkan pengisian data otomatis
    protected $fillable = ['name', 'slug'];
}
