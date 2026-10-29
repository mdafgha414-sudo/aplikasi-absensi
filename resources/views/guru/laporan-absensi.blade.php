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
    }

    .cell-hadir { background: #dcfce7; color: #15803d; }
    .cell-izin { background: #dbeafe; color: #1d4ed8; }
    .cell-sakit { background: #fef9c3; color: #a16207; }
    .cell-telat { background: #ffedd5; color: #c2410c; }
    .cell-alfa { background: #ffe4e6; color: #be123c; }
    .cell-pending { background: #f1f5f9; color: #94a3b8; }

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

    /* Header kolom nama siswa juga lavender */
    .matrix-table thead .student-name {
        background-color: #E6E6FA !important;
        color: #312E5C;
    }

    /* Header nomor */
    .matrix-table thead th:first-child {
        background-color: #E6E6FA !important;
    }

    /* ========================================
    WARNA STATUS KEHADIRAN
    ======================================== */

    /* T = Telat, oranye */
    .cell-telat {
        background-color: #FED7AA !important;
        color: #C2410C !important;
    }

    /* H = Hadir, hijau */
    .cell-hadir {
        background-color: #BBF7D0 !important;
        color: #166534 !important;
    }

    /* A = Alpa, merah */
    .cell-alfa {
        background-color: #FECACA !important;
        color: #B91C1C !important;
    }

    /* S = Sakit, kuning */
    .cell-sakit {
        background-color: #FEF08A !important;
        color: #854D0E !important;
    }

    /* I = Izin, biru muda */
    .cell-izin {
        background-color: #BFDBFE !important;
        color: #1D4ED8 !important;
    }

    /* Hari tanpa data */
    .cell-pending {
        background-color: #F1F5F9 !important;
        color: #64748B !important;
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
        <div>
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
                <p class="text-muted small mb-0">Filter berdasarkan bulan dan tahun untuk melihat detail harian.</p>
            </div>
            
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <form action="/guru/laporan-absensi" method="GET" class="d-flex gap-2">
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
                <a href="{{ route('guru.export.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-success btn-sm px-3 rounded-3 fw-medium">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('guru.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-outline-danger btn-sm px-3 rounded-3 fw-medium">
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
                    @foreach($siswa as $index => $s)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $index + 1 }}</td>
                            <td class="student-name">{{ $s->name }}</td>
                            
                            @foreach($tanggalList as $tgl)
                                @php
                                    $tglStr = $tgl->format('d');
                                    $key = $s->id . '-' . $tglStr;
                                    
                                    $absen = $absensi[$key] ?? null;
                                    $status = $absen ? $absen->status : null;
                                    
                                    $cellClass = 'cell-pending';
                                    $label = '-';
                                    
                                    if ($status == 'Telat') {
                                        $cellClass = 'cell-telat';
                                        $label = 'T';
                                    } elseif ($status == 'Izin') {
                                        $cellClass = 'cell-izin';
                                        $label = 'I';
                                    } elseif ($status == 'Sakit') {
                                        $cellClass = 'cell-sakit';
                                        $label = 'S';
                                    } elseif ($status == 'Alpa') {
                                        $cellClass = 'cell-alfa';
                                        $label = 'A';
                                    } elseif ($status) {
                                        $cellClass = 'cell-hadir';
                                        $label = 'H';
                                    } else {
                                        $isWeekend = in_array($tgl->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);
                                        if (!$isWeekend && $tgl->isPast()) {
                                            $cellClass = 'cell-alfa';
                                            $label = 'A';
                                        }
                                    }
                                @endphp

                                <td>
                                    <div class="status-badge-cell {{ $cellClass }}">
                                        {{ $label }}
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Legend & Keterangan (Tampilan Bawah Diperbarui Menarik) -->
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
@endsection