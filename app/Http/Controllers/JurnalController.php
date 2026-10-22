<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    // Tampilkan jurnal hari ini, riwayat jurnal, dan riwayat izin
    public function index()
    {
        $hariIni = Carbon::today()->toDateString();

        // Jurnal hari ini
        $jurnalHariIni = Jurnal::where('user_id', Auth::id())
            ->where('tanggal', $hariIni)
            ->first();

        // Riwayat jurnal siswa
        $riwayatJurnal = Jurnal::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        // Riwayat pengajuan izin siswa
        $riwayatIzin = Izin::where('user_id', Auth::id())
            ->orderBy('tanggal_izin', 'desc')
            ->get();

        return view('jurnal.index', compact(
            'jurnalHariIni',
            'riwayatJurnal',
            'riwayatIzin'
        ));
    }

    // Simpan jurnal baru
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|string',
            'kendala' => 'nullable|string',
        ]);

        Jurnal::create([
            'user_id' => Auth::id(),
            'tanggal' => Carbon::today()->toDateString(),
            'kegiatan' => $request->kegiatan,
            'kendala' => $request->kendala,
        ]);

        return back()->with(
            'success',
            'Jurnal hari ini berhasil disimpan!'
        );
    }
}
