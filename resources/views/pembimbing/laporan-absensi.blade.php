@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .report-container { 
        padding: 24px; 
        background: #f4f7fc; 
        min-height: 100vh; 
    }
    
    /* --- HERO BANNER --- */
    .hero-banner {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        border-radius: 20px;
        padding: 32px 40px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px -5px rgba(37, 99, 235, 0.3);
        position: relative;
        overflow: hidden;
    }
    .hero-banner::before {
        content: '';
        position: absolute;
        top: -100px; right: -50px;
        width: 300px; height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -150px; left: 20%;
        width: 400px; height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    .badge-pill-light {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 50px;
        backdrop-filter: blur(4px);
        display: inline-block;
        border: 1px solid rgba(255,255,255,0.1);
        position: relative; z-index: 2;
    }
    .btn-kembali {
        background: white;
        color: #1e40af;
        font-weight: 700;
        border-radius: 50px;
        padding: 10px 24px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.2s;
        position: relative; z-index: 2;
    }
    .btn-kembali:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); color: #1e3a8a; }
    
    .total-siswa-box {
        background: rgba(15, 23, 42, 0.3);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        padding: 12px 20px;
        display: flex; align-items: center; gap: 16px;
        border: 1px solid rgba(255,255,255,0.15);
        position: relative; z-index: 2;
    }

    /* --- MAIN CARD --- */
    .report-card { 
        background: #ffffff; 
        border-radius: 20px; 
        box-shadow: 0 5px 22px rgba(30, 60, 100, 0.04); 
        padding: 32px; 
        border: 1px solid #e8edf5; 
    }

    /* --- HEADER FILTER & EXPORT --- */
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .filter-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Form Filter */
    .filter-form {
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
    }

    .form-select-custom {
        height: 40px;
        min-width: 150px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 8px 36px 8px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background-color: #fff;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: all 0.2s;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .form-select-custom:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Tombol Ekspor */
    .btn-export-soft {
        height: 40px;
        padding: 0 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.2s;
        border: 1px solid;
    }
    .btn-excel { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
    .btn-excel:hover { background: #d1fae5; color: #065f46; }
    .btn-pdf { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .btn-pdf:hover { background: #fee2e2; color: #991b1b; }

    /* --- TABEL MATRIKS --- */
    .table-responsive {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        overflow: auto;
        background: white;
        margin-bottom: 24px;
    }

    .matrix-table {
        width: 100%;
        min-width: 1100px;
        border-spacing: 0;
        border-collapse: separate;
    }

    .matrix-table th {
        padding: 14px 8px;
        font-size: 11px;
        line-height: 1.4;
        background: #e9eafd !important; 
        color: #34345f !important; 
        border-bottom: 2px solid #dedff3 !important;
        font-weight: 700;
        text-align: center;
    }

    .matrix-table td {
        height: 49px;
        padding: 9px 8px;
        font-size: 12px;
        border-bottom: 1px solid #edf1f6;
        text-align: center;
        color: #334155;
    }
    .matrix-table tbody tr:hover td { background-color: #f7faff; }

    .matrix-table .student-name {
        min-width: 190px;
        font-weight: 600;
        padding-left: 15px;
        text-align: left;
        position: sticky;
        left: 0;
        background: #ffffff;
        z-index: 1;
    }
    .matrix-table thead .student-name { z-index: 2; background: #e9eafd; }

    .school-row td {
        padding: 12px 15px;
        background: #f0f5ff !important;
        color: #28528a;
        font-weight: 700;
        text-align: left;
    }

    /* Lingkaran status */
    .status-badge-cell {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 29px;
        height: 29px;
        font-size: 11px;
        border-radius: 50%;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
        position: relative; 
    }
    .status-badge-cell:hover {
        transform: scale(1.1);
    }

    /* Warna Status */
    .cell-hadir { background: #dcfce7; color: #15803d; }
    .cell-izin { background: #dbeafe; color: #1d4ed8; }
    .cell-sakit { background: #fef9c3; color: #a16207; }
    .cell-telat { background: #ffedd5; color: #c2410c; }
    .cell-alfa { background: #ffe4e6; color: #be123c; }
    .cell-pending { background: #f1f5f9; color: #94a3b8; cursor: pointer; }

    /* --- LEGEND / KETERANGAN --- */
    .legend-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding-top: 20px;
        border-top: 1px solid #edf1f6;
    }
    .legend-item {
        padding: 8px 12px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid transparent;
    }
    .legend-item .status-badge-cell { width: 22px; height: 22px; font-size: 10px; }
    
    .leg-hadir { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
    .leg-telat { background: #ffedd5; color: #c2410c; border-color: #fed7aa; }
    .leg-izin { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
    .leg-sakit { background: #fef9c3; color: #a16207; border-color: #fef08a; }
    .leg-alfa { background: #ffe4e6; color: #be123c; border-color: #fecdd3; }
    .leg-pending { background: #f1f5f9; color: #64748b; border-color: #e2e8f0; }

    /* Scrollbar tabel */
    .table-responsive::-webkit-scrollbar { height: 9px; }
    .table-responsive::-webkit-scrollbar-track { background: #f0f3f8; border-radius: 10px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #aab9cc; border-radius: 10px; }

    /* Responsif */
    @media (max-width: 992px) {
        .filter-actions { width: 100%; justify-content: flex-start; }
        .filter-form { flex-wrap: wrap; width: 100%; }
        .form-select-custom { width: 100%; flex: 1; }
    }
</style>

<div class="report-container">
    
    <!-- HERO BANNER -->
    <div class="hero-banner d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="badge-pill-light mb-2">
                <i class="bi bi-calendar-check me-1"></i> Rekap Absensi Siswa
            </div>
            <h2 class="fw-bold mb-1 text-white">Laporan Absensi PKL</h2>
            <p class="mb-0 text-white-50 small">Pantau riwayat dan kerekapan kehadiran siswa bimbingan Anda secara praktis.</p>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <!-- TOMBOL KEMBALI -->
            <a href="{{ route('pembimbing.dashboard') }}" class="btn btn-kembali d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <!-- Kotak Total Siswa -->
            <div class="total-siswa-box">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                    <i class="bi bi-person-check fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small fw-medium">Total Siswa</div>
                    <div class="fs-5 fw-bold text-white">{{ count($siswa) }} Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="report-card">
        
        <!-- HEADER FILTER & EXPORT -->
        <div class="filter-header">
            <div>
                <h5 class="fw-bold text-dark mb-1">Matriks Kehadiran Bulanan</h5>
                <p class="text-muted small mb-0">Filter berdasarkan sekolah, bulan, dan tahun untuk melihat detail harian.</p>
            </div>
            
            <div class="filter-actions">
                <!-- Form Filter -->
                <form action="{{ route('pembimbing.laporan-absensi') }}" method="GET" class="filter-form">
                    <!-- Select Sekolah -->
                    <select name="sekolah" class="form-select form-select-custom" onchange="this.form.submit()">
                        <option value="Semua" {{ $sekolahFilter == 'Semua' || !$sekolahFilter ? 'selected' : '' }}>Semua Sekolah</option>
                        @foreach($daftarSekolah as $sklh)
                            <option value="{{ $sklh->id }}" {{ $sekolahFilter == $sklh->id ? 'selected' : '' }}>
                                {{ $sklh->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Select Bulan -->
                    <select name="bulan" class="form-select form-select-custom" onchange="this.form.submit()">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <!-- Select Tahun -->
                    <select name="tahun" class="form-select form-select-custom" onchange="this.form.submit()">
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <!-- Tombol Ekspor -->
                <a href="{{ route('pembimbing.laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn btn-export-soft btn-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('pembimbing.laporan.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn btn-export-soft btn-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        <!-- TABEL MATRIKS -->
        <div class="table-responsive">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th class="student-name">Nama Siswa</th>

                        @foreach($tanggalList as $tgl)
                            <th>
                                {{ $tgl->format('d') }}<br>
                                <small style="font-weight: 500; opacity: 0.8;">{{ $tgl->translatedFormat('D') }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
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

                        <!-- Looping Siswa -->
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
                                        
                                        $dataIzin = $izin[$key] ?? null;
                                        $dataAlasan = isset($alasanKeterlambatan[$key]) ? $alasanKeterlambatan[$key] : null;
                                        
                                        // Alasan keterlambatan HANYA diambil jika status absennya 'Telat'
                                        if ($status == 'Telat' && $dataAlasan && ($dataAlasan->status === 'Disetujui' || $dataAlasan->status === 'Diterima')) {
                                            $teksAlasan = $dataAlasan->alasan;
                                        } else {
                                            $teksAlasan = null;
                                        }
                                        
                                        $cellClass = 'cell-pending';
                                        $label = '-';

                                        $isWeekend = in_array($tgl->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);
                                        $isPastDay = $tgl->startOfDay()->lt(\Carbon\Carbon::today()->startOfDay());
                                        
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

                                        $jsonAbsen = '';
                                        if ($absen) { 
                                            $jsonAbsen = json_encode([
                                                'user_id' => $s->id,
                                                'nama' => $s->name,
                                                'tanggal_ymd' => $tgl->format('Y-m-d'),
                                                'tanggal_label' => $tgl->format('d M Y'),
                                                'status' => $status,
                                                'jam_masuk' => $absen->jam_masuk,
                                                'jam_pulang' => $absen->jam_pulang,
                                                'foto_masuk' => $absen->foto_masuk ? asset('storage/' . $absen->foto_masuk) : null,
                                                'foto_pulang' => $absen->foto_pulang ? asset('storage/' . $absen->foto_pulang) : null,
                                                'alasan_terlambat' => $teksAlasan,
                                            ]);
                                        }

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
                                        @if($dataIzin && $dataIzin->status == 'Disetujui')
                                            <div class="status-badge-cell cell-izin" onclick="showDetailIzin({{ $jsonIzin }})" title="Klik untuk detail izin">
                                                {{ $dataIzin->jenis_izin == 'Sakit' ? 'S' : 'I' }}
                                            </div>
                                        @elseif($dataIzin && $dataIzin->status == 'Menunggu')
                                            <div class="status-badge-cell cell-pending" onclick="showDetailIzin({{ $jsonIzin }})" title="Menunggu persetujuan">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>
                                        @elseif($absen)
                                            <div class="status-badge-cell {{ $cellClass }}" onclick="showDetailAbsensi({{ $jsonAbsen }})" title="Klik untuk lihat/edit">
                                                {{ $label }}
                                                @if($teksAlasan)
                                                    <i class="bi bi-chat-left-text" style="font-size: 10px; position: absolute; top: 2px; right: 2px;"></i>
                                                @endif
                                            </div>
                                        @else
                                            <div class="status-badge-cell {{ $cellClass }}" 
                                                 onclick="bukaKoreksi('{{ $s->id }}', '{{ addslashes($s->name) }}', '{{ $tgl->format('Y-m-d') }}', '{{ $tgl->format('d M Y') }}', '{{ $cellClass }}')"
                                                 title="Klik untuk koreksi manual">
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
        
        <!-- LEGEND / KETERANGAN -->
        <div class="legend-box">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div>
                    <span class="fw-bold text-dark d-block" style="font-size: 14px;">Keterangan Status</span>
                    <span class="text-muted" style="font-size: 12px;">Semua kotak dapat diklik untuk melihat detail atau koreksi</span>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <div class="legend-item leg-hadir">
                    <span class="status-badge-cell cell-hadir">H</span> Hadir
                </div>
                <div class="legend-item leg-telat">
                    <span class="status-badge-cell cell-telat">T</span> Telat
                </div>
                <div class="legend-item leg-izin">
                    <span class="status-badge-cell cell-izin">I</span> Izin
                </div>
                <div class="legend-item leg-sakit">
                    <span class="status-badge-cell cell-sakit">S</span> Sakit
                </div>
                <div class="legend-item leg-alfa">
                    <span class="status-badge-cell cell-alfa">A</span> Alpa
                </div>
                <div class="legend-item leg-pending">
                    <span class="status-badge-cell cell-pending">-</span> Libur / Kosong
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 1: DETAIL & EDIT ABSENSI                       -->
<!-- ==================================================== -->
<div class="modal fade" id="modalDetailAbsensi" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white border-0 py-3 px-4">
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

                <div class="row g-3 mb-4" id="boxJamAbsen">
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-4 text-center">
                            <small class="text-muted d-block mb-1">Jam Masuk</small>
                            <span class="fs-5 fw-bold text-success" id="modalJamMasuk">--:--</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light p-3 rounded-4 text-center">
                            <small class="text-muted d-block mb-1">Jam Pulang</small>
                            <span class="fs-5 fw-bold text-danger" id="modalJamPulang">--:--</span>
                        </div>
                    </div>
                </div>

                <div id="boxAlasanTerlambat" class="mb-4" style="display: none; background: #fffbeb; border: 1px solid #fde68a; padding: 16px; border-radius: 12px;">
                    <h6 style="font-weight: 700; color: #d97706; margin-bottom: 5px;"><i class="bi bi-info-circle me-1"></i> Alasan Keterlambatan:</h6>
                    <p id="teksAlasanTerlambat" style="margin: 0; color: #92400e; font-size: 14px;"></p>
                </div>

                <div id="boxBuktiFoto">
                    <hr class="text-muted">
                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-camera me-2"></i>Bukti Foto Absensi</h6>
                    <div class="row g-3 text-center">
                        <div class="col-md-6">
                            <div class="p-2 border rounded-4 bg-white">
                                <p class="small text-muted fw-bold mb-2">Foto Masuk</p>
                                <img id="imgFotoMasuk" src="" alt="Foto Masuk" class="img-fluid rounded shadow-sm d-none" style="max-height: 250px; object-fit: cover;">
                                <div id="noFotoMasuk" class="py-5 text-muted bg-light rounded-4">
                                    <i class="bi bi-image fs-1 opacity-25 d-block mb-2"></i>
                                    <small>Tidak ada foto</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-2 border rounded-4 bg-white">
                                <p class="small text-muted fw-bold mb-2">Foto Pulang</p>
                                <img id="imgFotoPulang" src="" alt="Foto Pulang" class="img-fluid rounded shadow-sm d-none" style="max-height: 250px; object-fit: cover;">
                                <div id="noFotoPulang" class="py-5 text-muted bg-light rounded-4">
                                    <i class="bi bi-image fs-1 opacity-25 d-block mb-2"></i>
                                    <small>Tidak ada foto</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning px-4 rounded-3 fw-bold" id="btnEditDariDetail">
                    <i class="bi bi-pencil-square me-1"></i> Edit Status Ini
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 2: DETAIL IZIN                                 -->
<!-- ==================================================== -->
<div class="modal fade" id="modalDetailIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white border-0 py-3 px-4">
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
                    <a id="izLinkLampiran" href="#" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-3">
                        <i class="bi bi-paperclip"></i> Lihat File
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 3: KOREKSI ABSENSI MANUAL                      -->
<!-- ==================================================== -->
<div class="modal fade" id="modalKoreksiAbsensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Koreksi / Edit Absensi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formKoreksi">
                @csrf
                <input type="hidden" id="koreksi_user_id" name="user_id">
                <input type="hidden" id="koreksi_tanggal" name="tanggal">
                
                <div class="modal-body p-4">
                    <h5 class="fw-bold mb-1" id="koreksi_nama">Nama Siswa</h5>
                    <p class="text-muted mb-3" id="koreksi_tgl_label">Tanggal</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Kehadiran:</label>
                        <select name="status" class="form-select" id="koreksi_status" required>
                            <option value="Hadir">Hadir (Tepat Waktu)</option>
                            <option value="Telat">Telat</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpa">Alpa (Tanpa Keterangan)</option>
                        </select>
                    </div>

                    <div class="row" id="rowJamKoreksi">
                        <div class="col-6 mb-3">
                            <label class="form-label">Jam Masuk (Opsional)</label>
                            <input type="time" name="jam_masuk" id="koreksi_jam_masuk" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Jam Pulang (Opsional)</label>
                            <input type="time" name="jam_pulang" id="koreksi_jam_pulang" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================================================== -->
<!-- JAVASCRIPT UNTUK MODAL                               -->
<!-- ==================================================== -->
<script>
    let currentAbsenData = null;

    // --- FUNGSI MODAL DETAIL ABSENSI ---
    function showDetailAbsensi(data) {
        currentAbsenData = data;

        document.getElementById('modalNama').innerText = data.nama;
        document.getElementById('modalTanggal').innerText = data.tanggal_label;
        
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

        // LOGIKA BARU: Sembunyikan/Tampilkan elemen berdasarkan status
        const boxJam = document.getElementById('boxJamAbsen');
        const boxFoto = document.getElementById('boxBuktiFoto');
        const boxAlasan = document.getElementById('boxAlasanTerlambat');
        const teksAlasan = document.getElementById('teksAlasanTerlambat');

        if (data.status === 'Hadir' || data.status === 'Telat') {
            // Hadir / Telat: Tampilkan Jam & Foto
            boxJam.style.display = 'flex';
            boxFoto.style.display = 'block';

            // Tampilkan alasan HANYA jika statusnya Telat
            if (data.status === 'Telat' && data.alasan_terlambat) {
                teksAlasan.innerText = data.alasan_terlambat;
                boxAlasan.style.display = 'block';
            } else {
                boxAlasan.style.display = 'none';
            }

            // Render Foto
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

        } else {
            // Izin / Sakit / Alpa: Sembunyikan Jam, Foto, dan Alasan Keterlambatan
            boxJam.style.display = 'none';
            boxFoto.style.display = 'none';
            boxAlasan.style.display = 'none';
        }

        let modal = new bootstrap.Modal(document.getElementById('modalDetailAbsensi'));
        modal.show();
    }

    // --- FUNGSI TOMBOL EDIT DARI DALAM MODAL DETAIL ---
    document.getElementById('btnEditDariDetail').addEventListener('click', function() {
        let modalDetailEl = document.getElementById('modalDetailAbsensi');
        let modalDetail = bootstrap.Modal.getInstance(modalDetailEl);
        modalDetail.hide();

        if (currentAbsenData) {
            setTimeout(() => {
                bukaKoreksi(
                    currentAbsenData.user_id, 
                    currentAbsenData.nama, 
                    currentAbsenData.tanggal_ymd, 
                    currentAbsenData.tanggal_label,
                    currentAbsenData.status,
                    currentAbsenData.jam_masuk,
                    currentAbsenData.jam_pulang
                );
            }, 400);
        }
    });

    // --- FUNGSI MODAL DETAIL IZIN ---
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

    // --- FUNGSI MODAL KOREKSI MANUAL ---
    function bukaKoreksi(id, nama, tanggalYmd, tanggalLabel, statusSaatIni = 'Hadir', jamMasuk = '', jamPulang = '') {
        document.getElementById('koreksi_user_id').value = id;
        document.getElementById('koreksi_tanggal').value = tanggalYmd;
        document.getElementById('koreksi_nama').innerText = nama;
        document.getElementById('koreksi_tgl_label').innerText = tanggalLabel;
        
        document.getElementById('koreksi_status').value = statusSaatIni;
        document.getElementById('koreksi_jam_masuk').value = jamMasuk ? jamMasuk.substring(0, 5) : '';
        document.getElementById('koreksi_jam_pulang').value = jamPulang ? jamPulang.substring(0, 5) : '';

        // Panggil fungsi untuk cek form jam
        toggleFormJam(statusSaatIni);

        let modal = new bootstrap.Modal(document.getElementById('modalKoreksiAbsensi'));
        modal.show();
    }

    // --- FUNGSI UNTUK SEMBUNYIKAN FORM JAM SAAT EDIT JIKA IZIN/SAKIT/ALPA ---
    function toggleFormJam(status) {
        const rowJam = document.getElementById('rowJamKoreksi');
        if (status === 'Hadir' || status === 'Telat') {
            rowJam.style.display = 'flex';
        } else {
            rowJam.style.display = 'none';
        }
    }

    // Event listener saat dropdown status di modal koreksi diganti
    document.getElementById('koreksi_status').addEventListener('change', function() {
        toggleFormJam(this.value);
    });

    // --- PROSES SUBMIT FORM KOREKSI VIA AJAX ---
    document.getElementById('formKoreksi').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let btn = this.querySelector('button[type="submit"]');
        let originalText = btn.innerText;
        
        btn.disabled = true;
        btn.innerText = 'Menyimpan...';

        fetch("{{ route('pembimbing.laporan.simpan-manual') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            alert(data.message || 'Koreksi absensi berhasil disimpan!');
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMsg = error.message || 'Terjadi kesalahan sistem.';
            if (error.errors) {
                errorMsg = Object.values(error.errors).flat().join('\n');
            }
            alert('Gagal menyimpan: \n' + errorMsg);
            btn.disabled = false;
            btn.innerText = originalText;
        });
    });
</script>
@endsection