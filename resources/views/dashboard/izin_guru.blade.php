
@extends('layouts.app')

@section('content')

<style>
    .izin-page {
        --izin-blue: #4385f5;
        --izin-navy: #1e2b45;
        --izin-bg: #f2f6fd;
        background: var(--izin-bg);
        min-height: 100vh;
        padding: 24px;
        color: #263754;
    }

    .izin-page * {
        box-sizing: border-box;
    }

    .izin-page .izin-alert {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px 20px;
        margin-bottom: 24px;
        border: 1px solid #c5ead7;
        border-radius: 15px;
        background: #e6f8ef;
        color: #16794b;
        box-shadow: 0 4px 14px rgba(31, 65, 110, .04);
    }

    .izin-page .alert-icon {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: #c7f0dc;
        font-size: 20px;
    }

    .izin-page .izin-card {
        background: #fff;
        border: 1px solid #e8eef8;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(39, 65, 108, .06);
    }

    .izin-page .izin-heading {
        padding: 26px 26px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
    }

    .izin-page .heading-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .izin-page .heading-icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 16px;
        color: white;
        background: linear-gradient(135deg, #65a3ff, #4778f5);
        font-size: 25px;
        box-shadow: 0 7px 15px rgba(67, 133, 245, .18);
    }

    .izin-page .heading-title {
        margin: 0 0 7px;
        font-size: 22px;
        font-weight: 750;
        color: #203354;
    }

    .izin-page .heading-desc {
        margin: 0;
        color: #8292ad;
        font-size: 14px;
        line-height: 1.6;
    }

    .izin-page .izin-toolbar {
        padding: 0 26px 20px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .izin-page .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .izin-page .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8b9bb6;
        font-size: 16px;
    }

    .izin-page .search-input,
    .izin-page .filter-select {
        width: 100%;
        min-height: 44px;
        border: 1px solid #e2eaf6;
        background: #f8faff;
        color: #334765;
        border-radius: 11px;
        padding: 10px 13px;
        outline: none;
        font-size: 13px;
        transition: .2s;
    }

    .izin-page .search-input {
        padding-left: 42px;
    }

    .izin-page .search-input:focus,
    .izin-page .filter-select:focus {
        border-color: #79a9ff;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(67, 133, 245, .10);
    }

    .izin-page .filter-select {
        width: 165px;
        cursor: pointer;
    }

    .izin-page .table-wrap {
        padding: 0 18px;
        overflow-x: auto;
        scrollbar-width: thin;
    }

    .izin-page .izin-table {
        width: 100%;
        min-width: 1000px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .izin-page .izin-table thead th {
        padding: 16px 13px;
        background: #f1f5fd;
        color: #516582;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .45px;
        white-space: nowrap;
        border: 0;
    }

    .izin-page .izin-table thead th:first-child {
        border-radius: 12px 0 0 0;
    }

    .izin-page .izin-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }

    .izin-page .izin-table tbody td {
        padding: 19px 13px;
        vertical-align: middle;
        border-bottom: 1px solid #edf1f8;
        color: #344765;
        font-size: 13px;
    }

    .izin-page .izin-table tbody tr {
        transition: background .2s;
    }

    .izin-page .izin-table tbody tr:hover {
        background: #f8faff;
    }

    .izin-page .date-main {
        font-weight: 650;
        white-space: nowrap;
        color: #2d4265;
    }

    .izin-page .date-sub {
        display: block;
        margin-top: 5px;
        color: #92a1ba;
        font-size: 12px;
    }

    .izin-page .date-icon {
        color: #7597d4;
        margin-right: 6px;
    }

    .izin-page .student-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 150px;
    }

    .izin-page .student-avatar {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        border-radius: 13px;
        background: #e9e7ff;
        color: #6554df;
        font-size: 13px;
        font-weight: 800;
    }

    .izin-page .student-name {
        font-weight: 700;
        color: #263958;
        overflow-wrap: anywhere;
    }

    .izin-page .student-caption {
        display: block;
        color: #94a2b9;
        font-size: 11px;
        margin-top: 4px;
    }

    .izin-page .type-badge,
    .izin-page .status-badge,
    .izin-page .attachment-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }

    .izin-page .type-izin {
        background: #e3f1ff;
        color: #2875d8;
    }

    .izin-page .type-sakit {
        background: #fff0ce;
        color: #b97800;
    }

    .izin-page .type-other {
        background: #eee9ff;
        color: #7655cf;
    }

    .izin-page .status-menunggu {
        background: #fff1ca;
        color: #b87500;
    }

    .izin-page .status-disetujui {
        background: #d9f7e7;
        color: #168653;
    }

    .izin-page .status-ditolak {
        background: #ffe1e5;
        color: #d63d51;
    }

    .izin-page .attachment-badge {
        background: #f1f5fb;
        color: #8494ae;
        font-weight: 600;
    }

    .izin-page .attachment-link {
        color: #3677e8;
        text-decoration: none;
        background: #eaf2ff;
        transition: .2s;
    }

    .izin-page .attachment-link:hover {
        background: #d8e7ff;
    }

    .izin-page .reason-text {
        display: block;
        max-width: 160px;
        overflow-wrap: anywhere;
        line-height: 1.6;
    }

    .izin-page .action-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
    }

    .izin-page .action-btn {
        width: 38px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 11px;
        color: #fff;
        font-size: 15px;
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
    }

    .izin-page .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(30, 50, 80, .13);
    }

    .izin-page .btn-approve {
        background: #20b477;
    }

    .izin-page .btn-reject {
        background: #f04459;
    }

    .izin-page .btn-view {
        width: auto;
        padding: 0 13px;
        border: 1px solid #bcd4ff;
        background: #fff;
        color: #3678e8;
        font-size: 12px;
        font-weight: 700;
    }

    .izin-page .done-text {
        color: #8292aa;
        font-size: 12px;
        white-space: nowrap;
    }

    .izin-page .izin-footer {
        padding: 19px 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        color: #8797b1;
        font-size: 12px;
    }

    .izin-page .empty-state {
        padding: 48px 15px !important;
        text-align: center;
        color: #8c9bb3 !important;
    }

    .izin-page .empty-state i {
        display: block;
        font-size: 40px;
        color: #91b7fa;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .izin-page {
            padding: 13px;
        }

        .izin-page .izin-alert {
            padding: 14px;
            font-size: 13px;
            align-items: flex-start;
        }

        .izin-page .alert-icon {
            width: 34px;
            height: 34px;
        }

        .izin-page .izin-heading {
            padding: 20px 16px;
            align-items: flex-start;
        }

        .izin-page .heading-left {
            align-items: flex-start;
            gap: 12px;
        }

        .izin-page .heading-icon {
            width: 45px;
            height: 45px;
            font-size: 20px;
            border-radius: 12px;
        }

        .izin-page .heading-title {
            font-size: 18px;
            line-height: 1.4;
        }

        .izin-page .heading-desc {
            font-size: 12px;
        }

        .izin-page .izin-toolbar {
            padding: 0 16px 17px;
        }

        .izin-page .search-box {
            flex-basis: 100%;
        }

        .izin-page .filter-select {
            width: 100%;
        }

        .izin-page .table-wrap {
            padding: 0 10px;
        }

        .izin-page .izin-footer {
            padding: 17px;
        }
    }
</style>

<div class="izin-page">

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="izin-alert" role="alert">
            <div class="alert-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <div class="flex-grow-1">
                <strong>Berhasil!</strong>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    {{-- KARTU UTAMA --}}
    <div class="izin-card">

        {{-- JUDUL --}}
        <div class="izin-heading">
            <div class="heading-left">
                <div class="heading-icon">
                    <i class="bi bi-envelope-paper"></i>
                </div>

                <div>
                    <h4 class="heading-title">Daftar Pengajuan Izin Siswa</h4>
                    <p class="heading-desc">
                        Kelola dan setujui pengajuan izin dari siswa bimbingan Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- PENCARIAN DAN FILTER --}}
        <div class="izin-toolbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="searchIzin"
                    class="search-input"
                    placeholder="Cari nama siswa, alasan, atau jenis izin..."
                    aria-label="Cari pengajuan izin"
                >
            </div>

            <select id="filterStatus" class="filter-select"
                    aria-label="Filter status pengajuan">
                <option value="">Semua Status</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        {{-- TABEL --}}
        <div class="table-wrap">
            <table class="izin-table">
                <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>Nama Siswa</th>
                        <th>Jenis &amp; Tanggal Izin</th>
                        <th>Alasan</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabelIzin">
                    @forelse ($semuaIzin as $izin)
                        <tr class="izin-row"
                            data-status="{{ $izin->status }}"
                            data-search="{{ strtolower(($izin->user->name ?? 'Siswa') . ' ' . $izin->jenis_izin . ' ' . $izin->alasan . ' ' . $izin->status) }}">

                            {{-- TANGGAL PENGAJUAN --}}
                            <td>
                                <span class="date-main">
                                    <i class="bi bi-calendar3 date-icon"></i>
                                    {{ $izin->created_at->format('d M Y') }}
                                </span>
                                <span class="date-sub">
                                    {{ $izin->created_at->format('H:i') }}
                                </span>
                            </td>

                            {{-- NAMA SISWA --}}
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($izin->user->name ?? 'S', 0, 1)) }}
                                    </div>

                                    <div>
                                        <div class="student-name">
                                            {{ $izin->user->name ?? 'Siswa' }}
                                        </div>
                                        <span class="student-caption">
                                            Pengajuan izin
                                        </span>
                                    </div>
                                </div>
                            </td>

                            {{-- JENIS DAN TANGGAL IZIN --}}
                            <td>
                                @php
                                    $jenis = strtolower($izin->jenis_izin);
                                    $jenisClass = $jenis == 'izin'
                                        ? 'type-izin'
                                        : ($jenis == 'sakit' ? 'type-sakit' : 'type-other');
                                @endphp

                                <span class="type-badge {{ $jenisClass }}">
                                    {{ $izin->jenis_izin }}
                                </span>

                                <span class="date-sub">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}
                                </span>
                            </td>

                            {{-- ALASAN --}}
                            <td>
                                <span class="reason-text">
                                    {{ $izin->alasan }}
                                </span>
                            </td>

                            {{-- LAMPIRAN --}}
                            <td>
                                @if($izin->lampiran)
                                    <a
                                        href="{{ asset('storage/' . $izin->lampiran) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="attachment-badge attachment-link"
                                    >
                                        <i class="bi bi-paperclip"></i>
                                        Lihat
                                    </a>
                                @else
                                    <span class="attachment-badge">
                                        <i class="bi bi-paperclip"></i>
                                        Tidak ada
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($izin->status == 'Menunggu')
                                    <span class="status-badge status-menunggu">
                                        <i class="bi bi-clock"></i>
                                        Menunggu
                                    </span>
                                @elseif($izin->status == 'Disetujui')
                                    <span class="status-badge status-disetujui">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="status-badge status-ditolak">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <div class="action-group">
                                    @if($izin->status == 'Menunggu')

                                        <form action="/guru/izin/{{ $izin->id }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menyetujui pengajuan izin ini?')">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden"
                                                   name="status"
                                                   value="Disetujui">

                                            <button type="submit"
                                                    class="action-btn btn-approve"
                                                    title="Setujui"
                                                    aria-label="Setujui izin">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                        <form action="/guru/izin/{{ $izin->id }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menolak pengajuan izin ini?')">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden"
                                                   name="status"
                                                   value="Ditolak">

                                            <button type="submit"
                                                    class="action-btn btn-reject"
                                                    title="Tolak"
                                                    aria-label="Tolak izin">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>

                                    @else
                                        <span class="done-text">
                                            <i class="bi bi-check2-all me-1"></i>
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <strong>Belum ada pengajuan izin</strong>
                                <div class="mt-2">
                                    Pengajuan izin dari siswa akan muncul di sini.
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noSearchResult" style="display:none;">
                        <td colspan="7" class="empty-state">
                            <i class="bi bi-search"></i>
                            <strong>Data tidak ditemukan</strong>
                            <div class="mt-2">
                                Coba gunakan kata kunci atau filter lainnya.
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- FOOTER --}}
        <div class="izin-footer">
            <span id="jumlahIzin">
                Menampilkan {{ count($semuaIzin) }} pengajuan izin
            </span>

            <span>
                <i class="bi bi-shield-check me-1"></i>
                Pengelolaan izin siswa
            </span>
        </div>

    </div>
</div>

{{-- FITUR PENCARIAN DAN FILTER --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchIzin');
    const filterStatus = document.getElementById('filterStatus');
    const rows = Array.from(document.querySelectorAll('.izin-row'));
    const noResult = document.getElementById('noSearchResult');
    const jumlahIzin = document.getElementById('jumlahIzin');

    function filterIzin() {
        const keyword = searchInput.value.toLowerCase().trim();
        const status = filterStatus.value;
        let jumlah = 0;

        rows.forEach(function (row) {
            const teks = row.dataset.search || '';
            const statusRow = row.dataset.status || '';

            const cocokKeyword = teks.includes(keyword);
            const cocokStatus = !status || statusRow === status;
            const tampil = cocokKeyword && cocokStatus;

            row.style.display = tampil ? '' : 'none';

            if (tampil) {
                jumlah++;
            }
        });

        noResult.style.display =
            rows.length > 0 && jumlah === 0 ? '' : 'none';

        jumlahIzin.textContent =
            'Menampilkan ' + jumlah + ' dari ' + rows.length +
            ' pengajuan izin';
    }

    searchInput.addEventListener('input', filterIzin);
    filterStatus.addEventListener('change', filterIzin);
});
</script>

@endsection
