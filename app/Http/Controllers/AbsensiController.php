<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Setting;
use App\Models\QrToken;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // =====================================================
    // FUNGSI BANTU: MENGAMBIL JADWAL HARI INI
    // =====================================================
    private function jadwalHariIni()
    {
        $hari = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];

        $namaHari = $hari[Carbon::now()->dayOfWeekIso];

        $masuk = Setting::where('key', 'waktu_masuk_' . $namaHari)->value('value') ?? '09:00';
        $batasTelat = Setting::where('key', 'batas_jam_telat_' . $namaHari)->value('value') ?? '09:00';
        $pulang = Setting::where('key', 'jam_pulang_' . $namaHari)->value('value') ?? '16:00';

        return [
            'masuk' => substr($masuk, 0, 5),
            'telat' => substr($batasTelat, 0, 5),
            'pulang' => substr($pulang, 0, 5),
        ];
    }

    // =====================================================
    // FUNGSI BANTU: CEK APAKAH ABSENSI DIIZINKAN HARI INI
    // =====================================================
    private function absensiDiizinkan(): bool
    {
        $hariIni = strtolower(Carbon::now()->locale('id')->dayName);

        if (in_array($hariIni, ['sabtu', 'minggu'])) {
            $status = Setting::where('key', $hariIni . '_aktif')->value('value');
            $default = $hariIni === 'sabtu' ? '1' : '0';
            return (string) ($status ?? $default) === '1';
        }

        return true;
    }

    // =====================================================
    // FUNGSI BANTU: HITUNG JARAK (HAVERSINE)
    // =====================================================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; 
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
          cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    // =====================================================
    // 1. HALAMAN UTAMA ABSENSI
    // =====================================================
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        $absenHariIni = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();
        $jadwal = $this->jadwalHariIni();
        $jamMasukHariIni = $jadwal['telat'];

        return view('absensi.index', compact('absenHariIni', 'jamMasukHariIni'));
    }

    // =====================================================
    // 2. PROSES ABSEN MASUK (Manual)
    // =====================================================
    public function masuk()
    {
        if (!$this->absensiDiizinkan()) {
            return back()->with('error', 'Absensi hari ini sedang dinonaktifkan oleh admin.');
        }

        $hariIni = Carbon::today()->toDateString();
        $cek = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen masuk hari ini!');
        }

        $jadwal = $this->jadwalHariIni();
        $waktuSekarang = Carbon::now();
        $batasTelat = Carbon::today()->setTimeFromTimeString($jadwal['telat']);
        $statusAbsen = $waktuSekarang->lte($batasTelat) ? 'Tepat Waktu' : 'Telat';

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        return back()->with('success', 'Absen masuk berhasil! Status Anda: ' . $statusAbsen);
    }

    // =====================================================
    // 3. PROSES ABSEN PULANG
    // =====================================================
    public function pulang()
    {
        if (!$this->absensiDiizinkan()) {
            return back()->with('error', 'Absensi hari ini sedang dinonaktifkan oleh admin.');
        }

        $hariIni = Carbon::today()->toDateString();
        $absen = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        if (!$absen) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini!');
        }
        if ($absen->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini!');
        }

        $jadwal = $this->jadwalHariIni();
        $sekarang = Carbon::now();
        $waktuPulang = Carbon::today()->setTimeFromTimeString($jadwal['pulang']);

        if ($sekarang->lt($waktuPulang)) {
            return back()->with('error', 'Absen pulang hanya dapat dilakukan mulai pukul ' . $jadwal['pulang'] . '!');
        }

        $absen->update(['jam_pulang' => $sekarang->toTimeString()]);
        return back()->with('success', 'Absen pulang berhasil dicatat. Hati-hati di jalan!');
    }

    // =====================================================
    // 4. RIWAYAT ABSENSI SISWA
    // =====================================================
    public function riwayat()
    {
        $riwayat = Absensi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('absensi.riwayat', compact('riwayat'));
    }

    // =====================================================
    // 5. LAPORAN ABSENSI KHUSUS PEMBIMBING
    // =====================================================
    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')->latest()->get();
        return view('pembimbing.laporan-absensi', compact('laporanAbsensi'));
    }

    // =====================================================
    // 6. HALAMAN SCAN QR ABSENSI
    // =====================================================
    public function showScan()
    {
        return view('absensi.scan');
    }

    // =====================================================
    // 7. PROSES SCAN QR & VALIDASI LOKASI
    // =====================================================
    public function prosesScan(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        // 1. CEK TOKEN DENGAN PESAN ERROR DETAIL
        $tokenDikirim = $request->token;
        $tokenDiDatabase = QrToken::where('token', $tokenDikirim)->first();

        if (!$tokenDiDatabase) {
            return response()->json([
                'message' => 'Token TIDAK DITEMUKAN di database. (Token yang dikirim: ' . $tokenDikirim . ')'
            ], 400);
        }

        if (!$tokenDiDatabase->is_active) {
            return response()->json([
                'message' => 'Token DITEMUKAN, tetapi statusnya TIDAK AKTIF. (Mungkin sudah di-generate ulang oleh Guru).'
            ], 400);
        }

        if (Carbon::now()->greaterThan($tokenDiDatabase->expires_at)) {
            return response()->json([
                'message' => 'Token DITEMUKAN & AKTIF, tetapi sudah KEDALUWARSA. Waktu Sekarang: ' . Carbon::now() . ' | Waktu Expired: ' . $tokenDiDatabase->expires_at
            ], 400);
        }

        // 2. Cek Jarak Lokasi (Haversine Formula)
        $latSiswa = $request->lat;
        $lngSiswa = $request->lng;
        $latPkl = env('PKL_LATITUDE');
        $lngPkl = env('PKL_LONGITUDE');
        $radius = env('PKL_RADIUS', 100);

        $jarak = $this->hitungJarak($latSiswa, $lngSiswa, $latPkl, $lngPkl);

        if ($jarak > $radius) {
            return response()->json([
                'message' => 'Anda berada di luar radius PKL. Jarak Anda: ' . round($jarak) . ' meter.'
            ], 400);
        }

        // 3. Cek apakah sudah absen hari ini
        $hariIni = Carbon::today()->toDateString();
        $sudahAbsen = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        if ($sudahAbsen) {
            return response()->json(['message' => 'Anda sudah absen hari ini.'], 400);
        }

        // 4. Simpan Absensi
        $jadwal = $this->jadwalHariIni();
        $waktuSekarang = Carbon::now();
        $batasTelat = Carbon::today()->setTimeFromTimeString($jadwal['telat']);
        $statusAbsen = $waktuSekarang->lte($batasTelat) ? 'Tepat Waktu' : 'Telat';

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        return response()->json(['message' => 'Absensi berhasil! Status: ' . $statusAbsen]);
    }
}