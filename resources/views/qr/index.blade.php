
@extends('layouts.app')

@section('content')

<style>
.qr-page {
    min-height: calc(100vh - 100px);
    padding: 24px;
    color: #1e293b;
    background: #ffffff;
}

/* Banner judul */
.qr-page .qr-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 25px 30px;
    margin-bottom: 24px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: 5px solid #2684ff;
    border-radius: 16px;
    box-shadow: 0 5px 18px rgba(15, 23, 42, 0.04);
}

.qr-page .qr-hero-content {
    display: flex;
    align-items: center;
    gap: 18px;
}

.qr-page .qr-hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 68px;
    height: 68px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 16px;
}

.qr-page .qr-hero h2 {
    margin: 0 0 7px;
    color: #172554;
    font-size: 25px;
    font-weight: 700;
}

.qr-page .qr-hero p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

.qr-page .qr-illustration {
    width: 125px;
    height: auto;
    flex-shrink: 0;
}

/* Kartu tabel */
.qr-page .qr-table-card {
    padding: 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 5px 18px rgba(15, 23, 42, 0.04);
}

.qr-page .qr-table-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
}

.qr-page .qr-table-heading h3 {
    margin: 0;
    color: #1e293b;
    font-size: 17px;
    font-weight: 700;
}

.qr-page .qr-table-heading p {
    margin: 5px 0 0;
    color: #94a3b8;
    font-size: 13px;
}

.qr-page .qr-table-wrapper {
    overflow-x: auto;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
}

.qr-page .qr-table {
    width: 100%;
    min-width: 650px;
    margin: 0;
    border-collapse: collapse;
}

.qr-page .qr-table thead {
    background: #f1f6fd;
}

.qr-page .qr-table th {
    padding: 16px 18px;
    color: #334e7e;
    font-size: 13px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
    border-bottom: 1px solid #e2e8f0;
}

.qr-page .qr-table td {
    padding: 17px 18px;
    color: #475569;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.qr-page .qr-table tbody tr:last-child td {
    border-bottom: none;
}

.qr-page .qr-table tbody tr {
    transition: background 0.2s ease;
}

.qr-page .qr-table tbody tr:hover {
    background: #f8fbff;
}

.qr-page .qr-student-name {
    color: #1e293b;
    font-weight: 600;
}

.qr-page .qr-code-badge {
    display: inline-block;
    padding: 7px 12px;
    color: #1d4ed8;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.qr-page .qr-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 14px;
    color: #ffffff;
    background: #2677f5;
    border: 1px solid #2677f5;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.2s ease, transform 0.2s ease;
}

.qr-page .qr-action-btn:hover {
    color: #ffffff;
    background: #155ed1;
    border-color: #155ed1;
    transform: translateY(-1px);
}

.qr-page .qr-empty {
    padding: 35px !important;
    text-align: center;
    color: #94a3b8 !important;
}

@media (max-width: 768px) {
    .qr-page {
        padding: 14px;
    }

    .qr-page .qr-hero {
        padding: 18px;
    }

    .qr-page .qr-hero-content {
        gap: 12px;
    }

    .qr-page .qr-hero-icon {
        width: 54px;
        height: 54px;
    }

    .qr-page .qr-hero h2 {
        font-size: 20px;
    }

    .qr-page .qr-hero p {
        font-size: 12px;
    }

    .qr-page .qr-illustration {
        width: 75px;
    }

    .qr-page .qr-table-card {
        padding: 12px;
    }
}
</style>

<div class="qr-page">

    <div class="qr-hero">
        <div class="qr-hero-content">

            <div class="qr-hero-icon">
                <svg width="36" height="36" viewBox="0 0 24 24"
                     fill="none" stroke="#2677f5" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                    <path d="M14 14h3v3h-3zM20 14v2M14 20h2M19 19h2v2"/>
                </svg>
            </div>

            <div>
                <h2>Cetak Kartu QR Siswa</h2>
                <p>Kelola dan cetak kartu QR siswa dengan mudah dan cepat.</p>
            </div>

        </div>

        <svg class="qr-illustration" viewBox="0 0 180 120"
             xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="13" width="164" height="94"
                  rx="14" fill="#dbeafe"/>

            <g transform="rotate(-8 90 60)">
                <rect x="18" y="17" width="144" height="86"
                      rx="12" fill="#ffffff"
                      stroke="#93c5fd" stroke-width="2"/>

                <circle cx="51" cy="47" r="12" fill="#bfdbfe"/>
                <path d="M30 79 Q51 48 72 79" fill="#bfdbfe"/>

                <g transform="translate(91 32)" fill="#2563eb">
                    <rect width="12" height="12"/>
                    <rect x="4" y="4" width="4" height="4" fill="#ffffff"/>
                    <rect x="25" width="12" height="12"/>
                    <rect x="29" y="4" width="4" height="4" fill="#ffffff"/>
                    <rect y="25" width="12" height="12"/>
                    <rect x="4" y="29" width="4" height="4" fill="#ffffff"/>
                    <rect x="17" y="4" width="4" height="4"/>
                    <rect x="17" y="13" width="4" height="4"/>
                    <rect x="13" y="21" width="4" height="4"/>
                    <rect x="21" y="21" width="4" height="4"/>
                    <rect x="17" y="29" width="4" height="4"/>
                    <rect x="29" y="21" width="4" height="4"/>
                    <rect x="25" y="29" width="12" height="4"/>
                </g>
            </g>
        </svg>
    </div>

    <div class="qr-table-card">

        <div class="qr-table-heading">
            <div>
                <h3>Daftar Kartu QR Siswa</h3>
                <p>Pilih siswa untuk membuat kartu QR.</p>
            </div>
        </div>

        <div class="qr-table-wrapper">
            <table class="qr-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Kode Kartu</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswas as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="qr-student-name">
                                    {{ $siswa->nama ?? $siswa->name }}
                                </span>
                            </td>
                            <td>{{ $siswa->email }}</td>
                            <td>
                                <span class="qr-code-badge">
                                    {{ $siswa->kode_kartu }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ url('/cetak-qr/' . $siswa->id) }}"
                                   class="qr-action-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor"
                                         stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"/>
                                        <rect x="14" y="3" width="7" height="7"/>
                                        <rect x="3" y="14" width="7" height="7"/>
                                    </svg>
                                    Buat Kode QR
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="qr-empty">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection
