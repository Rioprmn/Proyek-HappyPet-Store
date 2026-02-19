@extends('layouts.admin')

@section('content')
<div class="container" style="padding: 50px 0;">
    <h2 style="margin-bottom: 30px; color: #1f2937;">Admin Dashboard 🐾</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
        
        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #2c9a94;">
            <h4 style="color: #64748b; margin-bottom: 10px; font-size: 0.9rem;">TOTAL PRODUK</h4>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 2rem; font-weight: bold; color: #1e293b;">{{ $totalProducts }}</span>
                <span style="font-size: 1.5rem;">📦</span>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #3b82f6;">
            <h4 style="color: #64748b; margin-bottom: 10px; font-size: 0.9rem;">TOTAL STOK</h4>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 2rem; font-weight: bold; color: #1e293b;">{{ $totalStock }}</span>
                <span style="font-size: 1.5rem;">📊</span>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #f59e0b;">
            <h4 style="color: #64748b; margin-bottom: 10px; font-size: 0.9rem;">PESANAN BARU</h4>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 2rem; font-weight: bold; color: #1e293b;">0</span>
                <span style="font-size: 1.5rem;">🛒</span>
            </div>
        </div>
    </div>

    <div style="background: #f8fafc; padding: 30px; border-radius: 15px; border: 1px dashed #cbd5e1;">
        <h4 style="margin-bottom: 20px;">Menu Cepat:</h4>
        <div style="display: flex; gap: 15px;">
            <a href="{{ route('admin.product.list') }}" style="background: #2c9a94; color: white; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500;">Kelola Produk</a>
            <a href="#" style="background: white; color: #2c9a94; border: 1px solid #2c9a94; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500;">Lihat Laporan Penjualan</a>
        </div>
    </div>
</div>
@endsection