@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 0;">
    <h2>Shopping Cart 🛒</h2>
    
    @if(session('cart'))
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background: #f4f4f4; text-align: left;">
            <th style="padding: 15px;">Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th style="padding: 15px;">Aksi</th> </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @foreach(session('cart') as $id => $details)
            @php $total += $details['price'] * $details['quantity'] @endphp
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                    <img src="{{ asset('assets/img/products/' . ($details['image'] ?? 'default.png')) }}" width="50">
                    {{ $details['name'] }}
                </td>
                <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                <td>{{ $details['quantity'] }}</td>
                <td>Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                <td style="padding: 15px;">
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                            🗑️ Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        <div style="text-align: right; margin-top: 30px;">
    <h3>Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
    
    <button onclick="window.location.href='{{ route('checkout.index') }}'" 
            style="background: #27ae60; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
        Lanjut ke Pembayaran (Checkout)
    </button>
</div>
    @else
        <p>Keranjangmu masih kosong. <a href="/shop">Yuk belanja!</a></p>
    @endif
</div>
@endsection