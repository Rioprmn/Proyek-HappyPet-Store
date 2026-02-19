@extends('layouts.app')

@section('title', 'Shop - HappyPet Store')

@section('content')
<main class="shop-container">
  <section class="shop-header">
    <h2 style="text-align: center; margin-bottom: 20px; font-size: 2rem; color: #1f2937;">Our Products</h2>

    <div class="search-wrapper">
        <form action="/shop" method="GET" class="search-form" style="max-width: 500px; margin: 0 auto 40px;">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="search" placeholder="Cari kebutuhan hewanmu..." class="search-input" value="{{ request('search') }}">
            {{-- Tombol cari sudah menggunakan warna teal di CSS --}}
            <button type="submit" class="search-button">🔍</button>
        </form>
    </div>
  </section>

  <section class="product-grid">
    @forelse($products as $product)
        <article class="product-card">
            <a href="{{ route('product.detail', $product->id) }}">
                <div class="product-image">
                    <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" 
                    alt="{{ $product->name }}" 
                    style="width: 100%; height: 200px; object-fit: contain;">
                </div>
            </a>
            
            <a href="{{ route('product.detail', $product->id) }}" style="text-decoration: none; color: #333;">
                <h3 style="margin: 15px 0 10px; font-size: 1.2rem;">{{ $product->name }}</h3>
            </a>

            {{-- Warna harga sudah diganti ke teal --}}
            <p class="price" style="color: #2c9a94; font-weight: bold; font-size: 1.1rem; margin-bottom: 15px;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
            
            {{-- Tombol detail menggunakan class agar lebih bersih --}}
            <a href="{{ route('product.detail', $product->id) }}" class="view-detail-btn">
               Lihat Detail
            </a>
        </article>
    @empty
        <div class="no-products" style="grid-column: 1/-1; text-align: center; padding: 50px;">
            <p>Maaf, produk tidak ditemukan.</p>
        </div>
    @endforelse
  </section>
</main>
@endsection