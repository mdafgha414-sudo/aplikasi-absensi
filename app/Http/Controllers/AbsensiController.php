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
    // 2. PROSES ABSEN MASUK
    // =====================================================
    public function masuk()
    {
        // CEK APAKAH ABSENSI HARI INI AKTIF
        if (!$this->absensiDiizinkan()) {
            return back()->with(
                'error',
                'Absensi hari ini sedang dinonaktifkan oleh admin.'
            );
        }

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
        // CEK APAKAH ABSENSI HARI INI AKTIF
        if (!$this->absensiDiizinkan()) {
            return back()->with(
                'error',
                'Absensi hari ini sedang dinonaktifkan oleh admin.'
            );
        }

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

    /**
     * Memeriksa apakah absensi diizinkan pada hari ini.
     */
    private function absensiDiizinkan(): bool
    {
        $hariIni = strtolower(Carbon::now()->locale('id')->dayName);

        // Sabtu dan Minggu mengikuti pengaturan admin.
        if (in_array($hariIni, ['sabtu', 'minggu'])) {
            $status = Setting::where('key', $hariIni . '_aktif')
                ->value('value');

            // Sabtu default ON, Minggu default OFF.
            $default = $hariIni === 'sabtu' ? '1' : '0';

            return (string) ($status ?? $default) === '1';
        }

        // Senin sampai Jumat tetap diizinkan.
        return true;
    }
}