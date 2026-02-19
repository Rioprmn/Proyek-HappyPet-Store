@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-product.css') }}">
@endpush

@section('content')
<div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h1 style="margin: 0; color: #1e293b;">Daftar Produk</h1>
        <p style="color: #64748b; margin-top: 5px;">Kelola semua inventaris HappyPet Store di sini.</p>
    </div>
    
    <a href="{{ route('admin.product.add') }}" style="background: #2c9a94; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s;">
        + Tambah Produk
    </a>
</div>

@if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #a7f3d0;">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
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
                    <td style="font-weight: 500;">{{ $product->name }}</td>
                    <td><span class="category-badge">{{ $product->category }}</span></td>
                    <td style="font-weight: 600; color: #2c9a94;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }} pcs</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn-edit" title="Edit Produk">📝</a>
                            
                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" style="background:none; border:none; cursor:pointer;" title="Hapus Produk">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px; color: #94a3b8;">
                        Belum ada produk. Klik "Tambah Produk" untuk memulai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection