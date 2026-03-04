@extends('layouts.app')

@section('content')
<div class="edit-page">
    <div class="edit-container">
        <div class="edit-card">
            <h1>✏️ Edit Profil</h1>

            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h2>📋 Informasi Pribadi</h2>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">📱 No. Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08123456789">
                        @error('phone')<span class="error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="address">📍 Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="4" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                        @error('address')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2>📷 Foto Profil</h2>

                    <label for="profile_photo" class="photo-upload">
                        <div class="photo-box">
                            @if($user->profile_photo)
                                <img id="photoPreview" src="{{ asset('assets/img/profiles/' . $user->profile_photo) }}" alt="Preview">
                            @else
                                <div id="photoPreview" class="photo-placeholder">
                                    <span>📸</span>
                                    <span>Klik untuk upload foto</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg" style="display: none;">
                    </label>
                    <p class="photo-hint">JPG, PNG • Maks 2MB</p>
                    @error('profile_photo')<span class="error">{{ $message }}</span>@enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">❌ Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .edit-page {
        background: #f8fafc;
        min-height: 100vh;
        padding: 20px;
    }

    .edit-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .edit-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 30px;
    }

    .edit-card h1 {
        font-size: 1.8rem;
        color: #1e293b;
        margin: 0 0 20px 0;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h2 {
        font-size: 1.1rem;
        color: #1e293b;
        margin: 0 0 15px 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #1e293b;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2c9a94;
    }

    .error {
        display: block;
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 4px;
    }

    .photo-upload {
        cursor: pointer;
        display: block;
    }

    .photo-box {
        width: 100%;
        aspect-ratio: 1;
        border: 2px dashed #2c9a94;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0fdf4;
        transition: all 0.3s;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .photo-upload:hover .photo-box {
        border-color: #1a7a75;
        background: #ecfdf5;
    }

    .photo-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        color: #2c9a94;
        text-align: center;
    }

    .photo-placeholder span:first-child {
        font-size: 2.5rem;
    }

    .photo-placeholder span:last-child {
        font-weight: 600;
    }

    .photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-hint {
        text-align: center;
        color: #94a3b8;
        font-size: 0.85rem;
        margin: 0 0 15px 0;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        flex: 1;
        min-width: 120px;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-primary {
        background: #2c9a94;
        color: white;
    }

    .btn-primary:hover {
        background: #1a7a75;
    }

    .btn-secondary {
        background: white;
        color: #2c9a94;
        border: 2px solid #2c9a94;
    }

    .btn-secondary:hover {
        background: #f0fdf4;
    }

    @media (max-width: 768px) {
        .edit-card {
            padding: 20px;
        }

        .edit-card h1 {
            font-size: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            min-width: auto;
        }
    }

    @media (max-width: 480px) {
        .edit-page {
            padding: 15px;
        }

        .edit-card {
            padding: 15px;
        }

        .edit-card h1 {
            font-size: 1.3rem;
        }

        .form-group input,
        .form-group textarea {
            padding: 8px 10px;
            font-size: 16px;
        }

        .photo-placeholder span:first-child {
            font-size: 2rem;
        }
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
                }
                const img = document.createElement('img');
                img.src = event.target.result;
                preview.innerHTML = '';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
