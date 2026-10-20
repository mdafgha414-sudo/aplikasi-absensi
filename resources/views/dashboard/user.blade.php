
@extends('layouts.app')

@section('content')

<style>
    .user-dashboard {
        max-width: 1150px;
        margin: 15px auto;
        color: #243454;
        font-family: Arial, sans-serif;
    }

    .ud-welcome {
        position: relative;
        overflow: hidden;
        padding: 35px;
        border-radius: 22px;
        color: white;
        background: linear-gradient(120deg, #3658d4, #7547d8);
        box-shadow: 0 12px 28px rgba(69, 79, 190, .20);
        margin-bottom: 25px;
    }

    .ud-welcome::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.09);
        right: -45px;
        top: -95px;
    }

    .ud-welcome::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        right: 100px;
        bottom: -100px;
    }

    .ud-welcome-content {
        position: relative;
        z-index: 1;
    }

    .ud-eyebrow {
        display: inline-block;
        padding: 7px 13px;
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 30px;
        font-size: 12px;
        margin-bottom: 17px;
    }

    .ud-welcome h2 {
        font-size: clamp(25px, 4vw, 36px);
        font-weight: 800;
        margin-bottom: 12px;
    }

    .ud-welcome p {
        max-width: 520px;
        color: #edf0ff;
        line-height: 1.8;
        margin-bottom: 22px;
    }

    .ud-primary-btn {
        display: inline-block;
        padding: 12px 20px;
        background: white;
        color: #4058cb;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        transition: .2s;
    }

    .ud-primary-btn:hover {
        background: #edf1ff;
        color: #293da5;
        transform: translateY(-2px);
    }

    .ud-hero-icon {
        position: absolute;
        right: 55px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 105px;
        opacity: .9;
        z-index: 1;
    }

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
    }

    .ud-purple {
        background: #f0e9ff;
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

    .ud-bottom-grid {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .ud-panel {
        background: white;
        border: 1px solid #e8ecf5;
        border-radius: 18px;
        padding: 23px;
        box-shadow: 0 5px 18px rgba(34, 53, 92, .04);
    }

    .ud-panel h5 {
        font-weight: 800;
        margin-bottom: 17px;
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
        width: 34px;
        height: 34px;
        border-radius: 11px;
        background: #edf1ff;
        color: #4965d6;
        font-weight: bold;
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
        font-size: 32px;
        margin-bottom: 12px;
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

    @media (max-width: 700px) {
        .user-dashboard {
            margin: 8px auto;
        }

        .ud-welcome {
            padding: 25px 21px;
        }

        .ud-hero-icon {
            right: 15px;
            font-size: 65px;
            opacity: .25;
        }

        .ud-menu-grid,
        .ud-bottom-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .ud-menu-card {
            padding: 20px;
        }

        .ud-panel {
            padding: 19px;
        }
    }
</style>

<div class="user-dashboard">

    {{-- BANNER SAMBUTAN --}}
    <section class="ud-welcome">
        <div class="ud-welcome-content">
            <span class="ud-eyebrow">
                ✨ PERSONAL DASHBOARD
            </span>

            <h2>
                Halo, {{ Auth::user()->name }}! 👋
            </h2>

            <p>
                Selamat datang kembali di Absensi App.
                Yuk, tetap disiplin dan jangan lupa mencatat
                kehadiranmu hari ini!
            </p>

            <a href="{{ url('/absensi') }}"
               class="ud-primary-btn">
                📝 &nbsp; Isi Absen Sekarang &nbsp; →
            </a>
        </div>

        <div class="ud-hero-icon">📋</div>
    </section>

    {{-- MENU UTAMA --}}
    <section>
        <h4 class="ud-section-title">Menu Utama</h4>

        <p class="ud-section-subtitle">
            Pilih layanan yang ingin kamu gunakan.
        </p>

        <div class="ud-menu-grid">

            <a href="{{ url('/absensi') }}"
               class="ud-menu-card">
                <div class="ud-menu-icon ud-blue">
                    📝
                </div>

                <h5>Isi Absensi</h5>

                <p>
                    Catat kehadiranmu dan lakukan
                    absensi masuk maupun pulang.
                </p>

                <span class="ud-menu-link">
                    Buka halaman absensi →
                </span>

                <span class="ud-menu-arrow">↗</span>
            </a>

            <a href="{{ url('/absensi/riwayat') }}"
               class="ud-menu-card">
                <div class="ud-menu-icon ud-purple">
                    📊
                </div>

                <h5>Riwayat Absensi</h5>

                <p>
                    Periksa catatan tanggal, jam masuk,
                    jam pulang, dan status kehadiranmu.
                </p>

                <span class="ud-menu-link">
                    Lihat riwayat →
                </span>

                <span class="ud-menu-arrow">↗</span>
            </a>

        </div>
    </section>

    {{-- INFORMASI TAMBAHAN --}}
    <div class="ud-bottom-grid">

        <section class="ud-panel">
            <h5>💡 Panduan Absensi</h5>

            <div class="ud-step">
                <div class="ud-step-number">1</div>
                <div>
                    <strong>Isi absensi masuk</strong>
                    <small>
                        Buka menu Isi Absensi untuk mencatat
                        waktu kedatanganmu.
                    </small>
                </div>
            </div>

            <div class="ud-step">
                <div class="ud-step-number">2</div>
                <div>
                    <strong>Isi absensi pulang</strong>
                    <small>
                        Catat waktu pulang setelah aktivitas
                        hari ini selesai.
                    </small>
                </div>
            </div>

            <div class="ud-step">
                <div class="ud-step-number">3</div>
                <div>
                    <strong>Periksa riwayatmu</strong>
                    <small>
                        Pastikan catatan absensi sudah
                        tersimpan dengan benar.
                    </small>
                </div>
            </div>
        </section>

        <section class="ud-panel ud-reminder">
            <div class="ud-reminder-icon">🌟</div>

            <h5>Semangat Hari Ini!</h5>

            <p>
                Disiplin dimulai dari kebiasaan kecil.
                Catat kehadiranmu dengan tertib dan
                jadikan setiap hari kesempatan untuk
                menjadi lebih baik.
            </p>

            <hr style="border-color:#dce4f6;">

            <p>
                📅 {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </section>

    </div>

    <div class="ud-footer">
        © {{ now()->year }} Absensi App · Sistem Pencatatan Kehadiran
    </div>

</div>

@endsection
