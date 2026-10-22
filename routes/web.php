<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\GuruExportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AlasanKeterlambatanController; // Tambahan import yang kurang

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect('/login');
});

// ==========================================
// ROUTE LOGIN & REGISTER (Bisa diakses tanpa login)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// ==========================================
// ROUTE UNTUK SEMUA USER YANG SUDAH LOGIN
// ==========================================
Route::middleware('auth')->group(function () {
    // Dashboard (Admin, Guru, Siswa)
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Route Absensi
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk']);
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang']);
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat']);
    

    Route::get('/absensi/riwayat', [
        AbsensiController::class,
        'riwayat'
        ])->name('absensi.riwayat');

    // Route Alasan Terlambat (Dipindahkan ke dalam grup auth)
    Route::post('/absensi/alasan-terlambat', [AlasanKeterlambatanController::class, 'simpan'])
        ->name('absensi.alasan.simpan');

    // Route Jurnal Siswa
    Route::get('/jurnal', [JurnalController::class, 'index']);
    Route::post('/jurnal', [JurnalController::class, 'store']);

    // Route Guru (Dashboard & Jurnal)
    Route::get('/guru/dashboard', function () {
        return view('dashboard.user_guru');
    });
    Route::get('/guru/jurnal', [GuruController::class, 'index']);
    Route::post('/guru/nilai/{id}', [GuruController::class, 'beriNilai']);

    // Route Export Guru (Dipindahkan ke dalam grup auth)
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/export/excel', [GuruExportController::class, 'excel'])->name('export.excel');
        Route::get('/export/pdf', [GuruExportController::class, 'pdf'])->name('export.pdf');
    });
});

// ==========================================
// ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    
    // Tambah User
    Route::get('/admin/tambah-user', [AdminController::class, 'createUser']);
    Route::post('/admin/tambah-user', [AdminController::class, 'storeUser']);
    
    // Edit & Hapus User
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser']);
    Route::put('/admin/edit-user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'destroyUser']);
    
    // PENGATURAN
    Route::get('/admin/setting', [SettingController::class, 'index']);
    Route::put('/admin/setting', [SettingController::class, 'update']);
}); // <-- Kurung kurawal penutup grup Admin yang sebelumnya hilang sudah ditambahkan di sini