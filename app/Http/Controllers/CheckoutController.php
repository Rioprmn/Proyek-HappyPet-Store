<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect('/shop')->with('error', 'Keranjangmu kosong, yuk belanja dulu!');
        }
        return view('checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $cart = session()->get('cart', []);
        
        // Hitung total harga
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Simpan ke database
        Order::create([
            'name' => $request->name,
            'address' => $request->address,
            'whatsapp' => $request->phone, // Sesuaikan 'whatsapp' jika itu nama kolom di DB kamu
            'total_price' => $total,
            'items' => json_encode($cart),
            'status' => 'pending',
        ]);

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect('/')->with('success', 'Terima kasih! Pesananmu sedang diproses oleh admin.');
    }
}