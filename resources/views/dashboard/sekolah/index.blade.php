@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Manajemen Sekolah</h3>
            <p class="text-muted mb-0">Kelola daftar sekolah asal siswa PKL.</p>
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

    <div class="row">
        <!-- Form Tambah Sekolah -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Tambah Sekolah Baru</h5>
                </div>
                <div class="card-body p-4">
                    
                    @php
                        // Tentukan route action berdasarkan role
                        $storeRoute = Auth::user()->role === 'pembimbing' ? route('pembimbing.sekolah.store') : route('admin.sekolah.store');
                    @endphp

                    <form action="{{ $storeRoute }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Sekolah / Instansi</label>
                            <input type="text" name="nama_sekolah" class="form-control form-control-lg bg-light" placeholder="Cth: SMK Negeri 1 Jakarta" required>
                            @error('nama_sekolah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="bi bi-save me-2"></i> Simpan Sekolah
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Sekolah -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="70" class="ps-4">No</th>
                                    <th>Nama Sekolah</th>
                                    
                                    {{-- Kolom Dibuat Oleh HANYA untuk Admin --}}
                                    @if(Auth::user()->role === 'admin')
                                        <th>Dibuat Oleh</th>
                                    @endif
                                    
                                    <th class="text-center" width="250">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sekolahs as $index => $s)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        @php
                                            // Tentukan route update berdasarkan role
                                            $updateRoute = Auth::user()->role === 'pembimbing' ? route('pembimbing.sekolah.update', $s->id) : route('admin.sekolah.update', $s->id);
                                        @endphp

                                        <!-- Form Edit Inline -->
                                        <form action="{{ $updateRoute }}" method="POST" class="d-flex align-items-center">
                                            @csrf @method('PUT')
                                            <input type="text" name="nama_sekolah" class="form-control form-control-sm bg-transparent border-0 fw-bold text-dark px-0" value="{{ $s->nama_sekolah }}" required style="box-shadow: none;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2" title="Update Nama">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Tampilkan pembuat HANYA untuk Admin --}}
                                    @if(Auth::user()->role === 'admin')
                                        <td>
                                            <span class="badge bg-secondary">{{ $s->user->name ?? 'Admin / Sistem' }}</span>
                                        </td>
                                    @endif

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            @php
                                                $assignRoute = Auth::user()->role === 'pembimbing' ? route('pembimbing.sekolah.assign', $s->id) : route('admin.sekolah.assign', $s->id);
                                                $destroyRoute = Auth::user()->role === 'pembimbing' ? route('pembimbing.sekolah.destroy', $s->id) : route('admin.sekolah.destroy', $s->id);
                                            @endphp

                                            <a href="{{ $assignRoute }}" class="btn btn-sm btn-info text-white" title="Atur Siswa">
                                                <i class="bi bi-people-fill"></i> Atur
                                            </a>

                                            <form action="{{ $destroyRoute }}" method="POST" onsubmit="return confirm('Hapus sekolah ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? 4 : 3 }}" class="text-center text-muted py-5">
                                        <i class="bi bi-building fs-1 d-block mb-3 text-secondary"></i>
                                        Belum ada data sekolah. <br> Silakan tambahkan di form sebelah kiri.
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