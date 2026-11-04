@extends('layouts.app')

@section('content')
<style>
    .report-container { 
        padding: 24px; 
        background: #f4f6f9; 
        min-height: 100vh; 
    }
    
    /* Hero Banner */
    .hero-banner {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 25px -5px rgba(13, 110, 253, 0.25);
    }

    .badge-pill-light {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 50px;
        backdrop-filter: blur(4px);
        display: inline-block;
    }

    /* Card Box */
    .report-card { 
        background: #ffffff; 
        border-radius: 16px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); 
        padding: 24px; 
        border: 1px solid #e9ecef; 
    }

    /* Styling Filter & Input */
    .form-select-custom {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        background-color: #fff;
    }

    /* Styling Tabel Matriks */
    .matrix-table { 
        border-collapse: separate; 
        border-spacing: 0; 
        width: 100%; 
        min-width: 1100px; 
    }
    
    .matrix-table th, .matrix-table td { 
        border: 1px solid #f1f5f9; 
        text-align: center; 
        padding: 10px 6px; 
        vertical-align: middle; 
    }

    .matrix-table th { 
        background: #f8fafc; 
        color: #475569; 
        font-weight: 600; 
        font-size: 12px; 
        white-space: nowrap; 
        border-bottom: 2px solid #e2e8f0; 
    }

    .matrix-table td { 
        font-size: 12px; 
        color: #334155; 
        min-width: 42px; 
    }

    .matrix-table .student-name { 
        text-align: left; 
        padding-left: 16px; 
        font-weight: 600; 
        color: #1e293b; 
        min-width: 200px; 
        position: sticky; 
        left: 0; 
        background: #ffffff; 
        z-index: 1; 
        border-right: 2px solid #e2e8f0; 
    }

    .matrix-table thead .student-name { 
        z-index: 2; 
        background: #f8fafc; 
    }

    .matrix-table tbody tr:hover td { 
        background-color: #f8fafc; 
    }

    /* Status Badge Cell Circle */
    .status-badge-cell { 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        width: 28px; 
        height: 28px; 
        border-radius: 50%; 
        font-weight: 700; 
        font-size: 11px; 
        cursor: pointer;
        transition: transform 0.2s;
        position: relative;
    }

    .status-badge-cell:hover {
        transform: scale(1.15);
        box-shadow: 0 0 8px rgba(0,0,0,0.15);
    }

    .cell-hadir { background: #dcfce7; color: #15803d; }
    .cell-izin { background: #dbeafe; color: #1d4ed8; }
    .cell-sakit { background: #fef9c3; color: #a16207; }
    .cell-telat { background: #ffedd5; color: #c2410c; }
    .cell-alfa { background: #ffe4e6; color: #be123c; }
    .cell-pending { background: #f1f5f9; color: #94a3b8; cursor: default; }

    /* Legend Item & Hover Effect */
    .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease-in-out;
    }
    .legend-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    /* ========================================
    WARNA HEADER TABEL: LAVENDER
    ======================================== */
    .matrix-table thead th {
        background-color: #E6E6FA !important;
        color: #312E5C;
        border-color: #D8D5F2 !important;
        font-weight: 700;
    }

    .matrix-table thead .student-name {
        background-color: #E6E6FA !important;
        color: #312E5C;
    }

    .matrix-table thead th:first-child {
        background-color: #E6E6FA !important;
    }

    /* ========================================
    WARNA STATUS KEHADIRAN
    ======================================== */
    .cell-telat {
        background-color: #FED7AA !important;
        color: #C2410C !important;
    }

    .cell-hadir {
        background-color: #BBF7D0 !important;
        color: #166534 !important;
    }

    .cell-alfa {
        background-color: #FECACA !important;
        color: #B91C1C !important;
    }

    .cell-sakit {
        background-color: #FEF08A !important;
        color: #854D0E !important;
    }

    .cell-izin {
        background-color: #BFDBFE !important;
        color: #1D4ED8 !important;
    }

    .cell-pending {
        background-color: #F1F5F9 !important;
        color: #64748B !important;
    }

    /* TAMBAHAN: Styling Baris Header Sekolah */
    .school-row td {
        background-color: #f0f4ff !important;
        color: #1e3a8a;
        font-weight: 700;
        text-align: left;
        padding: 10px 16px;
        border-bottom: 2px solid #bfdbfe;
        font-size: 13px;
    }
</style>

<div class="report-container">
    
    <!-- Hero Banner Warna Biru Sesuai Header Dashboard -->
    <div class="hero-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="badge-pill-light mb-2">
                <i class="bi bi-calendar-check me-1"></i> Rekap Absensi Siswa
            </div>
            <h2 class="fw-bold mb-1 text-white">Laporan Absensi PKL</h2>
            <p class="mb-0 text-white-50 small">Pantau riwayat dan kerekapan kehadiran siswa bimbingan Anda secara praktis.</p>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- TOMBOL KEMBALI KE DASHBOARD PEMBIMBING -->
            <a href="{{ route('pembimbing.dashboard') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2" style="color: #0d6efd;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Kotak Total Siswa -->
            <div class="bg-white bg-opacity-10 p-3 rounded-4 backdrop-blur d-flex align-items-center gap-3">
                <div class="bg-white text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-person-check fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small fw-medium">Total Siswa</div>
                    <div class="fs-5 fw-bold text-white">{{ count($siswa) }} Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <div class="report-card">
        
        <!-- Header Controls & Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h5 class="fw-bold text-dark mb-0">Matriks Kehadiran Bulanan</h5>
                <p class="text-muted small mb-0">Filter berdasarkan sekolah, bulan, dan tahun untuk melihat detail harian.</p>
            </div>
            
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <!-- Form Filter (Sekolah, Bulan, Tahun) -->
                <form action="{{ route('pembimbing.laporan-absensi') }}" method="GET" class="d-flex gap-2 flex-wrap">
                    <select name="sekolah" class="form-select form-select-sm form-select-custom" onchange="this.form.submit()">
                        <option value="Semua" {{ $sekolahFilter == 'Semua' || !$sekolahFilter ? 'selected' : '' }}>Semua Sekolah</option>
                        @foreach($daftarSekolah as $sklh)
                            <option value="{{ $sklh->id }}" {{ $sekolahFilter == $sklh->id ? 'selected' : '' }}>
                                {{ $sklh->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>

                    <select name="bulan" class="form-select form-select-sm form-select-custom" onchange="this.form.submit()">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun" class="form-select form-select-sm form-select-custom" onchange="this.form.submit()">
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <!-- Tombol Export -->
                <a href="{{ route('pembimbing.laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn btn-outline-success btn-sm px-3 rounded-3 fw-medium">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('pembimbing.laporan.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn btn-outline-danger btn-sm rounded-3 fw-medium">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </a>
            </div>
        </div>

        <!-- Tabel Matriks -->
        <div class="table-responsive rounded-3 border border-light mb-4">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th class="student-name">Nama Siswa</th>

                        @foreach($tanggalList as $tgl)
                            <th>
                                {{ $tgl->format('d') }}<br>
                                <small>
                                    {{ $tgl->translatedFormat('D') }}
                                </small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        // PERUBAHAN: Kelompokkan siswa berdasarkan sekolah_id
                        $siswaGrouped = $siswa->groupBy('sekolah_id');
                    @endphp

                    @foreach($siswaGrouped as $sekolahId => $listSiswa)
                        <!-- Baris Header Sekolah -->
                        <tr class="school-row">
                            <td colspan="{{ count($tanggalList) + 2 }}">
                                <i class="bi bi-building me-2"></i> 
                                {{ $listSiswa->first()->sekolah->nama_sekolah ?? 'Sekolah Tidak Disebutkan' }}
                            </td>
                        </tr>

                        <!-- Looping Siswa di Sekolah tersebut -->
                        @foreach($listSiswa as $index => $s)
                            <tr>
                                <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                                <td class="student-name">{{ $s->name }}</td>
                                
                                @foreach($tanggalList as $tgl)
                                    @php
                                        $tglStr = $tgl->format('d');
                                        $key = $s->id . '-' . $tglStr;
                                        
                                        $absen = $absensi[$key] ?? null;
                                        $status = $absen ? $absen->status : null;
                                        
                                        // AMBIL DATA IZIN
                                        $dataIzin = $izin[$key] ?? null;
                                        
                                        // AMBIL DATA ALASAN KETERLAMBATAN
                                        $dataAlasan = isset($alasanKeterlambatan[$key]) ? $alasanKeterlambatan[$key] : null;
                                        $teksAlasan = $dataAlasan ? $dataAlasan->alasan : null;
                                        
                                        $cellClass = 'cell-pending';
                                        $label = '-';

                                        // 1. Cek apakah hari ini sudah lewat
                                        $isWeekend = in_array($tgl->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);
                                        $isPastDay = $tgl->startOfDay()->lt(\Carbon\Carbon::today()->startOfDay());
                                        
                                        // 2. Logika penentuan status
                                        if ($status == 'Telat') {
                                            $cellClass = 'cell-telat';
                                            $label = 'T';
                                        } elseif ($status == 'Izin') {
                                            $cellClass = 'cell-izin';
                                            $label = 'I';
                                        } elseif ($status == 'Sakit') {
                                            $cellClass = 'cell-sakit';
                                            $label = 'S';
                                        } elseif ($status == 'Alpa' || $status == 'Alpha') {
                                            if ($isPastDay) {
                                                $cellClass = 'cell-alfa';
                                                $label = 'A';
                                            }
                                        } elseif ($status) {
                                            $cellClass = 'cell-hadir';
                                            $label = 'H';
                                        } else {
                                            if (!$isWeekend && $isPastDay) {
                                                $cellClass = 'cell-alfa';
                                                $label = 'A';
                                            }
                                        }

                                        // Siapkan JSON untuk Modal Absensi
                                        $jsonAbsen = '';
                                        if ($absen) { 
                                            $jsonAbsen = json_encode([
                                                'nama' => $s->name,
                                                'tanggal' => $tgl->format('d M Y'),
                                                'status' => $status,
                                                'jam_masuk' => $absen->jam_masuk,
                                                'jam_pulang' => $absen->jam_pulang,
                                                'foto_masuk' => $absen->foto_masuk ? asset('storage/' . $absen->foto_masuk) : null,
                                                'foto_pulang' => $absen->foto_pulang ? asset('storage/' . $absen->foto_pulang) : null,
                                                'alasan_terlambat' => $teksAlasan,
                                            ]);
                                        }

                                        // Siapkan JSON untuk Modal Izin
                                        $jsonIzin = '';
                                        if ($dataIzin) {
                                            $jsonIzin = json_encode([
                                                'nama' => $s->name,
                                                'tanggal' => $tgl->format('d M Y'),
                                                'jenis' => $dataIzin->jenis_izin,
                                                'status' => $dataIzin->status,
                                                'alasan' => $dataIzin->alasan,
                                                'lampiran' => $dataIzin->lampiran ? asset('storage/' . $dataIzin->lampiran) : null
                                            ]);
                                        }
                                    @endphp

                                    <td>
                                        {{-- Prioritas 1: Jika ada data Izin Disetujui, tampilkan Modal Izin --}}
                                        @if($dataIzin && $dataIzin->status == 'Disetujui')
                                            <div class="status-badge-cell cell-izin" onclick="showDetailIzin({{ $jsonIzin }})">
                                                {{ $dataIzin->jenis_izin == 'Sakit' ? 'S' : 'I' }}
                                            </div>
                                        
                                        {{-- Prioritas 2: Jika Izin Menunggu --}}
                                        @elseif($dataIzin && $dataIzin->status == 'Menunggu')
                                            <div class="status-badge-cell cell-pending" onclick="showDetailIzin({{ $jsonIzin }})" style="cursor: pointer;">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>

                                        {{-- Prioritas 3: Jika data Absensi biasa (Hadir, Telat, Alpa) --}}
                                        @elseif($absen)
                                            <div class="status-badge-cell {{ $cellClass }}" 
                                                 onclick="showDetailAbsensi({{ $jsonAbsen }})">
                                                {{ $label }}
                                                {{-- Indikator kecil jika ada alasan --}}
                                                @if($teksAlasan)
                                                    <i class="bi bi-chat-left-text" style="font-size: 10px; position: absolute; top: 2px; right: 2px;"></i>
                                                @endif
                                            </div>

                                        {{-- Prioritas 4: Jika kosong / libur --}}
                                        @else
                                            <div class="status-badge-cell {{ $cellClass }}">
                                                {{ $label }}
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Legend & Keterangan -->
        <div class="row g-3 align-items-center pt-2 border-top border-light">
            <div class="col-md-3">
                <span class="fw-bold text-dark d-block">Keterangan Status</span>
                <span class="text-muted small">Indikator warna matriks kehadiran</span>
            </div>
            <div class="col-md-9">
                <div class="d-flex gap-2 flex-wrap justify-content-md-end">
                    <div class="legend-item px-3 py-2 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                        <span class="status-badge-cell cell-hadir me-1" style="width:22px; height:22px; font-size:10px;">H</span> 
                        <span class="text-success fw-semibold small">Hadir</span>
                    </div>
                    <div class="legend-item px-3 py-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3">
                        <span class="status-badge-cell cell-telat me-1" style="width:22px; height:22px; font-size:10px;">T</span> 
                        <span class="text-warning text-dark fw-semibold small">Telat</span>
                    </div>
                    <div class="legend-item px-3 py-2 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3">
                        <span class="status-badge-cell cell-izin me-1" style="width:22px; height:22px; font-size:10px;">I</span> 
                        <span class="text-primary fw-semibold small">Izin</span>
                    </div>
                    <div class="legend-item px-3 py-2 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-3">
                        <span class="status-badge-cell cell-sakit me-1" style="width:22px; height:22px; font-size:10px;">S</span> 
                        <span class="text-info text-dark fw-semibold small">Sakit</span>
                    </div>
                    <div class="legend-item px-3 py-2 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3">
                        <span class="status-badge-cell cell-alfa me-1" style="width:22px; height:22px; font-size:10px;">A</span> 
                        <span class="text-danger fw-semibold small">Alpa</span>
                    </div>
                    <div class="legend-item px-3 py-2 bg-light border border-light rounded-3">
                        <span class="status-badge-cell cell-pending me-1" style="width:22px; height:22px; font-size:10px;">-</span> 
                        <span class="text-muted fw-semibold small">Libur/Belum</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 1: DETAIL ABSENSI                              -->
<!-- ==================================================== -->
<div class="modal fade" id="modalDetailAbsensi" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalDetailLabel"><i class="bi bi-person-badge me-2"></i>Detail Absensi Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4 class="fw-bold mb-1" id="modalNama">-</h4>
                        <p class="text-muted mb-0"><i class="bi bi-calendar3 me-1"></i> <span id="modalTanggal">-</span></p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <span class="badge fs-6 px-3 py-2" id="modalStatus">-</span>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="bg-light p-3 rounded text-center">
                            <small class="text-muted d-block mb-1">Jam Masuk</small>
                            <span class="fs-5 fw-bold text-success" id="modalJamMasuk">--:--</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-3 rounded text-center">
                            <small class="text-muted d-block mb-1">Jam Pulang</small>
                            <span class="fs-5 fw-bold text-danger" id="modalJamPulang">--:--</span>
                        </div>
                    </div>
                </div>

                <!-- BLOK ALASAN KETERLAMBATAN -->
                <div id="boxAlasanTerlambat" class="mb-4" style="display: none; background: #fffbeb; border: 1px solid #fde68a; padding: 15px; border-radius: 8px;">
                    <h6 style="font-weight: 700; color: #d97706; margin-bottom: 5px;"><i class="bi bi-info-circle me-1"></i> Alasan Keterlambatan:</h6>
                    <p id="teksAlasanTerlambat" style="margin: 0; color: #92400e; font-size: 14px;"></p>
                </div>

                <hr>

                <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-camera me-2"></i>Bukti Foto Absensi</h6>
                <div class="row g-3 text-center">
                    <div class="col-md-6">
                        <div class="p-2 border rounded bg-white">
                            <p class="small text-muted fw-bold mb-2">Foto Masuk</p>
                            <img id="imgFotoMasuk" src="" alt="Foto Masuk" class="img-fluid rounded shadow-sm d-none" style="max-height: 250px; object-fit: cover;">
                            <div id="noFotoMasuk" class="py-5 text-muted bg-light rounded">
                                <i class="bi bi-image fs-1 opacity-25 d-block mb-2"></i>
                                <small>Tidak ada foto</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 border rounded bg-white">
                            <p class="small text-muted fw-bold mb-2">Foto Pulang</p>
                            <img id="imgFotoPulang" src="" alt="Foto Pulang" class="img-fluid rounded shadow-sm d-none" style="max-height: 250px; object-fit: cover;">
                            <div id="noFotoPulang" class="py-5 text-muted bg-light rounded">
                                <i class="bi bi-image fs-1 opacity-25 d-block mb-2"></i>
                                <small>Tidak ada foto</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 2: DETAIL IZIN                                 -->
<!-- ==================================================== -->
<div class="modal fade" id="modalDetailIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-envelope-paper me-2"></i>Detail Pengajuan Izin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Nama:</strong> <span id="izNama"></span></p>
                <p><strong>Tanggal:</strong> <span id="izTanggal"></span></p>
                <p><strong>Jenis:</strong> <span id="izJenis"></span></p>
                <p><strong>Status:</strong> <span id="izStatus" style="font-weight: bold;"></span></p>
                <p><strong>Alasan:</strong> <span id="izAlasan"></span></p>
                <div id="izBoxLampiran" class="mt-3" style="display: none;">
                    <strong>Lampiran:</strong><br>
                    <a id="izLinkLampiran" href="#" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="bi bi-paperclip"></i> Lihat File
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- JAVASCRIPT UNTUK MODAL                               -->
<!-- ==================================================== -->
<script>
    function showDetailAbsensi(data) {
        document.getElementById('modalNama').innerText = data.nama;
        document.getElementById('modalTanggal').innerText = data.tanggal;
        
        let badgeStatus = document.getElementById('modalStatus');
        badgeStatus.innerText = data.status;
        
        badgeStatus.className = 'badge fs-6 px-3 py-2 ';
        if (data.status === 'Hadir' || data.status === 'Tepat Waktu') badgeStatus.classList.add('bg-success');
        else if (data.status === 'Telat') badgeStatus.classList.add('bg-warning', 'text-dark');
        else if (data.status === 'Izin') badgeStatus.classList.add('bg-primary');
        else if (data.status === 'Sakit') badgeStatus.classList.add('bg-info', 'text-dark');
        else badgeStatus.classList.add('bg-danger');

        document.getElementById('modalJamMasuk').innerText = data.jam_masuk ? data.jam_masuk.substring(0, 5) : '--:--';
        document.getElementById('modalJamPulang').innerText = data.jam_pulang ? data.jam_pulang.substring(0, 5) : '--:--';

        const boxAlasan = document.getElementById('boxAlasanTerlambat');
        const teksAlasan = document.getElementById('teksAlasanTerlambat');
        
        if (data.alasan_terlambat) {
            teksAlasan.innerText = data.alasan_terlambat;
            boxAlasan.style.display = 'block';
        } else {
            boxAlasan.style.display = 'none';
        }

        let imgMasuk = document.getElementById('imgFotoMasuk');
        let noFotoMasuk = document.getElementById('noFotoMasuk');
        if (data.foto_masuk && data.foto_masuk !== '') {
            imgMasuk.src = data.foto_masuk;
            imgMasuk.classList.remove('d-none');
            noFotoMasuk.classList.add('d-none');
        } else {
            imgMasuk.classList.add('d-none');
            noFotoMasuk.classList.remove('d-none');
        }

        let imgPulang = document.getElementById('imgFotoPulang');
        let noFotoPulang = document.getElementById('noFotoPulang');
        if (data.foto_pulang && data.foto_pulang !== '') {
            imgPulang.src = data.foto_pulang;
            imgPulang.classList.remove('d-none');
            noFotoPulang.classList.add('d-none');
        } else {
            imgPulang.classList.add('d-none');
            noFotoPulang.classList.remove('d-none');
        }

        let modal = new bootstrap.Modal(document.getElementById('modalDetailAbsensi'));
        modal.show();
    }

    function showDetailIzin(data) {
        document.getElementById('izNama').innerText = data.nama;
        document.getElementById('izTanggal').innerText = data.tanggal;
        document.getElementById('izJenis').innerText = data.jenis;
        document.getElementById('izAlasan').innerText = data.alasan;
        
        const statusEl = document.getElementById('izStatus');
        statusEl.innerText = data.status;
        statusEl.style.color = data.status === 'Disetujui' ? '#16a34a' : (data.status === 'Menunggu' ? '#ea580c' : '#dc2626');

        const boxLampiran = document.getElementById('izBoxLampiran');
        const linkLampiran = document.getElementById('izLinkLampiran');
        
        if (data.lampiran) {
            linkLampiran.href = data.lampiran;
            boxLampiran.style.display = 'block';
        } else {
            boxLampiran.style.display = 'none';
        }

        let modal = new bootstrap.Modal(document.getElementById('modalDetailIzin'));
        modal.show();
    }
</script>
@endsection