@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 0;">
    <h2 style="margin-bottom: 30px; text-align: center;">Lacak Pesanan Kamu 🐾</h2>

    {{-- Form Pencarian --}}
    <div style="max-width: 500px; margin: 0 auto 40px; text-align: center;">
        <form action="{{ route('order.history') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="phone" value="{{ $phone }}" placeholder="Masukkan Nomor WhatsApp (0812...)" 
                   style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ddd; outline: none;" required>
            <button type="submit" style="background: #2c9a94; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">
                Cari Pesanan
            </button>
        </form>
    </div>

    @if($phone)
        @forelse($orders as $order)
    <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); border-top: 5px solid 
        {{ $order->status == 'completed' ? '#27ae60' : ($order->status == 'pending' ? '#f1c40f' : '#3498db') }};">
        
        {{-- Header Kartu Riwayat --}}
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <div>
                <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold;">
                    #HP-{{ $order->id }}
                </span>
                <div style="margin-top: 8px;">
                    <span style="color: #94a3b8; font-size: 0.85rem; display: block;">
                        📅 {{ $order->created_at->format('d M Y') }} — ⏰ {{ $order->created_at->format('H:i') }}
                    </span>
                    <h3 style="margin: 5px 0 0; color: #1e293b; font-size: 1.2rem;">{{ $order->name }}</h3>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="display: block; font-size: 0.8rem; color: #94a3b8; margin-bottom: 5px;">Total Pembayaran</span>
                <span style="font-weight: 800; color: #2c9a94; font-size: 1.3rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Status Badge --}}
        <div style="margin-bottom: 20px;">
            <span style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase;
                {{ $order->status == 'completed' ? 'background: #dcfce7; color: #166534;' : '' }}
                {{ $order->status == 'pending' ? 'background: #fef3c7; color: #92400e;' : '' }}
                {{ $order->status == 'waiting_verification' ? 'background: #e0f2fe; color: #075985;' : '' }}">
                ● {{ $order->status }}
            </span>
        </div>

        <div style="background: #f8fafc; border-radius: 12px; padding: 15px;">
            <p style="font-weight: 700; color: #475569; margin-top: 0; margin-bottom: 10px; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
                📦 Rincian Produk
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($order->items as $item)
                    <div style="display: flex; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #1e293b;">
                            <strong style="color: #2c9a94;">{{ $item['quantity'] }}x</strong> {{ $item['name'] }}
                        </span>
                        <span style="color: #64748b;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        @if($order->status == 'pending')
            <div style="margin-top: 20px; padding: 12px; background: #fff9db; border-radius: 10px; border: 1px dashed #fab005; text-align: center;">
                <a href="{{ route('checkout.index', ['order_id' => $order->id]) }}" 
                   style="color: #92400e; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                   ⚠️ Klik di sini untuk Upload Bukti Pembayaran
                </a>
            </div>
        @endif
    </div>
@empty
    <div style="text-align: center; padding: 50px 0;">
        <div style="font-size: 3rem;">🔎</div>
        <p style="color: #94a3b8; margin-top: 10px;">Tidak ditemukan pesanan untuk nomor WhatsApp ini.</p>
    </div>
@endforelse
    @endif
</div>
@endsection