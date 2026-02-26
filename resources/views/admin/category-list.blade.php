@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-category.css') }}">
@endpush

@section('content')
<div class="category-header">
    <div class="header-content">
        <div>
            <h1 class="category-title">📁 Manajemen Kategori</h1>
            <p class="category-subtitle">Kelola kategori produk toko Anda</p>
        </div>
    </div>
</div>

<div class="category-layout">
    {{-- FORM SECTION --}}
    <div class="form-card">
        <h3 class="form-card-title" id="form-title">➕ Tambah Kategori</h3>
        
        <form id="category-form" action="{{ route('admin.category.store') }}" method="POST" class="category-form">
            @csrf
            <div id="method-field"></div>
            
            <div class="form-group">
                <label for="category-name">Nama Kategori</label>
                <input type="text" name="name" id="category-name" class="form-control" placeholder="Misal: Hamster" required>
            </div>
            
            <div class="form-actions-single">
                <button type="submit" id="btn-submit" class="btn-submit-category">💾 Simpan Kategori</button>
                <button type="button" id="btn-cancel" onclick="resetForm()" class="btn-cancel-category" style="display: none;">
                    ❌ Batal Edit
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="table-card">
        <div class="table-header">
            <h3 class="table-title">📋 Daftar Kategori</h3>
            <span class="category-count">{{ $categories->count() }} kategori</span>
        </div>

        <div class="table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr class="category-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <td>
                            <div class="category-name-cell">
                                <span class="category-icon">🏷️</span>
                                <span class="category-text">{{ $cat->name }}</span>
                            </div>
                        </td>
                        <td class="action-cell">
                            <div class="action-buttons">
                                <button type="button" 
                                        onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}')" 
                                        class="btn-action btn-edit"
                                        title="Edit">
                                    ✎
                                </button>

                                <form action="{{ route('admin.category.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">
                            <div class="empty-state">
                                <div class="empty-icon">📁</div>
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

<script>
    function editCategory(id, name) {
        document.getElementById('form-title').innerText = '✏️ Edit Kategori';
        document.getElementById('category-name').value = name;
        document.getElementById('category-form').action = '/admin/categories/update/' + id;
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('btn-submit').innerText = '💾 Update Kategori';
        document.getElementById('btn-submit').classList.add('btn-edit-mode');
        document.getElementById('btn-cancel').style.display = 'block';
        
        // Scroll ke form
        document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        document.getElementById('category-name').focus();
    }

    function resetForm() {
        document.getElementById('form-title').innerText = '➕ Tambah Kategori';
        document.getElementById('category-name').value = '';
        document.getElementById('category-form').action = "{{ route('admin.category.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('btn-submit').innerText = '💾 Simpan Kategori';
        document.getElementById('btn-submit').classList.remove('btn-edit-mode');
        document.getElementById('btn-cancel').style.display = 'none';
    }
</script>
@endsection
