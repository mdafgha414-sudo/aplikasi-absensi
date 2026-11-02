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

<!-- ========================================== -->
<!-- MODAL KONFIRMASI ABSENSI (LEBIH CANTIK)    -->
<!-- ========================================== -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalLabel"><i class="bi bi-person-badge"></i> Konfirmasi Absensi</h5>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-1" id="modalNama">-</h4>
                <p class="text-muted mb-4" id="modalKode">-</p>
                
                <div class="alert alert-warning fw-bold mb-0">
                    Apakah Anda yakin ingin mencatat <span id="modalTipe" class="text-uppercase">MASUK</span> untuk siswa ini?
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0 pb-4">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" onclick="batalkanScan()">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <button type="button" class="btn btn-primary px-4 fw-bold" id="btnKonfirmasi">
                    <i class="bi bi-check-circle"></i> Ya, Konfirmasi
                </button>
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
    let dataSiswaSementara = null; // Menyimpan data siswa sebelum dikonfirmasi
    let modalKonfirmasi; // Variabel untuk Bootstrap Modal

    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Modal Bootstrap
        modalKonfirmasi = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
        
        // Tombol Konfirmasi di dalam Modal
        document.getElementById('btnKonfirmasi').addEventListener('click', function() {
            if (dataSiswaSementara) {
                modalKonfirmasi.hide();
                simpanAbsensi(dataSiswaSementara.id, dataSiswaSementara.tipe_absen);
            }
        });

        startScanner();
    });

    function onScanSuccess(decodedText, decodedResult) {
        if (isProcessing) return; 
        isProcessing = true;

        // Hentikan kamera sementara saat memproses
        html5QrcodeScanner.pause(true);

        let resultDiv = document.getElementById('result');
        resultDiv.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Membaca kartu...';
        resultDiv.className = 'alert alert-warning mt-4 fw-bold';

        // 1. Cek data siswa ke server
        $.ajax({
            url: "{{ route('pembimbing.scan.cek') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                kode_kartu: decodedText
            },
            success: function(response) {
                dataSiswaSementara = response.data;
                
                // Isi data ke dalam Modal
                document.getElementById('modalNama').innerText = response.data.nama;
                document.getElementById('modalKode').innerText = 'Kode: ' + response.data.kode;
                
                let tipeEl = document.getElementById('modalTipe');
                tipeEl.innerText = response.data.tipe_absen;
                
                // Ubah warna teks tipe absen (Merah untuk pulang, Hijau untuk masuk)
                tipeEl.className = response.data.tipe_absen === 'Pulang' ? 'text-danger' : 'text-success';

                // Tampilkan Modal Bootstrap
                modalKonfirmasi.show();
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                resultDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + errorMsg;
                resultDiv.className = 'alert alert-danger mt-4 fw-bold';
                setTimeout(() => resetScanner('Menunggu scan...'), 3000);
            }
        });
    }

    function simpanAbsensi(userId, tipeAbsen) {
        let resultDiv = document.getElementById('result');
        resultDiv.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan data absensi...';
        resultDiv.className = 'alert alert-warning mt-4 fw-bold';

        $.ajax({
            url: "{{ route('pembimbing.scan.simpan') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                user_id: userId,
                tipe_absen: tipeAbsen
            },
            success: function(response) {
                resultDiv.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + response.message;
                resultDiv.className = 'alert alert-success mt-4 fw-bold';
                setTimeout(() => resetScanner('Menunggu scan...'), 3000);
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal menyimpan.';
                resultDiv.innerHTML = '<i class="bi bi-x-circle-fill"></i> ' + errorMsg;
                resultDiv.className = 'alert alert-danger mt-4 fw-bold';
                setTimeout(() => resetScanner('Menunggu scan...'), 3000);
            }
        });
    }

    function batalkanScan() {
        resetScanner('Scan dibatalkan.');
    }

    function resetScanner(pesan) {
        isProcessing = false;
        dataSiswaSementara = null;
        document.getElementById('result').innerHTML = '<i class="bi bi-camera-video"></i> ' + pesan;
        document.getElementById('result').className = 'alert alert-info mt-4 fw-bold';
        html5QrcodeScanner.resume(); // Nyalakan kamera lagi
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
</script>
@endsection