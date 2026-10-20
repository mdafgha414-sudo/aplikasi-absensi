
@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f5f6ff;
    }

    .dashboard {
        max-width: 1050px;
        margin: auto;
        padding: 25px 15px;
        color: #292d45;
    }

    .welcome {
        background: linear-gradient(120deg, #5146e5, #8b5cf6);
        color: white;
        padding: 32px;
        border-radius: 22px;
        margin-bottom: 28px;
        box-shadow: 0 10px 25px rgba(81, 70, 229, .16);
    }

    .welcome h2 {
        font-weight: 750;
        font-size: 27px;
    }

    .welcome p {
        color: #eeedff;
        margin-bottom: 0;
    }

    .date-box {
        display: inline-block;
        background: rgba(255,255,255,.18);
        padding: 10px 15px;
        border-radius: 10px;
        margin-top: 18px;
        font-size: 14px;
    }

    .section-title {
        font-weight: 750;
        font-size: 20px;
    }

    .section-desc {
        color: #85899e;
        font-size: 14px;
    }

    .attendance-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 20px;
        padding: 25px;
        height: 100%;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .04);
    }

    .icon-box {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 18px;
    }

    .green-icon {
        background: #e4f8ed;
        color: #15945b;
    }

    .orange-icon {
        background: #fff0dc;
        color: #e99421;
    }

    .card-label {
        color: #85899e;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .time {
        font-size: 30px;
        font-weight: 750;
        margin-bottom: 12px;
    }

    .status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 650;
    }

    .status-green {
        background: #e4f8ed;
        color: #16834f;
    }

    .status-red {
        background: #ffe7e7;
        color: #cf3333;
    }

    .status-orange {
        background: #fff0dc;
        color: #a86a10;
    }

    .action-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 20px;
        padding: 25px;
        margin-top: 22px;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .04);
    }

    .btn-absen {
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 650;
        width: 100%;
        transition: .2s;
    }

    .btn-masuk {
        background: linear-gradient(100deg, #5146e5, #7868f0);
        color: white;
    }

    .btn-masuk:hover {
        background: #4035c8;
        color: white;
    }

    .btn-pulang {
        background: #ffbd45;
        color: #302500;
    }

    .btn-pulang:hover {
        background: #f5aa22;
        color: #302500;
    }

    .info-box {
        background: #efeeff;
        color: #5146b8;
        padding: 17px;
        border-radius: 13px;
        font-size: 14px;
    }

    .history-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
    }

    .history-link {
        color: #5146e5;
        font-size: 28px;
        text-decoration: none;
    }

    @media (max-width: 576px) {
        .dashboard {
            padding: 15px 10px;
        }

        .welcome {
            padding: 24px 20px;
        }

        .welcome h2 {
            font-size: 23px;
        }

        .attendance-card {
            padding: 18px;
        }

        .time {
            font-size: 25px;
        }

        .action-card {
            padding: 20px;
        }
    }
</style>

<div class="dashboard">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger rounded-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Sambutan --}}
    <div class="welcome">
        <span class="small fw-semibold">
            <i class="bi bi-stars me-2"></i>
            DASHBOARD ABSENSI
        </span>

        <h2 class="mt-3">
            Halo, {{ Auth::user()->name }}! 👋
        </h2>

        <p>Selamat datang! Jangan lupa catat kehadiranmu hari ini.</p>

        <div class="date-box">
            <i class="bi bi-calendar3 me-2"></i>
            {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- Judul --}}
    <div class="mb-3">
        <h5 class="section-title mb-1">Ringkasan Kehadiran</h5>
        <p class="section-desc">
            Berikut informasi absensi kamu hari ini.
        </p>
    </div>

    {{-- Kartu absensi --}}
    <div class="row g-3">

        <div class="col-md-6">
            <div class="attendance-card">
                <div class="icon-box green-icon">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>

                <p class="card-label">Waktu Kehadiran</p>
                <h6 class="fw-bold">Absen Masuk</h6>

                <div class="time">
                    {{ $absenHariIni ? $absenHariIni->jam_masuk : '--:--' }}
                </div>

                @if ($absenHariIni)
                    @if ($absenHariIni->status == 'Telat')
                        <span class="status status-red">
                            <i class="bi bi-clock-history me-1"></i>
                            Terlambat
                        </span>
                    @else
                        <span class="status status-green">
                            <i class="bi bi-check-circle me-1"></i>
                            Tepat Waktu
                        </span>
                    @endif
                @else
                    <span class="status status-orange">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Belum Absen
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="attendance-card">
                <div class="icon-box orange-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>

                <p class="card-label">Waktu Kepulangan</p>
                <h6 class="fw-bold">Absen Pulang</h6>

                <div class="time">
                    {{ $absenHariIni && $absenHariIni->jam_pulang
                        ? $absenHariIni->jam_pulang
                        : '--:--' }}
                </div>

                @if ($absenHariIni && $absenHariIni->jam_pulang)
                    <span class="status status-green">
                        <i class="bi bi-check-circle me-1"></i>
                        Selesai
                    </span>
                @else
                    <span class="status status-orange">
                        <i class="bi bi-hourglass-split me-1"></i>
                        Belum Absen Pulang
                    </span>
                @endif
            </div>
        </div>

    </div>

    {{-- Tombol aksi --}}
    <div class="action-card">
        <h5 class="section-title mb-2">Aksi Absensi</h5>

        <p class="section-desc mb-4">
            @if (!$absenHariIni)
                Kamu belum absen masuk hari ini.
            @elseif (!$absenHariIni->jam_pulang)
                Absen masuk sudah tercatat. Jangan lupa absen pulang.
            @else
                Absensi hari ini sudah selesai. Terima kasih!
            @endif
        </p>

        @if (!$absenHariIni)
            <form action="/absensi/masuk" method="POST">
                @csrf
                <button type="submit" class="btn-absen btn-masuk">
                    <i class="bi bi-fingerprint me-2"></i>
                    Absen Masuk Sekarang
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

        @elseif (!$absenHariIni->jam_pulang)
            <form action="/absensi/pulang" method="POST">
                @csrf
                <button type="submit" class="btn-absen btn-pulang">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Absen Pulang Sekarang
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

        @else
            <div class="info-box">
                <i class="bi bi-check-circle-fill me-2"></i>
                Kamu sudah menyelesaikan absensi hari ini.
            </div>
        @endif
    </div>

    {{-- Informasi dan riwayat --}}
    <div class="row g-3 mt-1">
        <div class="col-md-7">
            <div class="info-box h-100">
                <h6 class="fw-bold">
                    <i class="bi bi-lightbulb-fill me-2"></i>
                    Informasi Absensi
                </h6>
                <p class="mb-0">
                    Pastikan kamu melakukan absensi masuk dan pulang
                    sesuai ketentuan yang berlaku.
                </p>
            </div>
        </div>

        <div class="col-md-5">
            <div class="history-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold mb-1">Riwayat Absensi</h6>
                    <p class="section-desc mb-0">
                        Lihat catatan kehadiranmu.
                    </p>
                </div>

                <a href="/absensi/riwayat" class="history-link"
                   aria-label="Lihat riwayat absensi">
                    <i class="bi bi-arrow-up-right-circle"></i>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
