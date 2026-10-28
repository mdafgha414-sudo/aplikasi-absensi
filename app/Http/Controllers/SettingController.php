<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Tambahan untuk hapus foto lama

class SettingController extends Controller
{
    // ============================================
    // 1. MENAMPILKAN HALAMAN PENGATURAN JAM (ADMIN)
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

<<<<<<< HEAD
        // Status Sabtu dan Minggu.
        foreach (['sabtu', 'minggu'] as $hari) {
            $jadwal[$hari]['aktif'] = (string) (
                $settings[$hari . '_aktif']
                ?? ($hari === 'sabtu' ? '1' : '0')
            );
        }

=======
>>>>>>> 50ad58812ca843df1c0c8c1ac0b2c48aa9bb55fc
        return view('dashboard.pengaturan', compact(
            'daftarHari',
            'jadwal'
        ));
    }

    // ============================================
<<<<<<< HEAD
    // 2. MENYIMPAN JADWAL TUJUH HARI
=======
    // 2. MENYIMPAN PENGATURAN 7 HARI (ADMIN)
>>>>>>> 50ad58812ca843df1c0c8c1ac0b2c48aa9bb55fc
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

<<<<<<< HEAD
        // Periksa urutan jam untuk semua hari yang aktif.
=======
        // Periksa urutan jam sebelum menyimpan.
>>>>>>> 50ad58812ca843df1c0c8c1ac0b2c48aa9bb55fc
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

    // ============================================
    // 3. MENAMPILKAN PROFIL (USER/GURU/PEMBIMBING)
    // ============================================
    public function profil()
    {
        $user = Auth::user();
        return view('pengaturan.index', compact('user'));
    }

    // ============================================
    // 4. MENYIMPAN PERUBAHAN PROFIL (DIPERBARUI)
    // ============================================
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|confirmed', // Harus ada password_baru_confirmation
        ]);

        // 1. Update Nama
        $user->name = $request->name;

        // 2. Update Foto Profil (jika ada)
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->foto_profil = $path;
        }

        // 3. Update Password (dengan verifikasi password lama)
        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
            }
            $user->password = Hash::make($request->password_baru);
        }
        
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}