<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\GuruExportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AlasanKeterlambatanController;

// ==========================================
// ROUTE PUBLIK (Bisa diakses tanpa login)
// ==========================================

// Halaman utama redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Auth (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ==========================================
// ROUTE UNTUK SEMUA USER YANG SUDAH LOGIN (Auth)
// ==========================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (Admin, Guru, Siswa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- FITUR ABSENSI ---
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    
    // Alasan Terlambat
    Route::post('/absensi/alasan-terlambat', [AlasanKeterlambatanController::class, 'simpan'])
        ->name('absensi.alasan.simpan');

    // --- FITUR JURNAL PKL (Siswa) ---
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');

    // --- FITUR IZIN (Siswa) ---
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

    // --- FITUR KHUSUS GURU (Hanya Melihat) ---
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.user_guru');
        })->name('dashboard');

        // Jurnal
        Route::get('/jurnal', [GuruController::class, 'index'])->name('jurnal');
        Route::post('/nilai/{id}', [GuruController::class, 'beriNilai'])->name('nilai');
        
        // Laporan Absensi
        Route::get('/laporan-absensi', [GuruController::class, 'laporanAbsensi'])->name('laporan-absensi');

        // Izin Guru
        Route::get('/izin', [GuruController::class, 'lihatIzin'])->name('izin');
        Route::put('/izin/{id}', [GuruController::class, 'updateIzin'])->name('izin.update');
        
        // Export
        Route::get('/export/excel', [GuruExportController::class, 'excel'])->name('export.excel');
        Route::get('/export/pdf', [GuruExportController::class, 'pdf'])->name('export.pdf');
    });

    // --- FITUR KHUSUS PEMBIMBING PKL (Bisa Menilai & Approve) ---
    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.user_pembimbing');
        })->name('dashboard');

        // Laporan Absensi Pembimbing (Diperbaiki)
        Route::get('/laporan-absensi', [AbsensiController::class, 'laporanAbsensi'])->name('laporan-absensi');

        // Gunakan GuruController
        Route::get('/jurnal', [GuruController::class, 'index'])->name('jurnal');
        Route::post('/nilai/{id}', [GuruController::class, 'beriNilai'])->name('nilai');

        Route::get('/izin', [GuruController::class, 'lihatIzin'])->name('izin');
        Route::put('/izin/{id}', [GuruController::class, 'updateIzin'])->name('izin.update');
    });

}); 


// ==========================================
// ROUTE KHUSUS ADMIN (Auth + isAdmin)
// ==========================================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index']);

    // Manajemen User
    Route::get('/admin/tambah-user', [AdminController::class, 'createUser']);
    Route::post('/admin/tambah-user', [AdminController::class, 'storeUser']);
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser']);
    Route::put('/admin/edit-user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'destroyUser']);
    
    // Pengaturan
    Route::get('/admin/setting', [SettingController::class, 'index']);
    Route::put('/admin/setting', [SettingController::class, 'update']);

});