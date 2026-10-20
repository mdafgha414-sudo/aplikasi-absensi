@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <!-- Alert Sukses -->
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <!-- FORM INPUT JURNAL -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-0 fw-bold">Jurnal Harian PKL</h5>
                    <p class="text-muted small mb-0">Tanggal: {{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="card-body">
                    @if($jurnalHariIni)
                        <div class="alert alert-info border-0">
                            <i class="bi bi-check-circle-fill me-2"></i> Anda sudah mengisi jurnal hari ini. Terima kasih!
                        </div>
                        <div class="p-3 bg-light rounded-3">
                            <strong>Kegiatan:</strong> <br>
                            <p>{{ $jurnalHariIni->kegiatan }}</p>
                            <strong>Kendala:</strong> <br>
                            <p class="mb-0">{{ $jurnalHariIni->kendala ?? 'Tidak ada kendala.' }}</p>
                        </div>
                    @else
                        <form action="/jurnal" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apa saja kegiatan Anda hari ini?</label>
                                <textarea name="kegiatan" class="form-control" rows="4" placeholder="Contoh: Membuat desain UI untuk halaman login..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apakah ada kendala? (Opsional)</label>
                                <textarea name="kendala" class="form-control" rows="2" placeholder="Contoh: Kesulitan menghubungkan database..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-send me-2"></i> Simpan Jurnal Hari Ini
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- RIWAYAT JURNAL -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-0 fw-bold">Riwayat Jurnal Anda</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Kendala</th>
                                    <th>Nilai & Catatan Guru</th>
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
                                                <br><small class="text-muted">{{ $jurnal->catatan_guru }}</small>
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

        </div>
    </div>
</div>
@endsection