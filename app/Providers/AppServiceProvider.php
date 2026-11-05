<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use App\Models\Jurnal;
use App\Models\AlasanKeterlambatan;

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
        // Pagination Bootstrap 5
        Paginator::useBootstrapFive();

        // HTTPS hanya untuk production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // ==========================================
        // NOTIFIKASI SIDEBAR PEMBIMBING
        // ==========================================

        View::composer('layouts.app', function ($view) {

            // Default notifikasi
            $jumlahJurnalPending = 0;
            $jumlahTerlambatPending = 0;
            $jumlahIzinPending = 0;

            // Hanya hitung jika user adalah pembimbing
            if (Auth::check() && Auth::user()->role === 'pembimbing') {

                // 1. JURNAL YANG BELUM DINILAI
                $jumlahJurnalPending = Jurnal::whereNull('nilai')
                    ->count();

                // 2. ALASAN KETERLAMBATAN YANG BELUM DITINDAKLANJUTI
                $jumlahTerlambatPending = AlasanKeterlambatan::where(function ($query) {
                    $query->whereNull('status')
                        ->orWhere('status', 'Menunggu');
                })->count();

                // 3. IZIN SISWA YANG MASIH MENUNGGU
                $jumlahIzinPending = Izin::where('status', 'Menunggu')
                    ->count();
            }

            // Kirim variabel ke sidebar
            $view->with([
                'jumlahJurnalPending' => $jumlahJurnalPending,
                'jumlahTerlambatPending' => $jumlahTerlambatPending,
                'jumlahIzinPending' => $jumlahIzinPending,
            ]);
        });
    }
}