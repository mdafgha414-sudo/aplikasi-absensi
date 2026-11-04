@extends('layouts.app')

@section('content')
<style>
    :root {
        --admin-primary: #7da7d9;
        --admin-bg: #f7faff;
        --admin-text: #40516a;
        --admin-border: #e8eef6;
    }

    .admin-dashboard {
        color: var(--admin-text);
        padding: 10px 0 30px;
    }

    .page-title { font-size: 1.65rem; font-weight: 700; color: #40516a; }
    .page-subtitle { color: #91a0b5; font-size: .9rem; }

    .stat-card {
        border: 1px solid #eaf0f8;
        border-radius: 20px;
        background: #fff;
        padding: 24px;
        box-shadow: 0 3px 15px rgba(82, 125, 180, .035);
        margin-bottom: 24px;
    }
    .stat-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 46px; height: 46px; border-radius: 15px;
        background: #edf4fd; color: #739ed1; font-size: 1.25rem;
    }
    .stat-label { color: #91a0b5; font-size: .84rem; margin-top: 18px; margin-bottom: 5px; }
    .stat-value { font-size: 1.9rem; font-weight: 700; color: #40516a; margin: 0; }

    .admin-panel {
        background: #fff;
        border: 1px solid #eaf0f7;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(82, 125, 180, .025);
        overflow: hidden;
    }
    .admin-panel-header {
        padding: 24px 26px;
        border-bottom: 1px solid #eff3f9;
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;
    }
    .admin-panel-title { font-size: 1.02rem; font-weight: 700; margin: 0; color: #50617a; }
    .admin-panel-description { color: #9aa9bd; font-size: .82rem; margin: 6px 0 0; }
    .admin-panel-body { padding: 24px 26px; }

    .btn-add-employee {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 16px; border-radius: 11px;
        background: #e8f1fc; border: 1px solid #e8f1fc;
        color: #5f8fc9; font-size: .85rem; font-weight: 600;
        text-decoration: none; transition: .2s;
    }
    .btn-add-employee:hover { background: #dceafb; color: #4d7eb9; }

    .btn-action {
        display: inline-flex; align-items: center; gap: 5px;
        border-radius: 9px; padding: 7px 11px;
        font-size: .79rem; font-weight: 500;
    }
    .btn-outline-warning { color: #648fc3 !important; border-color: #dce9f8 !important; background: #f4f8fe !important; }
    .btn-outline-warning:hover { background: #e7f0fc !important; }
    .btn-outline-danger { color: #c18491 !important; border-color: #f1e1e6 !important; background: #fff8f9 !important; }
    .btn-outline-danger:hover { background: #f9eaee !important; }

    .admin-table { margin: 0; vertical-align: middle; min-width: 650px; }
    .admin-table thead th { background: #f8faff; color: #91a1b7; font-size: .7rem; padding: 15px 18px; border-bottom: 1px solid #eaf0f7; text-transform: uppercase; }
    .admin-table tbody td { padding: 16px 18px; border-bottom: 1px solid #f1f5fa; color: #718198; font-size: .85rem; }
    .admin-table tbody tr:hover { background: #fafdff; }

    .employee-avatar {
        display: inline-flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: 13px;
        background: #edf4fd; color: #729bd0; font-weight: 600; font-size: .88rem;
    }
    .employee-name { font-weight: 600; color: #52627a; margin-bottom: 2px; }
    .employee-email { font-size: .77rem; color: #a0aec0; }

    .admin-pagination { padding-top: 22px; border-top: 1px solid #f0f4f9; margin-top: 10px; }
    .admin-pagination nav { display: flex; justify-content: flex-end; }
</style>

<div class="admin-dashboard">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="page-title mb-1">Manajemen Siswa</h2>
            <p class="page-subtitle mb-0">Kelola data siswa bimbingan PKL Anda.</p>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                </div>
                <p class="stat-label">Total Pengguna</p>
                <h3 class="stat-value">{{ $totalUser }} <span class="fs-6 fw-semibold text-muted">Orang</span></h3>
            </div>
        </div>
    </div>

    {{-- TABEL DAFTAR SISWA --}}
    <div class="admin-panel">
        <div class="admin-panel-header">
            <div>
                <h5 class="admin-panel-title"><i class="bi bi-person-lines-fill text-primary me-2"></i> Daftar Pengguna</h5>
                <p class="admin-panel-description">Informasi dan pengelolaan data Siswa & Guru.</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('pembimbing.siswa.create') }}" class="btn-add-employee">
                    <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                </a>
                <a href="{{ route('pembimbing.sekolah.index') }}" class="btn-add-employee" style="background: #e0f2fe; border-color: #e0f2fe; color: #0369a1;">
                    <i class="bi bi-building"></i> Manajemen Sekolah
                </a>
            </div>
        </div>

        <div class="admin-panel-body">
            @if(session('success'))
                <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 mb-4">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th width="70">No.</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Sekolah</th>
                            <th>Role</th>
                            <th class="text-center" style="min-width:190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($semuaPengguna as $index => $pengguna)
                            <tr>
                                <td>{{ $semuaPengguna->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="employee-avatar">{{ strtoupper(substr($pengguna->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="employee-name">{{ $pengguna->name }}</div>
                                            <div class="employee-email">ID Pengguna #{{ $pengguna->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $pengguna->email }}</td>
                                <td>{{ $pengguna->sekolah->nama_sekolah ?? '-' }}</td>
                                <td>
                                    @if($pengguna->role == 'admin')
                                        <span class="badge rounded-pill" style="background-color: #f3e8ff; color: #7e22ce;">Admin</span>
                                    @elseif($pengguna->role == 'pembimbing')
                                        <span class="badge rounded-pill" style="background-color: #fef3c7; color: #b45309;">Pembimbing</span>
                                    @elseif($pengguna->role == 'guru')
                                        <span class="badge rounded-pill" style="background-color: #e0f2fe; color: #0369a1;">Guru</span>
                                    @else
                                        <span class="badge rounded-pill" style="background-color: #f1f5f9; color: #475569;">Siswa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('pembimbing.siswa.edit', $pengguna->id) }}" class="btn btn-outline-warning btn-action">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @if (strtolower($pengguna->role) !== 'admin')
                                            <form action="{{ route('pembimbing.siswa.destroy', $pengguna->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-action">
                                                    <i class="bi bi-trash3"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($semuaPengguna->hasPages())
                <div class="admin-pagination">
                    {{ $semuaPengguna->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection