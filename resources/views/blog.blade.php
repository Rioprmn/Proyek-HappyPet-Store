@extends('layouts.app')

@section('title', 'Blog - HappyPet Store')

@section('content')
<div class="blog-container">
    <h1 class="blog-title">Our Blog</h1>

    <div class="blog-list">
        <div class="blog-card">
            <div class="blog-image">
                <img src="https://placehold.co/600x400?text=Produk+Berkualitas" alt="Tips Produk">
            </div>
            <div class="blog-content">
                <h2 class="blog-card-title">Tips Memilih Produk Berkualitas</h2>
                <p class="blog-card-date">12 Februari 2026</p>
                <p class="blog-card-desc">
                    Pelajari cara memilih produk terbaik dengan kualitas tinggi dan harga yang sesuai kebutuhan kamu.
                </p>
                <a href="#" class="blog-read-more">Read More</a>
            </div>
        </div>

        <div class="blog-card">
            <div class="blog-image">
                <img src="https://placehold.co/600x400?text=Belanja+Aman" alt="Belanja Aman">
            </div>
            <div class="blog-content">
                <h2 class="blog-card-title">Cara Belanja Online yang Aman</h2>
                <p class="blog-card-date">8 Februari 2026</p>
                <p class="blog-card-desc">
                    Belanja online itu praktis, tapi tetap harus aman. Simak tipsnya di artikel ini.
                </p>
                <a href="#" class="blog-read-more">Read More</a>
            </div>
        </div>

        <div class="blog-card">
            <div class="blog-image">
                <img src="https://placehold.co/600x400?text=Rekomendasi+Minggu+Ini" alt="Rekomendasi Produk">
            </div>
            <div class="blog-content">
                <h2 class="blog-card-title">Rekomendasi Produk Favorit Minggu Ini</h2>
                <p class="blog-card-date">1 Februari 2026</p>
                <p class="blog-card-desc">
                    Ini dia produk-produk yang paling banyak diminati pelanggan minggu ini.
                </p>
                <a href="#" class="blog-read-more">Read More</a>
            </div>
        </div>
    </div>
</div>
@endsection