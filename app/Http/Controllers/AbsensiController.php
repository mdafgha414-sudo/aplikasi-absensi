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
    // =====================================================
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();

        $absenHariIni = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

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

        $keyJam = 'jam_masuk_' . $namaHari;
        $settingJam = Setting::where('key', $keyJam)->first();

        $jamMasukHariIni = $settingJam
            ? substr($settingJam->value, 0, 5)
            : '08:00';

        return view('absensi.index', compact(
            'absenHariIni',
            'jamMasukHariIni'
        ));
    }

    // =====================================================
    // 2. PROSES ABSEN MASUK
    // =====================================================
    public function masuk()
    {
        $hariIni = Carbon::today()->toDateString();

        $cek = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        if ($cek) {
            return back()->with(
                'error',
                'Anda sudah absen masuk hari ini!'
            );
        }

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

        $keyJam = 'jam_masuk_' . $namaHari;

        try {
            $setting = Setting::where('key', $keyJam)->first();
            $jam = $setting ? $setting->value : '08:00';
        } catch (\Exception $e) {
            $jam = '08:00';
        }

        $waktuSekarang = Carbon::now();
        $batasWaktu = Carbon::today()->setTimeFromTimeString($jam);

        $statusAbsen = $waktuSekarang->lte($batasWaktu)
            ? 'Tepat Waktu'
            : 'Telat';  

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        return back()->with(
            'success',
            'Absen masuk berhasil! Status Anda: ' . $statusAbsen
        );
    }

    // =====================================================
    // 3. PROSES ABSEN PULANG
    // =====================================================
    public function pulang()
    {
        $hariIni = Carbon::today()->toDateString();

        $absen = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        if (!$absen) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini!');
        }

        if ($absen->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini!');
        }

        $absen->update([
            'jam_pulang' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Absen pulang berhasil dicatat. Hati-hati di jalan!');
    }

    // =====================================================
    // 4. RIWAYAT ABSENSI SISWA
    // =====================================================
    public function riwayat()
    {
        $riwayat = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.riwayat', compact('riwayat'));
    }

    // =====================================================
    // 5. LAPORAN ABSENSI (KHUSUS PEMBIMBING)
    // =====================================================
    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')->latest()->get();

        return view('pembimbing.laporan-absensi', compact('laporanAbsensi'));
    }
}