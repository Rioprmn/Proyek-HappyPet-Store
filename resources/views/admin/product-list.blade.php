@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-product.css') }}">
@endpush

@section('content')
<div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
    <div>
        <h1 style="margin: 0; color: #1e293b; font-weight: 800; letter-spacing: -0.025em;">Product Inventory</h1>
        <p style="color: #64748b; margin-top: 5px;">Total {{ $products->count() }} produk terdaftar.</p>
    </div>
    
    <a href="{{ route('admin.product.add') }}" style="background: #2c9a94; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(44, 154, 148, 0.3); transition: 0.3s; display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 1.2rem;">+</span> Tambah Produk
    </a>
</div>

{{-- Alert Success --}}
@if(session('success'))
    <div style="background: #ecfdf5; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 10px;">
        <span>✅</span> {{ session('success') }}
    </div>
@endif


{{-- Tambahkan ini di bawah header-section tapi di atas table-container --}}
<div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 15px;">
    <div style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">
        <span style="margin-right: 5px;">🔍</span> Filter Cepat:
    </div>
    
    <form action="{{ route('admin.product.list') }}" method="GET" style="display: flex; gap: 10px; flex: 1;">
        <select name="category" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #475569; font-size: 0.85rem; outline: none; cursor: pointer; min-width: 200px;">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        @if(request('category'))
            <a href="{{ route('admin.product.list') }}" style="text-decoration: none; color: #ef4444; font-size: 0.85rem; display: flex; align-items: center; font-weight: 500;">
                ✕ Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 80px;">Produk</th>
                <th>Detail Nama</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" 
                             alt="{{ $product->name }}" 
                             style="width: 50px; height: 50px; object-fit: contain; border-radius: 4px; border: 1px solid #eee;">
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1e293b;">{{ $product->name }}</div>
                        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px;">ID: #PROD-{{ $product->id }}</div>
                    </td>
                    <td><span class="category-badge">{{ $product->category }}</span></td>
                    <td style="font-weight: 700; color: #1e293b;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="stock-badge {{ $product->stock <= 5 ? 'stock-low' : '' }}">
                            {{ $product->stock }} <span style="font-weight: 400; font-size: 0.8rem;">pcs</span>
                        </span>
                    </td>
                    <td style="text-align: right; padding-right: 20px;"> {{-- Kolom Aksi Rata Kanan --}}
                        <div class="action-buttons" style="display: flex; justify-content: flex-end; gap: 10px;">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn-action btn-edit-new" title="Edit">
                                ✎
                            </a>
                            
                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete-new" title="Hapus">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 80px 0;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">📦</div>
                        <h3 style="color: #64748b; margin-bottom: 5px;">Belum ada produk</h3>
                        <p style="color: #94a3b8;">Mulai tambahkan produk pertamamu ke toko.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection