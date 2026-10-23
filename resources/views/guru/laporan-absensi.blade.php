@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1"><i class="bi bi-calendar-event text-primary me-2"></i>Laporan Absensi</h5>
                <p class="text-muted small mb-0">Pantau waktu masuk, waktu pulang, dan status kehadiran pengguna.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-secondary small fw-bold">
                        <th>NO.</th>
                        <th>NAMA PENGGUNA</th>
                        <th>TANGGAL</th>
                        <th>JAM MASUK</th>
                        <th>JAM PULANG</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanAbsensi as $index => $absensi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold">{{ $absensi->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                {{ $absensi->jam_masuk ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($absensi->jam_pulang)
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                    {{ $absensi->jam_pulang }}
                                </span>
                            @else
                                <span class="badge bg-light text-secondary border px-2 py-1">Belum Pulang</span>
                            @endif
                        </td>
                        <td>
                            @if($absensi->status == 'Telat')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Telat</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Tepat Waktu</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data absensi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection