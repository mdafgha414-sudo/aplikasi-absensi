<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHAN

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

        $user = Auth::user(); // Pembimbing yang sedang scan

        // KEAMANAN: Cari siswa berdasarkan kode kartu DAN perusahaan yang sama
        $siswa = User::where('kode_kartu', $request->kode_kartu)
                     ->where('perusahaan_id', $user->perusahaan_id) // <-- FILTER PENTING
                     ->first();

        if (!$siswa) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Kartu tidak dikenali atau bukan siswa perusahaan Anda!'
            ], 404);
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

        // KEAMANAN TAMBAHAN: Pastikan siswa yang disimpan benar-benar milik perusahaan Pembimbing
        if ($siswa->perusahaan_id !== Auth::user()->perusahaan_id) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Anda tidak memiliki akses untuk mencatat absensi siswa ini.'
            ], 403);
        }

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