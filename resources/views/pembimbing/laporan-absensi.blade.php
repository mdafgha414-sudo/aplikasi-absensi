@extends('layouts.app')

@section('content')
<style>
    .report-container { padding: 20px; background: #f8fafc; min-height: 100vh; }
    .report-card { background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 25px; border: 1px solid #eef2f9; }
    
    /* Styling Tabel Matriks */
    .matrix-table { border-collapse: separate; border-spacing: 0; width: 100%; min-width: 1100px; }
    .matrix-table th, .matrix-table td { border: 1px solid #f1f5f9; text-align: center; padding: 10px 5px; vertical-align: middle; }
    .matrix-table th { background: #f8faff; color: #64748b; font-weight: 600; font-size: 12px; white-space: nowrap; border-bottom: 2px solid #e2e8f0; }
    .matrix-table td { font-size: 12px; color: #334155; min-width: 40px; }
    .matrix-table .student-name { text-align: left; padding-left: 15px; font-weight: 700; color: #1e293b; min-width: 180px; position: sticky; left: 0; background: white; z-index: 1; border-right: 1px solid #f1f5f9; }
    .matrix-table thead .student-name { z-index: 2; background: #f8faff; }
    .matrix-table tbody tr:hover td { background-color: #f8fafc; }

    /* Badge Status */
    .status-badge-cell { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; font-weight: 700; font-size: 10px; }
    .cell-hadir { background: #dcfce7; color: #166534; }
    .cell-izin { background: #dbeafe; color: #1e40af; }
    .cell-sakit { background: #fef9c3; color: #854d0e; }
    .cell-telat { background: #fee2e2; color: #991b1b; }
    .cell-alfa { background: #fecdd3; color: #9f1239; }
    .cell-pending { background: #f1f5f9; color: #94a3b8; }

    /* Keterangan Status Kehadiran */
    .status-legend-wrapper {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #eeeeee;
    }

    .status-legend-title {
        font-size: 16px;
        font-weight: 700;
        color: #292d32;
        margin-bottom: 6px;
    }

    .status-legend-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .status-legend-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .status-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 15px;
        min-height: 40px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-legend-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 700;
    }

    /* Hadir */
    .status-legend-item.hadir {
        background: #e8f6ef;
        border-color: #a9dfc5;
        color: #168653;
    }

    .status-legend-item.hadir .status-legend-icon {
        background: #b5f5d0;
        color: #168653;
    }

    /* Telat */
    .status-legend-item.telat {
        background: #fff8e7;
        border-color: #ffdc91;
        color: #333333;
    }

    .status-legend-item.telat .status-legend-icon {
        background: #ffd5a8;
        color: #b75b00;
    }

    /* Izin */
    .status-legend-item.izin {
        background: #e5efff;
        border-color: #a8c9ff;
        color: #2563b9;
    }

    .status-legend-item.izin .status-legend-icon {
        background: #bfdbfe;
        color: #2563b9;
    }

    /* Sakit */
    .status-legend-item.sakit {
        background: #e8fbff;
        border-color: #9be7f5;
        color: #333333;
    }

    .status-legend-item.sakit .status-legend-icon {
        background: #fff08a;
        color: #806500;
    }

    /* Alpa */
    .status-legend-item.alpa {
        background: #fdebed;
        border-color: #ffb8c0;
        color: #333333;
    }

    .status-legend-item.alpa .status-legend-icon {
        background: #ffc4c8;
        color: #c62828;
    }

    /* Libur/Belum */
    .status-legend-item.libur {
        background: #f5f6f7;
        border-color: #f5f6f7;
        color: #60656b;
    }

    .status-legend-item.libur .status-legend-icon {
        background: #edf0f4;
        color: #8a929d;
    }

    @media (max-width: 576px) {
        .status-legend-list {
            gap: 7px;
        }

        .status-legend-item {
            padding: 7px 10px;
            gap: 7px;
        }
    }
</style>

<div class="report-container">
    <div class="report-card">
        
        <!-- Header & Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-calendar-check text-primary me-2"></i> Laporan Absensi</h4>
                <p class="text-muted small mb-0">Rekap kehadiran siswa berdasarkan tanggal.</p>
            </div>
            
            <div class="d-flex gap-2">
                <form action="/pembimbing/laporan-absensi" method="GET" class="d-flex gap-2">
                    <select name="bulan" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <!-- Tombol Export -->
                <a href="{{ route('pembimbing.laporan.export.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success btn-sm px-3">
                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                </a>
                <a href="{{ route('pembimbing.laporan.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger btn-sm px-3">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                </a>
            </div>
        </div>

        <!-- Tabel Matriks -->
        <div class="table-responsive">
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th class="student-name">Nama Siswa</th>
                        @foreach($tanggalList as $tgl)
                            <th>
                                {{ $tgl->format('d') }}<br>
                                <small class="text-muted">{{ $tgl->translatedFormat('D') }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                        <tr>
                            <td class="text-muted fw-bold">{{ $index + 1 }}</td>
                            <td class="student-name">{{ $s->name }}</td>
                            
                            @foreach($tanggalList as $tgl)
                                @php
                                    $tglStr = $tgl->format('d');
                                    $key = $s->id . '-' . $tglStr;
                                    
                                    $absen = $absensi[$key] ?? null;
                                    $status = $absen ? $absen->status : null;
                                    
                                    $cellClass = '';
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
                                        // Jika tidak ada data sama sekali, cek hari kerja
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
        
        <!-- Keterangan Status -->
        <div class="status-legend-wrapper">
            <h6 class="status-legend-title">Keterangan Status</h6>
            <p class="status-legend-subtitle">
                Indikator warna matriks kehadiran
            </p>

            <div class="status-legend-list">
                <div class="status-legend-item hadir">
                    <span class="status-legend-icon">H</span>
                    <span>Hadir</span>
                </div>

                <div class="status-legend-item telat">
                    <span class="status-legend-icon">T</span>
                    <span>Telat</span>
                </div>

                <div class="status-legend-item izin">
                    <span class="status-legend-icon">I</span>
                    <span>Izin</span>
                </div>

                <div class="status-legend-item sakit">
                    <span class="status-legend-icon">S</span>
                    <span>Sakit</span>
                </div>

                <div class="status-legend-item alpa">
                    <span class="status-legend-icon">A</span>
                    <span>Alpa</span>
                </div>

                <div class="status-legend-item libur">
                    <span class="status-legend-icon">-</span>
                    <span>Libur/Belum</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection