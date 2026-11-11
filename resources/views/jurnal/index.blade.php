
@extends('layouts.app')

@section('content')

<style>
    /* =====================================
       TIMETRIX - JURNAL HARIAN PKL
    ===================================== */

    .jurnal-page {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto;
        padding: 15px;
        color: #243454;
        box-sizing: border-box;
    }

    .jurnal-page *,
    .jurnal-page *::before,
    .jurnal-page *::after {
        box-sizing: border-box;
    }

    /* BANNER */

    .jurnal-banner {
        position: relative;
        overflow: hidden;
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        border-radius: 18px;
        margin-bottom: 18px;
        box-shadow: 0 5px 16px rgba(14, 165, 233, .08);
    }

    .jurnal-banner-content {
        position: relative;
        z-index: 2;
        padding: 32px;
        padding-right: 130px;
    }

    .jurnal-banner-date {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: white;
        color: #0284c7;
        border: 1px solid #bae6fd;
        border-radius: 30px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .jurnal-banner h2 {
        color: #0f172a;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.3;
        margin: 0 0 7px;
    }

    .jurnal-banner p {
        color: #334155;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    .jurnal-banner-icon {
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 65px;
        color: #0284c7;
        opacity: .22;
        z-index: 1;
        pointer-events: none;
    }

    /* CARD UTAMA */

    .jurnal-card {
        background: white;
        border: 1px solid #e9edf5;
        border-radius: 17px;
        box-shadow: 0 5px 20px rgba(34, 53, 92, .05);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .jurnal-card-body {
        padding: 25px;
    }

    /* JUDUL FORM */

    .jurnal-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 23px;
    }

    .jurnal-heading-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #0284c7;
        border-radius: 12px;
        font-size: 22px;
    }

    .jurnal-heading h5 {
        font-size: 17px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 4px;
    }

    .jurnal-heading p {
        font-size: 12px;
        color: #8490a7;
        margin: 0;
        line-height: 1.5;
    }

    /* FORM INPUT */

    .jurnal-page .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
    }

    .jurnal-page .form-control {
        font-size: 13px;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #dce3ed;
        color: #334155;
    }

    .jurnal-page .form-control:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, .12);
        background: white;
    }

    .jurnal-page .input-group-text {
        font-size: 13px;
        border-color: #dce3ed;
        border-radius: 8px 0 0 8px;
    }

    .jurnal-page .form-text {
        font-size: 11px;
        color: #8490a7;
        line-height: 1.5;
        margin-top: 6px;
    }

    .jurnal-page textarea.form-control {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    .jurnal-page .input-group .form-control {
        border-radius: 0 8px 8px 0;
    }

    /* TOMBOL SIMPAN */

    .jurnal-submit {
        width: 100%;
        padding: 11px 15px;
        border: none;
        border-radius: 9px;
        background: #0284c7;
        color: white;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
        box-shadow: 0 4px 10px rgba(2, 132, 199, .15);
    }

    .jurnal-submit:hover {
        background: #0369a1;
        transform: translateY(-1px);
    }

    /* STATUS JURNAL */

    .jurnal-success-icon {
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        background: #dcfce7;
        color: #16a34a;
        border-radius: 50%;
        font-size: 32px;
    }

    .jurnal-status-title {
        font-size: 20px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 7px;
    }

    .jurnal-status-description {
        font-size: 13px;
        color: #8490a7;
    }

    .jurnal-detail {
        background: #f8fafc;
        border: 1px solid #edf0f5;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .jurnal-detail-label {
        display: block;
        color: #8490a7;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .jurnal-detail-content {
        color: #334155;
        font-size: 13px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    /* HEADER RIWAYAT */

    .jurnal-history-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 23px 13px;
    }

    .jurnal-history-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e0f2fe;
        color: #0284c7;
        border-radius: 11px;
        font-size: 20px;
        flex-shrink: 0;
    }

    .jurnal-history-header h5 {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .jurnal-history-header p {
        font-size: 11px;
        color: #8490a7;
        margin: 0;
        line-height: 1.5;
    }

    .jurnal-history-body {
        padding: 15px 23px 22px;
    }

    .jurnal-page .table {
        font-size: 12px;
        vertical-align: middle;
    }

    .jurnal-page .table thead th {
        background: #f0f9ff;
        color: #0369a1;
        font-size: 11px;
        font-weight: 700;
        padding: 13px 12px;
        white-space: nowrap;
    }

    .jurnal-page .table tbody td {
        padding: 13px 12px;
        color: #475569;
    }

    .jurnal-page .table-responsive {
        border-radius: 9px;
    }

    /* =====================================
       RESPONSIVE TABLET
    ===================================== */

    @media (max-width: 991px) {

        .jurnal-banner-content {
            padding: 27px;
            padding-right: 105px;
        }

        .jurnal-banner-icon {
            right: 20px;
            font-size: 58px;
        }
    }

    /* =====================================
       KHUSUS HP
    ===================================== */

    @media (max-width: 700px) {

        .jurnal-page {
            padding: 8px 11px;
            margin: 0 auto;
        }

        /* BANNER HP */

        .jurnal-banner {
            border-radius: 15px;
            margin-bottom: 14px;
        }

        .jurnal-banner-content {
            padding: 17px 15px;
            padding-right: 55px;
        }

        .jurnal-banner-date {
            font-size: 9px;
            padding: 5px 9px;
            gap: 5px;
            margin-bottom: 9px;
            max-width: 100%;
        }

        .jurnal-banner h2 {
            font-size: 18px;
            line-height: 1.35;
            margin-bottom: 6px;
            overflow-wrap: break-word;
        }

        .jurnal-banner p {
            font-size: 10px;
            line-height: 1.55;
        }

        .jurnal-banner-icon {
            right: 9px;
            top: 50%;
            font-size: 37px;
            opacity: .13;
        }

        /* CARD */

        .jurnal-card {
            border-radius: 14px;
            margin-bottom: 14px;
        }

        .jurnal-card-body {
            padding: 15px;
        }

        /* FORM HEADER */

        .jurnal-heading {
            gap: 10px;
            margin-bottom: 17px;
        }

        .jurnal-heading-icon {
            width: 39px;
            height: 39px;
            font-size: 18px;
            border-radius: 10px;
        }

        .jurnal-heading h5 {
            font-size: 14px;
            margin-bottom: 3px;
        }

        .jurnal-heading p {
            font-size: 10px;
            line-height: 1.5;
        }

        /* INPUT */

        .jurnal-page .form-label {
            font-size: 10px;
            margin-bottom: 6px;
        }

        .jurnal-page .form-control {
            font-size: 11px;
            padding: 9px 10px;
            border-radius: 7px;
        }

        .jurnal-page .input-group-text {
            font-size: 11px;
            padding: 8px 10px;
        }

        .jurnal-page .form-text {
            font-size: 9px;
            line-height: 1.5;
            margin-top: 5px;
        }

        .jurnal-page textarea.form-control {
            min-height: 85px;
            line-height: 1.5;
        }

        .jurnal-page .mb-3 {
            margin-bottom: 13px !important;
        }

        .jurnal-page .mb-4 {
            margin-bottom: 15px !important;
        }

        /* TOMBOL */

        .jurnal-submit {
            padding: 10px;
            font-size: 11px;
            border-radius: 8px;
        }

        /* STATUS */

        .jurnal-success-icon {
            width: 49px;
            height: 49px;
            font-size: 24px;
            margin-bottom: 11px;
        }

        .jurnal-status-title {
            font-size: 16px;
            line-height: 1.4;
        }

        .jurnal-status-description {
            font-size: 10px;
            line-height: 1.5;
        }

        .jurnal-detail {
            padding: 13px;
            border-radius: 10px;
            margin-top: 14px;
        }

        .jurnal-detail-label {
            font-size: 10px;
        }

        .jurnal-detail-content {
            font-size: 11px;
            line-height: 1.6;
        }

        /* RIWAYAT */

        .jurnal-history-header {
            padding: 14px 14px 9px;
            gap: 9px;
        }

        .jurnal-history-icon {
            width: 35px;
            height: 35px;
            font-size: 17px;
            border-radius: 9px;
        }

        .jurnal-history-header h5 {
            font-size: 13px;
            margin-bottom: 3px;
        }

        .jurnal-history-header p {
            font-size: 9px;
            line-height: 1.5;
        }

        .jurnal-history-body {
            padding: 10px 13px 15px;
        }

        .jurnal-page .table {
            font-size: 10px;
            min-width: 650px;
        }

        .jurnal-page .table thead th {
            font-size: 9px;
            padding: 10px;
        }

        .jurnal-page .table tbody td {
            padding: 10px;
        }

        .jurnal-page .table .badge {
            font-size: 9px;
            white-space: nowrap;
        }

        .jurnal-page .alert {
            font-size: 11px;
            padding: 12px;
            border-radius: 10px;
        }

        .jurnal-page .alert .fs-4 {
            font-size: 18px !important;
        }
    }

    /* HP KECIL */

    @media (max-width: 380px) {

        .jurnal-page {
            padding: 7px 9px;
        }

        .jurnal-banner-content {
            padding: 15px 12px;
            padding-right: 48px;
        }

        .jurnal-banner h2 {
            font-size: 16px;
        }

        .jurnal-banner p {
            font-size: 9px;
        }

        .jurnal-banner-icon {
            font-size: 32px;
            right: 7px;
        }

        .jurnal-card-body {
            padding: 12px;
        }

        .jurnal-heading h5 {
            font-size: 13px;
        }

        .jurnal-heading p {
            font-size: 9px;
        }

        .jurnal-page .form-control {
            font-size: 10px;
        }
    }
</style>


<div class="jurnal-page">

    <div class="container-fluid p-0">

        {{-- BANNER JURNAL --}}
        <div class="jurnal-banner">

            <div class="jurnal-banner-content">

                <div class="jurnal-banner-date">
                    <i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                </div>

                <h2>Jurnal Harian PKL</h2>

                <p>
                    Catat kegiatan harian Praktik Kerja Lapangan
                    Anda dengan mudah dan terstruktur.
                </p>

            </div>

            <i class="bi bi-journal-richtext jurnal-banner-icon"></i>

        </div>


        {{-- ALERT SUKSES --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>

                    <div>
                        <strong>Berhasil!</strong>
                        {{ session('success') }}
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>

        @endif


        {{-- ALERT ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">

                <div class="d-flex">

                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>

                    <div>

                        <strong>Periksa kembali data kamu:</strong>

                        <ul class="mb-0 mt-1 ps-3">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>

        @endif


        {{-- FORM / STATUS JURNAL --}}
        <div class="jurnal-card">

            <div class="jurnal-card-body">

                @if($jurnalHariIni)

                    {{-- JURNAL SUDAH TERISI --}}

                    <div class="text-center py-3">

                        <div class="jurnal-success-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <h4 class="jurnal-status-title">
                            Jurnal Hari Ini Sudah Terisi
                        </h4>

                        <p class="jurnal-status-description">
                            Terima kasih telah mencatat kegiatan PKL Anda hari ini.
                        </p>

                    </div>


                    <div class="jurnal-detail">

                        <div class="row g-3">

                            <div class="col-md-4">

                                <span class="jurnal-detail-label">
                                    Tanggal Jurnal
                                </span>

                                <div class="jurnal-detail-content fw-semibold">

                                    <i class="bi bi-calendar3 me-1" style="color:#0284c7;"></i>

                                    {{ \Carbon\Carbon::parse($jurnalHariIni->tanggal)->translatedFormat('d F Y') }}

                                </div>

                            </div>


                            <div class="col-12">

                                <hr class="text-muted opacity-25 my-2">

                                <span class="jurnal-detail-label">
                                    Kegiatan
                                </span>

                                <p class="jurnal-detail-content mb-0" style="white-space: pre-line;">
                                    {{ $jurnalHariIni->kegiatan }}
                                </p>

                            </div>


                            <div class="col-12">

                                <hr class="text-muted opacity-25 my-2">

                                <span class="jurnal-detail-label">
                                    Kendala
                                </span>

                                <p class="jurnal-detail-content mb-0">

                                    @if($jurnalHariIni->kendala)

                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $jurnalHariIni->kendala }}
                                        </span>

                                    @else

                                        <span class="text-success">
                                            <i class="bi bi-shield-check me-1"></i>
                                            Tidak ada kendala.
                                        </span>

                                    @endif

                                </p>

                            </div>

                        </div>

                    </div>

                @else

                    {{-- FORM INPUT JURNAL --}}

                    <div class="jurnal-heading">

                        <div class="jurnal-heading-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>

                        <div>

                            <h5>Form Input Jurnal</h5>

                            <p>
                                Silakan isi laporan kegiatan PKL Anda hari ini.
                            </p>

                        </div>

                    </div>


                    <form action="{{ url('/jurnal') }}" method="POST">

                        @csrf

                        {{-- TANGGAL --}}

                        <div class="mb-3">

                            <label class="form-label text-uppercase">
                                Pilih Tanggal Jurnal
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-light border-end-0 text-muted">
                                    <i class="bi bi-calendar-date"></i>
                                </span>

                                <input
                                    type="date"
                                    name="tanggal"
                                    class="form-control bg-light border-start-0"
                                    value="{{ old('tanggal', date('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}"
                                    required
                                >

                            </div>

                            <div class="form-text">
                                Anda bisa memilih tanggal hari ini atau tanggal sebelumnya jika belum mengisi.
                            </div>

                        </div>


                        {{-- KEGIATAN --}}

                        <div class="mb-3">

                            <label class="form-label text-uppercase" for="kegiatan">

                                Apa saja kegiatan Anda hari ini?

                                <span class="text-danger">*</span>

                            </label>

                            <textarea
                                id="kegiatan"
                                name="kegiatan"
                                class="form-control bg-light"
                                rows="4"
                                placeholder="Contoh: Membuat desain UI untuk halaman login menggunakan Figma..."
                                required
                            >{{ old('kegiatan') }}</textarea>

                        </div>


                        {{-- KENDALA --}}

                        <div class="mb-4">

                            <label class="form-label text-uppercase" for="kendala">

                                Apakah ada kendala?

                                <span class="text-muted fw-normal">(Opsional)</span>

                            </label>

                            <textarea
                                id="kendala"
                                name="kendala"
                                class="form-control bg-light"
                                rows="2"
                                placeholder="Contoh: Kesulitan menghubungkan database ke Laravel..."
                            >{{ old('kendala') }}</textarea>

                        </div>


                        {{-- SIMPAN --}}

                        <button type="submit" class="jurnal-submit">

                            <i class="bi bi-send-fill me-2"></i>

                            Simpan Jurnal Hari Ini

                        </button>

                    </form>

                @endif

            </div>

        </div>


        {{-- RIWAYAT JURNAL --}}
        <div class="jurnal-card">

            <div class="jurnal-history-header">

                <div class="jurnal-history-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>

                    <h5>Riwayat Jurnal Anda</h5>

                    <p>
                        Daftar seluruh jurnal kegiatan PKL yang pernah Anda kirim.
                    </p>

                </div>

            </div>


            <div class="jurnal-history-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="text-uppercase">

                            <tr>

                                <th class="rounded-start border-0">
                                    Tanggal
                                </th>

                                <th class="border-0">
                                    Kegiatan
                                </th>

                                <th class="border-0">
                                    Kendala
                                </th>

                                <th class="rounded-end border-0">
                                    Nilai &amp; Catatan Guru
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($riwayatJurnal as $jurnal)

                                <tr>

                                    <td class="fw-semibold text-nowrap">

                                        <div class="text-dark">

                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}

                                        </div>

                                    </td>


                                    <td>

                                        <div class="text-dark text-wrap" style="min-width:200px;">

                                            {{ $jurnal->kegiatan }}

                                        </div>

                                    </td>


                                    <td>

                                        <span class="text-muted">

                                            {{ $jurnal->kendala ?? '-' }}

                                        </span>

                                    </td>


                                    <td>

                                        @if($jurnal->nilai)

                                            <div class="d-flex flex-column align-items-start">

                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 mb-1 fw-semibold">

                                                    <i class="bi bi-star-fill me-1"></i>

                                                    Nilai: {{ $jurnal->nilai }}

                                                </span>


                                                @if($jurnal->catatan_guru)

                                                    <small class="text-muted fst-italic">

                                                        “{{ $jurnal->catatan_guru }}”

                                                    </small>

                                                @endif

                                            </div>

                                        @else

                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1">

                                                <i class="bi bi-hourglass-split me-1"></i>

                                                Belum Dinilai

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">

                                        <div class="py-3">

                                            <i class="bi bi-folder2-open display-6 text-muted opacity-50 mb-2 d-block"></i>

                                            Belum ada riwayat jurnal yang tercatat.

                                        </div>

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

@endsection
