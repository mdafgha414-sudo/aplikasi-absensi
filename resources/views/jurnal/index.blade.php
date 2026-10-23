
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- ALERT SUKSES --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-3">
                    <strong>Periksa kembali data kamu:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM JURNAL HARIAN PKL --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
<<<<<<< HEAD
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-journal-text text-primary me-2"></i>
                        Jurnal Harian PKL
                    </h5>
                    <p class="text-muted small mb-0">
                        Tanggal: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                    </p>
=======
                    <h5 class="mb-0 fw-bold">Jurnal Harian PKL</h5>
                    <p class="text-muted small mb-0">Hari ini: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
>>>>>>> 9201ffdd2cd021995635c835bc9c539f9794d680
                </div>

                <div class="card-body">
                    @if($jurnalHariIni)
<<<<<<< HEAD
                        <div class="alert alert-info border-0 rounded-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Kamu sudah mengisi jurnal hari ini. Terima kasih!
=======
                        <div class="alert alert-info border-0">
                            <i class="bi bi-check-circle-fill me-2"></i> Anda sudah mengisi jurnal untuk hari ini. Terima kasih!
>>>>>>> 9201ffdd2cd021995635c835bc9c539f9794d680
                        </div>

                        <div class="p-3 bg-light rounded-3">
<<<<<<< HEAD
                            <strong>Kegiatan:</strong>
                            <p class="mt-1">{{ $jurnalHariIni->kegiatan }}</p>

                            <strong>Kendala:</strong>
=======
                            <strong>Tanggal Jurnal:</strong> {{ \Carbon\Carbon::parse($jurnalHariIni->tanggal)->translatedFormat('d F Y') }} <br><br>
                            <strong>Kegiatan:</strong> <br>
                            <p>{{ $jurnalHariIni->kegiatan }}</p>
                            <strong>Kendala:</strong> <br>
>>>>>>> 9201ffdd2cd021995635c835bc9c539f9794d680
                            <p class="mb-0">{{ $jurnalHariIni->kendala ?? 'Tidak ada kendala.' }}</p>
                        </div>
                    @else
                        <form action="{{ url('/jurnal') }}" method="POST">
                            @csrf
<<<<<<< HEAD
=======
                            
                            <!-- FITUR KALENDER (PILIH TANGGAL) -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Tanggal Jurnal</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                <div class="form-text">Anda bisa memilih tanggal hari ini atau tanggal sebelumnya jika belum mengisi.</div>
                            </div>
>>>>>>> 9201ffdd2cd021995635c835bc9c539f9794d680

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="kegiatan">
                                    Apa saja kegiatan Anda hari ini?
                                </label>
                                <textarea
                                    id="kegiatan"
                                    name="kegiatan"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Contoh: Membuat desain UI untuk halaman login..."
                                    required>{{ old('kegiatan') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="kendala">
                                    Apakah ada kendala? (Opsional)
                                </label>
                                <textarea
                                    id="kendala"
                                    name="kendala"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Contoh: Kesulitan menghubungkan database...">{{ old('kendala') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
<<<<<<< HEAD
                                <i class="bi bi-send me-2"></i>
                                Simpan Jurnal Hari Ini
=======
                                <i class="bi bi-send me-2"></i> Simpan Jurnal
>>>>>>> 9201ffdd2cd021995635c835bc9c539f9794d680
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- RIWAYAT JURNAL --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Riwayat Jurnal Anda
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Kendala</th>
                                    <th>Nilai &amp; Catatan Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatJurnal as $jurnal)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>{{ $jurnal->kegiatan }}</td>
                                        <td>{{ $jurnal->kendala ?? '-' }}</td>
                                        <td>
                                            @if($jurnal->nilai)
                                                <span class="badge bg-success">
                                                    Nilai: {{ $jurnal->nilai }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $jurnal->catatan_guru }}
                                                </small>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Belum Dinilai
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            Belum ada riwayat jurnal.
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
