<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Mengatur encoding agar teks bahasa Indonesia tampil benar. --}}
    <meta charset="UTF-8">

    {{-- Judul dokumen laporan jurnal siswa. --}}
    <title>Laporan Jurnal Siswa</title>

    {{-- CSS untuk mengatur tampilan PDF. --}}
    <style>
        /* Mengatur jenis dan ukuran tulisan seluruh dokumen. */
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        /* Membuat judul laporan berada di tengah halaman. */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Membuat tabel memenuhi lebar halaman. */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Mengatur garis, jarak isi, dan perataan sel tabel. */
        th,
        td {
            border: 1px solid #333;
            padding: 7px;
            text-align: center;
        }

        /* Memberikan warna latar pada judul kolom. */
        th {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body>

    {{-- Judul utama yang muncul di bagian atas PDF. --}}
    <h2>Laporan Jurnal Siswa</h2>

    {{-- Tabel untuk menampilkan data jurnal siswa. --}}
    <table>

        {{-- Bagian kepala tabel: nama setiap kolom. --}}
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kegiatan</th>
                <th>Kendala</th>
                <th>Nilai &amp; Catatan</th>
            </tr>
        </thead>

        {{-- Bagian isi tabel: data yang dikirim dari controller. --}}
        <tbody>

            {{-- Memeriksa apakah data jurnal tersedia. --}}
            @forelse ($jurnal as $item)

                {{-- Menampilkan satu baris untuk setiap jurnal. --}}
                <tr>
                    {{-- Tanggal jurnal dibuat. --}}
                    <td>{{ $item->tanggal }}</td>

                    {{-- Nama pengguna yang terkait dengan jurnal. --}}
                    <td>{{ $item->user?->name ?? '-' }}</td>

                    {{-- Isi kegiatan siswa. --}}
                    <td>{{ $item->kegiatan ?? '-' }}</td>

                    {{-- Kendala yang dialami siswa. --}}
                    <td>{{ $item->kendala ?? '-' }}</td>

                    {{-- Nilai atau catatan dari jurnal. --}}
                    <td>
                        Nilai: {{ $item->nilai ?? '-' }}
                    <br>
                        Catatan: {{ $item->catatan ?? '-' }}
                    </td>
                </tr>

            {{-- Jika tidak ada data jurnal, tampilkan pesan ini. --}}
            @empty
                <tr>
                    <td colspan="5">Belum ada jurnal siswa.</td>
                </tr>
            @endforelse

        </tbody>
    </table>

</body>
</html>