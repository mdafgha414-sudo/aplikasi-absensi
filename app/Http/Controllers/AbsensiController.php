<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Setting;
use App\Models\QrToken; 
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class AbsensiController extends Controller
{
    // =====================================================
    // FUNGSI BANTU: MENGAMBIL JADWAL HARI INI (DIPERBAIKI)
    // =====================================================
    private function jadwalHariIni()
    {
        $hari = [
            1 => 'senin', 2 => 'selasa', 3 => 'rabu', 4 => 'kamis',
            5 => 'jumat', 6 => 'sabtu', 7 => 'minggu',
        ];

        $namaHari = $hari[Carbon::now()->dayOfWeekIso];

        // PAKSA AMBIL DARI KANTONG GLOBAL (ADMIN), TANPA PEDULI PERUSAHAAN
        $masuk = Setting::whereNull('perusahaan_id')->where('key', 'waktu_masuk_' . $namaHari)->value('value') ?? '09:00';
        $batasTelat = Setting::whereNull('perusahaan_id')->where('key', 'batas_jam_telat_' . $namaHari)->value('value') ?? '09:00';
        $pulang = Setting::whereNull('perusahaan_id')->where('key', 'jam_pulang_' . $namaHari)->value('value') ?? '16:00';

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
            $status = Setting::whereNull('perusahaan_id')->where('key', $hariIni . '_aktif')->value('value');
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

    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        $absenHariIni = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();
        $jadwal = $this->jadwalHariIni();
        $jamMasukHariIni = $jadwal['telat'];

        return view('absensi.index', compact('absenHariIni', 'jamMasukHariIni'));
    }

    public function masuk(Request $request)
    {
        if (!$this->absensiDiizinkan()) {
            return back()->with('error', 'Absensi hari ini sedang dinonaktifkan oleh admin.');
        }

        $user = Auth::user();
        $perusahaan = $user->perusahaan;

        if (!$perusahaan) {
            return back()->with('error', 'Anda belum terdaftar di perusahaan PKL manapun. Hubungi Admin.');
        }

        $latPkl = $perusahaan->latitude;
        $lngPkl = $perusahaan->longitude;
        $radius = $perusahaan->radius;

        if ($request->filled('lat') && $request->filled('lng')) {
            $jarak = $this->hitungJarak($request->lat, $request->lng, $latPkl, $lngPkl);
            if ($jarak > $radius) {
                return back()->with('error', 'Anda berada di luar radius PKL. Jarak Anda: ' . round($jarak) . ' meter.');
            }
        } else {
            return back()->with('error', 'Lokasi GPS tidak terdeteksi. Pastikan izin lokasi menyala.');
        }

        $hariIni = Carbon::today()->toDateString();
        $cek = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah absen masuk hari ini!');
        }

        $fotoPath = null;
        if ($request->filled('foto')) {
            $image = $request->foto;
            $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
            $imageName = 'absensi/' . Auth::id() . '_masuk_' . time() . '.jpg';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $fotoPath = $imageName;
        }

        $jadwal = $this->jadwalHariIni();
        $waktuSekarang = Carbon::now();
        $batasTelat = Carbon::today()->setTimeFromTimeString($jadwal['telat']);
        
        $statusAbsen = $waktuSekarang->lte($batasTelat) ? 'Hadir' : 'Telat';

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
            'foto_masuk' => $fotoPath,
        ]);

        return back()->with('success', 'Absen masuk berhasil! Status: ' . $statusAbsen);
    }

    public function pulang(Request $request)
    {
        if (!$this->absensiDiizinkan()) {
            return back()->with('error', 'Absensi hari ini sedang dinonaktifkan oleh admin.');
        }

        $user = Auth::user();
        $perusahaan = $user->perusahaan;

        if (!$perusahaan) {
            return back()->with('error', 'Anda belum terdaftar di perusahaan PKL manapun.');
        }

        $latPkl = $perusahaan->latitude;
        $lngPkl = $perusahaan->longitude;
        $radius = $perusahaan->radius;

        if ($request->filled('lat') && $request->filled('lng')) {
            $jarak = $this->hitungJarak($request->lat, $request->lng, $latPkl, $lngPkl);
            if ($jarak > $radius) {
                return back()->with('error', 'Anda berada di luar radius PKL. Jarak Anda: ' . round($jarak) . ' meter.');
            }
        }

        $hariIni = Carbon::today()->toDateString();
        $absen = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();

        if (!$absen) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini!');
        }
        if ($absen->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini!');
        }

        $fotoPath = null;
        if ($request->filled('foto')) {
            $image = $request->foto;
            $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
            $imageName = 'absensi/' . Auth::id() . '_pulang_' . time() . '.jpg';
            Storage::disk('public')->put($imageName, base64_decode($image));
            $fotoPath = $imageName;
        }

        $jadwal = $this->jadwalHariIni();
        $sekarang = Carbon::now();
        $waktuPulang = Carbon::today()->setTimeFromTimeString($jadwal['pulang']);

        if ($sekarang->lt($waktuPulang)) {
            return back()->with('error', 'Absen pulang hanya dapat dilakukan mulai pukul ' . $jadwal['pulang'] . '!');
        }

        $absen->update([
            'jam_pulang' => $sekarang->toTimeString(),
            'foto_pulang' => $fotoPath,
        ]);
        
        return back()->with('success', 'Absen pulang berhasil dicatat. Hati-hati di jalan!');
    }

    public function riwayat()
    {
        $riwayat = Absensi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('absensi.riwayat', compact('riwayat'));
    }

    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')->latest()->get();
        return view('pembimbing.laporan-absensi', compact('laporanAbsensi'));
    }

    public function prosesScan(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $user = Auth::user();
        $perusahaan = $user->perusahaan;

        if (!$perusahaan) {
            return response()->json(['message' => 'Anda belum terdaftar di perusahaan PKL manapun.'], 400);
        }

        $tokenDikirim = $request->token;
        $tokenDiDatabase = QrToken::where('token', $tokenDikirim)->first();

        if (!$tokenDiDatabase) {
            return response()->json(['message' => 'Token TIDAK DITEMUKAN di database.'], 400);
        }

        if (!$tokenDiDatabase->is_active) {
            return response()->json(['message' => 'Token TIDAK AKTIF.'], 400);
        }

        if (Carbon::now()->greaterThan($tokenDiDatabase->expires_at)) {
            return response()->json(['message' => 'Token sudah KEDALUWARSA.'], 400);
        }

        $jarak = $this->hitungJarak($request->lat, $request->lng, $perusahaan->latitude, $perusahaan->longitude);
        if ($jarak > $perusahaan->radius) {
            return response()->json(['message' => 'Anda berada di luar radius PKL. Jarak: ' . round($jarak) . ' m.'], 400);
        }

        $hariIni = Carbon::today()->toDateString();
        $sudahAbsen = Absensi::where('user_id', Auth::id())->where('tanggal', $hariIni)->first();
        if ($sudahAbsen) {
            return response()->json(['message' => 'Anda sudah absen hari ini.'], 400);
        }

        $jadwal = $this->jadwalHariIni();
        $waktuSekarang = Carbon::now();
        $batasTelat = Carbon::today()->setTimeFromTimeString($jadwal['telat']);
        $statusAbsen = $waktuSekarang->lte($batasTelat) ? 'Hadir' : 'Telat';

        Absensi::create([
            'user_id' => Auth::id(),
            'tanggal' => $hariIni,
            'jam_masuk' => $waktuSekarang->toTimeString(),
            'status' => $statusAbsen,
        ]);

        return response()->json(['message' => 'Absensi berhasil! Status: ' . $statusAbsen]);
    }
}