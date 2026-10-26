<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Jadwal Absensi | Timetrix</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2878f0;
            --navy: #172d50;
            --text: #243b60;
            --muted: #8192ad;
            --border: #e2ebf8;
            --background: #f3f7fd;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
            min-height: 100vh;
        }

        button, input {
            font-family: inherit;
        }

        button {
            cursor: pointer;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 230px;
            background: linear-gradient(180deg, #172d50, #102341);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
        }

        .brand {
            height: 80px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.09);
            flex-shrink: 0;
        }

        .brand-icon {
            color: #57b9ff;
            font-size: 30px;
        }

        .brand h2 {
            font-size: 21px;
            letter-spacing: -.6px;
        }

        .brand p {
            font-size: 10px;
            color: #a9bad4;
            margin-top: 3px;
        }

        .nav-label {
            padding: 28px 25px 12px;
            color: #92a7c6;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px 17px;
            margin: 0 12px 7px;
            border-radius: 10px;
            color: #d5e1f3;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-link i {
            width: 19px;
            font-size: 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(110deg, #3988ff, #2370ed);
            color: white;
        }

        .nav-link.logout {
            color: #ff858c;
        }

        .nav-link.logout:hover {
            background: rgba(255,90,105,.12);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 24px;
            color: #a9bad4;
            font-size: 11px;
            line-height: 1.7;
        }

        .sidebar-footer i {
            font-size: 25px;
            color: #6b9de7;
            margin-bottom: 13px;
        }

        /* LAPISAN GELAP UNTUK MENU MOBILE */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(12, 27, 49, .45);
            z-index: 900;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* KONTEN UTAMA */
        .main {
            margin-left: 230px;
            min-height: 100vh;
            transition: margin-left .3s ease;
        }

        /* HEADER */
        .topbar {
            height: 80px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid #e8eef7;
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 500;
        }

        .menu-toggle {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border: 1px solid #e3ebf6;
            background: white;
            color: #31547f;
            font-size: 19px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            position: relative;
            z-index: 1100;
            transition: .2s;
        }

        .menu-toggle:hover {
            background: #eaf2ff;
            color: var(--primary);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f5f8fd;
            border: 1px solid #e9eff9;
            border-radius: 13px;
            padding: 0 16px;
            height: 42px;
            max-width: 430px;
            flex: 1;
            color: #8b9bb5;
        }

        .search-box input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            color: var(--text);
            font-size: 12px;
        }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .notification {
            position: relative;
            color: #45648d;
            font-size: 19px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #2878f0;
            color: white;
            font-weight: 700;
        }

        .profile-info strong {
            display: block;
            font-size: 12px;
        }

        .profile-info small {
            display: block;
            font-size: 10px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* AREA KONTEN */
        .content {
            max-width: 1450px;
            padding: 30px 32px 45px;
            margin: auto;
        }

        .breadcrumb {
            display: flex;
            gap: 11px;
            align-items: center;
            font-size: 11px;
            color: #8396b4;
            margin-bottom: 27px;
        }

        .breadcrumb i:first-child {
            color: var(--primary);
        }

        .page-heading {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 27px;
        }

        .heading-icon {
            width: 54px;
            height: 54px;
            border-radius: 17px;
            background: #e0edff;
            color: var(--primary);
            display: grid;
            place-items: center;
            font-size: 23px;
            flex-shrink: 0;
        }

        .page-heading h1 {
            font-size: clamp(20px, 2vw, 27px);
            font-weight: 800;
            color: #1b3153;
            letter-spacing: -.7px;
        }

        .page-heading p {
            font-size: 12px;
            color: #7185a4;
            margin-top: 8px;
            line-height: 1.6;
        }

        .active-badge {
            margin-left: auto;
            padding: 11px 15px;
            border-radius: 12px;
            background: #dcf9ee;
            color: #11966d;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* PANEL JADWAL */
        .schedule-panel {
            background: white;
            border: 1px solid #e4edfa;
            border-radius: 20px;
            padding: 18px;
            box-shadow: 0 12px 40px rgba(41,77,125,.045);
        }

        .panel-heading {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(110deg, #edf5ff, #f7faff);
            border-radius: 14px;
            padding: 19px;
            margin-bottom: 17px;
        }

        .panel-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #d8e9ff;
            color: #2878f0;
            font-size: 21px;
        }

        .panel-heading h2 {
            font-size: 15px;
            color: #233d63;
        }

        .panel-heading p {
            font-size: 11px;
            color: #8192ad;
            margin-top: 6px;
            line-height: 1.6;
        }

        .total-days {
            margin-left: auto;
            border: 1px solid #d4e5ff;
            border-radius: 11px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2878f0;
            flex-shrink: 0;
        }

        .total-days i {
            font-size: 20px;
        }

        .total-days small {
            display: block;
            color: #8192ad;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .total-days strong {
            display: block;
            font-size: 11px;
        }

        /* KARTU HARI */
        .day-card {
            --day-color: #2878f0;
            --day-light: #e8f1ff;

            display: grid;
            grid-template-columns: 100px minmax(0,1fr) minmax(0,1fr) minmax(0,1fr) 82px;
            align-items: center;
            gap: 14px;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 13px;
            margin-bottom: 13px;
            transition: border-color .2s, box-shadow .2s;
        }

        .day-card:hover {
            border-color: #bdd7ff;
            box-shadow: 0 5px 18px rgba(48,111,205,.055);
        }

        .day-card.tuesday {
            --day-color: #13a778;
            --day-light: #e4f9f0;
        }

        .day-card.wednesday {
            --day-color: #8951e8;
            --day-light: #f1e8ff;
        }

        .day-card.thursday {
            --day-color: #e87922;
            --day-light: #fff0df;
        }

        .day-card.friday {
            --day-color: #089bb9;
            --day-light: #e0f8fc;
        }

        .day-card.saturday {
            --day-color: #d9437b;
            --day-light: #ffe8f0;
        }

        .day-card.sunday {
            --day-color: #8493a9;
            --day-light: #edf1f5;
            background: #fafbfd;
        }

        .day-info {
            background: var(--day-light);
            border-radius: 11px;
            text-align: center;
            padding: 12px 5px;
            color: var(--day-color);
        }

        .day-icon {
            width: 34px;
            height: 34px;
            margin: 0 auto 8px;
            border-radius: 50%;
            background: white;
            display: grid;
            place-items: center;
        }

        .day-info h3 {
            font-size: 12px;
            font-weight: 800;
        }

        .day-info small {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            color: #7e91ad;
        }

        .field label {
            display: block;
            font-size: 10px;
            font-weight: 600;
            color: #687e9f;
            margin-bottom: 8px;
        }

        .time-input {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #dfe9f8;
            border-radius: 9px;
            padding: 0 10px;
            height: 39px;
            background: white;
            transition: .2s;
        }

        .time-input:focus-within {
            border-color: #80b3ff;
            box-shadow: 0 0 0 3px rgba(40,120,240,.08);
        }

        .time-input input {
            width: 100%;
            min-width: 0;
            border: none;
            outline: none;
            color: #294567;
            background: transparent;
            font-size: 12px;
        }

        .time-input i {
            color: #607796;
            font-size: 12px;
        }

        .field-hint {
            display: block;
            margin-top: 7px;
            color: #8295b0;
            font-size: 9px;
            line-height: 1.4;
        }

        .edit-button {
            border: 1px solid #d6e5fa;
            background: #f5f9ff;
            color: #2878f0;
            border-radius: 9px;
            padding: 11px 10px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .edit-button:hover:not(:disabled) {
            background: #2878f0;
            color: white;
            border-color: #2878f0;
        }

        .day-card:not(.editing) .time-input {
            background: #f9fbfe;
        }

        .day-card:not(.editing) .time-input input {
            pointer-events: none;
        }

        .day-card.sunday .time-input,
        .day-card.sunday .edit-button {
            opacity: .55;
        }

        /* INFORMASI DAN TOMBOL */
        .info-note {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #edf5ff;
            color: #4a80ca;
            padding: 13px 15px;
            border-radius: 10px;
            margin-top: 17px;
            font-size: 10px;
            line-height: 1.6;
        }

        .info-note i {
            font-size: 15px;
        }

        .panel-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-top: 1px solid #e9eff8;
            padding-top: 18px;
            margin-top: 18px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 10px;
            padding: 12px 17px;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .btn-back {
            border: 1px solid #dce6f4;
            background: white;
            color: #526c8f;
        }

        .btn-back:hover {
            background: #f3f7fd;
        }

        .btn-save {
            border: none;
            background: linear-gradient(110deg, #3988ff, #236ee9);
            color: white;
            box-shadow: 0 5px 13px rgba(40,120,240,.18);
        }

        .btn-save:hover {
            transform: translateY(-1px);
        }

        .success-message {
            background: #e2f8ec;
            border: 1px solid #c3efd6;
            color: #168553;
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 12px;
        }

        .error-message {
            background: #fff0f0;
            color: #c73939;
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 12px;
        }

        /* RESPONSIVE LAPTOP KECIL */
        @media (max-width: 1100px) {
            .day-card {
                grid-template-columns: 80px repeat(3, minmax(0,1fr));
            }

            .edit-button {
                grid-column: 2 / -1;
                justify-self: end;
                min-width: 90px;
            }

            .content {
                padding: 25px 20px;
            }

            .topbar {
                padding: 0 20px;
            }
        }

        /* RESPONSIVE HP */
        @media (max-width: 760px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                height: 68px;
                gap: 12px;
                padding: 0 12px;
            }

            .topbar-right {
                gap: 12px;
            }

            .profile-info {
                display: none;
            }

            .search-box {
                padding: 0 10px;
            }

            .content {
                padding: 22px 13px 30px;
            }

            .page-heading {
                flex-wrap: wrap;
            }

            .active-badge {
                margin-left: 0;
            }

            .schedule-panel {
                padding: 11px;
                border-radius: 15px;
            }

            .panel-heading {
                flex-wrap: wrap;
                padding: 14px;
            }

            .total-days {
                margin-left: 0;
                width: 100%;
            }

            .day-card {
                grid-template-columns: 1fr;
                gap: 13px;
                padding: 14px;
            }

            .day-info {
                display: flex;
                align-items: center;
                gap: 10px;
                text-align: left;
                padding: 10px 12px;
            }

            .day-icon {
                margin: 0;
                flex-shrink: 0;
            }

            .day-info small {
                margin: 0 0 0 auto;
            }

            .field label {
                font-size: 11px;
            }

            .time-input {
                height: 43px;
            }

            .edit-button {
                grid-column: auto;
                justify-self: stretch;
                padding: 12px;
            }

            .panel-footer {
                flex-wrap: wrap;
            }

            .btn {
                flex: 1;
            }
        }

        /* MODE SIDEBAR TERTUTUP DI LAPTOP */
        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.sidebar-collapsed .main {
            margin-left: 0;
        }

        /* PASTIKAN SIDEBAR TERLIHAT JIKA MODE MOBILE DIBUKA */
        @media (max-width: 760px) {
            body.sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-collapsed .main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <i class="fa-regular fa-calendar-check brand-icon"></i>
        <div>
            <h2>Timetrix</h2>
            <p>Attendance System</p>
        </div>
    </div>

    <div class="nav-label">MENU UTAMA</div>

    <a href="{{ url('/dashboard') }}" class="nav-link">
        <i class="fa-solid fa-house"></i>
        Dashboard Admin
    </a>

    <div class="nav-label">PENGATURAN</div>

    <a href="{{ url('/pengaturan') }}" class="nav-link active">
        <i class="fa-solid fa-gear"></i>
        Pengaturan
    </a>

    <a href="{{ url('/logout') }}"
       class="nav-link logout"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </a>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" hidden>
        @csrf
    </form>

    <div class="sidebar-footer">
        <i class="fa-solid fa-calendar-days"></i>
        <p>Kelola waktu, tingkatkan produktivitas bersama Timetrix.</p>
    </div>
</aside>

<main class="main">

    <header class="topbar">
        <button type="button"
                class="menu-toggle"
                id="menuToggle"
                aria-label="Buka atau tutup sidebar"
                aria-expanded="true">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search"
                   id="searchInput"
                   placeholder="Cari hari atau pengaturan...">
        </div>

        <div class="topbar-right">
            <div class="notification">
                <i class="fa-regular fa-bell"></i>
            </div>

            <div class="profile">
                <div class="avatar">A</div>
                <div class="profile-info">
                    <strong>Halo, Admin</strong>
                    <small>Administrator</small>
                </div>
            </div>
        </div>
    </header>

    <section class="content">

        <div class="breadcrumb">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Pengaturan</span>
        </div>

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

        @if(session('success'))
            <div class="success-message">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                <strong>Pengaturan belum berhasil disimpan.</strong>
                <ul style="margin:8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/pengaturan') }}" method="POST">
            @csrf

            <div class="schedule-panel">

                <div class="panel-heading">
                    <div class="panel-icon">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>

                    <div>
                        <h2>Jadwal Kehadiran Mingguan</h2>
                        <p>Atur jadwal absensi untuk seluruh hari kerja.<br>
                           Pastikan waktu sesuai ketentuan sekolah atau instansi.</p>
                    </div>

                    <div class="total-days">
                        <i class="fa-regular fa-clock"></i>
                        <div>
                            <small>Total Hari Kerja</small>
                            <strong>6 hari dalam seminggu</strong>
                        </div>
                    </div>
                </div>

                @php
                    $days = [
                        'senin' => ['Senin', 'monday'],
                        'selasa' => ['Selasa', 'tuesday'],
                        'rabu' => ['Rabu', 'wednesday'],
                        'kamis' => ['Kamis', 'thursday'],
                        'jumat' => ['Jumat', 'friday'],
                        'sabtu' => ['Sabtu', 'saturday'],
                        'minggu' => ['Minggu', 'sunday'],
                    ];

                    $defaultSchedules = [
                        'masuk' => '07:00',
                        'telat' => '07:15',
                        'pulang' => '15:00',
                    ];
                @endphp

                @foreach($days as $key => $day)
                    @php
                        $isSunday = $key === 'minggu';
                        $schedule = $jadwal[$key] ?? $defaultSchedules;
                    @endphp

                    <div class="day-card {{ $day[1] }} {{ $isSunday ? 'sunday' : '' }}"
                         data-day="{{ $day[0] }}"
                         data-holiday="{{ $isSunday ? 'true' : 'false' }}">

                        <div class="day-info">
                            <div class="day-icon">
                                <i class="fa-regular fa-calendar-check"></i>
                            </div>
                            <h3>{{ $day[0] }}</h3>
                            <small>{{ $isSunday ? 'Hari Libur' : 'Hari Kerja' }}</small>
                        </div>

                        <div class="field">
                            <label for="{{ $key }}_masuk">Waktu Masuk</label>
                            <div class="time-input">
                                <input type="time"
                                       id="{{ $key }}_masuk"
                                       name="jadwal[{{ $key }}][masuk]"
                                       value="{{ old("jadwal.$key.masuk", $schedule['masuk'] ?? '07:00') }}"
                                       {{ $isSunday ? 'disabled' : 'readonly' }}>
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <small class="field-hint">
                                {{ $isSunday ? 'Tidak aktif' : 'Jam mulai kerja' }}
                            </small>
                        </div>

                        <div class="field">
                            <label for="{{ $key }}_telat">Batas Jam Telat</label>
                            <div class="time-input">
                                <input type="time"
                                       id="{{ $key }}_telat"
                                       name="jadwal[{{ $key }}][telat]"
                                       value="{{ old("jadwal.$key.telat", $schedule['telat'] ?? '07:15') }}"
                                       {{ $isSunday ? 'disabled' : 'readonly' }}>
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <small class="field-hint">
                                {{ $isSunday ? 'Tidak aktif' : 'Batas waktu keterlambatan' }}
                            </small>
                        </div>

                        <div class="field">
                            <label for="{{ $key }}_pulang">Jam Pulang</label>
                            <div class="time-input">
                                <input type="time"
                                       id="{{ $key }}_pulang"
                                       name="jadwal[{{ $key }}][pulang]"
                                       value="{{ old("jadwal.$key.pulang", $schedule['pulang'] ?? '15:00') }}"
                                       {{ $isSunday ? 'disabled' : 'readonly' }}>
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <small class="field-hint">
                                {{ $isSunday ? 'Tidak aktif' : 'Jam selesai kerja' }}
                            </small>
                        </div>

                        <button type="button"
                                class="edit-button"
                                {{ $isSunday ? 'disabled' : '' }}>
                            <i class="fa-solid fa-pen"></i>
                            Edit
                        </button>

                    </div>
                @endforeach

                <div class="info-note">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>
                        Klik tombol Edit untuk mengubah jadwal.
                        Perubahan dikirim setelah tombol Simpan Pengaturan ditekan.
                    </span>
                </div>

                <div class="panel-footer">
                    <a href="{{ url('/dashboard') }}" class="btn btn-back">
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

    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const searchInput = document.getElementById('searchInput');

    // Tombol garis tiga berfungsi di laptop maupun HP.
    menuToggle.addEventListener('click', function () {
        if (window.innerWidth <= 760) {
            const isOpen = sidebar.classList.toggle('open');
            overlay.classList.toggle('show', isOpen);
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        } else {
            document.body.classList.toggle('sidebar-collapsed');

            const isOpen = !document.body.classList.contains('sidebar-collapsed');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        }
    });

    // Tutup sidebar mobile saat area gelap diklik.
    overlay.addEventListener('click', function () {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');
    });

    // Tutup sidebar mobile jika pengguna memilih menu.
    sidebar.querySelectorAll('.nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 760) {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            }
        });
    });

    // Atur tampilan sidebar ketika ukuran jendela berubah.
    window.addEventListener('resize', function () {
        if (window.innerWidth > 760) {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        }
    });

    // Fungsi Edit jadwal.
    document.querySelectorAll('.edit-button').forEach(function (button) {
        button.addEventListener('click', function () {
            const card = button.closest('.day-card');

            if (card.dataset.holiday === 'true') {
                return;
            }

            const inputs = card.querySelectorAll('input[type="time"]');
            const isEditing = card.classList.toggle('editing');

            inputs.forEach(function (input) {
                input.readOnly = !isEditing;
            });

            button.innerHTML = isEditing
                ? '<i class="fa-solid fa-check"></i> Selesai'
                : '<i class="fa-solid fa-pen"></i> Edit';

            if (isEditing) {
                inputs[0].focus();
            }
        });
    });

    // Pencarian berdasarkan nama hari.
    searchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();

        document.querySelectorAll('.day-card').forEach(function (card) {
            const dayName = card.dataset.day.toLowerCase();

            card.style.display = dayName.includes(keyword) ? '' : 'none';
        });
    });
});
</script>

</body>
</html>
```