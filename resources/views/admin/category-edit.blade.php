@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1>Edit Kategori</h1>
</div>

<div class="form-container" style="max-width: 500px;">
    <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn-submit">Update Kategori</button>
            <a href="{{ route('admin.category.list') }}" style="margin-left:10px; color: #64748b; text-decoration:none;">Batal</a>
        </div>
    </form>
</div>
@endsection