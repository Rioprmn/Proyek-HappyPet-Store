<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Menambah produk ke keranjang
    public function add(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $cart = session()->get('cart', []);

    // AMBIL QUANTITY DARI INPUT FORM (detail produk)
    // Jika input tidak ada, default ke 1
    $quantity = $request->input('quantity', 1);

    // Jika produk sudah ada di keranjang, tambahkan jumlahnya sesuai input
    if(isset($cart[$product->id])) {
        // Pakai += agar jumlah yang baru ditambahkan ke jumlah yang lama
        $cart[$product->id]['quantity'] += $quantity;
    } else {
        // Jika belum ada, masukkan data baru dengan quantity sesuai input
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => $quantity, // Pakai variabel $quantity
            "price" => $product->price,
            "image" => $product->image
        ];
    }

    session()->put('cart', $cart);
    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambah!');
}

    // Menghapus satu item dari keranjang
public function remove(Request $request)
{
    if($request->id) {
        $cart = session()->get('cart');
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}

// Menghapus seluruh isi keranjang
public function clear()
{
    session()->forget('cart');
    return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan!');
}

}