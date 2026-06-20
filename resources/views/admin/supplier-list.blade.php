@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush

@section('content')

<div class="blog-header">
    <div class="header-content">
        <div>
            <h1 class="blog-title">🚚 Manajemen Supplier</h1>
            <p class="blog-subtitle">
                Kelola informasi supplier HappyPet
            </p>
        </div>

        <a href="{{ route('admin.suppliers.create') }}" class="btn-add-article">
            <span>+</span> Tambah Supplier
        </a>
    </div>
</div>

<div class="blog-card">

    <div class="table-header">
        <h3 class="table-title">📋 Daftar Supplier</h3>
        <span class="article-count">
            {{ $suppliers->count() }} supplier
        </span>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Produk</th>
                    <th>Catatan</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                <tr style="animation-delay: {{ $loop->index * 0.05 }}s">

                    <td>
                        <div class="article-info">
                            <span class="article-title">
                                {{ $supplier->name }}
                            </span>
                        </div>
                    </td>

                    <td>{{ $supplier->contact_person }}</td>

                    <td>{{ $supplier->phone }}</td>

                    <td>
                        <span class="category-badge">
                            {{ $supplier->product_type }}
                        </span>
                    </td>

                    <td>{{ $supplier->notes }}</td>

                    <td class="action-cell">
                        <div class="action-buttons">

                            <a href="{{ route('admin.suppliers.edit',$supplier->id) }}"
                               class="btn-action btn-edit">
                                ✎
                            </a>

                            <form action="{{ route('admin.suppliers.delete',$supplier->id) }}"
                                  method="POST"
                                  class="delete-form"
                                  onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn-action btn-delete">
                                    🗑
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">🚚</div>
                            <h3>Belum ada supplier</h3>
                            <p>Tambahkan supplier pertama Anda</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection