@extends('layouts.admin')

@section('content')
<div style="padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="color: #1e293b; font-weight: 700; margin: 0;">Kategori Blog</h1>
        <p style="color: #64748b; margin-top: 5px;">Kelola kategori edukasi untuk HappyPet.</p>
    </div>

    <div style="display: grid; grid-template-columns: 350px 1fr; gap: 25px; align-items: start;">
        
        {{-- BAGIAN FORM --}}
        <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0; margin-bottom: 20px; color: #1e293b; font-size: 18px;">Tambah Baru</h3>
            <form action="{{ route('admin.blog.category.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px;">Nama Kategori</label>
                    <input type="text" name="name" required placeholder="Contoh: Perawatan Kucing" 
                           style="width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; outline: none; box-sizing: border-box;">
                </div>
                <button type="submit" style="width: 100%; background: #2c9a94; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 15px;">
                    ➕ Simpan Kategori
                </button>
            </form>
        </div>

        {{-- BAGIAN TABEL --}}
        <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 18px; color: #475569; font-weight: 600; border-bottom: 2px solid #f1f5f9;">Nama Kategori</th>
                        <th style="padding: 18px; color: #475569; font-weight: 600; border-bottom: 2px solid #f1f5f9;">Slug</th>
                        <th style="padding: 18px; color: #475569; font-weight: 600; border-bottom: 2px solid #f1f5f9; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 18px; font-weight: 600; color: #1e293b;">{{ $cat->name }}</td>
                        <td style="padding: 18px;">
                            <span style="background: #f1f5f9; color: #64748b; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-family: monospace;">
                                {{ $cat->slug }}
                            </span>
                        </td>
                        <td style="padding: 18px; text-align: center;">
                            <form action="{{ route('admin.blog.category.destroy', $cat->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 50px; text-align: center; color: #94a3b8;">
                            <div style="font-size: 40px; margin-bottom: 10px;">📂</div>
                            Belum ada kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection