<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
<<<<<<< HEAD
use App\Models\Absensi; 
use App\Models\Izin; 
=======
use App\Models\Izin; 
use App\Models\Absensi;
>>>>>>> 3533e216f3ad1c5e383005b33ccb6df163a254ee
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class GuruController extends Controller
{
    // ==========================================
    // 1. HALAMAN DASHBOARD GURU
    // ==========================================
    public function index()
    {
        $semuaJurnal = Jurnal::with('user')->orderBy('tanggal', 'desc')->get();
        $totalSiswa = User::where('role', 'user')->count();
        
        return view('dashboard.guru', compact('semuaJurnal', 'totalSiswa'));
    }

    // ==========================================
    // 2. MENYIMPAN PENILAIAN JURNAL
    // ==========================================
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

<<<<<<< HEAD
    // ==========================================
    // 3. LAPORAN ABSENSI GURU
    // ==========================================
=======
    // 3. Menampilkan daftar pengajuan izin siswa
    // 3. Tambahan fungsi untuk Laporan Absensi Guru
>>>>>>> 3533e216f3ad1c5e383005b33ccb6df163a254ee
    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')->latest()->get(); 
        return view('guru.laporan-absensi', compact('laporanAbsensi'));
<<<<<<< HEAD
    }

    // ==========================================
    // 4. MANAJEMEN IZIN & REKAP KEHADIRAN (MATRIKS)
    // ==========================================
    public function lihatIzin(Request $request)
    {
        // 1. Tentukan Bulan dan Tahun (Default: Bulan ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 2. Buat daftar tanggal dalam 1 bulan
        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        // 3. Ambil semua data siswa
        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();

        // 4. Ambil data Absensi pada bulan tersebut
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // 5. Ambil data Izin pada bulan tersebut
        $izin = Izin::whereMonth('tanggal_izin', $bulan)
                    ->whereYear('tanggal_izin', $tahun)
                    ->get()
                    ->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        // 6. Ambil data untuk tabel "Daftar Pengajuan Izin"
        $semuaIzin = Izin::with('user')->orderBy('created_at', 'desc')->get();

        return view('dashboard.izin_guru', compact(
            'semuaIzin', 
            'siswa', 
            'tanggalList', 
            'absensi', 
            'izin',
            'bulan',
            'tahun'
        ));
    }

    // ==========================================
    // 5. PROSES PERSETUJUAN / PENOLAKAN IZIN
    // ==========================================
=======
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
>>>>>>> 3533e216f3ad1c5e383005b33ccb6df163a254ee
    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        
        $izin->update([
            'status' => $request->status,
        ]);

        // SINKRONISASI KE ABSENSI
        if ($request->status == 'Disetujui') {
            $cekAbsen = Absensi::where('user_id', $izin->user_id)
                               ->where('tanggal', $izin->tanggal_izin)
                               ->first();

            if (!$cekAbsen) {
                Absensi::create([
                    'user_id' => $izin->user_id,
                    'tanggal' => $izin->tanggal_izin,
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'status' => 'Izin', 
                ]);
            }
        }

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }
}