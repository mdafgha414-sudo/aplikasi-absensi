@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-envelope-paper text-warning me-2"></i>
                Daftar Pengajuan Izin Siswa
            </h5>
            <p class="text-muted small mb-0 mt-1">Kelola dan setujui pengajuan izin dari siswa bimbingan Anda.</p>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Izin</th>
                            <th>Tanggal Izin</th>
                            <th>Alasan</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($semuaIzin as $izin)
                            <tr>
                                <td>{{ $izin->created_at->format('d M Y') }}</td>
                                <td class="fw-bold text-dark">{{ $izin->user->name ?? 'Siswa' }}</td>
                                <td>{{ $izin->jenis_izin }}</td>
                                <td>{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</td>
                                <td>{{ $izin->alasan }}</td>
                                <td>
                                    @if($izin->lampiran)
                                        <a href="{{ asset('storage/' . $izin->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-paperclip"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($izin->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">Menunggu</span>
                                    @elseif($izin->status == 'Disetujui')
                                        <span class="badge bg-success rounded-pill px-3">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($izin->status == 'Menunggu')
                                        <div class="d-flex gap-2 justify-content-center">
                                            <form action="/guru/izin/{{ $izin->id }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">Setujui</button>
                                            </form>
                                            <form action="/guru/izin/{{ $izin->id }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Tolak</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted small">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2 text-muted"></i>
                                    Belum ada pengajuan izin dari siswa.
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