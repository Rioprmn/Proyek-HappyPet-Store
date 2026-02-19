<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/shop', [ProductController::class, 'index']);
Route::get('/shop/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/contact', function () {
    return view('contact');
});


// Grouping route admin
Route::prefix('admin')->group(function () {
    // Halaman Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // --- Bagian Produk ---
    Route::get('/products', [AdminController::class, 'productList'])->name('admin.product.list');
    Route::get('/products/add', [AdminController::class, 'create'])->name('admin.product.add');
    Route::post('/products/store', [AdminController::class, 'store'])->name('admin.product.store');
    
    // Tambahkan ini agar kamu bisa Edit & Hapus Produk
    Route::get('/products/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
    Route::put('/products/update/{id}', [AdminController::class, 'update'])->name('admin.product.update');
    Route::delete('/products/delete/{id}', [AdminController::class, 'destroy'])->name('admin.product.delete');

    // --- Bagian Kategori ---
    Route::get('/categories', [AdminController::class, 'categoryList'])->name('admin.category.list');
    Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('admin.category.store');
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDelete'])->name('admin.category.delete');
});