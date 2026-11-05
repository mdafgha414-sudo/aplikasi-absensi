@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Manajemen Perusahaan (Tempat PKL)</h3>
            <p class="text-muted mb-0">Daftarkan lokasi PKL baru beserta koordinat radiusnya.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Tambah Perusahaan -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Perusahaan</h5>
                    
                    <div class="alert alert-info border-0" style="font-size: 12px;">
                        <i class="bi bi-lightbulb-fill me-1"></i> Buka <a href="https://maps.google.com" target="_blank" class="alert-link">Google Maps</a>, cari lokasi, klik kanan, lalu copy angka koordinatnya.
                    </div>

                    <form action="{{ route('admin.perusahaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="form-control" placeholder="PT. Maju Jaya" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" class="form-control" placeholder="-6.2..." required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" class="form-control" placeholder="106.8..." required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Radius (Meter)</label>
                            <input type="number" name="radius" class="form-control" value="100" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Perusahaan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Perusahaan -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i>Daftar Perusahaan & Anggotanya</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Perusahaan</th>
                                    <th class="text-center">Radius</th>
                                    <th class="text-center">Total Anggota</th>
                                    <th class="text-center" width="220">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perusahaans as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $p->nama_perusahaan }}</div>
                                        <small class="text-muted">{{ $p->alamat ?? '-' }}</small>
                                    </td>
                                    <td class="text-center"><span class="badge bg-info text-dark">{{ $p->radius }} m</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $p->users->count() }} Orang</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAnggota{{ $p->id }}" title="Lihat Anggota">
                                                <i class="bi bi-people"></i>
                                            </button>
                                            
                                            <!-- TOMBOL EDIT -->
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}" title="Edit Perusahaan">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <form action="{{ route('admin.perusahaan.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus perusahaan ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL ANGGOTA PERUSAHAAN -->
                                <div class="modal fade" id="modalAnggota{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title"><i class="bi bi-building me-2"></i>Anggota: {{ $p->nama_perusahaan }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if($p->users->count() > 0)
                                                    <table class="table table-sm table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <th>Email</th>
                                                                <th>Role</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($p->users as $u)
                                                            <tr>
                                                                <td class="fw-bold">{{ $u->name }}</td>
                                                                <td>{{ $u->email }}</td>
                                                                <td>
                                                                    @if($u->role == 'pembimbing')
                                                                        <span class="badge bg-warning text-dark">Pembimbing</span>
                                                                    @elseif($u->role == 'guru')
                                                                        <span class="badge bg-info text-dark">Guru</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Siswa</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="text-center text-muted py-4">
                                                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                                        Belum ada anggota yang terdaftar di perusahaan ini.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MODAL EDIT PERUSAHAAN -->
                                <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title text-dark"><i class="bi bi-pencil-square me-2"></i>Edit: {{ $p->nama_perusahaan }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.perusahaan.update', $p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nama Perusahaan</label>
                                                        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $p->nama_perusahaan }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Alamat</label>
                                                        <textarea name="alamat" class="form-control" rows="2">{{ $p->alamat }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <label class="form-label">Latitude</label>
                                                            <input type="text" name="latitude" class="form-control" value="{{ $p->latitude }}" required>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label class="form-label">Longitude</label>
                                                            <input type="text" name="longitude" class="form-control" value="{{ $p->longitude }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Radius (Meter)</label>
                                                        <input type="number" name="radius" class="form-control" value="{{ $p->radius }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Belum ada data perusahaan. Silakan tambahkan di form sebelah kiri.
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