<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Absensi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JurnalExport;
use App\Exports\AbsensiExport; // Tambahkan import ini
use Barryvdh\DomPDF\Facade\Pdf;

class GuruExportController extends Controller
{
    /**
     * EKSPOR EXCEL JURNAL SISWA
     */
    public function excel()
    {
        return Excel::download(
            new JurnalExport(),
            'laporan-jurnal-siswa.xlsx'
        );
    }

    /**
     * FUNGSI EKSPOR PDF JURNAL SISWA
     */
    public function pdf()
    {
        $jurnal = Jurnal::with('user')
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView(
            'guru.laporan-jurnal-pdf',
            compact('jurnal')
        );

        return $pdf->setPaper('a4', 'landscape')
            ->download('laporan-jurnal-siswa.pdf');
    }

    // ==========================================
    // FUNGSI EXPORT ABSENSI
    // ==========================================

    /**
     * EKSPOR EXCEL ABSENSI
     */
    public function exportExcelAbsensi(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // Panggil class AbsensiExport
        return Excel::download(
            new AbsensiExport($bulan, $tahun), 
            'laporan-absensi-' . $bulan . '-' . $tahun . '.xlsx'
        );
    }

    /**
     * EKSPOR PDF ABSENSI
     */
    public function exportPdfAbsensi(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $absensi = Absensi::with('user')
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // Pastikan file view 'guru.laporan-absensi-pdf' sudah ada
        $pdf = Pdf::loadView('guru.laporan-absensi-pdf', compact('absensi', 'bulan', 'tahun'));
        
        return $pdf->setPaper('a4', 'landscape')
            ->download('laporan-absensi-' . $bulan . '-' . $tahun . '.pdf');
    }
}