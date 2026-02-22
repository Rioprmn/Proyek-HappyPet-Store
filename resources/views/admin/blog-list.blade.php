@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="margin: 0; color: #1e293b; font-weight: 700;">Manajemen Blog</h1>
        <p style="color: #64748b; margin: 5px 0 0 0;">Kelola semua artikel edukasi HappyPet di sini.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" 
       style="background: #2c9a94; color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 10px rgba(44, 154, 148, 0.2); transition: 0.3s;">
        + Tambah Artikel
    </a>
</div>

<div style="background: white; padding: 10px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #f1f5f9;">
                <th style="padding: 15px; color: #475569; font-weight: 600;">Gambar</th>
                <th style="padding: 15px; color: #475569; font-weight: 600;">Judul Artikel</th>
                <th style="padding: 15px; color: #475569; font-weight: 600;">Kategori</th>
                <th style="padding: 15px; color: #475569; font-weight: 600; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr style="border-bottom: 1px solid #f1f5f9; transition: 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <td style="padding: 15px;">
                    @if($post->image)
                        <img src="{{ asset('assets/img/blog/'.$post->image) }}" alt="thumb" 
                             style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                    @else
                        <div style="width: 70px; height: 50px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px;">No Image</div>
                    @endif
                </td>
                <td style="padding: 15px;">
                    <div style="font-weight: 600; color: #1e293b;">{{ $post->title }}</div>
                    <small style="color: #94a3b8;">{{ $post->created_at->format('d M Y') }}</small>
                </td>
                <td style="padding: 15px;">
                    <span style="background: #f1f5f9; color: #2c9a94; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid rgba(44, 154, 148, 0.1);">
                        {{ $post->category->name ?? 'Uncategorized' }}
                    </span>
                </td>
                <td style="padding: 15px; text-align: center;">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.blog.edit', $post->id) }}" 
                           style="background: #eff6ff; color: #2563eb; padding: 8px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; border: 1px solid #dbeafe;">
                            ✏️ Edit
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.blog.delete', $post->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background: #fff1f2; color: #e11d48; padding: 8px 12px; border-radius: 8px; border: 1px solid #fecdd3; font-size: 13px; font-weight: 600; cursor: pointer;">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 50px; color: #94a3b8;">
                    <div style="font-size: 40px; margin-bottom: 10px;">✍️</div>
                    <p style="margin: 0;">Belum ada artikel. Yuk tulis edukasi pertamamu!</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection