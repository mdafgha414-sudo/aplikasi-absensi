<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrAbsensiController extends Controller
{
    // Halaman untuk menampilkan QR
    public function show()
    {
        // Cek apakah ada token aktif dan belum kedaluwarsa
        $tokenAktif = QrToken::where('is_active', true)
                             ->where('expires_at', '>', Carbon::now())
                             ->latest()
                             ->first();

        return view('absensi.qr', compact('tokenAktif'));
    }

    // Fungsi untuk generate token baru
    public function generate()
    {
        // 1. Nonaktifkan semua token lama
        QrToken::where('is_active', true)->update(['is_active' => false]);

        // 2. Buat token baru (berlaku 5 menit)
        QrToken::create([
            'token' => Str::random(32),
            'created_by' => auth()->id(),
            'expires_at' => Carbon::now()->addMinutes(5),
            'is_active' => true, // <-- INI YANG HILANG SEBELUMNYA!
        ]);

        return back()->with('success', 'QR Code baru berhasil dibuat!');
    }
}