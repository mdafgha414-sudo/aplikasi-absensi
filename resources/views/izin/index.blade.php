@extends('layouts.app')

@section('content')

<style>
    .izin-page {
        padding: 25px;
        background: #f4f8fd;
        min-height: 100vh;
    }

    /* HEADER */
    .izin-hero {
        position: relative;
        overflow: hidden;
        padding: 35px 40px;
        border-radius: 20px;
        margin-bottom: 24px;
        background: linear-gradient(110deg, #0875ed, #079bea, #48c6f5);
        box-shadow: 0 8px 22px rgba(0, 112, 220, .15);
        color: white;
    }

    .izin-hero::before {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        right: 120px;
        top: -170px;
        border: 35px solid rgba(255,255,255,.10);
        border-radius: 50%;
    }

    .izin-hero::after {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        right: -60px;
        bottom: -130px;
        background: rgba(255,255,255,.12);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-label {
        display: inline-block;
        padding: 7px 16px;
        background: rgba(255,255,255,.22);
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .izin-hero h2 {
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .izin-hero p {
        margin: 0;
        font-size: 14px;
        color: rgba(255,255,255,.92);
    }

    .hero-icon {
        font-size: 80px;
        color: rgba(255,255,255,.85);
        position: relative;
        z-index: 2;
    }

    /* CARD */
    .izin-card {
        background: #fff;
        border: 1px solid #e8eef6;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 5px 20px rgba(40,70,110,.05);
    }

    .form-heading {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 20px;
        margin-bottom: 22px;
        border-bottom: 1px solid #e8eef6;
    }

    .form-heading-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e3f2ff;
        color: #087fe5;
        font-size: 27px;
    }

    .form-heading h4 {
        font-size: 20px;
        font-weight: 800;
        color: #172c4d;
        margin-bottom: 4px;
    }

    .form-heading p {
        font-size: 13px;
        color: #718198;
        margin: 0;
    }

    /* INPUT */
    .izin-form label {
        font-size: 14px;
        font-weight: 600;
        color: #243958;
        margin-bottom: 9px;
    }

    .required {
        color: #ef4444;
    }

    .izin-form .form-control,
    .izin-form .form-select {
        border: 1px solid #dce5f0;
        border-radius: 11px;
        padding: 11px 14px;
        font-size: 14px;
        color: #334968;
        background-color: #fbfcfe;
        transition: .2s;
    }

    .izin-form .form-control:focus,
    .izin-form .form-select:focus {
        border-color: #1685ed;
        box-shadow: 0 0 0 3px rgba(22,133,237,.10);
        background: #fff;
    }

    .izin-form textarea {
        min-height: 125px;
        resize: vertical;
    }

    .form-hint {
        font-size: 12px;
        color: #8190a5;
        margin-top: 7px;
    }

    .char-count {
        text-align: right;
        font-size: 12px;
        color: #8190a5;
        margin-top: 5px;
    }

    /* UPLOAD */
    .upload-area {
        border: 2px dashed #a7ccfa;
        background: #f4f9ff;
        border-radius: 15px;
        min-height: 130px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 22px;
        cursor: pointer;
        text-align: center;
        transition: .2s;
    }

    .upload-area:hover {
        background: #eaf4ff;
        border-color: #1685ed;
    }

    .upload-area i {
        font-size: 38px;
        color: #087fe5;
        margin-bottom: 10px;
    }

    .upload-area strong {
        font-size: 14px;
        color: #253c5e;
    }

    .upload-area span {
        font-size: 12px;
        color: #8190a5;
        margin-top: 5px;
    }

    #fileName {
        color: #087fe5;
        font-weight: 600;
        margin-top: 8px;
        font-size: 12px;
    }

    /* BUTTON */
    .btn-reset {
        padding: 11px 23px;
        border-radius: 11px;
        background: white;
        border: 1px solid #1685ed;
        color: #0875df;
        font-weight: 600;
    }

    .btn-reset:hover {
        background: #edf6ff;
        color: #075bb5;
    }

    .btn-submit {
        padding: 12px 25px;
        border-radius: 11px;
        border: none;
        color: white;
        font-weight: 700;
        background: linear-gradient(110deg, #0875ed, #0861dc);
        box-shadow: 0 5px 12px rgba(0,100,220,.17);
        transition: .2s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 17px rgba(0,100,220,.23);
        color: white;
    }

    /* KETENTUAN */
    .rules-card {
        background: white;
        border: 1px solid #e8eef6;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(40,70,110,.05);
    }

    .rules-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
    }

    .rules-heading i {
        color: #087fe5;
        font-size: 24px;
    }

    .rules-heading h5 {
        font-size: 17px;
        font-weight: 800;
        color: #172c4d;
        margin: 0;
    }

    .rule-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-bottom: 19px;
    }

    .rule-item i {
        color: #0eaa82;
        font-size: 16px;
        margin-top: 3px;
    }

    .rule-item p {
        color: #62748c;
        font-size: 13px;
        line-height: 1.7;
        margin: 0;
    }

    .rule-item strong {
        color: #263d5c;
    }

    .rules-illustration {
        text-align: center;
        padding: 15px 0;
        margin-top: 15px;
        background: linear-gradient(180deg, #f5faff, #e7f3ff);
        border-radius: 15px;
    }

    .rules-illustration i {
        font-size: 75px;
        color: #1685ed;
    }

    .rules-illustration p {
        color: #31547e;
        font-size: 13px;
        font-weight: 600;
        margin: 10px 0 0;
    }

    .info-box {
        padding: 15px;
        border-radius: 13px;
        background: #eaf4ff;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 15px;
    }

    .info-box i {
        color: #0875df;
        font-size: 21px;
    }

    .info-box p {
        color: #416184;
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }

    /* RESPONSIVE */
    @media(max-width: 992px) {
        .izin-hero {
            padding: 28px;
        }

        .rules-card {
            margin-top: 5px;
        }
    }

    @media(max-width: 576px) {
        .izin-page {
            padding: 14px;
        }

        .izin-hero {
            padding: 25px 20px;
        }

        .izin-hero h2 {
            font-size: 23px;
        }

        .hero-icon {
            display: none;
        }

        .izin-card,
        .rules-card {
            padding: 19px;
        }

        .form-heading h4 {
            font-size: 17px;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .form-actions button {
            width: 100%;
        }
    }
</style>


<div class="izin-page">

    {{-- HEADER --}}
    <div class="izin-hero">

        <div class="d-flex justify-content-between align-items-center">

            <div class="hero-content">

                <span class="hero-label">
                    <i class="bi bi-send me-1"></i>
                    Pengajuan Izin & Sakit
                </span>

                <h2>Pengajuan Izin & Sakit</h2>

                <p>
                    Ajukan izin ketidakhadiran Anda dengan mudah
                    dan cepat melalui formulir berikut.
                </p>

            </div>

            <div class="hero-icon">
                <i class="bi bi-clipboard2-check"></i>
            </div>

        </div>

    </div>


    <div class="row g-4">

        {{-- FORM PENGAJUAN --}}
        <div class="col-lg-8">

            <div class="izin-card">

                <div class="form-heading">

                    <div class="form-heading-icon">
                        <i class="bi bi-send"></i>
                    </div>

                    <div>
                        <h4>Form Pengajuan</h4>
                        <p>Isi formulir di bawah ini dengan lengkap dan benar.</p>
                    </div>

                </div>

                {{-- LOGIKA BLOKIR FORM JIKA SUDAH ABSEN --}}
                @if($sudahAbsenHariIni)
                    <div class="alert alert-warning d-flex align-items-start mb-0" role="alert" style="border-radius: 15px; border-left: 5px solid #f59e0b; background-color: #fffbeb; padding: 25px;">
                        <i class="bi bi-exclamation-triangle-fill fs-2 me-3 text-warning mt-1"></i>
                        <div>
                            <h5 class="alert-heading fw-bold text-dark mb-2">Anda Sudah Absen Hari Ini</h5>
                            <p class="mb-0 text-muted" style="font-size: 14px; line-height: 1.6;">
                                Sistem mendeteksi Anda sudah melakukan absensi masuk pada hari ini. Formulir pengajuan izin dinonaktifkan untuk mencegah data ganda.
                                <br><br>
                                <strong>Silakan ajukan izin untuk tanggal esok hari atau seterusnya.</strong>
                            </p>
                        </div>
                    </div>
                @else
                    <form
                        action="{{ url('/izin') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="izin-form"
                        id="izinForm"
                    >

                        @csrf

                        <div class="row g-4">

                            {{-- JENIS IZIN --}}
                            <div class="col-md-6">

                                <label>
                                    Jenis Izin <span class="required">*</span>
                                </label>

                                <select
                                    name="jenis_izin"
                                    id="jenis_izin"
                                    class="form-select"
                                    required
                                >
                                    <option value="">Pilih jenis izin...</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                </select>

                            </div>


                            {{-- TANGGAL --}}
                            <div class="col-md-6">

                                <label>
                                    Tanggal Izin <span class="required">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_izin"
                                    id="tanggal_izin"
                                    class="form-control"
                                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                    required
                                >

                            </div>


                            {{-- ALASAN --}}
                            <div class="col-12">

                                <label>
                                    Alasan Izin <span class="required">*</span>
                                </label>

                                <textarea
                                    name="alasan"
                                    id="alasanIzin"
                                    class="form-control"
                                    maxlength="500"
                                    placeholder="Jelaskan alasan izin Anda di sini..."
                                    required
                                ></textarea>

                                <div class="d-flex justify-content-between">
                                    <span class="form-hint">
                                        Berikan alasan yang jelas dan lengkap.
                                    </span>

                                    <span class="char-count">
                                        <span id="charCount">0</span>/500 karakter
                                    </span>
                                </div>

                            </div>


                            {{-- LAMPIRAN --}}
                            <div class="col-12">

                                <label>
                                    Lampiran / Surat Dokter
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>

                                <label for="lampiran" class="upload-area w-100">

                                    <i class="bi bi-cloud-arrow-up"></i>

                                    <strong>
                                        Klik atau seret file ke sini untuk mengunggah
                                    </strong>

                                    <span>
                                        Format: PDF, JPG, PNG | Maksimal 5MB
                                    </span>

                                    <div id="fileName"></div>

                                </label>

                                <input
                                    type="file"
                                    name="lampiran"
                                    id="lampiran"
                                    class="d-none"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                >

                            </div>


                            {{-- TOMBOL --}}
                            <div class="col-12">

                                <div class="d-flex justify-content-between align-items-center form-actions">

                                    <button
                                        type="reset"
                                        class="btn btn-reset"
                                        id="resetBtn"
                                    >
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                                        Reset
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-submit"
                                    >
                                        <i class="bi bi-send me-2"></i>
                                        Kirim Pengajuan
                                    </button>

                                </div>

                            </div>

                        </div>

                    </form>
                @endif

            </div>

        </div>


        {{-- PANEL KETENTUAN --}}
        <div class="col-lg-4">

            <div class="rules-card">

                <div class="rules-heading">
                    <i class="bi bi-info-circle-fill"></i>
                    <h5>Ketentuan Pengajuan</h5>
                </div>


                <div class="rule-item">
                    <i class="bi bi-check-circle"></i>
                    <p>
                        Pengajuan izin minimal dilakukan
                        <strong>1 hari sebelum</strong>
                        tanggal ketidakhadiran (kecuali sakit mendadak).
                    </p>
                </div>


                <div class="rule-item">
                    <i class="bi bi-check-circle"></i>
                    <p>
                        Jika sakit lebih dari 2 hari, wajib
                        melampirkan <strong>Surat Keterangan Dokter.</strong>
                    </p>
                </div>


                <div class="rule-item">
                    <i class="bi bi-check-circle"></i>
                    <p>
                        Status pengajuan dapat dipantau
                        di menu <strong>Riwayat Absensi.</strong>
                    </p>
                </div>


                <div class="rules-illustration">
                    <i class="bi bi-calendar2-check"></i>
                    <p>
                        Ajukan dengan mudah,<br>
                        pantau statusnya secara real-time!
                    </p>
                </div>


                <div class="info-box">
                    <i class="bi bi-info-circle"></i>
                    <p>
                        Pastikan pengajuan Anda sesuai
                        dengan ketentuan yang berlaku.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>


<script>
    // Pastikan elemen ada sebelum menjalankan script (karena form bisa disembunyikan)
    const alasan = document.getElementById('alasanIzin');
    const charCount = document.getElementById('charCount');
    
    if (alasan && charCount) {
        alasan.addEventListener('input', function () {
            charCount.textContent = this.value.length;
        });
    }

    const lampiran = document.getElementById('lampiran');
    const fileName = document.getElementById('fileName');

    if (lampiran && fileName) {
        lampiran.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                fileName.textContent = '';
                return;
            }

            const allowedTypes = [
                'application/pdf',
                'image/jpeg',
                'image/png'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Format file harus PDF, JPG, atau PNG.');
                this.value = '';
                fileName.textContent = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB.');
                this.value = '';
                fileName.textContent = '';
                return;
            }

            fileName.textContent = 'File dipilih: ' + file.name;
        });
    }

    // LOGIKA KALENDER OTOMATIS
    const jenisIzin = document.getElementById('jenis_izin');
    const tanggalIzin = document.getElementById('tanggal_izin');

    if (jenisIzin && tanggalIzin) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;

        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tmmrwYyyy = tomorrow.getFullYear();
        const tmmrwMm = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const tmmrwDd = String(tomorrow.getDate()).padStart(2, '0');
        const tomorrowStr = `${tmmrwYyyy}-${tmmrwMm}-${tmmrwDd}`;

        jenisIzin.addEventListener('change', function() {
            if (this.value === 'Sakit') {
                tanggalIzin.value = todayStr;
                tanggalIzin.min = todayStr;
                tanggalIzin.max = todayStr; 
            } else if (this.value === 'Izin') {
                tanggalIzin.value = tomorrowStr;
                tanggalIzin.min = tomorrowStr;
                tanggalIzin.max = ''; 
            } else {
                tanggalIzin.value = '';
                tanggalIzin.min = todayStr;
                tanggalIzin.max = '';
            }
        });
    }

    // RESET FORM
    const izinForm = document.getElementById('izinForm');
    if (izinForm) {
        izinForm.addEventListener('reset', function () {
            setTimeout(function () {
                if(charCount) charCount.textContent = '0';
                if(fileName) fileName.textContent = '';
                if(tanggalIzin) tanggalIzin.value = ''; 
            }, 0);
        });
    }
</script>

@endsection