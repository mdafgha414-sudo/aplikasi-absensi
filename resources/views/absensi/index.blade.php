@extends('layouts.app')

@section('content')
<style>
    /* Gaya khusus untuk tampilan Clean & Minimalis */
    body { background-color: #f8f9fa; }
    
    .clean-card {
        background-color: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #f1f3f5;
        color: #495057;
        font-size: 24px;
        margin-bottom: 1rem;
    }

    .time-display {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        letter-spacing: -1px;
    }

    .label-text {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #868e96;
        font-weight: 600;
    }

    .btn-clean-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-clean-primary:hover { background-color: #0b5ed7; }

    .btn-clean-warning {
        background-color: #ffc107;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: #000;
        transition: all 0.2s;
    }
    .btn-clean-warning:hover { background-color: #ffca2c; }
</style>

<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-6 col-lg-5">
        
        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> {{ session('error') }}
            </div>
        @endif

        <div class="clean-card p-4 p-md-5 text-center">
            <!-- Header -->
            <div class="mb-4">
                <div class="icon-box mx-auto">
                    <i class="bi bi-fingerprint"></i>
                </div>
                <h4 class="fw-bold mb-1">Absensi Harian</h4>
                <p class="text-muted small">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
            </div>

            <hr class="text-muted opacity-25 mb-4">

            @if ($absenHariIni)
                <div class="row mb-5">
                    <!-- Kolom Masuk -->
                    <div class="col-6 border-end">
                        <p class="label-text mb-1">Jam Masuk</p>
                        <div class="time-display">{{ $absenHariIni->jam_masuk }}</div>
                        
                        @if($absenHariIni->status == 'Telat')
                            <span class="badge bg-danger bg-opacity-10 text-danger mt-2 px-3 py-1 rounded-pill">
                                <i class="bi bi-clock-history me-1"></i> Telat
                            </span>
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success mt-2 px-3 py-1 rounded-pill">
                                <i class="bi bi-check2-circle me-1"></i> Tepat Waktu
                            </span>
                        @endif
                    </div>
                    
                    <!-- Kolom Pulang -->
                    <div class="col-6">
                        <p class="label-text mb-1">Jam Pulang</p>
                        <div class="time-display text-muted">{{ $absenHariIni->jam_pulang ?? '--:--' }}</div>
                        
                        @if(!$absenHariIni->jam_pulang)
                            <span class="badge bg-secondary bg-opacity-10 text-secondary mt-2 px-3 py-1 rounded-pill">
                                <i class="bi bi-dash-circle me-1"></i> Belum
                            </span>
                        @endif
                    </div>
                </div>

                @if (!$absenHariIni->jam_pulang)
                    <form action="/absensi/pulang" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-clean-warning w-100 shadow-sm">
                            <i class="bi bi-box-arrow-right me-2"></i> Absen Pulang
                        </button>
                    </form>
                @else
                    <div class="p-3 bg-light rounded-3 text-muted small">
                        <i class="bi bi-check-all me-1 fs-5 align-middle"></i> Anda telah menyelesaikan absensi hari ini.
                    </div>
                @endif
            @else
                <div class="mb-5 py-3">
                    <p class="text-muted mb-4">Anda belum melakukan absensi untuk hari ini.</p>
                    <form action="/absensi/masuk" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-clean-primary text-white w-100 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Absen Masuk
                        </button>
                    </form>
                </div>
            @endif

            <div class="mt-4 pt-3 border-top">
                <a href="/absensi/riwayat" class="btn btn-link text-decoration-none text-muted small">
                    <i class="bi bi-clock-history me-1"></i> Lihat Riwayat Absensi
                </a>
            </div>

        </div>
    </div>
</div>
@endsection