@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 0;">
    <div style="display: flex; gap: 50px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        {{-- Bagian Gambar --}}
        <div style="flex: 1;">
            <img src="{{ asset('assets/img/products/' . ($product->image ?? 'default.png')) }}" 
                 alt="{{ $product->name }}" 
                 style="width: 100%; border-radius: 15px; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
        </div>

        {{-- Bagian Informasi --}}
        <div style="flex: 1;">
            <nav style="margin-bottom: 20px; color: #888; font-size: 0.9rem;">
                {{-- Link Breadcrumb diganti ke Teal --}}
                <a href="/shop" style="text-decoration: none; color: #2c9a94; font-weight: 500;">Shop</a> / {{ $product->category }}
            </nav>
            
            <h1 style="font-size: 2.5rem; color: #333; margin-bottom: 10px;">{{ $product->name }}</h1>
            {{-- Warna Harga diganti ke Teal --}}
            <h2 style="color: #2c9a94; font-size: 2rem; margin-bottom: 20px; font-weight: 700;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </h2>
            
            <div style="background: #f9f9f9; padding: 25px; border-radius: 12px; margin-bottom: 20px; border-left: 4px solid #2c9a94;">
                <h4 style="margin-bottom: 10px; color: #444;">Deskripsi Produk:</h4>
                <p style="line-height: 1.7; color: #666; margin: 0;">{{ $product->description }}</p>
            </div>

            <p style="color: #555;"><strong>Stok:</strong> {{ $product->stock }} tersedia</p>

            <form action="/cart/add" method="POST" style="margin-top: 30px;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div style="display: flex; gap: 12px;">
                    {{-- Input Quantity --}}
                    <input type="number" name="quantity" value="1" min="1" 
                           style="width: 70px; padding: 12px; border-radius: 8px; border: 1px solid #ddd; text-align: center; outline: none; transition: 0.3s;"
                           onfocus="this.style.borderColor='#2c9a94'">
                    
                    {{-- Tombol Add to Cart diganti ke Teal --}}
                    <button type="submit" 
                            style="flex: 1; background: #2c9a94; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;"
                            onmouseover="this.style.backgroundColor='#237a75'; this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.backgroundColor='#2c9a94'; this.style.transform='translateY(0)'">
                        🛒 Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection