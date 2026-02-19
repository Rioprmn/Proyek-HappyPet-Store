<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Kalau keranjang kosong, jangan kasih akses ke checkout
        if(empty($cart)) {
            return redirect('/shop')->with('error', 'Keranjangmu kosong, yuk belanja dulu!');
        }

        return view('checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        // Validasi input (Simpel dulu)
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        // Di sini nantinya kita akan simpan ke tabel 'orders'
        // Untuk sekarang, kita kosongkan keranjang dan anggap sukses
        session()->forget('cart');

        return redirect('/')->with('success', 'Terima kasih! Pesananmu sedang diproses.');
    }
}