@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">QR Code Absensi</h3>
                    <p class="text-muted">Tampilkan QR Code ini ke siswa untuk melakukan absensi.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($tokenAktif)
                        <div id="qrcode" class="d-flex justify-content-center my-4"></div>
                        <p class="text-danger fw-bold">
                            <i class="bi bi-clock-history me-1"></i>
                            Berlaku sampai: {{ \Carbon\Carbon::parse($tokenAktif->expires_at)->format('H:i:s') }}
                        </p>
                    @else
                        <div class="alert alert-warning my-4">
                            Tidak ada QR Code aktif. Silakan buat baru.
                        </div>
                    @endif

                    <form action="{{ route('qr.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="bi bi-arrow-clockwise me-2"></i> Generate QR Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    @if($tokenAktif)
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $tokenAktif->token }}",
            width: 250,
            height: 250,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    @endif
</script>
@endsection