@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 text-center p-5">
            <h3 class="mb-2 fw-bold">Dashboard Guru Pembimbing</h3>
            <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai Guru.</p>
            
            <hr class="my-4">

            <div class="d-grid gap-3">
                <a href="/guru/jurnal" class="btn btn-success btn-lg w-100 rounded-3 py-3">
                    <i class="bi bi-journal-check me-2"></i> Lihat & Nilai Jurnal Siswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection