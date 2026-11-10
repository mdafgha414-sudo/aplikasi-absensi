@extends('layouts.app')

@section('content')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --primary: #2878f0; --border: #e2ebf8; --background: #f3f7fd; --text: #243b60; }
    
    .content-wrapper {
        font-family: 'Inter', sans-serif; background: var(--background); color: var(--text);
        min-height: 100vh; padding: 30px 32px 45px; max-width: 1450px; margin: auto;
    }

    /* HEADER */
    .breadcrumb { display: flex; gap: 11px; align-items: center; font-size: 11px; color: #8396b4; margin-bottom: 27px; }
    .page-heading { display: flex; align-items: center; gap: 16px; margin-bottom: 27px; flex-wrap: wrap; }
    .heading-icon { width: 54px; height: 54px; border-radius: 17px; background: #e0edff; color: var(--primary); display: grid; place-items: center; font-size: 23px; flex-shrink: 0; }
    .page-heading h1 { font-size: clamp(20px, 2vw, 27px); font-weight: 800; color: #1b3153; letter-spacing: -.7px; }
    .page-heading p { font-size: 12px; color: #7185a4; margin-top: 8px; }
    .active-badge { margin-left: auto; padding: 11px 15px; border-radius: 12px; background: #dcf9ee; color: #11966d; font-size: 11px; font-weight: 700; }

    /* PANEL */
    .schedule-panel { background: white; border: 1px solid #e4edfa; border-radius: 20px; padding: 18px; box-shadow: 0 12px 40px rgba(41,77,125,.045); }
    .panel-heading { display: flex; align-items: center; gap: 15px; background: #f7faff; border-radius: 14px; padding: 19px; margin-bottom: 17px; flex-wrap: wrap; }
    .panel-icon { width: 48px; height: 48px; flex-shrink: 0; display: grid; place-items: center; border-radius: 50%; background: #d8e9ff; color: #2878f0; font-size: 21px; }

    /* KARTU JADWAL */
    .day-card { display: grid; grid-template-columns: 95px repeat(3, minmax(0, 1fr)); align-items: center; gap: 15px; border: 1px solid var(--border); border-radius: 11px; padding: 15px; margin-bottom: 15px; transition: border-color .2s; }
    .day-card:hover { border-color: #bdd7ff; }
    .day-info { background: #e8f1ff; border-radius: 9px; text-align: center; padding: 12px 4px; color: #2878f0; }
    .day-info h3 { font-size: 14px; font-weight: 800; }
    .field label { display: block; font-size: 11px; font-weight: 600; color: #687e9f; margin-bottom: 5px; }
    .time-input { display: flex; align-items: center; gap: 5px; border: 1px solid #dfe9f8; border-radius: 7px; padding: 0 10px; height: 40px; background: white; }
    .time-input input { width: 100%; border: none; outline: none; color: #294567; font-size: 13px; }

    /* FOOTER & MESSAGES */
    .panel-footer { display: flex; justify-content: space-between; align-items: center; gap: 12px; border-top: 1px solid #e9eff8; padding-top: 18px; margin-top: 18px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 9px; border-radius: 10px; padding: 12px 17px; font-size: 13px; font-weight: 700; text-decoration: none; cursor: pointer; border: none; }
    .btn-back { border: 1px solid #dce6f4; background: white; color: #526c8f; }
    .btn-save { background: #2878f0; color: white; box-shadow: 0 5px 13px rgba(40,120,240,.18); }
    .success-message { background: #e2f8ec; border: 1px solid #c3efd6; color: #168553; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 13px; }
    .error-message { background: #fff0f0; color: #c73939; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 13px; }

    @media (max-width: 760px) {
        .day-card { grid-template-columns: 1fr; gap: 13px; padding: 14px; }
    }
</style>

<div class="content-wrapper">
    <div class="breadcrumb">
        <i class="fa-solid fa-house"></i> <span>Dashboard</span> <i class="fa-solid fa-chevron-right"></i> <span>Pengaturan</span>
    </div>

    <div class="page-heading">
        <div class="heading-icon"><i class="fa-solid fa-clock"></i></div>
        <div>
            <h1>Pengaturan Jadwal Absensi</h1>
            <p>Atur waktu masuk, batas keterlambatan, dan jam pulang untuk setiap hari.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="success-message"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="error-message">
            <strong>Pengaturan belum berhasil disimpan.</strong>
            <ul style="margin:8px 0 0 20px;">@foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ url('/admin/setting') }}" method="POST">
        @csrf

        <div class="schedule-panel">
            <div class="panel-heading">
                <div class="panel-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div>
                    <h2>Jadwal Kehadiran Mingguan</h2>
                    <p>Ubah jam langsung di kolom yang tersedia, lalu klik Simpan.</p>
                </div>
            </div>

            @php
                $days = [
                    'senin' => 'Senin', 'selasa' => 'Selasa', 'rabu' => 'Rabu',
                    'kamis' => 'Kamis', 'jumat' => 'Jumat', 'sabtu' => 'Sabtu', 'minggu' => 'Minggu'
                ];
            @endphp

            @foreach($days as $key => $dayName)
                @php
                    $jamMasuk = $jadwal[$key]['masuk'] ?? '07:00';
                    $jamTelat = $jadwal[$key]['telat'] ?? '07:15';
                    $jamPulang = $jadwal[$key]['pulang'] ?? '15:00';
                @endphp

                <div class="day-card">
                    <div class="day-info">
                        <h3>{{ $dayName }}</h3>
                    </div>

                    <div class="field">
                        <label>Waktu Masuk</label>
                        <div class="time-input">
                            <input type="time" name="jam_masuk_{{ $key }}" value="{{ $jamMasuk }}">
                        </div>
                    </div>

                    <div class="field">
                        <label>Batas Jam Telat</label>
                        <div class="time-input">
                            <input type="time" name="jam_telat_{{ $key }}" value="{{ $jamTelat }}">
                        </div>
                    </div>

                    <div class="field">
                        <label>Jam Pulang</label>
                        <div class="time-input">
                            <input type="time" name="jam_pulang_{{ $key }}" value="{{ $jamPulang }}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="panel-footer">
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-save"><i class="fa-regular fa-floppy-disk"></i> Simpan Pengaturan</button>
            </div>
        </div>
    </form>
</div>
@endsection