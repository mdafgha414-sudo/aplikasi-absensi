<?php

namespace App\Http\Controllers;

// Model untuk mengambil data jurnal siswa dari database.
use App\Models\Jurnal;

// Library untuk membuat file Excel.
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JurnalExport;

// Library untuk membuat file PDF.
use Barryvdh\DomPDF\Facade\Pdf;

class GuruExportController extends Controller
{
    /**
     * EKSPOR EXCEL JURNAL SISWA
     * Mengunduh jurnal, bukan data absensi.
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
     * Mengambil data jurnal dan membuat laporan PDF.
     */
    public function pdf()
    {
        // Mengambil data jurnal beserta relasi pengguna.
        // Relasi user digunakan untuk mendapatkan nama siswa.
        $jurnal = Jurnal::with('user')

            // Mengurutkan jurnal berdasarkan tanggal terbaru.
            ->orderBy('tanggal', 'desc')

            // Menjalankan query dan mengambil data dari database.
            ->get();

        // Memuat template Blade khusus laporan jurnal PDF.
        // compact('jurnal') mengirim variabel $jurnal ke template.
        $pdf = Pdf::loadView(
            'guru.laporan-jurnal-pdf',
            compact('jurnal')
        );

        // Mengatur ukuran kertas A4 dengan orientasi landscape,
        // kemudian mengunduh hasilnya sebagai file PDF.
        return $pdf->setPaper('a4', 'landscape')
            ->download('laporan-jurnal-siswa.pdf');
    }
}