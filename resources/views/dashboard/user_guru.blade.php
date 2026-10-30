@extends('layouts.app')

@section('content')
<div class="dashboard-wrapper py-4 px-3 px-lg-5">
    
    <!-- 1. Header Banner Welcome -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Banner Biru Muda -->
            <div class="welcome-banner p-4 p-lg-5 rounded-4 position-relative overflow-hidden shadow-sm">
                <div class="banner-overlay"></div>
                <div class="row align-items-center position-relative z-2">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <!-- Badge -->
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white text-primary fw-medium small mb-3">
                            <span class="status-pulse"></span> Teacher Workspace
                        </div>
                        <!-- Judul & Teks -->
                        <h2 class="fw-bold fs-2 text-dark mb-2 tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }} 
                        </h2>
                        <p class="text-secondary mb-0 fs-6 leading-relaxed">
                            Kelola jurnal harian, beri penilaian aktivitas, dan setujui pengajuan izin siswa bimbingan PKL Anda dalam satu tempat.
                        </p>
                    </div>
                    
                    <!-- Kotak Status Kanan -->
                    <div class="col-lg-4 text-lg-end">
                        <div class="bg-white bg-opacity-50 rounded-4 p-3 d-inline-block text-center text-lg-start border border-white">
                            <div class="small text-secondary fw-medium mb-1">Status Akun</div>
                            <div class="fw-bold fs-6 text-primary"><i class="bi bi-shield-check me-1"></i> Guru</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Ringkasan Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card p-3 rounded-4 bg-white border border-slate-200 shadow-sm d-flex align-items-center gap-3">
                <div class="stat-icon rounded-3 bg-primary-subtle text-primary p-3">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <div>
                    <span class="text-secondary small fw-medium d-block">Siswa Bimbingan</span>
                    <h4 class="fw-bold mb-0 text-dark">Aktif PKL</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card p-3 rounded-4 bg-white border border-slate-200 shadow-sm d-flex align-items-center gap-3">
                <div class="stat-icon rounded-3 bg-warning-subtle text-warning p-3">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
                <div>
                    <span class="text-secondary small fw-medium d-block">Jurnal Aktivitas</span>
                    <h4 class="fw-bold mb-0 text-dark">Periksa Harian</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="stat-card p-3 rounded-4 bg-white border border-slate-200 shadow-sm d-flex align-items-center gap-3">
                <div class="stat-icon rounded-3 bg-info-subtle text-info p-3">
                    <i class="bi bi-envelope-paper-fill fs-4"></i>
                </div>
                <div>
                    <span class="text-secondary small fw-medium d-block">Perizinan Siswa</span>
                    <h4 class="fw-bold mb-0 text-dark">Validasi Surat</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Section Menu Utama Navigasi -->
    <div class="row">
        <div class="col-12 mb-3">
            <h5 class="fw-bold text-dark mb-1">Menu Utama Navigasi</h5>
            <p class="text-secondary small mb-0">Pilih salah satu tindakan di bawah untuk mulai mengelola siswa bimbingan</p>
        </div>

        <div class="col-12">
            <div class="row g-4">

                <!-- Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url('/guru/jurnal') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card position-relative overflow-hidden">
                            <div class="card-accent-line bg-indigo"></div>
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="action-icon-wrapper rounded-3 bg-indigo text-white d-flex align-items-center justify-content-center shadow-indigo">
                                        <i class="bi bi-journal-check fs-3"></i>
                                    </div>
                                    <span class="arrow-badge rounded-circle bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-right text-dark fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2 card-title-hover">Lihat Jurnal Siswa</h5>
                                    <p class="text-secondary small mb-0 leading-relaxed">
                                        Periksa catatan aktivitas harian siswa PKL, berikan ulasan, dan input nilai secara langsung.
                                    </p>
                                </div>
                                <div class="pt-2 border-top border-light d-flex align-items-center justify-content-between text-indigo fw-semibold small">
                                    <span>Buka Menu Jurnal</span>
                                    <i class="bi bi-chevron-right fs-7"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url('/guru/laporan-absensi') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card position-relative overflow-hidden">
                            <div class="card-accent-line bg-teal"></div>
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="action-icon-wrapper rounded-3 bg-teal text-white d-flex align-items-center justify-content-center shadow-teal">
                                        <i class="bi bi-calendar-check fs-3"></i>
                                    </div>
                                    <span class="arrow-badge rounded-circle bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-right text-dark fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2 card-title-hover">Laporan Absensi</h5>
                                    <p class="text-secondary small mb-0 leading-relaxed">
                                        Pantau rekapitulasi kehadiran harian, ketidakhadiran, dan status akumulasi siswa.
                                    </p>
                                </div>
                                <div class="pt-2 border-top border-light d-flex align-items-center justify-content-between text-teal fw-semibold small">
                                    <span>Cek Rekap Absensi</span>
                                    <i class="bi bi-chevron-right fs-7"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ url('/guru/izin') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card position-relative overflow-hidden">
                            <div class="card-accent-line bg-amber"></div>
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="action-icon-wrapper rounded-3 bg-amber text-white d-flex align-items-center justify-content-center shadow-amber">
                                        <i class="bi bi-envelope-paper fs-3"></i>
                                    </div>
                                    <span class="arrow-badge rounded-circle bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-right text-dark fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2 card-title-hover">Daftar Izin Siswa</h5>
                                    <p class="text-secondary small mb-0 leading-relaxed">
                                        Tinjau permohonan surat izin atau sakit yang diajukan oleh siswa dan berikan persetujuan.
                                    </p>
                                </div>
                                <div class="pt-2 border-top border-light d-flex align-items-center justify-content-between text-amber fw-semibold small">
                                    <span>Tinjau Permohonan</span>
                                    <i class="bi bi-chevron-right fs-7"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container Background */
    .dashboard-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* Warna Biru Muda (Tanpa merusak teks) */
    .welcome-banner {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border: 1px solid #7dd3fc;
    }

    .banner-overlay {
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background-image: 
            radial-gradient(circle at 95% 10%, rgba(255, 255, 255, 0.4) 0%, transparent 40%),
            radial-gradient(circle at 10% 90%, rgba(255, 255, 255, 0.3) 0%, transparent 35%);
        pointer-events: none;
    }

    /* Live Pulse Indicator */
    .status-pulse {
        width: 8px; height: 8px;
        background-color: #0284c7; /* Biru tua */
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.7);
        animation: pulse 1.8s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(2, 132, 199, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); }
    }

    /* Stats Cards */
    .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.04) !important; }

    /* Custom Action Cards */
    .custom-action-card {
        border: 1px solid #e2e8f0 !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-accent-line {
        position: absolute; top: 0; left: 0; right: 0; height: 4px;
        opacity: 0; transition: opacity 0.25s ease;
    }

    .action-card-link:hover .custom-action-card {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.06), 0 10px 10px rgba(0, 0, 0, 0.04) !important;
    }

    .action-card-link:hover .card-accent-line { opacity: 1; }
    .action-card-link:hover .arrow-badge { background-color: #4f46e5 !important; color: #ffffff !important; transform: translateX(3px); }
    .action-card-link:hover .arrow-badge i { color: #ffffff !important; }

    .arrow-badge { width: 38px; height: 38px; transition: all 0.25s ease; }
    .action-icon-wrapper { width: 52px; height: 52px; }

    /* Custom Color Accents */
    .bg-indigo { background-color: #4f46e5 !important; }
    .text-indigo { color: #4f46e5 !important; }
    .shadow-indigo { box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25); }

    .bg-teal { background-color: #0d9488 !important; }
    .text-teal { color: #0d9488 !important; }
    .shadow-teal { box-shadow: 0 6px 16px rgba(13, 148, 136, 0.25); }

    .bg-amber { background-color: #d97706 !important; }
    .text-amber { color: #d97706 !important; }
    .shadow-amber { box-shadow: 0 6px 16px rgba(217, 119, 6, 0.25); }
</style>
@endsection