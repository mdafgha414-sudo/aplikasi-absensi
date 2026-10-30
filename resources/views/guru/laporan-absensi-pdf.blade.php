<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Laporan Absensi</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: sans-serif;
            font-size: 8px;
            color: #222;
        }

        h3 {
            text-align: center;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 9px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #bfc9d8;
            text-align: center;
            padding: 4px 1px;
        }

        th {
            background-color: #eaf0f8;
            font-weight: bold;
        }

        .no {
            width: 25px;
        }

        .nama {
            width: 105px;
            text-align: left;
            padding-left: 5px;
        }

        .tanggal {
            font-size: 7px;
            width: auto;
        }

        .nama-siswa {
            text-align: left;
            font-weight: bold;
            padding-left: 5px;
        }

        .hadir {
            background-color: #a7f3d0;
            color: #047857;
            font-weight: bold;
        }

        .telat {
            background-color: #fed7aa;
            color: #c2410c;
            font-weight: bold;
        }

        .izin {
            background-color: #bfdbfe;
            color: #1d4ed8;
            font-weight: bold;
        }

        .sakit {
            background-color: #fef08a;
            color: #854d0e;
            font-weight: bold;
        }

        .alpa {
            background-color: #fecaca;
            color: #b91c1c;
            font-weight: bold;
        }

        .kosong {
            background-color: #f1f5f9;
            color: #64748b;
        }

        .keterangan {
            margin-top: 15px;
            font-size: 9px;
        }

        .keterangan td {
            padding: 5px;
        }

        .keterangan-title {
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>

    <h3>Laporan Absensi Siswa</h3>

    <div class="subtitle">
        Bulan {{ $bulan }} Tahun {{ $tahun }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th class="nama">Nama Siswa</th>

                @foreach($tanggalList as $tgl)
                    <th class="tanggal">
                        {{ $tgl->format('d') }}
                        <br>
                        {{ $tgl->format('D') }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>

            @foreach($siswa as $index => $s)

                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td class="nama-siswa">
                        {{ $s->name }}
                    </td>

                    @foreach($tanggalList as $tgl)

                        @php
                            $key = $s->id . '-' . $tgl->format('d');

                            $record = $absensi[$key] ?? null;

                            $status = '-';
                            $class = 'kosong';

                            if ($record) {

                                $nilaiStatus = strtolower(trim($record->status ?? ''));

                                if ($nilaiStatus == 'telat') {
                                    $status = 'T';
                                    $class = 'telat';

                                } elseif ($nilaiStatus == 'izin') {
                                    $status = 'I';
                                    $class = 'izin';

                                } elseif ($nilaiStatus == 'sakit') {
                                    $status = 'S';
                                    $class = 'sakit';

                                } elseif (in_array($nilaiStatus, ['alpa', 'alpha'])) {
                                    $status = 'A';
                                    $class = 'alpa';

                                } else {
                                    $status = 'H';
                                    $class = 'hadir';
                                }

                            } elseif (
                                !$tgl->isWeekend() &&
                                $tgl->lt(\Carbon\Carbon::today())
                            ) {
                                $status = 'A';
                                $class = 'alpa';
                            }
                        @endphp

                        <td class="{{ $class }}">
                            {{ $status }}
                        </td>

                    @endforeach

                </tr>

            @endforeach

        </tbody>
    </table>

    <div class="keterangan">

        <div class="keterangan-title">
            Keterangan Status:
        </div>

        <table>
            <tr>
                <td class="hadir">H = Hadir</td>
                <td class="telat">T = Telat</td>
                <td class="izin">I = Izin</td>
                <td class="sakit">S = Sakit</td>
                <td class="alpa">A = Alpa</td>
                <td class="kosong">- = Libur/Belum</td>
            </tr>
        </table>

    </div>

</body>
</html>