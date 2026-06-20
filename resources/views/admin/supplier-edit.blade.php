@extends('layouts.admin')

@push('styles')

<link rel="stylesheet" href="{{ asset('css/admin-blog.css') }}">
@endpush

@section('content')

<div class="blog-header">
    <div class="header-content">
        <div>
            <h1 class="blog-title">✏️ Edit Supplier</h1>
            <p class="blog-subtitle">
                Perbarui informasi supplier HappyPet
            </p>
        </div>
    </div>
</div>

<form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST" class="blog-form">
    @csrf
    @method('PUT')

```
<div class="form-section">

    <h3 class="section-title">🚚 Informasi Supplier</h3>

    <div class="form-group">
        <label>Nama Supplier</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ $supplier->name }}">
    </div>

    <div class="form-group">
        <label>Nama Kontak</label>
        <input type="text"
               name="contact_person"
               class="form-control"
               value="{{ $supplier->contact_person }}">
    </div>

    <div class="form-group">
        <label>Telepon</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ $supplier->phone }}">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ $supplier->email }}">
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="address"
                  class="form-control"
                  rows="4">{{ $supplier->address }}</textarea>
    </div>

    <div class="form-group">
        <label>Jenis Produk</label>
        <input type="text"
               name="product_type"
               class="form-control"
               value="{{ $supplier->product_type }}">
    </div>

    <div class="form-group">
        <label>Catatan</label>
        <textarea name="notes"
                  class="form-control"
                  rows="4">{{ $supplier->notes }}</textarea>
    </div>

    <div style="display:flex; gap:10px;">

        <button type="submit" class="btn-publish">
            💾 Update Supplier
        </button>

        <a href="{{ route('admin.suppliers.index') }}"
           class="btn-publish"
           style="
                text-decoration:none;
                background:#64748b;
                display:flex;
                align-items:center;
                justify-content:center;
           ">
            ← Kembali
        </a>

    </div>

</div>
```

</form>

@endsection
