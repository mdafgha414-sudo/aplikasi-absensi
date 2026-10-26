<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // ============================================
    // 1. MENAMPILKAN HALAMAN PENGATURAN ADMIN
    // ============================================
    public function index()
    {
        // Mengambil semua pengaturan yang tersimpan.
        $settings = Setting::all();

        // Daftar hari untuk pengaturan jam masuk.
        $daftarHari = [
            'senin',
            'selasa',
            'rabu',
            'kamis',
            'jumat',
            'sabtu',
            'minggu',
        ];

        // Mengambil jam masuk setiap hari dari database.
        // Jika belum ada, gunakan jam default 08:00.
        $jadwalJam = [];

        foreach ($daftarHari as $hari) {
            $key = 'jam_masuk_' . $hari;

            $setting = Setting::where('key', $key)->first();

            $jadwalJam[$hari] = $setting
                ? substr($setting->value, 0, 5)
                : '08:00';
        }

        // Mengirim data ke halaman Blade.
        return view('dashboard.pengaturan', compact(
            'settings',
            'jadwalJam'
        ));
    }

    // ============================================
    // 2. MENYIMPAN JADWAL JAM MASUK MINGGUAN
    // ============================================
    public function update(Request $request)
    {
        // Memastikan seluruh jam menggunakan format HH:MM.
        $request->validate([
            'jam_masuk_senin'  => 'required|date_format:H:i',
            'jam_masuk_selasa' => 'required|date_format:H:i',
            'jam_masuk_rabu'   => 'required|date_format:H:i',
            'jam_masuk_kamis'  => 'required|date_format:H:i',
            'jam_masuk_jumat'  => 'required|date_format:H:i',
            'jam_masuk_sabtu'  => 'required|date_format:H:i',
            'jam_masuk_minggu' => 'required|date_format:H:i',
        ]);

        // Menyimpan jam masing-masing hari ke database.
        $daftarHari = [
            'senin',
            'selasa',
            'rabu',
            'kamis',
            'jumat',
            'sabtu',
            'minggu',
        ];

        foreach ($daftarHari as $hari) {
            Setting::updateOrCreate(
                ['key' => 'jam_masuk_' . $hari],
                ['value' => $request->input('jam_masuk_' . $hari)]
            );
        }

        // Kembali ke halaman pengaturan dengan pesan sukses.
        return back()->with(
            'success',
            'Jadwal jam masuk mingguan berhasil disimpan!'
        );
    }
}
