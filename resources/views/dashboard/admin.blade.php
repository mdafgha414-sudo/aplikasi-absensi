@extends('layouts.app')

@section('content')

<style>
    :root {
    --admin-primary: #7da7d9;
    --admin-primary-dark: #5f8fc9;
    --admin-bg: #f7faff;
    --admin-text: #40516a;
    --admin-muted: #91a0b5;
    --admin-border: #e8eef6;
}

.admin-dashboard {
    color: var(--admin-text);
    padding: 10px 0 30px;
}

/* HEADER */
.admin-dashboard .page-title {
    font-size: 1.65rem;
    font-weight: 700;
    letter-spacing: -.5px;
    color: #40516a;
}

.admin-dashboard .page-subtitle {
    color: #91a0b5;
    font-size: .9rem;
}

/* Badge admin */
.admin-dashboard .badge.text-bg-primary {
    background: #eaf2fc !important;
    color: #638fc5 !important;
    font-weight: 600;
    letter-spacing: .3px;
}

/* KARTU STATISTIK */
.stat-card {
    position: relative;
    overflow: hidden;
    border: 1px solid #eaf0f8;
    border-radius: 20px;
    background: #fff;
    padding: 24px;
    height: 100%;
    box-shadow: 0 3px 15px rgba(82, 125, 180, .035);
    transition: border-color .2s ease;
    --stat-color: #739ed1;
    --stat-soft: #edf4fd;
}

.stat-card:hover {
    border-color: #d8e6f7;
}

.stat-card::after {
    content: "";
    position: absolute;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    right: -35px;
    top: -35px;
    background: var(--stat-soft);
    opacity: .8;
}

.stat-icon {
    position: relative;
    z-index: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 15px;
    background: var(--stat-soft);
    color: var(--stat-color);
    font-size: 1.25rem;
}

.stat-label {
    color: #91a0b5;
    font-size: .84rem;
    font-weight: 500;
    margin-top: 18px;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.9rem;
    font-weight: 700;
    letter-spacing: -.7px;
    margin: 0;
    color: #40516a;
}

/* NAVIGASI TAB */
.admin-tabs {
    display: flex;
    gap: 8px;
    border: 1px solid #eaf0f8;
    padding: 6px;
    background: #f0f5fc;
    border-radius: 15px;
    width: fit-content;
    max-width: 100%;
}

.admin-tabs .nav-link {
    border: 0;
    border-radius: 11px;
    padding: 11px 18px;
    color: #8b9bb2;
    font-size: .88rem;
    font-weight: 500;
    white-space: nowrap;
    transition: background .2s ease, color .2s ease;
}

.admin-tabs .nav-link:hover {
    color: #628fc7;
}

.admin-tabs .nav-link.active {
    background: #fff;
    color: #628fc7;
    box-shadow: 0 2px 8px rgba(82, 125, 180, .06);
}

/* PANEL */
.admin-panel {
    background: #fff;
    border: 1px solid #eaf0f7;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(82, 125, 180, .025);
}

.admin-panel-header {
    padding: 24px 26px;
    border-bottom: 1px solid #eff3f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.admin-panel-title {
    font-size: 1.02rem;
    font-weight: 700;
    margin: 0;
    color: #50617a;
}

.admin-panel-title .text-primary {
    color: #7da7d9 !important;
}

.admin-panel-description {
    color: #9aa9bd;
    font-size: .82rem;
    margin: 6px 0 0;
}

.admin-panel-body {
    padding: 24px 26px;
}

/* TOMBOL TAMBAH */
.btn-add-employee {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 11px;
    background: #e8f1fc;
    border: 1px solid #e8f1fc;
    color: #5f8fc9;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s ease;
}

.btn-add-employee:hover {
    background: #dceafb;
    border-color: #dceafb;
    color: #4d7eb9;
}

/* TOMBOL AKSI */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border-radius: 9px;
    padding: 7px 11px;
    font-size: .79rem;
    font-weight: 500;
    transition: background .2s ease;
}

/* Edit: biru muda */
.btn-outline-warning {
    color: #648fc3 !important;
    border-color: #dce9f8 !important;
    background: #f4f8fe !important;
}

.btn-outline-warning:hover {
    color: #507eb5 !important;
    background: #e7f0fc !important;
}

/* Hapus: merah lembut */
.btn-outline-danger {
    color: #c18491 !important;
    border-color: #f1e1e6 !important;
    background: #fff8f9 !important;
}

.btn-outline-danger:hover {
    color: #ad6b7b !important;
    background: #f9eaee !important;
}

/* TABEL */
.admin-table {
    margin: 0;
    vertical-align: middle;
    min-width: 650px;
}

.admin-table thead th {
    background: #f8faff;
    color: #91a1b7;
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .6px;
    text-transform: uppercase;
    padding: 15px 18px;
    border-bottom: 1px solid #eaf0f7;
    white-space: nowrap;
}

.admin-table tbody td {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5fa;
    color: #718198;
    font-size: .85rem;
}

.admin-table tbody tr:last-child td {
    border-bottom: 0;
}

.admin-table tbody tr {
    transition: background .2s ease;
}

.admin-table tbody tr:hover {
    background: #fafdff;
}

/* AVATAR PENGGUNA */
.employee-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    border-radius: 13px;
    background: #edf4fd;
    color: #729bd0;
    font-weight: 600;
    font-size: .88rem;
}

.employee-name {
    font-weight: 600;
    color: #52627a;
    margin-bottom: 2px;
}

.employee-email {
    font-size: .77rem;
    color: #a0aec0;
}

.table-number {
    color: #a4b1c3;
    font-weight: 500;
}

/* BADGE STATUS ABSENSI */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 10px;
    border-radius: 9px;
    font-size: .74rem;
    font-weight: 500;
    white-space: nowrap;
}

.status-success {
    color: #679b83;
    background: #edf7f0;
}

.status-late {
    color: #bd7d87;
    background: #fcf0f1;
}

.status-warning {
    color: #9d8a61;
    background: #fbf6e9;
}

.status-neutral {
    color: #8b9bb0;
    background: #f1f5fa;
}

/* DATA KOSONG */
.empty-state {
    text-align: center;
    padding: 48px 20px !important;
}

.empty-state-icon {
    display: inline-flex;
    width: 58px;
    height: 58px;
    justify-content: center;
    align-items: center;
    border-radius: 18px;
    background: #eff5fd;
    color: #91afd8;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.empty-state-title {
    font-weight: 600;
    color: #5c6d84;
    margin-bottom: 5px;
}

.empty-state-text {
    color: #9baabd;
    font-size: .83rem;
    margin: 0;
}

/* PAGINATION */
.admin-pagination {
    padding-top: 22px;
    border-top: 1px solid #f0f4f9;
    margin-top: 10px;
}

.admin-pagination nav {
    display: flex;
    justify-content: flex-end;
}

.admin-pagination .pagination {
    gap: 5px;
    margin-bottom: 0;
    flex-wrap: wrap;
}

.admin-pagination .page-link {
    border: 1px solid #e7eef7;
    border-radius: 9px !important;
    color: #8294ad;
    font-size: .82rem;
    padding: 8px 12px;
    background: #fff;
}

.admin-pagination .page-link:hover {
    background: #f0f6fd;
    color: #628fc7;
}

.admin-pagination .page-item.active .page-link {
    background: #e6f0fc;
    border-color: #e6f0fc;
    color: #5d88be;
}

.admin-pagination .page-item.disabled .page-link {
    color: #cbd5e1;
}

/* NOTIFIKASI */
.admin-alert {
    border-radius: 12px;
    padding: 14px 17px;
    font-size: .86rem;
}

/* RESPONSIF */
@media (max-width: 767.98px) {
    .admin-dashboard .page-title {
        font-size: 1.4rem;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-value {
        font-size: 1.7rem;
    }

    .admin-tabs {
        width: 100%;
    }

    .admin-tabs .nav-item {
        flex: 1;
    }

    .admin-tabs .nav-link {
        width: 100%;
        padding: 11px 8px;
        font-size: .76rem;
    }

    .admin-panel-header {
        padding: 20px;
    }

    .admin-panel-body {
        padding: 17px;
    }

    .admin-panel-header .btn-add-employee {
        width: 100%;
        justify-content: center;
    }

    .admin-pagination nav {
        justify-content: center;
    }
}
</style>

<div class="admin-dashboard">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                    <i class="bi bi-grid-1x2-fill me-1"></i>
                    ADMIN PANEL
                </span>
            </div>

            <h2 class="page-title mb-1">Dashboard Admin</h2>

            <p class="page-subtitle mb-0">
                Kelola data pengguna dan pantau laporan absensi.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-shield-check text-primary fs-5"></i>
            <span>Sistem Manajemen Pengguna</span>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stat-card"
                 style="--stat-color:#4f46e5; --stat-soft:#eef2ff;">

                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <span class="badge rounded-pill text-bg-light text-primary">
                        <i class="bi bi-graph-up-arrow me-1"></i>
                        Total
                    </span>
                </div>

                <p class="stat-label">Total Pengguna</p>

                <h3 class="stat-value">
                    {{ $totalUser }}
                    <span class="fs-6 fw-semibold text-muted">Orang</span>
                </h3>

                <p class="small text-muted mb-0 mt-2">
                    <i class="bi bi-person-check me-1"></i>
                    Data pengguna terdaftar
                </p>
            </div>
        </div>

    </div>

    {{-- NAVIGASI TAB --}}
    <ul class="nav nav-tabs admin-tabs mb-4"
        id="adminTab"
        role="tablist">

        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="pengguna-tab"
                data-bs-toggle="tab"
                data-bs-target="#pengguna"
                type="button"
                role="tab"
                aria-controls="pengguna"
                aria-selected="true">

                <i class="bi bi-people-fill me-2"></i>
                Manajemen Pengguna
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="absensi-tab"
                data-bs-toggle="tab"
                data-bs-target="#absensi"
                type="button"
                role="tab"
                aria-controls="absensi"
                aria-selected="false">

                <i class="bi bi-calendar2-check-fill me-2"></i>
                Laporan Absensi
            </button>
        </li>

    </ul>

    {{-- KONTEN TAB --}}
    <div class="tab-content" id="adminTabContent">

        {{-- TAB 1: MANAJEMEN PENGGUNA --}}
        <div
            class="tab-pane fade show active"
            id="pengguna"
            role="tabpanel"
            aria-labelledby="pengguna-tab">

            <div class="admin-panel">

                <div class="admin-panel-header">
                    <div>
                        <h5 class="admin-panel-title">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>
                            Daftar Pengguna
                        </h5>

                        <p class="admin-panel-description">
                            Informasi dan pengelolaan data Siswa & Guru.
                        </p>
                    </div>

                    <a href="{{ url('/admin/tambah-user') }}"
                       class="btn-add-employee">

                        <i class="bi bi-person-plus-fill"></i>
                        Tambah Pengguna
                    </a>
                </div>

                <div class="admin-panel-body">

                    {{-- NOTIFIKASI --}}
                    @if(session('success'))
                        <div class="alert alert-success admin-alert border-0 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger admin-alert border-0 mb-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table admin-table">

                            <thead>
                                <tr>
                                    <th width="70">No.</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center" style="min-width:190px;">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Menggunakan variabel $semuaPengguna dari Controller --}}
                                @forelse ($semuaPengguna as $index => $pengguna)

                                    <tr>
                                        <td class="table-number">
                                            {{ $semuaPengguna->firstItem() + $index }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-3">

                                                <div class="employee-avatar">
                                                    {{ strtoupper(substr($pengguna->name, 0, 1)) }}
                                                </div>

                                                <div>
                                                    <div class="employee-name">
                                                        {{ $pengguna->name }}
                                                    </div>

                                                    <div class="employee-email">
                                                        ID Pengguna #{{ $pengguna->id }}
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <span>
                                                <i class="bi bi-envelope me-2 text-muted"></i>
                                                {{ $pengguna->email }}
                                            </span>
                                        </td>

                                        <td>
                                            {{-- Menampilkan Role --}}
                                            @if($pengguna->role == 'guru')
                                                <span class="badge rounded-pill" style="background-color: #e0f2fe; color: #0369a1;">Guru</span>
                                            @else
                                                <span class="badge rounded-pill" style="background-color: #f1f5f9; color: #475569;">Siswa</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                                <a
                                                    href="{{ url('/admin/edit-user/' . $pengguna->id) }}"
                                                    class="btn btn-outline-warning btn-action">

                                                    <i class="bi bi-pencil-square"></i>
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ url('/admin/hapus-user/' . $pengguna->id) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-action">

                                                        <i class="bi bi-trash3"></i>
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="empty-state">

                                            <div class="empty-state-icon">
                                                <i class="bi bi-people"></i>
                                            </div>

                                            <div class="empty-state-title">
                                                Belum Ada Pengguna
                                            </div>

                                            <p class="empty-state-text">
                                                Data pengguna yang terdaftar akan muncul di sini.
                                            </p>

                                        </td>
                                    </tr>

                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- PAGINATION PENGGUNA --}}
                    @if($semuaPengguna->hasPages())
                        <div class="admin-pagination">
                            {{ $semuaPengguna->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- TAB 2: LAPORAN ABSENSI --}}
        <div
            class="tab-pane fade"
            id="absensi"
            role="tabpanel"
            aria-labelledby="absensi-tab">

            <div class="admin-panel">

                <div class="admin-panel-header">
                    <div>
                        <h5 class="admin-panel-title">
                            <i class="bi bi-calendar2-week-fill text-primary me-2"></i>
                            Laporan Absensi
                        </h5>

                        <p class="admin-panel-description">
                            Pantau waktu masuk, waktu pulang, dan status kehadiran pengguna.
                        </p>
                    </div>

                    <span class="badge rounded-pill text-bg-light text-primary px-3 py-2">
                        <i class="bi bi-clipboard-data me-1"></i>
                        Data Absensi
                    </span>
                </div>

                <div class="admin-panel-body">

                    <div class="table-responsive">
                        <table class="table admin-table">

                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pengguna</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($semuaAbsensi as $index => $absen)

                                    <tr>
                                        <td class="table-number">
                                            {{ $semuaAbsensi->firstItem() + $index }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-3">

                                                <div class="employee-avatar">
                                                    {{ strtoupper(substr(optional($absen->user)->name ?? '?', 0, 1)) }}
                                                </div>

                                                <div class="employee-name">
                                                    {{ optional($absen->user)->name ?? 'Pengguna tidak ditemukan' }}
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <span class="text-nowrap">
                                                <i class="bi bi-calendar3 me-2 text-muted"></i>

                                                {{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($absen->jam_masuk)
                                                <span class="status-badge status-success">
                                                    <i class="bi bi-box-arrow-in-right"></i>
                                                    {{ $absen->jam_masuk }}
                                                </span>
                                            @else
                                                <span class="status-badge status-neutral">
                                                    Belum Masuk
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($absen->jam_pulang)
                                                <span class="status-badge status-warning">
                                                    <i class="bi bi-box-arrow-right"></i>
                                                    {{ $absen->jam_pulang }}
                                                </span>
                                            @else
                                                <span class="status-badge status-neutral">
                                                    <i class="bi bi-clock"></i>
                                                    Belum Pulang
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($absen->status == 'Telat')

                                                <span class="status-badge status-late">
                                                    <i class="bi bi-exclamation-circle-fill"></i>
                                                    Telat
                                                </span>

                                            @else

                                                <span class="status-badge status-success">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Tepat Waktu
                                                </span>

                                            @endif
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="empty-state">

                                            <div class="empty-state-icon">
                                                <i class="bi bi-calendar-x"></i>
                                            </div>

                                            <div class="empty-state-title">
                                                Belum Ada Data Absensi
                                            </div>

                                            <p class="empty-state-text">
                                                Data kehadiran pengguna akan muncul di sini.
                                            </p>

                                        </td>
                                    </tr>

                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    {{-- PAGINATION ABSENSI --}}
                    @if($semuaAbsensi->hasPages())
                        <div class="admin-pagination">
                            {{ $semuaAbsensi->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

{{-- PERTAHANKAN TAB AKTIF SAAT PINDAH HALAMAN PAGINATION --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll(
            '#adminTab button[data-bs-toggle="tab"]'
        );

        const storageKey = 'adminDashboardActiveTab';

        tabButtons.forEach(function (button) {
            button.addEventListener('shown.bs.tab', function (event) {
                sessionStorage.setItem(storageKey, event.target.id);
            });
        });

        const params = new URLSearchParams(window.location.search);
        const isAbsensiPage = params.has('page_absensi');

        let activeTabId = sessionStorage.getItem(storageKey);

        if (isAbsensiPage) {
            activeTabId = 'absensi-tab';
        }

        if (activeTabId) {
            const activeButton = document.getElementById(activeTabId);

            if (activeButton && window.bootstrap) {
                bootstrap.Tab.getOrCreateInstance(activeButton).show();
            }
        }
    });
</script>

@endsection