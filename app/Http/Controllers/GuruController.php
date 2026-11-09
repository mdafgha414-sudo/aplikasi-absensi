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
    // =====================================================
    // LAPORAN JURNAL SISWA + FILTER BULAN DAN TAHUN
    // =====================================================
    public function index(Request $request)
    {
        $user = Auth::user();

        // Daftar nama bulan
        $daftarBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // Ambil pilihan filter dari URL
        $bulan = $request->input('bulan', 'semua');
        $tahun = $request->input('tahun', 'semua');

        // Validasi pilihan bulan
        if ($bulan !== 'semua' && !array_key_exists($bulan, $daftarBulan)) {
            $bulan = 'semua';
        }

        // Validasi pilihan tahun
        if ($tahun !== 'semua' && !preg_match('/^\d{4}$/', (string) $tahun)) {
            $tahun = 'semua';
        }

        // Query jurnal
        $queryJurnal = Jurnal::with('user');

        // Pembimbing hanya melihat jurnal siswa dari perusahaannya
        if ($user->role === 'pembimbing') {
            $queryJurnal->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            });
        }

        // Query untuk mengambil daftar tahun yang tersedia
        $queryTahun = Jurnal::query();

        if ($user->role === 'pembimbing') {
            $queryTahun->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            });
        }

        $daftarTahun = $queryTahun
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun')
            ->map(function ($item) {
                return (string) $item;
            })
            ->values();

        // Jika belum ada jurnal, tetap tampilkan tahun sekarang
        if ($daftarTahun->isEmpty()) {
            $daftarTahun = collect([(string) date('Y')]);
        }

        // Filter berdasarkan bulan
        if ($bulan !== 'semua') {
            $queryJurnal->whereMonth('tanggal', (int) $bulan);
        }

        // Filter berdasarkan tahun
        if ($tahun !== 'semua') {
            $queryJurnal->whereYear('tanggal', (int) $tahun);
        }

        // Ambil jurnal sesuai filter
        $semuaJurnal = $queryJurnal
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung total siswa
        $querySiswa = User::where('role', 'user');

        if ($user->role === 'pembimbing') {
            $querySiswa->where('perusahaan_id', $user->perusahaan_id);
        }

        $totalSiswa = $querySiswa->count();

        return view('dashboard.guru', compact(
            'semuaJurnal',
            'totalSiswa',
            'bulan',
            'tahun',
            'daftarBulan',
            'daftarTahun'
        ));
    }


    // =====================================================
    // MEMBERIKAN NILAI JURNAL
    // =====================================================
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan_guru' => 'nullable|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);

        // Pembimbing hanya boleh menilai jurnal perusahaannya
        if (
            Auth::user()->role === 'pembimbing' &&
            $jurnal->user->perusahaan_id !== Auth::user()->perusahaan_id
        ) {
            return back()->with('error', 'Anda tidak memiliki akses ke jurnal ini.');
        }

        $jurnal->update([
            'nilai' => $request->nilai,
            'catatan_guru' => $request->catatan_guru,
        ]);

        return back()->with('success', 'Penilaian dan catatan berhasil disimpan!');
    }


    // =====================================================
    // LAPORAN ABSENSI
    // =====================================================
    public function laporanAbsensi(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $sekolahFilter = $request->input('sekolah');
        $user = Auth::user();

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;

        $tanggalList = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();

        // Filter siswa
        $querySiswa = User::where('role', 'user')->with('sekolah');

        if ($user->role === 'pembimbing') {
            $querySiswa->where('perusahaan_id', $user->perusahaan_id);
        }

        if ($sekolahFilter && $sekolahFilter != 'Semua') {
            $querySiswa->where('sekolah_id', $sekolahFilter);
        }

        $siswa = $querySiswa
            ->orderBy('sekolah_id', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $absensi = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal));
            });

        $izin = Izin::whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
            });

        $alasanKeterlambatan = AlasanKeterlambatan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal));
            });

        if ($user->role === 'pembimbing') {
            return view('pembimbing.laporan-absensi', compact(
                'siswa',
                'tanggalList',
                'absensi',
                'izin',
                'alasanKeterlambatan',
                'bulan',
                'tahun',
                'daftarSekolah',
                'sekolahFilter'
            ));
        }

        return view('guru.laporan-absensi', compact(
            'siswa',
            'tanggalList',
            'absensi',
            'izin',
            'alasanKeterlambatan',
            'bulan',
            'tahun',
            'daftarSekolah',
            'sekolahFilter'
        ));
    }


    // =====================================================
    // MELIHAT IZIN SISWA
    // =====================================================
    public function lihatIzin(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $sekolahFilter = $request->input('sekolah');
        $user = Auth::user();

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;

        $tanggalList = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        $daftarSekolah = Sekolah::orderBy('nama_sekolah', 'asc')->get();

        $querySiswa = User::where('role', 'user')->with('sekolah');

        if ($user->role === 'pembimbing') {
            $querySiswa->where('perusahaan_id', $user->perusahaan_id);
        }

        if ($sekolahFilter && $sekolahFilter != 'Semua') {
            $querySiswa->where('sekolah_id', $sekolahFilter);
        }

        $siswa = $querySiswa->orderBy('name', 'asc')->get();

        $absensi = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal));
            });

        $izin = Izin::whereMonth('tanggal_izin', $bulan)
            ->whereYear('tanggal_izin', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
            });

        $alasanKeterlambatan = AlasanKeterlambatan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . date('d', strtotime($item->tanggal));
            });

        if ($user->role === 'pembimbing') {
            $query = Izin::with('user')->orderBy('created_at', 'desc');

            // Hanya izin dari perusahaan pembimbing
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            });

            if ($request->filled('search')) {
                $search = $request->search;

                $query->whereHas('user', function ($q) use ($search) {
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
                $query->whereMonth('tanggal_izin', Carbon::now()->month)
                    ->whereYear('tanggal_izin', Carbon::now()->year);

            } elseif ($waktu == 'bulan_lalu') {
                $query->whereMonth('tanggal_izin', Carbon::now()->subMonth()->month)
                    ->whereYear('tanggal_izin', Carbon::now()->subMonth()->year);

            } elseif ($waktu == 'pilih_bulan' && $request->filled('bulan_filter')) {
                $parts = explode('-', $request->bulan_filter);

                if (count($parts) === 2) {
                    $query->whereMonth('tanggal_izin', $parts[1])
                        ->whereYear('tanggal_izin', $parts[0]);
                }
            }

            $semuaIzin = $query->paginate(10)->withQueryString();

            // Hitung jumlah menunggu dari perusahaan pembimbing
            $jumlahMenunggu = Izin::where('status', 'Menunggu')
                ->whereHas('user', function ($q) use ($user) {
                    $q->where('perusahaan_id', $user->perusahaan_id);
                })
                ->count();

            return view('dashboard.izin_pembimbing', compact(
                'semuaIzin',
                'jumlahMenunggu',
                'siswa',
                'tanggalList',
                'absensi',
                'izin',
                'alasanKeterlambatan',
                'bulan',
                'tahun',
                'daftarSekolah',
                'sekolahFilter'
            ));
        }

        return view('dashboard.izin_guru', compact(
            'siswa',
            'tanggalList',
            'absensi',
            'izin',
            'alasanKeterlambatan',
            'bulan',
            'tahun',
            'daftarSekolah',
            'sekolahFilter'
        ));
    }


    // =====================================================
    // MEMPERBARUI STATUS IZIN
    // =====================================================
    public function updateIzin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $izin = Izin::findOrFail($id);

        // Pembimbing hanya boleh update izin perusahaannya
        if (
            Auth::user()->role === 'pembimbing' &&
            $izin->user->perusahaan_id !== Auth::user()->perusahaan_id
        ) {
            return back()->with('error', 'Anda tidak memiliki akses ke pengajuan izin ini.');
        }

        $izin->update([
            'status' => $request->status
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
            } else {
                $cekAbsen->update([
                    'status' => 'Izin',
                    'jam_masuk' => null,
                    'jam_pulang' => null
                ]);
            }
        }

        return back()->with(
            'success',
            'Status pengajuan izin berhasil diperbarui menjadi: ' . $request->status
        );
    }


    // =====================================================
    // DASHBOARD PEMBIMBING
    // =====================================================
    public function dashboardPembimbing()
    {
        $user = Auth::user();

        // Jurnal terbaru dari perusahaan pembimbing
        $jurnalTerbaru = Jurnal::with('user')
            ->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Total siswa
        $totalSiswa = User::where('role', 'user')
            ->where('perusahaan_id', $user->perusahaan_id)
            ->count();

        // Total jurnal
        $totalJurnal = Jurnal::whereHas('user', function ($q) use ($user) {
            $q->where('perusahaan_id', $user->perusahaan_id);
        })->count();

        // Jurnal belum dinilai
        $jurnalBelumDinilai = Jurnal::whereNull('nilai')
            ->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            })->count();

        // Jurnal sudah dinilai
        $jurnalSudahDinilai = Jurnal::whereNotNull('nilai')
            ->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            })->count();

        return view('dashboard.user_pembimbing', compact(
            'jurnalTerbaru',
            'totalSiswa',
            'totalJurnal',
            'jurnalBelumDinilai',
            'jurnalSudahDinilai'
        ));
    }


    // =====================================================
    // ALASAN KETERLAMBATAN
    // =====================================================
    public function alasanKeterlambatan()
    {
        $user = Auth::user();

        $query = AlasanKeterlambatan::with('user');

        // Filter untuk pembimbing
        if ($user->role === 'pembimbing') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('perusahaan_id', $user->perusahaan_id);
            });
        }

        $alasanKeterlambatan = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.alasan-keterlambatan', compact('alasanKeterlambatan'));
    }

        // FUNGSI BARU: Menyimpan Absensi Manual / Backdate
    public function simpanAbsensiManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Telat',
            'jam_masuk' => 'nullable',
            'jam_pulang' => 'nullable',
        ]);

        // Cek apakah data sudah ada
        $absen = Absensi::where('user_id', $request->user_id)
                        ->where('tanggal', $request->tanggal)
                        ->first();

        $data = [
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            // Tambahkan keterangan bahwa ini diinput manual (opsional)
            'is_manual' => true 
        ];

        if ($absen) {
            $absen->update($data);
        } else {
            Absensi::create($data);
        }

        return response()->json(['message' => 'Absensi manual berhasil disimpan!']);
    }
}
