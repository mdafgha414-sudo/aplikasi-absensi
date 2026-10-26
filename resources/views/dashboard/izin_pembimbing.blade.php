@extends('layouts.app')

@section('content')
<style>
    /* --- STYLING MATRIKS MODERN --- */
    .matrix-container { 
        overflow-x: auto; 
        background: white; 
        border-radius: 20px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.03); 
        padding: 25px; 
        margin-bottom: 30px;
        border: 1px solid #eef2f9;
    }
    
    .matrix-table { 
        border-collapse: separate; 
        border-spacing: 0; 
        width: 100%; 
        min-width: 1100px; 
    }
    
    .matrix-table th, .matrix-table td { 
        border: none; 
        border-bottom: 1px solid #f1f5f9; 
        text-align: center; 
        padding: 14px 8px; 
        vertical-align: middle; 
    }
    
    .matrix-table th { 
        background: transparent; 
        color: #64748b; 
        font-weight: 600; 
        font-size: 12px; 
        white-space: nowrap;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .matrix-table td { 
        font-size: 13px; 
        color: #334155; 
        min-width: 45px;
    }
    
    .matrix-table .student-name { 
        text-align: left; 
        padding-left: 20px; 
        font-weight: 700; 
        color: #1e293b;
        min-width: 200px; 
        position: sticky;
        left: 0;
        background: white;
        z-index: 1;
        border-right: 1px solid #f1f5f9;
    }
    
    .matrix-table thead .student-name {
        z-index: 2;
        background: white;
    }
    
    /* Efek Hover Baris */
    .matrix-table tbody tr:hover td {
        background-color: #f8fafc;
    }
    
    /* Desain Kotak Status (Pill/Bulat) */
    .status-badge-cell {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .status-badge-cell:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    /* Warna Status */
    .cell-hadir { background: #dcfce7; color: #166534; }
    .cell-izin { background: #dbeafe; color: #1e40af; }
    .cell-sakit { background: #fef9c3; color: #854d0e; }
    .cell-telat { background: #fee2e2; color: #991b1b; }
    .cell-alfa { background: #fecdd3; color: #9f1239; }
    .cell-menunggu { background: #fef3c7; color: #b45309; border: 1px dashed #f59e0b; }

    /* Legend */
    .legend-box { display: flex; gap: 20px; flex-wrap: wrap; padding: 15px 25px; background: #f8fafc; border-radius: 12px; border: 1px solid #eef2f9; margin-top: 15px; }
    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #475569; }
    .legend-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 11px; font-weight: bold; }

    /* --- STYLING PANEL APPROVE BAWAH --- */
    .approval-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #eef2f9;
        padding: 25px;
    }
    .approval-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        margin-bottom: 12px;
        background: #f8fafc;
        transition: 0.2s;
    }
    .approval-item:hover { background: #f1f5f9; border-color: #e2e8f0; }
    .approval-info h6 { margin: 0; font-weight: 700; color: #1e293b; }
    .approval-info p { margin: 0; font-size: 13px; color: #64748b; margin-top: 4px; }
    
    .btn-approve { background: #10b981; color: white; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; transition: 0.2s; }
    .btn-approve:hover { background: #059669; }
    .btn-reject { background: #ef4444; color: white; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; transition: 0.2s; }
    .btn-reject:hover { background: #dc2626; }
</style>

<div class="container-fluid py-3">
    
    <!-- Filter Bulan & Tahun -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i> Matriks Kehadiran</h5>
        <form action="/pembimbing/izin" method="GET" class="d-flex gap-2">
            <select name="bulan" class="form-select form-select-sm border-0 shadow-sm" onchange="this.form.submit()" style="background: #f8fafc;">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="form-select form-select-sm border-0 shadow-sm" onchange="this.form.submit()" style="background: #f8fafc;">
                @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    <!-- TABEL MATRIKS -->
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
                                
                                // Cek Absensi
                                $absen = $absensi[$key] ?? null;
                                $statusAbsen = $absen ? $absen->status : null;
                                $jamMasuk = $absen ? $absen->jam_masuk : null;
                                
                                // Cek Izin
                                $izinData = $izin[$key] ?? null;
                                $statusIzin = $izinData ? $izinData->status : null;
                                $alasanIzin = $izinData ? $izinData->alasan : null;
                                $jenisIzin = $izinData ? $izinData->jenis_izin : null;
                                
                                // Logika Penentuan Status Tampilan
                                $cellClass = '';
                                $label = '-';
                                $tooltipTitle = 'Klik untuk detail';
                                
                                if ($statusIzin == 'Menunggu') {
                                    $cellClass = 'cell-menunggu';
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
                                    // Jika tidak ada absensi & tidak ada izin, cek apakah hari kerja (Senin-Jumat)
                                    $isWeekend = in_array($tgl->dayOfWeek, [Carbon\Carbon::SATURDAY, Carbon\Carbon::SUNDAY]);
                                    if (!$isWeekend && $tgl->isPast()) {
                                        $cellClass = 'cell-alfa';
                                        $label = 'A';
                                        $tooltipTitle = 'Alpa';
                                    }
                                }
                            @endphp

                            <td>
                                <!-- Kotak Status yang bisa diklik -->
                                <div class="status-badge-cell {{ $cellClass }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal{{ $s->id }}-{{ $tglStr }}"
                                    title="{{ $tooltipTitle }}">
                                    {{ $label }}
                                </div>
                            </td>

                            <!-- MODAL DETAIL UNTUK SETIAP SEL -->
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
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span class="text-muted">Jam Masuk:</span>
                                                    <span class="fw-bold">{{ $jamMasuk ?? '-' }}</span>
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
                                                <div class="mb-0 mt-2">
                                                    <span class="text-muted d-block mb-1">Alasan:</span>
                                                    <em class="text-secondary">"{{ $alasanIzin }}"</em>
                                                </div>
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

        <!-- LEGEND / KETERANGAN WARNA -->
        <div class="legend-box">
            <div class="legend-item"><div class="legend-icon cell-hadir">H</div> Hadir</div>
            <div class="legend-item"><div class="legend-icon cell-izin">I</div> Izin</div>
            <div class="legend-item"><div class="legend-icon cell-sakit">S</div> Sakit</div>
            <div class="legend-item"><div class="legend-icon cell-telat">T</div> Telat</div>
            <div class="legend-item"><div class="legend-icon cell-alfa">A</div> Alpa (Tanpa Keterangan)</div>
        </div>
    </div>

    <!-- PANEL APPROVE DI BAWAH -->
    <div class="approval-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0"><i class="bi bi-inbox-fill text-warning me-2"></i> Menunggu Persetujuan Izin</h5>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ $izinMenunggu->count() }} Pengajuan</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 mb-4 rounded-3 shadow-sm">{{ session('success') }}</div>
        @endif

        @forelse($izinMenunggu as $izin)
            <div class="approval-item">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px;">
                        {{ strtoupper(substr($izin->user->name, 0, 1)) }}
                    </div>
                    <div class="approval-info">
                        <h6>{{ $izin->user->name }}</h6>
                        <p>
                            <span class="badge bg-secondary me-1 rounded-pill">{{ $izin->jenis_izin }}</span>
                            <span class="mx-1">&bull;</span> 
                            <strong>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</strong>
                        </p>
                        <p class="fst-italic text-secondary mt-1">"{{ $izin->alasan }}"</p>
                        @if($izin->lampiran)
                            <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank" class="small text-decoration-none fw-bold mt-2 d-inline-block">
                                <i class="bi bi-paperclip"></i> Lihat Lampiran
                            </a>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Disetujui">
                        <button type="submit" class="btn-approve shadow-sm">Setujui</button>
                    </form>
                    <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="btn-reject shadow-sm">Tolak</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                </div>
                <h6 class="fw-bold">Tidak ada pengajuan izin yang menunggu.</h6>
                <p class="mb-0 small">Semua pengajuan izin sudah diproses dengan baik.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection