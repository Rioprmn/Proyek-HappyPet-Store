<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CheckoutController extends Controller
{

    /**
     * Menampilkan halaman checkout.
     */
    public function index(Request $request) 
    {
        if ($request->has('order_id')) {
            $order = Order::find($request->order_id);
            if ($order) {
                return view('checkout', compact('order'));
            }
        }

        $cart = session()->get('cart', []);

        if(empty($cart)) {
            return redirect('/shop')->with('error', 'Keranjang belanja Anda kosong.');
        }

        return view('checkout', compact('cart'));
    }

    /**
     * Memproses data formulir pengiriman (Step 1)
     */
    public function process(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) { 
            $total += $item['price'] * $item['quantity']; 
        }

        $order = Order::create([
            'name' => $request->name,
            'address' => $request->address,
            'whatsapp' => $request->phone,
            'total_price' => $total,
            'items' => $cart, 
            'status' => 'pending',
        ]);

        session()->forget('cart');

        return redirect()->route('checkout.index', ['order_id' => $order->id])
                         ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    /**
     * Menampilkan metode pembayaran
     */
    public function paymentMethod($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('payment-method', compact('order'));
    }

    /**
     * Proses pembayaran transfer bank
     */
    public function processTransfer(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'waiting_verification']);
        
        return redirect()->route('order.history')
                         ->with('success', 'Pesanan dibuat! Silakan transfer ke rekening yang tertera.');
    }

    /**
     * Proses pembayaran dengan bukti transfer
     */
    public function processPaymentProof(Request $request, $orderId)
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $order = Order::findOrFail($orderId);

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '_order_' . $order->id . '.' . $file->getClientOriginalExtension();
            
            $path = public_path('receipts');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            if ($order->payment_receipt && File::exists(public_path('receipts/' . $order->payment_receipt))) {
                File::delete(public_path('receipts/' . $order->payment_receipt));
            }

            $file->move($path, $filename);
            $order->update([
                'payment_receipt' => $filename,
                'status' => 'waiting_verification'
            ]);

            return redirect()->route('order.history')
                             ->with('success', 'Bukti pembayaran berhasil diunggah! Admin akan memverifikasi dalam 1x24 jam.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }



    public function history(Request $request)
    {
        $phone = $request->get('phone');
        $orders = [];

        if ($phone) {
            $orders = Order::where('whatsapp', $phone)
                           ->orderBy('created_at', 'desc')
                           ->get();
        }

        return view('order-history', compact('orders', 'phone'));
    }
}
