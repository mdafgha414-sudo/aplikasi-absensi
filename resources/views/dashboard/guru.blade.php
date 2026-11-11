
@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background-color: #f8fafc !important;
    }

    /* =================================
       DASHBOARD
    ================================= */

    .dash-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 25px rgba(0,0,0,.03);
        overflow: hidden;
        position: relative;
    }

    .dash-banner {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        color: #0369a1;
        padding: 35px;
        min-height: 145px;
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
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,.4);
        border-radius: 50%;
    }

    .dash-banner::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: 50px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,.2);
        border-radius: 50%;
    }

    .dash-banner h2 {
        color: #0f172a;
        font-size: 23px;
    }

    .dash-banner p {
        color: #334155;
        font-size: 13px !important;
    }

    .banner-icon {
        background: rgba(255,255,255,.8);
        backdrop-filter: blur(10px);
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        color: #0284c7;
        border: 1px solid white;
        box-shadow: 0 8px 20px rgba(2,132,199,.15);
        z-index: 2;
        flex-shrink: 0;
    }

    .dash-total {
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        min-height: 145px;
    }

    .total-icon {
        width: 58px;
        height: 58px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    /* =================================
       DAFTAR JURNAL
    ================================= */

    .journal-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 25px rgba(0,0,0,.03);
    }

    .journal-heading {
        color: #0f172a;
        font-size: 18px;
        font-weight: 800;
        margin: 0;
    }

    .journal-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 22px;
    }

    .export-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .export-buttons .btn {
        font-size: 11px;
        font-weight: 700;
        padding: 8px 12px;
        white-space: nowrap;
        border-radius: 8px;
    }

    /* =================================
       TABEL
    ================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        border-radius: 10px;
        scrollbar-width: thin;
        scrollbar-color: #93c5fd #eff6ff;
    }

    .table-wrapper::-webkit-scrollbar {
        height: 7px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: #eff6ff;
        border-radius: 10px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #93c5fd;
        border-radius: 10px;
    }

    .table-premium {
        margin-bottom: 0;
        width: 100%;
        min-width: 850px;
    }

    .table-premium thead th {
        background-color: #f1f7fd;
        color: #64748b;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 14px 13px;
        border-bottom: 1px solid #e2e8f0;
        border-top: none;
        white-space: nowrap;
    }

    .table-premium tbody td {
        padding: 14px 13px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        line-height: 1.6;
    }

    .table-premium tbody tr {
        transition: background-color .2s ease;
    }

    .table-premium tbody tr:hover {
        background-color: #f8fafc;
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
        background-color: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 12px;
        border: 2px solid #dbeafe;
        flex-shrink: 0;
    }

    .badge-nilai {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 11px;
        display: inline-block;
        white-space: nowrap;
    }

    .btn-aksi {
        background: #2563eb;
        color: white;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        padding: 8px 12px;
        border: none;
        white-space: nowrap;
        transition: all .2s;
    }

    .btn-aksi:hover {
        background: #1d4ed8;
        color: white;
    }

    .scroll-hint {
        display: none;
    }

    /* =================================
       MODAL PENILAIAN
    ================================= */

    .modal-content {
        border: none;
        border-radius: 16px;
    }

    .modal-title {
        font-size: 17px;
    }

    /* =================================
       TABLET
    ================================= */

    @media (max-width: 991px) {

        .dash-banner {
            padding: 25px;
        }

        .dash-total {
            padding: 22px;
        }

        .journal-card {
            padding: 22px;
        }

    }

    /* =================================
       HP
    ================================= */

    @media (max-width: 767px) {

        body {
            font-size: 13px;
        }

        .container-fluid {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        /* BANNER */

        .row.g-4 {
            --bs-gutter-x: 10px;
            --bs-gutter-y: 10px;
            margin-bottom: 18px !important;
        }

        .dash-card {
            border-radius: 15px;
        }

        .dash-banner {
            min-height: 105px;
            padding: 17px;
        }

        .dash-banner h2 {
            font-size: 17px;
            line-height: 1.4;
            margin-bottom: 5px !important;
            letter-spacing: -.3px !important;
        }

        .dash-banner p {
            font-size: 10px !important;
            line-height: 1.6;
            max-width: 260px;
        }

        .banner-icon {
            display: none !important;
        }

        /* TOTAL SISWA */

        .dash-total {
            min-height: 80px;
            padding: 13px 17px;
        }

        .dash-total p {
            font-size: 9px !important;
            letter-spacing: .6px !important;
        }

        .dash-total h1 {
            font-size: 27px !important;
        }

        .dash-total h1 span {
            font-size: 11px !important;
        }

        .total-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            font-size: 18px;
        }

        /* PANEL JURNAL */

        .journal-card {
            padding: 15px 12px;
            border-radius: 15px;
        }

        .journal-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 15px;
        }

        .journal-heading {
            font-size: 14px;
        }

        .journal-heading i {
            font-size: 18px !important;
        }

        /* TOMBOL EKSPOR */

        .export-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            gap: 8px;
        }

        .export-buttons .btn {
            width: 100%;
            font-size: 10px;
            padding: 9px 5px;
            border-radius: 8px;
        }

        /* TABEL TETAP TABEL */

        .table-wrapper {
            display: block;
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            border: 1px solid #edf2f7;
            border-radius: 9px;
        }

        .table-premium {
            min-width: 820px;
            width: 820px;
            table-layout: auto;
        }

        .table-premium thead th {
            font-size: 10px;
            padding: 11px 10px;
            letter-spacing: .3px;
        }

        .table-premium tbody td {
            font-size: 10px;
            padding: 12px 10px;
            line-height: 1.5;
        }

        .table-premium tbody td:nth-child(1) {
            min-width: 100px;
            white-space: nowrap;
        }

        .table-premium tbody td:nth-child(2) {
            min-width: 165px;
        }

        .table-premium tbody td:nth-child(3) {
            min-width: 190px;
            max-width: 190px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .table-premium tbody td:nth-child(4) {
            min-width: 140px;
            max-width: 140px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .table-premium tbody td:nth-child(5) {
            min-width: 75px;
        }

        .table-premium tbody td:nth-child(6) {
            min-width: 115px;
        }

        .avatar-sm {
            width: 29px;
            height: 29px;
            font-size: 10px;
            border-width: 1px;
        }

        .badge-nilai {
            font-size: 10px;
            padding: 5px 9px;
        }

        .btn-aksi {
            font-size: 10px;
            padding: 7px 9px;
        }

        /* PETUNJUK GESER */

        .scroll-hint {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            color: #94a3b8;
            font-size: 9px;
            margin-top: 9px;
        }

        .scroll-hint i {
            color: #0284c7;
            font-size: 12px;
        }

        /* MODAL */

        .modal-dialog {
            margin: 12px;
        }

        .modal-body {
            padding: 16px !important;
        }

        .modal-title {
            font-size: 14px;
        }

        .modal .form-control {
            font-size: 13px;
        }

    }

    /* HP KECIL */

    @media (max-width: 380px) {

        .dash-banner {
            min-height: 95px;
            padding: 14px;
        }

        .dash-banner h2 {
            font-size: 15px;
        }

        .dash-banner p {
            font-size: 9px !important;
        }

        .journal-card {
            padding: 12px 9px;
        }

        .journal-heading {
            font-size: 13px;
        }

        .export-buttons .btn {
            font-size: 9px;
        }

    }
</style>


<div class="container-fluid py-4 px-lg-5">

    {{-- =================================
         1. AREA DASHBOARD
    ================================== --}}

    <div class="row g-4 mb-5">

        {{-- BANNER --}}

        <div class="col-lg-8">

            <div class="dash-card h-100">

                <div class="dash-banner">

                    <div style="position:relative;z-index:2;">

                        <h2 class="fw-bolder mb-2"
                            style="letter-spacing:-0.5px;">

                            Laporan Jurnal Siswa

                        </h2>

                        <p class="mb-0 fw-medium">

                            Pantau dan periksa jurnal harian siswa PKL dengan mudah.

                        </p>

                    </div>

                    <div class="banner-icon d-none d-md-flex">

                        <i class="bi bi-clipboard-check"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- TOTAL SISWA --}}

        <div class="col-lg-4">

            <div class="dash-card h-100">

                <div class="dash-total">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="fw-bold mb-1 text-uppercase"
                               style="color:#64748b;font-size:12px;letter-spacing:1px;">

                                Total Siswa PKL

                            </p>

                            <h1 class="fw-bolder mb-0"
                                style="color:#0f172a;font-size:48px;">

                                {{ $totalSiswa ?? 0 }}

                                <span class="fs-6 fw-semibold text-secondary ms-1">
                                    Siswa
                                </span>

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


    {{-- =================================
         2. AREA TABEL JURNAL
    ================================== --}}

    <div class="journal-card">

        {{-- HEADER DAN EKSPOR --}}

        <div class="journal-toolbar">

            <h5 class="journal-heading d-flex align-items-center gap-2">

                <i class="bi bi-journal-text text-primary fs-4"></i>

                Daftar Jurnal Siswa

            </h5>


            <div class="export-buttons">

                <a href="{{ route('guru.export.excel', ['bulan' => date('m'), 'tahun' => date('Y')]) }}"
                   class="btn btn-outline-success fw-semibold">

                    <i class="bi bi-file-earmark-excel me-1"></i>

                    Ekspor Excel

                </a>


                <a href="{{ route('guru.export.pdf', ['bulan' => date('m'), 'tahun' => date('Y')]) }}"
                   class="btn btn-outline-danger fw-semibold">

                    <i class="bi bi-file-earmark-pdf me-1"></i>

                    Ekspor PDF

                </a>

            </div>

        </div>


        {{-- TABEL RESPONSIF --}}

        <div class="table-wrapper">

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

                            {{-- TANGGAL --}}

                            <td class="text-secondary fw-medium text-nowrap">

                                {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}

                            </td>


                            {{-- NAMA SISWA --}}

                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div class="avatar-sm">

                                        {{ substr($jurnal->user->name ?? 'S', 0, 1) }}

                                    </div>

                                    <span class="fw-bold text-capitalize"
                                          style="color:#1e293b;">

                                        {{ $jurnal->user->name ?? 'Siswa' }}

                                    </span>

                                </div>

                            </td>


                            {{-- KEGIATAN --}}

                            <td class="text-secondary"
                                style="max-width:250px;white-space:normal;line-height:1.5;">

                                {{ $jurnal->kegiatan }}

                            </td>


                            {{-- KENDALA --}}

                            <td class="text-secondary"
                                style="max-width:200px;white-space:normal;line-height:1.5;">

                                {{ $jurnal->kendala ?? '-' }}

                            </td>


                            {{-- NILAI --}}

                            <td class="text-center">

                                @if($jurnal->nilai !== null)

                                    <span class="badge-nilai"
                                          style="background-color:#dcfce7;color:#16a34a;">

                                        {{ $jurnal->nilai }}

                                    </span>

                                @else

                                    <span class="badge-nilai"
                                          style="background-color:#f1f5f9;color:#64748b;">

                                        Belum

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            @if(Auth::user()->role === 'pembimbing')

                                <td class="text-end">

                                    <button type="button"
                                            class="btn-aksi d-inline-flex align-items-center gap-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalNilai{{ $jurnal->id }}">

                                        <i class="bi bi-pencil-square"></i>

                                        Beri Nilai

                                    </button>

                                </td>

                            @endif

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-50"></i>

                                Belum ada jurnal yang diisi oleh siswa.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PETUNJUK GESER HP --}}

        <div class="scroll-hint">

            <i class="bi bi-arrow-left-right"></i>

            Geser tabel ke samping untuk melihat kolom lainnya

        </div>

    </div>


    {{-- =================================
         3. MODAL PENILAIAN
         ================================== --}}

    @if(Auth::user()->role === 'pembimbing')

        @foreach($semuaJurnal as $jurnal)

            <div class="modal fade"
                 id="modalNilai{{ $jurnal->id }}"
                 tabindex="-1"
                 aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content shadow-lg">

                        <div class="modal-header border-bottom-0 pb-0">

                            <h5 class="modal-title fw-bold text-dark">

                                <i class="bi bi-pencil-square text-primary me-2"></i>

                                Penilaian Jurnal

                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">

                            </button>

                        </div>


                        <form action="{{ route('guru.nilai', $jurnal->id) }}"
                              method="POST">

                            @csrf

                            <div class="modal-body p-4">

                                <div class="mb-3 p-3 bg-light rounded-3">

                                    <span class="text-secondary small d-block mb-1">
                                        Siswa:
                                    </span>

                                    <strong class="text-dark">

                                        {{ $jurnal->user->name ?? 'Siswa' }}

                                    </strong>

                                    <span class="text-secondary mx-1">|</span>

                                    <span class="text-secondary">

                                        {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}

                                    </span>

                                </div>


                                <div class="mb-3">

                                    <label class="form-label fw-semibold text-secondary small">

                                        Nilai (0-100)

                                    </label>

                                    <input type="number"
                                           name="nilai"
                                           class="form-control form-control-lg fw-bold"
                                           min="0"
                                           max="100"
                                           value="{{ $jurnal->nilai }}"
                                           required
                                           placeholder="Contoh: 90">

                                </div>


                                <div class="mb-0">

                                    <label class="form-label fw-semibold text-secondary small">

                                        Catatan Guru / Ulasan

                                    </label>

                                    <textarea name="catatan_guru"
                                              class="form-control"
                                              rows="3"
                                              placeholder="Berikan ulasan atau masukan untuk siswa...">{{ $jurnal->catatan_guru }}</textarea>

                                </div>

                            </div>


                            <div class="modal-footer border-top-0 pt-0">

                                <button type="button"
                                        class="btn btn-light fw-semibold"
                                        data-bs-dismiss="modal">

                                    Batal
                                </button>

                                <button type="submit"
                                        class="btn btn-primary fw-semibold px-4 rounded-3">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Simpan Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection