
@extends('layouts.app')

@section('content')

<style>
.qr-page {
    padding: 24px;
    color: #172554;
}

.qr-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 28px 32px;
    margin-bottom: 24px;
    background: linear-gradient(120deg, #fff, #dbeafe);
    border: 1px solid #dbeafe;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(37,99,235,.08);
}

.qr-hero-content {
    display: flex;
    align-items: center;
    gap: 22px;
}

.qr-hero-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 82px;
    height: 82px;
    background: linear-gradient(135deg,#38bdf8,#2563eb);
    border-radius: 20px;
}

.qr-hero h2 {
    margin: 0 0 10px;
    color: #172554;
    font-size: 28px;
    font-weight: 750;
}

.qr-hero p {
    margin: 0;
    color: #64748b;
    font-size: 15px;
}

.qr-illustration {
    width: 150px;
    flex-shrink: 0;
}

.qr-table-card {
    padding: 22px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(15,23,42,.05);
}

.qr-table-wrapper {
    overflow-x: auto;
    border: 1px solid #e2e8f0;
    border-radius: 15px;
}

.qr-table {
    width: 100%;
    min-width: 650px;
    margin: 0;
    border-collapse: collapse;
}

.qr-table thead {
    background: #eff6ff;
}

.qr-table th {
    padding: 18px 20px;
    color: #1e3a8a;
    font-size: 14px;
    font-weight: 700;
    white-space: nowrap;
    border-bottom: 1px solid #dbeafe;
}

.qr-table td {
    padding: 18px 20px;
    color: #334155;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.qr-table tbody tr:last-child td {
    border-bottom: none;
}

.qr-table tbody tr:hover {
    background: #f8fbff;
}

.qr-code-badge {
    display: inline-block;
    padding: 8px 14px;
    color: white;
    background: #64748b;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
}

.qr-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 16px;
    color: white;
    background: linear-gradient(135deg,#3b82f6,#075cff);
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(37,99,235,.18);
    transition: .2s ease;
}

.qr-action-btn:hover {
    color: white;
    transform: translateY(-2px);
}

.qr-empty {
    padding: 35px !important;
    text-align: center;
    color: #94a3b8 !important;
}

@media (max-width: 768px) {
    .qr-page {
        padding: 14px;
    }

    .qr-hero {
        padding: 20px;
    }

    .qr-hero-content {
        gap: 14px;
    }

    .qr-hero-icon {
        width: 60px;
        height: 60px;
    }

    .qr-hero h2 {
        font-size: 21px;
    }

    .qr-hero p {
        font-size: 13px;
        line-height: 1.6;
    }

    .qr-illustration {
        width: 80px;
    }

    .qr-table-card {
        padding: 12px;
    }
}
</style>

<div class="qr-page">

    <div class="qr-hero">
        <div class="qr-hero-content">

            <div class="qr-hero-icon">
                <svg width="42" height="42" viewBox="0 0 24 24"
                     fill="none" stroke="white" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                    <path d="M14 14h3v3h-3zM20 14v2M14 20h2M19 19h2v2"/>
                </svg>
            </div>

            <div>
                <h2>Cetak Kartu QR Siswa</h2>
                <p>Kelola dan cetak kartu QR untuk siswa dengan mudah dan cepat.</p>
            </div>

        </div>

        <svg class="qr-illustration" viewBox="0 0 180 120"
             xmlns="http://www.w3.org/2000/svg">
            <rect x="8" y="13" width="164" height="94"
                  rx="14" fill="#bfdbfe"/>

            <g transform="rotate(-8 90 60)">
                <rect x="18" y="17" width="144" height="86"
                      rx="12" fill="white" stroke="#60a5fa" stroke-width="3"/>

                <circle cx="51" cy="47" r="12" fill="#93c5fd"/>
                <path d="M30 79 Q51 48 72 79" fill="#93c5fd"/>

                <g transform="translate(91 32)" fill="#1e3a8a">
                    <rect width="12" height="12"/>
                    <rect x="4" y="4" width="4" height="4" fill="white"/>
                    <rect x="25" width="12" height="12"/>
                    <rect x="29" y="4" width="4" height="4" fill="white"/>
                    <rect y="25" width="12" height="12"/>
                    <rect x="4" y="29" width="4" height="4" fill="white"/>
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
        <div class="qr-table-wrapper">
            <table class="qr-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Kode Kartu</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswas as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $siswa->nama ?? $siswa->name }}</strong>
                            </td>
                            <td>{{ $siswa->email }}</td>
                            <td>
                                <span class="qr-code-badge">
                                    {{ $siswa->kode_kartu }}
                                </span>
                            </td>
                            <td style="text-align:center">
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
