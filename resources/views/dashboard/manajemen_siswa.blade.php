@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Siswa & Guru</h3>
            <p class="text-muted mb-0">
                Kelola anggota untuk: 
                <span class="badge bg-primary px-2 py-1" style="font-size: 0.9rem;">
                    <i class="bi bi-building me-1"></i> {{ Auth::user()->perusahaan->nama_perusahaan ?? 'Perusahaan Anda' }}
                </span>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pembimbing.sekolah.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-building"></i> Data Sekolah
            </a>
            <a href="{{ route('pembimbing.siswa.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- KARTU RINGKASAN (SIMPLE) --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd);">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-dark fw-bold text-uppercase small" style="opacity: 0.7;">Total Anggota</div>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalUser }} <span class="fs-6 fw-normal">Orang</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DATA ANGGOTA --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="70">No.</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Sekolah</th>
                            <th>Role</th>
                            <th class="text-center" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaPengguna as $index => $pengguna)
                            <tr>
                                <td class="ps-4 text-muted fw-bold">{{ $semuaPengguna->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold;">
                                            {{ strtoupper(substr($pengguna->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $pengguna->name }}</div>
                                            <div class="text-muted small">ID #{{ $pengguna->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $pengguna->email }}</td>
                                <td>
                                    <span class="text-muted">{{ $pengguna->sekolah->nama_sekolah ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($pengguna->role == 'pembimbing')
                                        <span class="badge bg-warning text-dark">Pembimbing</span>
                                    @elseif($pengguna->role == 'guru')
                                        <span class="badge bg-info text-dark">Guru</span>
                                    @else
                                        <span class="badge bg-secondary">Siswa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('pembimbing.siswa.edit', $pengguna->id) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    @if(strtolower($pengguna->role) !== 'admin')
                                        <form action="{{ route('pembimbing.siswa.destroy', $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-person-x fs-1 d-block mb-3 text-secondary"></i>
                                    Belum ada anggota di perusahaan ini. <br> Klik tombol <strong>Tambah Pengguna</strong> di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINATION --}}
            <div class="p-3 border-top">
                {{ $semuaPengguna->links() }}
            </div>
        </div>
    </div>
</div>
@endsection