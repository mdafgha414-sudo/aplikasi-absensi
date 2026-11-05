@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Manajemen Siswa & Pengguna</h3>
            <p class="text-muted mb-0">Kelola seluruh data pengguna, filter berdasarkan sekolah atau perusahaan.</p>
        </div>
        <a href="{{ url('/admin/tambah-user') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- BAGIAN FILTER --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3 align-items-end">
                
                <!-- Filter Pencarian -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">Cari Nama</label>
                    <input type="text" name="search" class="form-control" placeholder="Ketik nama..." value="{{ request('search') }}">
                </div>

                <!-- Filter Role -->
                <div class="col-md-2">
                    <label class="form-label fw-bold small text-muted">Role</label>
                    <select name="role" class="form-select">
                        <option value="Semua">Semua Role</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="pembimbing" {{ request('pembimbing') == 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                    </select>
                </div>

                <!-- Filter Sekolah -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">Sekolah</label>
                    <select name="sekolah" class="form-select">
                        <option value="Semua">Semua Sekolah</option>
                        @foreach($daftarSekolah as $sklh)
                            <option value="{{ $sklh->id }}" {{ request('sekolah') == $sklh->id ? 'selected' : '' }}>{{ $sklh->nama_sekolah }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Perusahaan -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">Perusahaan (PKL)</label>
                    <select name="perusahaan" class="form-select">
                        <option value="Semua">Semua Perusahaan</option>
                        @foreach($daftarPerusahaan as $prs)
                            <option value="{{ $prs->id }}" {{ request('perusahaan') == $prs->id ? 'selected' : '' }}>{{ $prs->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Aksi Filter -->
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
                <div class="col-md-1 d-grid">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No.</th>
                            <th>Nama Pengguna</th>
                            <th>Role</th>
                            <th>Sekolah</th>
                            <th>Perusahaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaPengguna as $index => $pengguna)
                            <tr>
                                <td class="ps-4">{{ $semuaPengguna->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold">{{ $pengguna->name }}</div>
                                    <div class="text-muted small">{{ $pengguna->email }}</div>
                                </td>
                                <td>
                                    @if($pengguna->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($pengguna->role == 'pembimbing')
                                        <span class="badge bg-warning text-dark">Pembimbing</span>
                                    @elseif($pengguna->role == 'guru')
                                        <span class="badge bg-info text-dark">Guru</span>
                                    @else
                                        <span class="badge bg-secondary">Siswa</span>
                                    @endif
                                </td>
                                <td>{{ $pengguna->sekolah->nama_sekolah ?? '-' }}</td>
                                <td>{{ $pengguna->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/admin/edit-user/' . $pengguna->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    @if(strtolower($pengguna->role) !== 'admin')
                                    <form action="{{ url('/admin/hapus-user/' . $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data yang sesuai filter.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $semuaPengguna->links() }}
            </div>
        </div>
    </div>
</div>
@endsection