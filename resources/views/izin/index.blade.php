
@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold mb-1">
            <i class="bi bi-calendar-check text-primary me-2"></i>
            Pengajuan Izin & Sakit
        </h3>
        <p class="text-muted mb-0">
            Ajukan izin ketidakhadiran selama kegiatan PKL.
        </p>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- PESAN ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <strong>Pengajuan belum berhasil.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM PENGAJUAN IZIN --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-1">Formulir Pengajuan</h5>
            <p class="text-muted small mb-0">
                Isi data dengan benar sebelum mengirim pengajuan.
            </p>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('izin.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- JENIS IZIN --}}
                    <div class="col-md-6">
                        <label for="jenis_izin" class="form-label fw-semibold">
                            Jenis Izin <span class="text-danger">*</span>
                        </label>

                        <select
                            name="jenis_izin"
                            id="jenis_izin"
                            class="form-select @error('jenis_izin') is-invalid @enderror"
                            required>
                            <option value="">Pilih jenis izin</option>
                            <option value="Izin" @selected(old('jenis_izin') == 'Izin')>
                                Izin
                            </option>
                            <option value="Sakit" @selected(old('jenis_izin') == 'Sakit')>
                                Sakit
                            </option>
                            <option value="Keperluan Keluarga"
                                @selected(old('jenis_izin') == 'Keperluan Keluarga')>
                                Keperluan Keluarga
                            </option>
                        </select>

                        @error('jenis_izin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TANGGAL IZIN --}}
                    <div class="col-md-6">
                        <label for="tanggal_izin" class="form-label fw-semibold">
                            Tanggal Izin <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_izin"
                            id="tanggal_izin"
                            class="form-control @error('tanggal_izin') is-invalid @enderror"
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('tanggal_izin') }}"
                            required>

                        @error('tanggal_izin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ALASAN --}}
                    <div class="col-12">
                        <label for="alasan" class="form-label fw-semibold">
                            Alasan Izin <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="alasan"
                            id="alasan"
                            rows="4"
                            maxlength="500"
                            class="form-control @error('alasan') is-invalid @enderror"
                            placeholder="Jelaskan alasan pengajuan izin kamu..."
                            required>{{ old('alasan') }}</textarea>

                        <div class="form-text">Maksimal 500 karakter.</div>

                        @error('alasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- LAMPIRAN --}}
                    <div class="col-12">
                        <label for="lampiran" class="form-label fw-semibold">
                            Lampiran <span class="text-muted fw-normal">(Opsional)</span>
                        </label>

                        <input
                            type="file"
                            name="lampiran"
                            id="lampiran"
                            class="form-control @error('lampiran') is-invalid @enderror"
                            accept=".pdf,.jpg,.jpeg,.png">

                        <div class="form-text">
                            Format PDF, JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </div>

                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TOMBOL KIRIM --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-send me-2"></i>
                            Ajukan Izin
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RIWAYAT PENGAJUAN IZIN --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-1">
                <i class="bi bi-clock-history text-primary me-2"></i>
                Riwayat Pengajuan Izin
            </h5>
            <p class="text-muted small mb-0">
                Daftar pengajuan izin yang pernah kamu kirim.
            </p>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Jenis Izin</th>
                            <th>Tanggal Izin</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Catatan Guru</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($riwayatIzin as $index => $izin)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $izin->created_at?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>{{ $izin->jenis_izin }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d/m/Y') }}
                                </td>

                                <td>{{ $izin->alasan }}</td>

                                <td>
                                    @if($izin->status === 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($izin->status === 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            {{ $izin->status ?? 'Menunggu' }}
                                        </span>
                                    @endif
                                </td>

                                <td>{{ $izin->catatan_guru ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
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
@endsection
