@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush

@section('content')

<div class="blog-header">
    <div class="header-content">
        <div>
            <h1 class="blog-title">➕ Tambah Supplier</h1>
            <p class="blog-subtitle">
                Tambahkan data supplier baru
            </p>
        </div>
    </div>
</div>

<form action="{{ route('admin.suppliers.store') }}" method="POST" class="blog-form">
@csrf

<div class="form-section">

    <h3 class="section-title">📦 Informasi Supplier</h3>

    <div class="form-group">
        <label>Nama Supplier</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="form-group">
        <label>Nama Kontak</label>
        <input type="text" name="contact_person" class="form-control">
    </div>

    <div class="form-group">
        <label>Telepon</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="address" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Jenis Produk</label>
        <input type="text" name="product_type" class="form-control">
    </div>

    <div class="form-group">
        <label>Catatan</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn-publish">
        💾 Simpan Supplier
    </button>

</div>

</form>

@endsection