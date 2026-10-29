<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithStyles
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection(): \Illuminate\Support\Enumerable
    {
        $siswa = User::where('role', 'user')
            ->orderBy('name')
            ->get();

        $jumlahHari = Carbon::create(
            (int) $this->tahun,
            (int) $this->bulan,
            1
        )->daysInMonth;

        $data = [];

        foreach ($siswa as $index => $user) {
            $baris = [
                'No' => $index + 1,
                'Nama Siswa' => $user->name,
            ];

            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $tanggal = Carbon::create(
                    (int) $this->tahun,
                    (int) $this->bulan,
                    $hari
                );

                $absensi = Absensi::where('user_id', $user->id)
                    ->whereDate('tanggal', $tanggal->toDateString())
                    ->first();

                $status = $absensi ? $absensi->status : null;

                if ($status === 'Tepat Waktu' || $status === 'Hadir') {
                    $label = 'H';
                } elseif ($status === 'Telat') {
                    $label = 'T';
                } elseif ($status === 'Izin') {
                    $label = 'I';
                } elseif ($status === 'Sakit') {
                    $label = 'S';
                } elseif ($status === 'Alpa') {
                    $label = 'A';
                } else {
                    // Hari tanpa absensi pada hari kerja yang sudah lewat.
                    if (
                        !in_array($tanggal->dayOfWeek, [
                            Carbon::SATURDAY,
                            Carbon::SUNDAY,
                        ]) &&
                        $tanggal->isPast()
                    ) {
                        $label = 'A';
                    } else {
                        $label = '-';
                    }
                }

                $baris[
                    $tanggal->format('d D')
                ] = $label;
            }

            $data[] = $baris;
        }

        return collect($data);
    }

    public function headings(): array
    {
        $jumlahHari = Carbon::create(
            (int) $this->tahun,
            (int) $this->bulan,
            1
        )->daysInMonth;

        $headings = ['No', 'Nama Siswa'];

        for ($hari = 1; $hari <= $jumlahHari; $hari++) {
            $tanggal = Carbon::create(
                (int) $this->tahun,
                (int) $this->bulan,
                $hari
            );

            $headings[] = $tanggal->format('d D');
        }

        return $headings;
    }

    public function styles(Worksheet $sheet): array
    {
        $jumlahKolom = $sheet->getHighestColumn();

        // Warna lavender untuk seluruh baris judul.
        $sheet->getStyle("A1:{$jumlahKolom}1")->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'E6E6FA'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getStyle(
            'A1:' . $jumlahKolom . $sheet->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(24);

        for ($kolom = 3; $kolom <= \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($jumlahKolom); $kolom++) {
            $sheet->getColumnDimension(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($kolom)
            )->setWidth(12);
        }

        // Warna sel berdasarkan status kehadiran.
        $warnaStatus = [
            'H' => '86EFAC', // Hijau
            'T' => 'FDBA74', // Oranye
            'A' => 'FCA5A5', // Merah
            'S' => 'FDE047', // Kuning
            'I' => '93C5FD', // Biru muda
        ];

        foreach ($warnaStatus as $status => $warna) {
            $sheet->getStyle(
                "C2:{$jumlahKolom}" . $sheet->getHighestRow()
            )->getConditionalStyles();

            $conditional = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
            $conditional->setConditionType(
                \PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT
            );
            $conditional->setOperatorType(
                \PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT
            );
            $conditional->setText($status);
            $conditional->getStyle()->getFill()
                ->setFillType('solid')
                ->getStartColor()->setRGB($warna);

            $range = "C2:{$jumlahKolom}" . $sheet->getHighestRow();
            $styles = $sheet->getStyle($range)->getConditionalStyles();
            $styles[] = $conditional;
            $sheet->getStyle($range)->setConditionalStyles($styles);
        }

        return [];
    }
}