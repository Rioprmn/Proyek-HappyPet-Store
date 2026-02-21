<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4-8 produk terbaru untuk ditampilkan di Featured Products
        $featuredProducts = Product::latest()->take(8)->get();
        
        // Ambil semua kategori untuk bagian "Shop by Category"
        $categories = Category::all();

        return view('home', compact('featuredProducts', 'categories'));
    }
}