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

        // Ambil data absensi
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // Cek role untuk menentukan view
        if (Auth::user()->role === 'pembimbing') {
            return view('pembimbing.laporan-absensi', compact(
                'siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'
            ));
        }

        return view('guru.laporan-absensi', compact(
            'siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'
        ));
    }

    // ==========================================
    // FUNGSI LIHAT IZIN (DIPISAH GURU & PEMBIMBING)
    // ==========================================
    public function lihatIzin(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Siapkan daftar tanggal (1 - 31) untuk Matriks Guru
        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();

        // Ambil data absensi
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // Ambil data izin (untuk matriks)
        $izin = Izin::whereMonth('tanggal_izin', $bulan)
                    ->whereYear('tanggal_izin', $tahun)
                    ->get()
                    ->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        // Cek role
        if (Auth::user()->role === 'pembimbing') {
            // UNTUK PEMBIMBING: Gunakan list approval dengan pagination
            $query = Izin::with('user')->orderBy('created_at', 'desc');

            // 1. Filter Pencarian (Nama Siswa)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            // 2. Filter Status
            if ($request->filled('status') && $request->status != 'Semua') {
                $query->where('status', $request->status);
            }

            // 3. Filter Rentang Waktu (Quick Filter)
            $waktu = $request->input('waktu', 'semua');
            
            if ($waktu == 'hari_ini') {
                $query->whereDate('tanggal_izin', Carbon::today());
            } elseif ($waktu == '7_hari') {
                $query->whereDate('tanggal_izin', '>=', Carbon::today()->subDays(7));
            } elseif ($waktu == 'bulan_ini') {
                $query->whereMonth('tanggal_izin', Carbon::now()->month)
                      ->whereYear('tanggal_izin', Carbon::now()->year);
            } elseif ($waktu == 'bulan_lalu') { // <-- Tambahan Baru
                $query->whereMonth('tanggal_izin', Carbon::now()->subMonth()->month)
                      ->whereYear('tanggal_izin', Carbon::now()->subMonth()->year);
            } elseif ($waktu == 'pilih_bulan' && $request->filled('bulan_filter')) { // <-- Tambahan Baru
                // Format bulan_filter: YYYY-MM (contoh: 2026-09)
                $parts = explode('-', $request->bulan_filter);
                $query->whereMonth('tanggal_izin', $parts[1])
                      ->whereYear('tanggal_izin', $parts[0]);
            }

            // Pagination
            $semuaIzin = $query->paginate(10)->withQueryString();
            $jumlahMenunggu = Izin::where('status', 'Menunggu')->count();

            return view('dashboard.izin_pembimbing', compact('semuaIzin', 'jumlahMenunggu'));
        }

        // UNTUK GURU: Tampilkan matriks (hanya melihat)
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
            } else {
                $cekAbsen->update([
                    'status' => 'Izin',
                    'jam_masuk' => null,
                    'jam_pulang' => null,
                ]);
            }
        }

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }
}