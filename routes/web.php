<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SupplierController;

// --- AUTENTIKASI (PUBLIC) ---
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    return view('landing');
})->name('home');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    return view('landing');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// --- API ROUTES ---
Route::post('/api/chat', [ChatController::class, 'chat']);

// --- HALAMAN YANG BUTUH LOGIN ---
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index'); 
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/shop', [ProductController::class, 'index'])->name('product.index');
    Route::get('/shop/{id}', [ProductController::class, 'show'])->name('product.detail');

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/my-orders', [CheckoutController::class, 'history'])->name('order.history');
});

// --- AREA ADMIN (BACKEND) ---
Route::prefix('admin')->middleware(['auth', 'App\\Http\\Middleware\\IsAdmin'])->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.list');
        Route::get('/add', [UserController::class, 'create'])->name('admin.user.add');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'productList'])->name('admin.product.list');
        Route::get('/add', [AdminController::class, 'create'])->name('admin.product.add');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.product.store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.product.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminController::class, 'categoryList'])->name('admin.category.list');
        Route::post('/store', [AdminController::class, 'categoryStore'])->name('admin.category.store');
        Route::delete('/delete/{id}', [AdminController::class, 'categoryDelete'])->name('admin.category.delete');
    });

    Route::get('/orders', [AdminController::class, 'orderList'])->name('admin.order.list');
    Route::get('/orders/print/{id}', [AdminController::class, 'printReceipt'])->name('admin.order.print');
    Route::post('/orders/verify/{id}', [AdminController::class, 'verifyPayment'])->name('admin.order.verify');
    Route::delete('/orders/{id}', [AdminController::class, 'orderDelete'])->name('admin.order.delete');
    Route::put('/orders/update-status/{id}', [AdminController::class, 'orderUpdateStatus'])->name('admin.order.updateStatus');

    Route::get('/reports', [AdminController::class, 'reportIndex'])->name('admin.report.index');
    Route::get('/reports/download/{period}', [AdminController::class, 'downloadReport'])->name('admin.report.download');
    

    Route::prefix('blog')->group(function () {
        Route::get('/', [AdminController::class, 'blogList'])->name('admin.blog.list');
        Route::get('/create', [AdminController::class, 'blogCreate'])->name('admin.blog.create');
        Route::post('/store', [AdminController::class, 'blogStore'])->name('admin.blog.store');
        Route::get('/edit/{id}', [AdminController::class, 'blogEdit'])->name('admin.blog.edit');
        Route::put('/update/{id}', [AdminController::class, 'blogUpdate'])->name('admin.blog.update');
        Route::delete('/delete/{id}', [AdminController::class, 'blogDestroy'])->name('admin.blog.delete');

        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/categories', [AdminController::class, 'blogCategoryList'])->name('admin.blog.category.list');
        Route::post('/categories/store', [AdminController::class, 'blogCategoryStore'])->name('admin.blog.category.store');
        Route::delete('/categories/destroy/{id}', [AdminController::class, 'blogCategoryDestroy'])->name('admin.blog.category.destroy');
    });
    Route::get('/admin/report/excel/{period}',[AdminController::class, 'exportExcel'])->name('admin.report.excel');

        // --- Supplier Routes ---
        Route::prefix('suppliers')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('admin.suppliers.index');
            Route::get('/create', [SupplierController::class, 'create'])->name('admin.suppliers.create');
            Route::post('/store', [SupplierController::class, 'store'])->name('admin.suppliers.store');
            Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('admin.suppliers.edit');
            Route::put('/update/{id}', [SupplierController::class, 'update'])->name('admin.suppliers.update');
            Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('admin.suppliers.delete');
        });
});
