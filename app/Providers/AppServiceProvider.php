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

            $jumlahJurnalPending = 0;
            $jumlahTerlambatPending = 0;
            $jumlahIzinPending = 0;

            // Hanya hitung jika user adalah pembimbing
            if (Auth::check() && Auth::user()->role === 'pembimbing') {
                $user = Auth::user();

                // 1. JURNAL YANG BELUM DINILAI (FILTER PERUSAHAAN/SEKOLAH)
                $jumlahJurnalPending = Jurnal::whereNull('nilai')
                    ->whereHas('user', function ($q) use ($user) {
                        if ($user->perusahaan_id) {
                            $q->where('perusahaan_id', $user->perusahaan_id);
                        } elseif ($user->sekolah_id) {
                            $q->where('sekolah_id', $user->sekolah_id);
                        }
                    })->count();

                // 2. ALASAN KETERLAMBATAN (FILTER PERUSAHAAN/SEKOLAH)
                $jumlahTerlambatPending = AlasanKeterlambatan::where(function ($query) {
                    $query->whereNull('status')
                          ->orWhere('status', 'Menunggu');
                })
                ->whereHas('user', function ($q) use ($user) {
                    if ($user->perusahaan_id) {
                        $q->where('perusahaan_id', $user->perusahaan_id);
                    } elseif ($user->sekolah_id) {
                        $q->where('sekolah_id', $user->sekolah_id);
                    }
                })->count();

                // 3. IZIN SISWA YANG MASIH MENUNGGU (FILTER PERUSAHAAN/SEKOLAH)
                $jumlahIzinPending = Izin::where('status', 'Menunggu')
                    ->whereHas('user', function ($q) use ($user) {
                        if ($user->perusahaan_id) {
                            $q->where('perusahaan_id', $user->perusahaan_id);
                        } elseif ($user->sekolah_id) {
                            $q->where('sekolah_id', $user->sekolah_id);
                        }
                    })->count();
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