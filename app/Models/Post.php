<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'blog_category_id', 'content', 'image'];

    // Relasi ke kategori blog
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}