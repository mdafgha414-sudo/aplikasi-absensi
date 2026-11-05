@extends('layouts.app')

@section('content')

@php
    $role = Auth::user()->role;
    $isGuru = $role === 'guru';
    $isPembimbing = $role === 'pembimbing';
@endphp

<style>
/* STYLE UMUM */
.alasan-page {
    padding: 22px 24px;
    color: #18345f;
    min-height: 85vh;
}

.alasan-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 22px;
}

.alasan-heading h4 {
    font-weight: 750;
    font-size: 23px;
    color: #17345f;
    margin-bottom: 5px;
}

.alasan-heading p {
    font-size: 13px;
    color: #8292aa;
    margin: 0;
}

/* BANNER GURU */
.guru-banner {
    display: flex;
    align-items: center;
    gap: 22px;
    padding: 25px 30px;
    min-height: 150px;
    border-radius: 18px;
    margin-bottom: 23px;
    background: linear-gradient(110deg,#e3eeff,#f2f7ff,#d6e7ff);
    border: 1px solid #d8e7ff;
    overflow: hidden;
}

.guru-banner-icon {
    width: 82px;
    height: 82px;
    min-width: 82px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 20px;
    background: white;
    color: #2878df;
    font-size: 40px;
}

.guru-banner h2 {
    font-size: 26px;
    font-weight: 750;
    color: #163568;
    margin-bottom: 8px;
}

.guru-banner p {
    font-size: 14px;
    color: #58749c;
    margin: 0;
}

.guru-banner-decoration {
    margin-left: auto;
    color: rgba(42,116,218,.25);
    font-size: 75px;
}

/* PANEL GURU */
.alasan-panel {
    background: #fff;
    border: 1px solid #e4ebf5;
    border-radius: 19px;
    padding: 22px;
    box-shadow: 0 4px 17px rgba(34,75,130,.045);
}

.alasan-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

/* SEARCH GURU */
.alasan-search {
    position: relative;
    width: 100%;
}

.alasan-search i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #8295b2;
}

.alasan-search input {
    width: 100%;
    height: 44px;
    padding: 0 15px 0 43px;
    border: 1px solid #e1e9f5;
    border-radius: 11px;
    background: #f9fbff;
    outline: none;
    font-size: 13px;
}

.alasan-search input:focus {
    border-color: #3983df;
    background: white;
    box-shadow: 0 0 0 3px rgba(57,131,223,.08);
}

/* FILTER GURU */
.alasan-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 30px;
    border: 1px solid #e2eaf7;
    background: white;
    color: #344f79;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.filter-btn.active {
    background: #2875df;
    color: white;
    border-color: #2875df;
    box-shadow: 0 4px 10px rgba(40,117,223,.18);
}

.filter-count {
    background: #e3edff;
    color: #2875df;
    padding: 2px 8px;
    border-radius: 20px;
}

.filter-btn.active .filter-count {
    background: white;
    color: #2875df;
}

/* FILTER BULAN DAN TAHUN */
.alasan-date {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;
    margin-left: auto;
}

.alasan-date select {
    height: 36px;
    min-width: 90px;
    padding: 0 10px;
    border: 1px solid #e0e8f5;
    border-radius: 9px;
    background: #fff;
    color: #34547e;
    font-size: 12px;
    cursor: pointer;
    outline: none;
}

.alasan-date select:focus {
    border-color: #3983df;
    box-shadow: 0 0 0 3px rgba(57,131,223,.08);
}

/* TABEL GURU */
.alasan-table-wrap {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #e4ebf5;
    border-radius: 14px;
}

.alasan-table {
    width: 100%;
    min-width: 600px;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}

.alasan-table thead th {
    background: #eaf2ff;
    color: #294d80;
    padding: 16px 14px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    border-bottom: 1px solid #dce8f8;
}

.alasan-table tbody td {
    padding: 15px 14px;
    font-size: 13px;
    color: #526783;
    border-bottom: 1px solid #edf1f7;
    vertical-align: middle;
}

.alasan-table tbody tr:last-child td {
    border-bottom: none;
}

.alasan-table tbody tr:hover {
    background: #f5f9ff;
}

.nama-siswa {
    color: #203d69 !important;
    font-weight: 650;
    white-space: nowrap;
}

.alasan-text {
    max-width: 250px;
    white-space: normal;
    line-height: 1.5;
}

.siswa-avatar {
    display: inline-flex;
    width: 34px;
    height: 34px;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    background: #e4efff;
    color: #2875d9;
    margin-right: 7px;
}

/* STATUS */
.status-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 12px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 650;
    white-space: nowrap;
}

.status-label:before {
    content: "";
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
}

.status-menunggu {
    background: #fff1d8;
    color: #d98c16;
}

.status-diterima {
    background: #e1f5e9;
    color: #168957;
}

.status-ditolak {
    background: #ffe5e7;
    color: #d83e4d;
}

/* BANNER PEMBIMBING */
.pembimbing-banner {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 24px 28px;
    margin-bottom: 22px;
    border-radius: 17px;
    background: linear-gradient(110deg, #e5f0ff, #f4f8ff);
    border: 1px solid #dce9fb;
}

.pembimbing-banner-icon {
    width: 65px;
    height: 65px;
    min-width: 65px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 17px;
    background: #fff;
    color: #2875df;
    font-size: 30px;
    box-shadow: 0 4px 12px rgba(40,117,223,.08);
}

.pembimbing-banner h2 {
    color: #173b70;
    font-size: 23px;
    font-weight: 750;
    margin: 0 0 6px;
}

.pembimbing-banner p {
    color: #7186a5;
    font-size: 13px;
    margin: 0;
}

/* PANEL PEMBIMBING */
.pembimbing-panel {
    background: white;
    border: 1px solid #e2eaf5;
    border-radius: 17px;
    padding: 22px;
    box-shadow: 0 5px 18px rgba(35,72,120,.045);
}

.pembimbing-panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.pembimbing-panel-heading h5 {
    color: #1b3c6c;
    font-size: 16px;
    font-weight: 750;
    margin: 0 0 5px;
}

.pembimbing-panel-heading p {
    color: #8a9ab1;
    font-size: 12px;
    margin: 0;
}

/* SEARCH PEMBIMBING */
.pembimbing-search {
    position: relative;
    width: 280px;
    max-width: 100%;
}

.pembimbing-search i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #8498b5;
}

.pembimbing-search input {
    width: 100%;
    height: 42px;
    padding: 0 13px 0 40px;
    border: 1px solid #e0e8f4;
    border-radius: 10px;
    background: #f9fbff;
    font-size: 12px;
    outline: none;
}

.pembimbing-search input:focus {
    background: white;
    border-color: #3983df;
    box-shadow: 0 0 0 3px rgba(57,131,223,.08);
}

/* TABEL PEMBIMBING */
.pembimbing-table {
    width: 100%;
    min-width: 700px;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}

.pembimbing-table thead th {
    background: #edf4ff;
    color: #315783;
    padding: 15px 14px;
    font-size: 12px;
    font-weight: 750;
    border-bottom: 1px solid #dce8f8;
    white-space: nowrap;
}

.pembimbing-table thead th:first-child {
    border-radius: 11px 0 0 0;
}

.pembimbing-table thead th:last-child {
    border-radius: 0 11px 0 0;
}

.pembimbing-table tbody td {
    padding: 16px 14px;
    font-size: 12px;
    color: #526783;
    border-bottom: 1px solid #edf1f7;
    vertical-align: middle;
}

.pembimbing-table tbody tr:hover {
    background: #f7faff;
}

.pembimbing-table tbody tr:last-child td {
    border-bottom: none;
}

.pembimbing-table .nama-siswa {
    color: #244675 !important;
    font-weight: 700;
}

/* TOMBOL AKSI */
.pembimbing-action {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 7px;
}

.pembimbing-action form {
    margin: 0;
}

.pembimbing-action .btn {
    padding: 8px 12px;
    border: none;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 650;
    transition: .2s;
    white-space: nowrap;
}

.pembimbing-action .btn-terima {
    background: #19875d;
    color: white;
}

.pembimbing-action .btn-tolak {
    background: #e34c5b;
    color: white;
}

.pembimbing-action .btn-terima:hover {
    background: #126b49;
    transform: translateY(-1px);
}

.pembimbing-action .btn-tolak:hover {
    background: #c93443;
    transform: translateY(-1px);
}

.pembimbing-finish {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 12px;
    border-radius: 20px;
    background: #e2f5eb;
    color: #168957;
    font-size: 11px;
    font-weight: 650;
}

/* DATA KOSONG */
.empty-data {
    text-align: center;
    padding: 40px 15px !important;
    color: #8494ab !important;
}

.empty-data i {
    display: block;
    font-size: 35px;
    margin-bottom: 10px;
}

/* RESPONSIVE HP */
@media(max-width:768px) {
    .alasan-page {
        padding: 14px 10px;
    }

    .alasan-panel {
        padding: 13px;
    }

    .guru-banner {
        padding: 17px;
        gap: 12px;
        min-height: 115px;
    }

    .guru-banner-icon {
        width: 55px;
        height: 55px;
        min-width: 55px;
        font-size: 27px;
    }

    .guru-banner h2 {
        font-size: 18px;
    }

    .guru-banner p {
        font-size: 11px;
    }

    .guru-banner-decoration {
        display: none;
    }

    .alasan-toolbar {
        align-items: flex-start;
    }

    .alasan-filters {
        width: 100%;
    }

    .filter-btn {
        padding: 8px 10px;
        font-size: 11px;
    }

    .alasan-date {
        width: 100%;
        margin-left: 0;
        flex-wrap: wrap;
    }

    .alasan-date select {
        min-width: 90px;
    }

    .pembimbing-banner {
        padding: 17px;
    }

    .pembimbing-banner-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        font-size: 24px;
    }

    .pembimbing-banner h2 {
        font-size: 18px;
    }

    .pembimbing-banner p {
        font-size: 11px;
    }

    .pembimbing-panel {
        padding: 14px;
    }

    .pembimbing-panel-heading {
        align-items: flex-start;
    }

    .pembimbing-search {
        width: 100%;
    }
}
</style>


{{-- ==========================================
     HALAMAN GURU
========================================== --}}

@if($isGuru)

<div class="container-fluid alasan-page">

    <div class="guru-banner">
        <div class="guru-banner-icon">
            <i class="bi bi-clock-history"></i>
        </div>

        <div>
            <h2>Alasan Keterlambatan</h2>
            <p>Periksa dan kelola informasi alasan keterlambatan siswa.</p>
        </div>

        <div class="guru-banner-decoration">
            <i class="bi bi-alarm"></i>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="alasan-panel">

        {{-- SEARCH --}}
        <div class="alasan-toolbar">
            <div class="alasan-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchGuru"
                    placeholder="Cari nama siswa atau alasan keterlambatan...">
            </div>
        </div>

        {{-- FILTER STATUS --}}
        <div class="alasan-toolbar">

            <div class="alasan-filters">

                <button type="button" class="filter-btn active"
                    data-status="semua">
                    <i class="bi bi-grid"></i> Semua
                </button>

                <button type="button" class="filter-btn"
                    data-status="Menunggu">
                    <i class="bi bi-clock"></i> Menunggu
                    <span class="filter-count" id="countMenunggu">0</span>
                </button>

                <button type="button" class="filter-btn"
                    data-status="Diterima">
                    <i class="bi bi-check-circle"></i> Disetujui
                </button>

                <button type="button" class="filter-btn"
                    data-status="Ditolak">
                    <i class="bi bi-x-circle"></i> Ditolak
                </button>

            </div>

            <div class="alasan-date">
                <i class="bi bi-calendar3 text-primary"></i>

                <select id="filterBulan" aria-label="Pilih bulan">
                    <option value="">Semua Bulan</option>

                    @foreach(range(1, 12) as $bulan)
                        <option value="{{ sprintf('%02d', $bulan) }}">
                            {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select id="filterTahun" aria-label="Pilih tahun">
                    <option value="">Semua Tahun</option>

                    @foreach(range(now()->year, now()->year - 5) as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>

                <button type="button"
                    class="btn btn-sm btn-outline-primary"
                    id="resetTanggal">
                    Reset
                </button>
            </div>

        </div>

        <div class="mb-3">
            <small class="text-secondary">
                Menampilkan <span id="jumlahData">0</span> data
            </small>
        </div>

        <div class="alasan-table-wrap">

            <table class="alasan-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="tableGuru">

                    @forelse($daftarAlasan as $index => $alasan)

                    <tr class="guru-row"
                        data-status="{{ $alasan->status ?? 'Menunggu' }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($alasan->tanggal)->format('Y-m-d') }}">

                        <td>{{ $index + 1 }}</td>

                        <td class="nama-siswa">
                            <span class="siswa-avatar">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            {{ $alasan->user->name ?? 'Siswa' }}
                        </td>

                        <td style="white-space:nowrap">
                            {{ \Carbon\Carbon::parse($alasan->tanggal)->format('d M Y') }}
                        </td>

                        <td class="alasan-text">
                            {{ $alasan->alasan ?? '-' }}
                        </td>

                        <td>
                            @if($alasan->status == 'Diterima')
                                <span class="status-label status-diterima">
                                    Disetujui
                                </span>
                            @elseif($alasan->status == 'Ditolak')
                                <span class="status-label status-ditolak">
                                    Ditolak
                                </span>
                            @else
                                <span class="status-label status-menunggu">
                                    Menunggu
                                </span>
                            @endif
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="empty-data">
                            <i class="bi bi-inbox"></i>
                            Belum ada alasan keterlambatan dari siswa.
                        </td>
                    </tr>

                    @endforelse

                    <tr id="guruNoResult" style="display:none">
                        <td colspan="5" class="empty-data">
                            <i class="bi bi-search"></i>
                            Data tidak ditemukan.
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>


{{-- ==========================================
     HALAMAN PEMBIMBING
========================================== --}}

@elseif($isPembimbing)

<div class="container-fluid alasan-page">

    {{-- BANNER PEMBIMBING --}}
    {{-- Tombol Kembali sudah dihapus --}}

    <div class="pembimbing-banner">

        <div class="pembimbing-banner-icon">
            <i class="bi bi-clock-history"></i>
        </div>

        <div>
            <h2>Alasan Keterlambatan</h2>
            <p>Periksa pengajuan dan berikan keputusan atas alasan keterlambatan siswa.</p>
        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- PANEL TABEL --}}
    <div class="pembimbing-panel">

        <div class="pembimbing-panel-heading">

            <div>
                <h5>Daftar Pengajuan Keterlambatan</h5>
                <p>Kelola dan tinjau pengajuan keterlambatan siswa.</p>
            </div>

            <div class="pembimbing-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchPembimbing"
                    placeholder="Cari nama siswa...">
            </div>

        </div>

        <div class="alasan-table-wrap">

            <table class="pembimbing-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tablePembimbing">

                    @forelse($daftarAlasan as $index => $alasan)

                    <tr class="pembimbing-row">

                        <td>{{ $index + 1 }}</td>

                        <td class="nama-siswa">
                            <i class="bi bi-person-circle me-1 text-primary"></i>
                            {{ $alasan->user->name ?? 'Siswa' }}
                        </td>

                        <td style="white-space:nowrap">
                            {{ \Carbon\Carbon::parse($alasan->tanggal)->format('d M Y') }}
                        </td>

                        <td class="alasan-text">
                            {{ $alasan->alasan ?? '-' }}
                        </td>

                        <td>
                            @if($alasan->status == 'Diterima')
                                <span class="status-label status-diterima">
                                    Diterima
                                </span>
                            @elseif($alasan->status == 'Ditolak')
                                <span class="status-label status-ditolak">
                                    Ditolak
                                </span>
                            @else
                                <span class="status-label status-menunggu">
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($alasan->status == 'Menunggu')

                                <div class="pembimbing-action">

                                    <form action="{{ route('pembimbing.alasan.terima', $alasan->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="btn btn-terima"
                                            onclick="return confirm('Terima alasan ini?')">
                                            <i class="bi bi-check-lg"></i>
                                            Terima
                                        </button>
                                    </form>

                                    <form action="{{ route('pembimbing.alasan.tolak', $alasan->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="btn btn-tolak"
                                            onclick="return confirm('Tolak alasan ini?')">
                                            <i class="bi bi-x-lg"></i>
                                            Tolak
                                        </button>
                                    </form>

                                </div>

                            @else

                                <div class="text-end">
                                    <span class="pembimbing-finish">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Selesai
                                    </span>
                                </div>

                            @endif
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="empty-data">
                            <i class="bi bi-inbox"></i>
                            Belum ada pengajuan keterlambatan.
                        </td>
                    </tr>

                    @endforelse

                    <tr id="pembimbingNoResult" style="display:none">
                        <td colspan="6" class="empty-data">
                            <i class="bi bi-search"></i>
                            Data tidak ditemukan.
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>

@endif


{{-- ==========================================
     JAVASCRIPT GURU
========================================== --}}

@if($isGuru)

<script>
document.addEventListener('DOMContentLoaded', function() {

    const rows = Array.from(document.querySelectorAll('.guru-row'));
    const search = document.getElementById('searchGuru');
    const buttons = document.querySelectorAll('.filter-btn');

    const bulan = document.getElementById('filterBulan');
    const tahun = document.getElementById('filterTahun');
    const noResult = document.getElementById('guruNoResult');

    let activeStatus = 'semua';

    function filterGuru() {

        let keyword = search.value.toLowerCase();
        let total = 0;

        rows.forEach(function(row) {

            let status = row.dataset.status;
            let tanggal = row.dataset.tanggal;
            let text = row.innerText.toLowerCase();

            let cocokStatus =
                activeStatus === 'semua' || status === activeStatus;

            let cocokSearch = text.includes(keyword);

            let bagianTanggal = tanggal.split('-');

            let cocokBulan =
                !bulan.value || bagianTanggal[1] === bulan.value;

            let cocokTahun =
                !tahun.value || bagianTanggal[0] === tahun.value;

            let tampil =
                cocokStatus && cocokSearch && cocokBulan && cocokTahun;

            row.style.display = tampil ? '' : 'none';

            if (tampil) total++;
        });

        document.getElementById('jumlahData').textContent = total;

        noResult.style.display =
            total === 0 && rows.length > 0 ? '' : 'none';
    }

    buttons.forEach(function(button) {

        button.addEventListener('click', function() {

            buttons.forEach(btn => btn.classList.remove('active'));

            this.classList.add('active');

            activeStatus = this.dataset.status;

            filterGuru();
        });

    });

    search.addEventListener('input', filterGuru);
    bulan.addEventListener('change', filterGuru);
    tahun.addEventListener('change', filterGuru);

    document.getElementById('resetTanggal').addEventListener('click', function() {

        bulan.value = '';
        tahun.value = '';

        filterGuru();
    });

    let menunggu = rows.filter(row =>
        row.dataset.status === 'Menunggu'
    ).length;

    document.getElementById('countMenunggu').textContent = menunggu;

    filterGuru();

});
</script>

@endif


{{-- ==========================================
     JAVASCRIPT PEMBIMBING
========================================== --}}

@if($isPembimbing)

<script>
document.addEventListener('DOMContentLoaded', function() {

    const search = document.getElementById('searchPembimbing');
    const rows = document.querySelectorAll('.pembimbing-row');
    const noResult = document.getElementById('pembimbingNoResult');

    search.addEventListener('input', function() {

        let keyword = this.value.toLowerCase();
        let total = 0;

        rows.forEach(function(row) {

            let tampil = row.innerText.toLowerCase().includes(keyword);

            row.style.display = tampil ? '' : 'none';

            if (tampil) total++;
        });

        noResult.style.display =
            total === 0 && rows.length > 0 ? '' : 'none';

    });

});
</script>

@endif

@endsection