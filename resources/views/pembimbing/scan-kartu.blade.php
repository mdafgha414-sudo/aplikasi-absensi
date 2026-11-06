@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-qr-code-scan"></i> Scan Kartu Siswa PKL</h5>
                </div>
                <div class="card-body text-center p-4">
                    <p class="text-muted mb-3">Arahkan kamera ke QR Code pada kartu siswa.</p>
                    
                    <!-- Area Kamera Scanner -->
                    <div id="reader" style="width: 100%; max-width: 450px; margin: 0 auto; border: 3px solid #e2e8f0; border-radius: 15px; overflow: hidden;"></div>
                    
                    <!-- Area Status -->
                    <div id="result" class="alert alert-info mt-4 fw-bold" style="font-size: 1.1rem;">
                        <i class="bi bi-camera-video"></i> Menunggu scan...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Library HTML5 QR Code --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let html5QrcodeScanner;
    let isProcessing = false; 

    function onScanSuccess(decodedText, decodedResult) {
        if (isProcessing) return; 
        isProcessing = true;

        // Hentikan kamera sementara saat memproses
        html5QrcodeScanner.pause(true);

        let resultDiv = document.getElementById('result');
        resultDiv.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses kartu...';
        resultDiv.className = 'alert alert-warning mt-4 fw-bold';

        // Kirim data langsung ke server (tanpa modal)
        $.ajax({
            url: "{{ route('pembimbing.scan.proses') }}", // <-- PASTIKAN INI
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                kode_kartu: decodedText
            },
            success: function(response) {
                // Tampilkan pesan sukses
                resultDiv.innerHTML = response.message;
                resultDiv.className = 'alert alert-success mt-4 fw-bold';
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                resultDiv.innerHTML = '❌ ' + errorMsg;
                resultDiv.className = 'alert alert-danger mt-4 fw-bold';
            },
            complete: function() {
                // Jeda 2.5 detik sebelum bisa scan lagi
                setTimeout(() => {
                    isProcessing = false;
                    resultDiv.innerHTML = '<i class="bi bi-camera-video"></i> Menunggu scan...';
                    resultDiv.className = 'alert alert-info mt-4 fw-bold';
                    html5QrcodeScanner.resume(); // Nyalakan kamera lagi
                }, 2500);
            }
        });
    }

    function startScanner() {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 20, 
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    let minEdgePercentage = 0.8; 
                    let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
                    let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
                    return { width: qrboxSize, height: qrboxSize };
                },
                rememberLastUsedCamera: true,
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true 
                }
            }
        );
        html5QrcodeScanner.render(onScanSuccess);
    }

    document.addEventListener('DOMContentLoaded', function() {
        startScanner();
    });
</script>
@endsection