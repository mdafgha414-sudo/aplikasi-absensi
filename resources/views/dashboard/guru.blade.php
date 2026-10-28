@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-lg-5">
    
    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Laporan Jurnal Siswa</h3>
            <p class="text-secondary small mb-0">Pantau, periksa, dan berikan penilaian pada jurnal harian siswa PKL.</p>
        </div>
        
        <!-- Card Total Siswa -->
        <div class="card border-0 shadow-sm rounded-4" style="min-width: 250px;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <p class="text-secondary small fw-semibold mb-1 text-uppercase tracking-wider">Total Siswa PKL</p>
                    <h4 class="fw-bold text-dark mb-0">{{ $totalSiswa ?? 0 }} <span class="fs-6 fw-normal text-secondary">Siswa</span></h4>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tabel Jurnal -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            
            <!-- Header Tabel & Tombol Export -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-journal-text text-secondary"></i> Daftar Jurnal Siswa
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('guru.export.excel', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-success btn-sm fw-semibold px-3 rounded-2">
                        <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
                    </a>
                    <a href="{{ route('guru.export.pdf', ['bulan' => date('m'), 'tahun' => date('Y')]) }}" class="btn btn-outline-danger btn-sm fw-semibold px-3 rounded-2">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Ekspor PDF
                    </a>
                </div>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary" style="font-size: 13px;">
                        <tr>
                            <th class="fw-bold py-3">TANGGAL</th>
                            <th class="fw-bold py-3">NAMA SISWA</th>
                            <th class="fw-bold py-3">KEGIATAN</th>
                            <th class="fw-bold py-3">KENDALA</th>
                            <th class="fw-bold py-3 text-center">NILAI</th>
                            <th class="fw-bold py-3 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaJurnal as $jurnal)
                            <tr>
                                <td class="text-secondary">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 13px;">
                                            {{ substr($jurnal->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $jurnal->user->name ?? 'Siswa' }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary" style="max-width: 300px; white-space: normal;">
                                    {{ $jurnal->kegiatan }}
                                </td>
                                <td class="text-secondary" style="max-width: 200px; white-space: normal;">
                                    {{ $jurnal->kendala ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @if($jurnal->nilai)
                                        <span class="badge bg-success text-white fs-6 rounded-pill px-3">{{ $jurnal->nilai }}</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-25 text-dark rounded-pill px-3">Belum</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <!-- Tombol Pemicu Modal -->
                                    <button type="button" class="btn btn-sm btn-primary fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#modalNilai{{ $jurnal->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Beri Nilai
                                    </button>
                                </td>
                            </tr>

                            <!-- MODAL FORM PENILAIAN UNTUK SETIAP JURNAL -->
                            <div class="modal fade" id="modalNilai{{ $jurnal->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark">Penilaian Jurnal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('guru.nilai', $jurnal->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="mb-3 p-3 bg-light rounded-3">
                                                    <span class="text-secondary small d-block mb-1">Siswa:</span>
                                                    <strong class="text-dark">{{ $jurnal->user->name ?? 'Siswa' }}</strong> <span class="text-secondary mx-1">|</span> <span class="text-secondary">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</span>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-secondary small">Nilai (0-100)</label>
                                                    <input type="number" name="nilai" class="form-control form-control-lg fw-bold" min="0" max="100" value="{{ $jurnal->nilai }}" required placeholder="Contoh: 90">
                                                </div>
                                                
                                                <div class="mb-0">
                                                    <label class="form-label fw-semibold text-secondary small">Catatan Guru / Ulasan</label>
                                                    <textarea name="catatan_guru" class="form-control" rows="3" placeholder="Berikan ulasan atau masukan untuk siswa...">{{ $jurnal->catatan_guru }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0">
                                                <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan Nilai</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                    Belum ada jurnal yang diisi oleh siswa.
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