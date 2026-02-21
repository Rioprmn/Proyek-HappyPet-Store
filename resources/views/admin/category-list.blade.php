@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    
    {{-- FORM SECTION: Bisa untuk Tambah atau Edit --}}
    <div class="form-container">
        <h3 id="form-title">Tambah Kategori</h3>
        
        <form id="category-form" action="{{ route('admin.category.store') }}" method="POST">
            @csrf
            {{-- Hidden input untuk Method PUT (hanya aktif saat edit) --}}
            <div id="method-field"></div>
            
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" id="category-name" class="form-control" placeholder="Misal: Hamster" required>
            </div>
            
            <button type="submit" id="btn-submit" class="btn-submit" style="width: 100%;">Simpan Kategori</button>
            <button type="button" id="btn-cancel" onclick="resetForm()" class="btn-cancel" style="width: 100%; margin-top: 10px; display: none; background: #94a3b8; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;">Batal Edit</button>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            {{-- Tombol Edit (Memicu Javascript) --}}
                            <button type="button" 
                                    onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}')" 
                                    style="background: #3b82f6; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 13px;">
                                📝 Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.category.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete" style="font-size: 13px;">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- JAVASCRIPT UNTUK LOGIK EDIT --}}
<script>
    function editCategory(id, name) {
        // 1. Ubah Judul & Nama di Input
        document.getElementById('form-title').innerText = 'Edit Kategori';
        document.getElementById('category-name').value = name;
        
        // 2. Ubah Action Form ke URL Update
        // Sesuaikan URL-nya dengan route admin.category.update kamu
        document.getElementById('category-form').action = '/admin/categories/update/' + id;
        
        // 3. Tambahkan Method PUT (Laravel butuh ini untuk update)
        document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        // 4. Ubah Teks Tombol & Tampilkan Tombol Batal
        document.getElementById('btn-submit').innerText = 'Update Kategori';
        document.getElementById('btn-submit').style.background = '#f59e0b'; // Warna oranye untuk edit
        document.getElementById('btn-cancel').style.display = 'block';
    }

    function resetForm() {
        // Kembalikan form ke keadaan awal (Tambah)
        document.getElementById('form-title').innerText = 'Tambah Kategori';
        document.getElementById('category-name').value = '';
        document.getElementById('category-form').action = "{{ route('admin.category.store') }}";
        document.getElementById('method-field').innerHTML = '';
        document.getElementById('btn-submit').innerText = 'Simpan Kategori';
        document.getElementById('btn-submit').style.background = '#38b2ac';
        document.getElementById('btn-cancel').style.display = 'none';
    }
</script>
@endsection