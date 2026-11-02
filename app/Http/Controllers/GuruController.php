<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi; 
use App\Models\Izin; 
use App\Models\Jurnal;
use App\Models\AlasanKeterlambatan;
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

        if (Auth::user()->role === 'pembimbing') {
            return view('pembimbing.laporan-absensi', compact('siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'));
        }

        return view('guru.laporan-absensi', compact('siswa', 'tanggalList', 'absensi', 'bulan', 'tahun'));
    }

    public function lihatIzin(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $startDate = Carbon::createFromDate($tahun, $bulan, 1);
        $daysInMonth = $startDate->daysInMonth;
        $tanggalList = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $tanggalList[] = Carbon::createFromDate($tahun, $bulan, $i);
        }

        $siswa = User::where('role', 'user')->orderBy('name', 'asc')->get();
        
        $absensi = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get()->keyBy(function($item) {
                              return $item->user_id . '-' . date('d', strtotime($item->tanggal));
                          });
                          
        $izin = Izin::whereMonth('tanggal_izin', $bulan)->whereYear('tanggal_izin', $tahun)->get()->keyBy(function($item) {
                        return $item->user_id . '-' . date('d', strtotime($item->tanggal_izin));
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
                'semuaIzin', 'jumlahMenunggu', 'siswa', 'tanggalList', 'absensi', 'izin', 'bulan', 'tahun'
            ));
        }

        return view('dashboard.izin_guru', compact('siswa', 'tanggalList', 'absensi', 'izin', 'bulan', 'tahun'));
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

    public function dashboardPembimbing()
    {
        $jurnalTerbaru = Jurnal::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.user_pembimbing', compact('jurnalTerbaru'));
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