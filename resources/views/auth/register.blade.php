@extends('layouts.auth')

@section('content')
<div class="card border-0 shadow-lg rounded-4" style="width: 100%; max-width: 450px;">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Daftar Akun</h3>
            <p class="text-muted">Silakan isi data diri Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">Daftar Sekarang</button>
        </form>
    </div>
</div>
@endsection