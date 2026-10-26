<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Timetrix</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --blue: #2047B8;
            --blue-dark: #153783;
            --cyan: #13B9C7;
            --background: #F2F6FC;
            --muted: #7186A7;
            --border: #D7E3F5;
        }

        /* Kunci HTML & Body agar tidak ada scrollbar keseluruhan */
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--blue-dark);
            background: var(--background);
        }

        a {
            text-decoration: none;
        }

        /* LOGO TIMETRIX */
        .logo {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            display: block;
        }

        .navbar {
            height: 64px;
            padding: 0 4%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(25, 61, 115, .06);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--blue-dark);
            font-size: 22px;
            font-weight: 800;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            padding: 8px 16px;
            border: 1px solid var(--blue);
            border-radius: 8px;
            color: var(--blue);
            font-size: 12px;
            font-weight: 650;
        }

        .nav-btn.primary {
            background: var(--blue);
            color: white;
        }

        /* LAYOUT UTAMA - Menyesuaikan tinggi layar dikurangi navbar */
        .page {
            height: calc(100vh - 64px);
            padding: 16px 4%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: 
                radial-gradient(circle at 5% 95%, #DCEAFF, transparent 27%),
                radial-gradient(circle at 95% 5%, #E1EDFF, transparent 27%),
                var(--background);
        }

        .card {
            width: 100%;
            max-width: 900px;
            height: 100%;
            max-height: 560px; /* Batasi tinggi maksimal agar kompak */
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border: 1px solid #E0E9F7;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(30, 70, 130, .1);
        }

        /* PANEL KIRI */
        .left {
            position: relative;
            overflow: hidden;
            padding: 24px 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(
                145deg,
                #E7F0FF,
                #D0E2FF 65%,
                #BBD5FF
            );
        }

        .left::before {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            top: -100px;
            right: -40px;
            border-radius: 50%;
            background: rgba(32, 71, 184, .08);
        }

        .left > * {
            position: relative;
            z-index: 1;
        }

        .left-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--blue-dark);
            font-size: 22px;
            font-weight: 800;
        }

        .left-brand .logo {
            width: 44px;
            height: 44px;
        }

        .title {
            margin: 0 0 8px;
            font-size: clamp(24px, 2.5vw, 32px);
            line-height: 1.15;
            letter-spacing: -.5px;
            color: var(--blue-dark);
        }

        .title span {
            color: var(--blue);
        }

        .description {
            max-width: 380px;
            margin: 0 0 14px;
            color: #536F9B;
            font-size: 13px;
            line-height: 1.5;
        }

        .features-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(255,255,255,.72);
            color: var(--blue);
        }

        .feature-icon svg {
            width: 18px;
            height: 18px;
        }

        .feature strong {
            display: block;
            margin-bottom: 2px;
            font-size: 12px;
        }

        .feature p {
            margin: 0;
            color: #607AA2;
            font-size: 11px;
        }

        .illustration {
            display: none; /* Disembunyikan pada ukuran standar agar card ringkas dan pas */
        }

        .copyright {
            color: #536F9B;
            font-size: 10px;
        }

        /* PANEL LOGIN */
        .right {
            padding: 24px clamp(20px, 5%, 50px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            overflow-y: auto;
        }

        .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-heading .logo {
            width: 50px;
            height: 50px;
            margin: 0 auto 4px;
        }

        .form-heading h1 {
            margin: 4px 0 4px;
            color: var(--blue-dark);
            font-size: 22px;
            letter-spacing: -.5px;
        }

        .form-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .alert {
            padding: 10px 12px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: #FFF0F1;
            border: 1px solid #FFDBDF;
            color: #B42332;
            font-size: 11px;
            line-height: 1.4;
        }

        .alert.success {
            background: #ECF9F0;
            border-color: #C8EED4;
            color: #187647;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            color: #203D72;
            font-size: 12px;
            font-weight: 650;
        }

        .input-box {
            height: 44px;
            padding: 0 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            border-radius: 9px;
            transition: .2s;
        }

        .input-box:focus-within {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(32,71,184,.09);
        }

        .input-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: #7794C1;
        }

        .input-box input {
            width: 100%;
            min-width: 0;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: var(--blue-dark);
            font-size: 12px;
        }

        .input-box input::placeholder {
            color: #91A5C4;
        }

        .toggle-password {
            padding: 4px;
            border: none;
            background: transparent;
            color: #7794C1;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 9px;
            background: linear-gradient(100deg, #286CE2, #2047B8);
            color: white;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(32,71,184,.2);
            transition: .2s;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(32,71,184,.25);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 14px 0;
            color: #8296B7;
            font-size: 11px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #E3EAF4;
        }

        .register {
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 9px;
            color: #7186A8;
            font-size: 11px;
            text-align: center;
        }

        .register a {
            color: var(--blue);
            font-weight: 700;
        }

        .footer {
            margin-top: 14px;
            color: #7F94B5;
            font-size: 10px;
            line-height: 1.5;
            text-align: center;
        }

        @media (max-width: 850px) {
            html, body {
                overflow: auto; /* Mengizinkan scroll di mobile */
            }
            .page {
                height: auto;
                padding: 16px;
            }
            .card {
                max-width: 500px;
                max-height: none;
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@php
    $logoTimetrix = '
    <svg class="logo"
         viewBox="0 0 100 100"
         xmlns="http://www.w3.org/2000/svg"
         role="img"
         aria-label="Logo Timetrix">
        <circle cx="43" cy="42" r="32" fill="white" stroke="#2047B8" stroke-width="8"/>
        <path d="M43 23 V42 L59 30" fill="none" stroke="#2047B8" stroke-width="5.5" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M10 53 L31 53 L46 70 L91 13 L52 79 L44 91 L25 66 Z" fill="#13B9C7" stroke="white" stroke-width="2.5" stroke-linejoin="round"/>
    </svg>';
@endphp

<header class="navbar">
    <a href="{{ url('/') }}" class="brand">
        {!! $logoTimetrix !!}
        <span>Timetrix</span>
    </a>

    <div class="nav-actions">
        <a href="{{ route('login') }}" class="nav-btn">Sign In</a>
        @if (\Illuminate\Support\Facades\Route::has('register'))
            <a href="{{ route('register') }}" class="nav-btn primary">Sign Up</a>
        @else
            <a href="#login-form" class="nav-btn primary">Masuk</a>
        @endif
    </div>
</header>

<main class="page">
    <section class="card">

        <!-- PANEL KIRI -->
        <div class="left">
            <div class="left-brand">
                {!! $logoTimetrix !!}
                <span>Timetrix</span>
            </div>

            <div>
                <h1 class="title">
                    Kelola Kehadiran,<br>
                    Lebih Mudah &<br>
                    <span>Efisien.</span>
                </h1>

                <p class="description">
                    Sistem absensi digital yang membantu pengelolaan kehadiran menjadi lebih praktis, cepat, dan terorganisir.
                </p>

                <div class="features-wrapper">
                    <div class="feature">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/><path d="M12 7 V12 L16 14"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Praktis & Cepat</strong>
                            <p>Absensi cukup dengan beberapa klik.</p>
                        </div>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 3 L20 6 V11 C20 16 16.5 19 12 21 C7.5 19 4 16 4 11 V6 Z"/>
                                <path d="M8 12 L11 15 L16 9"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Aman & Terpercaya</strong>
                            <p>Data kehadiran tersimpan dengan aman.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="copyright">
                © {{ date('Y') }} Timetrix. All rights reserved.
            </div>
        </div>

        <!-- PANEL KANAN -->
        <div class="right" id="login-form">
            <div class="form-heading">
                {!! $logoTimetrix !!}
                <h1>Selamat Datang</h1>
                <p>Silakan masuk untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <div class="input-box">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M4 7 L12 13 L20 7"/>
                        </svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" autocomplete="email" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <div class="input-box">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="10" width="14" height="11" rx="2"/>
                            <path d="M8 10 V7 A4 4 0 0 1 16 7 V10"/>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan kata sandi">◉</button>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    ➜ &nbsp; Masuk ke Sistem
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="register">
                Belum punya akun?
                @if (\Illuminate\Support\Facades\Route::has('register'))
                    <a href="{{ route('register') }}">Daftar sekarang ›</a>
                @else
                    <span>Hubungi administrator untuk membuat akun.</span>
                @endif
            </div>

            <div class="footer">
                Akses hanya untuk pengguna resmi<br>
                © {{ date('Y') }} Timetrix. Sistem Absensi Digital
            </div>
        </div>
    </section>
</main>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const show = passwordInput.type === 'password';
            passwordInput.type = show ? 'text' : 'password';
            this.textContent = show ? '◎' : '◉';
            this.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    }
</script>

</body>
</html>