<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi; 
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // 1. Halaman Utama Absen (UNTUK MENAMPILKAN VIEW)
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        
        // Cek apakah user sudah absen hari ini
        $absenHariIni = Absensi::where('user_id', Auth::id())
                                ->where('tanggal', $hariIni)
                                ->first();

        // Tampilkan halaman form absen
        return view('absensi.index', compact('absenHariIni'));
    }

      // 2. Proses Absen Masuk (UNTUK MEMPROSES DATA)
    public function masuk()
    {
        $hariIni = Carbon::today()->toDateString();
        
        $cek = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();
        if ($cek) {
            return back()->with('error', 'Anda sudah absen masuk hari ini!');
        }

        // --- BAGIAN YANG DIUBAH ---
        // Ambil jam masuk dari database settings
        $setting = Setting::where('key', 'jam_masuk')->first();
        $jam = $setting ? $setting->value : '08:00'; // Default 08:00 jika kosong
        $jamMasukKantor = Carbon::createFromTimeString($jam);
        // --------------------------

        $waktuSekarang = Carbon::now();

        // Cek apakah telat
        $statusAbsen = 'Tepat Waktu';
        if ($waktuSekarang->greaterThan($jamMasukKantor)) {
            $statusAbsen = 'Telat';
        }

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        return back()->with('success', 'Absen masuk berhasil! Status Anda: ' . $statusAbsen);
    }
}