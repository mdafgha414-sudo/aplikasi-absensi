
@extends('layouts.auth')

@section('content')
<style>
    .login-page {
        min-height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 35px 20px;
        background:
            radial-gradient(circle at 90% 10%, #dbeafe 0, transparent 30%),
            #f4f7ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .login-layout {
        width: 100%;
        max-width: 1050px;
        min-height: 570px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        overflow: hidden;
        border-radius: 26px;
        background: white;
        box-shadow: 0 25px 70px rgba(30, 64, 175, .12);
    }

    .login-brand {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 45px;
        color: white;
        background: linear-gradient(145deg, #60a5fa, #2563eb 55%, #1e40af);
    }

    .login-brand::before,
    .login-brand::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .login-brand::before {
        width: 320px;
        height: 320px;
        top: -170px;
        right: -130px;
        background: rgba(255,255,255,.10);
    }

    .login-brand::after {
        width: 260px;
        height: 260px;
        bottom: -130px;
        left: -100px;
        background: rgba(147,197,253,.16);
    }

    .brand-content,
    .brand-bottom {
        position: relative;
        z-index: 1;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 13px;
        font-size: 23px;
        font-weight: 800;
    }

    .brand-logo-icon {
        width: 49px;
        height: 49px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(255,255,255,.3);
        border-radius: 15px;
        background: rgba(255,255,255,.17);
        font-size: 25px;
    }

    .brand-title {
        margin-top: 65px;
        font-size: clamp(29px, 3vw, 38px);
        line-height: 1.3;
        font-weight: 800;
        letter-spacing: -1.2px;
    }

    .brand-description {
        margin-top: 18px;
        color: #dbeafe;
        font-size: 14px;
        line-height: 1.9;
    }

    .brand-illustration {
        margin-top: 35px;
        padding: 28px 15px;
        text-align: center;
        border-radius: 22px;
        background: rgba(255,255,255,.13);
        border: 1px solid rgba(255,255,255,.2);
    }

    .brand-illustration i {
        font-size: 83px;
        line-height: 1.4;
    }

    .brand-illustration p {
        margin: 12px 0 0;
        color: #eff6ff;
        font-size: 12px;
    }

    .brand-bottom {
        margin-top: 35px;
        color: #dbeafe;
        font-size: 11px;
    }

    .login-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px;
        background: #fff;
    }

    .login-form-content {
        width: 100%;
        max-width: 365px;
    }

    .login-heading {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-icon {
        width: 64px;
        height: 64px;
        display: grid;
        place-items: center;
        margin: 0 auto 18px;
        border-radius: 20px;
        color: white;
        font-size: 29px;
        background: linear-gradient(135deg, #60a5fa, #2563eb);
        box-shadow: 0 8px 20px rgba(37,99,235,.22);
    }

    .login-heading h2 {
        margin-bottom: 9px;
        color: #172554;
        font-size: 27px;
        font-weight: 800;
        letter-spacing: -.8px;
    }

    .login-heading p {
        margin: 0;
        color: #8491aa;
        font-size: 12px;
    }

    .login-label {
        display: block;
        margin-bottom: 9px;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
    }

    .login-input-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        padding: 0 14px;
        border: 1px solid #dbe4f2;
        border-radius: 12px;
        background: #fff;
        transition: .2s;
    }

    .login-input-wrap:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,.10);
    }

    .login-input-wrap > i {
        flex-shrink: 0;
        color: #7890b5;
        font-size: 17px;
    }

    .login-input-wrap .form-control {
        min-width: 0;
        height: 49px;
        padding: 8px 0;
        border: none;
        outline: none;
        box-shadow: none;
        font-size: 13px;
    }

    .login-input-wrap .form-control:focus {
        box-shadow: none;
    }

    .login-input-wrap .form-control::placeholder {
        color: #a3aec2;
    }

    .btn-toggle-eye {
        display: grid;
        flex-shrink: 0;
        place-items: center;
        padding: 8px 0 8px 8px;
        border: 0;
        background: transparent;
        color: #7890b5;
        cursor: pointer;
    }

    .btn-login {
        width: 100%;
        min-height: 51px;
        margin-top: 8px;
        border: none;
        border-radius: 12px;
        color: white;
        background: linear-gradient(110deg, #3b82f6, #1d4ed8);
        box-shadow: 0 8px 18px rgba(37,99,235,.20);
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
    }

    .btn-login:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37,99,235,.25);
    }

    .login-help {
        margin-top: 25px;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.9;
        text-align: center;
    }

    .login-help a {
        color: #2563eb;
        font-weight: 700;
        text-decoration: none;
    }

    .login-footer {
        margin-top: 20px;
        text-align: center;
        color: #a0abc0;
        font-size: 10px;
    }

    .mobile-brand {
        display: none;
    }

    @media (max-width: 768px) {
        .login-page {
            min-height: 100vh;
            padding: 20px 14px;
        }

        .login-layout {
            max-width: 460px;
            min-height: auto;
            grid-template-columns: 1fr;
            border-radius: 22px;
        }

        .login-brand {
            display: none;
        }

        .login-form-panel {
            padding: 30px 24px;
        }

        .login-form-content {
            max-width: 390px;
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 28px;
            color: #2563eb;
            font-size: 19px;
            font-weight: 800;
        }

        .mobile-brand i {
            font-size: 27px;
        }

        .login-heading {
            margin-bottom: 25px;
        }

        .login-heading h2 {
            font-size: 25px;
        }

        .login-footer {
            margin-top: 18px;
        }
    }

    @media (max-width: 360px) {
        .login-form-panel {
            padding: 25px 17px;
        }
    }
</style>

<div class="login-page">
    <div class="login-layout">

        <!-- PANEL BRANDING DESKTOP -->
        <aside class="login-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="brand-logo-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <span>Absensi App</span>
                </div>

                <h1 class="brand-title">
                    Kelola Kehadiran,<br>
                    Lebih Mudah &amp; Efisien.
                </h1>

                <p class="brand-description">
                    Sistem absensi digital yang membantu
                    pengelolaan kehadiran menjadi lebih praktis,
                    cepat, dan terorganisir.
                </p>

                <div class="brand-illustration">
                    <i class="bi bi-calendar2-week"></i>
                    <p>
                        <i class="bi bi-check-circle-fill"></i>
                        Kehadiran tercatat, pekerjaan lebih teratur.
                    </p>
                </div>
            </div>

            <div class="brand-bottom">
                &copy; {{ date('Y') }} Sistem Absensi Digital
            </div>
        </aside>

        <!-- FORM LOGIN -->
        <main class="login-form-panel">
            <div class="login-form-content">

                <div class="mobile-brand">
                    <i class="bi bi-calendar2-check"></i>
                    <span>Absensi App</span>
                </div>

                <div class="login-heading">
                    <div class="login-icon">
                        <i class="bi bi-person-lock"></i>
                    </div>
                    <h2>Login Sistem</h2>
                    <p>Silakan masuk untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 small py-2" role="alert">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="login-label">
                            Alamat Email
                        </label>

                        <div class="login-input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email Anda"
                                value="{{ old('email') }}"
                                autocomplete="username"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="login-label">
                            Kata Sandi
                        </label>

                        <div class="login-input-wrap">
                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="btn-toggle-eye"
                                id="togglePassword"
                                aria-label="Tampilkan kata sandi"
                                aria-pressed="false"
                            >
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-arrow-right-circle me-2"></i>
                        Masuk ke Sistem
                    </button>
                </form>

                <div class="login-help">
                    Butuh bantuan untuk masuk?<br>
                    Hubungi administrator sistem.
                </div>

                <div class="login-footer">
                    <i class="bi bi-shield-lock me-1"></i>
                    &copy; {{ date('Y') }} Sistem Absensi Digital
                </div>
            </div>
        </main>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const showPassword = passwordInput.type === 'password';

                passwordInput.type = showPassword ? 'text' : 'password';

                eyeIcon.className = showPassword
                    ? 'bi bi-eye'
                    : 'bi bi-eye-slash';

                togglePassword.setAttribute(
                    'aria-label',
                    showPassword
                        ? 'Sembunyikan kata sandi'
                        : 'Tampilkan kata sandi'
                );

                togglePassword.setAttribute(
                    'aria-pressed',
                    showPassword ? 'true' : 'false'
                );
            });
        }
    });
</script>
@endsection
