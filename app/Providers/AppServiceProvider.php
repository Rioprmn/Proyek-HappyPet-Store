<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Pastikan dua baris ini ada di paling atas!
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Taruh kodenya di sini
        View::composer('*', function ($view) {
            $view->with('globalCategories', Category::all());
        });
    }
}