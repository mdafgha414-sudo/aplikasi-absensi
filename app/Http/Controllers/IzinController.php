<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    // ==========================================
    // 1. SISWA: MENAMPILKAN FORM & RIWAYAT IZIN
    // ==========================================
    public function index()
    {
        $riwayatIzin = Izin::where('user_id', Auth::id())
                           ->orderBy('created_at', 'desc')
                           ->get();

        // CEK APAKAH SISWA SUDAH ABSEN HARI INI
        $sudahAbsenHariIni = Absensi::where('user_id', Auth::id())
                                ->whereDate('tanggal', \Carbon\Carbon::today())
                                ->exists();

        return view('izin.index', compact('riwayatIzin', 'sudahAbsenHariIni'));
    }

    // ==========================================
    // 2. SISWA: MENYIMPAN PENGAJUAN IZIN
    // ==========================================
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_izin' => 'required|in:Izin,Sakit,Keperluan Keluarga',
            'tanggal_izin' => 'required|date',
            'alasan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $tanggalIzin = \Carbon\Carbon::parse($request->tanggal_izin)->startOfDay();
        $hariIni = \Carbon\Carbon::today()->startOfDay();

        // ATURAN 1: VALIDASI TANGGAL
        if ($tanggalIzin->lt($hariIni)) {
            return back()->with('error', 'Tidak bisa mengajukan izin untuk tanggal yang sudah lewat.')->withInput();
        }

        if ($request->jenis_izin !== 'Sakit' && $tanggalIzin->lte($hariIni)) {
            return back()->with('error', 'Pengajuan izin (selain sakit) minimal dilakukan H-1 (besok).')->withInput();
        }

        // ATURAN 2: CEK APAKAH SUDAH ABSEN DI TANGGAL TERSEBUT
        $cekAbsen = Absensi::where('user_id', Auth::id())
                           ->whereDate('tanggal', $tanggalIzin)
                           ->first();
                           
        if ($cekAbsen) {
            return back()->with('error', 'Anda sudah melakukan absensi di tanggal tersebut. Pengajuan izin dibatalkan.')->withInput();
        }

        // ATURAN 3: CEK APAKAH SUDAH ADA PENGAJUAN IZIN
        $cekIzin = Izin::where('user_id', Auth::id())
                       ->whereDate('tanggal_izin', $tanggalIzin)
                       ->first();

        if ($cekIzin) {
            return back()->with('error', 'Anda sudah mengajukan izin untuk tanggal tersebut.')->withInput();
        }

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran-izin', 'public');
        }

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'Menunggu';

        Izin::create($data);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim dan sedang menunggu persetujuan.');
    }

    // ==========================================
    // 3. PEMBIMBING: MELIHAT DAFTAR IZIN SISWA
    // ==========================================
    public function indexPembimbing()
    {
        $pembimbing = Auth::user();

        $daftarIzin = Izin::with('user')
            ->whereHas('user', function ($query) use ($pembimbing) {
                $query->where(function($q) use ($pembimbing) {
                    if ($pembimbing->perusahaan_id) {
                        $q->where('perusahaan_id', $pembimbing->perusahaan_id);
                    } elseif ($pembimbing->sekolah_id) {
                        $q->where('sekolah_id', $pembimbing->sekolah_id);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembimbing.izin.index', compact('daftarIzin')); 
    }
}