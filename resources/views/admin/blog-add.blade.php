@extends('layouts.admin')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="margin: 0; color: #1e293b; font-weight: 700;">Tulis Artikel Baru</h1>
    <p style="color: #64748b;">Berikan edukasi terbaik buat pelanggan HappyPet.</p>
</div>

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        {{-- Kolom Kiri: Konten --}}
        <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1e293b;">Judul Artikel</label>
                <input type="text" name="title" required placeholder="Contoh: 5 Cara Memandikan Kucing" 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1e293b;">Isi Artikel</label>
                <textarea name="content" rows="15" required 
                          style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;"></textarea>
            </div>
        </div>

        {{-- Kolom Kanan: Meta Data --}}
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1e293b;">Kategori</label>
                    <select name="blog_category_id" required style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1e293b;">Thumbnail Gambar</label>
                    <input type="file" name="image" required style="width: 100%;">
                    <small style="color: #94a3b8; display: block; mt-2;">Format: JPG, PNG (Max 2MB)</small>
                </div>

                <button type="submit" style="width: 100%; background: #2c9a94; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700; cursor: pointer;">
                    🚀 Terbitkan Artikel
                </button>
            </div>
        </div>

    </div>
</form>
@endsection