<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    // Menangani halaman list blog (index)
    public function index(Request $request)
    {
        // Narik semua kategori buat filter biar gak error undefined variable
        $categories = BlogCategory::all();

        $query = Post::with('category');

        // Fitur Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter Kategori
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    // Menangani halaman baca artikel (show)
    public function show($slug)
    {
        // Cari artikel berdasarkan slug biar link "Read More" jalan
        $post = Post::with('category')->where('slug', $slug)->firstOrFail();
        
        return view('blog.show', compact('post'));
    }
}