<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class ScanKartuController extends Controller
{
    public function index()
    {
        return view('pembimbing.scan-kartu'); 
    }

    // 1. FUNGSI CEK DATA (Dijalankan saat QR ter-scan)
    public function cekKartu(Request $request)
    {
        $request->validate(['kode_kartu' => 'required|string']);

        $siswa = User::where('kode_kartu', $request->kode_kartu)->first();

        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Kartu tidak dikenali!'], 404);
        }

        $hariIni = Carbon::today()->toDateString();
        $absen = Absensi::where('user_id', $siswa->id)->where('tanggal', $hariIni)->first();

        // Tentukan tipe absen apa yang akan dilakukan
        $tipeAbsen = 'Masuk';
        if ($absen) {
            if ($absen->jam_pulang == null) {
                $tipeAbsen = 'Pulang';
            } else {
                return response()->json([
                    'status' => 'error', 
                    'message' => '⚠️ ' . $siswa->name . ' sudah absen masuk & pulang hari ini.'
                ], 400);
            }
        }

        // Kembalikan data siswa ke frontend (tidak disimpan dulu)
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $siswa->id,
                'nama' => $siswa->name,
                'kode' => $siswa->kode_kartu,
                'tipe_absen' => $tipeAbsen
            ]
        ]);
    }

    // 2. FUNGSI SIMPAN (Dijalankan setelah Pembimbing klik "Konfirmasi")
    public function simpanAbsen(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipe_absen' => 'required|in:Masuk,Pulang'
        ]);

        $siswa = User::findOrFail($request->user_id);
        $hariIni = Carbon::today()->toDateString();
        $sekarang = Carbon::now();

        if ($request->tipe_absen === 'Masuk') {
            // Logika Absen Masuk
            $batasTelat = Carbon::today()->setTimeFromTimeString('09:00'); 
            $statusAbsen = $sekarang->lte($batasTelat) ? 'Tepat Waktu' : 'Telat';

            Absensi::create([
                'user_id' => $siswa->id,
                'tanggal' => $hariIni,
                'jam_masuk' => $sekarang->toTimeString(),
                'status' => $statusAbsen,
            ]);
            $msg = '✅ Masuk: ' . $siswa->name . ' (' . $statusAbsen . ')';
        } else {
            // Logika Absen Pulang
            $absen = Absensi::where('user_id', $siswa->id)->where('tanggal', $hariIni)->first();
            if($absen) {
                $absen->update(['jam_pulang' => $sekarang->toTimeString()]);
            }
            $msg = '👋 Pulang: ' . $siswa->name . ' pada ' . $sekarang->format('H:i');
        }

        return response()->json(['status' => 'success', 'message' => $msg]);
    }
}