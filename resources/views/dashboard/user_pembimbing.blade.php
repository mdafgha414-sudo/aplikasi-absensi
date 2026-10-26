@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-5" style="background-color: #f8fafc; min-height: 100vh;">
    
    <!-- Banner Sambutan Minimalis (Biru Lebih Pekat & Kontras) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 p-lg-5 rounded-4 bg-white border border-light-subtle shadow-2xs position-relative overflow-hidden">
                
                <!-- Motif Background Aksen Biru Lebih Pekat -->
                <div class="banner-pattern-bg"></div>
                <div class="banner-glow-circle"></div>
                <div class="banner-glow-circle-2"></div>
                
                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-8">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary text-white fw-semibold small mb-3 shadow-sm">
                            <i class="bi bi-circle-fill" style="font-size: 6px;"></i> Pembimbing Workspace
                        </div>
                        <h2 class="fw-bold text-dark mb-2 tracking-tight">Selamat Datang, {{ Auth::user()->name }}</h2>
                        <p class="text-secondary mb-0 fs-6">
                            Kelola jurnal, nilai aktivitas, dan setujui pengajuan izin siswa bimbingan PKL Anda dengan mudah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Menu Utama -->
    <div class="row">
        <div class="col-12">
            <div class="mb-3 px-1">
                <h5 class="fw-bold text-dark mb-1">Menu Utama</h5>
                <p class="text-secondary small mb-0">Pilih menu navigasi di bawah untuk mulai bekerja</p>
            </div>

            <div class="row g-3">
                <!-- Card 1: Lihat & Nilai Jurnal -->
                <div class="col-md-4">
                    <a href="{{ url('/pembimbing/jurnal') }}" class="text-decoration-none group-link">
                        <div class="card border border-light-subtle rounded-4 p-4 h-100 bg-white shadow-2xs custom-card-hover">
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="icon-box bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-xs">
                                        <i class="bi bi-journal-check fs-4"></i>
                                    </div>
                                    <span class="text-muted small fw-medium arrow-move">
                                        <i class="bi bi-arrow-right fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 title-color">Lihat & Nilai Jurnal</h6>
                                    <p class="text-secondary small mb-0 line-clamp-2">Periksa jurnal harian siswa dan berikan penilaian.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Laporan Absensi -->
                <div class="col-md-4">
                    <a href="{{ url('/pembimbing/laporan-absensi') }}" class="text-decoration-none group-link">
                        <div class="card border border-light-subtle rounded-4 p-4 h-100 bg-white shadow-2xs custom-card-hover">
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="icon-box bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-xs">
                                        <i class="bi bi-calendar-check fs-4"></i>
                                    </div>
                                    <span class="text-muted small fw-medium arrow-move">
                                        <i class="bi bi-arrow-right fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 title-color">Laporan Absensi</h6>
                                    <p class="text-secondary small mb-0 line-clamp-2">Pantau rekapitulasi kehadiran dan status siswa.</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Daftar Izin Siswa -->
                <div class="col-md-4">
                    <a href="{{ url('/pembimbing/izin') }}" class="text-decoration-none group-link">
                        <div class="card border border-light-subtle rounded-4 p-4 h-100 bg-white shadow-2xs custom-card-hover">
                            <div class="d-flex flex-column h-100 justify-content-between gap-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="icon-box bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-xs">
                                        <i class="bi bi-envelope-paper fs-4"></i>
                                    </div>
                                    <span class="text-muted small fw-medium arrow-move">
                                        <i class="bi bi-arrow-right fs-5"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1 title-color">Daftar Izin Siswa</h6>
                                    <p class="text-secondary small mb-0 line-clamp-2">Lihat dan setujui pengajuan izin atau sakit siswa.</p>
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
    /* Motif Geometric Grid & Lingkaran dengan Biru yang Lebih Pekat/Solid */
    .banner-pattern-bg {
        position: absolute;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background-image: radial-gradient(rgba(13, 110, 253, 0.45) 2px, transparent 2px);
        background-size: 16px 16px;
        mask-image: linear-gradient(to left, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%);
        -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%);
        pointer-events: none;
    }

    .banner-glow-circle {
        position: absolute;
        top: -40px;
        right: -20px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.16);
        filter: blur(25px);
        pointer-events: none;
    }

    .banner-glow-circle-2 {
        position: absolute;
        bottom: -40px;
        right: 160px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 2px dashed rgba(13, 110, 253, 0.35);
        pointer-events: none;
    }

    /* Kotak ikon menu utama menggunakan latar biru pekat */
    .icon-box {
        width: 48px;
        height: 48px;
    }

    /* Card Hover minimalis */
    .custom-card-hover {
        transition: all 0.2s ease-in-out;
    }

    .group-link:hover .custom-card-hover {
        border-color: #0d6efd !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(13, 110, 253, 0.08), 0 8px 10px -6px rgba(13, 110, 253, 0.08) !important;
    }

    .group-link:hover .title-color {
        color: #0d6efd !important;
    }

    .group-link:hover .arrow-move {
        transform: translateX(4px);
        color: #0d6efd !important;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    /* Utilitas */
    .shadow-2xs {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
    }

    .shadow-xs {
        box-shadow: 0 1px 3px rgba(13, 110, 253, 0.2);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection