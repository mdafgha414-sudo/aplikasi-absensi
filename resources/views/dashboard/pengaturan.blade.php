
@extends('layouts.app')

@section('content')

{{-- ============================================
     STYLE PENGATURAN JADWAL MINGGUAN
============================================ --}}
<style>
    .setting-container {
        color: #40516a;
        padding: 10px 0 30px;
    }

    .setting-card {
        background: #fff;
        border: 1px solid #e8eef6;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(82, 125, 180, .05);
        overflow: hidden;
    }

    .setting-card-header {
        padding: 24px 26px;
        border-bottom: 1px solid #eff3f9;
        background: #f8faff;
    }

    .setting-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #50617a;
        margin: 0;
    }

    .setting-card-body {
        padding: 26px;
    }

    .day-setting {
        padding: 20px;
        border: 1px solid #e8eef6;
        border-radius: 14px;
        margin-bottom: 18px;
        background: #fff;
    }

    .day-title {
        font-weight: 700;
        color: #50617a;
        margin-bottom: 18px;
        font-size: 1rem;
    }

    .form-label {
        font-weight: 600;
        color: #52627a;
        font-size: .85rem;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #dce9f8;
        padding: 11px 12px;
        color: #40516a;
    }

    .form-control:focus {
        border-color: #7da7d9;
        box-shadow: 0 0 0 3px rgba(125, 167, 217, .15);
    }

    .btn-save {
        background: #e8f1fc;
        border: 1px solid #e8f1fc;
        color: #477ebd;
        font-weight: 600;
        border-radius: 11px;
        padding: 11px 22px;
    }

    .btn-save:hover {
        background: #dceafb;
        color: #3569a7;
    }

    .info-text {
        font-size: .82rem;
        color: #8493a8;
        line-height: 1.6;
    }

    @media (max-width: 576px) {
        .setting-card-header,
        .setting-card-body {
            padding: 17px;
        }

        .day-setting {
            padding: 15px;
        }

        .btn-save {
            width: 100%;
        }
    }
</style>

{{-- ============================================
     HALAMAN PENGATURAN
============================================ --}}
<div class="setting-container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4"
                     style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4"
                     style="border-radius: 12px;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="setting-card">

                {{-- Judul halaman --}}
                <div class="setting-card-header">
                    <h4 class="setting-card-title">
                        <i class="bi bi-gear-fill text-primary me-2"></i>
                        Pengaturan Jadwal Absensi
                    </h4>

                    <p class="text-muted mb-0 mt-2">
                        Atur waktu masuk, batas keterlambatan,
                        dan jam pulang untuk setiap hari.
                    </p>
                </div>

                <div class="setting-card-body">

                    <form action="/admin/setting" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Tampilkan 7 hari --}}
                        @foreach ($daftarHari as $hari => $namaHari)

                            <div class="day-setting">

                                <h5 class="day-title">
                                    <i class="bi bi-calendar-week text-primary me-2"></i>
                                    Jadwal Hari {{ $namaHari }}
                                </h5>

                                <div class="row g-3">

                                    {{-- 1. WAKTU MASUK --}}
                                    <div class="col-12 col-md-4">
                                        <label
                                            for="waktu_masuk_{{ $hari }}"
                                            class="form-label"
                                        >
                                            Waktu Masuk
                                        </label>

                                        <input
                                            type="time"
                                            id="waktu_masuk_{{ $hari }}"
                                            name="waktu_masuk_{{ $hari }}"
                                            class="form-control"
                                            value="{{ old('waktu_masuk_' . $hari, $jadwalMingguan[$hari]['waktu_masuk']) }}"
                                            required
                                        >
                                    </div>

                                    {{-- 2. BATAS JAM TELAT --}}
                                    <div class="col-12 col-md-4">
                                        <label
                                            for="batas_jam_telat_{{ $hari }}"
                                            class="form-label"
                                        >
                                            Batas Jam Telat
                                        </label>

                                        <input
                                            type="time"
                                            id="batas_jam_telat_{{ $hari }}"
                                            name="batas_jam_telat_{{ $hari }}"
                                            class="form-control"
                                            value="{{ old('batas_jam_telat_' . $hari, $jadwalMingguan[$hari]['batas_jam_telat']) }}"
                                            required
                                        >
                                    </div>

                                    {{-- 3. JAM PULANG --}}
                                    <div class="col-12 col-md-4">
                                        <label
                                            for="jam_pulang_{{ $hari }}"
                                            class="form-label"
                                        >
                                            Jam Pulang
                                        </label>

                                        <input
                                            type="time"
                                            id="jam_pulang_{{ $hari }}"
                                            name="jam_pulang_{{ $hari }}"
                                            class="form-control"
                                            value="{{ old('jam_pulang_' . $hari, $jadwalMingguan[$hari]['jam_pulang']) }}"
                                            required
                                        >
                                    </div>

                                </div>
                            </div>

                        @endforeach

                        {{-- Keterangan --}}
                        <p class="info-text mt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Setiap hari memiliki pengaturan sendiri.
                            Perubahan akan disimpan ke database setelah
                            tombol Simpan Pengaturan ditekan.
                        </p>

                        {{-- Tombol navigasi --}}
                        <div class="d-flex flex-wrap justify-content-between
                                    align-items-center gap-2 mt-4 pt-3 border-top">

                            <a href="/admin/dashboard"
                               class="btn btn-light border"
                               style="border-radius: 10px;">
                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-save me-2"></i>
                                Simpan Pengaturan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
