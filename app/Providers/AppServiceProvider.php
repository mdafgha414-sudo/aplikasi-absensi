<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request; // Tambahan

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

        // 2. PAKSA HTTPS DI SEMUA KONDISI (Solusi Mixed Content)
        // Ini akan memaksa semua URL yang di-generate Laravel (termasuk route fetch) menjadi https://
        URL::forceScheme('https');

        // 3. Paksa Laravel menganggap semua request adalah secure (https)
        // Ini penting agar session/cookie tidak diblokir browser
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $_SERVER['HTTPS'] = 'on';
        }
    }
}