<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // =====================================================
    // 1. HALAMAN UTAMA ABSENSI
    // Menampilkan halaman absensi dan mengecek absen hari ini.
    // =====================================================
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();

        // Cari absensi milik user yang login untuk hari ini.
        $absenHariIni = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        // Tampilkan halaman utama absensi.
        return view('absensi.index', compact('absenHariIni'));
    }

    // =====================================================
    // 2. PROSES ABSEN MASUK
    // Menyimpan jam masuk dan menentukan status keterlambatan.
    // =====================================================
    public function masuk()
    {
        $hariIni = Carbon::today()->toDateString();

        // Cek apakah user sudah memiliki absensi hari ini.
        $cek = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        if ($cek) {
            return back()->with(
                'error',
                'Anda sudah absen masuk hari ini!'
            );
        }

        // Ambil pengaturan jam masuk dari database.
        $setting = Setting::where('key', 'jam_masuk')->first();

        // Gunakan pukul 08:00 jika pengaturan belum tersedia.
        $jam = $setting ? $setting->value : '08:00';

        $jamMasukKantor = Carbon::createFromTimeString($jam);
        $waktuSekarang = Carbon::now();

        // Tentukan status berdasarkan jam masuk kantor.
        $statusAbsen = 'Tepat Waktu';

        if ($waktuSekarang->format('H:i:s') > $jamMasukKantor->format('H:i:s')) {
            $statusAbsen = 'Telat';
        }

        // Simpan data absensi masuk ke database.
        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        // Kembali ke halaman sebelumnya dengan pesan hasil.
        return back()->with(
            'success',
            'Absen masuk berhasil! Status Anda: ' . $statusAbsen
        );
    }

    // =====================================================
    // 3. RIWAYAT ABSENSI
    // Menampilkan riwayat absensi milik user yang login.
    // =====================================================
    public function riwayat()
    {
        // Ambil data absensi user yang sedang login.
        $riwayat = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        // Kirim variabel $riwayat ke halaman Blade.
        return view('absensi.riwayat', compact('riwayat'));
    }
}
