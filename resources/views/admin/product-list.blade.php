@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-product.css') }}">
@endpush

@section('content')
<div class="product-header">
    <div class="header-content">
        <div>
            <h1 class="product-title">📦 Product Inventory</h1>
            <p class="product-subtitle">Total {{ $products->count() }} produk terdaftar</p>
        </div>
        <a href="{{ route('admin.product.add') }}" class="btn-add-product">
            <span>+</span> Tambah Produk
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="filter-section">
    <div class="filter-label">🔍 Filter Cepat:</div>
    <form action="{{ route('admin.product.list') }}" method="GET" class="filter-form">
        <select name="category" onchange="this.form.submit()" class="filter-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        @if(request('category'))
            <a href="{{ route('admin.product.list') }}" class="btn-reset">
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
                <tr class="product-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                    <td>
                        <div class="product-image">
                            <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" 
                                 alt="{{ $product->name }}">
                        </div>
                    </td>
                    <td>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-id">ID: #PROD-{{ $product->id }}</div>
                    </td>
                    <td>
                        <span class="category-badge">{{ $product->category }}</span>
                    </td>
                    <td class="price-cell">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="stock-badge {{ $product->stock <= 5 ? 'stock-low' : '' }}">
                            {{ $product->stock }} <span class="stock-unit">pcs</span>
                        </span>
                    </td>
                    <td class="action-cell">
                        <div class="action-buttons">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn-action btn-edit" title="Edit">
                                ✎
                            </a>
                            
                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini secara permanen?')" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">📦</div>
                            <h3>Belum ada produk</h3>
                            <p>Mulai tambahkan produk pertamamu ke toko</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
