@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f5f6ff;
    }

    .history-page {
        max-width: 1150px;
        margin: auto;
        padding: 25px 15px;
        color: #292d45;
    }

    .history-banner {
        /* Mengubah banner menjadi biru sangat muda */
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        border-radius: 22px;
        padding: 30px;
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-block;
        color: #0284c7;
        text-decoration: none;
        background: white;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        border: 1px solid #e0f2fe;
        transition: .2s;
    }

    .back-link:hover {
        color: #0369a1;
        background: #f0f9ff;
    }

    .banner-icon {
        width: 65px;
        height: 65px;
        /* Gradien ikon menjadi biru */
        background: linear-gradient(135deg, #38bdf8, #0284c7);
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        flex-shrink: 0;
    }

    .history-banner h2 {
        font-size: 27px;
        font-weight: 800;
        color: #0f172a; /* Teks lebih gelap */
        margin-bottom: 8px;
    }

    .history-banner p {
        color: #334155;
        margin-bottom: 0;
    }

    .stat-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .035);
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 13px;
        font-size: 21px;
        margin-bottom: 15px;
    }

    .stat-purple {
        /* Mengubah icon statistik pertama jadi biru */
        background: #e0f2fe;
        color: #0284c7;
    }

    .stat-green {
        background: #e4f8ed;
        color: #15945b;
    }

    .stat-red {
        background: #ffe9e9;
        color: #db4646;
    }

    .stat-orange {
        background: #fff0dc;
        color: #d78a18;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 3px;
        color: #292d45;
    }

    .stat-label {
        font-size: 13px;
        color: #85899e;
    }

    .history-panel {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 20px;
        padding: 25px;
        margin-top: 24px;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .035);
    }

    .panel-title {
        font-size: 19px;
        font-weight: 750;
        color: #292d45;
    }

    .panel-subtitle {
        font-size: 13px;
        color: #85899e;
    }

    .table-wrap {
        border: 1px solid #edf0fa;
        border-radius: 13px;
        overflow-x: auto;
    }

    .history-table {
        min-width: 650px;
        margin-bottom: 0;
    }

    .history-table thead th {
        /* Mengubah header tabel jadi biru muda */
        background: #f0f9ff;
        color: #0369a1;
        font-size: 12px;
        font-weight: 700;
        padding: 16px 15px;
        border: none;
        white-space: nowrap;
    }

    .history-table tbody td {
        padding: 16px 15px;
        vertical-align: middle;
        font-size: 13px;
        color: #424761;
        border-color: #f0f1f8;
    }

    .history-table tbody tr:hover td {
        background: #f8fbff; /* Hover tabel biru sangat tipis */
    }

    .date-main {
        font-weight: 700;
        color: #35385d;
    }

    .date-day {
        color: #9599b0;
        font-size: 11px;
        margin-top: 3px;
    }

    .time-value {
        font-weight: 650;
        color: #343957;
    }

    .time-in {
        color: #169768;
    }

    .time-out {
        color: #d98b1b;
    }

    .status-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-on-time {
        background: #e2f8ee;
        color: #16865a;
    }

    .badge-late {
        background: #ffe8e8;
        color: #d53f45;
    }

    .badge-pending {
        background: #fff2dc;
        color: #a86d13;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
        color: #85899e;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        background: #e0f2fe; /* Biru muda */
        color: #0284c7; /* Biru */
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        font-size: 32px;
        margin: 0 auto 18px;
    }

    .info-panel {
        margin-top: 20px;
        padding: 17px 20px;
        background: #f0f9ff;
        border: 1px solid #e0f2fe;
        border-radius: 15px;
        color: #0369a1;
        font-size: 13px;
    }

    @media (max-width: 576px) {
        .history-page {
            padding: 15px 10px;
        }

        .history-banner {
            padding: 22px 18px;
        }

        .history-banner h2 {
            font-size: 23px;
        }

        .banner-icon {
            width: 52px;
            height: 52px;
            font-size: 24px;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-number {
            font-size: 24px;
        }

        .history-panel {
            padding: 17px 12px;
        }
    }
</style>

@php
    $totalRiwayat = 0;
    $totalTelat = 0;
    $totalPulang = 0;
    $totalBelumPulang = 0;

    foreach ($riwayat as $item) {
        $totalRiwayat++;

        if ($item->status == 'Telat') {
            $totalTelat++;
        }

        if ($item->jam_pulang) {
            $totalPulang++;
        } else {
            $totalBelumPulang++;
        }
    }
@endphp

<div class="history-page">

    {{-- Banner halaman --}}
    <div class="history-banner">
        <a href="/dashboard" class="back-link">
            <i class="bi bi-arrow-left me-2"></i>
            Kembali ke Dashboard
        </a>

        <div class="d-flex align-items-center gap-3">
            <div class="banner-icon">
                <i class="bi bi-clock-history"></i>
            </div>

            <div>
                <h2>Riwayat Absensi</h2>
                <p>
                    Hai, {{ Auth::user()->name }}!
                    Berikut catatan kehadiran kamu.
                </p>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-3">

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon stat-purple">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $totalRiwayat }}</div>
                <div class="stat-label">Total Catatan</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon stat-green">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div class="stat-number">{{ $totalRiwayat }}</div>
                <div class="stat-label">Tercatat Masuk</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon stat-red">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-number">{{ $totalTelat }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon stat-orange">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <div class="stat-number">{{ $totalPulang }}</div>
                <div class="stat-label">Sudah Absen Pulang</div>
            </div>
        </div>

    </div>

    {{-- Tabel riwayat --}}
    <div class="history-panel">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h5 class="panel-title mb-1">
                    <i class="bi bi-list-ul me-2" style="color:#0284c7;"></i> {{-- Ikon jadi biru --}}
                    Catatan Kehadiran
                </h5>
                <p class="panel-subtitle mb-0">
                    Daftar absensi yang tercatat pada akunmu.
                </p>
            </div>

            <span class="badge rounded-pill px-3 py-2"
                  style="background:#e0f2fe;color:#0284c7;"> {{-- Badge jadi biru --}}
                {{ $totalRiwayat }} catatan
            </span>
        </div>

        <div class="table-wrap">
            <table class="table history-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- =================================================
                        MENAMPILKAN DATA RIWAYAT ABSENSI
                        $riwayat dikirim dari AbsensiController.
                        ================================================= --}}
                    @forelse ($riwayat as $r)

                        <tr>
                            {{-- Nomor urut data --}}
                            <td>{{ $loop->iteration }}</td>

                            {{-- Tanggal dan nama hari --}}
                            <td>
                                <div class="date-main">
                                    {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                                </div>

                                <div class="date-day">
                                    {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('l') }}
                                </div>
                            </td>

                            {{-- Jam masuk --}}
                            <td>
                                @if ($r->jam_masuk)
                                    <span class="time-value time-in">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>
                                        {{ $r->jam_masuk }}
                                    </span>
                                @else
                                    <span class="text-muted">--:--</span>
                                @endif
                            </td>

                            {{-- Jam pulang --}}
                            <td>
                                @if ($r->jam_pulang)
                                    <span class="time-value time-out">
                                        <i class="bi bi-box-arrow-right me-1"></i>
                                        {{ $r->jam_pulang }}
                                    </span>
                                @else
                                    <span class="status-badge badge-pending">
                                        Belum pulang
                                    </span>
                                @endif
                            </td>

                            {{-- Status kehadiran --}}
                            <td>
                                @if ($r->status == 'Telat')
                                    <span class="status-badge badge-late">
                                        <i class="bi bi-clock me-1"></i>
                                        Terlambat
                                    </span>
                                @else
                                    <span class="status-badge badge-on-time">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Tepat Waktu
                                    </span>
                                @endif
                            </td>
                        </tr>

                    {{-- =================================================
                        TAMPILAN JIKA BELUM ADA RIWAYAT ABSENSI
                        ================================================= --}}
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-calendar2-x"></i>
                                    </div>

                                    <h6 class="fw-bold" style="color:#414563;">
                                        Belum Ada Riwayat
                                    </h6>

                                    <p class="mb-3">
                                        Catatan absensi kamu akan muncul di sini
                                        setelah melakukan absensi masuk.
                                    </p>

                                    <a href="/absensi"
                                    class="btn btn-sm text-white rounded-pill px-4"
                                    style="background:#0284c7;"> {{-- Tombol jadi biru --}}
                                        <i class="bi bi-fingerprint me-1"></i>
                                        Absen Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <span class="panel-subtitle">
                Menampilkan {{ $totalRiwayat }} catatan absensi.
            </span>

            <a href="/absensi"
               class="btn btn-sm rounded-pill px-3"
               style="background:#e0f2fe;color:#0284c7;"> {{-- Tombol kembali jadi biru --}}
                <i class="bi bi-arrow-left me-1"></i>
                Kembali ke Absensi
            </a>
        </div>

    </div>

    {{-- Informasi --}}
    <div class="info-panel">
        <i class="bi bi-lightbulb-fill me-2"></i>
        <strong>Informasi:</strong>
        Periksa kembali catatan kehadiranmu. Jika terdapat data yang
        tidak sesuai, hubungi admin untuk mendapatkan bantuan.
    </div>

</div>
@endsection