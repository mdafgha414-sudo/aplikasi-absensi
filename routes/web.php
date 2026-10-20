<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController; // Tambahkan use ini di atas
use App\Http\Controllers\GuruController; // <-- Tambahkan baris ini
use App\Http\Controllers\JurnalController; // Tambahkan ini di atas

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route Login (GET = tampil form, POST = proses)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route Dashboard (Hanya bisa diakses jika sudah login)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
// Route Logout
Route::post('/logout', [AuthController::class, 'logout']);

// Route Absensi (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk']);
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang']);
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat']);
});

// Route Dashboard (Bisa diakses Admin & User)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Route Khusus Admin (Dilindungi oleh middleware isAdmin)
Route::get('/admin/dashboard', [AdminController::class, 'index'])
     ->middleware(['auth', 'isAdmin']);

     // Tambahkan dua baris ini:
Route::get('/admin/tambah-user', [AdminController::class, 'createUser'])->middleware(['auth', 'isAdmin']);
Route::post('/admin/tambah-user', [AdminController::class, 'storeUser'])->middleware(['auth', 'isAdmin']);
// Route Edit & Hapus Karyawan
Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser'])->middleware(['auth', 'isAdmin']);
Route::put('/admin/edit-user/{id}', [AdminController::class, 'updateUser'])->middleware(['auth', 'isAdmin']);
Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'destroyUser'])->middleware(['auth', 'isAdmin']);

   // --- TAMBAHKAN ROUTE GURU DI SINI ---
    Route::get('/guru/dashboard', function () {
        return view('dashboard.user_guru');
    });
    
    Route::get('/guru/jurnal', [GuruController::class, 'index']);
    Route::post('/guru/nilai/{id}', [GuruController::class, 'beriNilai']);

      // Route Jurnal Siswa
    Route::get('/jurnal', [JurnalController::class, 'index']);
    Route::post('/jurnal', [JurnalController::class, 'store']);