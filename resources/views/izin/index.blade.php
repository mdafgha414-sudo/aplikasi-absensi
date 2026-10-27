@extends('layouts.app') {{-- Sesuaikan dengan nama layout Anda --}}

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- 1. Header Banner Modern (Nuansa Biru Soft) -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 position-relative overflow-hidden" 
         style="background: #e0f2fe !important; border: 1px solid #bae6fd !important;">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    
                    <h2 class="fw-bold mb-2" style="color: #0f172a;">Pengajuan Izin & Sakit</h2>
                    <p class="mb-0 fs-6" style="color: #334155;">
                        Ajukan izin ketidakhadiran Anda selama kegiatan PKL dengan mengisi formulir di bawah ini secara lengkap.
                    </p>
                </div>
                <div class="col-md-4 text-center text-md-end d-none d-md-block">
                    <i class="bi bi-envelope-paper-fill display-1 opacity-25" style="color: #0284c7;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Card Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        {{-- Ikon Form jadi Biru Soft --}}
                        <div class="rounded-3 p-3 me-3" style="background: #e0f2fe; color: #0284c7;">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Formulir Pengajuan</h5>
                            <p class="text-muted small mb-0">Isi data dengan benar sebelum mengirim pengajuan izin Anda.</p>
                        </div>
                    </div>

                    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Field: Jenis Izin & Tanggal -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="jenis_izin" class="form-label fw-semibold text-secondary">
                                    Jenis Izin <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-tag"></i>
                                    </span>
                                    <select name="jenis_izin" id="jenis_izin" class="form-select bg-light border-start-0 ps-0" required>
                                        <option value="" disabled selected>Pilih jenis izin...</option>
                                        <option value="Izin">Izin (Kepentingan/Urusan)</option>
                                        <option value="Sakit">Sakit (Memerlukan Surat Dokter)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_izin" class="form-label fw-semibold text-secondary">
                                    Tanggal Izin <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-calendar3"></i>
                                    </span>
                                    <input type="date" name="tanggal_izin" id="tanggal_izin" class="form-control bg-light border-start-0 ps-0" required>
                                </div>
                            </div>
                        </div>

                        <!-- Field: Alasan Izin -->
                        <div class="mb-4">
                            <label for="alasan" class="form-label fw-semibold text-secondary">
                                Alasan Izin <span class="text-danger">*</span>
                            </label>
                            <textarea name="alasan" id="alasan" rows="4" maxlength="500" class="form-control bg-light p-3" 
                                      placeholder="Jelaskan alasan detail pengajuan izin kamu di sini..." required></textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <span class="text-muted small">Berikan alasan yang meyakinkan & jelas.</span>
                                <span class="text-muted small"><span id="charCount">0</span>/500 karakter</span>
                            </div>
                        </div>

                        <!-- Field: Upload Lampiran Custom -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">
                                Lampiran / Surat Dokter <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light position-relative" id="dropArea">
                                <i class="bi bi-cloud-arrow-up display-5 mb-2" style="color: #0284c7;"></i>
                                <p class="fw-semibold mb-1 text-dark">Klik atau seret file ke sini untuk mengunggah</p>
                                <p class="text-muted small mb-0">Format yang didukung: JPG, PNG, PDF (Maksimal 2MB)</p>
                                <input type="file" name="lampiran" id="lampiran" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer">
                            </div>
                            <div id="fileInfo" class="mt-2 text-success small fw-semibold d-none">
                                <i class="bi bi-check-circle me-1"></i> File terpilih: <span id="fileName"></span>
                            </div>
                        </div>

                        <!-- Tombol Action -->
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                            <button type="reset" class="btn btn-light rounded-3 px-4 fw-medium text-secondary">
                                Batal
                            </button>
                            {{-- Tombol Kirim jadi Biru --}}
                            <button type="submit" class="btn rounded-3 px-4 py-2 fw-semibold shadow-sm text-white" style="background: #0284c7; border: none;">
                                <i class="bi bi-send me-1"></i> Kirim Pengajuan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- 3. Sidebar Widget InformasiTambahan (Opsional) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-info-circle me-2" style="color: #0284c7;"></i>Ketentuan Pengajuan
                </h6>
                <ul class="list-unstyled mb-0 small text-muted">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-check2-circle text-success me-2 fs-6"></i>
                        <span>Pengajuan izin minimal dilakukan <strong>1 hari sebelum</strong> tanggal ketidakhadiran (kecuali sakit mendadak).</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-check2-circle text-success me-2 fs-6"></i>
                        <span>Jika sakit lebih dari 2 hari, wajib melampirkan <strong>Surat Keterangan Dokter</strong>.</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-check2-circle text-success me-2 fs-6"></i>
                        <span>Status pengajuan dapat dipantau di menu <strong>Riwayat Absensi</strong>.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript Sederhana untuk Penghitung Karakter & Preview File -->
<script>
    // Live Character Counter
    const textarea = document.getElementById('alasan');
    const charCount = document.getElementById('charCount');
    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });

    // File Input Name Display
    const fileInput = document.getElementById('lampiran');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            fileName.textContent = e.target.files[0].name;
            fileInfo.classList.remove('d-none');
        } else {
            fileInfo.classList.add('d-none');
        }
    });
</script>
@endsection