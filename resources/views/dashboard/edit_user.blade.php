@extends('layouts.app')

@section('content')

<style>
    :root {
        --admin-primary: #7da7d9;
        --admin-bg: #f7faff;
        --admin-text: #40516a;
        --admin-border: #e8eef6;
    }

    .edit-container {
        color: var(--admin-text);
        padding: 10px 0 30px;
    }

    .edit-card {
        background: #fff;
        border: 1px solid var(--admin-border);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(82, 125, 180, .035);
        overflow: hidden;
    }

    .edit-card-header {
        padding: 24px 26px;
        border-bottom: 1px solid #eff3f9;
        background: #f8faff;
    }

    .edit-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #50617a;
        margin: 0;
    }

    .edit-card-body {
        padding: 24px 26px;
    }

    .form-label {
        font-weight: 600;
        color: #52627a;
        font-size: .85rem;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #dce9f8;
        padding: 10px 14px;
        font-size: .9rem;
        color: #52627a;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(125, 167, 217, .15);
    }

    .btn-save {
        background: #e8f1fc;
        border: 1px solid #e8f1fc;
        color: #5f8fc9;
        font-weight: 600;
        border-radius: 11px;
        padding: 10px 22px;
        transition: background .2s ease;
    }

    .btn-save:hover {
        background: #dceafb;
        border-color: #dceafb;
        color: #4d7eb9;
    }

    .btn-cancel {
        background: #fff;
        border: 1px solid #e8eef6;
        color: #8b9bb2;
        font-weight: 600;
        border-radius: 11px;
        padding: 10px 22px;
        transition: background .2s ease;
    }

    .btn-cancel:hover {
        background: #f4f8fe;
        color: #628fc7;
    }

    .btn-eye {
        background: #fff;
        border: 1px solid #dce9f8;
        border-left: none;
        color: #8b9bb2;
        border-radius: 0 10px 10px 0;
        cursor: pointer;
    }

    .btn-eye:hover {
        background: #f4f8fe;
        color: #52627a;
    }
</style>

<div class="edit-container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            
            <div class="edit-card">
                <div class="edit-card-header">
                    <h4 class="edit-card-title">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Edit Data Pengguna
                    </h4>
                </div>

                <div class="edit-card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0" style="border-radius: 12px; font-size: .85rem;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Tentukan Action URL berdasarkan Role yang Login --}}
                    @php
                        $actionUrl = Auth::user()->role === 'pembimbing' ? route('pembimbing.siswa.update', $pengguna->id) : url('/admin/edit-user/'.$pengguna->id);
                        $cancelUrl = Auth::user()->role === 'pembimbing' ? route('pembimbing.siswa.index') : url('/admin/dashboard');
                    @endphp

                    <form action="{{ $actionUrl }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $pengguna->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $pengguna->email) }}" required>
                        </div>

                        <!-- TAMBAHAN: Password Baru (Opsional) dengan Ikon Mata -->
                        <div class="mb-3">
                            <label class="form-label">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password" style="border-radius: 10px 0 0 10px;">
                                <button class="btn btn-eye" type="button" onclick="togglePassword('password', 'eyeIcon1')">
                                    <i class="bi bi-eye-slash" id="eyeIcon1"></i>
                                </button>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">*Biarkan kosong jika tidak ingin mengganti password lama.</small>
                        </div>

                        <!-- TAMBAHAN: Konfirmasi Password Baru dengan Ikon Mata -->
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru" style="border-radius: 10px 0 0 10px;">
                                <button class="btn btn-eye" type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                                    <i class="bi bi-eye-slash" id="eyeIcon2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- DROPDOWN ROLE -->
                        <div class="mb-4">
                            <label class="form-label">Role / Jabatan</label>
                            <select name="role" id="roleSelect" class="form-select" required onchange="toggleForm()">
                                <option value="user" {{ old('role', $pengguna->role) == 'user' ? 'selected' : '' }}>Siswa (PKL)</option>
                                <option value="guru" {{ old('role', $pengguna->role) == 'guru' ? 'selected' : '' }}>Guru Pembimbing</option>
                                
                                {{-- Hanya Admin yang bisa mengubah role ke Pembimbing --}}
                                @if(Auth::user()->role === 'admin')
                                    <option value="pembimbing" {{ old('role', $pengguna->role) == 'pembimbing' ? 'selected' : '' }}>Guru Pembimbing PKL</option>
                                @endif
                            </select>
                            <small class="text-muted mt-1 d-block" style="font-size: .78rem;">
                                *Ubah role untuk memindahkan pengguna ke dashboard yang sesuai.
                            </small>
                        </div>

                        <!-- INPUT ASAL SEKOLAH (Hanya Muncul Jika Role = Siswa) -->
                        <div class="mb-4" id="sekolahContainer" style="display: none;">
                            <label class="form-label">Asal Sekolah</label>
                            <select name="sekolah_id" class="form-select">
                                <option value="" disabled selected>-- Pilih Sekolah --</option>
                                @foreach($daftarSekolah as $sklh)
                                    <option value="{{ $sklh->id }}" {{ old('sekolah_id', $pengguna->sekolah_id ?? '') == $sklh->id ? 'selected' : '' }}>
                                        {{ $sklh->nama_sekolah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- INPUT PERUSAHAAN (Muncul untuk Siswa, Guru, & Pembimbing) -->
                        <div class="mb-4" id="perusahaanContainer" style="display: none;">
                            <label class="form-label">Tempat PKL (Perusahaan)</label>
                            <select name="perusahaan_id" class="form-select">
                                <option value="" disabled selected>-- Pilih Perusahaan --</option>
                                @foreach($daftarPerusahaan as $prs)
                                    <option value="{{ $prs->id }}" {{ old('perusahaan_id', $pengguna->perusahaan_id ?? '') == $prs->id ? 'selected' : '' }}>
                                        {{ $prs->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ $cancelUrl }}" class="btn btn-cancel">Batal</a>
                            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- JavaScript untuk menampilkan/menyembunyikan input dan password --}}
<script>
    // Fungsi toggle visibilitas password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }

    function toggleForm() {
        const role = document.getElementById('roleSelect').value;
        const sekolahContainer = document.getElementById('sekolahContainer');
        const perusahaanContainer = document.getElementById('perusahaanContainer');
        
        // Logika Sekolah (Hanya Siswa)
        if (role === 'user') {
            if(sekolahContainer) sekolahContainer.style.display = 'block';
        } else {
            if(sekolahContainer) sekolahContainer.style.display = 'none';
        }

        // Logika Perusahaan (Siswa, Guru, Pembimbing)
        if (role === 'user' || role === 'guru' || role === 'pembimbing') {
            if(perusahaanContainer) perusahaanContainer.style.display = 'block';
        } else {
            if(perusahaanContainer) perusahaanContainer.style.display = 'none';
        }
    }

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        toggleForm();
    });
</script>
@endsection