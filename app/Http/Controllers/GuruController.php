<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Absensi; // Tambahkan ini untuk memanggil model Absensi
use App\Models\Izin; // <-- Tambahkan ini untuk memanggil Model Izin
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

    // 3. Tambahan fungsi untuk Laporan Absensi Guru
    public function laporanAbsensi()
    {
        // Mengambil data absensi dari database untuk dilihat guru
        $laporanAbsensi = Absensi::with('user')->latest()->get(); 

        return view('guru.laporan-absensi', compact('laporanAbsensi'));
    // ==========================================
    // FITUR BARU: MANAJEMEN IZIN SISWA
    // ==========================================

    // 3. Menampilkan daftar pengajuan izin siswa
    public function lihatIzin()
    {
        // Ambil semua data izin beserta data user (siswa) yang mengajukan
        // Urutkan dari yang terbaru
        $semuaIzin = Izin::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('dashboard.izin_guru', compact('semuaIzin'));
    }

    // 4. Memproses persetujuan atau penolakan izin
    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        
        $izin->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }
}