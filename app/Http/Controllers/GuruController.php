<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi; 
use App\Models\Izin; 
use App\Models\Jurnal;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk mengecek role

class GuruController extends Controller
{
    public function index()
    {
        $semuaJurnal = Jurnal::with('user')->orderBy('tanggal', 'desc')->get();
        $totalSiswa = User::where('role', 'user')->count();
        
        return view('dashboard.guru', compact('semuaJurnal', 'totalSiswa'));
    }

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

    public function laporanAbsensi()
    {
        $laporanAbsensi = Absensi::with('user')->latest()->get(); 
        return view('guru.laporan-absensi', compact('laporanAbsensi'));
    }

    // ==========================================
    // FUNGSI LIHAT IZIN (DIPISAH ANTARA GURU & PEMBIMBING)
    // ==========================================
    public function lihatIzin(Request $request)
    {
        // 1. JIKA YANG LOGIN ADALAH PEMBIMBING
        // Tampilkan tabel daftar izin dengan tombol Setujui/Tolak
        if (Auth::user()->role === 'pembimbing') {
            $semuaIzin = Izin::with('user')->orderBy('created_at', 'desc')->get();
            return view('dashboard.izin_pembimbing', compact('semuaIzin'));
        }

        // 2. JIKA YANG LOGIN ADALAH GURU
        // Tampilkan matriks kalender kehadiran (hanya melihat)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();

        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        $izin = Izin::whereMonth('tanggal_izin', $bulan)
                    ->whereYear('tanggal_izin', $tahun)
                    ->get()
                    ->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        return view('dashboard.izin_guru', compact(
            'siswa', 
            'tanggalList', 
            'absensi', 
            'izin',
            'bulan',
            'tahun'
        ));
    }

    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        
        $izin->update([
            'status' => $request->status,
        ]);

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