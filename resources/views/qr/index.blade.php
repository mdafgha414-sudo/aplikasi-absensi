@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0"><i class="bi bi-qr-code"></i> Cetak Kartu QR Siswa</h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Kode Kartu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $siswa->name }}</td>
                            <td>{{ $siswa->email }}</td>
                            <td><span class="badge bg-primary px-3 py-2">{{ $siswa->kode_kartu }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('qr.show', $siswa->id) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-printer"></i> Buat Kode QR
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data siswa yang memiliki kode kartu. <br>
                                Silakan tambah user dengan role "user" di menu Admin.
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