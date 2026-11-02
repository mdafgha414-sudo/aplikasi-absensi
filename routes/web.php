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
use App\Http\Controllers\QrAbsensiController;

// ==========================================
// ROUTE PUBLIK
// ==========================================
Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ==========================================
// ROUTE AUTH (Semua Role yang Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- PENGATURAN PROFIL ---
    Route::get('/pengaturan', [SettingController::class, 'profil'])->name('pengaturan');
    Route::put('/pengaturan/update', [SettingController::class, 'updateProfil'])->name('pengaturan.update');

    // --- FITUR SISWA ---
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/masuk', [AbsensiController::class, 'masuk'])->name('absensi.masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    Route::post('/absensi/alasan-terlambat', [AlasanKeterlambatanController::class, 'simpan'])->name('absensi.alasan.simpan');
    
    // FITUR SCAN QR (Siswa)
    Route::get('/absensi/scan', [AbsensiController::class, 'showScan'])->name('absensi.scan');
    Route::post('/absensi/proses-scan', [AbsensiController::class, 'prosesScan'])->name('absensi.proses-scan');
    
    // JURNAL & IZIN SISWA
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

    // --- FITUR KHUSUS GURU ---
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.user_guru');
        })->name('dashboard');

        Route::get('/jurnal', [GuruController::class, 'index'])->name('jurnal');
        Route::post('/nilai/{id}', [GuruController::class, 'beriNilai'])->name('nilai');
        Route::get('/laporan-absensi', [GuruController::class, 'laporanAbsensi'])->name('laporan-absensi');
        
        // IZIN
        Route::get('/izin', [GuruController::class, 'lihatIzin'])->name('izin');
        Route::put('/izin/{id}', [GuruController::class, 'updateIzin'])->name('izin.update');
        
        // ALASAN KETERLAMBATAN (TAMBAHAN BARU)
        Route::get('/alasan-keterlambatan', [AlasanKeterlambatanController::class, 'index'])->name('alasan-keterlambatan');
        Route::put('/alasan-keterlambatan/{id}/terima', [AlasanKeterlambatanController::class, 'terima'])->name('alasan.terima');
        Route::put('/alasan-keterlambatan/{id}/tolak', [AlasanKeterlambatanController::class, 'tolak'])->name('alasan.tolak');

        // EXPORT
        Route::get('/export/excel', [GuruExportController::class, 'excel'])->name('export.excel');
        Route::get('/export/pdf', [GuruExportController::class, 'pdf'])->name('export.pdf');
    });

    // --- FITUR KHUSUS PEMBIMBING PKL ---
    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'dashboardPembimbing'])->name('dashboard');
        Route::get('/laporan-absensi', [GuruController::class, 'laporanAbsensi'])->name('laporan-absensi');
        Route::get('/laporan-absensi/export-excel', [GuruExportController::class, 'exportExcelAbsensi'])->name('laporan.export.excel');
        Route::get('/laporan-absensi/export-pdf', [GuruExportController::class, 'exportPdfAbsensi'])->name('laporan.export.pdf');
        
        Route::get('/jurnal', [GuruController::class, 'index'])->name('jurnal');
        Route::post('/nilai/{id}', [GuruController::class, 'beriNilai'])->name('nilai');

        // IZIN
        Route::get('/izin', [GuruController::class, 'lihatIzin'])->name('izin');
        Route::put('/izin/{id}', [GuruController::class, 'updateIzin'])->name('izin.update');

        // ALASAN KETERLAMBATAN
        Route::get('/alasan-keterlambatan', [AlasanKeterlambatanController::class, 'index'])->name('alasan.index');
        Route::put('/alasan-keterlambatan/{id}/terima', [AlasanKeterlambatanController::class, 'terima'])->name('alasan.terima');
        Route::put('/alasan-keterlambatan/{id}/tolak', [AlasanKeterlambatanController::class, 'tolak'])->name('alasan.tolak');
    });

    // --- FITUR QR ABSENSI (Guru & Pembimbing) ---
    Route::get('/qr-absensi', [QrAbsensiController::class, 'show'])->name('qr.show');
    Route::post('/qr-absensi/generate', [QrAbsensiController::class, 'generate'])->name('qr.generate');
}); 

// ==========================================
// ROUTE ADMIN
// ==========================================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/admin/tambah-user', [AdminController::class, 'createUser']);
    Route::post('/admin/tambah-user', [AdminController::class, 'storeUser']);
    Route::get('/admin/edit-user/{id}', [AdminController::class, 'editUser']);
    Route::put('/admin/edit-user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/hapus-user/{id}', [AdminController::class, 'destroyUser']);
    
    // Pengaturan Jam (Khusus Admin)
    Route::get('/admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    Route::put('/admin/setting', [SettingController::class, 'update'])->name('admin.setting.update');
});