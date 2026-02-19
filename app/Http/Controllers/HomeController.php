<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 4 produk terbaru dari tabel products
        $featuredProducts = Product::latest()->take(4)->get();

        // Mengirim data ke view home.blade.php
        return view('home', compact('featuredProducts'));
    }
}