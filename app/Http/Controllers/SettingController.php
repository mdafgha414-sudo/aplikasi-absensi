<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // 1. TAMPILKAN HALAMAN PENGATURAN JAM
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan hanya Admin dan Pembimbing yang bisa akses
        if (!in_array($user->role, ['admin', 'pembimbing'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Tentukan "kantong" data
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Ambil data langsung dari tabel
        $settings = DB::table('settings')
            ->where(function($q) use ($perusahaanId) {
                if ($perusahaanId) {
                    $q->where('perusahaan_id', $perusahaanId);
                } else {
                    $q->whereNull('perusahaan_id');
                }
            })
            ->pluck('value', 'key')->toArray();

        $default = ['masuk' => '07:00', 'telat' => '07:15', 'pulang' => '15:00'];
        $jadwal = [];

        foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
            foreach ($default as $jenis => $jamDefault) {
                $jenisDb = ['masuk' => 'waktu_masuk', 'telat' => 'batas_jam_telat', 'pulang' => 'jam_pulang'][$jenis];
                $key = $jenisDb . '_' . $hari;
                $jadwal[$hari][$jenis] = $settings[$key] ?? $jamDefault;
            }
        }

        $jadwal['sabtu']['aktif'] = $settings['sabtu_aktif'] ?? '1';
        $jadwal['minggu']['aktif'] = $settings['minggu_aktif'] ?? '0';

        return view('dashboard.pengaturan', compact('jadwal'));
    }

    // 2. SIMPAN PENGATURAN JAM
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!in_array($user->role, ['admin', 'pembimbing'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Validasi simpel
        $request->validate([
            'jam_masuk_senin' => 'required',
            'jam_telat_senin' => 'required',
            'jam_pulang_senin' => 'required',
        ]);

        DB::transaction(function () use ($request, $perusahaanId) {
            // Hapus data lama untuk "kantong" ini
            DB::table('settings')->where(function($q) use ($perusahaanId) {
                if ($perusahaanId) {
                    $q->where('perusahaan_id', $perusahaanId);
                } else {
                    $q->whereNull('perusahaan_id');
                }
            })->delete();

            // Siapkan array untuk insert baru
            $newData = [];

            foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
                $newData[] = ['key' => 'waktu_masuk_' . $hari, 'perusahaan_id' => $perusahaanId, 'value' => $request->input('jam_masuk_' . $hari)];
                $newData[] = ['key' => 'batas_jam_telat_' . $hari, 'perusahaan_id' => $perusahaanId, 'value' => $request->input('jam_telat_' . $hari)];
                $newData[] = ['key' => 'jam_pulang_' . $hari, 'perusahaan_id' => $perusahaanId, 'value' => $request->input('jam_pulang_' . $hari)];
            }

            // Simpan status sabtu/minggu
            $statusSabtu = $request->has('status_sabtu') ? '1' : '0';
            $statusMinggu = $request->has('status_minggu') ? '1' : '0';
            
            $newData[] = ['key' => 'sabtu_aktif', 'perusahaan_id' => $perusahaanId, 'value' => $statusSabtu];
            $newData[] = ['key' => 'minggu_aktif', 'perusahaan_id' => $perusahaanId, 'value' => $statusMinggu];

            DB::table('settings')->insert($newData);
        });

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }

    // 3. PROFIL
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