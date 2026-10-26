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

                    <form action="/admin/edit-user/{{ $pengguna->id }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $pengguna->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $pengguna->email }}" required>
                        </div>

                        <!-- DROPDOWN ROLE -->
                        <div class="mb-4">
                            <label class="form-label">Role / Jabatan</label>
                            <select name="role" class="form-select" required>
                                <option value="user" {{ $pengguna->role == 'user' ? 'selected' : '' }}>Siswa (PKL)</option>
                                <option value="guru" {{ $pengguna->role == 'guru' ? 'selected' : '' }}>Guru Pembimbing</option>
                                 <option value="pembimbing" {{ $pengguna->role == 'pembimbing' ? 'selected' : '' }}>Guru Pembimbing PKL</option> <!-- TAMBAHKAN INI -->
                            </select>
                            <small class="text-muted mt-1 d-block" style="font-size: .78rem;">
                                *Ubah role untuk memindahkan pengguna ke dashboard yang sesuai.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="/admin/dashboard" class="btn btn-cancel">Batal</a>
                            <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection