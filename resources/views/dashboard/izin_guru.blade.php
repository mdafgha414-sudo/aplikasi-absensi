@extends('layouts.app')

@section('content')

<style>
    /* CSS PENYESUAIAN LAPORAN ABSENSI & IZIN */
    .rekap-page {
        background: #f4f7fc;
        min-height: 100vh;
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .rekap-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        padding: 30px;
        border: 1px solid #eef2f9;
    }

    /* =========================================
       BANNER BIRU MUDA (DISAMAKAN DENGAN DASHBOARD)
       ========================================= */
    .hero-banner {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border: 1px solid #7dd3fc;
        border-radius: 16px;
        padding: 30px;
        color: #0f172a; /* Teks gelap agar terbaca */
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(56, 189, 248, 0.15);
        flex-wrap: wrap;
        gap: 20px;
    }
    .hero-left { display: flex; flex-direction: column; gap: 10px; }
    
    .hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #ffffff; color: #0284c7; /* Biru laut */
        padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;
        width: fit-content;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .hero-title { font-size: 28px; font-weight: 800; margin: 0; letter-spacing: -0.5px; color: #0f172a; }
    .hero-desc { font-size: 14px; color: #334155; margin: 0; max-width: 500px; line-height: 1.5; }
    
    .hero-right {
        display: flex; align-items: center; gap: 15px;
        background: rgba(255, 255, 255, 0.6); padding: 15px 25px; border-radius: 12px;
        backdrop-filter: blur(5px);
        border: 1px solid #bae6fd;
    }
    .hero-icon-box {
        width: 45px; height: 45px; background: #ffffff; color: #0284c7;
        border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .hero-stat h5 { margin: 0 0 2px 0; font-size: 13px; color: #475569; font-weight: 600; }
    .hero-stat h3 { margin: 0; font-size: 22px; font-weight: 700; color: #0284c7; }

    /* HEADER & TOMBOL EXPORT */
    .rekap-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
    .header-left { display: flex; align-items: flex-start; gap: 10px; flex-direction: column; }
    .header-title { font-size: 20px; font-weight: 700; color: #202124; margin: 0 0 5px 0; }
    .header-desc { font-size: 14px; color: #5f6368; margin: 0; }

    .filter-actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .filter-group {
        display: flex; align-items: center; background: #fff; border: 1px solid #dadce0;
        border-radius: 8px; padding: 0 12px; height: 42px; color: #3c4043;
    }
    .filter-group select { border: none; outline: none; background: transparent; font-size: 14px; color: #3c4043; cursor: pointer; }
    
    .btn-export {
        display: inline-flex; align-items: center; gap: 8px; padding: 0 18px;
        height: 42px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: 0.2s;
        cursor: pointer;
    }
    .btn-excel { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .btn-export:hover { filter: brightness(0.95); }
    .btn-pdf { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    /* SEARCH BAR */
    .search-bar-wrapper { margin-bottom: 25px; display: flex; }
    .search-input {
        width: 100%; max-width: 400px; height: 45px; border: 1px solid #dadce0;
        border-radius: 8px; padding: 0 15px 0 45px; font-size: 14px; color: #3c4043; outline: none;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='%235f6368' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E") no-repeat 15px center;
    }

    /* TABEL MATRIKS */
    .table-responsive { overflow-x: auto; border: 1px solid #e0e0e0; border-radius: 8px; -webkit-overflow-scrolling: touch; }
    .matrix-table { width: 100%; border-collapse: collapse; min-width: 1000px; text-align: center; }
    
    .matrix-table th, .matrix-table td { border: 1px solid #e0e0e0; padding: 16px 10px; vertical-align: middle; }
    
    /* HEADER TANGGAL */
    .matrix-table thead th { background: #ffffff; font-weight: 600; color: #3c4043; font-size: 14px; border-bottom: 2px solid #e0e0e0; }
    .matrix-table thead th .day-name { display: block; font-size: 11px; color: #80868b; font-weight: 400; margin-top: 3px; text-transform: uppercase; }

    /* STICKY KOLOM NAMA */
    .matrix-table td:first-child, .matrix-table th:first-child { text-align: center; width: 60px; font-weight: 600; color: #3c4043; font-size: 14px; }
    .matrix-table .student-name { 
        text-align: left; padding-left: 15px; font-weight: 600; color: #202124; min-width: 220px; font-size: 15px;
        position: sticky; left: 0; background: white; z-index: 1; border-right: 1px solid #e0e0e0;
    }
    .matrix-table thead .student-name { z-index: 2; background: #ffffff; }
    .matrix-table tbody tr:hover td { background-color: #f8fafc; }
    .matrix-table tbody tr:hover .student-name { background-color: #f8fafc; }

    /* AVATAR */
    .student-info { display: flex; align-items: center; gap: 12px; }
    .avatar-circle {
        width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff;
    }
    .bg-av-1 { background: #a8c0ff; color: #1a3b8b; }
    .bg-av-2 { background: #d4b4ff; color: #5b2c8b; }
    .bg-av-3 { background: #ffb4c0; color: #8b2c3d; }
    .bg-av-4 { background: #b4ffd4; color: #2c8b5b; }

    /* STATUS ICONS (PASTEL KOTAK) */
    .status-box {
        width: 34px; height: 34px; border-radius: 8px; display: inline-flex;
        align-items: center; justify-content: center; font-weight: 800; font-size: 15px;
        text-decoration: none; transition: transform 0.2s;
    }
    .status-box.clickable:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); cursor: pointer; }
    
    .status-hadir { background: #dcfce7; color: #16a34a; }
    .status-izin { background: #dbeafe; color: #2563eb; }
    .status-sakit { background: #fef9c3; color: #ca8a04; }
    .status-alpa { background: #fee2e2; color: #dc2626; }
    .status-telat { background: #ffedd5; color: #ea580c; }
    
    /* KOSONG / LIBUR */
    .status-empty { 
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; color: #cbd5e1; font-size: 20px; font-weight: 600;
    }

    /* JAM PASIR MENUNGGU */
    .status-menunggu { 
        background: #fffbeb; 
        border: 1px solid #fde68a;
        color: #d97706; 
        animation: putarPelan 3s infinite ease-in-out;
    }
    .status-menunggu svg { width: 18px; height: 18px; fill: currentColor; }

    @keyframes putarPelan {
        0% { transform: rotate(0deg); }
        25% { transform: rotate(10deg); }
        75% { transform: rotate(-10deg); }
        100% { transform: rotate(0deg); }
    }

    /* KETERANGAN STATUS BAWAH */
    .legend-container {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 30px; flex-wrap: wrap; gap: 20px;
    }
    .legend-title h4 { margin: 0 0 5px 0; font-size: 16px; font-weight: 700; color: #202124; }
    .legend-title p { margin: 0; font-size: 13px; color: #80868b; }
    
    .legend-items { display: flex; gap: 12px; flex-wrap: wrap; }
    .legend-box {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
    }
    .legend-box.hadir { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .legend-box.telat { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .legend-box.izin  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .legend-box.sakit { background: #fefce8; color: #ca8a04; border: 1px solid #fef08a; }
    .legend-box.alpa  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .legend-box.empty { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }
    .legend-box span { font-weight: 800; font-size: 14px; }
</style>

<div class="rekap-page">
    
    <!-- BANNER BIRU MUDA -->
    <div class="hero-banner">
        <div class="hero-left">
            <div class="hero-badge">
                <i class="bi bi-calendar-check"></i> Laporan Kehadiran
            </div>
            <h1 class="hero-title">Laporan Absensi & Izin PKL</h1>
            <p class="hero-desc">Pantau riwayat kehadiran, keterlambatan, serta persetujuan izin siswa bimbingan Anda secara praktis.</p>
        </div>
        
        <div class="hero-right">
            <div class="hero-icon-box">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="hero-stat">
                <h5>Total Siswa</h5>
                <h3>{{ count($siswa) }} Siswa</h3>
            </div>
        </div>
    </div>

    <div class="rekap-card">
        
        <!-- HEADER & FILTER -->
        <div class="rekap-header">
            <div class="header-left">
                <div>
                    <h2 class="header-title">Detail Kehadiran Harian</h2>
                    <p class="header-desc">Pilih bulan dan tahun untuk melihat data.</p>
                </div>
            </div>
            
            <div class="filter-actions">
                <form action="" method="GET" class="d-flex gap-2">
                    <div class="filter-group">
                        <select name="bulan" onchange="this.form.submit()">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="filter-group">
                        <select name="tahun" onchange="this.form.submit()">
                            @for ($i = date('Y') - 2; $i <= date('Y') + 5; $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </form>

                <!-- TOMBOL EXPORT -->
                <a href="{{ route('guru.export.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn-export btn-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('guru.export.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn-export btn-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        <!-- PENCARIAN -->
        <div class="search-bar-wrapper">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari nama siswa...">
        </div>

        <!-- TABEL MATRIKS -->
        <div class="table-responsive">
            <table class="matrix-table" id="rekapTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="student-name">Nama Siswa</th>
                        @foreach($tanggalList as $tgl)
                            @php
                                $isWeekend = $tgl->isWeekend();
                                $bgStyle = $isWeekend ? 'background-color: #e0f2fe;' : 'background-color: #ffffff;'; 
                            @endphp
                            <th style="{{ $bgStyle }}">
                                {{ $tgl->format('d') }}
                                <span class="day-name">{{ $tgl->translatedFormat('D') }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $index => $s)
                        <tr class="student-row">
                            <td>{{ $index + 1 }}</td>
                            <td class="student-name">
                                <div class="student-info">
                                    <div class="avatar-circle bg-av-{{ ($index % 4) + 1 }}">
                                        {{ strtoupper(substr($s->name, 0, 2)) }}
                                    </div>
                                    <span>{{ $s->name }}</span>
                                </div>
                            </td>
                            @foreach($tanggalList as $tgl)
                                @php
                                    $key = $s->id . '-' . $tgl->format('d');
                                    $statusAbsen = isset($absensi[$key]) ? $absensi[$key]->status : null;
                                    $dataIzin = isset($izin[$key]) ? $izin[$key] : null;
                                    
                                    $finalStatus = null;

                                    if ($dataIzin) {
                                        if ($dataIzin->status == 'Menunggu') {
                                            $finalStatus = 'Menunggu';
                                        } else if ($dataIzin->status == 'Disetujui') {
                                            $finalStatus = $dataIzin->jenis_izin; 
                                        } else {
                                            $finalStatus = $statusAbsen ?? 'Alpa'; 
                                        }
                                    } else {
                                        $finalStatus = $statusAbsen ?? 'Alpa';
                                    }

                                    if (!$statusAbsen && !$dataIzin && $tgl->isWeekend()) {
                                        $finalStatus = 'Libur';
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
                                    @if($finalStatus == 'Hadir' || $finalStatus == 'Tepat Waktu')
                                        <span class="status-box status-hadir"><i class="bi bi-check-lg"></i></span>
                                    
                                    @elseif($finalStatus == 'Telat' || $finalStatus == 'Terlambat')
                                        <span class="status-box status-telat">T</span>

                                    @elseif($finalStatus == 'Izin')
                                        <a href="javascript:void(0)" class="status-box status-izin clickable" onclick="showDetailIzin({{ $jsonIzin }})">I</a>
                                    
                                    @elseif($finalStatus == 'Sakit')
                                        <a href="javascript:void(0)" class="status-box status-sakit clickable" onclick="showDetailIzin({{ $jsonIzin }})">S</a>
                                    
                                    @elseif($finalStatus == 'Menunggu')
                                        <a href="javascript:void(0)" class="status-box status-menunggu clickable" title="Menunggu Persetujuan" onclick="showDetailIzin({{ $jsonIzin }})">
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 2v6h.01L6 8.01 10 12l-4 4 .01.01H6V22h12v-5.99h-.01L18 16l-4-4 4-3.99-.01-.01H18V2H6zm10 14.5V20H8v-3.5l4-4 4 4zm-4-5l-4-4V4h8v3.5l-4 4z"/>
                                            </svg>
                                        </a>
                                    
                                    @elseif($finalStatus == 'Alpa')
                                        <span class="status-box status-alpa">A</span>
                                    
                                    @else
                                        <span class="status-empty">&minus;</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- KETERANGAN STATUS -->
        <div class="legend-container">
            <div class="legend-title">
                <h4>Keterangan Status</h4>
                <p>Indikator warna matriks kehadiran</p>
            </div>
            <div class="legend-items">
                <div class="legend-box hadir"><span>H</span> Hadir</div>
                <div class="legend-box telat"><span>T</span> Telat</div>
                <div class="legend-box izin"><span>I</span> Izin</div>
                <div class="legend-box sakit"><span>S</span> Sakit</div>
                <div class="legend-box alpa"><span>A</span> Alpa</div>
                <div class="legend-box empty">- Libur/Belum</div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL POP-UP UNTUK LAMPIRAN -->
<div id="modalIzin" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(3px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 30px; border-radius: 16px; width: 90%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 20px; color: #1e293b; font-weight: 700;">Detail Pengajuan</h3>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #94a3b8;">&times;</button>
        </div>
        
        <div style="font-size: 15px; color: #334155; line-height: 1.8;">
            <p style="margin: 0 0 10px 0;"><strong>Nama:</strong> <span id="modalNama"></span></p>
            <p style="margin: 0 0 10px 0;"><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
            <p style="margin: 0 0 10px 0;"><strong>Jenis:</strong> <span id="modalJenis"></span></p>
            <p style="margin: 0 0 10px 0;"><strong>Status:</strong> <span id="modalStatus" style="font-weight: bold;"></span></p>
            <p style="margin: 0 0 15px 0;"><strong>Alasan:</strong> <span id="modalAlasan"></span></p>
            
            <div id="modalLampiranContainer" style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                <strong>Lampiran Bukti:</strong><br>
                <a id="modalLampiranLink" href="#" target="_blank" style="display: inline-block; margin-top: 10px; padding: 12px 24px; background: #eff6ff; color: #2563eb; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    <i class="bi bi-paperclip"></i> Lihat Surat/Foto
                </a>
                <span id="modalTidakAdaLampiran" style="display: none; color: #dc2626; font-weight: 600;">Tidak ada lampiran</span>
            </div>
        </div>
        
        <div style="margin-top: 25px; text-align: right;">
            <button onclick="closeModal()" style="padding: 12px 28px; background: #f1f5f9; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; color: #475569; transition: 0.2s;">Tutup</button>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL DAN PENCARIAN -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.student-row');

    searchInput.addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        
        rows.forEach(row => {
            const name = row.querySelector('.student-name').textContent.toLowerCase();
            if (name.includes(keyword)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

function showDetailIzin(data) {
    document.getElementById('modalNama').innerText = data.nama;
    document.getElementById('modalTanggal').innerText = data.tanggal;
    document.getElementById('modalJenis').innerText = data.jenis;
    document.getElementById('modalAlasan').innerText = data.alasan;

    const statusEl = document.getElementById('modalStatus');
    statusEl.innerText = data.status;
    
    if (data.status === 'Menunggu') statusEl.style.color = '#ea580c';
    else if (data.status === 'Disetujui') statusEl.style.color = '#16a34a';
    else statusEl.style.color = '#dc2626';

    const btnLampiran = document.getElementById('modalLampiranLink');
    const textNoLampiran = document.getElementById('modalTidakAdaLampiran');

    if (data.lampiran) {
        btnLampiran.href = data.lampiran;
        btnLampiran.style.display = 'inline-block';
        textNoLampiran.style.display = 'none';
    } else {
        btnLampiran.style.display = 'none';
        textNoLampiran.style.display = 'inline-block';
    }

    const modal = document.getElementById('modalIzin');
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalIzin').style.display = 'none';
}
</script>

@endsection