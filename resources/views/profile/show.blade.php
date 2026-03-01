@extends('layouts.app')

@section('content')
<div class="profile-hero">
    <div class="profile-hero-content">
        <h1 class="profile-hero-title">👤 Profil Saya</h1>
        <p class="profile-hero-subtitle">Kelola informasi akun dan data pribadi Anda</p>
    </div>
    <div class="profile-hero-pattern"></div>
</div>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-photo-wrapper">
                @if($user->profile_photo)
                    <img src="{{ asset('assets/img/profiles/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="profile-photo">
                @else
                    <div class="profile-photo-placeholder">👤</div>
                @endif
            </div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-email">{{ $user->email }}</p>
        </div>

        <div class="profile-body">
            <div class="profile-section">
                <h3 class="section-header">Informasi Pribadi</h3>
                
                <div class="profile-item">
                    <div class="item-icon">📧</div>
                    <div class="item-content">
                        <div class="item-label">Email</div>
                        <div class="item-value">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="item-icon">📱</div>
                    <div class="item-content">
                        <div class="item-label">No. Telepon</div>
                        <div class="item-value {{ $user->phone ? '' : 'empty' }}">
                            {{ $user->phone ?? 'Belum diisi' }}
                        </div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="item-icon">📍</div>
                    <div class="item-content">
                        <div class="item-label">Alamat Lengkap</div>
                        <div class="item-value {{ $user->address ? '' : 'empty' }}">
                            {{ $user->address ?? 'Belum diisi' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h3 class="section-header">Informasi Akun</h3>
                
                <div class="profile-item">
                    <div class="item-icon">👥</div>
                    <div class="item-content">
                        <div class="item-label">Role</div>
                        <div class="item-value">
                            <span class="role-badge {{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="profile-item">
                    <div class="item-icon">📅</div>
                    <div class="item-content">
                        <div class="item-label">Terdaftar Sejak</div>
                        <div class="item-value">{{ $user->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="btn-edit">✏️ Edit Profile</a>
                <a href="{{ route('order.history') }}" class="btn-orders">📦 Riwayat Pesanan</a>
            </div>
        </div>
    </div>
</div>
@endsection
