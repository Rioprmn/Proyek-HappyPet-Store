@extends('layouts.admin')

@section('content')
<div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
    <div>
        <h1 style="margin: 0; color: #1e293b; font-weight: 800; letter-spacing: -0.025em;">Manajemen User</h1>
        <p style="color: #64748b; margin-top: 5px;">Total {{ $users->count() }} user terdaftar.</p>
    </div>
    
    <a href="{{ route('admin.user.add') }}" style="background: #2c9a94; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(44, 154, 148, 0.3); transition: 0.3s; display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 1.2rem;">+</span> Tambah User
    </a>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 10px;">
        <span>✅</span> {{ session('success') }}
    </div>
@endif

{{-- Filter & Sort Section --}}
<div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
    <form action="{{ route('admin.user.list') }}" method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        
        {{-- Filter by Role --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <label style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">Filter:</label>
            <select name="role" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #475569; font-size: 0.85rem; outline: none; cursor: pointer;">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        {{-- Sort Options --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <label style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">Urutkan:</label>
            <select name="sort" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #475569; font-size: 0.85rem; outline: none; cursor: pointer;">
                <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                <option value="email" {{ $sort == 'email' ? 'selected' : '' }}>Email</option>
                <option value="role" {{ $sort == 'role' ? 'selected' : '' }}>Role</option>
                <option value="date" {{ $sort == 'date' ? 'selected' : '' }}>Tanggal Registrasi</option>
            </select>
        </div>

        {{-- Sort Direction --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <select name="direction" onchange="this.form.submit()" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; color: #475569; font-size: 0.85rem; outline: none; cursor: pointer;">
                <option value="asc" {{ $direction == 'asc' ? 'selected' : '' }}>↑ Ascending</option>
                <option value="desc" {{ $direction == 'desc' ? 'selected' : '' }}>↓ Descending</option>
            </select>
        </div>

        {{-- Reset Filter --}}
        @if(request('role') || $sort != 'name' || $direction != 'asc')
            <a href="{{ route('admin.user.list') }}" style="text-decoration: none; color: #ef4444; font-size: 0.85rem; display: flex; align-items: center; font-weight: 500;">
                ✕ Reset Filter
            </a>
        @endif
    </form>
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
                <tr>
                    <td>
                        @if($user->photo)
                            <img src="{{ asset('assets/img/profiles/' . $user->photo) }}" alt="{{ $user->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; {{ $user->role === 'admin' ? 'background: #fee2e2; color: #991b1b;' : 'background: #dbeafe; color: #1e40af;' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="color: #64748b; font-size: 0.9rem;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="text-align: right; padding-right: 20px;">
                        <div class="action-buttons" style="display: flex; justify-content: flex-end; gap: 10px;">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action btn-edit-new" title="Edit">
                                ✎
                            </a>
                            
                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete-new" title="Hapus">
                                    🗑
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 80px 0;">
                        <div style="font-size: 3rem; margin-bottom: 10px;">👥</div>
                        <h3 style="color: #64748b; margin-bottom: 5px;">Belum ada user</h3>
                        <p style="color: #94a3b8;">Mulai tambahkan user pertamamu.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
