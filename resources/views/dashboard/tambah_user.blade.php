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

            <form action="/admin/tambah-user" method="POST">
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
                    <select name="role" id="roleSelect" class="form-select" required onchange="toggleSekolah()">
                        <option value="" disabled selected>-- Pilih Role --</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Siswa (PKL)</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="pembimbing" {{ old('role') == 'pembimbing' ? 'selected' : '' }}>Pembimbing PKL</option>
                    </select>
                    <small class="text-muted">Pilih role agar sistem mengarahkan ke dashboard yang tepat.</small>
                </div>

                {{-- Input Asal Sekolah (Hanya Muncul Jika Role = Siswa) --}}
                <div class="mb-4" id="sekolahContainer" style="display: none;">
                    <label class="form-label fw-bold">Asal Sekolah</label>
                   <select name="sekolah_id" class="form-select">
                  <option value="" disabled selected>-- Pilih Sekolah --</option>
                        @foreach($daftarSekolah as $sklh)
                         <option value="{{ $sklh->id }}" {{ old('sekolah_id', $pengguna->sekolah_id ?? '') == $sklh->id ? 'selected' : '' }}>
                             {{ $sklh->nama_sekolah }}
                        </option>
                            @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="/admin/dashboard" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript untuk menampilkan/menyembunyikan input sekolah --}}
<script>
    function toggleSekolah() {
        const role = document.getElementById('roleSelect').value;
        const sekolahContainer = document.getElementById('sekolahContainer');
        
        if (role === 'user') {
            sekolahContainer.style.display = 'block';
        } else {
            sekolahContainer.style.display = 'none';
            // Opsional: kosongkan value sekolah jika bukan user
            document.querySelector('select[name="sekolah"]').value = ''; 
        }
    }

    // Jalankan saat halaman dimuat (untuk kasus validasi gagal / old input)
    document.addEventListener('DOMContentLoaded', function() {
        toggleSekolah();
    });
</script>
@endsection