@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-sm btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Perusahaan
            </a>
            <h3 class="fw-bold mb-1">{{ $perusahaan->nama_perusahaan }}</h3>
            <p class="text-muted mb-0">Total Anggota: {{ $totalUser }} Orang</p>
        </div>
        <div>
            <a href="{{ url('/admin/tambah-user') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Anggota
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom py-3">
            <ul class="nav nav-tabs card-header-tabs" id="detailTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="pengguna-tab" data-bs-toggle="tab" data-bs-target="#pengguna" type="button" role="tab">
                        <i class="bi bi-people-fill me-2"></i> Daftar Pengguna
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi" type="button" role="tab">
                        <i class="bi bi-calendar2-check-fill me-2"></i> Laporan Absensi
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content" id="detailTabContent">
                
                {{-- TAB PENGGUNA --}}
                <div class="tab-pane fade show active" id="pengguna" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="70" class="ps-4">No.</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center" style="min-width:190px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semuaPengguna as $index => $pengguna)
                                    <tr>
                                        <td class="ps-4">{{ $semuaPengguna->firstItem() + $index }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $pengguna->name }}</div>
                                            <div class="text-muted small">ID #{{ $pengguna->id }}</div>
                                        </td>
                                        <td>{{ $pengguna->email }}</td>
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
                                            <a href="{{ url('/admin/edit-user/' . $pengguna->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            @if (strtolower($pengguna->role) !== 'admin')
                                                <form action="{{ url('/admin/hapus-user/' . $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash3"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada anggota di perusahaan ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $semuaPengguna->links() }}
                    </div>
                </div>

                {{-- TAB ABSENSI --}}
                <div class="tab-pane fade" id="absensi" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">No.</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($semuaAbsensi as $absen)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $absen->user->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d M Y') }}</td>
                                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                                        <td>{{ $absen->jam_pulang ?? '-' }}</td>
                                        <td>
                                            @if($absen->status == 'Telat')
                                                <span class="badge bg-danger">Telat</span>
                                            @elseif($absen->status == 'Izin')
                                                <span class="badge bg-info text-dark">Izin</span>
                                            @else
                                                <span class="badge bg-success">Tepat Waktu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data absensi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        {{ $semuaAbsensi->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection