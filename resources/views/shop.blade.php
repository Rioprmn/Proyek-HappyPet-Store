@extends('layouts.app')

@section('title', 'Shop')


@section('content')

<main class="shop-container">

  <section class="shop-header">
    <h2>Our Products</h2>

    <select class="sort-dropdown">
      <option>Sort by</option>
      <option>Price: Low to High</option>
      <option>Price: High to Low</option>
      <option>Name: A - Z</option>
    </select>
  </section>

  <section class="product-grid">

    <article class="product-card">
      <img src="https://placehold.co/300x200" alt="Cat Food">
      <h3>Cat Food Premium</h3>
      <p class="price">Rp 120.000</p>
      <button>Add to Cart</button>
    </article>

    <article class="product-card">
      <img src="https://placehold.co/300x200" alt="Dog Toy">
      <h3>Dog Chew Toy</h3>
      <p class="price">Rp 75.000</p>
      <button>Add to Cart</button>
    </article>

    <article class="product-card">
      <img src="https://placehold.co/300x200" alt="Vitamins">
      <h3>Pet Vitamins</h3>
      <p class="price">Rp 95.000</p>
      <button>Add to Cart</button>
    </article>

  </section>

</main>

@endsection
