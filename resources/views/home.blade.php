@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<section class="hero">
    <div class="container">
        <h1>Everything Your Pet Needs in One Place</h1>
        <p>HappyPet Store menyediakan makanan, aksesoris, dan perlengkapan terbaik untuk hewan kesayangan Anda.</p>
        <a href="/shop" class="btn-main">Shop Now</a>
    </div>
</section>

<section class="categories">
    <div class="container">
        <h2>Shop by Category</h2>
        <div class="category-list">
            @foreach($categories as $category)
            <a href="/shop?category={{ strtolower($category->name) }}" class="category-card">
                {{-- Logika simpel untuk nampilin icon berdasarkan nama kategori --}}
                <span>
                    @if(Str::contains(strtolower($category->name), 'dog')) 🐶 
                    @elseif(Str::contains(strtolower($category->name), 'cat')) 🐱 
                    @elseif(Str::contains(strtolower($category->name), 'food')) 🦴 
                    @elseif(Str::contains(strtolower($category->name), 'acc')) 🧸 
                    @elseif(Str::contains(strtolower($category->name), 'vit')) 💊 
                    @else 🐾 @endif
                </span>
                <h3>{{ $category->name }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="featured-products">
    <div class="container">
        <h2 style="text-align:center; margin-bottom:40px;">Featured Products</h2>
        <div class="product-list">
            @forelse($featuredProducts as $product)
            <div class="product-card">
                <a href="{{ route('product.detail', $product->id) }}">
                    <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" alt="{{ $product->name }}">
                </a>
                <div class="product-info" style="padding: 15px;">
                    <h3>{{ $product->name }}</h3>
                    <p class="category-text" style="font-size: 0.8rem; color: #64748b;">{{ $product->category }}</p>
                    <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ route('product.detail', $product->id) }}" class="btn-view-detail">Lihat Detail</a>
                </div>
            </div>
            @empty
            <p style="text-align: center; width: 100%; color: #94a3b8;">Belum ada produk unggulan.</p>
            @endforelse
        </div>
    </div>
</section>

@endsection