@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 0;">
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
</div>
@endsection