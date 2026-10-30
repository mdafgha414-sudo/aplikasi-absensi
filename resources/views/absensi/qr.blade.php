@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">QR Code Absensi</h3>
                    <p class="text-muted small mb-4">Tampilkan layar ini ke siswa. Siswa wajib memindai QR Code ini menggunakan HP mereka.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($tokenAktif)
                        <!-- Area Tempat QR Code Muncul -->
                        <div id="qrcode" class="d-flex justify-content-center my-4"></div>
                        
                        <div class="alert alert-warning py-2 mb-4">
                            <i class="bi bi-clock-history me-1"></i>
                            QR Code ini hanya berlaku sampai pukul <strong>{{ \Carbon\Carbon::parse($tokenAktif->expires_at)->format('H:i:s') }}</strong>
                        </div>
                    @else
                        <div class="alert alert-danger my-4">
                            <i class="bi bi-x-circle me-2"></i> Tidak ada QR Code aktif. Silakan buat baru.
                        </div>
                    @endif

                    <!-- Tombol Generate -->
                    <form action="{{ route('qr.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                            <i class="bi bi-arrow-clockwise me-2"></i> Generate QR Code Baru
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Library Pembuat QR Code -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
    // Cek apakah ada token aktif yang dikirim dari Controller
    @if($tokenAktif)
        // Jika ada, buat QR Code di dalam div dengan id="qrcode"
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $tokenAktif->token }}", // Isi QR Code dengan token dari database
            width: 250, // Lebar QR
            height: 250, // Tinggi QR
            colorDark : "#000000", // Warna kotak
            colorLight : "#ffffff", // Warna background
            correctLevel : QRCode.CorrectLevel.H // Tingkat ketajaman
        });
    @endif
</script>
@endsection