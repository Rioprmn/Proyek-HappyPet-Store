@extends('layouts.admin')

@section('content')
<h2>Edit Artikel: {{ $post->title }}</h2>

<form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- PENTING: Untuk Update harus pakai PUT --}}
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div style="background: white; padding: 25px; border-radius: 16px;">
            <div style="margin-bottom: 20px;">
                <label>Judul Artikel</label>
                <input type="text" name="title" value="{{ $post->title }}" required style="width: 100%; padding: 12px; border-radius: 10px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label>Isi Artikel</label>
                <textarea name="content" rows="15" required style="width: 100%; padding: 12px; border-radius: 10px;">{{ $post->content }}</textarea>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 16px;">
            <div style="margin-bottom: 20px;">
                <label>Kategori</label>
                <select name="blog_category_id" required style="width: 100%; padding: 12px;">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $post->blog_category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label>Ganti Gambar (Kosongkan jika tidak diubah)</label>
                <input type="file" name="image" style="width: 100%;">
                <img src="{{ asset('assets/img/blog/'.$post->image) }}" width="100%" style="margin-top: 10px; border-radius: 10px;">
            </div>

            <button type="submit" style="width: 100%; background: #2c9a94; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: 700;">
                💾 Simpan Perubahan
            </button>
        </div>
    </div>
</form>
@endsection