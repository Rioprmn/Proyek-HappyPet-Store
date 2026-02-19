@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Edit Produk</h1>
    <p style="color: #64748b;">Ubah detail informasi untuk produk: <strong>{{ $product->name }}</strong></p>
</div>

<div class="form-container">
    {{-- Perhatikan route update dan method PUT --}}
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" id="category" class="form-control" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}" {{ $product->category == $cat->name ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stock">Stok Barang</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea name="description" id="description" rows="4" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto Produk Saat Ini</label>
            <div style="margin-bottom: 10px;">
                @if($product->image)
                    <img src="{{ asset('assets/img/products/' . $product->image) }}" alt="Preview" style="width: 100px; border-radius: 8px; border: 1px solid #ddd;">
                @else
                    <p style="font-size: 0.8rem; color: #94a3b8;">Tidak ada foto.</p>
                @endif
            </div>
            <label for="image">Ganti Foto (Kosongkan jika tidak ingin ganti)</label>
            <input type="file" name="image" id="image" class="form-control" style="padding: 8px;">
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <button type="submit" class="btn-submit">Update Produk</button>
            <a href="{{ route('admin.product.list') }}" class="btn-cancel" style="margin-left: 15px; text-decoration: none; color: #64748b;">Batal</a>
        </div>
    </form>
</div>
@endsection