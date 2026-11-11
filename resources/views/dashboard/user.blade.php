
@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .user-dashboard {
        width: 100%;
        max-width: 1150px;
        margin: 15px auto;
        padding: 0 14px;
        color: #243454;
        font-family: Arial, sans-serif;
        box-sizing: border-box;
    }

    .user-dashboard *,
    .user-dashboard *::before,
    .user-dashboard *::after {
        box-sizing: border-box;
    }

    /* BANNER */

    .ud-welcome {
        position: relative;
        overflow: hidden;
        padding: 35px;
        border-radius: 22px;
        color: #1e3a8a;
        background: #e0f2fe;
        box-shadow: 0 12px 28px rgba(14, 165, 233, .10);
        margin-bottom: 25px;
        border: 1px solid #bae6fd;
    }

    .ud-welcome::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.4);
        right: -45px;
        top: -95px;
    }

    .ud-welcome::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,.3);
        right: 100px;
        bottom: -100px;
    }

    .ud-welcome-content {
        position: relative;
        z-index: 2;
    }

    .ud-eyebrow {
        display: inline-block;
        padding: 7px 13px;
        background: #fff;
        border: 1px solid #bae6fd;
        border-radius: 30px;
        font-size: 12px;
        margin-bottom: 17px;
        color: #0284c7;
        font-weight: bold;
    }

    .ud-welcome h2 {
        font-size: clamp(25px, 4vw, 36px);
        font-weight: 800;
        margin-bottom: 12px;
        color: #0f172a;
        line-height: 1.3;
    }

    .ud-welcome p {
        max-width: 520px;
        color: #334155;
        line-height: 1.8;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .ud-primary-btn {
        display: inline-block;
        padding: 12px 20px;
        background: #fff;
        color: #0284c7;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        transition: .2s;
        border: 1px solid #bae6fd;
    }

    .ud-primary-btn:hover {
        background: #f0f9ff;
        color: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(2, 132, 199, .15);
    }

    .ud-hero-icon {
        position: absolute;
        right: 55px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 105px;
        opacity: .15;
        z-index: 1;
        color: #0284c7;
        pointer-events: none;
    }

    /* JUDUL MENU */

    .ud-section-title {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 7px;
        color: #243454;
    }

    .ud-section-subtitle {
        color: #8490a7;
        font-size: 14px;
        margin-bottom: 19px;
    }

    /* MENU CARD */

    .ud-menu-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 27px;
    }

    .ud-menu-card {
        position: relative;
        overflow: hidden;
        padding: 24px;
        background: white;
        border: 1px solid #e8ecf5;
        border-radius: 18px;
        text-decoration: none;
        color: #243454;
        box-shadow: 0 5px 18px rgba(34, 53, 92, .05);
        transition: .25s;
        min-width: 0;
    }

    .ud-menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(34, 53, 92, .11);
        color: #243454;
    }

    .ud-menu-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        font-size: 27px;
        border-radius: 16px;
        margin-bottom: 19px;
    }

    .ud-blue {
        background: #e8efff;
        color: #3658d4;
    }

    .ud-purple {
        background: #f0e9ff;
        color: #7547d8;
    }

    .ud-menu-card h5 {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .ud-menu-card p {
        color: #7d8aa3;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 18px;
    }

    .ud-menu-link {
        font-size: 14px;
        font-weight: bold;
        color: #4965d6;
    }

    .ud-menu-arrow {
        position: absolute;
        right: 23px;
        bottom: 22px;
        font-size: 23px;
        color: #7186d8;
    }

    /* INFORMASI TAMBAHAN */

    .ud-bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .ud-panel {
        background: white;
        border: 1px solid #e8ecf5;
        border-radius: 18px;
        padding: 23px;
        box-shadow: 0 5px 18px rgba(34, 53, 92, .04);
        min-width: 0;
    }

    .ud-panel h5 {
        font-weight: 800;
        margin-bottom: 20px;
        font-size: 17px;
    }

    .ud-step {
        display: flex;
        gap: 13px;
        align-items: flex-start;
        margin-bottom: 17px;
    }

    .ud-step:last-child {
        margin-bottom: 0;
    }

    .ud-step-number {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 11px;
        background: #edf1ff;
        color: #4965d6;
        font-size: 18px;
    }

    .ud-step strong {
        display: block;
        margin: 2px 0 5px;
        font-size: 14px;
    }

    .ud-step small {
        color: #8490a7;
        line-height: 1.6;
    }

    .ud-reminder {
        background: linear-gradient(135deg, #eaf7ff, #f1edff);
        border: 0;
    }

    .ud-reminder-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        background: white;
        color: #6655d9;
        border-radius: 16px;
        font-size: 28px;
        margin-bottom: 16px;
    }

    .ud-reminder p {
        color: #687a9b;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .ud-footer {
        text-align: center;
        color: #96a1b4;
        font-size: 12px;
        padding: 10px 0 20px;
    }

    .ud-icon {
        display: inline-block;
        line-height: 1;
        vertical-align: middle;
    }

    /* TABLET */

    @media (max-width: 991px) {
        .ud-welcome {
            padding: 28px;
        }

        .ud-hero-icon {
            right: 25px;
            font-size: 85px;
        }

        .ud-menu-grid,
        .ud-bottom-grid {
            gap: 15px;
        }
    }

    /* ==========================
       KHUSUS HP
    ========================== */

    @media (max-width: 700px) {

        .user-dashboard {
            width: 100%;
            max-width: 100%;
            margin: 5px auto;
            padding: 0 10px;
        }

        .ud-welcome {
            padding: 17px 15px;
            border-radius: 15px;
            margin-bottom: 17px;
        }

        .ud-eyebrow {
            font-size: 9px;
            padding: 5px 9px;
            margin-bottom: 9px;
        }

        .ud-welcome h2 {
            font-size: 19px;
            line-height: 1.35;
            margin-bottom: 7px;
        }

        .ud-welcome p {
            font-size: 11px;
            line-height: 1.55;
            margin-bottom: 12px;
            max-width: 88%;
        }

        .ud-primary-btn {
            padding: 8px 11px;
            font-size: 10px;
            border-radius: 8px;
        }

        .ud-hero-icon {
            right: 8px;
            font-size: 43px;
            opacity: .08;
        }

        .ud-section-title {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .ud-section-subtitle {
            font-size: 11px;
            margin-bottom: 11px;
        }

        .ud-menu-grid,
        .ud-bottom-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .ud-menu-card {
            padding: 14px;
            border-radius: 13px;
        }

        .ud-menu-icon {
            width: 37px;
            height: 37px;
            font-size: 18px;
            border-radius: 10px;
            margin-bottom: 9px;
        }

        .ud-menu-card h5 {
            font-size: 13px;
            margin-bottom: 5px;
        }

        .ud-menu-card p {
            font-size: 10px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .ud-menu-link {
            font-size: 10px;
        }

        .ud-menu-arrow {
            right: 13px;
            bottom: 13px;
            font-size: 16px;
        }

        .ud-panel {
            padding: 14px;
            border-radius: 13px;
        }

        .ud-panel h5 {
            font-size: 13px;
            margin-bottom: 12px;
        }

        .ud-step {
            gap: 9px;
            margin-bottom: 11px;
        }

        .ud-step-number {
            width: 27px;
            height: 27px;
            font-size: 12px;
            border-radius: 8px;
        }

        .ud-step strong {
            font-size: 10px;
        }

        .ud-step small {
            font-size: 10px;
            line-height: 1.45;
        }

        .ud-reminder-icon {
            width: 37px;
            height: 37px;
            font-size: 19px;
            margin-bottom: 9px;
        }

        .ud-reminder p {
            font-size: 10px;
            line-height: 1.55;
        }

        .ud-footer {
            font-size: 9px;
            padding: 8px 0 15px;
        }
    }

    /* HP KECIL */

    @media (max-width: 380px) {

        .user-dashboard {
            padding: 0 8px;
        }

        .ud-welcome {
            padding: 15px 12px;
        }

        .ud-welcome h2 {
            font-size: 17px;
        }

        .ud-welcome p {
            font-size: 10px;
        }

        .ud-primary-btn {
            font-size: 9px;
        }

        .ud-menu-card h5 {
            font-size: 12px;
        }

        .ud-menu-card p {
            font-size: 9px;
        }
    }
</style>

<div class="user-dashboard">

    {{-- BANNER SAMBUTAN --}}
    <section class="ud-welcome">

        <div class="ud-welcome-content">

            <span class="ud-eyebrow">
                <i class="bi bi-grid-1x2-fill ud-icon"></i>
                PERSONAL DASHBOARD
            </span>

            <h2>
                Halo, {{ Auth::user()->name }}!
            </h2>

            <p>
                Selamat datang kembali di Timetrix.
                Yuk, tetap disiplin dan jangan lupa mencatat
                kehadiranmu hari ini!
            </p>

            <a href="{{ url('/absensi') }}" class="ud-primary-btn">
                <i class="bi bi-pencil-square ud-icon"></i>
                Isi Absen Sekarang
                <i class="bi bi-arrow-right ud-icon"></i>
            </a>

        </div>

        <i class="bi bi-clipboard2-check ud-hero-icon"></i>

    </section>

    {{-- MENU UTAMA --}}
    <section>

        <h4 class="ud-section-title">Menu Utama</h4>

        <p class="ud-section-subtitle">
            Pilih layanan yang ingin kamu gunakan.
        </p>

        <div class="ud-menu-grid">

            {{-- ABSENSI --}}
            <a href="{{ url('/absensi') }}" class="ud-menu-card">

                <div class="ud-menu-icon ud-blue">
                    <i class="bi bi-calendar2-check"></i>
                </div>

                <h5>Isi Absensi</h5>

                <p>
                    Catat kehadiranmu dan lakukan
                    absensi masuk maupun pulang.
                </p>

                <span class="ud-menu-link">
                    Buka halaman absensi
                    <i class="bi bi-arrow-right"></i>
                </span>

                <i class="bi bi-arrow-up-right ud-menu-arrow"></i>

            </a>

            {{-- RIWAYAT ABSENSI --}}
            <a href="{{ url('/absensi/riwayat') }}" class="ud-menu-card">

                <div class="ud-menu-icon ud-purple">
                    <i class="bi bi-clock-history"></i>
                </div>

                <h5>Riwayat Absensi</h5>

                <p>
                    Periksa catatan tanggal, jam masuk,
                    jam pulang, dan status kehadiranmu.
                </p>

                <span class="ud-menu-link">
                    Lihat riwayat
                    <i class="bi bi-arrow-right"></i>
                </span>

                <i class="bi bi-arrow-up-right ud-menu-arrow"></i>

            </a>

            {{-- JURNAL HARIAN --}}
            <a href="{{ url('/jurnal') }}" class="ud-menu-card">

                <div class="ud-menu-icon" style="background:#e6fcf5;color:#0ca678;">
                    <i class="bi bi-journal-text"></i>
                </div>

                <h5>Jurnal Harian PKL</h5>

                <p>
                    Catat kegiatan dan kendala yang kamu
                    alami selama PKL hari ini.
                </p>

                <span class="ud-menu-link" style="color:#0ca678;">
                    Buka jurnal
                    <i class="bi bi-arrow-right"></i>
                </span>

                <i class="bi bi-arrow-up-right ud-menu-arrow" style="color:#0ca678;"></i>

            </a>

            {{-- PENGAJUAN IZIN --}}
            <a href="{{ url('/izin') }}" class="ud-menu-card">

                <div class="ud-menu-icon" style="background:#fff1f2;color:#e11d48;">
                    <i class="bi bi-envelope-paper"></i>
                </div>

                <h5>Pengajuan Izin</h5>

                <p>
                    Ajukan surat izin jika kamu berhalangan hadir
                    atau sakit.
                </p>

                <span class="ud-menu-link" style="color:#e11d48;">
                    Buka form izin
                    <i class="bi bi-arrow-right"></i>
                </span>

                <i class="bi bi-arrow-up-right ud-menu-arrow" style="color:#e11d48;"></i>

            </a>

        </div>

    </section>

    {{-- INFORMASI TAMBAHAN --}}
    <div class="ud-bottom-grid">

        {{-- PANDUAN ABSENSI --}}
        <section class="ud-panel">

            <h5>
                <i class="bi bi-list-check" style="color:#4965d6"></i>
                Panduan Absensi
            </h5>

            <div class="ud-step">

                <div class="ud-step-number">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>

                <div>
                    <strong>Isi absensi masuk</strong>

                    <small>
                        Buka menu Isi Absensi atau Scan QR untuk mencatat
                        waktu kedatanganmu.
                    </small>
                </div>

            </div>

            <div class="ud-step">

                <div class="ud-step-number">
                    <i class="bi bi-box-arrow-right"></i>
                </div>

                <div>
                    <strong>Isi absensi pulang</strong>

                    <small>
                        Catat waktu pulang setelah aktivitas
                        hari ini selesai.
                    </small>
                </div>

            </div>

            <div class="ud-step">

                <div class="ud-step-number">
                    <i class="bi bi-journal-check"></i>
                </div>

                <div>
                    <strong>Isi jurnal harian</strong>

                    <small>
                        Catat kegiatan dan kendalamu di menu
                        Jurnal Harian PKL.
                    </small>
                </div>

            </div>

        </section>

        {{-- PENGINGAT --}}
        <section class="ud-panel ud-reminder">

            <div class="ud-reminder-icon">
                <i class="bi bi-lightbulb"></i>
            </div>

            <h5>Pengingat Hari Ini</h5>

            <p>
                Disiplin dimulai dari kebiasaan kecil.
                Catat kehadiranmu dengan tertib dan
                jadikan setiap hari kesempatan untuk
                menjadi lebih baik.
            </p>

            <hr style="border-color:#dce4f6;">

            <p>
                <i class="bi bi-calendar3"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </p>

        </section>

    </div>

    {{-- FOOTER --}}
    <div class="ud-footer">

        <i class="bi bi-shield-check"></i>

        © {{ now()->year }} Timetrix
        · Sistem Pencatatan Kehadiran

    </div>

</div>

@endsection
