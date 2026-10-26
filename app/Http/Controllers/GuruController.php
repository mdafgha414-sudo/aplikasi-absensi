<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Izin; 
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    // 1. Halaman Dashboard Guru
    public function index()
    {
        $semuaJurnal = Jurnal::with('user')->orderBy('tanggal', 'desc')->get();
        $totalSiswa = User::where('role', 'user')->count();
        return view('dashboard.guru', compact('semuaJurnal', 'totalSiswa'));
    }

    // 2. Menyimpan penilaian jurnal
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

    // 3. Menampilkan daftar pengajuan izin siswa
    // 3. Tambahan fungsi untuk Laporan Absensi Guru
    public function laporanAbsensi()
    {
        // Mengambil data absensi dari database untuk dilihat guru
        $laporanAbsensi = Absensi::with('user')->latest()->get(); 

        return view('guru.laporan-absensi', compact('laporanAbsensi'));
    } // <-- INI YANG KURANG (Tutup kurung kurawal fungsi laporanAbsensi)

    // ==========================================
    // FITUR BARU: MANAJEMEN IZIN SISWA
    // ==========================================

    // 4. Menampilkan daftar pengajuan izin siswa
    public function lihatIzin()
    {
        $semuaIzin = Izin::with('user')->orderBy('created_at', 'desc')->get();
        return view('dashboard.izin_guru', compact('semuaIzin'));
    }

    // 4. Memproses persetujuan/penolakan izin DAN Sinkronisasi ke Absensi
    // 5. Memproses persetujuan atau penolakan izin
    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        
        $izin->update([
            'status' => $request->status,
        ]);

        // --- LOGIKA SINKRONISASI KE ABSENSI ---
        // Jika disetujui, buat catatan absensi otomatis untuk tanggal izin tersebut
        if ($request->status == 'Disetujui') {
            
            // Cek dulu, jangan sampai double input jika guru menekan tombol dua kali
            $cekAbsen = Absensi::where('user_id', $izin->user_id)
                               ->where('tanggal', $izin->tanggal_izin)
                               ->first();

            if (!$cekAbsen) {
                Absensi::create([
                    'user_id' => $izin->user_id,
                    'tanggal' => $izin->tanggal_izin,
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'status' => 'Izin', // Status khusus untuk membedakan dengan Telat/Tepat Waktu
                ]);
            }
        }

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }
}