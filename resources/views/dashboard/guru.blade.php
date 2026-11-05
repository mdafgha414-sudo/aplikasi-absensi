
@extends('layouts.app')

@section('content')

<style>
    :root {
        --tim-blue: #0284c7;
        --tim-blue-dark: #075985;
        --tim-blue-light: #e0f2fe;
        --tim-bg: #f1f7fc;
    }

    .journal-page {
        background: var(--tim-bg);
        min-height: 100vh;
        padding: 28px 0;
    }

    .journal-page .main-title {
        font-size: 27px;
        font-weight: 800;
        color: #12304a;
    }

    .journal-page .subtitle {
        color: #64748b;
        font-size: 14px;
    }

    .journal-hero {
        background: linear-gradient(120deg, #dff3ff, #eff8ff);
        border: 1px solid #c7e8fa;
        border-radius: 22px;
        padding: 32px;
        position: relative;
        overflow: hidden;
    }

    .journal-hero h3 {
        color: #075985;
        font-weight: 800;
    }

    .journal-hero p {
        color: #42677f;
    }

    .hero-icon {
        position: absolute;
        right: 35px;
        top: 20px;
        font-size: 85px;
        color: #0284c7;
        opacity: .13;
    }

    .journal-card, .stat-card {
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 22px rgba(30,80,120,.07);
    }

    .stat-card {
        height: 100%;
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        flex-shrink: 0;
    }

    .section-title {
        color: #163b57;
        font-weight: 750;
        font-size: 18px;
    }

    .search-box {
        border: 1px solid #dceaf4;
        border-radius: 11px;
        padding: 10px 14px;
        background: #f8fbfe;
        min-width: 230px;
    }

    .search-box:focus {
        border-color: #38a8e8;
        box-shadow: 0 0 0 3px rgba(2,132,199,.1);
        outline: none;
    }

    .journal-page .table thead th {
        background: #eaf6fd;
        color: #075985;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
        padding: 17px 13px;
        border: none;
        white-space: nowrap;
    }

    .journal-page .table tbody td {
        padding: 16px 13px;
        border-color: #edf2f7;
        font-size: 13px;
        vertical-align: middle;
    }

    .journal-page .table tbody tr:hover {
        background: #f5fbff;
    }

    .student-avatar {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #dff2ff;
        color: #0277b9;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 800;
        flex-shrink: 0;
    }

    .activity-text {
        max-width: 270px;
        white-space: normal;
        line-height: 1.6;
        color: #475569;
    }

    .problem-text {
        max-width: 190px;
        white-space: normal;
        color: #64748b;
    }

    .btn-blue {
        background: var(--tim-blue);
        color: white;
        border: none;
        border-radius: 9px;
        padding: 9px 15px;
    }

    .btn-blue:hover {
        background: var(--tim-blue-dark);
        color: white;
    }

    .export-btn {
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        padding: 9px 13px;
        white-space: nowrap;
    }

    .filter-select {
        border: 1px solid #dceaf4;
        border-radius: 9px;
        padding: 9px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        background-color: #f8fbfe;
        min-width: 135px;
    }

    .filter-select:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2,132,199,.1);
    }

    .empty-state {
        padding: 55px 15px;
        color: #94a3b8;
    }

    .journal-page .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    @media(max-width: 768px) {
        .journal-page {
            padding: 15px 0;
        }

        .journal-hero {
            padding: 23px 20px;
        }

        .journal-hero h3 {
            font-size: 21px;
        }

        .hero-icon {
            font-size: 55px;
            right: 15px;
        }

        .journal-page .main-title {
            font-size: 22px;
        }

        .filter-area {
            width: 100%;
        }

        .filter-area select {
            flex: 1;
            min-width: 0;
        }

        .export-area {
            width: 100%;
        }

        .export-area a {
            flex: 1;
            text-align: center;
        }

        .search-box {
            width: 100%;
        }
    }
</style>

<div class="journal-page">
    <div class="container-fluid px-3 px-lg-5">

        {{-- HERO --}}
        <div class="journal-hero mb-4">
            <i class="bi bi-journal-richtext hero-icon"></i>

            <div class="position-relative">
                <h3 class="mb-2">Laporan Jurnal Harian PKL</h3>
                <p class="mb-0">
                    Pantau aktivitas, kendala, dan perkembangan kegiatan
                    Praktik Kerja Lapangan seluruh siswa.
                </p>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="row g-3 mb-4">

            <div class="col-12 col-md-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small fw-bold mb-2">
                                TOTAL SISWA PKL
                            </p>
                            <h2 class="fw-bold mb-0 text-dark">
                                {{ $totalSiswa ?? 0 }}
                            </h2>
                            <small class="text-secondary">Siswa terdaftar</small>
                        </div>
                        <div class="stat-icon"
                             style="background:#e0f2fe;color:#0284c7;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small fw-bold mb-2">
                                TOTAL JURNAL
                            </p>
                            <h2 class="fw-bold mb-0 text-dark">
                                {{ $semuaJurnal->count() }}
                            </h2>
                            <small class="text-secondary">Jurnal sesuai filter</small>
                        </div>
                        <div class="stat-icon"
                             style="background:#e0f2fe;color:#0284c7;">
                            <i class="bi bi-journal-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
                <div class="stat-card">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-secondary small fw-bold mb-2">
                                BELUM DINILAI
                            </p>
                            <h2 class="fw-bold mb-0 text-dark">
                                {{ $semuaJurnal->whereNull('nilai')->count() }}
                            </h2>
                            <small class="text-secondary">Menunggu penilaian</small>
                        </div>
                        <div class="stat-icon"
                             style="background:#fff7df;color:#d99a17;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- TABEL JURNAL --}}
        <div class="journal-card">
            <div class="card-body p-3 p-md-4">

                {{-- JUDUL DAN FILTER --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>
                        <h5 class="section-title mb-1">
                            <i class="bi bi-journal-text me-2"
                               style="color:#0284c7;"></i>
                            Daftar Jurnal Siswa
                        </h5>
                        <p class="text-secondary small mb-0">
                            Informasi kegiatan harian siswa PKL.
                        </p>
                    </div>

                    <div class="d-flex align-items-center flex-wrap gap-2">

                        {{-- FILTER BULAN DAN TAHUN --}}
                        <form action="{{ url()->current() }}"
                              method="GET"
                              id="formFilterJurnal"
                              class="d-flex align-items-center flex-wrap gap-2">

                            <div class="d-flex gap-2 filter-area">

                                <select name="bulan"
                                        id="filterBulan"
                                        class="form-select filter-select"
                                        onchange="document.getElementById('formFilterJurnal').submit()">

                                    <option value="semua"
                                        {{ ($bulan ?? 'semua') == 'semua' ? 'selected' : '' }}>
                                        Semua Bulan
                                    </option>

                                    @foreach($daftarBulan as $angka => $nama)
                                        <option value="{{ $angka }}"
                                            {{ ($bulan ?? 'semua') == $angka ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach

                                </select>

                                <select name="tahun"
                                        id="filterTahun"
                                        class="form-select filter-select"
                                        onchange="document.getElementById('formFilterJurnal').submit()">

                                    <option value="semua"
                                        {{ ($tahun ?? 'semua') == 'semua' ? 'selected' : '' }}>
                                        Semua Tahun
                                    </option>

                                    @foreach($daftarTahun as $th)
                                        <option value="{{ $th }}"
                                            {{ ($tahun ?? 'semua') == $th ? 'selected' : '' }}>
                                            {{ $th }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </form>

                        {{-- EXPORT --}}
                        <div class="d-flex gap-2 export-area">

                            <a id="btnExcel"
                               href="{{ route('guru.export.excel', [
                                   'bulan' => $bulan ?? 'semua',
                                   'tahun' => $tahun ?? 'semua'
                               ]) }}"
                               class="btn btn-outline-success export-btn">
                                <i class="bi bi-file-earmark-excel me-1"></i>
                                Export Excel
                            </a>

                            <a id="btnPDF"
                               href="{{ route('guru.export.pdf', [
                                   'bulan' => $bulan ?? 'semua',
                                   'tahun' => $tahun ?? 'semua'
                               ]) }}"
                               class="btn btn-outline-danger export-btn">
                                <i class="bi bi-file-earmark-pdf me-1"></i>
                                Export PDF
                            </a>

                        </div>

                    </div>
                </div>

                {{-- PENCARIAN --}}
                <div class="mb-3">
                    <div class="position-relative" style="max-width:350px;">
                        <i class="bi bi-search position-absolute"
                           style="left:13px;top:12px;color:#94a3b8;"></i>

                        <input type="text"
                               id="searchJurnal"
                               class="form-control search-box ps-5"
                               placeholder="Cari nama atau kegiatan siswa...">
                    </div>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="tableJurnal">

                        <thead>
                            <tr>
                                <th>TANGGAL</th>
                                <th>NAMA SISWA</th>
                                <th>KEGIATAN</th>
                                <th>KENDALA</th>
                                <th class="text-center">NILAI</th>

                                @if(Auth::user()->role === 'pembimbing')
                                    <th class="text-center">AKSI</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($semuaJurnal as $jurnal)

                                <tr>
                                    <td class="text-nowrap">
                                        <span class="fw-semibold text-dark">
                                            <i class="bi bi-calendar3 me-1"
                                               style="color:#0284c7;"></i>
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($jurnal->user->name ?? 'S', 0, 1)) }}
                                            </div>

                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $jurnal->user->name ?? 'Siswa' }}
                                                </div>
                                                <small class="text-secondary">Siswa PKL</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="activity-text">
                                            {{ $jurnal->kegiatan }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="problem-text">
                                            {{ $jurnal->kendala ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        @if($jurnal->nilai !== null)
                                            <span class="badge rounded-pill px-3 py-2"
                                                  style="background:#dcfce7;color:#15803d;">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ $jurnal->nilai }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-2"
                                                  style="background:#f1f5f9;color:#64748b;">
                                                Belum Dinilai
                                            </span>
                                        @endif
                                    </td>

                                    @if(Auth::user()->role === 'pembimbing')
                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn btn-blue btn-sm fw-semibold text-nowrap"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalNilai{{ $jurnal->id }}">
                                                <i class="bi bi-pencil-square me-1"></i>
                                                Beri Nilai
                                            </button>
                                        </td>
                                    @endif

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'pembimbing' ? 6 : 5 }}"
                                        class="text-center">
                                        <div class="empty-state">
                                            <i class="bi bi-calendar-x display-3 d-block mb-3"></i>
                                            <h6 class="fw-bold text-secondary">
                                                Tidak Ada Jurnal
                                            </h6>
                                            <p class="small mb-0">
                                                Belum ada jurnal pada bulan atau tahun yang kamu pilih.
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div id="hasilPencarian"
                     class="text-center text-secondary small mt-3"
                     style="display:none;">
                    Data jurnal tidak ditemukan.
                </div>

            </div>
        </div>

    </div>
</div>

{{-- MODAL PENILAIAN --}}
@if(Auth::user()->role === 'pembimbing')

    @foreach($semuaJurnal as $jurnal)

        <div class="modal fade"
             id="modalNilai{{ $jurnal->id }}"
             tabindex="-1"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg">

                    <div class="modal-header border-0 px-4 pt-4">
                        <div>
                            <span class="badge rounded-pill mb-2"
                                  style="background:#e0f2fe;color:#0284c7;">
                                PENILAIAN SISWA
                            </span>
                            <h5 class="modal-title fw-bold text-dark">
                                Penilaian Jurnal
                            </h5>
                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('guru.nilai', $jurnal->id) }}"
                          method="POST">

                        @csrf

                        <div class="modal-body px-4">

                            <div class="p-3 rounded-3 mb-4"
                                 style="background:#f0f9ff;">

                                <small class="text-secondary d-block mb-1">
                                    Nama Siswa
                                </small>

                                <strong class="text-dark">
                                    {{ $jurnal->user->name ?? 'Siswa' }}
                                </strong>

                                <hr class="my-2">

                                <small class="text-secondary d-block mb-1">
                                    Tanggal Jurnal
                                </small>

                                <strong class="text-dark">
                                    {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                </strong>

                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">
                                    Nilai (0-100)
                                </label>

                                <input type="number"
                                       name="nilai"
                                       class="form-control form-control-lg"
                                       min="0"
                                       max="100"
                                       value="{{ $jurnal->nilai }}"
                                       placeholder="Masukkan nilai siswa"
                                       required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-bold small">
                                    Catatan Guru / Ulasan
                                </label>

                                <textarea name="catatan_guru"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Berikan masukan untuk siswa...">{{ $jurnal->catatan_guru }}</textarea>
                            </div>

                        </div>

                        <div class="modal-footer border-0 px-4 pb-4">
                            <button type="button"
                                    class="btn btn-light fw-semibold"
                                    data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit"
                                    class="btn btn-blue fw-semibold px-4">
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

{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // PENCARIAN JURNAL
    const search = document.getElementById('searchJurnal');
    const table = document.getElementById('tableJurnal');
    const emptyMessage = document.getElementById('hasilPencarian');

    if (search && table) {
        search.addEventListener('input', function () {

            const keyword = this.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr');

            let visibleRows = 0;

            rows.forEach(function (row) {

                const text = row.innerText.toLowerCase();
                const match = text.includes(keyword);

                row.style.display = match ? '' : 'none';

                if (match) {
                    visibleRows++;
                }

            });

            emptyMessage.style.display =
                (keyword !== '' && visibleRows === 0) ? 'block' : 'none';

        });
    }

});
</script>

@endsection
