<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // ==========================================
    // 1. TAMPILKAN HALAMAN PENGATURAN JAM (ADMIN)
    // ==========================================
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang bisa mengakses halaman ini.');
        }

        // Ambil data langsung dari tabel, tanpa perantara
        $settings = DB::table('settings')->whereNull('perusahaan_id')->pluck('value', 'key')->toArray();

        $default = ['masuk' => '07:00', 'telat' => '07:15', 'pulang' => '15:00'];
        $jadwal = [];

        foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
            foreach ($default as $jenis => $jamDefault) {
                $jenisDb = ['masuk' => 'waktu_masuk', 'telat' => 'batas_jam_telat', 'pulang' => 'jam_pulang'][$jenis];
                $key = $jenisDb . '_' . $hari;
                $jadwal[$hari][$jenis] = $settings[$key] ?? $jamDefault;
            }
        }

        return view('dashboard.pengaturan', compact('jadwal'));
    }

    // ==========================================
    // 2. SIMPAN PENGATURAN JAM (ADMIN)
    // ==========================================
    public function update(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang bisa mengakses halaman ini.');
        }

        // Validasi simpel
        $request->validate([
            'jam_masuk_senin' => 'required',
            'jam_telat_senin' => 'required',
            'jam_pulang_senin' => 'required',
        ]);

        // Paksa hapus data lama, lalu buat baru (Anti-Gagal)
        DB::transaction(function () use ($request) {
            foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
                // Hapus data lama untuk hari ini (jika ada)
                DB::table('settings')->whereNull('perusahaan_id')->where('key', 'like', '%_' . $hari)->delete();

                // Buat data baru
                DB::table('settings')->insert([
                    ['key' => 'waktu_masuk_' . $hari, 'perusahaan_id' => null, 'value' => $request->input('jam_masuk_' . $hari, '07:00')],
                    ['key' => 'batas_jam_telat_' . $hari, 'perusahaan_id' => null, 'value' => $request->input('jam_telat_' . $hari, '07:15')],
                    ['key' => 'jam_pulang_' . $hari, 'perusahaan_id' => null, 'value' => $request->input('jam_pulang_' . $hari, '15:00')],
                ]);
            }
        });

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }

    // ==========================================
    // 3. PROFIL (BIARKAN SEPERTI ASLINYA)
    // ==========================================
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