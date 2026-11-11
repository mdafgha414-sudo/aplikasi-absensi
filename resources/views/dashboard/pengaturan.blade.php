@extends('layouts.app')

@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --border: #e2e8f0;
        --background: #f8fafc;
        --text: #1e293b;
        --text-muted: #64748b;
    }

    .content-wrapper {
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--background);
        color: var(--text);
        min-height: 100vh;
        padding: 30px 32px 45px;
        max-width: 1400px;
        margin: auto;
    }

    /* HEADER */
    .breadcrumb {
        display: flex;
        gap: 8px;
        align-items: center;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .page-heading {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .heading-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #eff6ff;
        color: var(--primary);
        display: grid;
        place-items: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .page-heading h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
    }

    .page-heading p {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 6px;
    }

    .active-badge {
        margin-left: auto;
        padding: 8px 16px;
        border-radius: 20px;
        background: #dcfce7;
        color: #166534;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* PANEL */
    .schedule-panel {
        background: white;
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    /* PENGATURAN MASSAL */
    .massal-container {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 20px;
        margin-bottom: 24px;
        align-items: start;
    }

    .massal-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .massal-item {
        background: white;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        min-width: 0;
    }

    .massal-item label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .massal-item input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        color: #0f172a;
        outline: none;
    }

    .massal-item input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,.1);
    }

    .massal-item button {
        width: 100%;
        margin-top: 12px;
        padding: 10px;
        border: none;
        border-radius: 8px;
        background: var(--primary);
        color: white;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
    }

    .massal-item button:hover {
        background: var(--primary-hover);
    }

    /* INFORMASI HARI KERJA */
    .info-panel {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .info-box-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #eff6ff;
        color: var(--primary);
        display: grid;
        place-items: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .info-box-text h4 {
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    .info-box-text p {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .checkbox-semua {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        padding: 12px 16px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .checkbox-semua input {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
    }

    /* DAFTAR HARI */
    .day-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .day-card {
        display: grid;
        grid-template-columns: 70px 140px repeat(3, 1fr) 80px;
        align-items: center;
        gap: 16px;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        background: white;
        transition: .2s;
    }

    .day-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 4px 12px rgba(37,99,235,.05);
    }

    .day-check {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .day-check input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .day-check span {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    /* BADGE HARI */
    .day-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border-radius: 12px;
        text-align: center;
    }

    .day-badge i {
        font-size: 18px;
        margin-bottom: 6px;
    }

    .day-badge h3 {
        font-size: 14px;
        font-weight: 700;
    }

    .day-badge small {
        font-size: 10px;
        margin-top: 2px;
        opacity: .8;
    }

    .day-senin { background: #eff6ff; color: #1d4ed8; }
    .day-selasa { background: #f0fdf4; color: #15803d; }
    .day-rabu { background: #faf5ff; color: #7e22ce; }
    .day-kamis { background: #fff7ed; color: #c2410c; }
    .day-jumat { background: #f0f9ff; color: #0369a1; }
    .day-sabtu { background: #fef2f2; color: #b91c1c; }
    .day-minggu { background: #f8fafc; color: #475569; }

    /* INPUT JAM */
    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .field label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }

    .time-input {
        display: flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        background: #f8fafc;
    }

    .time-input:focus-within {
        border-color: var(--primary);
        background: white;
    }

    .time-input input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 13px;
        color: #0f172a;
        width: 100%;
        min-width: 0;
        font-weight: 500;
    }

    .time-input i {
        color: #94a3b8;
        font-size: 14px;
    }

    .field small {
        font-size: 10px;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* EDIT */
    .btn-edit {
        border: 1px solid #bfdbfe;
        background: #eff6ff;
        color: var(--primary);
        border-radius: 8px;
        padding: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit:hover {
        background: #dbeafe;
    }

    /* TOGGLE */
    .switch-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
    }

    .switch-status {
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
    }

    .switch {
        position: relative;
        display: inline-flex;
        width: 40px;
        height: 22px;
        cursor: pointer;
    }

    .switch input {
        position: absolute;
        opacity: 0;
    }

    .switch .slider {
        position: absolute;
        inset: 0;
        background: #cbd5e1;
        border-radius: 30px;
        transition: .3s;
    }

    .switch .slider::before {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        left: 3px;
        top: 3px;
        background: white;
        border-radius: 50%;
        transition: transform .3s;
    }

    .switch input:checked + .slider {
        background: var(--primary);
    }

    .switch input:checked + .slider::before {
        transform: translateX(18px);
    }

    /* FOOTER */
    .panel-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        border-top: 1px solid #e2e8f0;
        padding-top: 24px;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        padding: 12px 24px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }

    .btn-back {
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
    }

    .btn-save {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(37,99,235,.2);
    }

    .btn-save:hover {
        background: var(--primary-hover);
    }

    /* ALERT */
    .alert {
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* TABLET */
    @media (max-width: 1200px) {
        .massal-container {
            grid-template-columns: 1fr;
        }

        .info-panel {
            flex-direction: row;
        }

        .info-box,
        .checkbox-semua {
            flex: 1;
        }
    }

    @media (max-width: 1024px) {
        .day-card {
            grid-template-columns: 70px 120px repeat(3, 1fr);
        }

        .btn-edit {
            grid-column: 2 / -1;
            width: max-content;
            justify-self: end;
            margin-top: 8px;
        }
    }

    /* =================================
       OPTIMASI TAMPILAN MOBILE
    ================================= */
    @media (max-width: 768px) {
        .content-wrapper {
            width: 100%;
            max-width: 100%;
            min-height: auto;
            padding: 12px 10px 20px;
            overflow-x: hidden;
        }

        .breadcrumb {
            margin-bottom: 12px;
            font-size: 10px;
            gap: 6px;
        }

        .page-heading {
            display: grid;
            grid-template-columns: 38px minmax(0, 1fr);
            gap: 9px;
            align-items: center;
            margin-bottom: 14px;
        }

        .heading-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            font-size: 17px;
        }

        .page-heading h1 {
            font-size: 17px;
            line-height: 1.25;
        }

        .page-heading p {
            font-size: 10px;
            line-height: 1.45;
            margin-top: 3px;
        }

        .active-badge {
            grid-column: 2;
            justify-self: start;
            margin-left: 0;
            padding: 5px 9px;
            font-size: 9px;
        }

        .schedule-panel {
            padding: 9px;
            border-radius: 15px;
        }

        /* PENGATURAN MASSAL */
        .massal-container {
            grid-template-columns: 1fr;
            gap: 8px;
            padding: 9px;
            margin-bottom: 10px;
            border-radius: 12px;
        }

        .massal-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 7px;
        }

        .massal-item {
            min-width: 0;
            padding: 8px;
            border-radius: 9px;
        }

        .massal-item:last-child {
            grid-column: 1 / -1;
        }

        .massal-item label {
            min-height: 20px;
            margin-bottom: 5px;
            font-size: 9px;
        }

        .massal-item input {
            min-width: 0;
            padding: 7px;
            font-size: 11px;
        }

        .massal-item button {
            min-height: 31px;
            margin-top: 7px;
            padding: 6px 4px;
            font-size: 8px;
            line-height: 1.3;
        }

        /* TOTAL HARI DAN PILIH SEMUA */
        .info-panel {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 6px;
        }

        .info-box {
            min-width: 0;
            gap: 7px;
            padding: 7px;
            border-radius: 9px;
        }

        .info-box-icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .info-box-text h4 {
            font-size: 9px;
            line-height: 1.3;
        }

        .info-box-text p {
            font-size: 8px;
        }

        .checkbox-semua {
            min-width: 0;
            gap: 5px;
            padding: 7px;
            font-size: 8px;
            line-height: 1.3;
            border-radius: 9px;
        }

        .checkbox-semua input {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        /* KARTU HARI LEBIH PENDEK */
        .day-list {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .day-card {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            grid-template-rows: auto auto auto;
            align-items: center;
            gap: 6px;
            min-width: 0;
            padding: 8px;
            border-radius: 10px;
        }

        .day-check {
            grid-column: 1 !important;
            grid-row: 1;
            justify-content: flex-start;
            align-self: center;
            gap: 4px;
        }

        .day-check input {
            width: 14px;
            height: 14px;
        }

        .day-check span {
            font-size: 8px;
        }

        .day-badge {
            grid-column: 2 / 4 !important;
            grid-row: 1;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            gap: 6px;
            min-height: 30px;
            padding: 4px 7px;
            border-radius: 7px;
            text-align: left;
        }

        .day-badge i {
            margin: 0;
            font-size: 11px;
        }

        .day-badge h3 {
            font-size: 10px;
            line-height: 1.15;
        }

        .day-badge small {
            display: block;
            font-size: 8px;
            margin-top: 0;
        }

        /* TIGA JAM SEJAJAR */
        .day-card > .field:nth-child(3),
        .day-card > .field:nth-child(4),
        .day-card > .field:nth-child(5) {
            grid-column: auto !important;
            grid-row: 2;
            min-width: 0;
            gap: 3px;
        }

        .field label {
            min-height: 20px;
            margin: 0;
            font-size: 8px;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .time-input {
            min-width: 0;
            min-height: 31px;
            padding: 4px 5px;
            border-radius: 6px;
        }

        .time-input input {
            width: 100%;
            min-width: 0;
            font-size: 11px;
            padding: 0;
        }

        .time-input i,
        .field small {
            display: none !important;
        }

        /* EDIT / TOGGLE */
        .day-card > div:last-child {
            grid-column: 1 / -1 !important;
            grid-row: 3;
            min-height: 25px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-edit {
            min-width: 62px;
            padding: 5px 9px;
            font-size: 9px;
        }

        .switch-wrapper {
            flex-direction: row;
            justify-content: flex-end;
            gap: 5px;
            margin: 0;
        }

        .switch {
            width: 34px;
            height: 19px;
        }

        .switch .slider::before {
            width: 13px;
            height: 13px;
            left: 3px;
            top: 3px;
        }

        .switch input:checked + .slider::before {
            transform: translateX(15px);
        }

        .switch-status {
            font-size: 8px;
        }

        /* TOMBOL BAWAH */
        .panel-footer {
            margin-top: 10px;
            padding-top: 10px;
            gap: 7px;
        }

        .panel-footer .btn {
            min-height: 35px;
            padding: 7px 10px;
            font-size: 9px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 12px;
            font-size: 10px;
            border-radius: 9px;
        }
    }

    /* HP KECIL */
    @media (max-width: 380px) {
        .content-wrapper {
            padding: 10px 8px 18px;
        }

        .schedule-panel {
            padding: 8px;
        }

        .massal-container {
            padding: 8px;
        }

        .massal-grid {
            gap: 6px;
        }

        .massal-item {
            padding: 7px;
        }

        .massal-item button {
            font-size: 8px;
        }

        .info-box {
            padding: 6px;
        }

        .checkbox-semua {
            padding: 6px 5px;
            font-size: 8px;
        }

        .day-card {
            gap: 5px;
            padding: 7px;
        }

        .field label {
            font-size: 7px;
        }

        .time-input input {
            font-size: 10px;
        }

        .day-badge h3 {
            font-size: 9px;
        }

        .panel-footer .btn {
            padding: 8px 9px;
            font-size: 9px;
        }
    }
</style>

<div class="content-wrapper">

    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <i class="fa-solid fa-house"></i>
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span>Pengaturan</span>
    </div>

    <!-- HEADER -->
    <div class="page-heading">
        <div class="heading-icon">
            <i class="fa-solid fa-clock"></i>
        </div>

        <div>
            <h1>Pengaturan Jadwal Absensi</h1>
            <p>Atur waktu masuk, batas keterlambatan, dan jam pulang untuk setiap hari.</p>
        </div>

        <div class="active-badge">
            <i class="fa-solid fa-circle-check"></i>
            Pengaturan Aktif
        </div>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Pengaturan belum berhasil disimpan.</strong>
                <ul style="margin:4px 0 0 16px; font-size:12px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ url('/admin/setting') }}" method="POST" id="formSetting">
        @csrf

        <input type="hidden" name="apply_to_all" id="apply_to_all" value="false">

        <div class="schedule-panel">

            <!-- PENGATURAN MASSAL -->
            <div class="massal-container">

                <div class="massal-grid">

                    <div class="massal-item">
                        <label>Waktu Masuk</label>
                        <input type="time" id="massal_masuk" value="08:00">
                        <button type="button" onclick="terapkanMassal('masuk')">
                            Terapkan Waktu Masuk
                        </button>
                    </div>

                    <div class="massal-item">
                        <label>Batas Jam Telat</label>
                        <input type="time" id="massal_telat" value="08:15">
                        <button type="button" onclick="terapkanMassal('telat')">
                            Terapkan Batas Telat
                        </button>
                    </div>

                    <div class="massal-item">
                        <label>Jam Pulang</label>
                        <input type="time" id="massal_pulang" value="16:00">
                        <button type="button" onclick="terapkanMassal('pulang')">
                            Terapkan Jam Pulang
                        </button>
                    </div>

                </div>

                <!-- INFORMASI HARI KERJA -->
                <div class="info-panel">

                    <div class="info-box">
                        <div class="info-box-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>

                        <div class="info-box-text">
                            <h4>Total Hari Kerja</h4>
                            <p>
                                <span id="totalHariKerja">7</span>
                                hari dalam seminggu
                            </p>
                        </div>
                    </div>

                    <label class="checkbox-semua">
                        <input type="checkbox" id="pilihSemuaHari">
                        Pilih Semua Hari
                    </label>

                </div>
            </div>

            <!-- DATA HARI -->
            @php
                $days = [
                    'senin' => ['name' => 'Senin', 'icon' => 'fa-calendar-day', 'class' => 'day-senin'],
                    'selasa' => ['name' => 'Selasa', 'icon' => 'fa-calendar-day', 'class' => 'day-selasa'],
                    'rabu' => ['name' => 'Rabu', 'icon' => 'fa-calendar-day', 'class' => 'day-rabu'],
                    'kamis' => ['name' => 'Kamis', 'icon' => 'fa-calendar-day', 'class' => 'day-kamis'],
                    'jumat' => ['name' => 'Jumat', 'icon' => 'fa-calendar-day', 'class' => 'day-jumat'],
                    'sabtu' => ['name' => 'Sabtu', 'icon' => 'fa-calendar-weekend', 'class' => 'day-sabtu'],
                    'minggu' => ['name' => 'Minggu', 'icon' => 'fa-calendar-weekend', 'class' => 'day-minggu']
                ];
            @endphp

            <div class="day-list">

                @foreach($days as $key => $day)

                    @php
                        $isWeekend = in_array($key, ['sabtu', 'minggu']);

                        $isActive = $isWeekend
                            ? ($jadwal[$key]['aktif'] ?? ($key === 'sabtu' ? '1' : '0'))
                            : '1';

                        $jamMasuk = $jadwal[$key]['masuk'] ?? '07:00';
                        $jamTelat = $jadwal[$key]['telat'] ?? '07:15';
                        $jamPulang = $jadwal[$key]['pulang'] ?? '15:00';
                    @endphp

                    <div class="day-card">

                        <!-- CHECKBOX PILIH -->
                        <div class="day-check">
                            <input
                                type="checkbox"
                                class="pilih-hari-jadwal"
                                value="{{ $key }}"
                            >
                            <span>Pilih</span>
                        </div>

                        <!-- NAMA HARI -->
                        <div class="day-badge {{ $day['class'] }}">
                            <i class="fa-solid {{ $day['icon'] }}"></i>

                            <div>
                                <h3>{{ $day['name'] }}</h3>

                                <small>
                                    {{ $isWeekend
                                        ? ($isActive == '1' ? 'Hari Kerja' : 'Hari Libur')
                                        : 'Hari Kerja' }}
                                </small>
                            </div>
                        </div>

                        <!-- WAKTU MASUK -->
                        <div class="field">
                            <label>Waktu Masuk</label>

                            <div class="time-input">
                                <input
                                    type="time"
                                    name="jam_masuk_{{ $key }}"
                                    value="{{ $jamMasuk }}"
                                    class="input-massal-masuk"
                                >

                                <i class="fa-regular fa-clock"></i>
                            </div>

                            <small>Jam mulai kerja</small>
                        </div>

                        <!-- BATAS TELAT -->
                        <div class="field">
                            <label>Batas Jam Telat</label>

                            <div class="time-input">
                                <input
                                    type="time"
                                    name="jam_telat_{{ $key }}"
                                    value="{{ $jamTelat }}"
                                    class="input-massal-telat"
                                >

                                <i class="fa-regular fa-clock"></i>
                            </div>

                            <small>Batas waktu keterlambatan</small>
                        </div>

                        <!-- JAM PULANG -->
                        <div class="field">
                            <label>Jam Pulang</label>

                            <div class="time-input">
                                <input
                                    type="time"
                                    name="jam_pulang_{{ $key }}"
                                    value="{{ $jamPulang }}"
                                    class="input-massal-pulang"
                                >

                                <i class="fa-regular fa-clock"></i>
                            </div>

                            <small>Jam selesai kerja</small>
                        </div>

                        <!-- EDIT / TOGGLE -->
                        <div>

                            @if($isWeekend)

                                <div class="switch-wrapper">

                                    <label class="switch">
                                        <input
                                            type="checkbox"
                                            name="status_{{ $key }}"
                                            value="1"
                                            class="toggle-hari"
                                            {{ $isActive == '1' ? 'checked' : '' }}
                                        >

                                        <span class="slider"></span>
                                    </label>

                                    <span class="switch-status">
                                        {{ $isActive == '1' ? 'Aktif' : 'Nonaktif' }}
                                    </span>

                                </div>

                            @else

                                <button type="button" class="btn-edit">
                                    <i class="fas fa-pen"></i>
                                    Edit
                                </button>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

            <!-- FOOTER -->
            <div class="panel-footer">

                <a href="{{ url('/pembimbing/dashboard') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-save">
                    <i class="fa-regular fa-floppy-disk"></i>
                    Simpan Pengaturan
                </button>

            </div>

        </div>
    </form>

</div>

<script>

    // FUNGSI TERAPKAN MASSAL
    function terapkanMassal(jenis) {

        const nilai = document.getElementById('massal_' + jenis).value;

        const inputs = document.querySelectorAll('.input-massal-' + jenis);

        inputs.forEach(input => {
            input.value = nilai;
        });

        // Animasi notifikasi tombol
        const btn = event.target;

        const originalText = btn.innerText;

        btn.innerText = 'Berhasil Diterapkan!';

        btn.style.background = '#16a34a';

        setTimeout(() => {

            btn.innerText = originalText;

            btn.style.background = 'var(--primary)';

        }, 1500);
    }


    // HITUNG TOTAL HARI KERJA
    function updateTotalHariKerja() {

        let total = 0;

        // Senin sampai Jumat
        total += 5;

        // Sabtu dan Minggu
        const sabtuAktif =
            document.querySelector('input[name="status_sabtu"]')?.checked;

        const mingguAktif =
            document.querySelector('input[name="status_minggu"]')?.checked;

        if (sabtuAktif) total++;

        if (mingguAktif) total++;

        document.getElementById('totalHariKerja').innerText = total;
    }


    // INISIALISASI
    document.addEventListener('DOMContentLoaded', () => {

        updateTotalHariKerja();

        // Toggle hari kerja
        document.querySelectorAll('.toggle-hari').forEach(toggle => {

            toggle.addEventListener('change', function() {

                const statusText =
                    this.closest('.switch-wrapper')
                        .querySelector('.switch-status');

                statusText.innerText =
                    this.checked ? 'Aktif' : 'Nonaktif';

                updateTotalHariKerja();

            });

        });

        // PILIH SEMUA HARI
        const pilihSemua =
            document.getElementById('pilihSemuaHari');

        if (pilihSemua) {

            pilihSemua.addEventListener('change', function() {

                const checkboxes =
                    document.querySelectorAll('.pilih-hari-jadwal');

                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });

            });

        }

    });

</script>

@endsection