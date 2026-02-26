@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush

@section('content')
<div class="blog-header">
    <div class="header-content">
        <div>
            <h1 class="blog-title">📝 Manajemen Blog & Edukasi</h1>
            <p class="blog-subtitle">Kelola semua artikel edukasi HappyPet di sini</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="btn-add-article">
            <span>+</span> Tambah Artikel
        </a>
    </div>
</div>

<div class="blog-card">
    <div class="table-header">
        <h3 class="table-title">📚 Daftar Artikel</h3>
        <span class="article-count">{{ $posts->count() }} artikel</span>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr class="blog-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                    <td>
                        <div class="blog-image">
                            @if($post->image)
                                <img src="{{ asset('assets/img/blog/'.$post->image) }}" alt="{{ $post->title }}">
                            @else
                                <div class="no-image">📷</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="article-info">
                            <span class="article-title">{{ $post->title }}</span>
                            <span class="article-date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </td>
                    <td class="action-cell">
                        <div class="action-buttons">
                            <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn-action btn-edit" title="Edit">
                                ✎
                            </a>

                            <form action="{{ route('admin.blog.delete', $post->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus artikel ini?')" class="delete-form">
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
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-icon">✍️</div>
                            <h3>Belum ada artikel</h3>
                            <p>Yuk tulis edukasi pertamamu!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
