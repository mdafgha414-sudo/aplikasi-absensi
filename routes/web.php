
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\IzinController;

// Halaman utama
Route::get('/', function () {
    return redirect('/login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Semua halaman setelah login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Isi Absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])
        ->name('absensi.index');

    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])
        ->name('absensi.masuk');

    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])
        ->name('absensi.pulang');

    // Riwayat Absensi
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat'])
        ->name('absensi.riwayat');

    // Jurnal Harian PKL
    Route::get('/jurnal', [JurnalController::class, 'index'])
        ->name('jurnal.index');

    Route::post('/jurnal', [JurnalController::class, 'store'])
        ->name('jurnal.store');

    // Pengajuan Izin
    Route::get('/izin', [IzinController::class, 'index'])
        ->name('izin.index');

    Route::post('/izin', [IzinController::class, 'store'])
        ->name('izin.store');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
