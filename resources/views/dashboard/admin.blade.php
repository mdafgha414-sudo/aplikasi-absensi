@extends('layouts.app')

@section('content')
    
    <!-- Kartu Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center p-3 border-0 shadow-sm rounded-4">
                <h6 class="text-uppercase text-white-50 mb-1">Total Karyawan</h6>
                <h2 class="fw-bold mb-0">{{ $totalUser }} Orang</h2>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- NAVIGASI TAB                               -->
    <!-- ========================================== -->
    <ul class="nav nav-tabs mb-4 border-bottom-0" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-dark" id="karyawan-tab" data-bs-toggle="tab" data-bs-target="#karyawan" type="button" role="tab">
                <i class="bi bi-people-fill me-1 text-primary"></i> Manajemen Karyawan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-muted" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi" type="button" role="tab">
                <i class="bi bi-clipboard-data-fill me-1"></i> Laporan Absensi
            </button>
        </li>
    </ul>

    <!-- ========================================== -->
    <!-- ISI KONTEN TAB                             -->
    <!-- ========================================== -->
    <div class="tab-content" id="adminTabContent">
        
        <!-- ================= TAB 1: DAFTAR KARYAWAN ================= -->
        <div class="tab-pane fade show active" id="karyawan" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Daftar Karyawan</h5>
                    <a href="/admin/tambah-user" class="btn btn-success btn-sm rounded-pill px-3">
                        <i class="bi bi-person-plus me-1"></i> Tambah Karyawan
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semuaKaryawan as $index => $karyawan)
                                    <tr>
                                        <td>{{ $semuaKaryawan->firstItem() + $index }}</td>
                                        <td class="fw-medium">{{ $karyawan->name }}</td>
                                        <td>{{ $karyawan->email }}</td>
                                        <td class="text-center">
                                            <a href="/admin/edit-user/{{ $karyawan->id }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            
                                            <form action="/admin/hapus-user/{{ $karyawan->id }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada data karyawan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- TOMBOL PAGINATION KARYAWAN -->
                    <div class="mt-3">
                        {{ $semuaKaryawan->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 2: DATA ABSENSI ================= -->
        <div class="tab-pane fade" id="absensi" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="mb-0 fw-bold">Data Absensi Seluruh Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semuaAbsensi as $index => $absen)
                                    <tr>
                                        <td>{{ $semuaAbsensi->firstItem() + $index }}</td>
                                        <td class="fw-bold">{{ $absen->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}</td>
                                        <td><span class="badge bg-success bg-opacity-10 text-success">{{ $absen->jam_masuk }}</span></td>
                                        <td>
                                            @if($absen->jam_pulang)
                                                <span class="badge bg-warning bg-opacity-10 text-dark">{{ $absen->jam_pulang }}</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Belum Pulang</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($absen->status == 'Telat')
                                                <span class="badge bg-danger bg-opacity-10 text-danger">Telat</span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success">Tepat Waktu</span>
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

                    <!-- TOMBOL PAGINATION ABSENSI -->
                    <div class="mt-3">
                        {{ $semuaAbsensi->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection