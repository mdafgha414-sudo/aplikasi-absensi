<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Setting;
use App\Models\QrToken; // Tambahan untuk QR
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

        // Ambil jadwal yang disimpan admin
        $masuk = Setting::where(
            'key', 'waktu_masuk_' . $namaHari
        )->value('value') ?? '09:00';

        $batasTelat = Setting::where(
            'key', 'batas_jam_telat_' . $namaHari
        )->value('value') ?? '09:00';

        $pulang = Setting::where(
            'key', 'jam_pulang_' . $namaHari
        )->value('value') ?? '16:00';

        return [
            'masuk' => substr($masuk, 0, 5),
            'telat' => substr($batasTelat, 0, 5),
            'pulang' => substr($pulang, 0, 5),
        ];
    }

    // =====================================================
    // 1. HALAMAN UTAMA ABSENSI
    // =====================================================
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();

        $absenHariIni = Absensi::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        $jadwal = $this->jadwalHariIni();

        // Variabel ini dipakai untuk menampilkan batas terlambat
        $jamMasukHariIni = $jadwal['telat'];

        return view('absensi.index', compact(
            'absenHariIni',
            'jamMasukHariIni'
        ));
    }

    // =====================================================
    // 2. PROSES ABSEN MASUK (Manual)
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

        $jadwal = $this->jadwalHariIni();

        $waktuSekarang = Carbon::now();

        // Status ditentukan berdasarkan batas terlambat admin
        $batasTelat = Carbon::today()->setTimeFromTimeString(
            $jadwal['telat']
        );

        $statusAbsen = $waktuSekarang->lte($batasTelat)
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
            return back()->with(
                'error',
                'Anda belum melakukan absen masuk hari ini!'
            );
        }

        if ($absen->jam_pulang) {
            return back()->with(
                'error',
                'Anda sudah melakukan absen pulang hari ini!'
            );
        }

        // Ambil jam pulang dari pengaturan admin
        $jadwal = $this->jadwalHariIni();

        $sekarang = Carbon::now();

        $waktuPulang = Carbon::today()->setTimeFromTimeString(
            $jadwal['pulang']
        );

        // Tolak absen pulang jika belum waktunya
        if ($sekarang->lt($waktuPulang)) {
            return back()->with(
                'error',
                'Absen pulang hanya dapat dilakukan mulai pukul '
                . $jadwal['pulang'] . '!'
            );
        }

        // Simpan absensi pulang
        $absen->update([
            'jam_pulang' => $sekarang->toTimeString(),
        ]);

        return back()->with(
            'success',
            'Absen pulang berhasil dicatat. Hati-hati di jalan!'
        );
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
    // 5. LAPORAN ABSENSI KHUSUS PEMBIMBING
    // =====================================================
    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')
            ->latest()
            ->get();

        return view(
            'pembimbing.laporan-absensi',
            compact('laporanAbsensi')
        );
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

        // 1. Cek Validitas Token QR
        $token = QrToken::where('token', $request->token)
                    ->where('is_active', true)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if (!$token) {
            return response()->json(['message' => 'QR Code tidak valid atau sudah kadaluarsa.'], 400);
        }

        // 2. Cek Jarak Lokasi (Haversine Formula)
        $latSiswa = $request->lat;
        $lngSiswa = $request->lng;
        $latPkl = env('PKL_LATITUDE');
        $lngPkl = env('PKL_LONGITUDE');
        $radius = env('PKL_RADIUS', 100); // Default 100 meter

        $jarak = $this->hitungJarak($latSiswa, $lngSiswa, $latPkl, $lngPkl);

        if ($jarak > $radius) {
            return response()->json([
                'message' => 'Anda berada di luar radius PKL. Jarak Anda: ' . round($jarak) . ' meter.'
            ], 400);
        }

        // 3. Cek apakah sudah absen hari ini
        $hariIni = Carbon::today()->toDateString();
        $sudahAbsen = Absensi::where('user_id', Auth::id())
                             ->where('tanggal', $hariIni)
                             ->first();

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

    // =====================================================
    // FUNGSI BANTU: HITUNG JARAK (HAVERSINE)
    // =====================================================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
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
}