
@extends('layouts.app')

@section('content')

<style>
/* =====================================
   TIMETRIX - MANAJEMEN SEKOLAH
===================================== */

.school-page {
    padding: 20px 12px 40px;
    color: #172554;
}

.school-page * {
    box-sizing: border-box;
}

/* HEADER */

.school-banner {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 25px 30px;
    margin-bottom: 26px;
    border-radius: 20px;
    background: linear-gradient(115deg, #e1efff, #f1f7ff, #dcecff);
    border: 1px solid #d6e8ff;
}

.school-banner::after {
    content: "";
    position: absolute;
    width: 300px;
    height: 180px;
    right: 100px;
    bottom: -125px;
    background: rgba(104, 170, 255, .13);
    border-radius: 50%;
}

.banner-content {
    display: flex;
    align-items: center;
    gap: 20px;
    z-index: 1;
}

.banner-icon {
    width: 65px;
    height: 65px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 18px;
    background: white;
    color: #2381e5;
    font-size: 30px;
    box-shadow: 0 5px 15px rgba(37, 99, 235, .08);
}

.banner-content h3 {
    font-size: 25px;
    font-weight: 800;
    margin: 0 0 6px;
    color: #172554;
}

.banner-content p {
    color: #647da2;
    font-size: 13px;
    margin: 0;
}

.banner-label {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px 17px;
    background: rgba(255,255,255,.65);
    color: #1767ca;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 700;
    z-index: 1;
}

/* ALERT */

.school-page .alert {
    border-radius: 12px;
    font-size: 13px;
}

/* CARD */

.school-card {
    background: #fff;
    border: 1px solid #e3ebf7;
    border-radius: 19px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(31, 75, 130, .055);
    height: 100%;
}

/* FORM HEADER */

.form-header {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px 23px;
    background: linear-gradient(120deg, #2582eb, #55a7fa);
    color: white;
}

.form-header::after {
    content: "";
    position: absolute;
    width: 160px;
    height: 160px;
    right: -40px;
    top: -90px;
    border-radius: 50%;
    background: rgba(255,255,255,.10);
}

.form-header-icon {
    width: 43px;
    height: 43px;
    border-radius: 50%;
    background: white;
    color: #2783e9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    z-index: 1;
}

.form-header h5 {
    font-size: 16px;
    font-weight: 800;
    margin: 0 0 4px;
}

.form-header small {
    font-size: 11px;
    opacity: .9;
}

/* FORM BODY */

.form-body {
    padding: 23px;
}

.form-body label {
    font-size: 13px;
    font-weight: 750;
    color: #243b60;
    margin-bottom: 10px;
}

.school-input {
    height: 49px;
    border: 1px solid #dce6f4;
    border-radius: 12px;
    background: #f9fbff;
    padding: 10px 14px;
    font-size: 13px;
    color: #334155;
}

.school-input:focus {
    background: white;
    border-color: #4a9cf0;
    box-shadow: 0 0 0 4px rgba(59,145,236,.11);
}

.school-input::placeholder {
    color: #94a3b8;
}

.btn-save-school {
    width: 100%;
    border: none;
    border-radius: 12px;
    padding: 13px;
    margin-top: 7px;
    background: linear-gradient(120deg, #247ce2, #398ff0);
    color: white;
    font-weight: 750;
    font-size: 13px;
    transition: .25s;
}

.btn-save-school:hover {
    background: #1769ca;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(37, 126, 226, .2);
}

.form-information {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    background: #eef6ff;
    padding: 14px;
    border-radius: 13px;
    margin-top: 22px;
    color: #3878bd;
    font-size: 11px;
    line-height: 1.7;
}

.form-information i {
    font-size: 19px;
}

/* TABLE HEADER */

.table-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 20px 22px;
    border-bottom: 1px solid #edf2f8;
}

.table-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.table-title-icon {
    width: 43px;
    height: 43px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eaf3ff;
    color: #267cda;
    font-size: 21px;
}

.table-title h5 {
    font-size: 16px;
    font-weight: 800;
    color: #172554;
    margin: 0 0 4px;
}

.table-title p {
    color: #94a3b8;
    font-size: 11px;
    margin: 0;
}

.total-school {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 10px 14px;
    border-radius: 30px;
    background: #e9f3ff;
    color: #2476d2;
    font-size: 12px;
    font-weight: 800;
}

/* TABLE */

.school-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}

.school-table thead th {
    padding: 16px 14px;
    background: #edf5ff;
    color: #405777;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
    border-bottom: 1px solid #e3edf9;
}

.school-table tbody td {
    padding: 14px;
    font-size: 12px;
    border-bottom: 1px solid #edf2f8;
    vertical-align: middle;
}

.school-table tbody tr:hover {
    background: #f8fbff;
}

.school-table tbody tr:last-child td {
    border-bottom: none;
}

.school-number {
    width: 33px;
    height: 33px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e5f1ff;
    color: #2676d3;
    border-radius: 10px;
    font-weight: 800;
}

.school-name {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 180px;
}

.school-name-icon {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #eaf4ff;
    color: #2782e4;
    font-size: 18px;
    flex-shrink: 0;
}

.school-name-form {
    display: flex;
    align-items: center;
    gap: 6px;
    flex: 1;
    min-width: 0;
}

.school-name-form input {
    width: 100%;
    min-width: 0;
    border: 1px solid transparent;
    border-radius: 8px;
    padding: 8px 9px;
    color: #243b60;
    font-weight: 700;
    font-size: 12px;
    background: transparent;
}

.school-name-form input:hover,
.school-name-form input:focus {
    outline: none;
    background: #f5f9ff;
    border-color: #c9ddf5;
}

.school-name-form button {
    width: 33px;
    height: 33px;
    flex-shrink: 0;
    border: 0;
    border-radius: 9px;
    background: #edf5ff;
    color: #2476d2;
}

.school-name-form button:hover {
    background: #2476d2;
    color: white;
}

.school-name-text {
    font-weight: 750;
    color: #243b60;
}

.school-owner {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 11px;
    border-radius: 20px;
    background: #f0f3f8;
    color: #52647e;
    font-size: 11px;
    font-weight: 700;
}

/* BUTTON AKSI */

.school-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
}

.btn-assign {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 22px;
    background: #e7f2ff;
    color: #2075d5;
    text-decoration: none;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
    transition: .2s;
}

.btn-assign:hover {
    background: #247ce2;
    color: white;
    transform: translateY(-2px);
}

.btn-delete {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 11px;
    background: #fff0f0;
    color: #e45656;
    font-size: 14px;
    transition: .2s;
}

.btn-delete:hover {
    background: #e45656;
    color: white;
}

/* EMPTY STATE */

.school-empty {
    text-align: center;
    padding: 55px 20px !important;
}

.empty-icon {
    width: 75px;
    height: 75px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 23px;
    background: #edf5ff;
    color: #3489df;
    font-size: 35px;
    margin: 0 auto 17px;
}

.school-empty h6 {
    font-size: 15px;
    font-weight: 800;
    color: #334155;
    margin-bottom: 8px;
}

.school-empty p {
    font-size: 12px;
    line-height: 1.7;
    color: #94a3b8;
    margin: 0;
}

/* RESPONSIVE */

@media (max-width: 991px) {
    .school-banner {
        padding: 22px;
    }

    .school-grid > div {
        margin-bottom: 20px;
    }
}

@media (max-width: 576px) {
    .school-page {
        padding: 12px 4px 25px;
    }

    .school-banner {
        padding: 19px;
        border-radius: 16px;
    }

    .banner-content {
        gap: 12px;
    }

    .banner-icon {
        width: 48px;
        height: 48px;
        font-size: 23px;
    }

    .banner-content h3 {
        font-size: 19px;
    }

    .banner-content p {
        font-size: 11px;
    }

    .banner-label {
        display: none;
    }

    .form-body {
        padding: 19px;
    }

    .table-heading {
        padding: 16px;
    }

    .school-table {
        min-width: 610px;
    }
}
</style>


<div class="container-fluid school-page">

    {{-- HEADER --}}
    <div class="school-banner">

        <div class="banner-content">

            <div class="banner-icon">
                <i class="bi bi-buildings"></i>
            </div>

            <div>
                <h3>Manajemen Sekolah</h3>
                <p>Kelola dan atur daftar sekolah asal siswa PKL dengan mudah.</p>
            </div>

        </div>

        <div class="banner-label">
            <i class="bi bi-shield-check fs-5"></i>
            Sistem Manajemen Timetrix
        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="row school-grid">

        {{-- FORM TAMBAH SEKOLAH --}}
        <div class="col-lg-4 mb-4">

            <div class="school-card">

                <div class="form-header">

                    <div class="form-header-icon">
                        <i class="bi bi-plus-lg"></i>
                    </div>

                    <div>
                        <h5>Tambah Sekolah Baru</h5>
                        <small>Tambahkan instansi asal siswa PKL</small>
                    </div>

                </div>


                <div class="form-body">

                    @php
                        $storeRoute = Auth::user()->role === 'pembimbing'
                            ? route('pembimbing.sekolah.store')
                            : route('admin.sekolah.store');
                    @endphp

                    <form action="{{ $storeRoute }}" method="POST">
                        @csrf

                        <div class="mb-3">

                            <label>Nama Sekolah / Instansi</label>

                            <input
                                type="text"
                                name="nama_sekolah"
                                class="form-control school-input @error('nama_sekolah') is-invalid @enderror"
                                placeholder="Contoh: SMK Negeri 1 Jakarta"
                                value="{{ old('nama_sekolah') }}"
                                required
                            >

                            @error('nama_sekolah')
                                <small class="text-danger d-block mt-2">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                        <button type="submit" class="btn-save-school">
                            <i class="bi bi-floppy me-2"></i>
                            Simpan Sekolah
                        </button>

                    </form>


                    <div class="form-information">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>
                            Pastikan nama sekolah ditulis dengan benar agar
                            memudahkan pengelolaan data siswa PKL.
                        </span>
                    </div>

                </div>

            </div>

        </div>


        {{-- DAFTAR SEKOLAH --}}
        <div class="col-lg-8 mb-4">

            <div class="school-card">

                {{-- JUDUL TABEL --}}
                <div class="table-heading">

                    <div class="table-title">

                        <div class="table-title-icon">
                            <i class="bi bi-list-ul"></i>
                        </div>

                        <div>
                            <h5>Daftar Sekolah</h5>
                            <p>Informasi seluruh sekolah yang terdaftar</p>
                        </div>

                    </div>

                    <div class="total-school">
                        <i class="bi bi-buildings"></i>
                        {{ $sekolahs->count() }} Sekolah
                    </div>

                </div>


                <div class="table-responsive">

                    <table class="school-table">

                        <thead>
                            <tr>
                                <th class="ps-4" width="65">No</th>
                                <th>Nama Sekolah</th>

                                @if(Auth::user()->role === 'admin')
                                    <th>Dibuat Oleh</th>
                                @endif

                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>


                        <tbody>

                            @forelse($sekolahs as $index => $s)

                                @php
                                    $isOwner = Auth::user()->role === 'admin'
                                        || $s->user_id === Auth::id();

                                    $updateRoute = Auth::user()->role === 'pembimbing'
                                        ? route('pembimbing.sekolah.update', $s->id)
                                        : route('admin.sekolah.update', $s->id);

                                    $assignRoute = Auth::user()->role === 'pembimbing'
                                        ? route('pembimbing.sekolah.assign', $s->id)
                                        : route('admin.sekolah.assign', $s->id);

                                    $destroyRoute = Auth::user()->role === 'pembimbing'
                                        ? route('pembimbing.sekolah.destroy', $s->id)
                                        : route('admin.sekolah.destroy', $s->id);
                                @endphp

                                <tr>

                                    {{-- NOMOR --}}
                                    <td class="ps-4">
                                        <div class="school-number">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>


                                    {{-- NAMA SEKOLAH --}}
                                    <td>

                                        <div class="school-name">

                                            <div class="school-name-icon">
                                                <i class="bi bi-building"></i>
                                            </div>

                                            <div style="flex:1; min-width:0;">

                                                @if($isOwner)

                                                    <form
                                                        action="{{ $updateRoute }}"
                                                        method="POST"
                                                        class="school-name-form"
                                                    >
                                                        @csrf
                                                        @method('PUT')

                                                        <input
                                                            type="text"
                                                            name="nama_sekolah"
                                                            value="{{ $s->nama_sekolah }}"
                                                            required
                                                        >

                                                        <button type="submit" title="Simpan perubahan">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>

                                                    </form>

                                                @else

                                                    <div class="school-name-text">
                                                        {{ $s->nama_sekolah }}
                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- PEMBUAT KHUSUS ADMIN --}}
                                    @if(Auth::user()->role === 'admin')
                                        <td>
                                            <span class="school-owner">
                                                <i class="bi bi-person-circle"></i>
                                                {{ $s->user->name ?? 'Admin / Sistem' }}
                                            </span>
                                        </td>
                                    @endif


                                    {{-- TOMBOL AKSI --}}
                                    <td>

                                        <div class="school-actions">

                                            <a
                                                href="{{ $assignRoute }}"
                                                class="btn-assign"
                                                title="Atur siswa"
                                            >
                                                <i class="bi bi-people-fill"></i>
                                                Atur Siswa
                                            </a>

                                            @if($isOwner)

                                                <form
                                                    action="{{ $destroyRoute }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn-delete"
                                                        title="Hapus sekolah"
                                                    >
                                                        <i class="bi bi-trash3"></i>
                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="{{ Auth::user()->role === 'admin' ? 4 : 3 }}"
                                        class="school-empty"
                                    >

                                        <div class="empty-icon">
                                            <i class="bi bi-buildings"></i>
                                        </div>

                                        <h6>Belum Ada Sekolah</h6>

                                        <p>
                                            Data sekolah belum tersedia saat ini.
                                            <br>
                                            Silakan tambahkan sekolah melalui formulir di sebelah kiri.
                                        </p>

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
