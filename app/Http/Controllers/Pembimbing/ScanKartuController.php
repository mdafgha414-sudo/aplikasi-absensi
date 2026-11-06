<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScanKartuController extends Controller
{
    public function index()
    {
        return view('pembimbing.scan-kartu'); 
    }

    // FUNGSI BARU: Gabungan Cek & Simpan (Langsung Proses)
    public function prosesScan(Request $request)
    {
        $request->validate(['kode_kartu' => 'required|string']);

        $user = Auth::user();

        // 1. Cari Siswa
        $siswa = User::where('kode_kartu', $request->kode_kartu)
                     ->where('perusahaan_id', $user->perusahaan_id)
                     ->first();

        if (!$siswa) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Kartu tidak dikenali atau bukan siswa perusahaan Anda!'
            ], 404);
        }

        $hariIni = Carbon::today()->toDateString();
        $sekarang = Carbon::now();
        $absen = Absensi::where('user_id', $siswa->id)->where('tanggal', $hariIni)->first();

        // 2. Logika Penentuan Masuk / Pulang
        if (!$absen) {
            // -- PROSES ABSEN MASUK --
            $batasTelat = Carbon::today()->setTimeFromTimeString('09:00'); 
            $statusAbsen = $sekarang->lte($batasTelat) ? 'Tepat Waktu' : 'Telat';

            Absensi::create([
                'user_id' => $siswa->id,
                'tanggal' => $hariIni,
                'jam_masuk' => $sekarang->toTimeString(),
                'status' => $statusAbsen,
            ]);
            
            return response()->json([
                'status' => 'success', 
                'message' => '✅ Masuk: ' . $siswa->name . ' (' . $statusAbsen . ')'
            ]);

        } elseif ($absen->jam_pulang == null) {
            // -- PROSES ABSEN PULANG --
            $namaHari = strtolower(Carbon::now()->locale('id')->dayName);
            $jamPulang = Setting::where('key', 'jam_pulang_' . $namaHari)->value('value') ?? '16:00';
            $waktuPulang = Carbon::today()->setTimeFromTimeString($jamPulang);

            if ($sekarang->lt($waktuPulang)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Absen pulang hanya dapat dilakukan mulai pukul ' . substr($jamPulang, 0, 5) . '!'
                ], 400);
            }

            $absen->update(['jam_pulang' => $sekarang->toTimeString()]);
            
            return response()->json([
                'status' => 'success', 
                'message' => '👋 Pulang: ' . $siswa->name . ' pada ' . $sekarang->format('H:i')
            ]);

        } else {
            // -- SUDAH ABSEN LENGKAP --
            return response()->json([
                'status' => 'error', 
                'message' => '⚠️ ' . $siswa->name . ' sudah absen masuk & pulang hari ini.'
            ], 400);
        }
    }
}