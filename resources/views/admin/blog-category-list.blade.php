@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog-category.css') }}">
@endpush

@section('content')
<div class="category-header">
    <div class="header-content">
        <div>
            <h1 class="category-title">📂 Kategori Blog & Edukasi</h1>
            <p class="category-subtitle">Kelola kategori edukasi untuk HappyPet</p>
        </div>
    </div>
</div>

<div class="category-layout">
    
    {{-- FORM SECTION --}}
    <div class="form-card">
        <h3 class="form-card-title">➕ Tambah Kategori</h3>
        
        <form action="{{ route('admin.blog.category.store') }}" method="POST" class="category-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" 
                       placeholder="Contoh: Perawatan Kucing" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit-category">
                💾 Simpan Kategori
            </button>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">📚 Daftar Kategori</h3>
            <span class="category-count">{{ $categories->count() }} kategori</span>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr class="category-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <td>
                            <span class="category-name">{{ $cat->name }}</span>
                        </td>
                        <td>
                            <span class="slug-badge">{{ $cat->slug }}</span>
                        </td>
                        <td class="action-cell">
                            <form action="{{ route('admin.blog.category.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    🗑
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-icon">📂</div>
                                <h3>Belum ada kategori</h3>
                                <p>Mulai tambahkan kategori pertamamu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
