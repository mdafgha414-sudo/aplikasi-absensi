<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // =========================================================
    // 1. MENAMPILKAN HALAMAN PENGATURAN JAM
    // =========================================================
    public function index()
    {
        $user = Auth::user();
        $daftarHari = [
            'senin'  => 'Senin',
            'selasa' => 'Selasa',
            'rabu'   => 'Rabu',
            'kamis'  => 'Kamis',
            'jumat'  => 'Jumat',
            'sabtu'  => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        // Ambil setting berdasarkan perusahaan_id (jika pembimbing)
        // Jika admin, ambil setting global (perusahaan_id = null)
        if ($user->role === 'pembimbing') {
            // PENGAMAN: Jika pembimbing tidak punya perusahaan_id, ambil array kosong
            if (is_null($user->perusahaan_id)) {
                $settings = [];
            } else {
                $settings = Setting::where('perusahaan_id', $user->perusahaan_id)
                                   ->pluck('value', 'key')->toArray();
            }
        } else {
            // Admin melihat setting global
            $settings = Setting::whereNull('perusahaan_id')
                               ->pluck('value', 'key')->toArray();
        }

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

        foreach (['sabtu', 'minggu'] as $hari) {
            $jadwal[$hari]['aktif'] = (string) (
                $settings[$hari . '_aktif']
                ?? ($hari === 'sabtu' ? '1' : '0')
            );
        }

        return view('dashboard.pengaturan', compact('daftarHari', 'jadwal'));
    }

    // =========================================================
    // 2. MENYIMPAN JADWAL TUJUH HARI
    // =========================================================
    public function update(Request $request)
    {
        $user = Auth::user();
        $daftarHari = [
            'senin', 'selasa', 'rabu', 'kamis',
            'jumat', 'sabtu', 'minggu',
        ];

        $aturan = [];

        foreach ($daftarHari as $hari) {
            $aturan["jadwal.$hari.masuk"] = 'required|date_format:H:i';
            $aturan["jadwal.$hari.telat"] = 'required|date_format:H:i';
            $aturan["jadwal.$hari.pulang"] = 'required|date_format:H:i';
        }

        $aturan['jadwal.sabtu.aktif'] = 'nullable|boolean';
        $aturan['jadwal.minggu.aktif'] = 'nullable|boolean';

        $data = $request->validate($aturan);

        // Validasi logika waktu (Telat tidak boleh mendahului Masuk, Pulang tidak boleh mendahului Telat)
        foreach ($daftarHari as $hari) {
            if (
                in_array($hari, ['sabtu', 'minggu']) &&
                !((int) ($data['jadwal'][$hari]['aktif'] ?? 0))
            ) {
                continue;
            }

            $jadwalHari = $data['jadwal'][$hari];

            if ($jadwalHari['telat'] < $jadwalHari['masuk']) {
                return back()->withErrors([
                    'jadwal' => 'Batas jam telat hari ' . ucfirst($hari) . ' tidak boleh lebih awal dari waktu masuk.',
                ])->withInput();
            }

            if ($jadwalHari['pulang'] < $jadwalHari['telat']) {
                return back()->withErrors([
                    'jadwal' => 'Jam pulang hari ' . ucfirst($hari) . ' tidak boleh lebih awal dari batas jam telat.',
                ])->withInput();
            }
        }

        // Tentukan perusahaan_id
        // Jika pembimbing, pakai perusahaan_id miliknya. Jika admin, null (global).
        $perusahaanId = $user->role === 'pembimbing' ? $user->perusahaan_id : null;

        // PENGAMAN EKSTRA: Jangan biarkan pembimbing tanpa perusahaan menyimpan data
        if ($user->role === 'pembimbing' && is_null($perusahaanId)) {
            return back()->withErrors(['jadwal' => 'Akun Anda belum terhubung ke perusahaan manapun. Hubungi Admin untuk mendaftarkan perusahaan Anda.'])->withInput();
        }

        DB::transaction(function () use ($data, $daftarHari, $perusahaanId) {
            foreach ($daftarHari as $hari) {
                // Jika hari sabtu/minggu tidak aktif, lewati penyimpanan jam
                if (
                    in_array($hari, ['sabtu', 'minggu']) &&
                    !((int) ($data['jadwal'][$hari]['aktif'] ?? 0))
                ) {
                    continue;
                }

                $jadwalHari = $data['jadwal'][$hari];

                $pengaturan = [
                    'waktu_masuk_' . $hari => $jadwalHari['masuk'],
                    'batas_jam_telat_' . $hari => $jadwalHari['telat'],
                    'jam_pulang_' . $hari => $jadwalHari['pulang'],
                ];

                foreach ($pengaturan as $key => $value) {
                    // updateOrCreate akan mencari berdasarkan 'key' DAN 'perusahaan_id'
                    Setting::updateOrCreate(
                        ['key' => $key, 'perusahaan_id' => $perusahaanId],
                        ['value' => $value]
                    );
                }
            }

            foreach (['sabtu', 'minggu'] as $hari) {
                Setting::updateOrCreate(
                    ['key' => $hari . '_aktif', 'perusahaan_id' => $perusahaanId],
                    ['value' => (string) ((int) ($data['jadwal'][$hari]['aktif'] ?? 0))]
                );
            }
        });

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }

    // =========================================================
    // 3. MENAMPILKAN PROFIL
    // =========================================================
    public function profil()
    {
        $user = Auth::user();
        return view('pengaturan.index', compact('user'));
    }

    // =========================================================
    // 4. MENYIMPAN PERUBAHAN PROFIL
    // =========================================================
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        if (! $user || ! method_exists($user, 'save')) {
            $user = \App\Models\User::findOrFail(Auth::id());
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->foto_profil = $path;
        }

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