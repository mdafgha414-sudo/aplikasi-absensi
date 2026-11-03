@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Manajemen Sekolah</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Tambah Sekolah -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Tambah Sekolah</h5>
                    <form action="{{ route('admin.sekolah.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="nama_sekolah" class="form-control" placeholder="Nama Sekolah (Cth: SMK Negeri 1)" required>
                            @error('nama_sekolah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Sekolah -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Sekolah</th>
                                    <th class="text-center" width="250">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sekolahs as $index => $s)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <!-- Form Edit Inline -->
                                        <form action="{{ route('admin.sekolah.update', $s->id) }}" method="POST" class="d-flex">
                                            @csrf @method('PUT')
                                            <input type="text" name="nama_sekolah" class="form-control form-control-sm me-2" value="{{ $s->nama_sekolah }}" required>
                                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- TAMBAHAN: TOMBOL ATUR SISWA -->
                                            <a href="{{ route('admin.sekolah.assign', $s->id) }}" class="btn btn-sm btn-info text-white" title="Atur Siswa di Sekolah Ini">
                                                <i class="bi bi-people-fill"></i> Atur Siswa
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.sekolah.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus sekolah ini? Siswa yang terdaftar di sekolah ini akan menjadi tanpa sekolah.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data sekolah.</td></tr>
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