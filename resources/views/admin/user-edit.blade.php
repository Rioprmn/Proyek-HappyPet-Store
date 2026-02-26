@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-form.css') }}">
@endpush

@section('content')
<div class="header-section" style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b;">Edit User</h1>
    <p style="color: #64748b;">Ubah detail informasi untuk user: <strong>{{ $user->name }}</strong></p>
</div>

<div class="form-container">
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            @error('name')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
            @error('email')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="phone">📱 No. Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" placeholder="08123456789">
                @error('phone')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="address">📍 Alamat Lengkap</label>
            <textarea name="address" id="address" class="form-control" style="min-height: 80px;">{{ $user->address }}</textarea>
            @error('address')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo">📷 Foto Profil</label>
            @if($user->photo)
                <div style="margin-bottom: 15px;">
                    <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 10px;">Foto saat ini:</p>
                    <img src="{{ asset('assets/img/profiles/' . $user->photo) }}" alt="{{ $user->name }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover; border: 1px solid #ddd;">
                </div>
            @endif
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            <small style="color: #94a3b8;">Format: JPG, PNG, WEBP. Maks: 2MB</small>
            @error('photo')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="password">Password Baru (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter">
                @error('password')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <button type="submit" class="btn-submit">Update User</button>
            <a href="{{ route('admin.user.list') }}" class="btn-cancel" style="margin-left: 15px; text-decoration: none; color: #64748b;">Batal</a>
        </div>
    </form>
</div>
@endsection
