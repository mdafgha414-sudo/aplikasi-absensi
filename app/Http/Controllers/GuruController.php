<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi; 
use App\Models\Izin; 
use App\Models\Jurnal;
use App\Models\AlasanKeterlambatan;
use App\Models\Sekolah;
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

    public function laporanAbsensi(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $sekolahFilter = $request->input('sekolah');

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        // 1. Ambil daftar sekolah dari Master Data
        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();

        // 2. Ambil siswa dengan filter sekolah_id
        $querySiswa = User::where('role', 'user')->with('sekolah');
        if ($sekolahFilter && $sekolahFilter != 'Semua') {
            $querySiswa->where('sekolah_id', $sekolahFilter);
        }
        $siswa = $querySiswa->orderBy('sekolah_id', 'asc')->orderBy('name', 'asc')->get();

        // 3. Ambil data absensi lengkap
        $absensi = Absensi::whereMonth('tanggal', $bulan)
                          ->whereYear('tanggal', $tahun)
                          ->get()
                          ->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });

        // 4. Ambil data izin (TAMBAHAN BARU)
        $izin = Izin::whereMonth('tanggal_izin', $bulan)
                    ->whereYear('tanggal_izin', $tahun)
                    ->get()
                    ->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        // 5. Ambil data alasan keterlambatan
        $alasanKeterlambatan = AlasanKeterlambatan::whereMonth('tanggal', $bulan)
                                                  ->whereYear('tanggal', $tahun)
                                                  ->get()
                                                  ->keyBy(function($item) {
                                                      return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                                                  });

        if (Auth::user()->role === 'pembimbing') {
            return view('pembimbing.laporan-absensi', compact('siswa', 'tanggalList', 'absensi', 'izin', 'alasanKeterlambatan', 'bulan', 'tahun', 'daftarSekolah', 'sekolahFilter'));
        }

        return view('guru.laporan-absensi', compact('siswa', 'tanggalList', 'absensi', 'izin', 'alasanKeterlambatan', 'bulan', 'tahun', 'daftarSekolah', 'sekolahFilter'));
    }

    public function lihatIzin(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $sekolahFilter = $request->input('sekolah');

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        // Ambil daftar sekolah untuk dropdown
        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();

        // Ambil siswa dengan filter sekolah (jika ada)
        $querySiswa = User::where('role', 'user')->with('sekolah');
        if ($sekolahFilter && $sekolahFilter != 'Semua') {
            $querySiswa->where('sekolah_id', $sekolahFilter);
        }
        $siswa = $querySiswa->orderBy('name', 'asc')->get();
        
        $absensi = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get()->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });
                          
        $izin = Izin::whereMonth('tanggal_izin', $bulan)->whereYear('tanggal_izin', $tahun)->get()->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
                    });

        // TAMBAHAN BARU: Ambil data alasan keterlambatan
        $alasanKeterlambatan = AlasanKeterlambatan::whereMonth('tanggal', $bulan)
                                                  ->whereYear('tanggal', $tahun)
                                                  ->get()
                                                  ->keyBy(function($item) {
                                                      return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                                                  });

        if (Auth::user()->role === 'pembimbing') {
            $query = Izin::with('user')->orderBy('created_at', 'desc');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status') && $request->status != 'Semua') {
                $query->where('status', $request->status);
            }

            $waktu = $request->input('waktu', 'semua');
            if ($waktu == 'hari_ini') {
                $query->whereDate('tanggal_izin', Carbon::today());
            } elseif ($waktu == '7_hari') {
                $query->whereDate('tanggal_izin', '>=', Carbon::today()->subDays(7));
            } elseif ($waktu == 'bulan_ini') {
                $query->whereMonth('tanggal_izin', Carbon::now()->month)->whereYear('tanggal_izin', Carbon::now()->year);
            } elseif ($waktu == 'bulan_lalu') { 
                $query->whereMonth('tanggal_izin', Carbon::now()->subMonth()->month)->whereYear('tanggal_izin', Carbon::now()->subMonth()->year);
            } elseif ($waktu == 'pilih_bulan' && $request->filled('bulan_filter')) { 
                $parts = explode('-', $request->bulan_filter);
                $query->whereMonth('tanggal_izin', $parts[1])->whereYear('tanggal_izin', $parts[0]);
            }

            $semuaIzin = $query->paginate(10)->withQueryString();
            $jumlahMenunggu = Izin::where('status', 'Menunggu')->count();

            return view('dashboard.izin_pembimbing', compact(
                'semuaIzin', 'jumlahMenunggu', 'siswa', 'tanggalList', 'absensi', 'izin', 'alasanKeterlambatan', 'bulan', 'tahun', 'daftarSekolah', 'sekolahFilter'
            ));
        }

        return view('dashboard.izin_guru', compact('siswa', 'tanggalList', 'absensi', 'izin', 'alasanKeterlambatan', 'bulan', 'tahun', 'daftarSekolah', 'sekolahFilter'));
    }

    public function updateIzin(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Disetujui,Ditolak']);
        $izin = Izin::findOrFail($id);
        $izin->update(['status' => $request->status]);

        if ($request->status == 'Disetujui') {
            $cekAbsen = Absensi::where('user_id', $izin->user_id)->where('tanggal', $izin->tanggal_izin)->first();
            if (!$cekAbsen) {
                Absensi::create([
                    'user_id' => $izin->user_id, 'tanggal' => $izin->tanggal_izin,
                    'jam_masuk' => null, 'jam_pulang' => null, 'status' => 'Izin', 
                ]);
            } else {
                $cekAbsen->update(['status' => 'Izin', 'jam_masuk' => null, 'jam_pulang' => null]);
            }
        }
        return back()->with('success', 'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status);
    }

        // ==========================================================
    // DASHBOARD PEMBIMBING PKL - TIMETRIX
    // ----------------------------------------------------------
    // Fungsi:
    // Menampilkan halaman utama dashboard Pembimbing PKL.
    //
    // Data yang disediakan:
    // 1. Lima jurnal siswa terbaru.
    // 2. Nama siswa melalui relasi model User.
    // 3. Data penilaian jurnal.
    // 4. Statistik ringkasan dashboard.
    //
    // View:
    // resources/views/dashboard/user_pembimbing.blade.php
    //
    // Catatan:
    // Data diambil langsung dari database sehingga dashboard
    // otomatis diperbarui ketika halaman dibuka.
    // ==========================================================
    public function dashboardPembimbing()
    {
        // ------------------------------------------------------
        // BAGIAN 1: RIWAYAT JURNAL TERBARU
        // Mengambil lima jurnal terakhir beserta data siswa.
        // ------------------------------------------------------
        $jurnalTerbaru = Jurnal::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        // ------------------------------------------------------
        // BAGIAN 2: TOTAL SISWA
        // Menghitung jumlah seluruh akun dengan role user.
        // ------------------------------------------------------
        $totalSiswa = User::where('role', 'user')->count();


        // ------------------------------------------------------
        // BAGIAN 3: TOTAL JURNAL
        // Menghitung seluruh jurnal yang sudah dikirim siswa.
        // ------------------------------------------------------
        $totalJurnal = Jurnal::count();


        // ------------------------------------------------------
        // BAGIAN 4: JURNAL BELUM DINILAI
        // Menghitung jurnal yang belum mendapatkan nilai.
        // ------------------------------------------------------
        $jurnalBelumDinilai = Jurnal::whereNull('nilai')->count();


        // ------------------------------------------------------
        // BAGIAN 5: JURNAL SUDAH DINILAI
        // Menghitung jurnal yang sudah mendapatkan nilai.
        // ------------------------------------------------------
        $jurnalSudahDinilai = Jurnal::whereNotNull('nilai')->count();


        // ------------------------------------------------------
        // BAGIAN 6: KIRIM DATA KE HALAMAN DASHBOARD
        // Semua variabel di atas dikirim ke Blade agar dapat
        // ditampilkan secara otomatis pada tampilan dashboard.
        // ------------------------------------------------------
        return view('dashboard.user_pembimbing', compact(
            'jurnalTerbaru',
            'totalSiswa',
            'totalJurnal',
            'jurnalBelumDinilai',
            'jurnalSudahDinilai'
        ));
    }

    // ==========================================
    // FUNGSI ALASAN KETERLAMBATAN (GURU)
    // ==========================================
    public function alasanKeterlambatan()
    {
        $alasanKeterlambatan = AlasanKeterlambatan::with('user')
                                ->orderBy('created_at', 'desc')
                                ->get();
                                
        return view('guru.alasan-keterlambatan', compact('alasanKeterlambatan'));
    }
}