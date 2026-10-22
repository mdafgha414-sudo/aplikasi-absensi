<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua pengaturan
        $settings = Setting::all();
        return view('dashboard.pengaturan', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi input jam (format H:i)
        $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
        ]);

        // Simpan atau perbarui pengaturan
        Setting::updateOrCreate(
            ['key' => 'jam_masuk'],
            ['value' => $request->jam_masuk]
        );

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}