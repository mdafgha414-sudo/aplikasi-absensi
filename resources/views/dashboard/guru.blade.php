@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white text-center p-3 border-0 shadow-sm rounded-4">
                <h6 class="text-uppercase text-white-50 mb-1">Total Siswa PKL</h6>
                <h2 class="fw-bold mb-0">{{ $totalSiswa }} Orang</h2>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 fw-bold">Laporan Jurnal Siswa</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Siswa</th>
                            <th>Kegiatan</th>
                            <th>Kendala</th>
                            <th>Nilai & Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($semuaJurnal as $jurnal)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                                <td class="fw-bold">{{ $jurnal->user->name }}</td>
                                <td>{{ $jurnal->kegiatan }}</td>
                                <td>{{ $jurnal->kendala ?? '-' }}</td>
                                <td>
                                    @if($jurnal->nilai)
                                        <span class="badge bg-success">Nilai: {{ $jurnal->nilai }}</span>
                                        <br><small class="text-muted">{{ $jurnal->catatan_guru }}</small>
                                    @else
                                        <span class="badge bg-secondary">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol untuk membuka modal penilaian -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $jurnal->id }}">
                                        Beri Nilai
                                    </button>

                                    <!-- Modal (Pop-up) Penilaian -->
                                    <div class="modal fade" id="modalNilai{{ $jurnal->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Penilaian Jurnal: {{ $jurnal->user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="/guru/nilai/{{ $jurnal->id }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nilai (0-100)</label>
                                                            <input type="number" name="nilai" class="form-control" value="{{ $jurnal->nilai }}" required min="0" max="100">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan Guru</label>
                                                            <textarea name="catatan_guru" class="form-control" rows="3">{{ $jurnal->catatan_guru }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada jurnal dari siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection