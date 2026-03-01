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
                    <label for="profile_photo" class="photo-upload-label">
                        <div class="photo-upload-box">
                            @if($user->profile_photo)
                                <img id="photoPreview" src="{{ asset('assets/img/profiles/' . $user->profile_photo) }}" alt="Preview" class="photo-preview-img">
                            @else
                                <div id="photoPreview" class="photo-placeholder">
                                    <span class="photo-icon">📸</span>
                                    <span class="photo-text">Pilih Foto</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg" class="file-input-hidden">
                    </label>
                    <p class="photo-hint">JPG, PNG • Maks 2MB</p>
                    @error('profile_photo')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
                <a href="{{ route('profile.show') }}" class="btn-cancel">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .file-input-hidden {
        display: none;
    }

    .photo-upload-label {
        cursor: pointer;
        display: block;
    }

    .photo-upload-box {
        width: 100%;
        aspect-ratio: 1;
        border: 2px dashed #2c9a94;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        transition: all 0.3s ease;
        overflow: hidden;
        max-width: 300px;
        margin: 0 auto 15px;
    }

    .photo-upload-label:hover .photo-upload-box {
        border-color: #1a7a75;
        background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
        transform: scale(1.02);
    }

    .photo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        color: #2c9a94;
    }

    .photo-icon {
        font-size: 3rem;
    }

    .photo-text {
        font-weight: 600;
        font-size: 1rem;
    }

    .photo-preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-hint {
        text-align: center;
        color: #94a3b8;
        font-size: 0.85rem;
        margin: 0;
    }
</style>

<script>
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('photoPreview');
                if (preview.classList.contains('photo-placeholder')) {
                    preview.classList.remove('photo-placeholder');
                    preview.innerHTML = '';
                }
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'photo-preview-img';
                preview.innerHTML = '';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
