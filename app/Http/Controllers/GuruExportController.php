<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Absensi;
use App\Models\User;
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

        // Membuat daftar seluruh tanggal dalam bulan yang dipilih
        $jumlahHari = \Carbon\Carbon::create($tahun, $bulan, 1)->daysInMonth;

        $tanggalList = collect();

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggalList->push(
                \Carbon\Carbon::create($tahun, $bulan, $i)
            );
        }

        // Mengambil seluruh siswa
        $siswa = \App\Models\User::where('role', 'user')
            ->orderBy('name', 'asc')
            ->get();

        // Mengambil data absensi pada bulan dan tahun terpilih
        $dataAbsensi = \App\Models\Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Mengelompokkan absensi berdasarkan ID siswa dan tanggal
        $absensi = $dataAbsensi->keyBy(function ($item) {
            return $item->user_id . '-' .
                \Carbon\Carbon::parse($item->tanggal)->format('d');
        });

        // Membuat PDF menggunakan tampilan matriks
        $pdf = Pdf::loadView('guru.laporan-absensi-pdf', compact(
            'siswa',
            'tanggalList',
            'absensi',
            'bulan',
            'tahun'
        ));

        return $pdf->setPaper('a4', 'landscape')
            ->download('laporan-absensi-' . $bulan . '-' . $tahun . '.pdf');
    }
}