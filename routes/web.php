<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes - HappyPet Store
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK (USER SIDE) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// --- HALAMAN PRODUK & BELANJA ---
Route::get('/shop', [ProductController::class, 'index'])->name('product.index');
Route::get('/shop/{id}', [ProductController::class, 'show'])->name('product.detail');

// --- SISTEM KERANJANG (CART) ---
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// --- SISTEM CHECKOUT ---
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// --- AREA ADMIN (BACKEND) ---
Route::prefix('admin')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Produk (CRUD)
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'productList'])->name('admin.product.list');
        Route::get('/add', [AdminController::class, 'create'])->name('admin.product.add');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.product.store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.product.delete');
    });

    // Manajemen Kategori
    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminController::class, 'categoryList'])->name('admin.category.list');
        Route::post('/store', [AdminController::class, 'categoryStore'])->name('admin.category.store');
        Route::delete('/delete/{id}', [AdminController::class, 'categoryDelete'])->name('admin.category.delete');
    });

    // Manajemen Pesanan (Orders)
    Route::get('/orders', [AdminController::class, 'orderList'])->name('admin.order.list');
    Route::delete('/orders/{id}', [AdminController::class, 'orderDelete'])->name('admin.order.delete');
});