
@extends('layouts.app')

@section('content')

{{-- =========================================================
    TIMETRIX - DASHBOARD PEMBIMBING
    File   : resources/views/dashboard/user_pembimbing.blade.php
    Fungsi : Halaman utama pembimbing PKL.
    ========================================================= --}}

<div class="timetrix-dashboard">

    {{-- 2. WELCOME BANNER --}}
    <div class="welcome-banner">

        <div class="banner-content">
            <div class="banner-label">
                <span class="banner-dot"></span>
                RUANG KERJA PEMBIMBING
            </div>

            <h1>
                Selamat Datang,<br>
                {{ Auth::user()->name }}
            </h1>

            <p>
                Semua aktivitas siswa bimbingan Anda tersusun
                rapi dalam satu ruang kerja yang sederhana.
            </p>
        </div>

        <div class="attendance-summary">

            <div class="summary-label">
                RINGKASAN JURNAL
            </div>

            @php
                $persentaseJurnal = ($totalJurnal ?? 0) > 0
                    ? round(
                        (($jurnalSudahDinilai ?? 0) / $totalJurnal) * 100
                    )
                    : 0;
            @endphp

            <div class="summary-number">
                {{ $persentaseJurnal }}%
            </div>

            <div class="summary-description">
                Jurnal telah dinilai
            </div>

            <div class="summary-progress"
                 role="progressbar"
                 aria-valuenow="{{ $persentaseJurnal }}"
                 aria-valuemin="0"
                 aria-valuemax="100"
                 aria-label="Persentase jurnal yang sudah dinilai">

                <div style="width: {{ $persentaseJurnal }}%"></div>
            </div>

            <div class="summary-footer">
                <span>{{ $jurnalSudahDinilai ?? 0 }} selesai</span>
                <span>{{ $jurnalBelumDinilai ?? 0 }} menunggu</span>
            </div>

        </div>
    </div>


    {{-- 3. STATISTIK PEMBIMBING --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Siswa PKL</p>
                <h3>{{ $totalSiswa ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-blue">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Total Jurnal</p>
                <h3>{{ $totalJurnal ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-purple">
                <i class="bi bi-journal-text"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Belum Dinilai</p>
                <h3>{{ $jurnalBelumDinilai ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-yellow">
                <i class="bi bi-file-earmark-text"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <p>Sudah Dinilai</p>
                <h3>{{ $jurnalSudahDinilai ?? 0 }}</h3>
            </div>
            <div class="stat-icon icon-green">
                <i class="bi bi-check-lg"></i>
            </div>
        </div>

    </div>


    {{-- 4. AKSES CEPAT --}}
    <div class="section-heading">
        <div>
            <h5>Akses Cepat</h5>
            <p>Pilih menu untuk mengelola aktivitas siswa</p>
        </div>
    </div>

    <div class="quick-access-grid">

        <a href="{{ url('/pembimbing/jurnal') }}" class="quick-card">
            <div class="quick-icon icon-purple">
                <i class="bi bi-journal-check"></i>
            </div>
            <div class="quick-content">
                <h6>Nilai Jurnal Siswa</h6>
                <p>Periksa jurnal dan berikan penilaian.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ url('/pembimbing/laporan-absensi') }}" class="quick-card">
            <div class="quick-icon icon-blue">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="quick-content">
                <h6>Laporan Absensi</h6>
                <p>Pantau rekap kehadiran siswa.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ route('pembimbing.scan.index') }}" class="quick-card">
            <div class="quick-icon icon-green">
                <i class="bi bi-qr-code-scan"></i>
            </div>
            <div class="quick-content">
                <h6>Scan Kartu Siswa</h6>
                <p>Catat kehadiran melalui QR Code.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ route('qr.index') }}" class="quick-card">
            <div class="quick-icon icon-yellow">
                <i class="bi bi-printer"></i>
            </div>
            <div class="quick-content">
                <h6>Buat Kode QR</h6>
                <p>Cetak kartu QR siswa PKL.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ url('/pembimbing/izin') }}" class="quick-card">
            <div class="quick-icon icon-orange">
                <i class="bi bi-envelope-paper"></i>
            </div>
            <div class="quick-content">
                <h6>Daftar Izin Siswa</h6>
                <p>Periksa pengajuan izin dan sakit.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ url('/pembimbing/alasan-keterlambatan') }}" class="quick-card">
            <div class="quick-icon icon-red">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="quick-content">
                <h6>Alasan Keterlambatan</h6>
                <p>Kelola alasan keterlambatan siswa.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ route('pembimbing.siswa.index') }}" class="quick-card">
            <div class="quick-icon icon-cyan">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="quick-content">
                <h6>Manajemen Siswa</h6>
                <p>Kelola data siswa dan guru bimbingan PKL.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

        <a href="{{ route('pembimbing.sekolah.index') }}" class="quick-card">
            <div class="quick-icon icon-cyan">
                <i class="bi bi-building"></i>
            </div>
            <div class="quick-content">
                <h6>Manajemen Sekolah</h6>
                <p>Kelola daftar sekolah asal siswa PKL.</p>
            </div>
            <i class="bi bi-arrow-up-right quick-arrow"></i>
        </a>

    </div>


    {{-- 5. RIWAYAT JURNAL TERBARU --}}
    <div class="activity-card">

        <div class="activity-header">

            <div>
                <span class="section-eyebrow">
                    AKTIVITAS TERBARU
                </span>

                <h5>Riwayat Jurnal Terbaru</h5>

                <p>
                    Daftar jurnal yang baru saja diisi oleh siswa.
                </p>
            </div>

            <a href="{{ url('/pembimbing/jurnal') }}" class="view-all-btn">
                Lihat Semua
                <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>

        {{-- WRAPPER TABEL RESPONSIVE --}}
        <div class="jurnal-table-wrapper">

            <table class="table jurnal-table align-middle">

                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Tanggal Jurnal</th>
                        <th>Jam Diisi</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse(($jurnalTerbaru ?? []) as $jurnal)

                        <tr>

                            {{-- NAMA SISWA --}}
                            <td>
                                <div class="student-info">

                                    <div class="student-avatar">
                                        {{ strtoupper(substr($jurnal->user->name ?? 'S', 0, 1)) }}
                                    </div>

                                    <span>
                                        {{ $jurnal->user->name ?? 'Siswa' }}
                                    </span>

                                </div>
                            </td>

                            {{-- TANGGAL JURNAL --}}
                            <td>
                                {{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}
                            </td>

                            {{-- JAM JURNAL --}}
                            <td>
                                <span class="time-badge">
                                    <i class="bi bi-clock"></i>

                                    {{ $jurnal->created_at
                                        ? $jurnal->created_at->format('H:i')
                                        : '-' }} WIB
                                </span>
                            </td>

                            {{-- STATUS PENILAIAN --}}
                            <td>

                                @if($jurnal->nilai !== null)

                                    <span class="status-badge status-success">
                                        <span></span>
                                        Sudah Dinilai
                                    </span>

                                @else

                                    <span class="status-badge status-pending">
                                        <span></span>
                                        Belum Dinilai
                                    </span>

                                @endif

                            </td>

                            {{-- TOMBOL BERI NILAI --}}
                            <td class="text-end">

                                <a href="{{ url('/pembimbing/jurnal') }}" class="action-btn">
                                    Beri Nilai
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada jurnal yang diisi oleh siswa.</p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

/* =========================================================
   6.1 VARIABEL WARNA DAN DASAR DASHBOARD
   ========================================================= */

.timetrix-dashboard {
    --navy: #142f52;
    --navy-light: #203f66;
    --primary: #078fc5;
    --background: #f3f6fa;
    --text: #172033;
    --muted: #718096;

    background: var(--background);
    min-height: 100vh;
    padding: 28px;
    font-family: 'Inter', 'Segoe UI', sans-serif;
    color: var(--text);
}


/* =========================================================
   6.2 HEADER DASHBOARD
   ========================================================= */

.dashboard-heading {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 18px;
    padding: 20px 24px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(15, 35, 65, 0.025);
}

.dashboard-heading h4 {
    font-size: 19px;
    font-weight: 700;
    margin: 0 0 5px;
}

.dashboard-heading p {
    font-size: 12px;
    color: #94a3b8;
    margin: 0;
}

.dashboard-user {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #475569;
    font-size: 14px;
    font-weight: 600;
}

.dashboard-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #334155;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    overflow: hidden;
    flex-shrink: 0;
}

.dashboard-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


/* =========================================================
   6.3 WELCOME BANNER
   ========================================================= */

.welcome-banner {
    background: linear-gradient(
        120deg,
        #142f52 0%,
        #193b64 100%
    );
    border-radius: 24px;
    padding: 48px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(20, 47, 82, 0.12);
}

.welcome-banner::before {
    content: "";
    position: absolute;
    width: 480px;
    height: 480px;
    right: 5%;
    top: -250px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 50%;
    box-shadow:
        0 0 0 35px rgba(255, 255, 255, 0.025),
        0 0 0 70px rgba(255, 255, 255, 0.02),
        0 0 0 105px rgba(255, 255, 255, 0.015);
    pointer-events: none;
}

.banner-content {
    position: relative;
    z-index: 1;
    max-width: 620px;
}

.banner-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.14);
    color: #e2eaf5;
    border-radius: 30px;
    padding: 9px 15px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.6px;
    margin-bottom: 24px;
}

.banner-dot {
    width: 7px;
    height: 7px;
    background: #facc15;
    border-radius: 50%;
}

.banner-content h1 {
    font-family: Georgia, serif;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 700;
    color: #ffffff;
    line-height: 1.3;
    margin: 0 0 16px;
}

.banner-content p {
    color: #b7c8dc;
    font-size: 14px;
    line-height: 1.8;
    margin: 0;
    max-width: 520px;
}


/* =========================================================
   6.4 RINGKASAN JURNAL
   ========================================================= */

.attendance-summary {
    position: relative;
    z-index: 1;
    width: 225px;
    min-width: 225px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 18px;
    padding: 22px;
}

.summary-label {
    font-size: 10px;
    font-weight: 700;
    color: #9fb4ce;
    letter-spacing: 1px;
    margin-bottom: 16px;
}

.summary-number {
    font-size: 36px;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 10px;
}

.summary-description {
    font-size: 11px;
    color: #bdcde0;
    margin-bottom: 16px;
}

.summary-progress {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.12);
    border-radius: 10px;
    overflow: hidden;
}

.summary-progress div {
    height: 100%;
    background: #facc15;
    border-radius: 10px;
    transition: width 0.4s ease;
}

.summary-footer {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    margin-top: 12px;
    color: #b7c8dc;
    font-size: 9px;
}


/* =========================================================
   6.5 GRID STATISTIK
   ========================================================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 30px;
}

.stat-card {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 18px;
    padding: 25px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15, 35, 65, 0.06);
}

.stat-info p {
    font-size: 12px;
    color: #64748b;
    margin: 0 0 10px;
}

.stat-info h3 {
    font-size: 27px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
    flex-shrink: 0;
}


/* =========================================================
   6.6 WARNA IKON
   ========================================================= */

.icon-blue {
    background: #e0f2fe;
    color: #0284c7;
}

.icon-purple {
    background: #f3e8ff;
    color: #9333ea;
}

.icon-yellow {
    background: #fef3c7;
    color: #d97706;
}

.icon-green {
    background: #d1fae5;
    color: #059669;
}

.icon-orange {
    background: #ffedd5;
    color: #ea580c;
}

.icon-red {
    background: #fee2e2;
    color: #dc2626;
}

.icon-cyan {
    background: #cffafe;
    color: #0891b2;
}


/* =========================================================
   6.7 JUDUL SECTION AKSES CEPAT
   ========================================================= */

.section-heading {
    margin-bottom: 18px;
}

.section-heading h5 {
    font-size: 17px;
    font-weight: 750;
    margin: 0 0 6px;
}

.section-heading p {
    color: #8492a6;
    font-size: 12px;
    margin: 0;
}


/* =========================================================
   6.8 KARTU AKSES CEPAT
   ========================================================= */

.quick-access-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 30px;
}

.quick-card {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.quick-card:hover {
    transform: translateY(-3px);
    border-color: #bfdbfe;
    box-shadow: 0 8px 24px rgba(15, 35, 65, 0.05);
}

.quick-icon {
    width: 44px;
    height: 44px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.quick-content {
    flex: 1;
    min-width: 0;
}

.quick-content h6 {
    font-size: 12px;
    font-weight: 700;
    margin: 0 0 6px;
    color: #243247;
}

.quick-content p {
    font-size: 10px;
    color: #94a3b8;
    line-height: 1.5;
    margin: 0;
}

.quick-arrow {
    color: #94a3b8;
    font-size: 15px;
    flex-shrink: 0;
}


/* =========================================================
   6.9 KARTU RIWAYAT JURNAL
   ========================================================= */

.activity-card {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 4px 15px rgba(15, 35, 65, 0.025);
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 24px;
}

.section-eyebrow {
    display: block;
    color: #b08954;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1.3px;
    margin-bottom: 9px;
}

.activity-header h5 {
    font-size: 17px;
    font-weight: 750;
    margin: 0 0 7px;
}

.activity-header p {
    font-size: 12px;
    color: #8492a6;
    margin: 0;
}


/* =========================================================
   6.10 TOMBOL LIHAT SEMUA
   ========================================================= */

.view-all-btn {
    border: 1px solid #bfdbfe;
    color: #0284c7;
    background: #ffffff;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.view-all-btn:hover {
    background: #0284c7;
    color: #ffffff;
}


/* =========================================================
   6.11 TABEL RIWAYAT JURNAL
   ========================================================= */

.activity-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
}

.activity-table thead th {
    background: #f8fafc;
    color: #718096;
    padding: 14px 12px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
    border-bottom: 1px solid #e2e8f0;
}

.activity-table tbody td {
    padding: 12px;
    border-bottom: 1px solid #e8edf3;
    color: #475569;
    vertical-align: middle;
}

.activity-table tbody tr:last-child td {
    border-bottom: none;
}

.activity-table tbody tr:hover {
    background: #fbfdff;
}


/* =========================================================
   6.12 INFORMASI SISWA
   ========================================================= */

.student-info {
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}

.student-info span {
    font-weight: 600;
    color: #243247;
}

.student-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #2563eb;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}


/* =========================================================
   6.13 BADGE JAM JURNAL
   ========================================================= */

.time-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 6px 9px;
    white-space: nowrap;
    font-size: 10px;
    color: #475569;
}


/* =========================================================
   6.14 BADGE STATUS PENILAIAN
   ========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 6px;
    padding: 7px 10px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge span {
    width: 5px;
    height: 5px;
    border-radius: 50%;
}

.status-success {
    color: #059669;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
}

.status-success span {
    background: #10b981;
}

.status-pending {
    color: #d97706;
    background: #fffbeb;
    border: 1px solid #fde68a;
}

.status-pending span {
    background: #f59e0b;
}


/* =========================================================
   6.15 TOMBOL AKSI BERI NILAI
   ========================================================= */

.action-btn {
    display: inline-block;
    background: #ffffff;
    color: #475569;
    border: 1px solid #dbe3ed;
    border-radius: 7px;
    padding: 8px 13px;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.action-btn:hover {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
}


/* =========================================================
   6.16 TAMPILAN DATA KOSONG
   ========================================================= */

.empty-state {
    text-align: center;
    padding: 40px 20px !important;
    color: #94a3b8 !important;
}

.empty-state i {
    display: block;
    font-size: 30px;
    margin-bottom: 10px;
}

.empty-state p {
    margin: 0;
    font-size: 12px;
}


/* =========================================================
   6.17 RESPONSIVE TABLET
   ========================================================= */

@media (max-width: 1200px) {

    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .quick-access-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}


/* =========================================================
   6.18 RESPONSIVE MOBILE
   ========================================================= */

@media (max-width: 768px) {

    .timetrix-dashboard {
        padding: 16px;
    }

    .dashboard-heading {
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .dashboard-heading h4 {
        font-size: 16px;
    }

    .dashboard-user {
        font-size: 11px;
        gap: 8px;
    }

    .dashboard-avatar {
        width: 36px;
        height: 36px;
    }

    .welcome-banner {
        padding: 28px 22px;
        border-radius: 18px;
        flex-direction: column;
        align-items: stretch;
        gap: 25px;
    }

    .banner-content h1 {
        font-size: 28px;
    }

    .banner-content p {
        font-size: 12px;
    }

    .attendance-summary {
        width: 100%;
        min-width: 0;
    }

    .stats-grid {
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        padding: 17px 14px;
        border-radius: 14px;
    }

    .stat-info p {
        font-size: 10px;
    }

    .stat-info h3 {
        font-size: 23px;
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        font-size: 17px;
    }

    .quick-access-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .quick-card {
        padding: 15px;
    }

    .activity-card {
        padding: 18px;
        border-radius: 16px;
    }

    .activity-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .activity-header h5 {
        font-size: 15px;
    }

    .view-all-btn {
        align-self: flex-start;
    }

}


/* =========================================================
   6.19 RESPONSIVE HP KECIL
   ========================================================= */

@media (max-width: 400px) {

    .timetrix-dashboard {
        padding: 12px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 18px;
    }

    .banner-content h1 {
        font-size: 24px;
    }

    .dashboard-heading {
        gap: 10px;
    }

    .dashboard-user span {
        font-size: 10px;
    }

}


/* =========================================================
   6.20 PERBAIKAN RESPONSIVE RIWAYAT JURNAL

   Desktop:
   Tabel tetap tampil seperti desain awal.

   HP:
   Tabel bisa digeser ke kanan dan kiri.
   Kolom tidak dipaksa mengecil.
   Tulisan tidak bertumpuk.
   ========================================================= */

.jurnal-table-wrapper {
    display: block;
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}

.jurnal-table {
    width: 100%;
    min-width: 850px;
    max-width: none;
    table-layout: auto;
    border-collapse: collapse;
    margin-bottom: 0;
}

.jurnal-table th,
.jurnal-table td {
    white-space: nowrap !important;
    overflow-wrap: normal;
    word-break: normal;
    vertical-align: middle;
}

.jurnal-table th:first-child,
.jurnal-table td:first-child {
    min-width: 220px;
}

.jurnal-table th:nth-child(2),
.jurnal-table td:nth-child(2) {
    min-width: 170px;
}

.jurnal-table th:nth-child(3),
.jurnal-table td:nth-child(3) {
    min-width: 120px;
}

.jurnal-table th:nth-child(4),
.jurnal-table td:nth-child(4) {
    min-width: 150px;
}

.jurnal-table th:last-child,
.jurnal-table td:last-child {
    min-width: 100px;
}

.student-info {
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}

.student-info span {
    white-space: nowrap;
}

.student-avatar {
    flex: 0 0 34px;
}


/* RESPONSIVE TABEL HP */

@media (max-width: 768px) {

    .activity-card {
        width: 100%;
        min-width: 0;
        padding: 16px;
        overflow: hidden;
    }

    .activity-header {
        width: 100%;
        gap: 14px;
        margin-bottom: 18px;
    }

    .activity-header > div {
        min-width: 0;
    }

    .activity-header p {
        line-height: 1.5;
    }

    .jurnal-table-wrapper {
        width: 100%;
        margin: 0;
        padding-bottom: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .jurnal-table {
        min-width: 850px;
        width: 850px;
        table-layout: auto;
    }

    .jurnal-table th,
    .jurnal-table td {
        padding: 12px 10px;
        font-size: 12px;
    }

}


/* RESPONSIVE HP KECIL */

@media (max-width: 400px) {

    .activity-card {
        padding: 14px;
    }

    .jurnal-table {
        min-width: 850px;
        width: 850px;
    }

}

</style>

@endsection
