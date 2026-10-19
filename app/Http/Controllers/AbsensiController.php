<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi; 
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

        // Tentukan Jam Masuk Kantor (Misal: 08:00)
        $jamMasukKantor = Carbon::createFromTime(8, 0, 0);
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

    // 3. Proses Absen Pulang
    public function pulang()
    {
        $hariIni = Carbon::today()->toDateString();
        
        $absen = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        // Cek apakah sudah absen masuk
        if (!$absen) {
            return back()->with('error', 'Anda belum absen masuk hari ini!');
        }

        // Cek apakah sudah absen pulang
        if ($absen->jam_pulang) {
            return back()->with('error', 'Anda sudah absen pulang hari ini!');
        }
    
        $absen->update([
            'jam_pulang' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Absen pulang berhasil!');
    }

    // 4. Halaman Riwayat Absen
    public function riwayat()
    {
        $riwayat = Absensi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('absensi.riwayat', compact('riwayat'));
    }
}