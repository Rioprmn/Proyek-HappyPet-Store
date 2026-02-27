<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CheckoutController extends Controller
{
    public function index(Request $request) 
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect('/shop')->with('error', 'Keranjang belanja Anda kosong.');
        }
        return view('checkout', compact('cart'));
    }

    public function process(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|min:10',
            'phone' => 'required|string|min:10|max:15',
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect('/shop')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        foreach($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }

        try {
            $filename = null;
            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $filename = time() . '_receipt.' . $file->getClientOriginalExtension();
                
                $path = public_path('receipts');
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $file->move($path, $filename);
            }

            $order = Order::create([
                'name' => $request->name,
                'address' => $request->address,
                'whatsapp' => $request->phone,
                'total_price' => $total,
                'items' => $cart,
                'payment_receipt' => $filename,
                'status' => 'waiting_verification'
            ]);

            session()->forget('cart');

            return redirect()->route('order.history')
                             ->with('success', 'Pesanan berhasil dibuat! Menunggu verifikasi pembayaran.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan.');
        }
    }

    public function history(Request $request)
    {
        $phone = $request->get('phone');
        $orders = [];

        if ($phone) {
            $request->validate([
                'phone' => 'required|string|min:10|max:15'
            ]);

            $orders = Order::where('whatsapp', $phone)
                           ->orderBy('created_at', 'desc')
                           ->get();
        }

        return view('order-history', compact('orders', 'phone'));
    }
}
