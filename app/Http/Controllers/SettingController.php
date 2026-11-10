<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    // 1. Tampilkan Halaman
    public function index()
    {
        $user = Auth::user();
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Ambil data dari database
        $settings = Setting::where('perusahaan_id', $perusahaanId)->pluck('value', 'key')->toArray();

        // Data default jika belum ada setting
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

    // 2. Simpan Perubahan
    public function update(Request $request)
    {
        $user = Auth::user();
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Validasi sederhana
        $request->validate([
            'jam_masuk_senin' => 'required',
            'jam_telat_senin' => 'required',
            'jam_pulang_senin' => 'required',
            // (Validasi untuk hari lain bisa ditambahkan atau di-loop)
        ]);

        // Simpan data
        foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
            Setting::updateOrCreate(
                ['key' => 'waktu_masuk_' . $hari, 'perusahaan_id' => $perusahaanId],
                ['value' => $request->input('jam_masuk_' . $hari, '07:00')]
            );
            Setting::updateOrCreate(
                ['key' => 'batas_jam_telat_' . $hari, 'perusahaan_id' => $perusahaanId],
                ['value' => $request->input('jam_telat_' . $hari, '07:15')]
            );
            Setting::updateOrCreate(
                ['key' => 'jam_pulang_' . $hari, 'perusahaan_id' => $perusahaanId],
                ['value' => $request->input('jam_pulang_' . $hari, '15:00')]
            );
        }

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }
}