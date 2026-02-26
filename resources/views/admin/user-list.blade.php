@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-user.css') }}">
@endpush

@section('content')
<div class="user-header">
    <div class="header-content">
        <div>
            <h1 class="user-title">👥 Manajemen User</h1>
            <p class="user-subtitle">Total {{ $users->count() }} user terdaftar</p>
        </div>
        <a href="{{ route('admin.user.add') }}" class="btn-add-user">
            <span>+</span> Tambah User
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="filter-section">
    <form action="{{ route('admin.user.list') }}" method="GET" class="filter-form">
        
        <div class="filter-group">
            <label class="filter-label">🔍 Filter:</label>
            <select name="role" onchange="this.form.submit()" class="filter-select">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">📊 Urutkan:</label>
            <select name="sort" onchange="this.form.submit()" class="filter-select">
                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="email" {{ $sort == 'email' ? 'selected' : '' }}>Email</option>
                <option value="role" {{ $sort == 'role' ? 'selected' : '' }}>Role</option>
                <option value="date" {{ $sort == 'date' ? 'selected' : '' }}>Tanggal Registrasi</option>
            </select>
        </div>

        <div class="filter-group">
            <select name="direction" onchange="this.form.submit()" class="filter-select">
                <option value="asc" {{ $direction == 'asc' ? 'selected' : '' }}>↑ Ascending</option>
                <option value="desc" {{ $direction == 'desc' ? 'selected' : '' }}>↓ Descending</option>
            </select>
        </div>

        @if(request('role') || $sort != 'name' || $direction != 'asc')
            <a href="{{ route('admin.user.list') }}" class="btn-reset">
                ✕ Reset Filter
            </a>
        @endif
    </form>
</div>

<div class="table-card">
    <div class="table-header">
        <h3 class="table-title">📋 Daftar User</h3>
        <span class="user-count">{{ $users->count() }} user</span>
    </div>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telpon</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="user-row" style="animation-delay: {{ $loop->index * 0.05 }}s">
                        <td>
                            <div class="user-photo">
                                @if($user->photo)
                                    <img src="{{ asset('assets/img/profiles/' . $user->photo) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="photo-placeholder">👤</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="user-name">{{ $user->name }}</span>
                        </td>
                        <td>
                            <span class="user-email">{{ $user->email }}</span>
                        </td>
                        <td>
                            <span class="user-phone">{{ $user->phone ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="role-badge {{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="user-date">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="action-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action btn-edit" title="Edit">
                                    ✎
                                </a>
                                
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">👥</div>
                                <h3>Belum ada user</h3>
                                <p>Mulai tambahkan user pertamamu</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
