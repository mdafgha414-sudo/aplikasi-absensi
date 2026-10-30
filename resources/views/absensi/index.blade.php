@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f5f6ff;
    }

    .dashboard {
        max-width: 1050px;
        margin: auto;
        padding: 25px 15px;
        color: #292d45;
    }

    .welcome {
        background: #e0f2fe; 
        border: 1px solid #bae6fd;
        color: #0f172a; 
        padding: 32px;
        border-radius: 22px;
        margin-bottom: 28px;
        box-shadow: 0 10px 25px rgba(14, 165, 233, .05);
    }

    .welcome h2 {
        font-weight: 750;
        font-size: 27px;
        color: #0f172a;
    }

    .welcome p {
        color: #334155;
        margin-bottom: 0;
    }

    .welcome .small {
        color: #0284c7;
    }

    .date-box {
        display: inline-block;
        background: #ffffff;
        border: 1px solid #bae6fd;
        color: #0369a1;
        padding: 10px 15px;
        border-radius: 10px;
        margin-top: 18px;
        font-size: 14px;
        font-weight: 600;
    }

    .section-title {
        font-weight: 750;
        font-size: 20px;
    }

    .section-desc {
        color: #85899e;
        font-size: 14px;
    }

    .attendance-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 20px;
        padding: 25px;
        height: 100%;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .04);
    }

    .icon-box {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 18px;
    }

    .green-icon {
        background: #e4f8ed;
        color: #15945b;
    }

    .orange-icon {
        background: #fff0dc;
        color: #e99421;
    }

    .card-label {
        color: #85899e;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .time {
        font-size: 30px;
        font-weight: 750;
        margin-bottom: 12px;
    }

    .status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 650;
    }

    .status-green {
        background: #e4f8ed;
        color: #16834f;
    }

    .status-red {
        background: #ffe7e7;
        color: #cf3333;
    }

    .status-orange {
        background: #fff0dc;
        color: #a86a10;
    }

    .action-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 20px;
        padding: 25px;
        margin-top: 22px;
        box-shadow: 0 5px 18px rgba(30, 35, 80, .04);
    }

    .btn-absen {
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 650;
        width: 100%;
        transition: .2s;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .btn-masuk {
        background: #0284c7; 
        color: white;
        margin-bottom: 10px;
    }

    .btn-masuk:hover {
        background: #0369a1;
        color: white;
    }

    .btn-scan {
        background: #0ea5e9; /* Warna biru cerah untuk Scan */
        color: white;
        margin-bottom: 15px;
        border: 2px dashed #bae6fd;
    }

    .btn-scan:hover {
        background: #0284c7;
        color: white;
    }

    .btn-pulang {
        background: #ffbd45;
        color: #302500;
    }

    .btn-pulang:hover {
        background: #f5aa22;
        color: #302500;
    }

    .info-box {
        background: #f0f9ff;
        border: 1px solid #e0f2fe;
        color: #0369a1;
        padding: 17px;
        border-radius: 13px;
        font-size: 14px;
    }

    .history-card {
        background: white;
        border: 1px solid #eceefa;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
    }

    .history-link {
        color: #0284c7;
        font-size: 28px;
        text-decoration: none;
    }

    @media (max-width: 576px) {
        .dashboard { padding: 15px 10px; }
        .welcome { padding: 24px 20px; }
        .welcome h2 { font-size: 23px; }
        .attendance-card { padding: 18px; }
        .time { font-size: 25px; }
        .action-card { padding: 20px; }
    }
</style>

<div class="dashboard">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger rounded-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Sambutan --}}
    <div class="welcome">
        <span class="small fw-semibold">
            <i class="bi bi-stars me-2"></i>
            DASHBOARD ABSENSI
        </span>

        <h2 class="mt-3">
            Halo, {{ Auth::user()->name }}! 
        </h2>

        <p>Selamat datang! Jangan lupa catat kehadiranmu hari ini.</p>

        <div class="date-box">
            <i class="bi bi-calendar3 me-2"></i>
            {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- Jam Realtime --}}
    <style>
        .realtime-clock-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 22px;
            margin-bottom: 22px;
            background: #ffffff;
            border: 1px solid #e8eaff;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(61, 69, 150, 0.06);
        }
        .realtime-clock-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            flex-shrink: 0;
            color: #0284c7; 
            background: #f0f9ff; 
            border-radius: 14px;
            font-size: 27px;
        }
        .realtime-clock-label {
            color: #7b8197;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .realtime-clock-time {
            color: #20284b;
            font-size: clamp(25px, 3vw, 32px);
            font-weight: 800;
            line-height: 1.2;
            font-variant-numeric: tabular-nums;
        }
        .realtime-clock-date {
            margin-top: 6px;
            color: #777f98;
            font-size: 12px;
        }
        @media (max-width: 576px) {
            .realtime-clock-card { padding: 15px; gap: 12px; }
            .realtime-clock-icon { width: 46px; height: 46px; font-size: 23px; }
        }
    </style>

    <div class="realtime-clock-card">
        <div class="realtime-clock-icon">🕒</div>
        <div>
            <div class="realtime-clock-label">WAKTU SEKARANG</div>
            <div id="realtimeClockTime" class="realtime-clock-time">--:--:--</div>
            <div id="realtimeClockDate" class="realtime-clock-date">Memuat tanggal...</div>
        </div>
    </div>

    <script>
        (() => {
            function updateRealtimeClock() {
                const now = new Date();
                const timeElement = document.getElementById('realtimeClockTime');
                const dateElement = document.getElementById('realtimeClockDate');
                if (!timeElement || !dateElement) return;

                timeElement.textContent = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).format(now);

                dateElement.textContent = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }).format(now);
            }
            updateRealtimeClock();
            setInterval(updateRealtimeClock, 1000);
        })();
    </script>

    {{-- Judul Ringkasan --}}
    <h5 class="section-title mb-1">Ringkasan Kehadiran</h5>
    <p class="section-desc">Berikut informasi absensi kamu hari ini.</p>

    {{-- Info Batas Jam (Dibersihkan dari tag aneh) --}}
    <div class="info-box mb-4">
        <i class="bi bi-clock me-2"></i>
        Batas jam masuk hari ini: <strong>{{ $jamMasukHariIni }}</strong>. Mengikuti jadwal yang disimpan admin.
    </div>

    {{-- Kartu absensi --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="attendance-card">
                <div class="icon-box green-icon">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <p class="card-label">Waktu Kehadiran</p>
                <h6 class="fw-bold">Absen Masuk</h6>
                <div class="time">
                    {{ $absenHariIni ? $absenHariIni->jam_masuk : '--:--' }}
                </div>

                @if ($absenHariIni)
                    @if ($absenHariIni->status == 'Telat')
                        <span class="status status-red">
                            <i class="bi bi-clock-history me-1"></i> Terlambat
                        </span>
                    @else
                        <span class="status status-green">
                            <i class="bi bi-check-circle me-1"></i> Tepat Waktu
                        </span>
                    @endif
                @else
                    <span class="status status-orange">
                        <i class="bi bi-hourglass-split me-1"></i> Belum Absen
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="attendance-card">
                <div class="icon-box orange-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <p class="card-label">Waktu Kepulangan</p>
                <h6 class="fw-bold">Absen Pulang</h6>
                <div class="time">
                    {{ $absenHariIni && $absenHariIni->jam_pulang ? $absenHariIni->jam_pulang : '--:--' }}
                </div>

                @if ($absenHariIni && $absenHariIni->jam_pulang)
                    <span class="status status-green">
                        <i class="bi bi-check-circle me-1"></i> Selesai
                    </span>
                @else
                    <span class="status status-orange">
                        <i class="bi bi-hourglass-split me-1"></i> Belum Absen Pulang
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Tombol aksi --}}
    <div class="action-card">
        <h5 class="section-title mb-2">Aksi Absensi</h5>

        {{-- Alasan Keterlambatan --}}
        <div class="late-reason-card mb-4">
            <h3>📝 Alasan Keterlambatan</h3>
            <p>Jelaskan alasan kamu terlambat. Kamu bisa mengubahnya kapan saja.</p>

            @if (session('success'))
                <p class="reason-success">{{ session('success') }}</p>
            @endif
            @if ($errors->has('alasan'))
                <p class="reason-error">{{ $errors->first('alasan') }}</p>
            @endif

            <form action="{{ route('absensi.alasan.simpan') }}" method="POST">
                @csrf
                <label for="alasan">Pilih alasan atau tulis sendiri</label>
                <select id="pilihanAlasan" class="reason-input" onchange="pilihAlasanIni(this)">
                    <option value="">-- Pilih alasan --</option>
                    <option value="Terjebak kemacetan">Terjebak kemacetan</option>
                    <option value="Kendala kendaraan">Kendala kendaraan</option>
                    <option value="Kendala transportasi umum">Kendala transportasi umum</option>
                    <option value="Cuaca buruk">Cuaca buruk</option>
                    <option value="Urusan keluarga">Urusan keluarga</option>
                    <option value="Alasan lainnya">Alasan lainnya</option>
                </select>

                <textarea id="alasan" name="alasan" class="reason-input" rows="3" maxlength="1000" required placeholder="Tulis alasan keterlambatan kamu...">{{ old('alasan', $alasanTerlambatHariIni ?? '') }}</textarea>

                <button type="submit" class="reason-save-btn">Simpan / Perbarui Alasan</button>
            </form>
        </div>

        <style>
            .late-reason-card {
                padding: 22px;
                background: #fff;
                border: 1px solid #e8eaff;
                border-radius: 16px;
                box-shadow: 0 5px 18px rgba(61,69,150,.06);
            }
            .late-reason-card h3 { color: #252b50; font-size: 17px; margin-bottom: 8px; }
            .late-reason-card p { color: #7b8197; font-size: 13px; margin-bottom: 14px; }
            .reason-input {
                display: block; width: 100%; margin: 8px 0 14px; padding: 12px 14px;
                color: #252b50; background: #fafbff; border: 1px solid #dfe3f3;
                border-radius: 10px; font: inherit;
            }
            .reason-input:focus { outline: 2px solid #bae6fd; border-color: #0284c7; }
            .reason-save-btn {
                width: 100%; padding: 12px 16px; color: #fff; background: #0284c7;
                border: 0; border-radius: 10px; font-weight: 600; cursor: pointer;
            }
            .reason-save-btn:hover { background: #0369a1; }
            .reason-success { padding: 10px; color: #16764b !important; background: #e8f8ef; border-radius: 8px; }
            .reason-error { color: #c62828 !important; }
        </style>

        <script>
            function pilihAlasanIni(select) {
                const textarea = document.getElementById('alasan');
                if (select.value && select.value !== 'Alasan lainnya') {
                    textarea.value = select.value;
                } else if (select.value === 'Alasan lainnya') {
                    textarea.value = '';
                    textarea.focus();
                }
            }
        </script>

        <p class="section-desc mb-4">
            @if (!$absenHariIni)
                Kamu belum absen masuk hari ini. Silakan pilih metode absensi di bawah.
            @elseif (!$absenHariIni->jam_pulang)
                Absen masuk sudah tercatat. Jangan lupa absen pulang.
            @else
                Absensi hari ini sudah selesai. Terima kasih!
            @endif
        </p>

        @if (!$absenHariIni)
            {{-- Tombol Scan QR (BARU) --}}
            <a href="{{ route('absensi.scan') }}" class="btn-absen btn-scan">
                <i class="bi bi-qr-code-scan me-2"></i>
                Scan QR Code (Validasi Lokasi)
                <i class="bi bi-arrow-right ms-2"></i>
            </a>

            <div class="text-center text-muted small mb-3">— ATAU —</div>

            <form action="/absensi/masuk" method="POST">
                @csrf
                <button type="submit" class="btn-absen btn-masuk">
                    <i class="bi bi-fingerprint me-2"></i>
                    Absen Masuk Manual
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

        @elseif (!$absenHariIni->jam_pulang)
            <form action="/absensi/pulang" method="POST">
                @csrf
                <button type="submit" class="btn-absen btn-pulang">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Absen Pulang Sekarang
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

        @else
            <div class="info-box">
                <i class="bi bi-check-circle-fill me-2"></i>
                Kamu sudah menyelesaikan absensi hari ini.
            </div>
        @endif
    </div>

    {{-- Informasi dan riwayat --}}
    <div class="row g-3 mt-1">
        <div class="col-md-7">
            <div class="info-box h-100">
                <h6 class="fw-bold">
                    <i class="bi bi-lightbulb-fill me-2"></i>
                    Informasi Absensi
                </h6>
                <p class="mb-0">
                    Pastikan kamu melakukan absensi masuk dan pulang
                    sesuai ketentuan yang berlaku.
                </p>
            </div>
        </div>

        <div class="col-md-5">
            <div class="history-card d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold mb-1">Riwayat Absensi</h6>
                    <p class="section-desc mb-0">Lihat catatan kehadiranmu.</p>
                </div>
                <a href="/absensi/riwayat" class="history-link" aria-label="Lihat riwayat absensi">
                    <i class="bi bi-arrow-up-right-circle"></i>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection