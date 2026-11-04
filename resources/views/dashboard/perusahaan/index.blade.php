@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Manajemen Perusahaan (Tempat PKL)</h3>
            <p class="text-muted mb-0">Daftarkan lokasi PKL baru beserta koordinat radiusnya.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Tambah Perusahaan -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle me-2"></i>Tambah Perusahaan Baru</h5>
                    <form action="{{ route('admin.perusahaan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Perusahaan / Instansi</label>
                            <input type="text" name="nama_perusahaan" class="form-control" placeholder="Contoh: PT. Maju Jaya" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Sudirman No. 1, Jakarta"></textarea>
                        </div>
                        
                        <!-- PETA INTERAKTIF -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-primary">
                                <i class="bi bi-geo-alt-fill"></i> Klik Peta untuk Mengatur Lokasi
                            </label>
                            <div id="map" style="height: 250px; border-radius: 8px; z-index: 1; border: 1px solid #ddd;"></div>
                            <small class="text-muted">Geser peta dan klik di area perusahaan untuk mengambil koordinat.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control bg-light" readonly required placeholder="Klik peta">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control bg-light" readonly required placeholder="Klik peta">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Radius Absensi (Meter)</label>
                            <input type="number" name="radius" class="form-control" value="100" required>
                            <small class="text-muted">Jarak maksimal siswa bisa absen (contoh: 100 meter).</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perusahaan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Perusahaan -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-list-ul me-2"></i>Daftar Perusahaan Terdaftar</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Lokasi (Lat, Lng)</th>
                                    <th class="text-center">Radius</th>
                                    <th class="text-center" width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perusahaans as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $p->nama_perusahaan }}</td>
                                    <td><small class="text-muted">{{ $p->alamat ?? '-' }}</small></td>
                                    <td class="text-center">
                                        <small class="d-block">{{ $p->latitude }}</small>
                                        <small class="d-block">{{ $p->longitude }}</small>
                                    </td>
                                    <td class="text-center"><span class="badge bg-info text-dark">{{ $p->radius }} m</span></td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.perusahaan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus perusahaan ini? Siswa di dalamnya mungkin akan kehilangan lokasi PKL.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-building fs-3 d-block mb-2 text-secondary"></i>
                                        Belum ada data perusahaan. Silakan tambahkan di form sebelah kiri.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPT PETA (LEAFLET)                      -->
<!-- ========================================== -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Peta (Default: Monas, Jakarta)
        var map = L.map('map').setView([-6.175392, 106.827153], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        // Event saat peta diklik
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(8);
            var lng = e.latlng.lng.toFixed(8);

            // Isi form input
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Pindahkan marker
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });
    });
</script>
@endsection