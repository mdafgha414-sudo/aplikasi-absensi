
@extends('layouts.app')

@section('content')

<style>
    :root {
        --admin-primary: #7da7d9;
        --admin-bg: #f7faff;
        --admin-text: #40516a;
        --admin-border: #e8eef6;
    }

    .setting-container {
        color: var(--admin-text);
        padding: 10px 0 30px;
    }

    .setting-card {
        background: #fff;
        border: 1px solid var(--admin-border);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(82, 125, 180, .035);
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

    .form-label {
        font-weight: 600;
        color: #52627a;
        font-size: .85rem;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #dce9f8;
        padding: 12px 15px;
        font-size: .95rem;
        color: #52627a;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .form-control:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(125, 167, 217, .15);
    }

    .btn-save {
        background: #e8f1fc;
        border: 1px solid #e8f1fc;
        color: #5f8fc9;
        font-weight: 600;
        border-radius: 11px;
        padding: 10px 24px;
        transition: background .2s ease;
    }

    .btn-save:hover {
        background: #dceafb;
        border-color: #dceafb;
        color: #4d7eb9;
    }

    .info-text {
        font-size: .8rem;
        color: #91a0b5;
        margin-top: 5px;
    }

    .day-setting {
        padding: 16px;
        border: 1px solid var(--admin-border);
        border-radius: 12px;
        margin-bottom: 14px;
        background: #fff;
    }

    .day-setting:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 576px) {
        .setting-card-header,
        .setting-card-body {
            padding: 18px;
        }

        .setting-card-title {
            font-size: 1rem;
        }

        .btn-save {
            padding: 10px 14px;
        }
    }
</style>

<div class="setting-container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4"
                     style="border-radius: 12px; font-size: .9rem;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4"
                     style="border-radius: 12px; font-size: .9rem;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="setting-card">
                <div class="setting-card-header">
                    <h4 class="setting-card-title">
                        <i class="bi bi-gear-fill text-primary me-2"></i>
                        Pengaturan Aplikasi
                    </h4>
                </div>

                <div class="setting-card-body">

                    {{-- Form pengaturan jam masuk mingguan --}}
                    <form action="/admin/setting" method="POST">
                        @csrf
                        @method('PUT')

                        <p class="mb-3">
                            Atur batas jam masuk tepat waktu untuk setiap hari.
                        </p>

                        @php
                            $daftarHari = [
                                'senin' => 'Senin',
                                'selasa' => 'Selasa',
                                'rabu' => 'Rabu',
                                'kamis' => 'Kamis',
                                'jumat' => 'Jumat',
                                'sabtu' => 'Sabtu',
                                'minggu' => 'Minggu',
                            ];
                        @endphp

                        @foreach ($daftarHari as $keyHari => $namaHari)
                            <div class="day-setting">
                                <label
                                    for="jam_masuk_{{ $keyHari }}"
                                    class="form-label"
                                >
                                    <i class="bi bi-calendar-day me-1"></i>
                                    Jam Masuk Hari {{ $namaHari }}
                                </label>

                                <input
                                    type="time"
                                    id="jam_masuk_{{ $keyHari }}"
                                    name="jam_masuk_{{ $keyHari }}"
                                    class="form-control"
                                    value="{{ old('jam_masuk_' . $keyHari, $jadwalJam[$keyHari] ?? '08:00') }}"
                                    required
                                >

                                @error('jam_masuk_' . $keyHari)
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @endforeach

                        <div class="info-text mt-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Jika pengguna melakukan absensi masuk setelah batas
                            waktu yang ditetapkan pada hari tersebut, statusnya
                            akan tercatat sebagai <strong>Telat</strong>.
                        </div>

                        {{-- Tombol kembali dan simpan --}}
                        <div class="d-flex flex-wrap justify-content-between
                                    align-items-center gap-2 mt-5 pt-3 border-top">
                            <a href="/admin/dashboard"
                               class="btn btn-light border"
                               style="border-radius: 10px;">
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
