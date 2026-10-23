
@extends('layouts.app')

@section('content')
<style>
    .attendance-page {
        --primary: #3978f6;
        --ink: #1e2b45;
        --muted: #8290aa;
        color: var(--ink);
        padding: 20px 16px 36px;
    }

    .attendance-page * {
        box-sizing: border-box;
    }

    .attendance-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        background: #fff;
        border: 1px solid #edf1f8;
        border-radius: 18px;
        padding: 24px 26px;
        margin-bottom: 22px;
        box-shadow: 0 5px 20px rgba(35, 56, 95, .035);
    }

    .attendance-heading-left {
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .attendance-icon {
        width: 66px;
        height: 66px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        background: #edf2ff;
        color: var(--primary);
        border-radius: 17px;
        font-size: 29px;
    }

    .attendance-heading h2 {
        font-size: 25px;
        font-weight: 750;
        margin: 0 0 7px;
        letter-spacing: -.6px;
    }

    .attendance-heading p {
        color: var(--muted);
        margin: 0;
        font-size: 14px;
    }

    .attendance-date {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #fff;
        border: 1px solid #e3eaf6;
        border-radius: 12px;
        color: #526482;
        font-size: 13px;
        white-space: nowrap;
    }

    .attendance-card {
        background: #fff;
        border: 1px solid #edf1f8;
        border-radius: 18px;
        padding: 24px 25px;
        min-height: 350px;
        box-shadow: 0 5px 22px rgba(35, 56, 95, .04);
    }

    .attendance-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
    }

    .attendance-search {
        position: relative;
        width: 350px;
        max-width: 100%;
    }

    .attendance-search i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8492ae;
        font-size: 17px;
    }

    .attendance-search input {
        width: 100%;
        height: 46px;
        padding: 0 15px 0 43px;
        border: 1px solid #e2e9f5;
        border-radius: 12px;
        outline: none;
        background: #fafbfe;
        color: var(--ink);
        font-size: 13px;
        transition: .2s;
    }

    .attendance-search input:focus {
        border-color: #8eafff;
        box-shadow: 0 0 0 3px rgba(57, 120, 246, .09);
        background: #fff;
    }

    .attendance-count {
        color: #8794ab;
        font-size: 12px;
        margin: 0;
    }

    .attendance-table-wrap {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #e6edf7;
        border-radius: 13px;
    }

    .attendance-table {
        width: 100%;
        min-width: 760px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .attendance-table thead th {
        background: #f5f7fc;
        color: #637291;
        padding: 17px 18px;
        font-size: 11px;
        font-weight: 750;
        letter-spacing: .65px;
        white-space: nowrap;
        border-bottom: 1px solid #e5ebf5;
    }

    .attendance-table tbody td {
        padding: 19px 18px;
        border-bottom: 1px solid #edf1f7;
        color: #465774;
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .attendance-table tbody tr:last-child td {
        border-bottom: none;
    }

    .attendance-table tbody tr {
        transition: background .2s;
    }

    .attendance-table tbody tr:hover {
        background: #fafbff;
    }

    .attendance-number {
        color: #8a97ae;
        font-weight: 600;
    }

    .attendance-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .attendance-avatar {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: linear-gradient(135deg, #80a9ff, #4c78f6);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(76, 120, 246, .17);
    }

    .attendance-name {
        color: #283853;
        font-weight: 700;
        font-size: 13px;
    }

    .attendance-date-cell {
        color: #344562;
        font-weight: 600;
    }

    .attendance-time {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .attendance-time i {
        font-size: 14px;
    }

    .time-in {
        color: #15985b;
        background: #e6f7ed;
    }

    .time-out {
        color: #1478ed;
        background: #e8f3ff;
    }

    .time-pending {
        color: #7d8799;
        background: #f0f2f6;
        font-size: 11px;
    }

    .attendance-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-late {
        background: #fff0f2;
        color: #ed4d67;
    }

    .status-on-time {
        background: #e7f8ef;
        color: #179b60;
    }

    .attendance-empty {
        text-align: center;
        padding: 55px 15px !important;
        color: #8b98ae !important;
        white-space: normal !important;
    }

    .attendance-empty i {
        display: block;
        font-size: 32px;
        color: #b7c7e4;
        margin-bottom: 12px;
    }

    .attendance-empty strong {
        display: block;
        color: #52627e;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .attendance-empty span {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .attendance-page {
            padding: 12px 4px 25px;
        }

        .attendance-heading {
            align-items: flex-start;
            padding: 18px;
            border-radius: 15px;
        }

        .attendance-heading-left {
            gap: 12px;
        }

        .attendance-icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            font-size: 22px;
        }

        .attendance-heading h2 {
            font-size: 19px;
        }

        .attendance-heading p {
            font-size: 12px;
            line-height: 1.6;
        }

        .attendance-date {
            display: none;
        }

        .attendance-card {
            padding: 17px 13px;
            border-radius: 15px;
        }

        .attendance-toolbar {
            margin-bottom: 15px;
        }

        .attendance-search {
            width: 100%;
        }

        .attendance-search input {
            height: 43px;
        }

        .attendance-table thead th {
            padding: 14px;
            font-size: 10px;
        }

        .attendance-table tbody td {
            padding: 14px;
        }
    }

    @media (max-width: 400px) {
        .attendance-heading {
            padding: 15px 12px;
        }

        .attendance-heading h2 {
            font-size: 17px;
        }

        .attendance-icon {
            width: 42px;
            height: 42px;
        }

        .attendance-card {
            padding: 14px 10px;
        }
    }
</style>

<div class="container-fluid attendance-page">

    {{-- HEADER LAPORAN --}}
    <div class="attendance-heading">
        <div class="attendance-heading-left">
            <div class="attendance-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <div>
                <h2>Laporan Absensi</h2>
                <p>Pantau waktu masuk, waktu pulang, dan status kehadiran pengguna.</p>
            </div>
        </div>

        <div class="attendance-date">
            <i class="bi bi-calendar3"></i>
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d M Y') }}</span>
        </div>
    </div>

    {{-- TABEL LAPORAN --}}
    <div class="attendance-card">

        <div class="attendance-toolbar">
            <div class="attendance-search">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="attendanceSearch"
                    placeholder="Cari nama pengguna..."
                    aria-label="Cari nama pengguna"
                >
            </div>

            <p class="attendance-count">
                Total data: <strong id="attendanceCount">{{ $laporanAbsensi->count() }}</strong>
            </p>
        </div>

        <div class="attendance-table-wrap">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>NAMA PENGGUNA</th>
                        <th>TANGGAL</th>
                        <th>JAM MASUK</th>
                        <th>JAM PULANG</th>
                        <th>STATUS</th>
                    </tr>
                </thead>

                <tbody id="attendanceTableBody">
                    @forelse($laporanAbsensi as $index => $absensi)
                        <tr class="attendance-row">
                            <td class="attendance-number">{{ $index + 1 }}</td>

                            <td>
                                <div class="attendance-user">
                                    <div class="attendance-avatar">
                                        {{ strtoupper(substr($absensi->user->name ?? '?', 0, 1)) }}
                                    </div>

                                    <span class="attendance-name">
                                        {{ $absensi->user->name ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="attendance-date-cell">
                                    {{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                </span>
                            </td>

                            <td>
                                <span class="attendance-time time-in">
                                    <i class="bi bi-clock"></i>
                                    {{ $absensi->jam_masuk ?? '-' }}
                                </span>
                            </td>

                            <td>
                                @if($absensi->jam_pulang)
                                    <span class="attendance-time time-out">
                                        <i class="bi bi-clock-history"></i>
                                        {{ $absensi->jam_pulang }}
                                    </span>
                                @else
                                    <span class="attendance-time time-pending">
                                        Belum Pulang
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($absensi->status == 'Telat')
                                    <span class="attendance-status status-late">
                                        <i class="bi bi-clock"></i>
                                        Telat
                                    </span>
                                @else
                                    <span class="attendance-status status-on-time">
                                        <i class="bi bi-check-circle"></i>
                                        Tepat Waktu
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="attendance-empty">
                                <i class="bi bi-calendar2-x"></i>
                                <strong>Belum ada data absensi</strong>
                                <span>Data absensi akan ditampilkan di sini.</span>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="attendanceNoResults" style="display: none;">
                        <td colspan="6" class="attendance-empty">
                            <i class="bi bi-search"></i>
                            <strong>Data tidak ditemukan</strong>
                            <span>Coba gunakan kata kunci nama yang lain.</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('attendanceSearch');
        const rows = document.querySelectorAll('.attendance-row');
        const countElement = document.getElementById('attendanceCount');
        const noResults = document.getElementById('attendanceNoResults');

        if (!searchInput) return;

        function filterAttendance() {
            const keyword = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            rows.forEach(function (row) {
                const name = row.querySelector('.attendance-name');

                const matches = name &&
                    name.textContent.toLowerCase().includes(keyword);

                row.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleCount++;
                }
            });

            countElement.textContent = visibleCount;

            if (noResults) {
                noResults.style.display =
                    rows.length > 0 && visibleCount === 0 ? '' : 'none';
            }
        }

        searchInput.addEventListener('input', filterAttendance);
    });
</script>
@endsection
