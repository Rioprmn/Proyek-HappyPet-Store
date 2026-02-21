@extends('layouts.admin')

@section('content')
{{-- Letakkan di bawah .header-section --}}
@if(session('success'))
    <div style="padding: 15px; background: #dcfce7; color: #166534; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Pesanan Masuk</h1>
    <p style="color: #64748b;">Kelola transaksi pelanggan di sini.</p>
</div>

<div class="table-container" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
    <tr style="border-bottom: 2px solid #f1f5f9; color: #64748b;">
        <th>Pelanggan</th>
        <th style="padding: 12px;">Waktu</th> {{-- Kolom Baru --}}
        <th>Alamat</th>
        <th>Total Bayar</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse($orders as $order)
        <tr style="border-bottom: 1px solid #f1f5f9;">
            {{-- KOLOM PELANGGAN --}}
            <td style="padding: 15px;">
                <span style="font-weight: 600; display: block; color: #1e293b;">{{ $order->name }}</span>
                <small style="color: #2c9a94;">{{ $order->whatsapp }}</small>
            </td>

            {{-- KOLOM WAKTU --}}
            <td style="padding: 15px; white-space: nowrap;">
                <div style="font-weight: 600; color: #1e293b;">{{ $order->created_at->format('H:i') }}</div>
                <div style="font-size: 11px; color: #94a3b8;">{{ $order->created_at->format('d/m/Y') }}</div>
            </td>
            
            <td style="font-size: 14px; color: #475569;">{{ $order->address }}</td>
            
            <td style="font-weight: 700; color: #1e293b;">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                <br>
                <a href="{{ route('admin.order.print', $order->id) }}" target="_blank" 
                   style="display: inline-block; margin-top: 5px; padding: 4px 8px; background: #1e293b; color: white; text-decoration: none; border-radius: 4px; font-size: 10px;">
                   🖨️ Cetak Struk
                </a>
            </td>

            <td>
                @if($order->payment_receipt)
                    <a href="{{ asset('receipts/' . $order->payment_receipt) }}" target="_blank" 
                       style="display: block; font-size: 11px; margin-bottom: 5px; text-decoration: none; color: #2c9a94; font-weight: 600;">
                        🖼️ Lihat Bukti TF
                    </a>
                @endif
                
                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd; font-size: 11px; font-weight: 600; cursor: pointer;
                        {{ $order->status == 'completed' ? 'background: #dcfce7; color: #166534;' : '' }}
                        {{ $order->status == 'waiting_verification' ? 'background: #e0f2fe; color: #075985;' : '' }}
                        {{ $order->status == 'pending' ? 'background: #fef3c7; color: #92400e;' : '' }}">
                        
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                        <option value="waiting_verification" {{ $order->status == 'waiting_verification' ? 'selected' : '' }}>VERIFIKASI</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                    </select>
                </form>
            </td>

            <td>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="https://wa.me/{{ $order->whatsapp }}?text=Halo%20{{ $order->name }},%20pesanan%20Anda%20sedang%20kami%20proses!" 
                       target="_blank" 
                       style="text-decoration: none; font-size: 12px; background: #25d366; color: white; padding: 4px 8px; border-radius: 5px; font-weight: bold;">
                       WA
                    </a>
                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; cursor:pointer; color: #ef4444; font-size: 16px;">🗑️</button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada pesanan masuk.</td>
        </tr>
    @endforelse
</tbody>
    </table>
</div>
@endsection