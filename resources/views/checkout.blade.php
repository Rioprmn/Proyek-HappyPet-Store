@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 0;">

    {{-- TAMBAHKAN INI: Alert untuk notifikasi sukses/error --}}
    <div style="max-width: 800px; margin: 0 auto;">
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #10b981;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #ef4444;">
                {{ session('error') }}
            </div>
        @endif
    </div>
    
    {{-- BAGIAN 1: Jika User SUDAH Checkout & Perlu Bayar --}}
    @if(isset($order))
        <div style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
            <h2 style="color: #1e293b; margin-bottom: 10px;">Langkah Terakhir! 🐾</h2>
            <p style="color: #64748b; margin-bottom: 30px;">Silakan transfer untuk pesanan #HP-{{ $order->id }}</p>

            <div style="background: #f8fafc; padding: 25px; border-radius: 15px; margin-bottom: 30px; text-align: left;">
                <p style="margin: 0; color: #94a3b8; font-size: 0.9rem;">Transfer ke Rekening BCA:</p>
                <h3 style="margin: 5px 0; color: #27ae60;">123-456-7890</h3>
                <p style="margin: 0; font-weight: 600;">a.n HappyPet Store</p>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;">
                <p style="margin: 0; color: #94a3b8; font-size: 0.9rem;">Total yang harus dibayar:</p>
                <h2 style="margin: 0; color: #1e293b;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
            </div>

            {{-- Cek Status: Jika pending tampilkan form upload, jika sudah upload tampilkan pesan menunggu --}}
            @if($order->status == 'pending')
                <form action="{{ route('order.upload_receipt', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom: 20px; text-align: left;">
                        <label style="font-weight: 600; display: block; margin-bottom: 8px;">Upload Foto Struk (JPG/PNG)</label>
                        <input type="file" name="receipt" class="form-control" required style="width: 100%;">
                    </div>
                    <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 15px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer;">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            @else
                <div style="padding: 25px; background: #e0f2fe; color: #0369a1; border-radius: 15px; font-weight: 600; border: 1px dashed #0ea5e9;">
                    <span style="font-size: 2rem; display: block; margin-bottom: 10px;">⌛</span>
                    Bukti sudah diunggah.<br>Admin sedang memverifikasi pembayaranmu.
                </div>
                <a href="{{ route('product.index') }}" style="display: inline-block; margin-top: 20px; color: #64748b; text-decoration: none; font-size: 14px;">← Kembali Belanja</a>
            @endif
        </div>

    {{-- BAGIAN 2: Jika User BARU mau Checkout (Form Alamat) --}}
    @else
        <h2 style="margin-bottom: 30px;">Formulir Pengiriman 📦</h2>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
            <form action="{{ route('checkout.process') }}" method="POST" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" rows="3" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;" required></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="phone" placeholder="0812xxxx" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;" required>
                </div>
                <button type="submit" style="width: 100%; background: #27ae60; color: white; padding: 15px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    Konfirmasi Pesanan
                </button>
            </form>

            <div style="background: #f9f9f9; padding: 25px; border-radius: 15px; height: fit-content;">
                <h4 style="margin-bottom: 20px;">Ringkasan Belanja</h4>
                @php $total = 0 @endphp
                @foreach($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                        <span>{{ $details['name'] }} (x{{ $details['quantity'] }})</span>
                        <span>Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px;">
                    <span>Total Tagihan:</span>
                    <span style="color: #27ae60;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection