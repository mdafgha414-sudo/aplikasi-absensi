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
    .total-days { margin-left: auto; border: 1px solid #d4e5ff; border-radius: 11px; padding: 11px 14px; display: flex; align-items: center; gap: 12px; color: #2878f0; flex-shrink: 0; }
    .panel-side { width: 170px; flex-shrink: 0; display: flex; flex-direction: column; gap: 10px; align-self: stretch; }
    .panel-side .total-days { width: 100%; margin: 0; }
    .panel-side-tools { width: 100%; padding: 10px; border: 1px solid #d4e5ff; border-radius: 11px; background: #fff; }
    .panel-side-tools h2 { font-size: 11px; color: #233d63; margin-bottom: 8px; }
    .pilih-semua-hari { display: inline-flex; align-items: center; gap: 8px; margin: 10px 0; color: #1e40af; font-size: 13px; font-weight: 600; cursor: pointer; }

    /* PENGATURAN MASSAL */
    .pengaturan-massal { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin: 16px 0; width: 100%; }
    .pengaturan-massal-item { padding: 14px; border: 1px solid #dbeafe; border-radius: 10px; background: #f8fbff; }
    .pengaturan-massal-item label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: #334155; }
    .pengaturan-massal-item input { width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #dbe3ef; border-radius: 8px; background: white; }
    .pengaturan-massal-item button { width: 100%; margin-top: 10px; padding: 10px 6px; border: none; border-radius: 8px; background: #2878f0; color: white; font-weight: 600; cursor: pointer; }

    /* KARTU JADWAL */
    .day-card { display: grid; grid-template-columns: 40px 95px repeat(3, minmax(0, 1fr)) 65px; align-items: center; gap: 8px; border: 1px solid var(--border); border-radius: 11px; padding: 8px; margin-bottom: 8px; transition: border-color .2s; }
    .day-card:hover { border-color: #bdd7ff; }
    .day-controls { display: flex; flex-direction: column; align-items: center; gap: 10px; }
    .checkbox-pilih-hari { display: flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 600; color: #2563eb; margin: 0; }
    .checkbox-pilih-hari input { width: 17px; height: 17px; accent-color: #2878f0; cursor: pointer; }
    .day-info { background: #e8f1ff; border-radius: 9px; text-align: center; padding: 8px 4px; color: #2878f0; }
    .day-icon { width: 28px; height: 28px; margin: 0 auto 5px; border-radius: 50%; background: white; display: grid; place-items: center; }
    .day-info h3 { font-size: 11px; font-weight: 800; }
    .day-info small { display: block; margin-top: 3px; font-size: 9px; color: #7e91ad; }
    .field label { display: block; font-size: 9px; font-weight: 600; color: #687e9f; margin-bottom: 5px; }
    .time-input { display: flex; align-items: center; gap: 5px; border: 1px solid #dfe9f8; border-radius: 7px; padding: 0 7px; height: 33px; background: white; }
    .time-input input { width: 100%; border: none; outline: none; color: #294567; font-size: 11px; }
    .field-hint { display: block; margin-top: 4px; color: #8295b0; font-size: 8px; }
    .edit-button { border: 1px solid #d6e5fa; background: #f5f9ff; color: #2878f0; border-radius: 7px; padding: 8px 5px; font-size: 10px; font-weight: 700; cursor: pointer; }

    /* SWITCH */
    .switch-wrapper { display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .switch-status { font-size: 10px; font-weight: 700; color: #64748b; }
    .sunday-switch { position: relative; display: inline-flex; width: 42px; height: 24px; cursor: pointer; }
    .sunday-switch input { position: absolute; opacity: 0; }
    .sunday-switch .switch-track { position: absolute; inset: 0; background: #cbd5e1; border-radius: 30px; transition: .2s; }
    .sunday-switch .switch-track::before { content: ""; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: white; border-radius: 50%; transition: transform .2s; }
    .sunday-switch input:checked + .switch-track { background: #2878f0; }
    .sunday-switch input:checked + .switch-track::before { transform: translateX(18px); }

    /* FOOTER & MESSAGES */
    .panel-footer { display: flex; justify-content: space-between; align-items: center; gap: 12px; border-top: 1px solid #e9eff8; padding-top: 18px; margin-top: 18px; flex-wrap: wrap; }
    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 9px; border-radius: 10px; padding: 12px 17px; font-size: 11px; font-weight: 700; text-decoration: none; cursor: pointer; border: none; }
    .btn-back { border: 1px solid #dce6f4; background: white; color: #526c8f; }
    .btn-save { background: #2878f0; color: white; box-shadow: 0 5px 13px rgba(40,120,240,.18); }
    .success-message { background: #e2f8ec; border: 1px solid #c3efd6; color: #168553; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 12px; }
    .error-message { background: #fff0f0; color: #c73939; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 12px; }

    @media (max-width: 1100px) {
        .day-card { grid-template-columns: 35px 85px repeat(3, 1fr) 60px; }
        .edit-button { grid-column: 2 / -1; justify-self: end; }
    }
    @media (max-width: 760px) {
        .day-card { grid-template-columns: 1fr; gap: 13px; padding: 14px; }
        .day-info { display: flex; align-items: center; gap: 10px; text-align: left; }
        .pengaturan-massal { grid-template-columns: 1fr; }
        .panel-side { width: 100%; }
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
        <div class="active-badge"><i class="fa-solid fa-circle-check"></i> Pengaturan Aktif</div>
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
        @method('PUT')

        <div class="schedule-panel">
            <div class="panel-heading">
                <div class="panel-icon"><i class="fa-regular fa-calendar-check"></i></div>
                <div style="flex: 1;">
                    <div class="pengaturan-massal">
                        <div class="pengaturan-massal-item">
                            <label>Waktu Masuk</label>
                            <input type="time" id="serentakMasuk" value="09:00">
                            <button type="button" onclick="terapkanSatuJam('masuk')">Terapkan Waktu Masuk</button>
                        </div>
                        <div class="pengaturan-massal-item">
                            <label>Batas Jam Telat</label>
                            <input type="time" id="serentakTelat" value="09:15">
                            <button type="button" onclick="terapkanSatuJam('telat')">Terapkan Batas Telat</button>
                        </div>
                        <div class="pengaturan-massal-item">
                            <label>Jam Pulang</label>
                            <input type="time" id="serentakPulang" value="16:00">
                            <button type="button" onclick="terapkanSatuJam('pulang')">Terapkan Jam Pulang</button>
                        </div>
                    </div>
                </div>
                <div class="panel-side">
                    <div class="total-days">
                        <i class="fa-regular fa-clock"></i>
                        <div><small>Total Hari Kerja</small><strong>7 hari dalam seminggu</strong></div>
                    </div>
                    <div class="panel-side-tools">
                        <h2>Jadwal Kehadiran Mingguan</h2>
                        <label class="pilih-semua-hari"><input type="checkbox" id="pilihSemuaHari"> Pilih Semua Hari</label>
                    </div>
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
                    $isSunday = $key === 'minggu';
                    $jamMasuk = $jadwal[$key]['masuk'] ?? '07:00';
                    $jamTelat = $jadwal[$key]['telat'] ?? '07:15';
                    $jamPulang = $jadwal[$key]['pulang'] ?? '15:00';
                    $isAktif = $jadwal[$key]['aktif'] ?? ($key === 'sabtu' ? '1' : '0');
                @endphp

                <div class="day-card">
                    <div class="day-controls">
                        <label class="checkbox-pilih-hari">
                            <input type="checkbox" class="pilih-hari-jadwal" value="{{ $key }}"> Pilih
                        </label>
                        @if(in_array($key, ['sabtu', 'minggu']))
                            <div class="switch-wrapper">
                                <label class="sunday-switch">
                                    <input type="checkbox" name="status_{{ $key }}" value="1" {{ $isAktif == '1' ? 'checked' : '' }} onchange="updateSwitchStatus(this)">
                                    <span class="switch-track"></span>
                                </label>
                                <span class="switch-status">{{ $isAktif == '1' ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="day-info">
                        <div class="day-icon"><i class="fa-regular fa-calendar-check"></i></div>
                        <h3>{{ $dayName }}</h3>
                        <small>{{ $isSunday ? ($isAktif == '1' ? 'Hari Kerja' : 'Hari Libur') : 'Hari Kerja' }}</small>
                    </div>

                    <div class="field">
                        <label>Waktu Masuk</label>
                        <div class="time-input">
                            <input type="time" name="jam_masuk_{{ $key }}" value="{{ $jamMasuk }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Batas Jam Telat</label>
                        <div class="time-input">
                            <input type="time" name="jam_telat_{{ $key }}" value="{{ $jamTelat }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label>Jam Pulang</label>
                        <div class="time-input">
                            <input type="time" name="jam_pulang_{{ $key }}" value="{{ $jamPulang }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                    </div>

                    <button type="button" class="edit-button" onclick="toggleEdit(this)">
                        <i class="fas fa-pen"></i> Edit
                    </button>
                </div>
            @endforeach

            <div class="panel-footer">
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <button type="submit" class="btn btn-save"><i class="fa-regular fa-floppy-disk"></i> Simpan Pengaturan</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.toggleEdit = function (button) {
            const dayCard = button.closest('.day-card');
            if (!dayCard) return;
            const isEditing = dayCard.classList.toggle('editing');
            button.innerHTML = isEditing ? '<i class="fas fa-check"></i> Selesai' : '<i class="fas fa-pen"></i> Edit';
        };

        const pilihSemua = document.getElementById('pilihSemuaHari');
        const checkboxHari = document.querySelectorAll('.pilih-hari-jadwal');
        if (pilihSemua) {
            pilihSemua.addEventListener('change', function () {
                checkboxHari.forEach(cb => cb.checked = pilihSemua.checked);
            });
        }

        window.updateSwitchStatus = function (input) {
            const wrapper = input.closest('.switch-wrapper');
            if (wrapper) {
                const status = wrapper.querySelector('.switch-status');
                if (status) status.textContent = input.checked ? 'Aktif' : 'Nonaktif';
            }
            const card = input.closest('.day-card');
            if (card) {
                const dayInfo = card.querySelector('.day-info small');
                if (dayInfo) dayInfo.textContent = input.checked ? 'Hari Kerja' : 'Hari Libur';
            }
        };
    });

    // FUNGSI TERAPKAN JAM MASSAL (TANPA SYARAT CENTANG)
    function terapkanSatuJam(jenis) {
        const idMap = { masuk: 'serentakMasuk', telat: 'serentakTelat', pulang: 'serentakPulang' };
        const waktu = document.getElementById(idMap[jenis]).value;
        if (!waktu) return alert('Pilih waktu terlebih dahulu.');

        // Ubah semua hari tanpa perlu dicentang
        const semuaHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        
        semuaHari.forEach(hari => {
            const input = document.querySelector(`input[name="jam_${jenis}_${hari}"]`);
            if (input) {
                input.value = waktu;
                input.readOnly = false;
            }
        });

        alert('Waktu berhasil diterapkan ke SEMUA HARI. Klik Simpan Pengaturan untuk menyimpan.');
    }
</script>
@endsection