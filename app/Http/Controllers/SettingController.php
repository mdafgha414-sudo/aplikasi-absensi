<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        $settings = Setting::where('perusahaan_id', $perusahaanId)->pluck('value', 'key')->toArray();

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

    public function update(Request $request)
    {
        $user = Auth::user();
        $perusahaanId = ($user->role === 'pembimbing') ? $user->perusahaan_id : null;

        // Validasi simpel
        $request->validate([
            'jam_masuk_senin' => 'required',
            'jam_telat_senin' => 'required',
            'jam_pulang_senin' => 'required',
        ]);

        // Gunakan DB Transaction agar aman
        DB::transaction(function () use ($request, $perusahaanId) {
            foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari) {
                // HAPUS DATA LAMA DULU (Paksa bersih)
                Setting::where('perusahaan_id', $perusahaanId)
                    ->where('key', 'like', '%_' . $hari)
                    ->delete();

                // BUAT DATA BARU
                Setting::create([
                    'key' => 'waktu_masuk_' . $hari,
                    'perusahaan_id' => $perusahaanId,
                    'value' => $request->input('jam_masuk_' . $hari, '07:00')
                ]);
                Setting::create([
                    'key' => 'batas_jam_telat_' . $hari,
                    'perusahaan_id' => $perusahaanId,
                    'value' => $request->input('jam_telat_' . $hari, '07:15')
                ]);
                Setting::create([
                    'key' => 'jam_pulang_' . $hari,
                    'perusahaan_id' => $perusahaanId,
                    'value' => $request->input('jam_pulang_' . $hari, '15:00')
                ]);
            }
        });

        return redirect('/admin/setting')->with('success', 'Jadwal absensi berhasil disimpan!');
    }
}