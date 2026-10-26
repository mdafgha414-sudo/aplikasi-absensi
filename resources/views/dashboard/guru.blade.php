@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Page & Stats -->
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1 text-dark">Laporan Jurnal Siswa</h4>
            <p class="text-muted small mb-0">Pantau, periksa, dan berikan penilaian pada jurnal harian siswa PKL.</p>
        </div>
        <div class="col-md-6 col-lg-4 ms-auto">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Total Siswa PKL</span>
                        <h3 class="fw-bold mb-0 text-success mt-1">{{ $totalSiswa }} <span class="fs-6 text-muted fw-normal">Siswa</span></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-journal-text text-success"></i> Daftar Jurnal Siswa
            </h5>
            
            <!-- Action Buttons (Export) -->
            <div class="d-flex gap-2">
                <a href="{{ route('guru.export.excel') }}" class="btn btn-outline-success rounded-3 btn-sm px-3 d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-excel-fill"></i> Ekspor Excel
                </a>
                <a href="{{ route('guru.export.pdf') }}" class="btn btn-outline-danger rounded-3 btn-sm px-3 d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Ekspor PDF
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase border-bottom">
                        <tr>
                            <th class="ps-4 py-3" style="width: 130px;">Tanggal</th>
                            <th class="py-3">Nama Siswa</th>
                            <th class="py-3">Kegiatan</th>
                            <th class="py-3">Kendala</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($semuaJurnal as $jurnal)
                            <tr>
                                <td class="ps-4 text-nowrap">
                                    <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                                            {{ strtoupper(substr($jurnal->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $jurnal->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-secondary text-truncate-2" style="max-width: 250px;">{{ $jurnal->kegiatan }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 text-muted small text-truncate-2" style="max-width: 200px;">{{ $jurnal->kendala ?? '-' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    <span>Belum ada jurnal kegiatan yang dikirimkan oleh siswa.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection