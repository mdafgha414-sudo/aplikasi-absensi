<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;

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

        // 2. Paksa HTTPS hanya di server Production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // 3. NOTIFIKASI IZIN SISWA PEMBIMBING
        // Menghitung izin yang masih menunggu persetujuan
        // dan menyediakan jumlahnya ke seluruh halaman Blade.

        View::composer('*', function ($view) {

            $jumlahIzinPending = 0;

            if (Auth::check() && Auth::user()->role === 'pembimbing') {

                $jumlahIzinPending = Izin::where('status', 'Menunggu')
                    ->count();

            }

            $view->with('jumlahIzinPending', $jumlahIzinPending);

        });
    }
}