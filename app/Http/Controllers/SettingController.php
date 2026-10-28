<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    // ============================================
    // 1. MENAMPILKAN HALAMAN PENGATURAN
    // ============================================
    public function index()
    {
        $daftarHari = [
            'senin'  => 'Senin',
            'selasa' => 'Selasa',
            'rabu'   => 'Rabu',
            'kamis'  => 'Kamis',
            'jumat'  => 'Jumat',
            'sabtu'  => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        $settings = Setting::pluck('value', 'key')->toArray();

        $default = [
            'masuk'  => '07:00',
            'telat'  => '07:15',
            'pulang' => '15:00',
        ];

        $jadwal = [];

        foreach ($daftarHari as $hari => $namaHari) {
            foreach ($default as $jenis => $jamDefault) {
                $jenisDatabase = [
                    'masuk'  => 'waktu_masuk',
                    'telat'  => 'batas_jam_telat',
                    'pulang' => 'jam_pulang',
                ][$jenis];

                $key = $jenisDatabase . '_' . $hari;

                $jadwal[$hari][$jenis] = isset($settings[$key])
                    ? substr($settings[$key], 0, 5)
                    : $jamDefault;
            }
        }

        // Status Sabtu dan Minggu.
        foreach (['sabtu', 'minggu'] as $hari) {
            $jadwal[$hari]['aktif'] = (string) (
                $settings[$hari . '_aktif']
                ?? ($hari === 'sabtu' ? '1' : '0')
            );
        }

        return view('dashboard.pengaturan', compact(
            'daftarHari',
            'jadwal'
        ));
    }

    // ============================================
    // 2. MENYIMPAN JADWAL TUJUH HARI
    // ============================================
    public function update(Request $request)
    {
        $daftarHari = [
            'senin', 'selasa', 'rabu', 'kamis',
            'jumat', 'sabtu', 'minggu',
        ];

        $aturan = [];

        foreach ($daftarHari as $hari) {
            $aturan["jadwal.$hari.masuk"] =
                'required|date_format:H:i';

            $aturan["jadwal.$hari.telat"] =
                'required|date_format:H:i';

            $aturan["jadwal.$hari.pulang"] =
                'required|date_format:H:i';
        }

        // Checkbox tidak dicentang akan bernilai 0.
        $aturan['jadwal.sabtu.aktif'] = 'nullable|boolean';
        $aturan['jadwal.minggu.aktif'] = 'nullable|boolean';

        $data = $request->validate($aturan);

        // Periksa urutan jam untuk semua hari yang aktif.
        foreach ($daftarHari as $hari) {
            if (
                in_array($hari, ['sabtu', 'minggu']) &&
                !((int) ($data['jadwal'][$hari]['aktif'] ?? 0))
            ) {
                // Hari nonaktif: jam tetap disimpan,
                // tetapi tidak perlu divalidasi urutannya.
                continue;
            }

            $jadwalHari = $data['jadwal'][$hari];

            if ($jadwalHari['telat'] < $jadwalHari['masuk']) {
                return back()
                    ->withErrors([
                        'jadwal' => 'Batas jam telat hari ' .
                            ucfirst($hari) .
                            ' tidak boleh lebih awal dari waktu masuk.',
                    ])
                    ->withInput();
            }

            if ($jadwalHari['pulang'] < $jadwalHari['telat']) {
                return back()
                    ->withErrors([
                        'jadwal' => 'Jam pulang hari ' .
                            ucfirst($hari) .
                            ' tidak boleh lebih awal dari batas jam telat.',
                    ])
                    ->withInput();
            }
        }

        // Simpan jadwal dan status dalam satu transaksi.
        DB::transaction(function () use ($data, $daftarHari) {
            foreach ($daftarHari as $hari) {
                $jadwalHari = $data['jadwal'][$hari];

                $pengaturan = [
                    'waktu_masuk_' . $hari =>
                        $jadwalHari['masuk'],

                    'batas_jam_telat_' . $hari =>
                        $jadwalHari['telat'],

                    'jam_pulang_' . $hari =>
                        $jadwalHari['pulang'],
                ];

                foreach ($pengaturan as $key => $value) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }

            // Simpan status aktif/nonaktif Sabtu dan Minggu.
            foreach (['sabtu', 'minggu'] as $hari) {
                Setting::updateOrCreate(
                    ['key' => $hari . '_aktif'],
                    [
                        'value' => (string) (
                            (int) ($data['jadwal'][$hari]['aktif'] ?? 0)
                        ),
                    ]
                );
            }
        });

        return redirect('/admin/setting')->with(
            'success',
            'Jadwal absensi berhasil disimpan!'
        );
    }
}
