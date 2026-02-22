@extends('layouts.admin')

@section('content')
<h2>Manajemen Kategori Blog</h2>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    {{-- Form Tambah --}}
    <div style="background: white; padding: 20px; border-radius: 12px;">
        <form action="{{ route('admin.blog.category.store') }}" method="POST">
            @csrf
            <label>Nama Kategori</label>
            <input type="text" name="name" required style="width:100%; margin: 10px 0; padding: 8px;">
            <button type="submit" style="background: #2c9a94; color: white; border: none; padding: 10px; width: 100%; border-radius: 8px;">Tambah</button>
        </form>
    </div>

    {{-- Tabel Daftar --}}
    <div style="background: white; padding: 20px; border-radius: 12px;">
        <table style="width: 100%;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid #eee;">
                    <th>Nama</th>
                    <th>Slug</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->slug }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection