
@extends('layouts.app')

@section('content')

<style>
    .guru-dashboard {
        padding: 28px;
        background: #f5f8fc;
        min-height: 100vh;
    }

    /* Banner Selamat Datang */
    .welcome-banner {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #e0f2fe, #bae6fd);
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 42px 46px;
        margin-bottom: 26px;
    }

    .welcome-banner::before {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        right: -50px;
        top: -100px;
        border-radius: 50%;
        background: rgba(255,255,255,.28);
    }

    .welcome-banner h2 {
        font-size: 30px;
        font-weight: 800;
        color: #14233d;
        margin-bottom: 10px;
    }

    .welcome-banner p {
        color: #53677f;
        font-size: 15px;
        max-width: 700px;
        margin: 0;
    }

    .welcome-label {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 30px;
        background: white;
        color: #0875df;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .welcome-icon {
        width: 78px;
        height: 78px;
        background: rgba(255,255,255,.85);
        color: #0784cf;
        border-radius: 22px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 36px;
        box-shadow: 0 5px 18px rgba(0,0,0,.05);
        position: relative;
        z-index: 1;
    }

    /* Judul Navigasi */
    .navigation-heading {
        margin: 32px 0 18px;
    }

    .navigation-heading h4 {
        font-weight: 800;
        color: #192b45;
        font-size: 21px;
        margin-bottom: 5px;
    }

    .navigation-heading p {
        color: #78889d;
        font-size: 14px;
        margin: 0;
    }

    /* Kartu Navigasi */
    .navigation-card {
        display: flex;
        flex-direction: column;
        position: relative;
        background: #fff;
        border: 1px solid #e7edf5;
        border-radius: 18px;
        padding: 24px;
        min-height: 235px;
        height: 100%;
        text-decoration: none !important;
        transition: all .25s ease;
        box-shadow: 0 3px 9px rgba(30,50,80,.04);
    }

    .navigation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(30,50,80,.10);
        border-color: #cbdcf3;
    }

    .navigation-icon {
        width: 52px;
        height: 52px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        margin-bottom: 22px;
    }

    .icon-jurnal {
        background: #ede9fe;
        color: #5744e8;
    }

    .icon-absensi {
        background: #ccfbf1;
        color: #0d9488;
    }

    .icon-keterlambatan {
        background: #ffedd5;
        color: #ea850c;
    }

    .navigation-arrow {
        position: absolute;
        top: 28px;
        right: 25px;
        width: 37px;
        height: 37px;
        border-radius: 50%;
        background: #f5f7fa;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all .2s ease;
    }

    .navigation-card:hover .navigation-arrow {
        background: #eaf2ff;
        color: #1769e8;
        transform: translateX(3px);
    }

    .navigation-card h5 {
        font-size: 19px;
        font-weight: 800;
        color: #17263d;
        margin-bottom: 9px;
    }

    .navigation-card p {
        font-size: 14px;
        line-height: 1.7;
        color: #78879a;
        margin-bottom: 20px;
    }

    .navigation-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f0f2f6;
        padding-top: 14px;
        margin-top: auto;
        font-size: 13px;
        font-weight: 700;
    }

    .link-jurnal {
        color: #5744e8;
    }

    .link-absensi {
        color: #0d9488;
    }

    .link-keterlambatan {
        color: #ea850c;
    }

    /* Kartu ketiga */
    .card-keterlambatan {
        min-height: 190px;
    }

    @media(max-width: 768px) {
        .guru-dashboard {
            padding: 15px;
        }

        .welcome-banner {
            padding: 28px 23px;
        }

        .welcome-banner h2 {
            font-size: 23px;
        }

        .welcome-icon {
            display: none;
        }

        .navigation-heading h4 {
            font-size: 19px;
        }

        .navigation-card {
            min-height: 215px;
        }
    }
</style>

<div class="guru-dashboard">

    {{-- BANNER SELAMAT DATANG --}}
    <div class="welcome-banner d-flex justify-content-between align-items-center">

        <div style="position: relative; z-index: 1;">

            <span class="welcome-label">
                <i class="bi bi-circle-fill me-1" style="font-size: 9px;"></i>
                Teacher Workspace
            </span>

            <h2>Selamat Datang, guru</h2>

            <p>
                Kelola jurnal harian, pantau kehadiran, dan periksa
                alasan keterlambatan siswa PKL Anda dalam satu tempat.
            </p>

        </div>

        <div class="welcome-icon">
            <i class="bi bi-clipboard-check"></i>
        </div>

    </div>


    {{-- JUDUL NAVIGASI --}}
    <div class="navigation-heading">
        <h4>Menu Utama Navigasi</h4>
        <p>
            Pilih salah satu tindakan di bawah untuk mulai mengelola
            siswa bimbingan PKL Anda.
        </p>
    </div>


    {{-- BARIS PERTAMA: JURNAL DAN ABSENSI --}}
    <div class="row g-4">

        {{-- KARTU JURNAL --}}
        <div class="col-lg-4 col-md-6">

            <a href="{{ url('/guru/jurnal') }}"
               class="navigation-card">

                <div class="navigation-icon icon-jurnal">
                    <i class="bi bi-journal-check"></i>
                </div>

                <div class="navigation-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>

                <h5>Lihat Jurnal Siswa</h5>

                <p>
                    Periksa catatan aktivitas harian siswa PKL,
                    berikan ulasan, dan input nilai secara langsung.
                </p>

                <div class="navigation-link link-jurnal">
                    <span>Buka Menu Jurnal</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

            </a>

        </div>


        {{-- KARTU ABSENSI --}}
        <div class="col-lg-4 col-md-6">

            <a href="{{ url('/guru/laporan-absensi-izin') }}"
               class="navigation-card">

                <div class="navigation-icon icon-absensi">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <div class="navigation-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>

                <h5>Laporan Absensi</h5>

                <p>
                    Pantau rekapitulasi kehadiran harian,
                    ketidakhadiran, dan status akumulasi siswa.
                </p>

                <div class="navigation-link link-absensi">
                    <span>Cek Rekap Absensi</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

            </a>

        </div>


        {{-- KARTU ALASAN KETERLAMBATAN --}}
        <div class="col-lg-4 col-md-6">

            <a href="{{ url('/guru/alasan-keterlambatan') }}"
               class="navigation-card card-keterlambatan">

                <div class="navigation-icon icon-keterlambatan">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div class="navigation-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>

                <h5>Alasan Keterlambatan</h5>

                <p>
                    Lihat dan periksa alasan keterlambatan siswa PKL,
                    serta pantau catatan keterlambatan setiap siswa.
                </p>

                <div class="navigation-link link-keterlambatan">
                    <span>Lihat Alasan Keterlambatan</span>
                    <i class="bi bi-chevron-right"></i>
                </div>

            </a>

        </div>

    </div>

</div>

@endsection
