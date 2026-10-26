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

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--blue-dark);
            background: var(--background);
        }

        a {
            text-decoration: none;
        }

        /* LOGO TIMETRIX */
        .logo {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: block;
        }

        .navbar {
            min-height: 76px;
            padding: 0 5%;
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
            font-size: 25px;
            font-weight: 800;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            padding: 11px 19px;
            border: 1px solid var(--blue);
            border-radius: 10px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 650;
        }

        .nav-btn.primary {
            background: var(--blue);
            color: white;
        }

        /* LAYOUT UTAMA */
        .page {
            min-height: calc(100vh - 76px);
            padding: 35px 5%;
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
            max-width: 1180px;
            min-height: 660px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border: 1px solid #E0E9F7;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(30, 70, 130, .11);
        }

        /* PANEL KIRI */
        .left {
            position: relative;
            overflow: hidden;
            padding: 40px 42px 25px;
            display: flex;
            flex-direction: column;
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
            width: 240px;
            height: 240px;
            top: -140px;
            right: -60px;
            border-radius: 50%;
            background: rgba(32, 71, 184, .08);
        }

        .left::after {
            content: "";
            position: absolute;
            width: 200px;
            height: 200px;
            bottom: -135px;
            left: -80px;
            border-radius: 50%;
            background: rgba(19, 185, 199, .12);
        }

        .left > * {
            position: relative;
            z-index: 1;
        }

        .left-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
            color: var(--blue-dark);
            font-size: 28px;
            font-weight: 800;
        }

        .left-brand .logo {
            width: 58px;
            height: 58px;
        }

        .title {
            margin: 0 0 15px;
            font-size: clamp(30px, 3.1vw, 41px);
            line-height: 1.18;
            letter-spacing: -1px;
            color: var(--blue-dark);
        }

        .title span {
            color: var(--blue);
        }

        .description {
            max-width: 420px;
            margin: 0 0 25px;
            color: #536F9B;
            font-size: 14px;
            line-height: 1.9;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-bottom: 16px;
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: rgba(255,255,255,.72);
            color: var(--blue);
        }

        .feature-icon svg {
            width: 23px;
            height: 23px;
        }

        .feature strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .feature p {
            margin: 0;
            color: #607AA2;
            font-size: 12px;
            line-height: 1.6;
        }

        .illustration {
            width: 100%;
            max-width: 410px;
            display: block;
            margin: auto auto 5px;
        }

        .copyright {
            margin-top: 12px;
            color: #536F9B;
            font-size: 11px;
        }

        /* PANEL LOGIN */
        .right {
            padding: 42px clamp(25px, 6.5%, 75px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        .form-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-heading .logo {
            width: 76px;
            height: 76px;
            margin: 0 auto 6px;
        }

        .form-heading h1 {
            margin: 7px 0 9px;
            color: var(--blue-dark);
            font-size: 28px;
            letter-spacing: -.5px;
        }

        .form-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }

        .alert {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 10px;
            background: #FFF0F1;
            border: 1px solid #FFDBDF;
            color: #B42332;
            font-size: 12px;
            line-height: 1.7;
        }

        .alert.success {
            background: #ECF9F0;
            border-color: #C8EED4;
            color: #187647;
        }

        .field {
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 9px;
            color: #203D72;
            font-size: 13px;
            font-weight: 650;
        }

        .input-box {
            height: 54px;
            padding: 0 14px;
            display: flex;
            align-items: center;
            gap: 11px;
            border: 1px solid var(--border);
            border-radius: 11px;
            transition: .2s;
        }

        .input-box:focus-within {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(32,71,184,.09);
        }

        .input-icon {
            width: 20px;
            height: 20px;
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
            font-size: 13px;
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
            font-size: 17px;
        }

        .submit-btn {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(100deg, #286CE2, #2047B8);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(32,71,184,.2);
            transition: .2s;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(32,71,184,.25);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 23px 0;
            color: #8296B7;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #E3EAF4;
        }

        .register {
            padding: 15px 10px;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: #7186A8;
            font-size: 12px;
            text-align: center;
        }

        .register a {
            color: var(--blue);
            font-weight: 700;
        }

        .register a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 25px;
            color: #7F94B5;
            font-size: 11px;
            line-height: 2;
            text-align: center;
        }

        @media (max-width: 850px) {
            .page {
                padding: 24px 14px;
            }

            .card {
                max-width: 550px;
                grid-template-columns: 1fr;
            }

            .left {
                padding: 30px 27px 22px;
            }

            .left-brand {
                margin-bottom: 25px;
            }

            .title {
                font-size: 34px;
            }

            .illustration {
                max-height: 200px;
            }

            .right {
                padding: 38px 27px;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                min-height: 65px;
                padding: 0 13px;
            }

            .brand {
                font-size: 21px;
                gap: 6px;
            }

            .navbar .logo {
                width: 36px;
                height: 36px;
            }

            .nav-actions {
                gap: 6px;
            }

            .nav-btn {
                padding: 9px 11px;
                font-size: 11px;
            }

            .page {
                padding: 14px 10px;
            }

            .card {
                border-radius: 18px;
            }

            .left {
                padding: 25px 21px 20px;
            }

            .left-brand {
                font-size: 24px;
            }

            .left-brand .logo {
                width: 48px;
                height: 48px;
            }

            .title {
                font-size: 30px;
            }

            .description {
                font-size: 13px;
            }

            .right {
                padding: 33px 21px;
            }

            .form-heading h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

@php
    /*
     * Logo Timetrix: jam biru dan satu centang toska.
     * Semua pemakaian logo di halaman menggunakan SVG yang sama.
     */
    $logoTimetrix = '
    <svg class="logo"
         viewBox="0 0 100 100"
         xmlns="http://www.w3.org/2000/svg"
         role="img"
         aria-label="Logo Timetrix">

        <!-- Lingkaran jam biru -->
        <circle
            cx="43"
            cy="42"
            r="32"
            fill="white"
            stroke="#2047B8"
            stroke-width="8"
        />

        <!-- Jarum jam, bukan centang tambahan -->
        <path
            d="M43 23 V42 L59 30"
            fill="none"
            stroke="#2047B8"
            stroke-width="5.5"
            stroke-linecap="round"
            stroke-linejoin="round"
        />

        <!-- Satu centang besar toska -->
        <path
            d="M10 53
               L31 53
               L46 70
               L91 13
               L52 79
               L44 91
               L25 66
               Z"
            fill="#13B9C7"
            stroke="white"
            stroke-width="2.5"
            stroke-linejoin="round"
        />
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

            <h1 class="title">
                Kelola Kehadiran,<br>
                Lebih Mudah &<br>
                <span>Efisien.</span>
            </h1>

            <p class="description">
                Sistem absensi digital yang membantu pengelolaan
                kehadiran menjadi lebih praktis, cepat, dan terorganisir.
            </p>

            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7 V12 L16 14"/>
                    </svg>
                </div>

                <div>
                    <strong>Praktis & Cepat</strong>
                    <p>Absensi cukup dengan beberapa klik.</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M12 3 L20 6 V11 C20 16 16.5 19 12 21 C7.5 19 4 16 4 11 V6 Z"/>
                        <path d="M8 12 L11 15 L16 9"/>
                    </svg>
                </div>

                <div>
                    <strong>Aman & Terpercaya</strong>
                    <p>Data kehadiran tersimpan dengan aman.</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="4" y="12" width="4" height="8" rx="1"/>
                        <rect x="10" y="7" width="4" height="13" rx="1"/>
                        <rect x="16" y="3" width="4" height="17" rx="1"/>
                    </svg>
                </div>

                <div>
                    <strong>Mudah Dipantau</strong>
                    <p>Rekap dan laporan selalu tersedia.</p>
                </div>
            </div>

            <!-- Ilustrasi absensi digital -->
            <svg class="illustration"
                 viewBox="0 0 420 200"
                 xmlns="http://www.w3.org/2000/svg"
                 role="img"
                 aria-label="Ilustrasi absensi digital">

                <ellipse cx="205" cy="184" rx="175" ry="9"
                         fill="#76A9ED" opacity=".35"/>

                <!-- Laptop -->
                <path d="M65 30 Q65 24 72 24 H258 Q265 24 266 31 L282 143 H82 Z"
                      fill="#16448D"/>

                <path d="M74 33 H257 L270 134 H87 Z"
                      fill="#FFFFFF"/>

                <rect x="87" y="42" width="31" height="84" rx="2"
                      fill="#2875E6"/>

                <path d="M94 55 H111 M94 66 H111 M94 77 H111 M94 88 H111 M94 99 H111"
                      stroke="#FFFFFF" stroke-width="3"
                      stroke-linecap="round"/>

                <rect x="126" y="43" width="130" height="12" rx="3"
                      fill="#EAF2FF"/>

                <rect x="126" y="64" width="59" height="17" rx="3"
                      fill="#E5EEFD"/>

                <rect x="192" y="64" width="59" height="17" rx="3"
                      fill="#D6F4F4"/>

                <path d="M132 72 L137 76 L144 68"
                      stroke="#1760D5" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round"/>

                <path d="M198 72 L203 76 L210 68"
                      stroke="#13A8B5" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round"/>

                <path d="M127 91 H252 M127 101 H245 M127 111 H251"
                      stroke="#D1DFF4" stroke-width="4"
                      stroke-linecap="round"/>

                <path d="M49 144 H282 L307 161 Q310 166 301 166 H63 Q55 166 49 159 Z"
                      fill="#5597F1"/>

                <path d="M93 148 H247 L261 158 H105 Z"
                      fill="#D9E8FF"/>

                <!-- Jam -->
                <circle cx="318" cy="49" r="34"
                        fill="#FFFFFF"
                        stroke="#2047B8"
                        stroke-width="6"/>

                <path d="M318 29 V49 L331 40"
                      fill="none"
                      stroke="#2047B8"
                      stroke-width="4"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>

                <!-- Kalender -->
                <rect x="300" y="103" width="58" height="57" rx="7"
                      fill="#FFFFFF"
                      stroke="#9CBDF0"
                      stroke-width="2"/>

                <path d="M300 111 Q300 103 308 103 H350 Q358 103 358 111 V119 H300 Z"
                      fill="#2047B8"/>

                <path d="M314 98 V109 M344 98 V109"
                      stroke="#2047B8"
                      stroke-width="4"
                      stroke-linecap="round"/>

                <path d="M309 132 L313 136 L320 128 M329 132 L333 136 L340 128 M309 147 L313 151 L320 143"
                      fill="none"
                      stroke="#13A8B5"
                      stroke-width="2.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>

                <!-- Tanaman -->
                <path d="M24 162 Q5 140 19 124 Q38 137 29 160"
                      fill="#16A9A7"/>

                <path d="M28 162 Q26 132 46 117 Q55 147 31 164"
                      fill="#21B9AE"/>

                <path d="M15 161 H43 L39 185 H19 Z"
                      fill="#FFFFFF"/>

                <path d="M15 161 H43 L42 167 H16 Z"
                      fill="#C6DCFA"/>

                <!-- Buku -->
                <path d="M276 161 H377 L393 174 H292 Z"
                      fill="#2365C7"/>

                <path d="M292 174 H393 V181 H292 Z"
                      fill="#FFFFFF"/>

                <path d="M287 148 H371 L385 160 H301 Z"
                      fill="#5597F1"/>

                <path d="M301 160 H385 V167 H301 Z"
                      fill="#FFFFFF"/>
            </svg>

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
                        <svg class="input-icon"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M4 7 L12 13 L20 7"/>
                        </svg>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email Anda"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="password">Kata Sandi</label>

                    <div class="input-box">
                        <svg class="input-icon"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <rect x="5" y="10" width="14" height="11" rx="2"/>
                            <path d="M8 10 V7 A4 4 0 0 1 16 7 V10"/>
                        </svg>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan kata sandi"
                        >◉</button>
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

            this.setAttribute(
                'aria-label',
                show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
            );
        });
    }
</script>

</body>
</html>
