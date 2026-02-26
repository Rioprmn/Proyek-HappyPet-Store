@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush

@section('content')
<div class="blog-header">
    <div class="header-content">
        <div>
            <h1 class="blog-title">✍️ Tulis Artikel Baru</h1>
            <p class="blog-subtitle">Berikan edukasi terbaik buat pelanggan HappyPet</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="blog-form">
    @csrf
    <div class="blog-form-layout">
        
        {{-- Kolom Kiri: Konten --}}
        <div class="form-main">
            <div class="form-section">
                <h3 class="section-title">📄 Konten Artikel</h3>

                <div class="form-group" style="animation-delay: 0.1s">
                    <label for="title">Judul Artikel</label>
                    <input type="text" name="title" id="title" class="form-control" 
                           placeholder="Contoh: 5 Cara Memandikan Kucing" required>
                    @error('title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="animation-delay: 0.15s">
                    <label for="content">Isi Artikel</label>
                    <textarea name="content" id="content" rows="15" class="form-control" 
                              placeholder="Tulis konten artikel Anda di sini..." required></textarea>
                    @error('content')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Meta Data --}}
        <div class="form-sidebar">
            <div class="form-section">
                <h3 class="section-title">⚙️ Pengaturan</h3>

                <div class="form-group" style="animation-delay: 0.2s">
                    <label for="blog_category_id">Kategori</label>
                    <select name="blog_category_id" id="blog_category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('blog_category_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="animation-delay: 0.25s">
                    <label for="image">Thumbnail Gambar</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="image" id="image" class="file-input" accept="image/*" required>
                        <div class="file-input-label">
                            <span class="file-icon">🖼️</span>
                            <span class="file-text">Klik untuk memilih gambar</span>
                            <span class="file-hint">JPG, PNG (Max 2MB)</span>
                        </div>
                    </div>
                    @error('image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-publish" style="animation-delay: 0.3s">
                    🚀 Terbitkan Artikel
                </button>
            </div>
        </div>

    </div>
</form>

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
        padding: 30px;
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
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .file-text {
        display: block;
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 0.9rem;
    }

    .file-hint {
        display: block;
        color: #94a3b8;
        font-size: 0.8rem;
    }
</style>
@endsection
