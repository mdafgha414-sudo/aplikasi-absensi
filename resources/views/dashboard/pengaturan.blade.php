@extends('layouts.app')

@section('content')
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

    .content-wrapper {
        font-family: 'Inter', sans-serif;
        background: var(--background);
        color: var(--text);
        min-height: 100vh;
        padding: 30px 32px 45px;
        max-width: 1450px;
        margin: auto;
    }

    button, input { font-family: inherit; }
    button { cursor: pointer; }

    /* HEADER */
    .breadcrumb {
        display: flex;
        gap: 11px;
        align-items: center;
        font-size: 11px;
        color: #8396b4;
        margin-bottom: 27px;
    }

    .breadcrumb i:first-child { color: var(--primary); }

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
        flex-wrap: wrap;
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

    .panel-heading h2 { font-size: 15px; color: #233d63; }
    .panel-heading p { font-size: 11px; color: #8192ad; margin-top: 6px; line-height: 1.6; }

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

    .panel-side {
        width: 170px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-self: stretch;
    }

    .panel-side .total-days { width: 100%; margin: 0; }

    .panel-side-tools {
        width: 100%;
        padding: 10px;
        border: 1px solid #d4e5ff;
        border-radius: 11px;
        background: #fff;
    }

    .panel-side-tools h2 { font-size: 11px; line-height: 1.5; color: #233d63; margin-bottom: 8px; }

    .panel-side-tools .pilih-semua-hari {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0;
        font-size: 10px;
        line-height: 1.5;
    }

    .total-days i { font-size: 20px; }
    .total-days small { display: block; color: #8192ad; font-size: 10px; margin-bottom: 4px; }
    .total-days strong { display: block; font-size: 11px; }

    /* PENGATURAN MASSAL */
    .pengaturan-massal {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin: 16px 0;
        width: 100%;
    }

    .pengaturan-massal-item {
        min-width: 0;
        padding: 14px;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        background: #f8fbff;
    }

    .pengaturan-massal-item label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .pengaturan-massal-item input {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: white;
    }

    .pengaturan-massal-item button {
        width: 100%;
        margin-top: 10px;
        padding: 10px 6px;
        border: none;
        border-radius: 8px;
        background: #2878f0;
        color: white;
        font-weight: 600;
        cursor: pointer;
    }

    .pengaturan-massal-item button:hover { background: #1764d1; }

    /* KARTU JADWAL */
    .day-card {
        --day-color: #2878f0;
        --day-light: #e8f1ff;
        display: grid;
        grid-template-columns: 40px 95px minmax(0, 1fr) minmax(0, 1fr) minmax(0, 1fr) 65px;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        border-radius: 11px;
        padding: 8px;
        margin-bottom: 8px;
        transition: border-color .2s, box-shadow .2s;
    }

    .day-card:hover { border-color: #bdd7ff; box-shadow: 0 5px 18px rgba(48,111,205,.055); }

    .day-card.tuesday { --day-color: #13a778; --day-light: #e4f9f0; }
    .day-card.wednesday { --day-color: #8951e8; --day-light: #f1e8ff; }
    .day-card.thursday { --day-color: #e87922; --day-light: #fff0df; }
    .day-card.friday { --day-color: #089bb9; --day-light: #e0f8fc; }
    .day-card.saturday { --day-color: #d9437b; --day-light: #ffe8f0; }
    .day-card.sunday { --day-color: #2878f0; --day-light: #e8f1ff; background: white; }

    .day-controls {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 0;
    }

    .day-info {
        background: var(--day-light);
        border-radius: 9px;
        text-align: center;
        padding: 8px 4px;
        color: var(--day-color);
        min-width: 0;
    }

    .day-icon {
        width: 28px;
        height: 28px;
        margin: 0 auto 5px;
        border-radius: 50%;
        background: white;
        display: grid;
        place-items: center;
    }

    .day-info h3 { font-size: 11px; font-weight: 800; }
    .day-info small { display: block; margin-top: 3px; font-size: 9px; color: #7e91ad; }

    .field label { display: block; font-size: 9px; font-weight: 600; color: #687e9f; margin-bottom: 5px; }

    .time-input {
        display: flex;
        align-items: center;
        gap: 5px;
        border: 1px solid #dfe9f8;
        border-radius: 7px;
        padding: 0 7px;
        height: 33px;
        background: white;
        transition: .2s;
    }

    .time-input input {
        width: 100%;
        min-width: 0;
        border: none;
        outline: none;
        color: #294567;
        background: transparent;
        font-size: 11px;
    }

    .field-hint { display: block; margin-top: 4px; color: #8295b0; font-size: 8px; line-height: 1.4; }

    .edit-button {
        border: 1px solid #d6e5fa;
        background: #f5f9ff;
        color: #2878f0;
        border-radius: 7px;
        padding: 8px 5px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .edit-button:hover:not(:disabled) { background: #2878f0; color: white; border-color: #2878f0; }

    /* CHECKBOX & SWITCH */
    .checkbox-pilih-hari {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 600;
        color: #2563eb;
        margin: 0;
    }

    .checkbox-pilih-hari input, .pilih-semua-hari input {
        width: 17px; height: 17px; accent-color: #2878f0; cursor: pointer;
    }

    .pilih-semua-hari {
        display: inline-flex; align-items: center; gap: 8px;
        margin: 10px 0; color: #1e40af; font-size: 13px; font-weight: 600; cursor: pointer;
    }

    .day-card:has(.pilih-hari-jadwal:checked) { border-color: #2878f0; background-color: #f5f9ff; }

    .switch-wrapper { display: flex; flex-direction: column; align-items: center; gap: 5px; margin-top: 2px; }
    .switch-status { font-size: 10px; font-weight: 700; color: #64748b; }
    .switch-wrapper:has(input:checked) .switch-status { color: #1672e8; }

    .sunday-switch { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 24px; margin: 0; cursor: pointer; }
    .sunday-switch input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .sunday-switch .switch-track { position: absolute; inset: 0; background: #cbd5e1; border-radius: 30px; transition: background .2s ease; }
    .sunday-switch .switch-track::before { content: ""; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: white; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,.2); transition: transform .2s ease; }
    .sunday-switch input:checked + .switch-track { background: #2878f0; }
    .sunday-switch input:checked + .switch-track::before { transform: translateX(18px); }
    .sunday-switch input:focus-visible + .switch-track { outline: 3px solid #bfdbfe; outline-offset: 2px; }

    /* FOOTER */
    .info-note { display: flex; align-items: center; gap: 10px; background: #edf5ff; color: #4a80ca; padding: 13px 15px; border-radius: 10px; margin-top: 17px; font-size: 10px; line-height: 1.6; }
    .info-note i { font-size: 15px; }

    .panel-footer { display: flex; justify-content: space-between; align-items: center; gap: 12px; border-top: 1px solid #e9eff8; padding-top: 18px; margin-top: 18px; }

    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 9px; border-radius: 10px; padding: 12px 17px; font-size: 11px; font-weight: 700; text-decoration: none; transition: .2s; }
    .btn-back { border: 1px solid #dce6f4; background: white; color: #526c8f; }
    .btn-back:hover { background: #f3f7fd; }
    .btn-save { border: none; background: linear-gradient(110deg, #3988ff, #236ee9); color: white; box-shadow: 0 5px 13px rgba(40,120,240,.18); }
    .btn-save:hover { transform: translateY(-1px); }

    .success-message { background: #e2f8ec; border: 1px solid #c3efd6; color: #168553; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 12px; }
    .error-message { background: #fff0f0; color: #c73939; padding: 13px 15px; border-radius: 10px; margin-bottom: 18px; font-size: 12px; }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .day-card { grid-template-columns: 35px 85px repeat(3, minmax(0, 1fr)) 60px; gap: 6px; padding: 7px; }
        .edit-button { grid-column: 2 / -1; justify-self: end; min-width: 90px; }
        .content-wrapper { padding: 25px 20px; }
    }

    @media (max-width: 760px) {
        .panel-side { width: 100%; }
        .day-card { grid-template-columns: 1fr; gap: 13px; padding: 14px; }
        .day-info { display: flex; align-items: center; gap: 10px; text-align: left; padding: 10px 12px; }
        .day-icon { margin: 0; flex-shrink: 0; }
        .day-info small { margin: 0 0 0 auto; }
        .field label { font-size: 11px; }
        .time-input { height: 43px; }
        .edit-button { grid-column: auto; justify-self: stretch; padding: 12px; }
        .panel-footer { flex-wrap: wrap; }
        .btn { flex: 1; }
        .pengaturan-massal { grid-template-columns: 1fr; }
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

    <!-- HEADING -->
    <div class="page-heading">
        <div class="heading-icon">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div>
            <h1>Pengaturan Jadwal Absensi</h1>
            <p>Atur waktu masuk, batas keterlambatan, dan jam pulang untuk setiap hari.</p>
        </div>
        <div class="active-badge">
            <i class="fa-solid fa-circle-check"></i> Pengaturan Aktif
        </div>
    </div>

    @if(session('success'))
        <div class="success-message">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
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

    <form action="{{ url('/admin/setting') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="schedule-panel">
            <div class="panel-heading">
                <div class="panel-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div style="flex: 1;">
                    <div class="pengaturan-massal">
                        <div class="pengaturan-massal-item">
                            <label for="serentakMasuk">Waktu Masuk</label>
                            <input type="time" id="serentakMasuk" value="09:00">
                            <button type="button" onclick="terapkanSatuJam('masuk')">Terapkan Waktu Masuk</button>
                        </div>
                        <div class="pengaturan-massal-item">
                            <label for="serentakTelat">Batas Jam Telat</label>
                            <input type="time" id="serentakTelat" value="09:15">
                            <button type="button" onclick="terapkanSatuJam('telat')">Terapkan Batas Telat</button>
                        </div>
                        <div class="pengaturan-massal-item">
                            <label for="serentakPulang">Jam Pulang</label>
                            <input type="time" id="serentakPulang" value="16:00">
                            <button type="button" onclick="terapkanSatuJam('pulang')">Terapkan Jam Pulang</button>
                        </div>
                    </div>
                </div>
                <div class="panel-side">
                    <div class="total-days">
                        <i class="fa-regular fa-clock"></i>
                        <div>
                            <small>Total Hari Kerja</small>
                            <strong>7 hari dalam seminggu</strong>
                        </div>
                    </div>
                    <div class="panel-side-tools">
                        <h2>Jadwal Kehadiran Mingguan</h2>
                        <label class="pilih-semua-hari">
                            <input type="checkbox" id="pilihSemuaHari"> Pilih Semua Hari
                        </label>
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
                $defaultSchedules = ['masuk' => '07:00', 'telat' => '07:15', 'pulang' => '15:00'];
            @endphp

            @foreach($days as $key => $day)
                @php
                    $isSunday = $key === 'minggu';
                    $schedule = $jadwal[$key] ?? $defaultSchedules;
                @endphp

                <div class="day-card {{ $day[1] }} {{ $isSunday ? 'sunday' : '' }}" data-day="{{ $day[0] }}" data-holiday="{{ $isSunday ? 'true' : 'false' }}">
                    <div class="day-controls">
                        <label class="checkbox-pilih-hari">
                            <input type="checkbox" class="pilih-hari-jadwal" value="{{ $key }}">
                            Pilih
                        </label>
                        @if(in_array($key, ['sabtu', 'minggu']))
                            <div class="switch-wrapper">
                                <label class="sunday-switch">
                                    <input type="checkbox" name="jadwal[{{ $key }}][aktif]" value="1" {{ old("jadwal.$key.aktif", $jadwal[$key]['aktif'] ?? ($key === 'sabtu' ? '1' : '0')) == '1' ? 'checked' : '' }} onchange="updateSwitchStatus(this)">
                                    <span class="switch-track"></span>
                                </label>
                                <span class="switch-status">{{ ($jadwal[$key]['aktif'] ?? ($key === 'sabtu' ? '1' : '0')) == '1' ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="day-info">
                        <div class="day-icon"><i class="fa-regular fa-calendar-check"></i></div>
                        <h3>{{ $day[0] }}</h3>
                        <small>
                            @if($isSunday)
                                {{ old('jadwal.minggu.aktif', $jadwal['minggu']['aktif'] ?? '0') == '1' ? 'Hari Kerja' : 'Hari Libur' }}
                            @else
                                Hari Kerja
                            @endif
                        </small>
                    </div>

                    <div class="field">
                        <label for="{{ $key }}_masuk">Waktu Masuk</label>
                        <div class="time-input">
                            <input type="time" id="{{ $key }}_masuk" name="jadwal[{{ $key }}][masuk]" value="{{ old("jadwal.$key.masuk", $schedule['masuk'] ?? '07:00') }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <small class="field-hint">Jam mulai kerja</small>
                    </div>

                    <div class="field">
                        <label for="{{ $key }}_telat">Batas Jam Telat</label>
                        <div class="time-input">
                            <input type="time" id="{{ $key }}_telat" name="jadwal[{{ $key }}][telat]" value="{{ old("jadwal.$key.telat", $schedule['telat'] ?? '07:15') }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <small class="field-hint">Batas waktu keterlambatan</small>
                    </div>

                    <div class="field">
                        <label for="{{ $key }}_pulang">Jam Pulang</label>
                        <div class="time-input">
                            <input type="time" id="{{ $key }}_pulang" name="jadwal[{{ $key }}][pulang]" value="{{ old("jadwal.$key.pulang", $schedule['pulang'] ?? '15:00') }}">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <small class="field-hint">Jam selesai kerja</small>
                    </div>

                    <button type="button" class="edit-button" onclick="toggleEdit(this)">
                        <i class="fas fa-pen"></i> Edit
                    </button>
                </div>
            @endforeach

            <div class="info-note">
                <i class="fa-solid fa-circle-info"></i>
                <span>Klik tombol Edit untuk mengubah jadwal. Perubahan dikirim setelah tombol Simpan Pengaturan ditekan.</span>
            </div>

            <div class="panel-footer">
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fa-regular fa-floppy-disk"></i> Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // FUNGSI EDIT JADWAL (DIPERBAIKI)
        window.toggleEdit = function (button) {
            const dayCard = button.closest('.day-card');
            if (!dayCard) return;

            const isEditing = dayCard.classList.toggle('editing');
            button.innerHTML = isEditing ? '<i class="fas fa-check"></i> Selesai' : '<i class="fas fa-pen"></i> Edit';
            
            // TIDAK ADA LAGI input.readOnly DI SINI
        };

        // FUNGSI PILIH SEMUA HARI
        const pilihSemua = document.getElementById('pilihSemuaHari');
        const checkboxHari = document.querySelectorAll('.pilih-hari-jadwal');

        if (pilihSemua) {
            pilihSemua.addEventListener('change', function () {
                checkboxHari.forEach(cb => cb.checked = pilihSemua.checked);
            });
            checkboxHari.forEach(cb => {
                cb.addEventListener('change', function () {
                    pilihSemua.checked = Array.from(checkboxHari).every(item => item.checked);
                });
            });
        }

        // FUNGSI SWITCH SABTU/MINGGU
        window.updateSwitchStatus = function (input) {
            const wrapper = input.closest('.switch-wrapper');
            if (!wrapper) return;
            const status = wrapper.querySelector('.switch-status');
            if (status) status.textContent = input.checked ? 'Aktif' : 'Nonaktif';

            const card = input.closest('.day-card');
            if (card) {
                const dayInfo = card.querySelector('.day-info small');
                if (dayInfo) dayInfo.textContent = input.checked ? 'Hari Kerja' : 'Hari Libur';
            }
        };
    });

    // FUNGSI TERAPKAN JAM MASSAL
    function terapkanSatuJam(jenis) {
        const config = {
            masuk: { id: 'serentakMasuk', nama: 'Waktu Masuk' },
            telat: { id: 'serentakTelat', nama: 'Batas Jam Telat' },
            pulang: { id: 'serentakPulang', nama: 'Jam Pulang' }
        };
        const c = config[jenis];
        const waktu = document.getElementById(c.id).value;
        if (!waktu) return alert('Pilih waktu terlebih dahulu.');

        const hariDipilih = document.querySelectorAll('.pilih-hari-jadwal:checked');
        if (hariDipilih.length === 0) return alert('Centang minimal satu hari.');

        let count = 0;
        hariDipilih.forEach(cb => {
            const hari = cb.value;
            const input = document.querySelector(`input[name="jadwal[${hari}][${jenis}]"]`);
            if (input) {
                input.value = waktu;
                count++;
            }
        });
        alert(`${c.nama} diterapkan ke ${count} hari. Klik Simpan untuk menyimpan.`);
    }
</script>
@endsection