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

            {{-- Tentukan Action URL berdasarkan Role yang Login --}}
            @php
                $actionUrl = Auth::user()->role === 'pembimbing' ? route('pembimbing.siswa.store') : url('/admin/tambah-user');
                $cancelUrl = Auth::user()->role === 'pembimbing' ? route('pembimbing.siswa.index') : url('/admin/dashboard');
            @endphp

            <form action="{{ $actionUrl }}" method="POST">
                @csrf
                
                {{-- Input Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Andi Wijaya" value="{{ old('name') }}" required>
                </div>

                {{-- Input Email --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="andi@gmail.com" value="{{ old('email') }}" required>
                </div>

                {{-- Input Password --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                </div>

                {{-- Dropdown Pilihan Role --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Daftar Sebagai</label>
                    <select name="role" id="roleSelect" class="form-select" required onchange="toggleForm()">
                        <option value="" disabled selected>-- Pilih Role --</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Siswa (PKL)</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        
                        {{-- Hanya Admin yang bisa membuat role Pembimbing --}}
                        @if(Auth::user()->role === 'admin')
                            <option value="pembimbing" {{ old('role') == 'pembimbing' ? 'selected' : '' }}>Pembimbing PKL</option>
                        @endif
                    </select>
                    <small class="text-muted">Pilih role agar sistem mengarahkan ke dashboard yang tepat.</small>
                </div>

                {{-- Input Perusahaan (Muncul jika role = user atau pembimbing) --}}
                <div class="mb-4" id="perusahaanContainer" style="display: none;">
                    <label class="form-label fw-bold">Tempat PKL (Perusahaan)</label>
                    <select name="perusahaan_id" class="form-select">
                        <option value="" disabled selected>-- Pilih Perusahaan --</option>
                        @foreach($daftarPerusahaan as $prs)
                            <option value="{{ $prs->id }}" {{ old('perusahaan_id') == $prs->id ? 'selected' : '' }}>
                                {{ $prs->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Asal Sekolah (Hanya Muncul Jika Role = Siswa) --}}
                <div class="mb-4" id="sekolahContainer" style="display: none;">
                    <label class="form-label fw-bold">Asal Sekolah</label>
                    <select name="sekolah_id" class="form-select">
                        <option value="" disabled selected>-- Pilih Sekolah --</option>
                        @foreach($daftarSekolah as $sklh)
                            <option value="{{ $sklh->id }}" {{ old('sekolah_id') == $sklh->id ? 'selected' : '' }}>
                                {{ $sklh->nama_sekolah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ $cancelUrl }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk menampilkan/menyembunyikan input --}}
<script>
    function toggleForm() {
        const role = document.getElementById('roleSelect').value;
        const sekolahContainer = document.getElementById('sekolahContainer');
        const perusahaanContainer = document.getElementById('perusahaanContainer');
        
        // Logika Sekolah (Hanya Siswa)
        if (role === 'user') {
            sekolahContainer.style.display = 'block';
        } else {
            sekolahContainer.style.display = 'none';
            const selectSekolah = document.querySelector('select[name="sekolah_id"]');
            if (selectSekolah) selectSekolah.value = ''; 
        }

        // Logika Perusahaan (Siswa & Pembimbing)
        if (role === 'user' || role === 'pembimbing') {
            if (perusahaanContainer) perusahaanContainer.style.display = 'block';
        } else {
            if (perusahaanContainer) perusahaanContainer.style.display = 'none';
            const selectPerusahaan = document.querySelector('select[name="perusahaan_id"]');
            if (selectPerusahaan) selectPerusahaan.value = '';
        }
    }

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        toggleForm();
    });
</script>
@endsection