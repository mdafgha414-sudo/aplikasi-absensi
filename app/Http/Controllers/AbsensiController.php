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
        // Mengambil tanggal hari ini.
        $hariIni = Carbon::today()->toDateString();

        // Mencari absensi user yang login untuk hari ini.
        $absenHariIni = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        // Menentukan nama hari dalam bahasa Indonesia.
        $hari = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];

        $nomorHari = Carbon::now()->dayOfWeekIso;
        $namaHari = $hari[$nomorHari];

        // Mengambil batas jam masuk berdasarkan hari ini.
        $keyJam = 'jam_masuk_' . $namaHari;
        $settingJam = Setting::where('key', $keyJam)->first();

        $jamMasukHariIni = $settingJam
            ? substr($settingJam->value, 0, 5)
            : '08:00';

        // Menampilkan halaman absensi beserta jadwal hari ini.
        return view('absensi.index', compact(
            'absenHariIni',
            'jamMasukHariIni'
        ));
    }

   // =====================================================
    // 2. PROSES ABSEN MASUK
    // Jam masuk mengikuti pengaturan admin setiap hari.
    // =====================================================
    public function masuk()
    {
        // Mengambil tanggal hari ini.
        $hariIni = Carbon::today()->toDateString();

        // Cek apakah user sudah absen hari ini.
        $cek = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        if ($cek) {
            return back()->with(
                'error',
                'Anda sudah absen masuk hari ini!'
            );
        }

       // ============================================
        // AMBIL JAM MASUK BERDASARKAN HARI
        // ============================================

        $hari = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];

        // Menentukan hari saat ini.
        $nomorHari = Carbon::now()->dayOfWeekIso;
        $namaHari = $hari[$nomorHari];

        // Mengambil jam masuk khusus hari tersebut.
        $keyJam = 'jam_masuk_' . $namaHari;

        try {
            $setting = Setting::where('key', $keyJam)->first();

            // Jika belum ada pengaturan, gunakan pukul 08:00.
            $jam = $setting ? $setting->value : '08:00';
        } catch (\Exception $e) {
            $jam = '08:00';
        }

        // Mengambil waktu saat ini.
        $waktuSekarang = Carbon::now();

        // Membandingkan waktu dengan batas jam masuk.
        $batasWaktu = Carbon::today()->setTimeFromTimeString($jam);

        // Menentukan status absensi.
        $statusAbsen = $waktuSekarang->lte($batasWaktu)
            ? 'Tepat Waktu'
            : 'Telat';  

        // ============================================
        // AKHIR PENGATURAN JAM MASUK HARIAN
        // ============================================

        // ============================================
        // SIMPAN ABSENSI KE DATABASE
        // ============================================
        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        // Menampilkan pesan hasil absensi.
        return back()->with(
            'success',
            'Absen masuk berhasil! Status Anda: ' . $statusAbsen
        );
    }
    // =====================================================
    // AKHIR PROSES ABSEN MASUK
    // =====================================================

    // =====================================================
    // 3. PROSES ABSEN PULANG (YANG SEBELUMNYA HILANG)
    // Mencatat jam pulang untuk absensi hari ini.
    // =====================================================
    public function pulang()
    {
        $hariIni = Carbon::today()->toDateString();

        // Cari data absensi masuk milik user hari ini
        $absen = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        if (!$absen) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini!');
        }

        if ($absen->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini!');
        }

        // Update jam pulang dengan waktu sekarang
        $absen->update([
            'jam_pulang' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Absen pulang berhasil dicatat. Hati-hati di jalan!');
    }

    // =====================================================
    // 4. RIWAYAT ABSENSI
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