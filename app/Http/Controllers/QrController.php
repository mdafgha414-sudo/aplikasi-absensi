<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHAN

class QrController extends Controller
{
    public function index()
    {
        // Filter berdasarkan role yang login
        if (Auth::user()->role === 'pembimbing') {
            // Pembimbing: Hanya lihat siswa di perusahaannya
            $siswas = User::where('role', 'user')
                          ->where('perusahaan_id', Auth::user()->perusahaan_id)
                          ->whereNotNull('kode_kartu')
                          ->orderBy('name', 'asc')
                          ->get();
        } else {
            // Admin: Lihat semua siswa
            $siswas = User::where('role', 'user')
                          ->whereNotNull('kode_kartu')
                          ->orderBy('name', 'asc')
                          ->get();
        }

        return view('qr.index', compact('siswas'));
    }

    public function show($id)
    {
        $siswa = User::findOrFail($id);
        
        // KEAMANAN: Pembimbing tidak boleh print QR siswa dari perusahaan lain
        if (Auth::user()->role === 'pembimbing' && $siswa->perusahaan_id !== Auth::user()->perusahaan_id) {
            abort(403, 'Anda tidak memiliki akses ke siswa ini.');
        }

        $qrCode = QrCode::size(200)->generate($siswa->kode_kartu);

        return view('qr.show', compact('siswa', 'qrCode'));
    }
}