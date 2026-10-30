@extends('layouts.app')

@section('content')
<div class="dashboard-wrapper py-4 px-3 px-lg-5">
    
    <!-- 1. Header Banner Welcome -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-banner p-4 p-lg-5 rounded-4 position-relative overflow-hidden shadow-sm">
                <div class="banner-overlay"></div>
                <div class="row align-items-center position-relative z-2">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white text-primary fw-medium small mb-3">
                            <span class="status-pulse"></span> Pembimbing Workspace
                        </div>
                        <h2 class="fw-bold fs-2 text-dark mb-2 tracking-tight">
                            Selamat Datang, {{ Auth::user()->name }} 
                        </h2>
                        <p class="text-secondary mb-0 fs-6 leading-relaxed">
                            Kelola jurnal, nilai aktivitas, dan setujui pengajuan izin siswa bimbingan PKL Anda dengan mudah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Section Menu Utama Navigasi -->
    <div class="row mb-4">
        <div class="col-12 mb-3">
            <h5 class="fw-bold text-dark mb-1">Menu Utama</h5>
            <p class="text-secondary small mb-0">Pilih menu navigasi di bawah untuk mulai bekerja</p>
        </div>

        <div class="col-12">
            <div class="row g-3">
                <!-- Card 1: Jurnal -->
                <div class="col-md-3">
                    <a href="{{ url('/pembimbing/jurnal') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="action-icon-wrapper rounded-3 bg-primary text-white d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-check fs-3"></i>
                                </div>
                                <i class="bi bi-arrow-right text-muted fs-5"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Nilai Jurnal Siswa</h5>
                            <p class="text-secondary small mb-0">Periksa jurnal harian siswa dan berikan penilaian.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Laporan Absensi -->
                <div class="col-md-3">
                    <a href="{{ url('/pembimbing/laporan-absensi') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card border-primary" style="border: 1px solid #bfdbfe !important;">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="action-icon-wrapper rounded-3 bg-primary text-white d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-check fs-3"></i>
                                </div>
                                <i class="bi bi-arrow-right text-primary fs-5"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Laporan Absensi</h5>
                            <p class="text-secondary small mb-0">Pantau rekapitulasi kehadiran dan status siswa.</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Daftar Izin -->
                <div class="col-md-3">
                    <a href="{{ url('/pembimbing/izin') }}" class="text-decoration-none action-card-link">
                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="action-icon-wrapper rounded-3 bg-primary text-white d-flex align-items-center justify-content-center">
                                    <i class="bi bi-envelope-paper fs-3"></i>
                                </div>
                                <i class="bi bi-arrow-right text-muted fs-5"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Daftar Izin Siswa</h5>
                            <p class="text-secondary small mb-0">Lihat dan setujui pengajuan izin atau sakit siswa.</p>
                        </div>
                    </a>
                </div>
                <!-- Card 4: Alasan Keterlambatan -->
                <div class="col-md-3">
                    <a href="{{ url('/pembimbing/alasan-keterlambatan') }}"
                    class="text-decoration-none action-card-link">

                        <div class="card h-100 border-0 rounded-4 p-4 bg-white shadow-sm custom-action-card">

                            <div class="d-flex align-items-center justify-content-between mb-3">

                                <div class="action-icon-wrapper rounded-3 bg-primary text-white d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock-history fs-3"></i>
                                </div>

                                <i class="bi bi-arrow-right text-muted fs-5"></i>

                            </div>

                            <h5 class="fw-bold text-dark mb-2">
                                Alasan Keterlambatan
                            </h5>

                            <p class="text-secondary small mb-0">
                                Kelola dan atur alasan keterlambatan siswa.
                            </p>

                        </div>

                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SECTION BARU: RIWAYAT JURNAL TERBARU -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Riwayat Jurnal Terbaru</h5>
                        <p class="text-secondary small mb-0">Daftar jurnal yang baru saja diisi oleh siswa.</p>
                    </div>
                    <a href="{{ url('/pembimbing/jurnal') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-secondary fw-semibold small">Nama Siswa</th>
                                <th class="text-secondary fw-semibold small">Tanggal Jurnal</th>
                                <th class="text-secondary fw-semibold small">Jam Diisi</th>
                                <th class="text-secondary fw-semibold small">Status</th>
                                <th class="text-secondary fw-semibold small text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalTerbaru as $jurnal)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                                                {{ substr($jurnal->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <span class="fw-medium text-dark">{{ $jurnal->user->name ?? 'Siswa' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-clock me-1"></i> {{ $jurnal->created_at->format('H:i') }} WIB
                                        </span>
                                    </td>
                                    <td>
                                        @if($jurnal->nilai)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Sudah Dinilai</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Belum Dinilai</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/pembimbing/jurnal') }}" class="btn btn-sm btn-light border">Beri Nilai</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        Belum ada jurnal yang diisi oleh siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper { background-color: #f8fafc; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    
    /* Warna Biru Muda Banner */
    .welcome-banner { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border: 1px solid #7dd3fc; }
    .banner-overlay {
        position: absolute; top: 0; right: 0; bottom: 0; left: 0;
        background-image: radial-gradient(circle at 95% 10%, rgba(255, 255, 255, 0.4) 0%, transparent 40%);
        pointer-events: none;
    }
    .status-pulse {
        width: 8px; height: 8px; background-color: #0284c7; border-radius: 50%;
        display: inline-block; animation: pulse 1.8s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(2, 132, 199, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(2, 132, 199, 0); }
    }
    
    /* Kartu Menu */
    .custom-action-card { transition: all 0.25s ease; border: 1px solid #e2e8f0 !important; }
    .action-card-link:hover .custom-action-card { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .action-icon-wrapper { width: 45px; height: 45px; }
</style>
@endsection