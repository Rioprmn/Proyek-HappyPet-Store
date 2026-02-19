<?php

namespace App\Http\Controllers;

use App\Models\Product; // Penting untuk memanggil Model
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index(Request $request)
{
    $query = Product::query();

    // Filter berdasarkan Kategori
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    // Filter berdasarkan Search
    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $products = $query->get();
    return view('shop', compact('products'));
}

public function show($id)
{
    $product = Product::findOrFail($id); // Cari produk berdasarkan ID, kalau tidak ada muncul 404
    return view('product-detail', compact('product'));
}

}