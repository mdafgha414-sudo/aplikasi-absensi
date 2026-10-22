<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Support\Collection;

// Fitur-fitur ekspor Excel.
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

// Digunakan untuk mengatur format sel Excel.
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class JurnalExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    /**
     * BAGIAN 1: MENGAMBIL DATA JURNAL
     * Mengambil data jurnal beserta nama pengguna.
     */
    public function collection(): Collection
    {
        return Jurnal::with('user')
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    /**
     * BAGIAN 2: JUDUL KOLOM
     * Menentukan nama kolom pada baris pertama Excel.
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Kegiatan',
            'Kendala',
            'Nilai & Catatan',
        ];
    }

    /**
     * BAGIAN 3: MEMETAKAN DATA
     * Mengatur urutan data yang dimasukkan ke setiap baris.
     */
    public function map($jurnal): array
{
    return [
        $jurnal->tanggal,
        optional($jurnal->user)->name ?? '-',
        $jurnal->kegiatan ?? '-',
        $jurnal->kendala ?? '-',

        // Menggabungkan nilai dan catatan dalam satu kolom.
        'Nilai: ' . ($jurnal->nilai ?? '-') .
        ' | Catatan: ' . ($jurnal->catatan ?? '-'),
    ];
}

    /**
     * BAGIAN 4: MENGATUR TAMPILAN EXCEL
     * Memberikan border, perataan teks, dan format judul.
     */
    public function styles(Worksheet $sheet): ?array
    {
        // Mengambil seluruh area tabel yang berisi data.
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Memberikan border pada seluruh sel tabel.
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Membuat judul kolom menjadi tebal.
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getFont()
            ->setBold(true);

        // Membuat judul kolom berada di tengah.
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Membuat isi tabel rata tengah secara vertikal.
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Memberikan warna latar pada judul kolom.
        $sheet->getStyle("A1:{$lastColumn}1")
            ->getFill()
            ->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )
            ->getStartColor()
            ->setARGB('FFDDEBF7');

        // Menambah tinggi baris judul.
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Mengembalikan array kosong karena semua styling
         // sudah diterapkan langsung melalui objek Worksheet.
        return [];
    }
}