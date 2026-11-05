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

    /* HEADER */
    .page-title { font-size: 1.65rem; font-weight: 700; color: #40516a; letter-spacing: -.5px; }
    .page-subtitle { color: #91a0b5; font-size: .9rem; }

    /* KARTU PERUSAHAAN (VERTIKAL PENUH) */
    .company-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #eef2f9;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
        text-decoration: none;
        display: block;
        margin-bottom: 20px;
    }
    .company-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(82, 125, 180, 0.12);
        border-color: #d8e6f7;
    }
    
    /* Bagian Atas (Warna) */
    .company-header {
        padding: 20px 30px;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        min-height: 80px;
    }
    .company-header h4 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
        position: relative;
        z-index: 2;
        letter-spacing: 0.5px;
    }
    
    /* Bagian Bawah (Anggota) */
    .company-body {
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
    }
    .company-stat-value { 
        font-size: 2.5rem; 
        font-weight: 800; 
        color: #1e293b; 
        line-height: 1; 
    }
    .company-stat-label { 
        color: #64748b; 
        font-size: 0.9rem; 
        font-weight: 600; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        margin-top: 8px; 
    }
    
    /* Variasi Warna */
    .bg-grad-1 { background: #ff4757; } /* Merah */
    .bg-grad-2 { background: #4e54c8; } /* Biru */
    .bg-grad-3 { background: #b224ef; } /* Ungu */
    .bg-grad-4 { background: #11998e; } /* Hijau */
    .bg-grad-5 { background: #f7971e; } /* Oranye */
    
    /* Vektor Unik */
    .vector-shape {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 200px;
        opacity: 0.15;
        z-index: 1;
        pointer-events: none;
    }
</style>

<div class="admin-dashboard">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill text-bg-primary px-3 py-2">
                    <i class="bi bi-grid-1x2-fill me-1"></i> ADMIN PANEL
                </span>
            </div>
            <h2 class="page-title mb-1">Daftar Perusahaan PKL</h2>
            <p class="page-subtitle mb-0">Pilih perusahaan untuk mengelola data anggotanya.</p>
        </div>
        <div class="d-flex align-items-center gap-2 text-muted small">
            <i class="bi bi-shield-check text-primary fs-5"></i>
            <span>Sistem Manajemen Pengguna</span>
        </div>
    </div>

    {{-- MENU CEPAT (TOTAL, TAMBAH) --}}
    <div class="row g-3 mb-5">
        <!-- Total Pengguna -->
        <div class="col-md-5 col-sm-12">
            <div class="card border-0 shadow-sm rounded-4" style="background: #f8fafc;">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Total Seluruh Pengguna</div>
                        <h3 class="fw-bold m-0">{{ $totalUser }} <span class="fs-6 text-muted fw-normal">Orang</span></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tombol Aksi -->
        <div class="col-md-7 col-sm-12 d-flex align-items-center justify-content-md-end gap-2">
            <a href="{{ route('admin.perusahaan.index') }}" class="btn btn-outline-primary px-4 py-2">
                <i class="bi bi-building me-2"></i> Manajemen Perusahaan
            </a>
            <a href="{{ url('/admin/tambah-user') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    {{-- DAFTAR KARTU PERUSAHAAN (VERTIKAL KE BAWAH) --}}
    <div class="row">
        @php
            $daftarPerusahaan = \App\Models\Perusahaan::withCount('users')->get();
            $colors = ['bg-grad-1', 'bg-grad-2', 'bg-grad-3', 'bg-grad-4', 'bg-grad-5'];
        @endphp

        @forelse($daftarPerusahaan as $index => $prs)
            <div class="col-12"> {{-- Full width agar kotak memanjang ke bawah --}}
                <a href="{{ route('admin.perusahaan.detail', $prs->id) }}" class="company-card">
                    
                    {{-- Bagian Header Berwarna --}}
                    <div class="company-header {{ $colors[$index % count($colors)] }}">
                        <h4>{{ $prs->nama_perusahaan }}</h4>
                        
                        {{-- Vektor Unik di Kanan --}}
                        @if($index % 4 == 0)
                            <svg class="vector-shape" viewBox="0 0 200 100" fill="none" preserveAspectRatio="none"><path d="M200 0L0 100H200V0Z" fill="white"/></svg>
                        @elseif($index % 4 == 1)
                            <svg class="vector-shape" viewBox="0 0 200 100" fill="none" preserveAspectRatio="none"><circle cx="200" cy="50" r="100" fill="white"/></svg>
                        @elseif($index % 4 == 2)
                            <svg class="vector-shape" viewBox="0 0 200 100" fill="none" preserveAspectRatio="none"><path d="M0 100L100 0L200 100H0Z" fill="white"/></svg>
                        @else
                            <svg class="vector-shape" viewBox="0 0 200 100" fill="none" preserveAspectRatio="none"><path d="M200 0C100 0 0 100 200 100V0Z" fill="white"/></svg>
                        @endif
                    </div>

                    {{-- Bagian Bawah (Jumlah Anggota) --}}
                    <div class="company-body">
                        <div>
                            <div class="company-stat-value">{{ $prs->users_count }}</div>
                            <div class="company-stat-label">Total Anggota</div>
                        </div>
                        <i class="bi bi-arrow-right-circle fs-1 text-secondary opacity-50"></i>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5 bg-white rounded shadow-sm">
                <i class="bi bi-building fs-1 d-block mb-3 text-secondary"></i>
                Belum ada perusahaan yang didaftarkan. <br> Silakan klik "Manajemen Perusahaan" di atas.
            </div>
        @endforelse
    </div>

</div>
@endsection