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

        // Ambil seluruh pengaturan dari database.
        $settings = Setting::pluck('value', 'key')->toArray();

        // Nilai default jika pengaturan belum pernah disimpan.
        $default = [
            'masuk'  => '07:00',
            'telat'  => '07:15',
            'pulang' => '15:00',
        ];

        // Susun jadwal sesuai struktur input Blade.
        $jadwal = [];

        foreach ($daftarHari as $hari => $namaHari) {
            foreach ($default as $jenis => $jamDefault) {

                // Samakan key dengan format yang digunakan database.
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

        return view('dashboard.pengaturan', compact(
            'daftarHari',
            'jadwal'
        ));
    }

    // ============================================
    // 2. MENYIMPAN PENGATURAN 7 HARI (ADMIN)
    // ============================================
    public function update(Request $request)
    {
        $daftarHari = [
            'senin', 'selasa', 'rabu', 'kamis',
            'jumat', 'sabtu', 'minggu',
        ];

        // Validasi berdasarkan nama input di Blade.
        $aturan = [];

        foreach ($daftarHari as $hari) {
            $aturan["jadwal.$hari.masuk"] =
                'exclude_if:jadwal.' . $hari . '.masuk,null|nullable|date_format:H:i';

            $aturan["jadwal.$hari.telat"] =
                'exclude_if:jadwal.' . $hari . '.telat,null|nullable|date_format:H:i';

            $aturan["jadwal.$hari.pulang"] =
                'exclude_if:jadwal.' . $hari . '.pulang,null|nullable|date_format:H:i';
        }

        $data = $request->validate($aturan);

        // Periksa urutan jam sebelum menyimpan.
        foreach ($daftarHari as $hari) {
            if ($hari === 'minggu') {
                continue;
            }

            $jadwalHari = $data['jadwal'][$hari] ?? [];

            $masuk = $jadwalHari['masuk'] ?? null;
            $telat = $jadwalHari['telat'] ?? null;
            $pulang = $jadwalHari['pulang'] ?? null;

            if (!$masuk || !$telat || !$pulang) {
                return back()
                    ->withErrors([
                        'jadwal' => 'Lengkapi semua waktu untuk hari ' .
                            ucfirst($hari) . '.',
                    ])
                    ->withInput();
            }

            if ($telat < $masuk) {
                return back()
                    ->withErrors([
                        'jadwal' => 'Batas jam telat hari ' .
                            ucfirst($hari) .
                            ' tidak boleh lebih awal dari waktu masuk.',
                    ])
                    ->withInput();
            }

            if ($pulang < $telat) {
                return back()
                    ->withErrors([
                        'jadwal' => 'Jam pulang hari ' .
                            ucfirst($hari) .
                            ' tidak boleh lebih awal dari batas jam telat.',
                    ])
                    ->withInput();
            }
        }

        // Simpan seluruh jadwal dalam transaksi database.
        DB::transaction(function () use ($data, $daftarHari) {
            foreach ($daftarHari as $hari) {
                if ($hari === 'minggu') {
                    continue;
                }

                $jadwalHari = $data['jadwal'][$hari];

                $pengaturan = [
                    'waktu_masuk_' . $hari => $jadwalHari['masuk'],
                    'batas_jam_telat_' . $hari => $jadwalHari['telat'],
                    'jam_pulang_' . $hari => $jadwalHari['pulang'],
                ];

                foreach ($pengaturan as $key => $value) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
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