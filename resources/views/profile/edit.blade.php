@extends('layouts.app')

@section('content')
<div class="profile-hero">
    <div class="profile-hero-content">
        <h1 class="profile-hero-title">✏️ Edit Profil</h1>
        <p class="profile-hero-subtitle">Perbarui informasi akun dan data pribadi Anda</p>
    </div>
    <div class="profile-hero-pattern"></div>
</div>

<div class="profile-container">
    <div class="profile-edit-card">
        @if(session('success'))
            <div class="success-message">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3 class="form-section-title">Informasi Pribadi</h3>

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">📱 No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">📍 Alamat Lengkap</label>
                    <textarea id="address" name="address" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">Foto Profil</h3>

                <div class="form-group">
                    <label for="photo">📷 Pilih Foto Profil</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="photo" name="photo" accept="image/*" class="file-input">
                        <div class="file-input-label">
                            <span class="file-icon">📸</span>
                            <span class="file-text">Klik untuk memilih foto atau drag & drop</span>
                            <span class="file-hint">Format: JPG, PNG, WEBP. Maks: 2MB</span>
                        </div>
                    </div>
                    @error('photo')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                @if($user->photo)
                    <div class="photo-preview-section">
                        <p class="preview-label">Foto Saat Ini:</p>
                        <img src="{{ asset('assets/img/profiles/' . $user->photo) }}" alt="{{ $user->name }}" class="photo-preview">
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
                <a href="{{ route('profile.show') }}" class="btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .file-input {
        display: none;
    }

    .file-input-wrapper {
        position: relative;
        cursor: pointer;
    }

    .file-input-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border: 2px dashed #2c9a94;
        border-radius: 12px;
        background: #f0fdf4;
        transition: all 0.3s ease;
        text-align: center;
    }

    .file-input-wrapper:hover .file-input-label {
        background: #ecfdf5;
        border-color: #1a7a75;
    }

    .file-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .file-text {
        display: block;
        color: #1f2937;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .file-hint {
        display: block;
        color: #94a3b8;
        font-size: 0.85rem;
    }
</style>
@endsection
