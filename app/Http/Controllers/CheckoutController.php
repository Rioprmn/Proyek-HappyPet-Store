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
        // 1. Cek jika ada order_id (setelah redirect dari proses checkout)
        if ($request->has('order_id')) {
            $order = Order::find($request->order_id);
            if ($order) {
                return view('checkout', compact('order'));
            }
        }

        // 2. Jika tidak ada order_id, tampilkan isi keranjang
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
     * Memproses upload bukti transfer ke folder PUBLIC (Step 2)
     * Solusi anti-403 Forbidden
     */
    public function uploadReceipt(Request $request, $id) 
    {
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $order = Order::findOrFail($id);

        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            
            // Buat nama file unik
            $filename = time() . '_order_' . $order->id . '.' . $file->getClientOriginalExtension();
            
            // Pastikan folder public/receipts tersedia
            $path = public_path('receipts');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Hapus foto lama di public/receipts jika ada
            if ($order->payment_receipt && File::exists(public_path('receipts/' . $order->payment_receipt))) {
                File::delete(public_path('receipts/' . $order->payment_receipt));
            }

            // PINDAHKAN FILE LANGSUNG KE PUBLIC
            $file->move($path, $filename);

            // Update database
            $order->update([
                'payment_receipt' => $filename,
                'status' => 'waiting_verification'
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }
}