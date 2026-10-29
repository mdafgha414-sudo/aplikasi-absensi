@extends('layouts.app')

@section('content')
<style>
    /* 
       DESAIN PENGATURAN - PROPORSIONAL & SEIMBANG
       Warna disesuaikan dengan tema: Biru Keputihan
    */
    .pengaturan-page {
        margin: -40px; /* Menarik paksa ke atas */
        padding: 30px 40px;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    .settings-container {
        max-width: 100%;
        margin: 0 auto;
    }

    /* Tombol Kembali - Perbaikan Underline */
    .btn-back {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        margin-bottom: 15px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none; /* <--- INI MENGHILANGKAN UNDERLINE */
    }
    .btn-back:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    /* CARD UTAMA */
    .settings-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        min-height: 600px;
        width: 100%;
    }

    /* --- SIDEBAR KIRI (BIRU KEPUTIHAN) --- */
    .settings-sidebar {
        width: 300px;
        background: #e0f2fe; /* <--- WARNA BIRU KEPUTIHAN SESUAI TEMA */
        border-right: 1px solid #bae6fd;
        padding: 30px 20px;
        flex-shrink: 0;
    }

    .user-profile-mini {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 20px;
        border-bottom: 1px solid #bae6fd;
        margin-bottom: 20px;
    }

    .user-profile-mini .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #ffffff; /* Avatar putih di atas biru */
        color: #0284c7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        overflow: hidden;
    }

    .user-profile-mini .name {
        font-weight: 700;
        color: #0f172a; /* Teks gelap agar kontras */
        font-size: 15px;
    }
    
    .user-profile-mini .role {
        font-size: 12px;
        color: #334155;
    }

    .settings-nav {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .settings-nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        color: #334155;
        text-decoration: none; /* Hilangkan underline menu */
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .settings-nav a i {
        font-size: 18px;
        color: #64748b;
    }

    .settings-nav a:hover {
        background: #bae6fd; /* Hover biru lebih gelap */
    }

    .settings-nav a.active {
        background: #ffffff; /* Menu aktif jadi putih */
        color: #0284c7;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.1);
    }

    .settings-nav a.active i {
        color: #0284c7;
    }

    /* --- KONTEN KANAN --- */
    .settings-content {
        flex-grow: 1;
        padding: 40px;
        background: #ffffff;
    }

    .content-header {
        margin-bottom: 30px;
    }

    .content-header h3 {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 5px;
        font-size: 22px;
    }

    .content-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    /* Style Input Form */
    .form-group {
        margin-bottom: 25px;
    }
    .form-label {
        font-size: 14px;
        color: #334155;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .form-control {
        padding: 12px 16px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        background-color: #ffffff;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-control:disabled {
        background-color: #f8fafc;
    }

    /* Avatar Section */
    .avatar-upload-section {
        display: flex;
        align-items: center;
        gap: 30px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        margin-bottom: 30px;
    }
    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: bold;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
    }

    /* Tombol Simpan */
    .btn-save {
        background-color: #3b82f6;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 14px;
        color: white;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-save:hover {
        background-color: #2563eb;
    }

    /* --- RESPONSIF MOBILE --- */
    @media (max-width: 768px) {
        .pengaturan-page {
            margin: -20px;
            padding: 20px;
        }
        .settings-card {
            flex-direction: column;
            min-height: auto;
        }
        .settings-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #bae6fd;
            padding: 20px;
        }
        .user-profile-mini {
            display: none;
        }
        .settings-nav {
            flex-direction: row;
            overflow-x: auto;
            gap: 10px;
            padding-bottom: 10px;
        }
        .settings-nav a {
            white-space: nowrap;
            padding: 10px 15px;
        }
        .settings-content {
            padding: 25px 20px;
        }
        .avatar-upload-section {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="pengaturan-page">
    <div class="settings-container">
        
        <!-- Tombol Kembali (Tanpa Underline) -->
        @if(Auth::user()->role === 'guru')
            <a href="{{ route('guru.dashboard') }}">Kembali ke Dashboard</a>
        @elseif(Auth::user()->role === 'pembimbing')
            <a href="{{ route('pembimbing.dashboard') }}">Kembali ke Dashboard</a>
        @elseif(Auth::user()->role === 'user')
            <a href="{{ url('/dashboard') }}">Kembali ke Dashboard</a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ url('/admin/dashboard') }}">Kembali ke Dashboard</a>
        @endif

        <!-- Card Pengaturan -->
        <div class="settings-card">
            
            <!-- SIDEBAR KIRI (Biru Keputihan) -->
            <div class="settings-sidebar">
                <div class="user-profile-mini">
                    <div class="avatar">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="name">{{ $user->name }}</div>
                        <div class="role">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>

                <ul class="settings-nav" id="settingsTab" role="tablist">
                    <li>
                        <a href="#profil" class="active" data-bs-toggle="tab" role="tab">
                            <i class="bi bi-person"></i> Profil Saya
                        </a>
                    </li>
                    <li>
                        <a href="#keamanan" data-bs-toggle="tab" role="tab">
                            <i class="bi bi-shield-lock"></i> Keamanan
                        </a>
                    </li>
                    <li>
                        <a href="#tentang" data-bs-toggle="tab" role="tab">
                            <i class="bi bi-info-circle"></i> Tentang Aplikasi
                        </a>
                    </li>
                </ul>
            </div>

            <!-- KONTEN KANAN -->
            <div class="settings-content tab-content" id="settingsTabContent">
                
                <!-- TAB 1: PROFIL -->
                <div class="tab-pane fade show active" id="profil" role="tabpanel">
                    <div class="content-header">
                        <h3>Profil Pengguna</h3>
                        <p>Perbarui informasi profil dan foto Anda di sini.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                    @endif
                    
                    <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="avatar-upload-section">
                            <div class="avatar-preview">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label mb-2">Unggah Foto Baru</label>
                                <input type="file" name="foto_profil" class="form-control" style="background: #ffffff;">
                                <small class="text-muted mt-1 d-block">Format: JPG, PNG (Maks. 2MB).</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly disabled>
                                    <small class="text-muted mt-1 d-block"><i class="bi bi-lock-fill"></i> Email tidak dapat diubah.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- TAB 2: KEAMANAN -->
                <div class="tab-pane fade" id="keamanan" role="tabpanel">
                    <div class="content-header">
                        <h3>Keamanan Akun</h3>
                        <p>Ubah password Anda secara berkala untuk menjaga keamanan akun.</p>
                    </div>

                    <form action="{{ route('pengaturan.update') }}" method="POST" style="max-width: 100%;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password Saat Ini</label>
                                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama">
                                    @error('password_lama') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control" placeholder="Minimal 6 karakter">
                                    @error('password_baru') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_baru_confirmation" class="form-control" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2" style="border-radius: 10px;">Perbarui Password</button>
                        </div>
                    </form>
                </div>

                <!-- TAB 3: TENTANG -->
                <div class="tab-pane fade" id="tentang" role="tabpanel">
                    <div class="content-header">
                        <h3>Tentang Aplikasi</h3>
                        <p>Informasi versi dan pengembang.</p>
                    </div>
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-check text-primary display-1 mb-3"></i>
                        <h3 class="fw-bold text-dark">Timetrix</h3>
                        <p class="text-muted mb-2 fs-5">Attendance System v1.0.0</p>
                        <span class="badge bg-light text-dark border px-3 py-2">Laravel 11 + Bootstrap 5</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Script Active State -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.settings-nav a');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endsection