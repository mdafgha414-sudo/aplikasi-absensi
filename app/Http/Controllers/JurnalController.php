<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    // 1. Tampilkan form & daftar jurnal milik siswa yang login
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();
        
        // Cek apakah siswa sudah isi jurnal hari ini
        $jurnalHariIni = Jurnal::where('user_id', Auth::id())
                               ->where('tanggal', $hariIni)
                               ->first();
                               
        // Ambil semua riwayat jurnal siswa ini
        $riwayatJurnal = Jurnal::where('user_id', Auth::id())
                               ->orderBy('tanggal', 'desc')
                               ->get();

        return view('jurnal.index', compact('jurnalHariIni', 'riwayatJurnal'));
    }

    // 2. Simpan jurnal baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|string',
            'kendala' => 'nullable|string',
        ]);

        Jurnal::create([
            'user_id' => Auth::id(),
            'tanggal' => Carbon::today()->toDateString(),
            'kegiatan' => $request->kegiatan,
            'kendala' => $request->kendala,
        ]);

        return back()->with('success', 'Jurnal hari ini berhasil disimpan!');
    }
}