
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\IzinController;

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');

// Route jurnal
Route::get('/jurnal', [JurnalController::class, 'index'])
    ->middleware('auth');

Route::post('/jurnal', [JurnalController::class, 'store'])
    ->middleware('auth');

// Route pengajuan izin
Route::post('/izin', [IzinController::class, 'store'])
    ->middleware('auth')
    ->name('izin.store');

// Route logout
Route::post('/logout', [AuthController::class, 'logout']);
