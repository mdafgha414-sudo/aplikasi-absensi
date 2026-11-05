
@extends('layouts.app')

@section('content')

{{-- =========================================================
    TIMETRIX - DASHBOARD PEMBIMBING
    File   : resources/views/dashboard/user_pembimbing.blade.php
    Fungsi : Halaman utama pembimbing PKL.

    BAGIAN HALAMAN:
    1. Header dashboard
    2. Banner sambutan dan ringkasan jurnal
    3. Statistik pembimbing
    4. Akses cepat fitur pembimbing
    5. Riwayat jurnal terbaru
    6. CSS dan responsive

    CATATAN:
    - Sidebar dan topbar berasal dari layouts.app.
    - Route Laravel tetap menggunakan route yang sudah ada.
    - Data statistik berasal dari controller.
    ========================================================= --}}


{{-- =========================================================
    1. CONTAINER UTAMA DASHBOARD
    Seluruh komponen dashboard pembimbing berada di sini.
    ========================================================= --}}
<div class="timetrix-dashboard">


    {{-- =====================================================
        1.1 HEADER DASHBOARD
        Menampilkan judul halaman, tanggal, dan avatar user.
        ===================================================== --}}
    <div class="dashboard-heading">

        {{-- Judul dan tanggal dashboard --}}
        <div>
            <h4>Dashboard Pembimbing</h4>

            <p>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        {{-- Informasi pembimbing yang sedang login --}}
        <div class="dashboard-user">

            <span>
                Halo, {{ Auth::user()->name }}
            </span>

            {{-- Avatar menggunakan foto profil jika tersedia --}}
            <div class="dashboard-avatar">

                @if(Auth::user()->foto_profil)
                    <img
                        src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                        alt="Foto Profil Pembimbing"
                    >
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                @endif

            </div>

        </div>

    </div>


    {{-- =====================================================
        2. WELCOME BANNER
        Menampilkan sambutan dan ringkasan penilaian jurnal.
        ===================================================== --}}
    <div class="welcome-banner">

        {{-- Bagian kiri: informasi sambutan pembimbing --}}
        <div class="banner-content">

            {{-- Label identitas dashboard --}}
            <div class="banner-label">
                <span class="banner-dot"></span>
                RUANG KERJA PEMBIMBING
            </div>

            {{-- Nama pembimbing diambil dari user yang login --}}
            <h1>
                Selamat Datang,<br>
                {{ Auth::user()->name }}
            </h1>

            {{-- Deskripsi singkat dashboard --}}
            <p>
                Semua aktivitas siswa bimbingan Anda tersusun
                rapi dalam satu ruang kerja yang sederhana.
            </p>

        </div>


        {{-- Bagian kanan: ringkasan jurnal --}}
        <div class="attendance-summary">

            <div class="summary-label">
                RINGKASAN JURNAL
            </div>

            {{-- 
                Menghitung persentase jurnal yang sudah dinilai.
                Jika total jurnal kosong, persentase menjadi 0%.
            --}}
            @php
                $persentaseJurnal = ($totalJurnal ?? 0) > 0
                    ? round(
                        (($jurnalSudahDinilai ?? 0) / $totalJurnal) * 100
                    )
                    : 0;
            @endphp

            {{-- Angka persentase jurnal --}}
            <div class="summary-number">
                {{ $persentaseJurnal }}%
            </div>

            <div class="summary-description">
                Jurnal telah dinilai
            </div>

            {{-- Progress bar mengikuti persentase penilaian --}}
            <div
                class="summary-progress"
                role="progressbar"
                aria-valuenow="{{ $persentaseJurnal }}"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-label="Persentase jurnal yang sudah dinilai"
            >
                <div style="width: {{ $persentaseJurnal }}%"></div>
            </div>

            {{-- Jumlah jurnal selesai dan menunggu --}}
            <div class="summary-footer">
                <span>{{ $jurnalSudahDinilai ?? 0 }} selesai</span>
                <span>{{ $jurnalBelumDinilai ?? 0 }} menunggu</span>
            </div>

        </div>

    </div>


    {{-- =====================================================
        3. STATISTIK PEMBIMBING
        Menampilkan jumlah siswa dan jurnal.
        ===================================================== --}}
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


        {{-- Statistik jurnal yang belum dinilai --}}
        <div class="stat-card">

            <div class="stat-info">
                <p>Belum Dinilai</p>
                <h3>{{ $jurnalBelumDinilai ?? 0 }}</h3>
            </div>

            <div class="stat-icon icon-yellow">
                <i class="bi bi-file-earmark-text"></i>
            </div>

        </div>


        {{-- Statistik jurnal yang sudah dinilai --}}
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


    {{-- =====================================================
        4. AKSES CEPAT
        Shortcut menuju fitur utama pembimbing.

        Catatan:
        Semua route menggunakan route yang sudah tersedia
        pada aplikasi Laravel.
        ===================================================== --}}

    {{-- Judul section akses cepat --}}
    <div class="section-heading">

        <div>
            <h5>Akses Cepat</h5>
            <p>Pilih menu untuk mengelola aktivitas siswa</p>
        </div>

    </div>


    {{-- Grid seluruh shortcut pembimbing --}}
    <div class="quick-access-grid">


        {{-- -----------------------------------------------
            4.1 NILAI JURNAL SISWA
            Menu untuk memeriksa dan menilai jurnal siswa.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.2 LAPORAN ABSENSI
            Menu untuk melihat rekap kehadiran siswa.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.3 SCAN KARTU SISWA
            Menu untuk scan QR Code kartu siswa.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.4 BUAT KODE QR
            Menu untuk membuat dan mencetak kartu QR.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.5 DAFTAR IZIN SISWA
            Menu untuk memeriksa pengajuan izin siswa.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.6 ALASAN KETERLAMBATAN
            Menu untuk mengelola alasan keterlambatan.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.7 MANAJEMEN SISWA
            Menu tambahan untuk mengelola data siswa.
            ----------------------------------------------- --}}
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


        {{-- -----------------------------------------------
            4.8 MANAJEMEN SEKOLAH
            Menu tambahan untuk mengelola sekolah asal siswa.
            ----------------------------------------------- --}}
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


    {{-- =====================================================
        5. RIWAYAT JURNAL TERBARU
        Menampilkan jurnal terakhir yang diisi siswa.

        Variabel:
        $jurnalTerbaru = koleksi jurnal dari controller.
        ===================================================== --}}
    <div class="activity-card">


        {{-- -----------------------------------------------
            5.1 HEADER RIWAYAT JURNAL
            Judul dan tombol menuju seluruh jurnal.
            ----------------------------------------------- --}}
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

            {{-- Tombol menuju halaman seluruh jurnal --}}
            <a href="{{ url('/pembimbing/jurnal') }}" class="view-all-btn">
                Lihat Semua
                <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>


        {{-- -----------------------------------------------
            5.2 TABEL RIWAYAT JURNAL
            table-responsive menjaga tabel tetap nyaman
            digunakan pada layar HP.
            ----------------------------------------------- --}}
        <div class="table-responsive">

            <table class="activity-table">

                {{-- Header kolom tabel --}}
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Tanggal Jurnal</th>
                        <th>Jam Diisi</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>


                {{-- Isi tabel --}}
                <tbody>

                    {{-- Mengulang jurnal terbaru dari controller --}}
                    @forelse(($jurnalTerbaru ?? []) as $jurnal)

                        <tr>

                            {{-- Nama siswa dan avatar --}}
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


                            {{-- Tanggal jurnal --}}
                            <td>
                                {{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}
                            </td>


                            {{-- Jam jurnal dibuat --}}
                            <td>
                                <span class="time-badge">
                                    <i class="bi bi-clock"></i>

                                    {{ $jurnal->created_at
                                        ? $jurnal->created_at->format('H:i')
                                        : '-' }} WIB
                                </span>
                            </td>


                            {{-- Status jurnal berdasarkan nilai --}}
                            <td>

                                @if($jurnal->nilai !== null)

                                    {{-- Status jika jurnal sudah dinilai --}}
                                    <span class="status-badge status-success">
                                        <span></span>
                                        Sudah Dinilai
                                    </span>

                                @else

                                    {{-- Status jika jurnal belum dinilai --}}
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

                        {{-- Tampilan jika belum ada jurnal --}}
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


{{-- =========================================================
    6. CSS DASHBOARD PEMBIMBING
    Semua styling halaman diletakkan di sini agar developer
    lain mudah menemukan dan mengedit desain dashboard.
    ========================================================= --}}
<style>


/* =========================================================
   6.1 VARIABEL WARNA DAN DASAR DASHBOARD
   Mengatur warna utama, background, dan font.
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
   Mengatur judul, tanggal, dan informasi pembimbing.
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

/* Judul halaman dashboard */
.dashboard-heading h4 {
    font-size: 19px;
    font-weight: 700;

    margin: 0 0 5px;
}

/* Tanggal dashboard */
.dashboard-heading p {
    font-size: 12px;
    color: #94a3b8;

    margin: 0;
}

/* Informasi user di kanan header */
.dashboard-user {
    display: flex;
    align-items: center;
    gap: 12px;

    color: #475569;
    font-size: 14px;
    font-weight: 600;
}

/* Avatar pembimbing */
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

/* Foto profil pembimbing */
.dashboard-avatar img {
    width: 100%;
    height: 100%;

    object-fit: cover;
}


/* =========================================================
   6.3 WELCOME BANNER
   Banner sambutan dengan warna navy.
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

/* Dekorasi lingkaran pada background banner */
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


/* =========================================================
   6.4 RINGKASAN JURNAL
   Mengatur kartu persentase penilaian jurnal.
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

/* Label ringkasan jurnal */
.summary-label {
    font-size: 10px;
    font-weight: 700;

    color: #9fb4ce;
    letter-spacing: 1px;

    margin-bottom: 16px;
}

/* Angka persentase */
.summary-number {
    font-size: 36px;
    font-weight: 800;

    color: white;
    line-height: 1;

    margin-bottom: 10px;
}

/* Deskripsi persentase */
.summary-description {
    font-size: 11px;
    color: #bdcde0;

    margin-bottom: 16px;
}

/* Background progress bar */
.summary-progress {
    width: 100%;
    height: 6px;

    background: rgba(255, 255, 255, 0.12);

    border-radius: 10px;
    overflow: hidden;
}

/* Progress jurnal yang telah dinilai */
.summary-progress div {
    height: 100%;

    background: #facc15;
    border-radius: 10px;

    transition: width 0.4s ease;
}

/* Jumlah jurnal selesai dan menunggu */
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
   Mengatur empat kartu statistik pada desktop.
   ========================================================= */

.stats-grid {
    display: grid;

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

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

/* Efek hover statistik */
.stat-card:hover {
    transform: translateY(-3px);

    box-shadow: 0 8px 24px rgba(15, 35, 65, 0.06);
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


/* =========================================================
   6.6 WARNA IKON
   Digunakan oleh statistik dan kartu akses cepat.
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


/* =========================================================
   6.8 KARTU AKSES CEPAT
   Mengatur delapan shortcut fitur pembimbing.
   ========================================================= */

.quick-access-grid {
    display: grid;

    grid-template-columns: repeat(3, minmax(0, 1fr));

    gap: 14px;
    margin-bottom: 30px;
}

/* Kartu shortcut */
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

/* Efek hover shortcut */
.quick-card:hover {
    transform: translateY(-3px);

    border-color: #bfdbfe;

    box-shadow: 0 8px 24px rgba(15, 35, 65, 0.05);
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

/* Header tabel dan tombol lihat semua */
.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 15px;
    margin-bottom: 24px;
}

/* Label aktivitas terbaru */
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

/* Efek hover tombol */
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

/* Efek hover baris jurnal */
.activity-table tbody tr:hover {
    background: #fbfdff;
}


/* =========================================================
   6.12 INFORMASI SISWA
   ========================================================= */

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

/* Avatar siswa */
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

/* Tampilan dasar badge status */
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

/* Titik status berhasil */
.status-success span {
    background: #10b981;
}

/* Status jurnal belum dinilai */
.status-pending {
    color: #d97706;

    background: #fffbeb;
    border: 1px solid #fde68a;
}

/* Titik status menunggu */
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

/* Efek hover tombol beri nilai */
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


/* =========================================================
   6.17 RESPONSIVE TABLET
   Mengubah jumlah kolom statistik dan shortcut.
   ========================================================= */

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


/* =========================================================
   6.18 RESPONSIVE MOBILE
   Mengatur tampilan dashboard pada layar HP.
   ========================================================= */

@media (max-width: 768px) {

    /* Padding dashboard lebih kecil */
    .timetrix-dashboard {
        padding: 16px;
    }

    /* Header dashboard */
    .dashboard-heading {
        padding: 16px;

        border-radius: 14px;
        margin-bottom: 20px;
    }

    /* Judul dashboard */
    .dashboard-heading h4 {
        font-size: 16px;
    }

    /* Informasi user */
    .dashboard-user {
        font-size: 11px;
        gap: 8px;
    }

    /* Avatar user */
    .dashboard-avatar {
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

    /* Label statistik mobile */
    .stat-info p {
        font-size: 10px;
    }

    /* Angka statistik mobile */
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

    /* Judul aktivitas mobile */
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


/* =========================================================
   6.19 RESPONSIVE HP KECIL
   Mengatur tampilan layar dengan lebar maksimal 400px.
   ========================================================= */

@media (max-width: 400px) {

    /* Padding lebih kecil pada layar sempit */
    .timetrix-dashboard {
        padding: 12px;
    }

    /* Statistik menjadi satu kolom */
    .stats-grid {
        grid-template-columns: 1fr;
    }

    /* Kartu statistik */
    .stat-card {
        padding: 18px;
    }

    /* Judul sambutan */
    .banner-content h1 {
        font-size: 24px;
    }

    /* Header menyesuaikan layar */
    .dashboard-heading {
        gap: 10px;
    }

    /* Informasi user tidak terlalu lebar */
    .dashboard-user span {
        font-size: 10px;
    }

}

</style>

@endsection
