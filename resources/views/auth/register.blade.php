@extends('layouts.app')

@section('content')
<style>
    .auth-container {
        max-width: 400px;
        margin: 60px auto;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .auth-container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    .form-group input:focus {
        outline: none;
        border-color: #27ae60;
        box-shadow: 0 0 5px rgba(39, 174, 96, 0.3);
    }
    .btn-submit {
        width: 100%;
        padding: 10px;
        background-color: #27ae60;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-submit:hover {
        background-color: #229954;
    }
    .auth-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
    }
    .auth-link a {
        color: #27ae60;
        text-decoration: none;
        font-weight: 600;
    }
    .auth-link a:hover {
        text-decoration: underline;
    }
    .error-message {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<div class="auth-container">
    <h2>Daftar Akun</h2>
    
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p style="margin: 5px 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-submit">Daftar</button>
    </form>

    <div class="auth-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
</div>
@endsection
