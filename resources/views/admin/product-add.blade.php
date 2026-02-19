@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Tambah Produk Baru</h1>
    <p style="color: #64748b;">Lengkapi detail informasi produk di bawah ini.</p>
</div>

<div class="form-container">
    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Royal Canin Kitten 2kg" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stock">Stok Barang</label>
                <input type="number" name="stock" id="stock" class="form-control" placeholder="0" required>
            </div>
        </div>

        <div class="form-group">
            <label for="price">Harga (Rp)</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Contoh: 150000" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Produk</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Jelaskan detail produk..."></textarea>
        </div>

        <div class="form-group">
            <label for="image">Foto Produk</label>
            <input type="file" name="image" id="image" class="form-control" style="padding: 8px;">
            <small style="color: #94a3b8;">Format: JPG, PNG, WEBP. Maks: 2MB</small>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <button type="submit" class="btn-submit">Simpan Produk</button>
            <a href="{{ route('admin.product.list') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection