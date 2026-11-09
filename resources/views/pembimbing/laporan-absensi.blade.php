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
    width: 100%;
    box-sizing: border-box;
}

/* HEADER */
.hero-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: nowrap;
    background: linear-gradient(135deg,#1e40af,#3b82f6);
    border-radius: 20px;
    padding: 30px;
    color: white;
    margin-bottom: 24px;
    box-shadow: 0 10px 30px rgba(37,99,235,.2);
    position: relative;
    overflow: hidden;
}

.hero-banner::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -50px;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,.1);
    border-radius: 50%;
}

.hero-info {
    flex: 1;
    min-width: 0;
    position: relative;
    z-index: 2;
}

.hero-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    z-index: 2;
}

.badge-pill-light {
    display: inline-block;
    background: rgba(255,255,255,.2);
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
}

.btn-kembali {
    background: white;
    color: #1e40af;
    font-weight: 700;
    border-radius: 50px;
    padding: 10px 24px;
    text-decoration: none;
    white-space: nowrap;
}

.total-siswa-box {
    background: rgba(15,23,42,.3);
    border-radius: 16px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    white-space: nowrap;
}

.report-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 22px rgba(30,60,100,.04);
    padding: 30px;
    border: 1px solid #e8edf5;
    width: 100%;
    box-sizing: border-box;
}

/* FILTER DAN PENCARIAN */
.filter-header {
    display: grid;
    grid-template-columns: minmax(0,1fr) auto;
    grid-template-rows: auto auto;
    align-items: center;
    gap: 12px 16px;
    margin-bottom: 22px;
}

.filter-title {
    grid-column: 1 / -1;
    grid-row: 1;
}

.search-name-wrap {
    grid-column: 1;
    grid-row: 2;
    position: relative;
    width: 280px;
    margin: 0;
}

.search-name-wrap i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
}

.search-name-input {
    width: 100%;
    height: 40px;
    padding: 8px 12px 8px 38px;
    border: 1px solid #cbd5e1;
    border-radius: 9px;
    outline: none;
    font-size: 13px;
    box-sizing: border-box;
}

.search-name-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,.1);
}

.filter-actions {
    grid-column: 2;
    grid-row: 2;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    width: auto;
    margin: 0;
}

.filter-form {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
}

.form-select-custom {
    height: 40px;
    min-width: 135px;
    padding: 8px 30px 8px 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    background: white;
    cursor: pointer;
    box-sizing: border-box;
}

.btn-export-soft {
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    white-space: nowrap;
    text-decoration: none;
    border: 1px solid;
}

.btn-excel {
    background: #ecfdf5;
    color: #047857;
    border-color: #a7f3d0;
}

.btn-pdf {
    background: #fef2f2;
    color: #b91c1c;
    border-color: #fecaca;
}

/* TABEL */
.table-responsive {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow-x: auto !important;
    overflow-y: hidden;
    background: white;
    margin-bottom: 24px;
    width: 100%;
    max-width: 100%;
    -webkit-overflow-scrolling: touch;
    position: relative;
}

.matrix-table {
    width: 100%;
    min-width: 850px;
    border-spacing: 0;
    border-collapse: separate;
}

.matrix-table th {
    padding: 12px 7px;
    font-size: 11px;
    line-height: 1.4;
    background: #e9eafd !important;
    color: #34345f !important;
    border-bottom: 2px solid #dedff3;
    font-weight: 700;
    text-align: center;
    white-space: nowrap;
}

.matrix-table td {
    height: 45px;
    padding: 7px;
    font-size: 12px;
    border-bottom: 1px solid #edf1f6;
    text-align: center;
    color: #334155;
    white-space: nowrap;
}

.matrix-table tbody tr:hover td {
    background: #f7faff;
}

.matrix-table .student-name {
    min-width: 155px;
    font-weight: 600;
    padding-left: 15px;
    text-align: left;
    position: sticky;
    left: 0;
    background: white;
    z-index: 1;
}

.matrix-table thead .student-name {
    z-index: 2;
    background: #e9eafd;
}

.school-row td {
    padding: 12px 15px;
    background: #f0f5ff !important;
    color: #28528a;
    font-weight: 700;
    text-align: left;
}

/* STATUS */
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
    position: relative;
    transition: transform 0.2s;
}

.status-badge-cell:hover {
    transform: scale(1.1);
}

.cell-hadir { background: #dcfce7; color: #15803d; }
.cell-izin { background: #dbeafe; color: #1d4ed8; }
.cell-sakit { background: #fef9c3; color: #a16207; }
.cell-telat { background: #ffedd5; color: #c2410c; }
.cell-alfa { background: #ffe4e6; color: #be123c; }
.cell-pending { background: #f1f5f9; color: #94a3b8; cursor: pointer; }

/* KETERANGAN */
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
    white-space: nowrap;
}

.legend-item .status-badge-cell {
    width: 22px;
    height: 22px;
    font-size: 10px;
}

.leg-hadir { background:#dcfce7;color:#15803d;border-color:#bbf7d0; }
.leg-telat { background:#ffedd5;color:#c2410c;border-color:#fed7aa; }
.leg-izin { background:#dbeafe;color:#1d4ed8;border-color:#bfdbfe; }
.leg-sakit { background:#fef9c3;color:#a16207;border-color:#fef08a; }
.leg-alfa { background:#ffe4e6;color:#be123c;border-color:#fecdd3; }
.leg-pending { background:#f1f5f9;color:#64748b;border-color:#e2e8f0; }

.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #aab9cc;
    border-radius: 10px;
}

/* RESPONSIVE TABLET */
@media(max-width: 992px) {
    .report-container { padding: 18px; }
    .report-card { padding: 22px; }
    .filter-header { grid-template-columns: 1fr; }
    .search-name-wrap { grid-column: 1; grid-row: 2; }
    .filter-actions { grid-column: 1; grid-row: 3; justify-content: flex-start; flex-wrap: wrap; }
    .filter-form { flex-wrap: wrap; }
    .form-select-custom { min-width: 120px; }
}

/* RESPONSIVE HP */
@media(max-width: 576px) {
    .report-container { padding: 12px; }
    .hero-banner { flex-direction: column; align-items: stretch; padding: 20px 16px; gap: 14px; }
    .hero-banner h2 { font-size: 21px; }
    .hero-banner p { font-size: 12px; }
    .hero-actions { width: 100%; justify-content: space-between; flex-wrap: wrap; }
    .total-siswa-box { padding: 9px 12px; }
    .report-card { padding: 15px 11px; border-radius: 15px; }
    .filter-header { display: flex; flex-direction: column; align-items: stretch; gap: 11px; margin-bottom: 16px; }
    .filter-title h5 { font-size: 16px; }
    .filter-title p { font-size: 11px; }
    .search-name-wrap { width: 100%; }
    .filter-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .filter-form { display: grid; grid-template-columns: 1fr 1fr; width: 100%; gap: 7px; }
    .filter-form select:first-child { grid-column: 1 / -1; }
    .form-select-custom { width: 100%; min-width: 0; height: 38px; font-size: 12px; padding: 6px 8px; }
    .btn-export-soft { width: 100%; height: 38px; font-size: 12px; }
    
    .table-responsive { max-height: 68vh; overflow-x: auto !important; overflow-y: auto !important; touch-action: pan-x pan-y; }
    .matrix-table { width: max-content; min-width: 100%; }
    .matrix-table th { padding: 8px 4px; font-size: 9px; }
    .matrix-table td { height: 39px; padding: 5px 3px; font-size: 10px; }
    
    .matrix-table th:first-child, .matrix-table td:first-child {
        min-width: 28px; width: 28px; position: sticky; left: 0; z-index: 4; background: white;
    }
    
    .matrix-table th.student-name, .matrix-table td.student-name {
        min-width: 118px; max-width: 118px; width: 118px; padding: 6px 7px;
        position: sticky !important; left: 28px; z-index: 3; background: white;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        box-shadow: 3px 0 5px rgba(15,23,42,.06);
    }
    
    .matrix-table thead th:first-child, .matrix-table thead th.student-name {
        background: #e9eafd !important; z-index: 6;
    }
    
    .matrix-table th:not(:first-child):not(.student-name), .matrix-table td:not(:first-child):not(.student-name) {
        min-width: 34px; width: 34px;
    }
    
    .status-badge-cell { width: 23px; height: 23px; font-size: 9px; }
    .school-row td { padding: 8px 10px; font-size: 10px; }
    
    .legend-box { flex-direction: column; align-items: flex-start; }
    .legend-box > div:last-child { display: flex; flex-wrap: wrap; gap: 7px !important; }
    .legend-item { padding: 6px 8px; font-size: 10px; }
}
</style>

<div class="report-container">

    <div class="hero-banner">
        <div class="hero-info">
            <div class="badge-pill-light mb-2">
                <i class="bi bi-calendar-check me-1"></i> Rekap Absensi Siswa
            </div>
            <h2 class="fw-bold mb-1 text-white">Laporan Absensi PKL</h2>
            <p class="mb-0 text-white-50 small">
                Pantau riwayat dan kerekapan kehadiran siswa bimbingan Anda secara praktis.
            </p>
        </div>

        <div class="hero-actions">
            <a href="{{ route('pembimbing.dashboard') }}" class="btn-kembali">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <div class="total-siswa-box">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px">
                    <i class="bi bi-person-check fs-4"></i>
                </div>
                <div>
                    <div class="text-white-50 small">Total Siswa</div>
                    <div class="fs-5 fw-bold text-white">{{ count($siswa) }} Siswa</div>
                </div>
            </div>
        </div>
    </div>

    <div class="report-card">

        <div class="filter-header">
            <div class="filter-title">
                <h5 class="fw-bold text-dark mb-1">Matriks Kehadiran Bulanan</h5>
                <p class="text-muted small mb-0">Filter berdasarkan sekolah, bulan, dan tahun untuk melihat detail harian.</p>
            </div>

            <div class="search-name-wrap">
                <i class="bi bi-search"></i>
                <input type="search" id="searchSiswa" class="search-name-input" placeholder="Cari nama siswa..." aria-label="Cari nama siswa">
            </div>

            <div class="filter-actions">
                <form action="{{ route('pembimbing.laporan-absensi') }}" method="GET" class="filter-form">
                    <select name="sekolah" class="form-select-custom" onchange="this.form.submit()">
                        <option value="Semua" {{ ($sekolahFilter == 'Semua' || !$sekolahFilter) ? 'selected' : '' }}>Semua Sekolah</option>
                        @foreach($daftarSekolah as $sklh)
                            <option value="{{ $sklh->id }}" {{ $sekolahFilter == $sklh->id ? 'selected' : '' }}>{{ $sklh->nama_sekolah }}</option>
                        @endforeach
                    </select>

                    <select name="bulan" class="form-select-custom" onchange="this.form.submit()">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ (int)$bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <select name="tahun" class="form-select-custom" onchange="this.form.submit()">
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <a href="{{ route('pembimbing.laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn-export-soft btn-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>

                <a href="{{ route('pembimbing.laporan.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun, 'sekolah' => $sekolahFilter]) }}" class="btn-export-soft btn-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width:50px">No</th>
                        <th class="student-name">Nama Siswa</th>
                        @foreach($tanggalList as $tgl)
                            <th>
                                {{ $tgl->format('d') }}<br>
                                <small style="font-weight:500;opacity:.8">{{ $tgl->translatedFormat('D') }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @php
                        $siswaGrouped = $siswa->groupBy('sekolah_id');
                    @endphp

                    @foreach($siswaGrouped as $sekolahId => $listSiswa)
                        <tr class="school-row">
                            <td colspan="{{ count($tanggalList) + 2 }}">
                                <i class="bi bi-building me-2"></i>
                                {{ $listSiswa->first()->sekolah->nama_sekolah ?? 'Sekolah Tidak Disebutkan' }}
                            </td>
                        </tr>

                        @foreach($listSiswa as $s)
                            <tr class="student-row" data-nama="{{ strtolower($s->name) }}">
                                <td class="text-muted fw-semibold">{{ $loop->iteration }}</td>
                                <td class="student-name">{{ $s->name }}</td>

                                @foreach($tanggalList as $tgl)
                                    @php
                                        $tglStr = $tgl->format('d');
                                        $key = $s->id . '-' . $tglStr;

                                        $absen = $absensi[$key] ?? null;
                                        $status = $absen ? $absen->status : null;

                                        $dataIzin = $izin[$key] ?? null;
                                        $dataAlasan = $alasanKeterlambatan[$key] ?? null;
                                        
                                        // Alasan keterlambatan HANYA diambil jika status absennya 'Telat'
                                        if ($status == 'Telat' && $dataAlasan && ($dataAlasan->status === 'Disetujui' || $dataAlasan->status === 'Diterima')) {
                                            $teksAlasan = $dataAlasan->alasan;
                                        } else {
                                            $teksAlasan = null;
                                        }

                                        $cellClass = 'cell-pending';
                                        $label = '-';

                                        $isWeekend = in_array($tgl->dayOfWeek, [\Carbon\Carbon::SATURDAY, \Carbon\Carbon::SUNDAY]);
                                        $isPastDay = $tgl->copy()->startOfDay()->lt(\Carbon\Carbon::today()->startOfDay());

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
                                        } elseif (!$isWeekend && $isPastDay) {
                                            $cellClass = 'cell-alfa';
                                            $label = 'A';
                                        }

                                        // Siapkan JSON Data
                                        $jsonAbsen = $absen ? [
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
                                        ] : [];

                                        $jsonIzin = $dataIzin ? [
                                            'nama' => $s->name,
                                            'tanggal' => $tgl->format('d M Y'),
                                            'jenis' => $dataIzin->jenis_izin,
                                            'status' => $dataIzin->status,
                                            'alasan' => $dataIzin->alasan,
                                            'lampiran' => $dataIzin->lampiran ? asset('storage/' . $dataIzin->lampiran) : null
                                        ] : [];
                                    @endphp

                                    <td>
                                        @if($dataIzin && $dataIzin->status == 'Disetujui')
                                            <div class="status-badge-cell cell-izin" onclick='showDetailIzin(@json($jsonIzin))' title="Klik untuk detail izin">
                                                {{ $dataIzin->jenis_izin == 'Sakit' ? 'S' : 'I' }}
                                            </div>
                                        @elseif($dataIzin && $dataIzin->status == 'Menunggu')
                                            <div class="status-badge-cell cell-pending" onclick='showDetailIzin(@json($jsonIzin))' title="Menunggu persetujuan">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>
                                        @elseif($absen)
                                            <div class="status-badge-cell {{ $cellClass }}" onclick='showDetailAbsensi(@json($jsonAbsen))' title="Klik untuk lihat/edit">
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

        <div class="legend-box">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:32px;height:32px">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
                <div>
                    <span class="fw-bold text-dark d-block" style="font-size: 14px;">Keterangan Status</span>
                    <span class="text-muted" style="font-size: 12px;">Semua kotak dapat diklik untuk melihat detail atau koreksi</span>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <div class="legend-item leg-hadir"><span class="status-badge-cell cell-hadir">H</span> Hadir</div>
                <div class="legend-item leg-telat"><span class="status-badge-cell cell-telat">T</span> Telat</div>
                <div class="legend-item leg-izin"><span class="status-badge-cell cell-izin">I</span> Izin</div>
                <div class="legend-item leg-sakit"><span class="status-badge-cell cell-sakit">S</span> Sakit</div>
                <div class="legend-item leg-alfa"><span class="status-badge-cell cell-alfa">A</span> Alpa</div>
                <div class="legend-item leg-pending"><span class="status-badge-cell cell-pending">-</span> Libur / Kosong</div>
            </div>
        </div>

    </div>
</div>

<!-- ==================================================== -->
<!-- MODAL 1: DETAIL & EDIT ABSENSI                       -->
<!-- ==================================================== -->
<div class="modal fade" id="modalDetailAbsensi" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px;overflow:hidden">
            <div class="modal-header bg-primary text-white border-0 py-3 px-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-badge me-2"></i> Detail Absensi Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

                <div id="boxAlasanTerlambat" class="mb-4" style="display:none;background:#fffbeb;border:1px solid #fde68a;padding:16px;border-radius:12px">
                    <h6 style="font-weight:700;color:#d97706;margin-bottom:5px"><i class="bi bi-info-circle me-1"></i> Alasan Keterlambatan:</h6>
                    <p id="teksAlasanTerlambat" style="margin:0;color:#92400e;font-size:14px"></p>
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
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px;overflow:hidden">
            <div class="modal-header bg-primary text-white border-0 py-3 px-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-envelope-paper me-2"></i> Detail Pengajuan Izin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Nama:</strong> <span id="izNama"></span></p>
                <p><strong>Tanggal:</strong> <span id="izTanggal"></span></p>
                <p><strong>Jenis:</strong> <span id="izJenis"></span></p>
                <p><strong>Status:</strong> <span id="izStatus" style="font-weight:bold"></span></p>
                <p><strong>Alasan:</strong> <span id="izAlasan"></span></p>

                <div id="izBoxLampiran" class="mt-3" style="display:none">
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
<!-- JAVASCRIPT                                           -->
<!-- ==================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // --- FITUR PENCARIAN SISWA ---
    const inputCari = document.getElementById('searchSiswa');
    if (inputCari) {
        inputCari.addEventListener('input', function () {
            const kata = this.value.toLocaleLowerCase('id').trim();
            
            document.querySelectorAll('.student-row').forEach(function (baris) {
                const nama = (baris.dataset.nama || '').toLocaleLowerCase('id');
                baris.style.display = nama.includes(kata) ? '' : 'none';
            });

            document.querySelectorAll('.school-row').forEach(function (barisSekolah) {
                let adaSiswa = false;
                let berikutnya = barisSekolah.nextElementSibling;
                while (berikutnya && !berikutnya.classList.contains('school-row')) {
                    if (berikutnya.classList.contains('student-row') && berikutnya.style.display !== 'none') {
                        adaSiswa = true;
                        break;
                    }
                    berikutnya = berikutnya.nextElementSibling;
                }
                barisSekolah.style.display = adaSiswa ? '' : 'none';
            });
        });
    }

    // --- EVENT LISTENER TOMBOL EDIT DI MODAL DETAIL ---
    const btnEdit = document.getElementById('btnEditDariDetail');
    if(btnEdit) {
        btnEdit.addEventListener('click', function() {
            let modalDetailEl = document.getElementById('modalDetailAbsensi');
            let modalDetail = bootstrap.Modal.getInstance(modalDetailEl);
            if(modalDetail) modalDetail.hide();

            if (window.currentAbsenData) {
                setTimeout(() => {
                    bukaKoreksi(
                        window.currentAbsenData.user_id, 
                        window.currentAbsenData.nama, 
                        window.currentAbsenData.tanggal_ymd, 
                        window.currentAbsenData.tanggal_label,
                        window.currentAbsenData.status,
                        window.currentAbsenData.jam_masuk,
                        window.currentAbsenData.jam_pulang
                    );
                }, 400);
            }
        });
    }

    // --- EVENT LISTENER DROPDOWN STATUS DI FORM KOREKSI ---
    const selStatus = document.getElementById('koreksi_status');
    if(selStatus) {
        selStatus.addEventListener('change', function() {
            toggleFormJam(this.value);
        });
    }

    // --- EVENT LISTENER SUBMIT FORM KOREKSI (AJAX) ---
    const formKoreksi = document.getElementById('formKoreksi');
    if(formKoreksi) {
        formKoreksi.addEventListener('submit', function(e) {
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
    }

});

// --- FUNGSI MODAL DETAIL ABSENSI ---
function showDetailAbsensi(data) {
    try {
        window.currentAbsenData = data; 

        document.getElementById('modalNama').innerText = data.nama || '-';
        document.getElementById('modalTanggal').innerText = data.tanggal_label || '-';
        
        let badgeStatus = document.getElementById('modalStatus');
        badgeStatus.innerText = data.status || '-';
        badgeStatus.className = 'badge fs-6 px-3 py-2 ';
        if (data.status === 'Hadir' || data.status === 'Tepat Waktu') badgeStatus.classList.add('bg-success');
        else if (data.status === 'Telat') badgeStatus.classList.add('bg-warning', 'text-dark');
        else if (data.status === 'Izin') badgeStatus.classList.add('bg-primary');
        else if (data.status === 'Sakit') badgeStatus.classList.add('bg-info', 'text-dark');
        else badgeStatus.classList.add('bg-danger');

        document.getElementById('modalJamMasuk').innerText = data.jam_masuk ? data.jam_masuk.substring(0, 5) : '--:--';
        document.getElementById('modalJamPulang').innerText = data.jam_pulang ? data.jam_pulang.substring(0, 5) : '--:--';

        const boxJam = document.getElementById('boxJamAbsen');
        const boxFoto = document.getElementById('boxBuktiFoto');
        const boxAlasan = document.getElementById('boxAlasanTerlambat');
        const teksAlasan = document.getElementById('teksAlasanTerlambat');

        if (data.status === 'Hadir' || data.status === 'Tepat Waktu' || data.status === 'Telat') {
            boxJam.style.display = 'flex';
            boxFoto.style.display = 'block';

            if (data.status === 'Telat' && data.alasan_terlambat) {
                teksAlasan.innerText = data.alasan_terlambat;
                boxAlasan.style.display = 'block';
            } else {
                boxAlasan.style.display = 'none';
            }

            // Render Foto Masuk
            let imgMasuk = document.getElementById('imgFotoMasuk');
            let noFotoMasuk = document.getElementById('noFotoMasuk');
            if (data.foto_masuk) {
                imgMasuk.onerror = function() {
                    this.classList.add('d-none');
                    noFotoMasuk.classList.remove('d-none');
                };
                imgMasuk.src = data.foto_masuk;
                imgMasuk.classList.remove('d-none');
                noFotoMasuk.classList.add('d-none');
            } else {
                imgMasuk.removeAttribute('src');
                imgMasuk.classList.add('d-none');
                noFotoMasuk.classList.remove('d-none');
            }

            // Render Foto Pulang
            let imgPulang = document.getElementById('imgFotoPulang');
            let noFotoPulang = document.getElementById('noFotoPulang');
            if (data.foto_pulang) {
                imgPulang.onerror = function() {
                    this.classList.add('d-none');
                    noFotoPulang.classList.remove('d-none');
                };
                imgPulang.src = data.foto_pulang;
                imgPulang.classList.remove('d-none');
                noFotoPulang.classList.add('d-none');
            } else {
                imgPulang.removeAttribute('src');
                imgPulang.classList.add('d-none');
                noFotoPulang.classList.remove('d-none');
            }
        } else {
            boxJam.style.display = 'none';
            boxFoto.style.display = 'none';
            boxAlasan.style.display = 'none';
        }

        let modal = new bootstrap.Modal(document.getElementById('modalDetailAbsensi'));
        modal.show();
    } catch (error) {
        console.error("Error di showDetailAbsensi:", error);
        alert("Terjadi kesalahan saat membuka detail. Cek Console (F12) untuk info.");
    }
}

// --- FUNGSI MODAL DETAIL IZIN ---
function showDetailIzin(data) {
    try {
        document.getElementById('izNama').innerText = data.nama || '-';
        document.getElementById('izTanggal').innerText = data.tanggal || '-';
        document.getElementById('izJenis').innerText = data.jenis || '-';
        document.getElementById('izAlasan').innerText = data.alasan || '-';
        
        const statusEl = document.getElementById('izStatus');
        statusEl.innerText = data.status || '-';
        statusEl.style.color = data.status === 'Disetujui' ? '#16a34a' : (data.status === 'Menunggu' ? '#ea580c' : '#dc2626');

        const boxLampiran = document.getElementById('izBoxLampiran');
        const linkLampiran = document.getElementById('izLinkLampiran');
        
        if (data.lampiran) {
            linkLampiran.href = data.lampiran;
            boxLampiran.style.display = 'block';
        } else {
            linkLampiran.removeAttribute('href');
            boxLampiran.style.display = 'none';
        }

        let modal = new bootstrap.Modal(document.getElementById('modalDetailIzin'));
        modal.show();
    } catch (error) {
        console.error("Error di showDetailIzin:", error);
    }
}

// --- FUNGSI MODAL KOREKSI MANUAL ---
function bukaKoreksi(id, nama, tanggalYmd, tanggalLabel, statusSaatIni = 'Hadir', jamMasuk = '', jamPulang = '') {
    try {
        document.getElementById('koreksi_user_id').value = id;
        document.getElementById('koreksi_tanggal').value = tanggalYmd;
        document.getElementById('koreksi_nama').innerText = nama;
        document.getElementById('koreksi_tgl_label').innerText = tanggalLabel;
        
        document.getElementById('koreksi_status').value = statusSaatIni;
        document.getElementById('koreksi_jam_masuk').value = jamMasuk ? jamMasuk.substring(0, 5) : '';
        document.getElementById('koreksi_jam_pulang').value = jamPulang ? jamPulang.substring(0, 5) : '';

        toggleFormJam(statusSaatIni);

        let modal = new bootstrap.Modal(document.getElementById('modalKoreksiAbsensi'));
        modal.show();
    } catch (error) {
        console.error("Error di bukaKoreksi:", error);
    }
}

// --- FUNGSI SEMBUNYIKAN FORM JAM SAAT EDIT ---
function toggleFormJam(status) {
    const rowJam = document.getElementById('rowJamKoreksi');
    if (rowJam) {
        if (status === 'Hadir' || status === 'Telat') {
            rowJam.style.display = 'flex';
        } else {
            rowJam.style.display = 'none';
        }
    }
}
</script>

@endsection