<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class IzinController extends Controller
{
    // 1. FUNGSI UNTUK MENAMPILKAN HALAMAN FORM & RIWAYAT IZIN
    public function index()
    {
        // Ambil riwayat izin milik user yang sedang login
        $riwayatIzin = Izin::where('user_id', Auth::id())
                           ->orderBy('created_at', 'desc')
                           ->get();

        // Arahkan ke view 'resources/views/izin/index.blade.php'
        return view('izin.index', compact('riwayatIzin'));
    }

    // 2. FUNGSI UNTUK MENYIMPAN PENGAJUAN IZIN (Kode dari teman Anda)
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_izin' => 'required|in:Izin,Sakit,Keperluan Keluarga',
            'tanggal_izin' => 'required|date|after_or_equal:today',
            'alasan' => 'required|string|max:500',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

            // CEK APAKAH SUDAH ADA ABSEN DI TANGGAL TERSEBUT
        $cekAbsen = \App\Models\Absensi::where('user_id', Auth::id())
                                       ->where('tanggal', $request->tanggal_izin)
                                       ->first();
                                       
        if ($cekAbsen) {
            return back()->with('error', 'Anda sudah melakukan absensi di tanggal tersebut. Pengajuan izin dibatalkan.');
        }

          // CEK APAKAH SUDAH ADA PENGAJUAN IZIN DI TANGGAL TERSEBUT
        $cekIzin = \App\Models\Izin::where('user_id', Auth::id())
                                   ->where('tanggal_izin', $request->tanggal_izin)
                                   ->first();

        if ($cekIzin) {
            return back()->with('error', 'Anda sudah mengajukan izin untuk tanggal tersebut.');
        }


        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')
                ->store('lampiran-izin', 'public');
        }

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'Menunggu';

        Izin::create($data);

        return redirect()->back()->with(
            'success',
            'Pengajuan izin berhasil dikirim dan sedang menunggu persetujuan.'
        );
    }
}