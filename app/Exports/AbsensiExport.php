<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $absensi = Absensi::with('user')
                    ->whereMonth('tanggal', $this->bulan)
                    ->whereYear('tanggal', $this->tahun)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        return view('guru.laporan-absensi-excel', [
            'absensi' => $absensi,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}