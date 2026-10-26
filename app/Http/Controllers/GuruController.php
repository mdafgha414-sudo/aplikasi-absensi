<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi; 
use App\Models\Izin; 
use App\Models\Jurnal;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;

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

    // ==========================================
    // FUNGSI LAPORAN ABSENSI (MATRIKS)
    // ==========================================
    public function laporanAbsensi(Request $request)
    {
        // Ambil bulan dan tahun dari request, default bulan ini
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Siapkan daftar tanggal 1 - 31
        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        // Ambil semua siswa
        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();

        // Ambil data absensi untuk bulan ini, keyBy untuk memudahkan pencarian
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // Cek role untuk menentukan view yang tepat
        if (Auth::user()->role === 'pembimbing') {
            // Untuk Pembimbing: arahkan ke view pembimbing
            return view('pembimbing.laporan-absensi', compact(
                'siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'
            ));
        }

        // Untuk Guru: arahkan ke view guru
        return view('guru.laporan-absensi', compact(
            'siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'
        ));
    }

    // ==========================================
    // FUNGSI LIHAT IZIN (MATRIKS UNTUK GURU & PEMBIMBING)
    // ==========================================
    public function lihatIzin(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // 1. Siapkan daftar tanggal (1 - 31)
        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        // 2. Ambil semua siswa
        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();

        // 3. Ambil data absensi
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // 4. Ambil data izin (untuk matriks)
        $izin = Izin::whereMonth('tanggal_izin', $bulan)
                    ->whereYear('tanggal_izin', $tahun)
                    ->get()
                    ->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        // 5. Tentukan View berdasarkan role
        if (Auth::user()->role === 'pembimbing') {
            $izinMenunggu = Izin::with('user')
                                ->where('status', 'Menunggu')
                                ->orderBy('created_at', 'asc')
                                ->get();

            return view('dashboard.izin_pembimbing', compact(
                'siswa', 'tanggalList', 'absensi', 'izin', 'bulan', 'tahun', 'izinMenunggu'
            ));
        }

        // Untuk guru: tampilkan matriks (hanya melihat)
        return view('dashboard.izin_guru', compact(
            'siswa', 'tanggalList', 'absensi', 'izin', 'bulan', 'tahun'
        ));
    }

    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        
        // 1. Update status pengajuan izin
        $izin->update([
            'status' => $request->status,
        ]);

        // 2. Sinkronisasi ke tabel Absensi
        if ($request->status == 'Disetujui') {
            // Cari data absensi siswa di tanggal tersebut
            $cekAbsen = Absensi::where('user_id', $izin->user_id)
                               ->where('tanggal', $izin->tanggal_izin)
                               ->first();

            if (!$cekAbsen) {
                // Jika belum ada data absen, buat baru dengan status Izin
                Absensi::create([
                    'user_id' => $izin->user_id,
                    'tanggal' => $izin->tanggal_izin,
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                    'status' => 'Izin', 
                ]);
            } else {
                // Jika sudah ada (misal sebelumnya Tepat Waktu/Telat), paksa ubah jadi Izin
                $cekAbsen->update([
                    'status' => 'Izin',
                    'jam_masuk' => null, // Kosongkan jam masuk karena izin
                    'jam_pulang' => null,
                ]);
            }
        }

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }
}