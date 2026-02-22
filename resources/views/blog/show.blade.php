@extends('layouts.app')

@section('title', $post->title . ' - HappyPet')

@section('content')
<div style="background: #f8fafc; padding: 40px 0;">
    <div style="max-width: 850px; margin: 0 auto; padding: 0 20px;">
        
        {{-- Navigasi Balik --}}
        <div style="margin-bottom: 25px;">
            <a href="{{ route('blog.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                ← Kembali ke Blog
            </a>
        </div>
        
        {{-- Header Artikel --}}
        <header style="margin-bottom: 35px; text-align: left;">
            <span style="color: #2c9a94; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">
                {{ $post->category->name }}
            </span>
            <h1 style="font-size: clamp(1.8rem, 5vw, 2.8rem); color: #1e293b; margin: 15px 0; line-height: 1.2; font-weight: 800; letter-spacing: -0.02em;">
                {{ $post->title }}
            </h1>
            <div style="color: #94a3b8; font-size: 15px; font-weight: 500;">
                📅 {{ $post->created_at->format('d F Y') }}
            </div>
        </header>

        {{-- Gambar Utama --}}
        <div style="margin-bottom: 40px;">
            <img src="{{ $post->image ? asset('assets/img/blog/'.$post->image) : 'https://placehold.co/1200x600?text=HappyPet+Journal' }}" 
                 style="width: 100%; height: auto; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.08);">
        </div>

        {{-- Konten Utama --}}
        <article style="background: white; padding: 40px; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
            <div style="line-height: 1.8; color: #334155; font-size: 1.1rem; white-space: pre-line; font-family: 'Inter', system-ui, sans-serif;">
                {!! $post->content !!}
            </div>

            <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #f1f5f9; text-align: center;">
                <a href="{{ route('blog.index') }}" style="display: inline-block; background: #2c9a94; color: white; padding: 14px 30px; border-radius: 12px; text-decoration: none; font-weight: 700; transition: 0.3s;">
                    Lihat Artikel Lainnya
                </a>
            </div>
        </article>
    </div>
</div>
@endsection