@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="form-header">
    <div class="header-content">
        <div>
            <h1 class="form-title">➕ Tambah Produk Baru</h1>
            <p class="form-subtitle">Lengkapi detail informasi produk di bawah ini</p>
        </div>
    </div>
</div>

<div class="form-container">
    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        
        <div class="form-section">
            <h3 class="section-title">Informasi Dasar</h3>
            
            <div class="form-group" style="animation-delay: 0.1s">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Royal Canin Kitten 2kg" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group" style="animation-delay: 0.15s">
                    <label for="category">Kategori</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="animation-delay: 0.2s">
                    <label for="stock">Stok Barang</label>
                    <input type="number" name="stock" id="stock" class="form-control" placeholder="0" required>
                    @error('stock')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Harga & Deskripsi</h3>

            <div class="form-group" style="animation-delay: 0.25s">
                <label for="price">Harga (Rp)</label>
                <div class="price-input-wrapper">
                    <span class="price-prefix">Rp</span>
                    <input type="number" name="price" id="price" class="form-control price-input" placeholder="150000" required>
                </div>
                @error('price')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="animation-delay: 0.3s">
                <label for="description">Deskripsi Produk</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Jelaskan detail produk, manfaat, dan spesifikasi..."></textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Foto Produk</h3>

            <div class="form-group" style="animation-delay: 0.35s">
                <label for="image">Pilih Foto Produk</label>
                <div class="file-input-wrapper">
                    <input type="file" name="image" id="image" class="file-input" accept="image/*">
                    <div class="file-input-label">
                        <span class="file-icon">📸</span>
                        <span class="file-text">Klik untuk memilih foto atau drag & drop</span>
                        <span class="file-hint">Format: JPG, PNG, WEBP. Maks: 2MB</span>
                    </div>
                </div>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">💾 Simpan Produk</button>
            <a href="{{ route('admin.product.list') }}" class="btn-cancel">❌ Batal</a>
        </div>
    </form>
</div>

<style>
    .file-input {
        display: none;
    }

    .file-input-wrapper {
        position: relative;
        cursor: pointer;
    }

    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border: 2px dashed #2c9a94;
        border-radius: 12px;
        background: #f0fdf4;
        transition: all 0.3s ease;
        text-align: center;
    }

    .file-input-wrapper:hover .file-input-label {
        background: #ecfdf5;
        border-color: #1a7a75;
    }

    .file-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .file-text {
        display: block;
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .file-hint {
        display: block;
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .price-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .price-prefix {
        position: absolute;
        left: 16px;
        color: #64748b;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .price-input {
        padding-left: 45px !important;
    }
</style>
@endsection
