@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 shadow-sm border-0">
            <h3 class="mb-4 fw-bold">Tambah Pengguna Baru</h3>

            <!-- Menampilkan pesan error jika validasi gagal -->
            @if ($errors->any())
                <div class="alert alert-danger border-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/tambah-user" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Andi Wijaya" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="andi@gmail.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                <!-- TAMBAHAN: Dropdown Pilihan Role -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Daftar Sebagai</label>
                    <select name="role" class="form-select" required>
                        <option value="user">Siswa (PKL)</option>
                        <option value="guru">Guru Pembimbing</option>
                    </select>
                    <small class="text-muted">Pilih role agar sistem mengarahkan ke dashboard yang tepat.</small>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="/admin/dashboard" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection