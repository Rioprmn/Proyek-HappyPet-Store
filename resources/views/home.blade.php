@extends('layouts.app')

{{-- Tambahkan ini agar CSS home terpanggil --}}
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
            <a href="/shop?category=dog" class="category-card">
                <span>🐶</span>
                <h3>Dog</h3>
            </a>
            <a href="/shop?category=cat" class="category-card">
                <span>🐱</span>
                <h3>Cat</h3>
            </a>
            <a href="/shop?category=accessories" class="category-card">
                <span>🧸</span>
                <h3>Accessories</h3>
            </a>
            <a href="/shop?category=vitamins" class="category-card">
                <span>💊</span>
                <h3>Vitamins</h3>
            </a>
        </div>
    </div>
</section>

<section class="featured-products">
    <div class="container">
        <h2 style="text-align:center; margin-bottom:40px;">Featured Products</h2>
        <div class="product-list">
            @foreach($featuredProducts as $product)
            <div class="product-card">
                <a href="{{ route('product.detail', $product->id) }}">
                    <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" alt="{{ $product->name }}">
                </a>
                <h3>{{ $product->name }}</h3>
                <p class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <a href="{{ route('product.detail', $product->id) }}" class="btn-view-detail">Lihat Detail</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection