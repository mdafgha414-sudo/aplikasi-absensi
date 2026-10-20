@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card p-4">
            <h3 class="text-center mb-4">Login Sistem</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

                    <form action="/login" method="POST">
                        @csrf
                        
                        <!-- Input Email dengan Ikon Amplop -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Alamat Email</label>
                            <div class="custom-input-group">
                                <span class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                    </svg>
                                </span>
                                <input type="email" name="email" 
                                    class="form-control py-2" 
                                    placeholder="Masukan Email Anda" 
                                    value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <!-- Input Password dengan Ikon Kunci & Tombol Mata -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small mb-1">Kata Sandi</label>
                            <div class="custom-input-group">
                                <span class="input-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                    </svg>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="form-control py-2" 
                                    placeholder="******" required>
                                <button type="button" class="btn-toggle-eye" id="togglePassword" aria-label="Lihat Password">
                                    <!-- Ikon Mata (Eye) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" id="eyeIcon">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                            Masuk Sekarang
                        </button>
                    </form>

                </div>

                <!-- Footer Kartu -->
                <div class="card-footer bg-light border-0 text-center py-3 rounded-bottom-4">
                    <span class="text-muted small">© {{ date('Y') }} Sistem Absensi Digital</span>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript untuk Toggle Lihat/Sembunyikan Password -->
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        
        // Ubah tipe input antara 'password' dan 'text'
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        // Ganti ikon mata terbuka / mata tercoret
        if (isPassword) {
            // Ikon Mata Tercoret (Eye Slash)
            eyeIcon.innerHTML = `<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a8 8 0 0 0-2.79.512l1.06 1.06A7 7 0 0 1 8 3.5c4.478 0 8.268 2.943 9.542 7a10 10 0 0 1-1.563 3.029l1.06 1.06zM11.225 10.5l1.06 1.06a4.5 4.5 0 0 0-4.475-4.475l1.06 1.06a2.5 2.5 0 0 1 2.355 2.355zM12.458 12.458a11 11 0 0 1-1.465 1.755C9.879 15.332 8.119 16.5 6 16.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 0 12s3-5.5 8-5.5a8 8 0 0 1 1.79.205l1.06 1.06C9.12 6.668 7.36 5.5 5.5 5.5s-3.879 1.168-5.168 2.457A13 13 0 0 0 0 12c.086.13.195.288.335.48a10 10 0 0 0 1.465 1.755l1.06-1.06A8 8 0 0 1 2.458 12c.112-.39.23-.783.355-1.173l-1.06-1.06zM8 12.5a2.5 2.5 0 0 1-2.355-2.355l1.06-1.06A4.5 4.5 0 0 0 12.5 8v-.008L12.5 8a4.5 4.5 0 0 0-4.5-4.5h-.008l-.008.008zm1.326 1.326l1.06 1.06A4.5 4.5 0 0 0 12.5 8v-.008L12.5 8a4.5 4.5 0 0 0-4.5-4.5h-.008l-.008.008z"/>`;
        } else {
            // Ikon Mata Terbuka (Eye)
            eyeIcon.innerHTML = `<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>`;
        }
    });
</script>
@endsection