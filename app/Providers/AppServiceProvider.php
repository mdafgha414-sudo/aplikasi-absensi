<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // 1. Gunakan Bootstrap 5 untuk Pagination
        Paginator::useBootstrapFive();

        // 2. Paksa HTTPS HANYA JIKA di server Production (Railway)
        // Jangan paksa HTTPS di localhost agar tidak error "Unsupported SSL request"
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}