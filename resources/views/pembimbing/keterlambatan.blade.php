@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Persetujuan Keterlambatan Siswa</h4>
            <p class="text-muted small mb-0">Kelola laporan keterlambatan, lihat alasan, dan berikan verifikasi.</p>
        </div>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Konten Utama --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">Daftar Laporan Masuk</h5>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                {{ $dataKeterlambatan->where('is_approved', false)->count() }} Menunggu Verifikasi
            </span>
        </div>

        <hr class="text-muted opacity-25">

        {{-- Daftar List Keterlambatan Siswa (Gaya Card ala Timetrix) --}}
        <div class="d-flex flex-column gap-3 mt-3">
            @forelse($dataKeterlambatan ?? [] as $item)
            <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center flex-wrap gap-3">
                
                {{-- Info Siswa & Alasan --}}
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 18px;">
                        {{ strtoupper(substr($item->user->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="fw-bold mb-0 text-dark">{{ $item->user->name ?? 'Siswa' }}</h6>
                            <span class="badge bg-danger text-white" style="font-size: 10px;">Terlambat</span>
                        </div>
                        <p class="text-muted small mb-1 mt-1">
                            <i class="bi bi-calendar-event me-1"></i> Tanggal: {{ $item->tanggal ?? $item->created_at->toDateString() }} 
                            <span class="ms-2"><i class="bi bi-clock me-1"></i> Diajukan: {{ $item->created_at }}</span>
                        </p>
                        <p class="mb-0 text-dark fst-italic bg-white p-2 rounded border border-light" style="font-size: 13px;">
                            "{{ $item->alasan ?? '-' }}"
                        </p>
                    </div>
                </div>

                {{-- Status & Tombol Aksi (Setujui) --}}
                <div class="d-flex align-items-center gap-2">
                    @if($item->is_approved)
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i> Disetujui
                        </span>
                    @else
                        <form action="{{ route('pembimbing.keterlambatan.verify', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm px-3 rounded-pill fw-semibold">
                                <i class="bi bi-check-lg me-1"></i> Verifikasi
                            </button>
                        </form>
                    @endif
                </div>

            </div>
            @empty
            <div class="text-center py-5">
                <div class="text-muted mb-2" style="font-size: 40px;"><i class="bi bi-inbox"></i></div>
                <h6 class="text-muted fw-bold">Belum ada data keterlambatan siswa.</h6>
                <p class="text-muted small">Laporan dari siswa yang terlambat akan muncul di sini secara otomatis.</p>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection