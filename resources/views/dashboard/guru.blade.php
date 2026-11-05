@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background-color: #f8fafc !important;
    }

    /* --- DESAIN DASHBOARD (ATAS) --- */
    .dash-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        position: relative;
    }

    /* Banner Kiri */
    .dash-banner {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        color: #0369a1;
        padding: 40px;
        height: 100%;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .dash-banner::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
    }
    .dash-banner::after {
        content: '';
        position: absolute;
        bottom: -80px; right: 50px;
        width: 150px; height: 150px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }
    .dash-banner h2 { color: #0f172a; }
    .dash-banner p { color: #334155; }
    
    .banner-icon {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        width: 80px; height: 80px;
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
        color: #0284c7;
        border: 1px solid rgba(255, 255, 255, 1);
        box-shadow: 0 8px 20px rgba(2, 132, 199, 0.15);
        z-index: 2;
    }

    /* Card Total Kanan */
    .dash-total {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }
    .total-icon {
        width: 65px; height: 65px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 28px;
    }

    /* --- DESAIN TABEL (BAWAH) --- */
    .table-premium { margin-bottom: 0; }
    .table-premium thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px 20px;
        border-bottom: 2px solid #e2e8f0;
        border-top: none;
    }
    .table-premium tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }
    .table-premium tbody tr { transition: background-color 0.2s ease; }
    .table-premium tbody tr:hover { background-color: #f8fafc; }

    /* Avatar & Badge */
    .avatar-sm {
        width: 38px; height: 38px;
        background-color: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        border: 2px solid #dbeafe;
    }
    .badge-nilai {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }

    .btn-aksi {
        background: #2563eb;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 16px;
        border: none;
        transition: all 0.2s;
    }
    .btn-aksi:hover { background: #1d4ed8; color: white; transform: translateY(-1px); }
</style>

<div class="container-fluid py-4 px-lg-5">
    
    <!-- AREA DASHBOARD -->
    <div class="row g-4 mb-5">
        <!-- Banner Kiri -->
        <div class="col-lg-8">
            <div class="dash-card h-100">
                <div class="dash-banner">
                    <div style="position: relative; z-index: 2;">
                        <h2 class="fw-bolder mb-2" style="letter-spacing: -0.5px;">Laporan Jurnal Siswa</h2>
                        <p class="mb-0" style="font-size: 15px; font-weight: 500;">Pantau dan periksa jurnal harian siswa PKL dengan mudah.</p>
                    </div>
                    <div class="banner-icon d-none d-md-flex">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Siswa Kanan -->
        <div class="col-lg-4">
            <div class="dash-card h-100">
                <div class="dash-total">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold mb-1 text-uppercase" style="color: #64748b; font-size: 12px; letter-spacing: 1px;">Total Siswa PKL</p>
                            <h1 class="fw-bolder mb-0" style="color: #0f172a; font-size: 48px;">
                                {{ $totalSiswa ?? 0 }} <span class="fs-6 fw-semibold text-secondary ms-1">Siswa</span>
                            </h1>
                        </div>
                        <div class="total-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tabel Jurnal -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            
            <!-- Header Tabel & Tombol Export -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-journal-text text-secondary"></i> Daftar Jurnal Siswa
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('guru.export.excel', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-success btn-sm fw-semibold px-3 rounded-2">
                        <i class="bi bi-file-earmark-excel me-1"></i> Eksport Excel
                    </a>
                    <a href="{{ route('guru.export.pdf', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-danger btn-sm fw-semibold px-3 rounded-2">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Eksport PDF
                    </a>
                </div>
    <!-- AREA TABEL JURNAL -->
    <div class="dash-card p-4 p-md-5">
        
        <!-- Header Tabel & Tombol Export (Tombol Export TIDAK diubah) -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="fw-bolder mb-0 d-flex align-items-center gap-2" style="color: #0f172a; font-size: 18px;">
                <i class="bi bi-journal-text text-primary fs-4"></i> Daftar Jurnal Siswa
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('guru.export.excel', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-success btn-sm fw-semibold px-3 rounded-2">
                    <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
                </a>
                <a href="{{ route('guru.export.pdf', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-danger btn-sm fw-semibold px-3 rounded-2">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Ekspor PDF
                </a>
            </div>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-premium align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kegiatan</th>
                        <th>Kendala</th>
                        <th class="text-center">Nilai</th>
                        @if(Auth::user()->role === 'pembimbing')
                            <th class="text-end">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($semuaJurnal as $jurnal)
                        <tr>
                            <td class="text-secondary fw-medium">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                            
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm">
                                        {{ substr($jurnal->user->name ?? 'S', 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-capitalize" style="color: #1e293b;">{{ $jurnal->user->name ?? 'Siswa' }}</span>
                                </div>
                            </td>

                            <td class="text-secondary" style="max-width: 250px; white-space: normal; line-height: 1.5;">
                                {{ $jurnal->kegiatan }}
                            </td>

                            <td class="text-secondary" style="max-width: 200px; white-space: normal; line-height: 1.5;">
                                {{ $jurnal->kendala ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if($jurnal->nilai)
                                    <span class="badge-nilai" style="background-color: #dcfce7; color: #16a34a;">
                                        {{ $jurnal->nilai }}
                                    </span>
                                @else
                                    <span class="badge-nilai" style="background-color: #f1f5f9; color: #64748b;">
                                        Belum
                                    </span>
                                @endif
                            </td>

                            @if(Auth::user()->role === 'pembimbing')
                                <td class="text-end">
                                    <button type="button" class="btn-aksi d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $jurnal->id }}">
                                        <i class="bi bi-pencil-square"></i> Beri Nilai
                                    </button>
                                </td>
                            @endif
                        </tr>

                        <!-- MODAL FORM PENILAIAN -->
                        <div class="modal fade" id="modalNilai{{ $jurnal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark">Penilaian Jurnal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('guru.nilai', $jurnal->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="mb-3 p-3 bg-light rounded-3">
                                                <span class="text-secondary small d-block mb-1">Siswa:</span>
                                                <strong class="text-dark">{{ $jurnal->user->name ?? 'Siswa' }}</strong> <span class="text-secondary mx-1">|</span> <span class="text-secondary">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-secondary small">Nilai (0-100)</label>
                                                <input type="number" name="nilai" class="form-control form-control-lg fw-bold" min="0" max="100" value="{{ $jurnal->nilai }}" required placeholder="Contoh: 90">
                                            </div>
                                            
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold text-secondary small">Catatan Guru / Ulasan</label>
                                                <textarea name="catatan_guru" class="form-control" rows="3" placeholder="Berikan ulasan atau masukan untuk siswa...">{{ $jurnal->catatan_guru }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-4 rounded-3">Simpan Nilai</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                Belum ada jurnal yang diisi oleh siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection