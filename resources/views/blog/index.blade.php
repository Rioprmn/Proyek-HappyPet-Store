@extends('layouts.app')

@section('title', 'Blog - HappyPet Store')

@section('content')
<div class="blog-container">
    <h1 class="blog-title">Our Blog</h1>

    {{-- Filter & Search --}}
    <div style="margin-bottom: 30px; display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <form action="{{ route('blog.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%; max-width: 500px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." 
                   style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            <button type="submit" style="background: #2c9a94; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Cari</button>
        </form>

        <div style="display: flex; gap: 15px;">
            <a href="{{ route('blog.index') }}" style="text-decoration: none; color: {{ !request('category') ? '#2c9a94' : '#666' }}; font-weight: bold;">Semua</a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                   style="text-decoration: none; color: {{ request('category') == $cat->slug ? '#2c9a94' : '#666' }}; font-weight: bold;">
                   {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="blog-list">
        @forelse($posts as $post)
            <div class="blog-card">
                <div class="blog-image">
                    <img src="{{ $post->image ? asset('assets/img/blog/'.$post->image) : 'https://placehold.co/600x400?text=HappyPet' }}" alt="{{ $post->title }}">
                </div>
                <div class="blog-content">
                    <h2 class="blog-card-title">{{ $post->title }}</h2>
                    <p class="blog-card-date">{{ $post->created_at->format('d F Y') }}</p>
                    <p class="blog-card-desc">
                        {{ Str::limit(strip_tags($post->content), 120) }}
                    </p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-read-more">Read More</a>
                </div>
            </div>
        @empty
            <div style="text-align: center; width: 100%;">
                <p>Belum ada artikel nih, Bang. Tunggu ya!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection