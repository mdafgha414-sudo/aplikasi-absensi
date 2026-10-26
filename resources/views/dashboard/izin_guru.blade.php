@extends('layouts.app')

@section('content')
<style>
    .matrix-container { overflow-x: auto; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 20px; border: 1px solid #eef2f9; }
    .matrix-table { border-collapse: separate; border-spacing: 0; width: 100%; min-width: 1100px; }
    .matrix-table th, .matrix-table td { border: 1px solid #f1f5f9; text-align: center; padding: 10px 5px; vertical-align: middle; }
    .matrix-table th { background: #f8faff; color: #64748b; font-weight: 600; font-size: 12px; white-space: nowrap; border-bottom: 2px solid #e2e8f0; }
    .matrix-table td { font-size: 12px; color: #334155; min-width: 45px; }
    .matrix-table .student-name { text-align: left; padding-left: 15px; font-weight: 700; color: #1e293b; min-width: 200px; position: sticky; left: 0; background: white; z-index: 1; border-right: 1px solid #f1f5f9; }
    .matrix-table thead .student-name { z-index: 2; background: #f8faff; }
    .matrix-table tbody tr:hover td { background-color: #f8fafc; }

    /* Desain Kotak Kecil */
    .status-badge-cell { 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        width: 32px; 
        height: 32px; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 11px; 
        cursor: pointer; /* Kursor berubah jadi tangan */
        transition: 0.2s;
    }
    .status-badge-cell:hover { transform: scale(1.1); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    
    .cell-hadir { background: #dcfce7; color: #166534; }
    .cell-izin { background: #dbeafe; color: #1e40af; }
    .cell-sakit { background: #fef9c3; color: #854d0e; }
    .cell-telat { background: #fee2e2; color: #991b1b; }
    .cell-alfa { background: #fecdd3; color: #9f1239; }
    .cell-pending { background: #f1f5f9; color: #94a3b8; }
</style>

<div class="container-fluid py-3">
    
    <!-- Filter Bulan & Tahun -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary me-2"></i> Matriks Kehadiran & Izin Siswa</h5>
        <form action="/guru/izin" method="GET" class="d-flex gap-2">
            <select name="bulan" class="form-select form-select-sm" onchange="this.form.submit()">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="form-select form-select-sm" onchange="this.form.submit()">
                @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- Tabel Matriks -->
    <div class="matrix-container">
        <table class="matrix-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
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
                                
                                // Data Absensi
                                $absen = $absensi[$key] ?? null;
                                $statusAbsen = $absen ? $absen->status : null;
                                $jamMasuk = $absen ? $absen->jam_masuk : null;
                                $jamPulang = $absen ? $absen->jam_pulang : null;
                                
                                // Data Izin
                                $izinData = $izin[$key] ?? null;
                                $statusIzin = $izinData ? $izinData->status : null;
                                $alasanIzin = $izinData ? $izinData->alasan : null;
                                $jenisIzin = $izinData ? $izinData->jenis_izin : null;
                                $lampiran = $izinData ? $izinData->lampiran : null;
                                $idIzin = $izinData ? $izinData->id : null;
                                
                                // Logika Tampilan
                                $cellClass = 'cell-pending';
                                $label = '-';
                                $tooltipTitle = 'Klik untuk detail';
                                
                                if ($statusIzin == 'Menunggu') {
                                    $cellClass = 'cell-pending';
                                    $label = '⏳';
                                    $tooltipTitle = 'Menunggu Persetujuan';
                                } elseif ($statusIzin == 'Disetujui' || $statusAbsen == 'Izin') {
                                    $cellClass = 'cell-izin';
                                    $label = 'I';
                                    $tooltipTitle = 'Izin Disetujui';
                                } elseif ($statusAbsen == 'Telat') {
                                    $cellClass = 'cell-telat';
                                    $label = 'T';
                                    $tooltipTitle = 'Telat';
                                } elseif ($statusAbsen == 'Sakit') {
                                    $cellClass = 'cell-sakit';
                                    $label = 'S';
                                    $tooltipTitle = 'Sakit';
                                } elseif ($statusAbsen) {
                                    $cellClass = 'cell-hadir';
                                    $label = 'H';
                                    $tooltipTitle = 'Hadir';
                                } else {
                                    // Alpa jika hari kerja & sudah lewat
                                    $isWeekend = in_array($tgl->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);
                                    if (!$isWeekend && $tgl->isPast()) {
                                        $cellClass = 'cell-alfa';
                                        $label = 'A';
                                        $tooltipTitle = 'Alpa (Tanpa Keterangan)';
                                    }
                                }
                            @endphp

                            <td>
                                <!-- Kotak yang bisa diklik -->
                                <div class="status-badge-cell {{ $cellClass }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $s->id }}-{{ $tglStr }}"
                                    title="{{ $tooltipTitle }}">
                                    {{ $label }}
                                </div>
                            </td>

                            <!-- MODAL DETAIL (Pop-up) -->
                            <div class="modal fade" id="detailModal{{ $s->id }}-{{ $tglStr }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow" style="border-radius: 15px;">
                                        <div class="modal-header bg-light border-0" style="border-radius: 15px 15px 0 0;">
                                            <h6 class="modal-title fw-bold"><i class="bi bi-person-badge text-primary me-2"></i> {{ $s->name }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="mb-3 text-muted small"><i class="bi bi-calendar3 me-2"></i>{{ $tgl->translatedFormat('l, d F Y') }}</p>
                                            
                                            @if($statusAbsen)
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Status Absensi:</span>
                                                    <span class="fw-bold {{ $statusAbsen == 'Telat' ? 'text-danger' : 'text-success' }}">{{ $statusAbsen }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Jam Masuk:</span>
                                                    <span class="fw-bold">{{ $jamMasuk ?? '-' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span class="text-muted">Jam Pulang:</span>
                                                    <span class="fw-bold">{{ $jamPulang ?? '-' }}</span>
                                                </div>
                                            @endif

                                            @if($statusIzin)
                                                <hr class="my-3 text-muted opacity-25">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Pengajuan Izin:</span>
                                                    <span class="badge bg-warning text-dark">{{ $statusIzin }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Jenis Izin:</span>
                                                    <span class="fw-bold">{{ $jenisIzin }}</span>
                                                </div>
                                                <div class="mb-2 mt-2">
                                                    <span class="text-muted d-block mb-1">Alasan:</span>
                                                    <em class="text-secondary">"{{ $alasanIzin }}"</em>
                                                </div>
                                                @if($lampiran)
                                                    <div class="mt-3">
                                                        <a href="{{ asset('storage/' . $lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-paperclip"></i> Lihat Lampiran
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                            
                                            @if(!$statusAbsen && !$statusIzin)
                                                <p class="text-center text-muted mb-0 py-3">Tidak ada data kehadiran/izin.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection