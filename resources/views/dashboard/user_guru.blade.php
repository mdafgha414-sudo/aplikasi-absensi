@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <!-- Banner Sambutan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4 p-lg-5">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <span class="badge bg-white text-primary mb-2 px-3 py-2 rounded-pill fw-bold">
                            Teacher Workspace
                        </span>
                        <h2 class="fw-bold mb-2 display-6">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="mb-0 opacity-75">
                            Kelola dan berikan penilaian jurnal kegiatan siswa bimbingan Anda dengan mudah di sini.
                        </p>
                    </div>
                    <!-- Ikon Banner Kanan -->
                    <div class="d-none d-md-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-4 p-3 me-2" style="width: 90px; height: 90px;">
                        <i class="bi bi-journal-check display-4 text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Menu Utama -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-grid-fill text-primary"></i> Menu Utama
                </h5>

                <div class="row g-3">
                    <!-- Card 1: Lihat & Nilai Jurnal -->
                    <div class="col-md-4">
                        <a href="/guru/jurnal" class="text-decoration-none card-menu-link">
                            <div class="card border rounded-4 h-100 p-3 card-menu-hover transition-all">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px;">
                                        <i class="bi bi-journal-check fs-3"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1">Lihat & Nilai Jurnal</h6>
                                        <p class="text-muted small mb-0 text-truncate-2">Periksa jurnal siswa dan berikan nilai.</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted ms-auto fs-5"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 2: Laporan Absensi -->
                    <div class="col-md-4">
                        <a href="/guru/laporan-absensi" class="text-decoration-none card-menu-link">
                            <div class="card border rounded-4 h-100 p-3 card-menu-hover transition-all">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px;">
                                        <i class="bi bi-calendar-check fs-3"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1">Laporan Absensi</h6>
                                        <p class="text-muted small mb-0 text-truncate-2">Pantau kehadiran dan status siswa.</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted ms-auto fs-5"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 3: Daftar Izin Siswa (BARU) -->
                    <div class="col-md-4">
                        <a href="/guru/izin" class="text-decoration-none card-menu-link">
                            <div class="card border rounded-4 h-100 p-3 card-menu-hover transition-all">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px;">
                                        <i class="bi bi-envelope-paper fs-3"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-1">Daftar Izin Siswa</h6>
                                        <p class="text-muted small mb-0 text-truncate-2">Lihat dan setujui pengajuan izin.</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted ms-auto fs-5"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus tampilan menu */
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
    .card-menu-hover {
        background-color: #f8f9fa;
        border-color: #e9ecef !important;
    }
    .card-menu-link:hover .card-menu-hover {
        background-color: #ffffff !important;
        border-color: #0d6efd !important;
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection