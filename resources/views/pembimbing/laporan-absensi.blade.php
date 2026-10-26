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
        
        <!-- Legend -->
        <div class="d-flex gap-3 mt-3 small text-muted flex-wrap">
            <span><span class="badge bg-success bg-opacity-25 text-success me-1">H</span> Hadir</span>
            <span><span class="badge bg-danger bg-opacity-25 text-danger me-1">T</span> Telat</span>
            <span><span class="badge bg-primary bg-opacity-25 text-primary me-1">I</span> Izin</span>
            <span><span class="badge bg-warning bg-opacity-25 text-warning me-1">S</span> Sakit</span>
            <span><span class="badge bg-danger bg-opacity-25 text-danger me-1">A</span> Alpa</span>
        </div>

    </div>
</div>
@endsection