@extends('layouts.app')

@section('content')
<div class="container text-center py-4">
    <h5 class="fw-bold mb-3">Scan QR Absensi</h5>
    <p class="text-muted small">Arahkan kamera ke QR Code yang ditampilkan Pembimbing.</p>

    <!-- Area Kamera -->
    <div id="reader" style="width: 100%; max-width: 400px; margin: auto; border-radius: 15px; overflow: hidden;"></div>

    <!-- Status Pesan -->
    <div id="status" class="mt-4 alert alert-info">Menunggu kamera...</div>
</div>

<!-- Library Scanner -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner setelah berhasil scan
        html5QrcodeScanner.clear();
        document.getElementById('status').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> QR terdeteksi! Memvalidasi lokasi...';

        // Minta akses lokasi GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Kirim data ke server
                fetch('{{ route('absensi.proses-scan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token: decodedText,
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message.includes('berhasil')) {
                        document.getElementById('status').className = 'mt-4 alert alert-success fw-bold';
                    } else {
                        document.getElementById('status').className = 'mt-4 alert alert-danger fw-bold';
                    }
                    document.getElementById('status').innerText = data.message;
                })
                .catch(error => {
                    document.getElementById('status').className = 'mt-4 alert alert-danger';
                    document.getElementById('status').innerText = "Terjadi kesalahan sistem.";
                });
            }, function(error) {
                document.getElementById('status').className = 'mt-4 alert alert-warning';
                document.getElementById('status').innerText = "Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin diberikan.";
            });
        } else {
            document.getElementById('status').className = 'mt-4 alert alert-danger';
            document.getElementById('status').innerText = "Browser Anda tidak mendukung GPS.";
        }
    }

    let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection