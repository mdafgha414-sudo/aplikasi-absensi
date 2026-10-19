@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <h3 class="mb-2">Dashboard User</h3>
            <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai User.</p>
            
            <hr class="my-4">

            <h5 class="mb-4">Menu Cepat:</h5>
            
            <!-- Tombol Absen -->
            <a href="/absensi" class="btn btn-primary btn-lg w-100 mb-3 rounded-3">
                📝 Isi Absen Sekarang
            </a>
            
            <!-- Tombol Riwayat -->
            <a href="/absensi/riwayat" class="btn btn-outline-secondary btn-lg w-100 rounded-3">
                📊 Lihat Riwayat Absen
            </a>
        </div>
    </div>
</div>
@endsection