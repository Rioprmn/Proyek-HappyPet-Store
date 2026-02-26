@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Tambah User Baru</h1>
    <p style="color: #64748b;">Lengkapi detail informasi user di bawah ini.</p>
</div>

<div class="form-container">
    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: John Doe" required value="{{ old('name') }}">
            @error('name')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: john@example.com" required value="{{ old('email') }}">
            @error('email')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="phone">📱 No. Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="08123456789" value="{{ old('phone') }}">
                @error('phone')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">Pilih Role</option>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="address">📍 Alamat Lengkap</label>
            <textarea name="address" id="address" class="form-control" style="min-height: 80px;" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
            @error('address')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo">📷 Foto Profil</label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            <small style="color: #94a3b8;">Format: JPG, PNG, WEBP. Maks: 2MB</small>
            @error('photo')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter" required>
                @error('password')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <button type="submit" class="btn-submit">Simpan User</button>
            <a href="{{ route('admin.user.list') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection
