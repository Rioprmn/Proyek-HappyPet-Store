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
    $quantityRequested = $request->input('quantity', 1);

    // CEK: Apakah stok mencukupi?
    if ($product->stock < $quantityRequested) {
        return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi. Sisa stok: ' . $product->stock);
    }

    $cart = session()->get('cart', []);

    if(isset($cart[$product->id])) {
        // CEK LAGI: Total di keranjang + permintaan baru tidak boleh > stok
        $newQty = $cart[$product->id]['quantity'] + $quantityRequested;
        if ($newQty > $product->stock) {
            return redirect()->back()->with('error', 'Total di keranjang melebihi stok yang tersedia.');
        }
        $cart[$product->id]['quantity'] = $newQty;
    } else {
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => $quantityRequested,
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