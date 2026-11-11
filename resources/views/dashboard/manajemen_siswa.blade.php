
@extends('layouts.app')

@section('content')

<style>
    /* =========================
       MANAJEMEN SISWA
    ========================= */

    .student-page {
        width: 100%;
        min-width: 0;
        padding-top: 24px;
        padding-bottom: 24px;
    }

    .student-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 24px;
    }

    .student-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }

    .student-header p {
        font-size: 14px;
    }

    .student-actions {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .student-actions .btn {
        border-radius: 9px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* SUMMARY */

    .student-summary {
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        border: none;
        border-radius: 16px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
    }

    .student-summary .card-body {
        padding: 22px;
    }

    /* TABLE */

    .student-table-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 3px 15px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .student-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
    }

    .student-table {
        width: 100%;
        min-width: 900px;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .student-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
        padding: 15px 14px;
        border-bottom: 1px solid #e9eef5;
        white-space: nowrap;
    }

    .student-table tbody td {
        padding: 13px 14px;
        font-size: 13px;
        color: #475569;
        border-bottom: 1px solid #f0f2f5;
        vertical-align: middle;
    }

    .student-table tbody tr:last-child td {
        border-bottom: none;
    }

    .student-table tbody tr:hover {
        background: #f8fbff;
    }

    .student-table .name-column {
        min-width: 190px;
    }

    .student-table .email-column {
        min-width: 220px;
    }

    .student-table .school-column {
        min-width: 170px;
    }

    .student-table .action-column {
        min-width: 170px;
        text-align: center;
        white-space: nowrap;
    }

    .student-avatar {
        width: 37px;
        height: 37px;
        min-width: 37px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #2563eb;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }

    .student-table .btn {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 7px;
        font-weight: 600;
    }

    .student-table .badge {
        font-size: 11px;
        padding: 6px 9px;
    }

    .student-scroll-info {
        display: none;
        padding: 9px 13px;
        color: #64748b;
        font-size: 11px;
        background: #f8fafc;
        border-bottom: 1px solid #edf0f4;
    }

    .student-pagination {
        padding: 15px;
        border-top: 1px solid #edf0f4;
        overflow-x: auto;
    }

    .student-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    .student-pagination .pagination {
        margin-bottom: 0;
    }

    /* =========================
       RESPONSIVE MOBILE
    ========================= */

    @media (max-width: 767.98px) {

        .student-page {
            padding: 16px 12px 24px;
        }

        .student-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 13px;
            margin-bottom: 19px;
        }

        .student-header h3 {
            font-size: 21px;
            margin-bottom: 5px;
        }

        .student-header p {
            font-size: 12px;
            line-height: 1.7;
        }

        .student-actions {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .student-actions .btn {
            width: 100%;
            padding: 10px 5px;
            font-size: 11px;
            text-align: center;
        }

        .student-summary-wrapper {
            margin-bottom: 18px !important;
        }

        .student-summary .card-body {
            padding: 17px !important;
        }

        .student-summary h2 {
            font-size: 26px;
        }

        .student-table-card {
            border-radius: 12px;
        }

        .student-scroll-info {
            display: block;
        }

        .student-table {
            min-width: 850px;
        }

        .student-table thead th {
            padding: 12px 11px;
            font-size: 11px;
        }

        .student-table tbody td {
            padding: 11px;
            font-size: 12px;
        }

        .student-avatar {
            width: 33px;
            height: 33px;
            min-width: 33px;
            font-size: 12px;
        }

        .student-table .name-column {
            min-width: 165px;
        }

        .student-table .email-column {
            min-width: 190px;
        }

        .student-table .school-column {
            min-width: 150px;
        }

        .student-table .action-column {
            min-width: 155px;
        }

        .student-table .btn {
            font-size: 11px;
            padding: 6px 8px;
        }

        .student-pagination {
            padding: 12px;
        }

        .student-pagination nav {
            justify-content: center;
        }

        .student-pagination .pagination {
            flex-wrap: wrap;
            justify-content: center;
            gap: 3px;
        }

        .student-pagination .page-link {
            font-size: 12px;
            padding: 7px 10px;
        }
    }

    @media (max-width: 380px) {

        .student-header h3 {
            font-size: 19px;
        }

        .student-actions .btn {
            font-size: 10px;
        }
    }
</style>


<div class="container-fluid student-page">

    {{-- HEADER --}}
    <div class="student-header">

        <div>
            <h3 class="mb-1">Data Siswa & Guru</h3>

            <p class="text-muted mb-0">
                Kelola anggota untuk:

                <span class="badge bg-primary px-2 py-1">
                    <i class="bi bi-building me-1"></i>
                    {{ Auth::user()->perusahaan->nama_perusahaan ?? 'Perusahaan Anda' }}
                </span>
            </p>
        </div>

        <div class="student-actions">

            <a href="{{ route('pembimbing.sekolah.index') }}"
               class="btn btn-outline-secondary">

                <i class="bi bi-building me-1"></i>
                Data Sekolah

            </a>

            <a href="{{ route('pembimbing.siswa.create') }}"
               class="btn btn-primary">

                <i class="bi bi-person-plus-fill me-1"></i>
                Tambah Pengguna

            </a>

        </div>

    </div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm"
             role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm"
             role="alert">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>

    @endif


    {{-- TOTAL ANGGOTA --}}
    <div class="row student-summary-wrapper mb-4">

        <div class="col-md-4 col-12">

            <div class="card student-summary">

                <div class="card-body d-flex align-items-center gap-3">

                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                         style="width:55px;height:55px;min-width:55px;">

                        <i class="bi bi-people-fill fs-4"></i>

                    </div>

                    <div>

                        <div class="text-dark fw-bold text-uppercase small"
                             style="opacity:.7;">

                            Total Anggota

                        </div>

                        <h2 class="fw-bold mb-0 text-dark">

                            {{ $totalUser }}

                            <span class="fs-6 fw-normal">Orang</span>

                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TABEL DATA ANGGOTA --}}
    <div class="card student-table-card">

        <div class="card-body p-0">

            <div class="student-scroll-info">
                <i class="bi bi-arrows-left-right me-1"></i>
                Geser tabel ke kanan atau kiri untuk melihat seluruh data.
            </div>

            <div class="student-table-wrapper">

                <table class="table table-hover align-middle student-table">

                    <thead>
                        <tr>

                            <th class="ps-4" width="65">No.</th>

                            <th class="name-column">Nama Pengguna</th>

                            <th class="email-column">Email</th>

                            <th class="school-column">Sekolah</th>

                            <th>Role</th>

                            <th class="action-column">Aksi</th>

                        </tr>
                    </thead>

                    <tbody>

                        @forelse($semuaPengguna as $index => $pengguna)

                            <tr>

                                <td class="ps-4 text-muted fw-bold">

                                    {{ $semuaPengguna->firstItem() + $index }}

                                </td>


                                <td>

                                    <div class="d-flex align-items-center gap-2">

                                        <div class="student-avatar">

                                            {{ strtoupper(substr($pengguna->name, 0, 1)) }}

                                        </div>

                                        <div>

                                            <div class="fw-bold text-dark">

                                                {{ $pengguna->name }}

                                            </div>

                                            <div class="text-muted small">

                                                ID #{{ $pengguna->id }}

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    {{ $pengguna->email }}

                                </td>


                                <td>

                                    <span class="text-muted">

                                        {{ $pengguna->sekolah->nama_sekolah ?? '-' }}

                                    </span>

                                </td>


                                <td>

                                    @if($pengguna->role == 'pembimbing')

                                        <span class="badge bg-warning text-dark">
                                            Pembimbing
                                        </span>

                                    @elseif($pengguna->role == 'guru')

                                        <span class="badge bg-info text-dark">
                                            Guru
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Siswa
                                        </span>

                                    @endif

                                </td>


                                <td class="action-column">

                                    <a href="{{ route('pembimbing.siswa.edit', $pengguna->id) }}"
                                       class="btn btn-sm btn-outline-warning">

                                        <i class="bi bi-pencil-square"></i>
                                        Edit

                                    </a>


                                    @if(strtolower($pengguna->role) !== 'admin')

                                        <form action="{{ route('pembimbing.siswa.destroy', $pengguna->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus pengguna ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">

                                                <i class="bi bi-trash3"></i>
                                                Hapus

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center text-muted py-5">

                                    <i class="bi bi-person-x fs-1 d-block mb-3 text-secondary"></i>

                                    Belum ada anggota di perusahaan ini.

                                    <br>

                                    Klik tombol
                                    <strong>Tambah Pengguna</strong>
                                    di atas.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            <div class="student-pagination">

                {{ $semuaPengguna->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
