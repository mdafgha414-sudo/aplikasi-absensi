<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
      // 1. Halaman Dashboard Guru (Melihat daftar jurnal siswa)
    public function index()
    {
        // Ambil semua jurnal beserta data siswa yang menulisnya
        $semuaJurnal = Jurnal::with('user')->orderBy('tanggal', 'desc')->get();

        // Hitung total siswa
        $totalSiswa = User::where('role', 'user')->count();

        return view('dashboard.guru', compact('semuaJurnal', 'totalSiswa'));
    }

   // 2. Fungsi untuk menyimpan penilaian dari guru
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan_guru' => 'nullable|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);

        $jurnal->update([
            'nilai' => $request->nilai,
            'catatan_guru' => $request->catatan_guru,
        ]);

        return back()->with('success', 'Penilaian dan catatan berhasil disimpan!');
    }


}
