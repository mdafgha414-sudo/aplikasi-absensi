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
    public function index()
    {
        $user = Auth::user();
        $daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

        // Tentukan ID Perusahaan (Admin = NULL, Pembimbing = ID Perusahaannya)
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Ambil setting HANYA berdasarkan perusahaan_id yang sesuai
        $settings = Setting::where('perusahaan_id', $perusahaanId)->pluck('value', 'key')->toArray();

        $default = ['masuk' => '07:00', 'telat' => '07:15', 'pulang' => '15:00'];
        $jadwal = [];

        foreach ($daftarHari as $hari) {
            foreach ($default as $jenis => $jamDefault) {
                $jenisDb = ['masuk' => 'waktu_masuk', 'telat' => 'batas_jam_telat', 'pulang' => 'jam_pulang'][$jenis];
                $key = $jenisDb . '_' . $hari;
                $jadwal[$hari][$jenis] = isset($settings[$key]) ? substr($settings[$key], 0, 5) : $jamDefault;
            }
        }

        foreach (['sabtu', 'minggu'] as $hari) {
            $jadwal[$hari]['aktif'] = (string) ($settings[$hari . '_aktif'] ?? ($hari === 'sabtu' ? '1' : '0'));
        }

        return view('dashboard.pengaturan', compact('daftarHari', 'jadwal'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

        // Validasi
        $rules = [];
        foreach ($daftarHari as $hari) {
            $rules["jam_masuk_$hari"] = 'required|date_format:H:i';
            $rules["jam_telat_$hari"] = 'required|date_format:H:i';
            $rules["jam_pulang_$hari"] = 'required|date_format:H:i';
        }
        $rules['status_sabtu'] = 'nullable|boolean';
        $rules['status_minggu'] = 'nullable|boolean';
        $request->validate($rules);

        // Validasi Logika Waktu
        foreach ($daftarHari as $hari) {
            if (in_array($hari, ['sabtu', 'minggu']) && !$request->has("status_$hari")) {
                continue;
            }
            $masuk = $request->input("jam_masuk_$hari");
            $telat = $request->input("jam_telat_$hari");
            $pulang = $request->input("jam_pulang_$hari");

            if ($telat < $masuk) return back()->withErrors(['error' => "Batas jam telat hari $hari tidak boleh lebih awal dari jam masuk."])->withInput();
            if ($pulang < $telat) return back()->withErrors(['error' => "Jam pulang hari $hari tidak boleh lebih awal dari batas jam telat."])->withInput();
        }

        // Tentukan ID Perusahaan
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        if ($user->role === 'pembimbing' && is_null($perusahaanId)) {
            return back()->withErrors(['error' => 'Akun Anda belum terhubung ke perusahaan.'])->withInput();
        }

        // Simpan ke Database
        DB::transaction(function () use ($request, $daftarHari, $perusahaanId) {
            foreach ($daftarHari as $hari) {
                Setting::updateOrCreate(['key' => "waktu_masuk_$hari", 'perusahaan_id' => $perusahaanId], ['value' => $request->input("jam_masuk_$hari")]);
                Setting::updateOrCreate(['key' => "batas_jam_telat_$hari", 'perusahaan_id' => $perusahaanId], ['value' => $request->input("jam_telat_$hari")]);
                Setting::updateOrCreate(['key' => "jam_pulang_$hari", 'perusahaan_id' => $perusahaanId], ['value' => $request->input("jam_pulang_$hari")]);

                if (in_array($hari, ['sabtu', 'minggu'])) {
                    $status = $request->has("status_$hari") ? '1' : '0';
                    Setting::updateOrCreate(['key' => "{$hari}_aktif", 'perusahaan_id' => $perusahaanId], ['value' => $status]);
                }
            }
        });

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('pengaturan.index', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        if (! $user || ! method_exists($user, 'save')) $user = \App\Models\User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password_lama' => 'nullable|required_with:password_baru',
            'password_baru' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) Storage::disk('public')->delete($user->foto_profil);
            $user->foto_profil = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        if ($request->filled('password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}