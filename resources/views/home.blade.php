@extends('layouts.app')

@section('content')

<section class="hero">
    <div class="container">
        <h1>Everything Your Pet Needs in One Place</h1>
        <p>HappyPet Store menyediakan makanan, aksesoris, dan perlengkapan terbaik untuk hewan kesayangan Anda.</p>
        <a href="#" class="btn-primary">Shop Now</a>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="container">
        <h2>Shop by Category</h2>

        <div class="category-list">
            <div class="category-card">
                <span>🐶</span>
                <h3>Dog</h3>
            </div>

            <div class="category-card">
                <span>🐱</span>
                <h3>Cat</h3>
            </div>

            <div class="category-card">
                <span>🧸</span>
                <h3>Accessories</h3>
            </div>

            <div class="category-card">
                <span>💊</span>
                <h3>Vitamins</h3>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <h2>Featured Products</h2>

        <div class="product-list">
            <div class="product-card">
                <div class="product-image">🐶</div>
                <h3>Dog Food Premium</h3>
                <p class="price">Rp 120.000</p>
                <a href="#" class="btn-secondary">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-image">🐱</div>
                <h3>Cat Food Healthy</h3>
                <p class="price">Rp 95.000</p>
                <a href="#" class="btn-secondary">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-image">🧸</div>
                <h3>Pet Toy Ball</h3>
                <p class="price">Rp 45.000</p>
                <a href="#" class="btn-secondary">Add to Cart</a>
            </div>

            <div class="product-card">
                <div class="product-image">💊</div>
                <h3>Pet Vitamins</h3>
                <p class="price">Rp 60.000</p>
                <a href="#" class="btn-secondary">Add to Cart</a>
            </div>
        </div>
    </div>
</section>


@endsection
