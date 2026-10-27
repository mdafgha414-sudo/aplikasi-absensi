@extends('layouts.app')

@section('content')
{{-- Tambahkan container dengan padding atas (pt-4) atau margin atas --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- HEADER HALAMAN / WELCOME BANNER (Nuansa Biru Soft) --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-dark overflow-hidden position-relative" 
                 style="background: #e0f2fe !important; border: 1px solid #bae6fd !important;">
                <div class="position-absolute top-0 end-0 p-4 opacity-25" style="color: #0284c7;">
                    <i class="bi bi-journal-richtext display-1"></i>
                </div>
                <div class="card-body p-4 p-md-5 position-relative z-1">
                    <span class="badge px-3 py-1 rounded-pill mb-2 fw-normal small" 
                          style="background: #ffffff; color: #0284c7; border: 1px solid #bae6fd;">
                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                    </span>
                    <h2 class="fw-bold mb-1" style="color: #0f172a;">Jurnal Harian PKL</h2>
                    <p class="mb-0" style="color: #334155;">Catat kegiatan harian Praktik Kerja Lapangan Anda dengan mudah dan terstruktur.</p>
                </div>
            </div>

            {{-- ALERT SUKSES --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger"></i>
                        <div>
                            <strong>Periksa kembali data kamu:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- FORM / STATUS JURNAL HARIAN PKL --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-4">
                    @if($jurnalHariIni)
                        <div class="text-center py-3">
                            <div class="mb-3">
                                <span class="badge bg-success bg-opacity-10 text-success p-3 rounded-circle">
                                    <i class="bi bi-check-lg fs-2"></i>
                                </span>
                            </div>
                            <h4 class="fw-bold text-dark">Jurnal Hari Ini Sudah Terisi</h4>
                            <p class="text-muted small">Terima kasih telah mencatat kegiatan PKL Anda hari ini.</p>
                        </div>

                        <div class="p-4 bg-light rounded-4 border border-1 border-light-subtle">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <span class="text-muted small d-block mb-1">Tanggal Jurnal</span>
                                    <span class="fw-semibold text-dark">
                                        <i class="bi bi-calendar3 me-1" style="color: #0284c7;"></i>
                                        {{ \Carbon\Carbon::parse($jurnalHariIni->tanggal)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                <div class="col-12">
                                    <hr class="text-muted opacity-25 my-2">
                                    <span class="text-muted small d-block mb-1">Kegiatan</span>
                                    <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $jurnalHariIni->kegiatan }}</p>
                                </div>
                                <div class="col-12">
                                    <hr class="text-muted opacity-25 my-2">
                                    <span class="text-muted small d-block mb-1">Kendala</span>
                                    <p class="mb-0 text-dark">
                                        @if($jurnalHariIni->kendala)
                                            <span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i> {{ $jurnalHariIni->kendala }}</span>
                                        @else
                                            <span class="text-success"><i class="bi bi-shield-check me-1"></i> Tidak ada kendala.</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center mb-4">
                            <div class="p-3 rounded-3 me-3" style="background: #e0f2fe; color: #0284c7;">
                                <i class="bi bi-pencil-square fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Form Input Jurnal</h5>
                                <p class="text-muted small mb-0">Silakan isi laporan kegiatan PKL Anda hari ini.</p>
                            </div>
                        </div>

                        <form action="{{ url('/jurnal') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wide">Pilih Tanggal Jurnal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" name="tanggal" class="form-control bg-light border-start-0 ps-0" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-text small">Anda bisa memilih tanggal hari ini atau tanggal sebelumnya jika belum mengisi.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wide" for="kegiatan">
                                    Apa saja kegiatan Anda hari ini? <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="kegiatan"
                                    name="kegiatan"
                                    class="form-control bg-light"
                                    rows="4"
                                    placeholder="Contoh: Membuat desain UI untuk halaman login menggunakan Figma..."
                                    required>{{ old('kegiatan') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small text-uppercase tracking-wide" for="kendala">
                                    Apakah ada kendala? <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <textarea
                                    id="kendala"
                                    name="kendala"
                                    class="form-control bg-light"
                                    rows="2"
                                    placeholder="Contoh: Kesulitan menghubungkan database ke Laravel...">{{ old('kendala') }}</textarea>
                            </div>

                            {{-- Tombol Simpan jadi Biru --}}
                            <button type="submit" class="btn w-100 py-2.5 rounded-3 fw-semibold shadow-sm text-white" style="background: #0284c7; border: none;">
                                <i class="bi bi-send-fill me-2"></i>
                                Simpan Jurnal Hari Ini
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- RIWAYAT JURNAL --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <div class="d-flex align-items-center">
                        {{-- Ikon jadi Biru Soft --}}
                        <div class="p-2 rounded-3 me-3" style="background: #e0f2fe; color: #0284c7;">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Riwayat Jurnal Anda</h5>
                            <p class="text-muted small mb-0">Daftar seluruh jurnal kegiatan PKL yang pernah Anda kirim.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            {{-- Header Tabel Biru Soft --}}
                            <thead class="text-uppercase small" style="background: #f0f9ff; color: #0369a1;">
                                <tr>
                                    <th class="py-3 rounded-start border-0">Tanggal</th>
                                    <th class="py-3 border-0">Kegiatan</th>
                                    <th class="py-3 border-0">Kendala</th>
                                    <th class="py-3 rounded-end border-0">Nilai &amp; Catatan Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatJurnal as $jurnal)
                                    <tr>
                                        <td class="fw-semibold text-nowrap">
                                            <div class="text-dark">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</div>
                                        </td>
                                        <td>
                                            <div class="text-dark text-wrap" style="min-width: 200px;">{{ $jurnal->kegiatan }}</div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $jurnal->kendala ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if($jurnal->nilai)
                                                <div class="d-flex flex-column align-items-start">
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 mb-1 fw-semibold">
                                                        <i class="bi bi-star-fill me-1"></i> Nilai: {{ $jurnal->nilai }}
                                                    </span>
                                                    @if($jurnal->catatan_guru)
                                                        <small class="text-muted fst-italic">“{{ $jurnal->catatan_guru }}”</small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1">
                                                    <i class="bi bi-hourglass-split me-1"></i> Belum Dinilai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <div class="py-3">
                                                <i class="bi bi-folder2-open display-6 text-muted opacity-50 mb-2 d-block"></i>
                                                Belum ada riwayat jurnal yang tercatat.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection