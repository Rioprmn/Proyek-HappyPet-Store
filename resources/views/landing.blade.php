@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endpush

@section('content')
<div class="landing-container">
    <div class="landing-left">
        <h1>HappyPet Store</h1>
        <p>Semua yang dibutuhkan hewan kesayangan Anda ada di sini. Produk berkualitas, harga terjangkau, dan layanan terbaik.</p>
        
        <div class="landing-features">
            <div class="feature-item">
                <div class="feature-icon">🛍️</div>
                <div>
                    <h3>Produk Lengkap</h3>
                    <p>Ribuan pilihan untuk semua jenis hewan peliharaan</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">💰</div>
                <div>
                    <h3>Harga Terbaik</h3>
                    <p>Penawaran menarik dan terjangkau setiap hari</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🚚</div>
                <div>
                    <h3>Pengiriman Cepat</h3>
                    <p>Sampai dengan aman dan tepat waktu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-right">
        <div class="auth-header">
            <h2>Selamat Datang</h2>
            <p>Masuk atau daftar untuk mulai berbelanja</p>
        </div>

        <div class="auth-tabs">
            <button class="auth-tab active" onclick="switchTab('login')">Login</button>
            <button class="auth-tab" onclick="switchTab('register')">Daftar</button>
        </div>

        {{-- Login Form --}}
        <form id="login" class="auth-form active" method="POST" action="{{ route('login') }}">
            @csrf
            
            @if ($errors->any())
                <div class="success-message" style="background: #f8d7da; color: #721c24; border-left-color: #f5c6cb;">
                    @foreach ($errors->all() as $error)
                        <p style="margin: 5px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required>
            </div>

            <button type="submit" class="btn-auth">Masuk</button>

            <div class="auth-link">
                Belum punya akun? <a href="#" onclick="switchTab('register'); return false;">Daftar sekarang</a>
            </div>
        </form>

        {{-- Register Form --}}
        <form id="register" class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            
            @if ($errors->any())
                <div class="success-message" style="background: #f8d7da; color: #721c24; border-left-color: #f5c6cb;">
                    @foreach ($errors->all() as $error)
                        <p style="margin: 5px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="register-name">Nama Lengkap</label>
                <input type="text" id="register-name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" name="password" required>
            </div>

            <div class="form-group">
                <label for="register-password-confirm">Konfirmasi Password</label>
                <input type="password" id="register-password-confirm" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-auth">Daftar</button>

            <div class="auth-link">
                Sudah punya akun? <a href="#" onclick="switchTab('login'); return false;">Masuk di sini</a>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tab) {
        document.querySelectorAll('.auth-form').forEach(form => {
            form.classList.remove('active');
        });
        
        document.querySelectorAll('.auth-tab').forEach(btn => {
            btn.classList.remove('active');
        });
        
        document.getElementById(tab).classList.add('active');
        event.target.classList.add('active');
    }
</script>
@endsection
