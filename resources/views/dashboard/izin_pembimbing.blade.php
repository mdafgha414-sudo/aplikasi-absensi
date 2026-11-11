
@extends('layouts.app')

@section('content')

<style>
/* =====================================================
   PENGATURAN DASAR
===================================================== */

body {
    background-color: #f8fafc;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.inbox-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* =====================================================
   HEADER
===================================================== */

.inbox-header {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    border: 1px solid #f1f5f9;
}

.inbox-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 4px;
}

.inbox-subtitle {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

/* =====================================================
   TOOLBAR PENCARIAN DAN FILTER
===================================================== */

.inbox-toolbar {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
    align-items: center;
}

.inbox-search {
    position: relative;
    flex: 1;
    min-width: 200px;
}

.inbox-search i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.inbox-search input {
    width: 100%;
    padding: 10px 16px 10px 42px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    outline: none;
    font-size: 13px;
    background: #f8fafc;
    transition: all 0.2s;
}

.inbox-search input:focus {
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.filter-group select {
    padding: 10px 16px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    outline: none;
    background: #f8fafc;
    font-size: 13px;
    color: #475569;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s;
}

.filter-group select:focus {
    border-color: #3b82f6;
    background: white;
}

/* =====================================================
   TOMBOL TOOLBAR
===================================================== */

.btn-toolbar-primary {
    background: #0f172a;
    color: white;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    padding: 10px 20px;
    border: none;
    transition: 0.2s;
    text-decoration: none;
    text-align: center;
}

.btn-toolbar-primary:hover {
    background: #334155;
    color: white;
}

.btn-toolbar-secondary {
    background: white;
    border: 1px solid #e2e8f0;
    color: #475569;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    padding: 10px 16px;
    transition: 0.2s;
    text-decoration: none;
    text-align: center;
}

.btn-toolbar-secondary:hover {
    background: #f1f5f9;
    color: #1e293b;
}

/* =====================================================
   FILTER TANGGAL
===================================================== */

.quick-filter {
    display: inline-flex;
    padding: 6px 14px;
    border-radius: 50px;
    border: 1px solid transparent;
    background: transparent;
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
}

.quick-filter:hover {
    background: #f1f5f9;
    color: #1e293b;
}

.quick-filter.active {
    background: #eff6ff;
    color: #2563eb;
    border-color: #bfdbfe;
}

.input-month-custom {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-size: 12px;
    color: #475569;
    outline: none;
}

/* =====================================================
   KARTU PENGAJUAN IZIN
===================================================== */

.approval-card {
    background: white;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    transition: all 0.2s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    position: relative;
    overflow: hidden;
}

.approval-card:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    border-color: #e2e8f0;
    transform: translateY(-2px);
}

/* GARIS AKSEN */

.approval-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
}

.approval-card.card-menunggu::before {
    background: #f59e0b;
}

.approval-card.card-disetujui::before {
    background: #10b981;
}

.approval-card.card-ditolak::before {
    background: #ef4444;
}

/* =====================================================
   INFORMASI SISWA
===================================================== */

.student-info {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
    min-width: 0;
}

.student-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #f8fafc;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
}

.student-details {
    min-width: 0;
    flex: 1;
}

.student-details h5 {
    margin: 0 0 4px;
    font-weight: 700;
    color: #1e293b;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.student-details .meta {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.student-details .reason {
    font-size: 13px;
    color: #475569;
    margin: 0;
    background: #f8fafc;
    padding: 8px 12px;
    border-radius: 8px;
    border-left: 3px solid #cbd5e1;
    overflow-wrap: anywhere;
}

/* =====================================================
   BADGE JENIS IZIN
===================================================== */

.badge-jenis {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.badge-sakit {
    background: #fef9c3;
    color: #854d0e;
}

.badge-izin {
    background: #dbeafe;
    color: #1e40af;
}

/* =====================================================
   TOMBOL AKSI
===================================================== */

.action-buttons {
    display: flex;
    gap: 10px;
    flex-shrink: 0;
    align-items: center;
}

.action-buttons form {
    margin: 0;
}

.btn-approve {
    background: white;
    color: #059669;
    border: 1px solid #a7f3d0;
    padding: 8px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}

.btn-approve:hover {
    background: #ecfdf5;
    border-color: #10b981;
}

.btn-reject {
    background: white;
    color: #e11d48;
    border: 1px solid #fecdd3;
    padding: 8px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}

.btn-reject:hover {
    background: #fff1f2;
    border-color: #f43f5e;
}

/* =====================================================
   STATUS AKHIR
===================================================== */

.status-badge {
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}

.status-disetujui {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.status-ditolak {
    background: #fff1f2;
    color: #be123c;
    border: 1px solid #fecdd3;
}


/* =====================================================
   RESPONSIVE TABLET
===================================================== */

@media (max-width: 992px) {

    .approval-card {
        gap: 15px;
    }

    .student-info {
        gap: 12px;
    }

    .action-buttons {
        gap: 7px;
    }

}


/* =====================================================
   RESPONSIVE HP
===================================================== */

@media (max-width: 768px) {

    /* CONTAINER UTAMA */

    .container-fluid {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    .inbox-container {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /* HEADER */

    .inbox-header {
        padding: 18px;
        border-radius: 16px;
        margin-bottom: 18px;
    }

    .inbox-title {
        font-size: 19px;
        line-height: 1.4;
    }

    .inbox-subtitle {
        font-size: 12px;
        line-height: 1.6;
    }

    /* BADGE MENUNGGU */

    .inbox-header > .d-flex {
        align-items: flex-start !important;
        gap: 12px !important;
    }

    /* PENCARIAN */

    .inbox-toolbar {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 10px;
        margin-top: 18px;
        align-items: stretch;
    }

    .inbox-search {
        grid-column: 1 / -1;
        width: 100%;
        min-width: 0;
    }

    .inbox-search input {
        width: 100%;
        height: 46px;
        font-size: 13px;
    }

    /* DROPDOWN STATUS */

    .filter-group {
        width: 100%;
        min-width: 0;
    }

    .filter-group select {
        width: 100%;
        height: 46px;
        padding: 8px 10px;
        font-size: 12px;
    }

    /* TOMBOL CARI DAN RESET */

    .btn-toolbar-primary,
    .btn-toolbar-secondary {
        min-height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        font-size: 12px;
    }

    /* FILTER WAKTU */

    .inbox-header > .mt-3 {
        display: flex;
        flex-wrap: wrap;
        gap: 8px !important;
        align-items: center;
    }

    .quick-filter {
        padding: 9px 11px;
        font-size: 11px;
        min-height: 36px;
    }

    /* FORM PILIH BULAN */

    .inbox-header > .mt-3 > form {
        width: 100%;
        margin: 8px 0 0 !important;
        display: flex;
        gap: 8px;
    }

    .input-month-custom {
        flex: 1;
        min-width: 0;
        width: 100%;
        height: 40px;
    }

    .inbox-header > .mt-3 > form button {
        min-width: 75px;
        height: 40px;
    }

    /* KARTU PENGAJUAN */

    .approval-card {
        width: 100%;
        min-width: 0;
        padding: 18px 14px 16px 18px;
        margin-bottom: 12px;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        overflow: hidden;
    }

    /* INFORMASI SISWA */

    .student-info {
        width: 100%;
        min-width: 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .student-avatar {
        width: 44px;
        height: 44px;
        min-width: 44px;
        font-size: 16px;
        border-radius: 11px;
        margin-top: 2px;
    }

    .student-details {
        width: 100%;
        min-width: 0;
        flex: 1;
    }

    .student-details h5 {
        font-size: 14px;
        line-height: 1.5;
        gap: 7px;
        margin-bottom: 8px;
        overflow-wrap: anywhere;
    }

    /* TANGGAL DAN WAKTU */

    .student-details .meta {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
        font-size: 11px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .student-details .meta > span {
        display: block;
        max-width: 100%;
        overflow-wrap: anywhere;
    }

    .student-details .meta > .text-muted {
        display: none;
    }

    /* ALASAN IZIN */

    .student-details .reason {
        width: 100%;
        font-size: 12px;
        line-height: 1.6;
        padding: 10px 12px;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    /* LAMPIRAN */

    .student-details > a {
        font-size: 11px !important;
        margin-top: 10px !important;
    }

    /* TOMBOL SETUJUI DAN TOLAK */

    .action-buttons {
        width: 100%;
        display: flex;
        gap: 10px;
        flex-shrink: 1;
        padding-left: 56px;
        align-items: center;
    }

    .action-buttons form {
        flex: 1;
        min-width: 0;
        width: 50%;
    }

    .btn-approve,
    .btn-reject {
        width: 100%;
        min-height: 42px;
        padding: 9px 8px;
        font-size: 12px;
        justify-content: center;
    }

    /* STATUS YANG SUDAH DIPROSES */

    .action-buttons > .status-badge {
        min-height: 36px;
        font-size: 11px;
    }

    /* NOTIFIKASI */

    .alert {
        font-size: 12px !important;
        line-height: 1.5;
    }

}


/* =====================================================
   RESPONSIVE HP KECIL
===================================================== */

@media (max-width: 400px) {

    .inbox-header {
        padding: 15px;
    }

    .inbox-title {
        font-size: 17px;
    }

    .inbox-subtitle {
        font-size: 11px;
    }

    .inbox-toolbar {
        gap: 8px;
    }

    .filter-group select {
        font-size: 11px;
        padding-left: 8px;
        padding-right: 5px;
    }

    .btn-toolbar-primary,
    .btn-toolbar-secondary {
        padding: 9px 12px;
        font-size: 11px;
    }

    .approval-card {
        padding: 16px 11px 14px 15px;
    }

    .student-info {
        gap: 10px;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        min-width: 40px;
    }

    .student-details h5 {
        font-size: 13px;
    }

    .student-details .meta {
        font-size: 10px;
    }

    .action-buttons {
        padding-left: 50px;
        gap: 7px;
    }

    .btn-approve,
    .btn-reject {
        font-size: 11px;
        padding: 8px 5px;
    }

    .quick-filter {
        font-size: 10px;
        padding: 8px 9px;
    }

}


/* =====================================================
   MENCEGAH HALAMAN MELEBAR DI HP
===================================================== */

@media (max-width: 768px) {

    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    .inbox-container,
    .inbox-header,
    .approval-card {
        box-sizing: border-box;
    }

    .student-info,
    .student-details,
    .inbox-search {
        box-sizing: border-box;
    }

    .approval-card:hover {
        transform: none;
    }

}

</style>


<div class="container-fluid py-4 px-lg-5">

    <div class="inbox-container">

        {{-- HEADER DAN TOOLBAR --}}

        <div class="inbox-header">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                <div>
                    <h4 class="inbox-title">
                        Persetujuan Izin Siswa
                    </h4>

                    <p class="inbox-subtitle">
                        Kelola pengajuan izin, lihat alasan, dan berikan keputusan.
                    </p>
                </div>

                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3 py-2"
                      style="font-size: 12px; font-weight: 700;">

                    <i class="bi bi-clock-history me-1"></i>
                    {{ $jumlahMenunggu }} Menunggu

                </span>

            </div>


            {{-- FORM PENCARIAN DAN FILTER --}}

            <form action="/pembimbing/izin" method="GET" class="inbox-toolbar">

                <div class="inbox-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama siswa..."
                    >

                </div>


                <div class="filter-group">

                    <select name="status" onchange="this.form.submit()">

                        <option value="Semua" {{ request('status') == 'Semua' || !request('status') ? 'selected' : '' }}>
                            Semua Status
                        </option>

                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>
                            Disetujui
                        </option>

                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>

                    </select>

                </div>


                <button type="submit" class="btn-toolbar-primary">
                    Cari
                </button>

                <a href="/pembimbing/izin" class="btn-toolbar-secondary">
                    Reset
                </a>

            </form>


            {{-- FILTER TANGGAL --}}

            <div class="mt-3 pt-3 border-top border-light d-flex gap-2 flex-wrap align-items-center">

                <a href="/pembimbing/izin?waktu=semua"
                   class="quick-filter {{ request('waktu') == 'semua' || !request('waktu') ? 'active' : '' }}">
                    Semua Waktu
                </a>

                <a href="/pembimbing/izin?waktu=hari_ini"
                   class="quick-filter {{ request('waktu') == 'hari_ini' ? 'active' : '' }}">
                    Hari Ini
                </a>

                <a href="/pembimbing/izin?waktu=7_hari"
                   class="quick-filter {{ request('waktu') == '7_hari' ? 'active' : '' }}">
                    7 Hari Terakhir
                </a>

                <a href="/pembimbing/izin?waktu=bulan_ini"
                   class="quick-filter {{ request('waktu') == 'bulan_ini' ? 'active' : '' }}">
                    Bulan Ini
                </a>

                <a href="/pembimbing/izin?waktu=bulan_lalu"
                   class="quick-filter {{ request('waktu') == 'bulan_lalu' ? 'active' : '' }}">
                    Bulan Lalu
                </a>


                {{-- FILTER BULAN --}}

                <form action="/pembimbing/izin"
                      method="GET"
                      class="d-flex gap-2 ms-auto mt-2 mt-sm-0 align-items-center">

                    <input type="hidden" name="waktu" value="pilih_bulan">

                    <input
                        type="month"
                        name="bulan_filter"
                        value="{{ request('bulan_filter') }}"
                        class="input-month-custom"
                    >

                    <button type="submit"
                            class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                            style="font-size: 12px; font-weight: 600;">
                        Lihat
                    </button>

                </form>

            </div>

        </div>


        {{-- NOTIFIKASI BERHASIL --}}

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm mb-4 rounded-3 d-flex align-items-center gap-2"
                 style="font-size: 13px;">

                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}

            </div>

        @endif


        {{-- DAFTAR PENGAJUAN IZIN --}}

        @forelse($semuaIzin as $izin)

            @php

                $cardClass = '';

                if($izin->status == 'Menunggu') {
                    $cardClass = 'card-menunggu';
                } elseif($izin->status == 'Disetujui') {
                    $cardClass = 'card-disetujui';
                } elseif($izin->status == 'Ditolak') {
                    $cardClass = 'card-ditolak';
                }

            @endphp


            <div class="approval-card {{ $cardClass }}">

                {{-- INFORMASI SISWA --}}

                <div class="student-info">

                    <div class="student-avatar">

                        {{ strtoupper(substr($izin->user->name ?? '?', 0, 1)) }}

                    </div>


                    <div class="student-details">

                        <h5>

                            {{ $izin->user->name ?? 'Siswa' }}

                            <span class="badge-jenis {{ strtolower($izin->jenis_izin) == 'sakit' ? 'badge-sakit' : 'badge-izin' }}">

                                {{ $izin->jenis_izin }}

                            </span>

                        </h5>


                        {{-- TANGGAL DAN WAKTU --}}

                        <div class="meta">

                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                Izin: {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}
                            </span>

                            <span class="text-muted">•</span>

                            <span>
                                <i class="bi bi-clock me-1"></i>
                                Diajukan: {{ $izin->created_at->format('d M Y H:i') }}
                            </span>

                        </div>


                        {{-- ALASAN IZIN --}}

                        <p class="reason">
                            "{{ $izin->alasan }}"
                        </p>


                        {{-- LAMPIRAN --}}

                        @if($izin->lampiran)

                            <a href="{{ asset('storage/' . $izin->lampiran) }}"
                               target="_blank"
                               class="small text-decoration-none fw-bold text-primary mt-2 d-inline-flex align-items-center gap-1"
                               style="font-size: 12px;">

                                <i class="bi bi-paperclip"></i>
                                Lihat Lampiran

                            </a>

                        @endif

                    </div>

                </div>


                {{-- TOMBOL AKSI --}}

                <div class="action-buttons">

                    @if($izin->status == 'Menunggu')

                        {{-- SETUJUI --}}

                        <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">

                            @csrf
                            @method('PUT')

                            <input type="hidden" name="status" value="Disetujui">

                            <button type="submit" class="btn-approve">

                                <i class="bi bi-check2"></i>
                                Setujui

                            </button>

                        </form>


                        {{-- TOLAK --}}

                        <form action="/pembimbing/izin/{{ $izin->id }}" method="POST">

                            @csrf
                            @method('PUT')

                            <input type="hidden" name="status" value="Ditolak">

                            <button type="submit" class="btn-reject">

                                <i class="bi bi-x"></i>
                                Tolak

                            </button>

                        </form>

                    @else

                        {{-- STATUS AKHIR --}}

                        <span class="status-badge {{ $izin->status == 'Disetujui' ? 'status-disetujui' : 'status-ditolak' }}">

                            <i class="bi {{ $izin->status == 'Disetujui' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>

                            {{ $izin->status }}

                        </span>

                    @endif

                </div>

            </div>


        @empty

            {{-- JIKA TIDAK ADA DATA --}}

            <div class="text-center py-5 text-muted bg-white rounded-4 border"
                 style="border-color: #f1f5f9 !important; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">

                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 64px; height: 64px;">

                    <i class="bi bi-inbox fs-2 text-secondary"></i>

                </div>

                <h5 class="fw-bold text-dark" style="font-size: 15px;">
                    Tidak Ada Data
                </h5>

                <p class="mb-0" style="font-size: 13px;">
                    Tidak ada pengajuan izin yang sesuai dengan filter Anda.
                </p>

            </div>

        @endforelse


        {{-- PAGINATION --}}

        @if($semuaIzin->hasPages())

            <div class="d-flex justify-content-center mt-4">

                {{ $semuaIzin->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
