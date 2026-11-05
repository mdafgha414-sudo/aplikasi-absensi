
@extends('layouts.app')

@section('content')

{{-- =====================================================
    TIMETRIX - DASHBOARD PEMBIMBING
    File     : resources/views/dashboard/user_pembimbing.blade.php
    Fungsi   : Menampilkan ringkasan aktivitas pembimbing,
               statistik jurnal, akses cepat, dan jurnal terbaru.
    Catatan  : Route dan variabel Laravel dipertahankan.
    ===================================================== --}}

<div class="timetrix-dashboard">

    {{-- =================================================
        1. WELCOME BANNER
        Menampilkan sambutan dan ringkasan penilaian jurnal.
        ================================================= --}}
    <div class="welcome-banner">

        {{-- Bagian kiri: sambutan pembimbing --}}
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
                Semua aktivitas siswa bimbingan Anda tersusun rapi
                dalam satu ruang kerja yang sederhana.
            </p>

        </div>


        {{-- Bagian kanan: ringkasan jurnal yang telah dinilai --}}
        <div class="attendance-summary">

            <div class="summary-label">
                RINGKASAN JURNAL
            </div>

            {{-- 
                Menghitung persentase jurnal yang sudah dinilai.
                Jika total jurnal 0, persentase ditampilkan sebagai 0%.
            --}}
            <div class="summary-number">
                {{ $totalJurnal > 0
                    ? round(($jurnalSudahDinilai / $totalJurnal) * 100)
                    : 0 }}%
            </div>

            <div class="summary-description">
                Jurnal telah dinilai
            </div>

            {{-- Progress bar mengikuti persentase penilaian --}}
            <div class="summary-progress">
                <div style="width: {{ $totalJurnal > 0
                    ? round(($jurnalSudahDinilai / $totalJurnal) * 100)
                    : 0 }}%">
                </div>
            </div>

            {{-- Jumlah jurnal selesai dan menunggu penilaian --}}
            <div class="summary-footer">
                <span>{{ $jurnalSudahDinilai ?? 0 }} selesai</span>
                <span>{{ $jurnalBelumDinilai ?? 0 }} menunggu</span>
            </div>

        </div>
    </div>


    {{-- =================================================
        2. STATISTIK PEMBIMBING
        Menampilkan jumlah siswa dan jurnal berdasarkan status.
        ================================================= --}}
    <div class="stats-grid">

        {{-- Statistik total siswa PKL --}}
        <div class="stat-card">
            <div class="stat-info">
                <p>Total Siswa PKL</p>
                <h3>{{ $totalSiswa ?? 0 }}</h3>
            </div>

            <div class="stat-icon icon-blue">
                <i class="bi bi-people"></i>
            </div>
        </div>


        {{-- Statistik seluruh jurnal siswa --}}
        <div class="stat-card">
            <div class="stat-info">
                <p>Total Jurnal</p>
                <h3>{{ $totalJurnal ?? 0 }}</h3>
            </div>

            <div class="stat-icon icon-purple">
                <i class="bi bi-journal-text"></i>
            </div>
        </div>


        {{-- Statistik jurnal yang belum mendapatkan nilai --}}
        <div class="stat-card">
            <div class="stat-info">
                <p>Belum Dinilai</p>
                <h3>{{ $jurnalBelumDinilai ?? 0 }}</h3>
            </div>

            <div class="stat-icon icon-yellow">
                <i class="bi bi-file-earmark-text"></i>
            </div>
        </div>


        {{-- Statistik jurnal yang sudah mendapatkan nilai --}}
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


    {{-- =================================================
        3. AKSES CEPAT
        Shortcut menuju fitur utama pembimbing.
        URL dan route tetap menggunakan sistem Laravel.
        ================================================= --}}
    <div class="section-heading">

        <div>
            <h5>Akses Cepat</h5>
            <p>Pilih menu untuk mengelola aktivitas siswa</p>
        </div>

    </div>


    <div class="quick-access-grid">

        {{-- Shortcut menuju halaman penilaian jurnal --}}
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


        {{-- Shortcut menuju laporan absensi --}}
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


        {{-- Shortcut menuju fitur scan kartu siswa --}}
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


        {{-- Shortcut menuju fitur pembuatan QR siswa --}}
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


        {{-- Shortcut menuju daftar pengajuan izin --}}
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


        {{-- Shortcut menuju pengelolaan alasan keterlambatan --}}
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

    </div>


    {{-- =================================================
        4. RIWAYAT JURNAL TERBARU
        Menampilkan jurnal terbaru beserta status penilaiannya.
        Data diambil dari variabel $jurnalTerbaru.
        ================================================= --}}
    <div class="activity-card">

        {{-- Header tabel dan tombol menuju seluruh jurnal --}}
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

            {{-- Tombol melihat seluruh jurnal --}}
            <a href="{{ url('/pembimbing/jurnal') }}" class="view-all-btn">
                Lihat Semua
                <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>


        {{-- 
            table-responsive menjaga tabel tetap bisa digeser
            secara horizontal pada layar HP.
        --}}
        <div class="table-responsive">

            <table class="activity-table">

                {{-- Judul setiap kolom tabel --}}
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

                    {{-- Mengulang data jurnal terbaru dari controller --}}
                    @forelse($jurnalTerbaru as $jurnal)

                        <tr>

                            {{-- Nama dan avatar siswa --}}
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


                            {{-- Tanggal jurnal dengan format Indonesia --}}
                            <td>
                                {{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}
                            </td>


                            {{-- Jam jurnal dibuat --}}
                            <td>
                                <span class="time-badge">
                                    <i class="bi bi-clock"></i>
                                    {{ $jurnal->created_at->format('H:i') }} WIB
                                </span>
                            </td>


                            {{-- Status penilaian berdasarkan nilai jurnal --}}
                            <td>

                                @if($jurnal->nilai !== null)

                                    {{-- Jurnal sudah dinilai --}}
                                    <span class="status-badge status-success">
                                        <span></span>
                                        Sudah Dinilai
                                    </span>

                                @else

                                    {{-- Jurnal masih menunggu penilaian --}}
                                    <span class="status-badge status-pending">
                                        <span></span>
                                        Belum Dinilai
                                    </span>

                                @endif

                            </td>


                            {{-- Tombol menuju halaman penilaian jurnal --}}
                            <td class="text-end">

                                <a href="{{ url('/pembimbing/jurnal') }}" class="action-btn">
                                    Beri Nilai
                                </a>

                            </td>

                        </tr>

                    @empty

                        {{-- Tampilan ketika belum ada jurnal siswa --}}
                        <tr>
                            <td colspan="5" class="empty-state">

                                <i class="bi bi-inbox"></i>

                                <p>
                                    Belum ada jurnal yang diisi oleh siswa.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =====================================================
    5. CSS DASHBOARD PEMBIMBING
    Semua styling halaman ini diletakkan di sini agar
    mudah ditemukan dan diedit oleh developer lain.
    ===================================================== --}}
<style>

/* =========================================
   5.1 VARIABEL WARNA DAN DASAR DASHBOARD
   ========================================= */

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


/* =========================================
   5.2 HEADER DASHBOARD
   ========================================= */

.dashboard-topbar {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 18px;
    padding: 20px 24px;
    margin-bottom: 28px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    box-shadow: 0 4px 15px rgba(15, 35, 65, 0.025);
}

/* Judul halaman */
.dashboard-topbar h4 {
    font-size: 19px;
    font-weight: 700;
    margin: 0 0 4px;
}

/* Tanggal di bawah judul */
.dashboard-topbar p {
    font-size: 12px;
    color: #94a3b8;
    margin: 0;
}

/* Informasi pengguna di sisi kanan */
.topbar-user {
    display: flex;
    align-items: center;
    gap: 12px;

    color: #475569;
    font-size: 14px;
    font-weight: 500;
}

/* Avatar pembimbing */
.user-avatar {
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
}


/* =========================================
   5.3 WELCOME BANNER
   Banner sambutan dengan warna navy.
   ========================================= */

.welcome-banner {
    background: linear-gradient(120deg, #142f52 0%, #193b64 100%);
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

/* Dekorasi lingkaran pada latar banner */
.welcome-banner::before {
    content: "";

    position: absolute;
    width: 480px;
    height: 480px;
    right: 5%;
    top: -250px;

    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 50%;

    box-shadow:
        0 0 0 35px rgba(255,255,255,0.025),
        0 0 0 70px rgba(255,255,255,0.02),
        0 0 0 105px rgba(255,255,255,0.015);

    pointer-events: none;
}

/* Konten sambutan berada di atas dekorasi */
.banner-content {
    position: relative;
    z-index: 1;
    max-width: 620px;
}

/* Label ruang kerja pembimbing */
.banner-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;

    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.14);

    color: #e2eaf5;
    border-radius: 30px;
    padding: 9px 15px;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.6px;

    margin-bottom: 24px;
}

/* Titik kuning pada label */
.banner-dot {
    width: 7px;
    height: 7px;

    background: #facc15;
    border-radius: 50%;
}

/* Judul sambutan */
.banner-content h1 {
    font-family: Georgia, serif;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 700;

    color: #ffffff;
    line-height: 1.3;

    margin: 0 0 16px;
}

/* Deskripsi sambutan */
.banner-content p {
    color: #b7c8dc;
    font-size: 14px;
    line-height: 1.8;

    margin: 0;
    max-width: 520px;
}


/* =========================================
   5.4 RINGKASAN JURNAL
   ========================================= */

.attendance-summary {
    position: relative;
    z-index: 1;

    width: 225px;
    min-width: 225px;

    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);

    border-radius: 18px;
    padding: 22px;
}

/* Label ringkasan */
.summary-label {
    font-size: 10px;
    font-weight: 700;
    color: #9fb4ce;
    letter-spacing: 1px;

    margin-bottom: 16px;
}

/* Persentase jurnal yang sudah dinilai */
.summary-number {
    font-size: 36px;
    font-weight: 800;
    color: white;
    line-height: 1;

    margin-bottom: 10px;
}

/* Keterangan persentase */
.summary-description {
    font-size: 11px;
    color: #bdcde0;

    margin-bottom: 16px;
}

/* Latar progress bar */
.summary-progress {
    width: 100%;
    height: 6px;

    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    overflow: hidden;
}

/* Bagian progress yang sudah selesai */
.summary-progress div {
    height: 100%;
    background: #facc15;
    border-radius: 10px;

    transition: width 0.4s ease;
}

/* Informasi jumlah jurnal */
.summary-footer {
    display: flex;
    justify-content: space-between;
    gap: 8px;

    margin-top: 12px;

    color: #b7c8dc;
    font-size: 9px;
}


/* =========================================
   5.5 GRID STATISTIK
   ========================================= */

.stats-grid {
    display: grid;

    /* Empat kartu statistik pada desktop */
    grid-template-columns: repeat(4, minmax(0, 1fr));

    gap: 18px;
    margin-bottom: 30px;
}

/* Kartu statistik */
.stat-card {
    background: #ffffff;
    border: 1px solid #e4eaf1;
    border-radius: 18px;
    padding: 25px 24px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;

    transition: transform .2s ease,
                box-shadow .2s ease;
}

/* Efek hover kartu */
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15,35,65,0.06);
}

/* Label statistik */
.stat-info p {
    font-size: 12px;
    color: #64748b;

    margin: 0 0 10px;
}

/* Angka statistik */
.stat-info h3 {
    font-size: 27px;
    font-weight: 800;
    color: #111827;

    margin: 0;
}

/* Kotak ikon statistik */
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


/* =========================================
   5.6 WARNA IKON
   Warna digunakan pada statistik dan akses cepat.
   ========================================= */

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


/* =========================================
   5.7 JUDUL SECTION AKSES CEPAT
   ========================================= */

.section-heading {
    margin-bottom: 18px;
}

/* Judul section */
.section-heading h5 {
    font-size: 17px;
    font-weight: 750;

    margin: 0 0 6px;
}

/* Deskripsi section */
.section-heading p {
    color: #8492a6;
    font-size: 12px;

    margin: 0;
}


/* =========================================
   5.8 KARTU AKSES CEPAT
   ========================================= */

.quick-access-grid {
    display: grid;

    /* Tiga kartu dalam satu baris desktop */
    grid-template-columns: repeat(3, minmax(0, 1fr));

    gap: 14px;
    margin-bottom: 30px;
}

/* Kartu shortcut */
.quick-card {
    background: white;
    border: 1px solid #e4eaf1;
    border-radius: 16px;
    padding: 20px;

    display: flex;
    align-items: center;
    gap: 14px;

    text-decoration: none;
    color: inherit;

    transition: all .2s ease;
}

/* Efek hover kartu shortcut */
.quick-card:hover {
    transform: translateY(-3px);
    border-color: #bfdbfe;

    box-shadow: 0 8px 24px rgba(15,35,65,0.05);
}

/* Kotak ikon shortcut */
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

/* Konten shortcut */
.quick-content {
    flex: 1;
    min-width: 0;
}

/* Judul shortcut */
.quick-content h6 {
    font-size: 12px;
    font-weight: 700;

    margin: 0 0 6px;
    color: #243247;
}

/* Deskripsi shortcut */
.quick-content p {
    font-size: 10px;
    color: #94a3b8;
    line-height: 1.5;

    margin: 0;
}

/* Ikon panah shortcut */
.quick-arrow {
    color: #94a3b8;
    font-size: 15px;
}


/* =========================================
   5.9 KARTU RIWAYAT JURNAL
   ========================================= */

.activity-card {
    background: white;
    border: 1px solid #e4eaf1;
    border-radius: 20px;
    padding: 28px;

    box-shadow: 0 4px 15px rgba(15,35,65,0.025);
}

/* Header tabel dan tombol lihat semua */
.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;

    margin-bottom: 24px;
}

/* Label kecil aktivitas terbaru */
.section-eyebrow {
    display: block;

    color: #b08954;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1.3px;

    margin-bottom: 9px;
}

/* Judul tabel */
.activity-header h5 {
    font-size: 17px;
    font-weight: 750;

    margin: 0 0 7px;
}

/* Deskripsi tabel */
.activity-header p {
    font-size: 12px;
    color: #8492a6;

    margin: 0;
}


/* =========================================
   5.10 TOMBOL LIHAT SEMUA
   ========================================= */

.view-all-btn {
    border: 1px solid #bfdbfe;
    color: #0284c7;
    background: white;

    text-decoration: none;

    padding: 10px 16px;
    border-radius: 30px;

    font-size: 11px;
    font-weight: 600;

    display: inline-flex;
    align-items: center;
    gap: 8px;

    white-space: nowrap;

    transition: all .2s ease;
}

/* Efek hover tombol */
.view-all-btn:hover {
    background: #0284c7;
    color: white;
}


/* =========================================
   5.11 TABEL RIWAYAT JURNAL
   ========================================= */

.activity-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;

    font-size: 12px;
}

/* Header tabel */
.activity-table thead th {
    background: #f8fafc;
    color: #718096;

    padding: 14px 12px;

    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;

    border-bottom: 1px solid #e2e8f0;
}

/* Isi tabel */
.activity-table tbody td {
    padding: 12px;

    border-bottom: 1px solid #e8edf3;
    color: #475569;

    vertical-align: middle;
}

/* Menghilangkan garis pada baris terakhir */
.activity-table tbody tr:last-child td {
    border-bottom: none;
}

/* Efek hover pada baris jurnal */
.activity-table tbody tr:hover {
    background: #fbfdff;
}


/* =========================================
   5.12 INFORMASI SISWA
   ========================================= */

/* Nama siswa dan avatar */
.student-info {
    display: flex;
    align-items: center;
    gap: 10px;

    white-space: nowrap;
}

/* Nama siswa */
.student-info span {
    font-weight: 600;
    color: #243247;
}

/* Avatar siswa pada tabel */
.student-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;

    background: #2563eb;
    color: white;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 11px;
    font-weight: 700;

    flex-shrink: 0;
}


/* =========================================
   5.13 BADGE JAM JURNAL
   ========================================= */

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


/* =========================================
   5.14 BADGE STATUS PENILAIAN
   ========================================= */

/* Tampilan dasar semua status */
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

/* Titik indikator status */
.status-badge span {
    width: 5px;
    height: 5px;
    border-radius: 50%;
}

/* Status jurnal sudah dinilai */
.status-success {
    color: #059669;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
}

.status-success span {
    background: #10b981;
}

/* Status jurnal belum dinilai */
.status-pending {
    color: #d97706;
    background: #fffbeb;
    border: 1px solid #fde68a;
}

.status-pending span {
    background: #f59e0b;
}


/* =========================================
   5.15 TOMBOL AKSI BERIKAN NILAI
   ========================================= */

.action-btn {
    display: inline-block;

    background: white;
    color: #475569;

    border: 1px solid #dbe3ed;
    border-radius: 7px;

    padding: 8px 13px;

    font-size: 10px;
    font-weight: 600;

    text-decoration: none;
    white-space: nowrap;

    transition: all .2s ease;
}

/* Efek hover tombol beri nilai */
.action-btn:hover {
    background: #0284c7;
    border-color: #0284c7;
    color: white;
}


/* =========================================
   5.16 TAMPILAN KETIKA DATA KOSONG
   ========================================= */

.empty-state {
    text-align: center;
    padding: 40px 20px !important;

    color: #94a3b8 !important;
}

/* Ikon informasi data kosong */
.empty-state i {
    display: block;
    font-size: 30px;

    margin-bottom: 10px;
}

/* Pesan data kosong */
.empty-state p {
    margin: 0;
    font-size: 12px;
}


/* =========================================
   5.17 RESPONSIVE TABLET
   Mengubah jumlah kolom statistik dan shortcut.
   ========================================= */

@media (max-width: 1200px) {

    /* Statistik menjadi dua kolom */
    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    /* Shortcut menjadi dua kolom */
    .quick-access-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}


/* =========================================
   5.18 RESPONSIVE MOBILE
   Mengatur tampilan dashboard pada HP.
   ========================================= */

@media (max-width: 768px) {

    /* Padding dashboard lebih kecil */
    .timetrix-dashboard {
        padding: 16px;
    }

    /* Header dashboard */
    .dashboard-topbar {
        padding: 16px;
        border-radius: 14px;
        margin-bottom: 20px;
    }

    .dashboard-topbar h4 {
        font-size: 16px;
    }

    /* Informasi pengguna */
    .topbar-user {
        font-size: 11px;
        gap: 8px;
    }

    /* Avatar lebih kecil */
    .user-avatar {
        width: 36px;
        height: 36px;
    }

    /* Banner sambutan menjadi vertikal */
    .welcome-banner {
        padding: 28px 22px;
        border-radius: 18px;

        flex-direction: column;
        align-items: stretch;
        gap: 25px;
    }

    /* Judul sambutan mobile */
    .banner-content h1 {
        font-size: 28px;
    }

    /* Deskripsi sambutan mobile */
    .banner-content p {
        font-size: 12px;
    }

    /* Ringkasan jurnal memenuhi lebar banner */
    .attendance-summary {
        width: 100%;
        min-width: 0;
    }

    /* Jarak antar statistik */
    .stats-grid {
        gap: 12px;
        margin-bottom: 24px;
    }

    /* Kartu statistik mobile */
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

    /* Ikon statistik mobile */
    .stat-icon {
        width: 38px;
        height: 38px;
        font-size: 17px;
    }

    /* Shortcut menjadi satu kolom */
    .quick-access-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    /* Kartu shortcut mobile */
    .quick-card {
        padding: 15px;
    }

    /* Kartu aktivitas mobile */
    .activity-card {
        padding: 18px;
        border-radius: 16px;
    }

    /* Header aktivitas menjadi vertikal */
    .activity-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .activity-header h5 {
        font-size: 15px;
    }

    /* Tombol lihat semua berada di kiri */
    .view-all-btn {
        align-self: flex-start;
    }

    /* Tabel dapat digeser horizontal */
    .activity-table {
        min-width: 650px;
    }
}


/* =========================================
   5.19 RESPONSIVE HP KECIL
   ========================================= */

@media (max-width: 400px) {

    /* Padding lebih kecil pada layar sempit */
    .timetrix-dashboard {
        padding: 12px;
    }

    /* Statistik menjadi satu kolom */
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 18px;
    }

    /* Judul sambutan menyesuaikan layar */
    .banner-content h1 {
        font-size: 24px;
    }
}

</style>

@endsection
