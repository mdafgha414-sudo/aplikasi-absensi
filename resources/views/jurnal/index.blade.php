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

            {{-- ALERT ERROR VALIDASI --}}
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
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-journal-text text-primary me-2"></i>
                        Jurnal Harian PKL
                    </h5>
                    <p class="text-muted small mb-0">
                        Tanggal: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <div class="card-body">
                    @if($jurnalHariIni)
                        <div class="alert alert-info border-0 rounded-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Kamu sudah mengisi jurnal hari ini. Terima kasih!
                        </div>

                        <div class="p-3 bg-light rounded-3">
                            <strong>Kegiatan:</strong>
                            <p class="mt-1">{{ $jurnalHariIni->kegiatan }}</p>
                            <strong>Kendala:</strong>
                            <p class="mb-0">{{ $jurnalHariIni->kendala ?? 'Tidak ada kendala.' }}</p>
                        </div>
                        @else
                        <form action="{{ url('/jurnal') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="kegiatan">Apa saja kegiatan Anda hari ini?</label>
                                <textarea
                                    id="kegiatan"
                                    name="kegiatan"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Contoh: Membuat desain UI untuk halaman login..."
                                    required>{{ old('kegiatan') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="kendala">Apakah ada kendala? (Opsional)</label>
                                <textarea
                                    id="kendala"
                                    name="kendala"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Contoh: Kesulitan menghubungkan database..."
                                >{{ old('kendala') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-send me-2"></i>
                                Simpan Jurnal Hari Ini
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
                                        <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                                        <td>{{ $jurnal->kegiatan }}</td>
                                        <td>{{ $jurnal->kendala ?? '-' }}</td>
                                        <td>
                                            @if($jurnal->nilai)
                                                <span class="badge bg-success">Nilai: {{ $jurnal->nilai }}</span>
                                                <br>
                                                <small class="text-muted">{{ $jurnal->catatan_guru }}</small>
                                            @else
                                                <span class="badge bg-secondary">Belum Dinilai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada riwayat jurnal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                      </div>
            </div>

            {{-- FORM PENGAJUAN IZIN --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-1 fw-bold">
                        <i class="bi bi-calendar2-check text-primary me-2"></i>
                        Pengajuan Izin
                    </h5>
                    <p class="text-muted small mb-0">Isi formulir jika kamu tidak dapat mengikuti kegiatan PKL.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_izin" class="form-label fw-bold">Jenis Izin</label>
                                <select id="jenis_izin" name="jenis_izin" class="form-select" required>
                                    <option value="">Pilih jenis izin</option>
                                    <option value="Izin" {{ old('jenis_izin') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ old('jenis_izin') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="Keperluan Keluarga" {{ old('jenis_izin') == 'Keperluan Keluarga' ? 'selected' : '' }}>Keperluan Keluarga</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_izin" class="form-label fw-bold">Tanggal Izin</label>
                                <input
                                    type="date"
                                    id="tanggal_izin"
                                    name="tanggal_izin"
                                    class="form-control"
                                    value="{{ old('tanggal_izin') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="alasan" class="form-label fw-bold">Alasan Izin</label>
                                <textarea
                                    id="alasan"
                                    name="alasan"
                                    class="form-control"
                                    rows="3"
                                    maxlength="500"
                                    placeholder="Jelaskan alasan izin..."
                                    required>{{ old('alasan') }}</textarea>
                                <small class="text-muted">Maksimal 500 karakter.</small>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="lampiran" class="form-label fw-bold">Lampiran (Opsional)</label>
                                <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">Format PDF, JPG, atau PNG. Maksimal 2 MB.</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-send me-2"></i>
                            Ajukan Izin
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIWAYAT PENGAJUAN IZIN --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-check text-primary me-2"></i>
                        Riwayat Pengajuan Izin
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jenis Izin</th>
                                    <th>Tanggal Izin</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($riwayatIzin ?? collect()) as $izin)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y') }}</td>
                                        <td>
                                            @if($izin->jenis_izin === 'Sakit')
                                                <span class="badge bg-danger-subtle text-danger">{{ $izin->jenis_izin }}</span>
                                            @elseif($izin->jenis_izin === 'Izin')
                                                <span class="badge bg-primary-subtle text-primary">{{ $izin->jenis_izin }}</span>
                                            @else
                                                <span class="badge bg-info-subtle text-info">{{ $izin->jenis_izin }}</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                                        <td>{{ $izin->alasan }}</td>
                                        <td>
                                            @php
                                                $warnaStatus = [
                                                    'Menunggu' => 'warning',
                                                    'Disetujui' => 'success',
                                                    'Ditolak' => 'danger',
                                                ][$izin->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $warnaStatus }}">{{ $izin->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Belum ada pengajuan izin.
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
