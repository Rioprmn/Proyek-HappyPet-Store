@extends('layouts.app')

@section('content')
<div class="profile-page">
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->profile_photo)
                <img src="{{ asset('assets/img/profiles/' . $user->profile_photo) }}" alt="{{ $user->name }}">
            @else
                <div class="avatar-placeholder">👤</div>
            @endif
        </div>
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <p>{{ $user->email }}</p>
            <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-section">
            <h2>📋 Informasi Pribadi</h2>
            <div class="info-grid">
                <div class="info-box">
                    <label>Email</label>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="info-box">
                    <label>No. Telepon</label>
                    <p>{{ $user->phone ?? 'Belum diisi' }}</p>
                </div>
                <div class="info-box">
                    <label>Alamat</label>
                    <p>{{ $user->address ?? 'Belum diisi' }}</p>
                </div>
                <div class="info-box">
                    <label>Terdaftar Sejak</label>
                    <p>{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="profile-actions">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">✏️ Edit Profil</a>
            <a href="{{ route('order.history') }}" class="btn btn-secondary">📦 Riwayat Pesanan</a>
        </div>
    </div>
</div>

<style>
    .profile-page {
        background: #f8fafc;
        min-height: 100vh;
        padding: 20px;
    }

    .profile-header {
        background: white;
        padding: 40px 20px;
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 20px;
        border: 4px solid #2c9a94;
        overflow: hidden;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        font-size: 3rem;
    }

    .profile-info h1 {
        font-size: 1.8rem;
        color: #1e293b;
        margin: 0 0 5px 0;
    }

    .profile-info p {
        color: #64748b;
        margin: 0 0 15px 0;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-user {
        background: #dbeafe;
        color: #1e40af;
    }

    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .profile-section {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .profile-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin: 0 0 20px 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-box {
        padding: 15px;
        background: #f8fafc;
        border-radius: 8px;
        border-left: 4px solid #2c9a94;
    }

    .info-box label {
        display: block;
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-box p {
        color: #1e293b;
        margin: 0;
        font-weight: 500;
    }

    .profile-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #2c9a94;
        color: white;
    }

    .btn-primary:hover {
        background: #1a7a75;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 154, 148, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #2c9a94;
        border: 2px solid #2c9a94;
    }

    .btn-secondary:hover {
        background: #f0fdf4;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .profile-header {
            padding: 30px 20px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
        }

        .profile-info h1 {
            font-size: 1.5rem;
        }

        .profile-section {
            padding: 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .profile-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .profile-page {
            padding: 15px;
        }

        .profile-header {
            padding: 20px 15px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .avatar-placeholder {
            font-size: 2.5rem;
        }

        .profile-info h1 {
            font-size: 1.3rem;
        }

        .profile-section {
            padding: 15px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
</style>
@endsection
