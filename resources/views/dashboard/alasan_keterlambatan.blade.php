@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Alasan Keterlambatan</h4>
            <p class="text-secondary small mb-0">Periksa dan berikan keputusan atas alasan keterlambatan siswa.</p>
        </div>
        <a href="{{ Auth::user()->role === 'guru' ? route('guru.dashboard') : route('pembimbing.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <!-- Tabel -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary" style="font-size: 13px;">
                        <tr>
                            <th class="fw-bold py-3">No.</th>
                            <th class="fw-bold py-3">Nama Siswa</th>
                            <th class="fw-bold py-3">Tanggal</th>
                            <th class="fw-bold py-3">Alasan</th>
                            <th class="fw-bold py-3">Status</th>
                            <th class="fw-bold py-3">Catatan</th>
                            {{-- KOLOM AKSI HANYA MUNCUL UNTUK PEMBIMBING --}}
                            @if(Auth::user()->role === 'pembimbing')
                                <th class="fw-bold py-3 text-end">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarAlasan as $index => $alasan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold text-dark">{{ $alasan->user->name ?? 'Siswa' }}</td>
                                <td>{{ \Carbon\Carbon::parse($alasan->tanggal)->format('d M Y') }}</td>
                                <td class="text-secondary" style="max-width: 250px; white-space: normal;">
                                    {{ $alasan->alasan ?? '-' }}
                                </td>
                                <td>
                                    @if($alasan->status == 'Diterima')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">Diterima</span>
                                    @elseif($alasan->status == 'Ditolak')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-secondary">{{ $alasan->catatan_pembimbing ?? '-' }}</td>
                                
                                {{-- ISI KOLOM AKSI HANYA UNTUK PEMBIMBING --}}
                                @if(Auth::user()->role === 'pembimbing')
                                    <td class="text-end">
                                        @if($alasan->status == 'Menunggu')
                                            <div class="d-flex gap-1 justify-content-end">
                                                <form action="{{ route('pembimbing.alasan.terima', $alasan->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success rounded-2">
                                                        <i class="bi bi-check-lg"></i> Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('pembimbing.alasan.tolak', $alasan->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-danger rounded-2">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">Selesai</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'pembimbing' ? 7 : 6 }}" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                    <h5 class="fw-bold text-dark">Belum ada alasan keterlambatan dari siswa.</h5>
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