<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // ============================================
    // 1. MENAMPILKAN PENGATURAN MINGGUAN
    // ============================================
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        $daftarHari = [
            'senin'  => 'Senin',
            'selasa' => 'Selasa',
            'rabu'   => 'Rabu',
            'kamis'  => 'Kamis',
            'jumat'  => 'Jumat',
            'sabtu'  => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        // Nilai default untuk setiap hari.
        $default = [
            'waktu_masuk'     => '07:00',
            'batas_jam_telat' => '07:15',
            'jam_pulang'      => '15:00',
        ];

        $jadwalMingguan = [];

        foreach ($daftarHari as $hari => $namaHari) {
            foreach ($default as $jenis => $jamDefault) {
                $key = $jenis . '_' . $hari;

                $jadwalMingguan[$hari][$jenis] =
                    isset($settings[$key])
                        ? substr($settings[$key], 0, 5)
                        : $jamDefault;
            }
        }

        return view('dashboard.pengaturan', compact(
            'daftarHari',
            'jadwalMingguan'
        ));
    }

    // ============================================
    // 2. MENYIMPAN PENGATURAN 7 HARI
    // ============================================
    public function update(Request $request)
    {
        $daftarHari = [
            'senin', 'selasa', 'rabu', 'kamis',
            'jumat', 'sabtu', 'minggu',
        ];

        $jenisWaktu = [
            'waktu_masuk',
            'batas_jam_telat',
            'jam_pulang',
        ];

        // Validasi semua 21 input waktu.
        $aturan = [];

        foreach ($daftarHari as $hari) {
            foreach ($jenisWaktu as $jenis) {
                $aturan[$jenis . '_' . $hari] =
                    'required|date_format:H:i';
            }
        }

        $data = $request->validate($aturan);

        // Periksa urutan waktu untuk masing-masing hari.
        foreach ($daftarHari as $hari) {
            $masuk = $data['waktu_masuk_' . $hari];
            $telat = $data['batas_jam_telat_' . $hari];
            $pulang = $data['jam_pulang_' . $hari];

            if ($telat < $masuk) {
                return back()
                    ->withErrors([
                        'batas_jam_telat_' . $hari =>
                            'Batas jam telat hari ' . ucfirst($hari) .
                            ' tidak boleh lebih awal dari waktu masuk.',
                    ])
                    ->withInput();
            }

            if ($pulang < $telat) {
                return back()
                    ->withErrors([
                        'jam_pulang_' . $hari =>
                            'Jam pulang hari ' . ucfirst($hari) .
                            ' tidak boleh lebih awal dari batas jam telat.',
                    ])
                    ->withInput();
            }
        }

        // Simpan setiap pengaturan menggunakan key per hari.
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with(
            'success',
            'Jadwal absensi untuk 7 hari berhasil disimpan!'
        );
    }
}
