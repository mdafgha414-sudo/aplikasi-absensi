<!DOCTYPE html>
<html lang="id">
<head>
  <!--  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-bg: #e0f2fe;
            --sidebar-hover: #bae6fd;
            --sidebar-active: #0284c7; 
            --text-main: #0f172a; 
            --text-muted: #334155;
            --sidebar-width: 260px;
        }

        body { 
            background-color: #f8fafc; 
            overflow-x: hidden; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            padding-top: 20px;
            /* TAMBAHAN: Memberi ruang kosong di bawah agar Logout tidak mepet */
            padding-bottom: 40px; 
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.03);
            border-right: 1px solid #bae6fd;
        }

        /* --- PERBAIKAN SCROLLBAR (DISEMBUNYIKAN TOTAL) --- */
        .sidebar::-webkit-scrollbar {
            display: none; /* Sembunyikan scrollbar di Chrome, Safari, Edge */
        }
        .sidebar {
            -ms-overflow-style: none;  /* Sembunyikan scrollbar di IE dan Edge lama */
            scrollbar-width: none;  /* Sembunyikan scrollbar di Firefox */
        }
        /* ------------------------------------------------ */

        .sidebar.collapsed { left: calc(-1 * var(--sidebar-width)); }

        .sidebar-brand {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-main);
            padding: 0 25px 25px 25px;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-bottom: 1px solid #bae6fd;
            margin-bottom: 15px;
        }
        .sidebar-brand i { color: var(--sidebar-active); font-size: 28px; margin-right: 12px; }
        .sidebar-brand span { font-size: 12px; font-weight: 500; color: var(--text-muted); display: block; margin-top: -5px; letter-spacing: 0.5px; }

        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; }
        .sidebar-menu .menu-label { font-size: 11px; text-transform: uppercase; color: #64748b; padding: 15px 10px 5px 10px; font-weight: 700; letter-spacing: 1px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 15px; color: var(--text-main); text-decoration: none; font-weight: 500; font-size: 14px; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s; }
        .sidebar-menu li a i { margin-right: 12px; font-size: 18px; width: 24px; text-align: center; color: #64748b; }
        .sidebar-menu li a:hover { background-color: var(--sidebar-hover); color: var(--text-main); }
        .sidebar-menu li a:hover i { color: var(--text-main); }
        
        .sidebar-menu li a.active { 
            background-color: var(--sidebar-active); 
            color: #ffffff; 
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.2); 
        }
        .sidebar-menu li a.active i { color: #ffffff; }
        
        .logout-btn { color: #dc2626 !important; font-weight: 600 !important; }
        .logout-btn i { color: #dc2626 !important; }
        .logout-btn:hover { background-color: #fecaca !important; }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .main-content.expanded { margin-left: 0; }

        .main-content.full-screen {
            margin-left: 0;
            padding: 30px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        /* =========================================
        TOMBOL HAMBURGER SIDEBAR
        Tombol untuk membuka dan menutup sidebar.
        Tetap terlihat selama topbar ditampilkan.
        ========================================= */

        .btn-toggle-sidebar {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #1e293b;

            /* Ukuran tombol agar nyaman diklik */
            width: 42px;
            height: 42px;
            border-radius: 8px;

            /* Memposisikan ikon tepat di tengah */
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            cursor: pointer;

            transition: background-color 0.2s ease,
                        border-color 0.2s ease,
                        color 0.2s ease;

            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        /* Efek ketika tombol disentuh atau diarahkan mouse */
        .btn-toggle-sidebar:hover {
            background-color: #f0f9ff;
            border-color: #bae6fd;
            color: #0284c7;
        }

        /* Efek ketika tombol sedang ditekan */
        .btn-toggle-sidebar:active {
            transform: scale(0.96);
        }

        /* Fokus keyboard untuk aksesibilitas */
        .btn-toggle-sidebar:focus-visible {
            outline: 3px solid rgba(2, 132, 199, 0.3);
            outline-offset: 3px;
        }

        /* =========================================
        RESPONSIVE SIDEBAR
        Mengatur sidebar pada layar tablet dan HP.
        ========================================= */

        @media (max-width: 991px) {

            /* Sidebar disembunyikan di luar layar */
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
                width: var(--sidebar-width);
                z-index: 1050;
            }

            /* Sidebar muncul ketika tombol hamburger diklik */
            .sidebar.show-mobile {
                left: 0;
            }

            /* Konten memenuhi layar tanpa ruang sidebar */
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            /* Padding khusus halaman full-screen */
            .main-content.full-screen {
                padding: 15px;
            }

            /* =====================================
            OVERLAY SIDEBAR MOBILE
            Lapisan gelap di belakang sidebar.
            ===================================== */

            .sidebar-overlay {
                display: none;

                position: fixed;
                top: 0;
                left: 0;

                width: 100vw;
                height: 100vh;

                background: rgba(15, 23, 42, 0.5);
                backdrop-filter: blur(2px);

                z-index: 1040;

                opacity: 0;
                transition: opacity 0.3s ease;
            }

            /* Overlay aktif ketika sidebar dibuka */
            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @auth
    {{-- SEMBUNYIKAN SIDEBAR UTAMA JIKA DI HALAMAN PENGATURAN --}}
    @if(!request()->is('pengaturan*'))
    <nav class="sidebar" id="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-clipboard-check"></i>
            <div>
                Timetrix
                <span>Attendance System</span>
            </div>
        </a>

        <ul class="sidebar-menu">
            <li class="menu-label">Menu Utama</li>

            {{-- MENU SISWA --}}
            @if(Auth::user()->role === 'user')
                <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
                <li><a href="{{ url('/absensi') }}" class="{{ request()->is('absensi') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Isi Absensi</a></li>
                <li><a href="{{ url('/absensi/riwayat') }}" class="{{ request()->is('absensi/riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Absensi</a></li>
                <li><a href="{{ url('/jurnal') }}" class="{{ request()->is('jurnal') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Jurnal Harian PKL</a></li>
                <li><a href="{{ url('/izin') }}" class="{{ request()->is('izin') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Pengajuan Izin</a></li>
            @endif

            {{-- MENU GURU --}}
            @if(Auth::user()->role === 'guru')
                <li><a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Guru</a></li>
                <li><a href="{{ route('guru.jurnal') }}" class="{{ request()->routeIs('guru.jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Lihat Jurnal Siswa</a></li>
                <li><a href="{{ route('guru.izin') }}" class="{{ request()->routeIs('guru.izin*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Laporan Absensi & Izin</a></li>
                <li><a href="{{ route('guru.alasan-keterlambatan') }}" class="{{ request()->routeIs('guru.alasan-keterlambatan') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Alasan Keterlambatan</a></li>
            @endif

            {{-- MENU PEMBIMBING --}}
            @if(Auth::user()->role === 'pembimbing')
                <li><a href="{{ route('pembimbing.dashboard') }}" class="{{ request()->routeIs('pembimbing.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Pembimbing</a></li>
                
                <li>
                    <a href="{{ route('pembimbing.scan.index') }}" class="{{ request()->routeIs('pembimbing.scan*') ? 'active' : '' }}">
                        <i class="bi bi-qr-code-scan"></i> Scan Kartu Siswa
                    </a>
                </li>

                <li>
                    <a href="{{ route('qr.index') }}" class="{{ request()->routeIs('qr.*') ? 'active' : '' }}">
                        <i class="bi bi-printer"></i> Buat Kode QR Siswa
                    </a>
                </li>

                <li><a href="{{ route('pembimbing.jurnal') }}" class="{{ request()->routeIs('pembimbing.jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Nilai Jurnal Siswa</a></li>
                
                <li><a href="{{ route('pembimbing.laporan-absensi') }}" class="{{ request()->routeIs('pembimbing.laporan-absensi') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Laporan Absensi</a></li>
                
                <li><a href="{{ route('pembimbing.izin') }}" class="{{ request()->routeIs('pembimbing.izin*') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Daftar Izin Siswa</a></li>

                <li><a href="{{ route('pembimbing.keterlambatan.index') }}" class="{{ request()->routeIs('pembimbing.keterlambatan.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Keterlambatan Siswa</a></li>
            @endif

            {{-- MENU ADMIN --}}
            @if(Auth::user()->role === 'admin')
                <li><a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
                <li>
                    <a href="{{ route('qr.index') }}" class="{{ request()->routeIs('qr.*') ? 'active' : '' }}">
                        <i class="bi bi-printer"></i> Cetak Kartu QR Siswa
                    </a>
                </li>
                              <!-- TAMBAHKAN MENU INI -->
                <li>
                    <a href="{{ route('admin.sekolah.index') }}" class="{{ request()->routeIs('admin.sekolah.*') ? 'active' : '' }}">
                        <i class="bi bi-building"></i> Manajemen Sekolah
                    </a>
                </li>
            @endif

            <!-- MENU PENGATURAN -->
            <li class="menu-label mt-4">Pengaturan</li>
            
            @if (Auth::user()->role === 'admin')
                <li><a href="{{ url('/admin/setting') }}" class="{{ request()->is('admin/setting') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan Jam</a></li>
            @else
                <li><a href="{{ route('pengaturan') }}" class="{{ request()->is('pengaturan') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan</a></li>
            @endif
         
            <li>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn w-100 text-start sidebar-menu-btn logout-btn" style="border: none; background: transparent; padding: 12px 15px; border-radius: 8px; display: flex; align-items: center;">
                        <i class="bi bi-box-arrow-right me-2" style="font-size: 18px; width: 24px;"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    @endif
    @endauth

    {{-- KONTEN UTAMA --}}
    <div class="main-content {{ request()->is('pengaturan*') ? 'full-screen' : '' }}" id="main-content">
        
        {{-- SEMBUNYIKAN TOPBAR JIKA DI HALAMAN PENGATURAN --}}
        @if(!request()->is('pengaturan*'))
        <div class="topbar">
            <div class="d-flex align-items-center">
                @auth
                {{-- =========================================
                TOMBOL HAMBURGER SIDEBAR
                Membuka dan menutup menu navigasi.
                Tampil pada halaman yang menggunakan topbar.
                ========================================= --}}

            <button
                class="btn-toggle-sidebar me-3"
                id="toggleSidebar"
                type="button"
                aria-label="Buka atau tutup menu navigasi"
                aria-controls="sidebar"
                aria-expanded="false">

                {{-- Ikon hamburger dari Bootstrap Icons --}}
                <i class="bi bi-list"></i>

            </button>
                <h5 class="mb-0 fw-bold text-dark d-none d-sm-block">Dashboard</h5>
                @endauth
            </div>
            
            <div class="d-flex align-items-center">
                @if(Auth::check())
                    <span class="me-3 fw-bold text-muted d-none d-sm-inline" style="font-size: 14px;">Halo, {{ Auth::user()->name }}</span>
                    
                    <!-- FOTO PROFIL DI TOPBAR -->
                    <a href="{{ route('pengaturan') }}" title="Buka Pengaturan Profil" class="text-decoration-none">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; overflow: hidden; cursor: pointer; transition: 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                    </a>
                @endif
            </div>
        </div>
        @endif

        @yield('content') 
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
        /* =========================================
        TIMETRIX - SIDEBAR CONTROLLER
        Mengatur buka/tutup sidebar pada laptop,
        tablet, dan HP.
        ========================================= */

        document.addEventListener('DOMContentLoaded', function () {

            // Mengambil elemen yang digunakan untuk sidebar
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebarOverlay');

            // Memastikan elemen sidebar tersedia sebelum menjalankan fungsi
            // Ini mencegah JavaScript error pada halaman tanpa sidebar.
            if (!sidebar || !mainContent) {
                return;
            }

            // Memeriksa apakah perangkat menggunakan tampilan mobile
            function isMobile() {
                return window.innerWidth < 992;
            }

            // =====================================
            // FUNGSI MEMBUKA SIDEBAR MOBILE
            // =====================================

            function openMobileSidebar() {

                // Menampilkan sidebar dari sisi kiri layar
                sidebar.classList.add('show-mobile');

                // Menampilkan overlay gelap di belakang sidebar
                if (overlay) {
                    overlay.classList.add('show');
                }

                // Mengunci scroll halaman ketika sidebar terbuka
                document.body.style.overflow = 'hidden';

                // Memperbarui status tombol hamburger
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', 'true');
                }
            }

            // =====================================
            // FUNGSI MENUTUP SIDEBAR MOBILE
            // =====================================

            function closeMobileSidebar() {

                // Menyembunyikan sidebar dari layar
                sidebar.classList.remove('show-mobile');

                // Menghilangkan overlay
                if (overlay) {
                    overlay.classList.remove('show');
                }

                // Mengembalikan scroll halaman
                document.body.style.overflow = '';

                // Memperbarui status tombol hamburger
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', 'false');
                }
            }

            // =====================================
            // FUNGSI TOGGLE SIDEBAR
            // Dipanggil ketika tombol hamburger diklik.
            // =====================================

            if (toggleBtn) {

                toggleBtn.addEventListener('click', function () {

                    if (isMobile()) {

                        // MOBILE:
                        // Membuka atau menutup sidebar menggunakan overlay.
                        if (sidebar.classList.contains('show-mobile')) {
                            closeMobileSidebar();
                        } else {
                            openMobileSidebar();
                        }

                    } else {

                        // DESKTOP:
                        // Menutup atau membuka sidebar dengan menggeser posisinya.
                        sidebar.classList.toggle('collapsed');

                        // Konten utama menyesuaikan ruang sidebar.
                        mainContent.classList.toggle('expanded');

                        // Menyimpan kondisi sidebar agar tetap sama
                        // ketika halaman dimuat ulang.
                        localStorage.setItem(
                            'sidebarCollapsed',
                            sidebar.classList.contains('collapsed')
                        );
                    }
                });
            }

            // =====================================
            // MENUTUP SIDEBAR KETIKA OVERLAY DIKLIK
            // =====================================

            if (overlay) {

                overlay.addEventListener('click', function () {
                    closeMobileSidebar();
                });
            }

            // =====================================
            // MENUTUP SIDEBAR DENGAN TOMBOL ESC
            // =====================================

            document.addEventListener('keydown', function (event) {

                if (event.key === 'Escape' && isMobile()) {
                    closeMobileSidebar();
                }
            });

            // =====================================
            // MEMULIHKAN KONDISI SIDEBAR DESKTOP
            // =====================================

            if (!isMobile()) {

                // Membaca kondisi sidebar yang tersimpan sebelumnya.
                const savedState = localStorage.getItem('sidebarCollapsed');

                if (savedState === 'true') {

                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');

                } else {

                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }

            // =====================================
            // MENYESUAIKAN SIDEBAR KETIKA UKURAN
            // LAYAR BERUBAH
            // =====================================

            window.addEventListener('resize', function () {

                if (isMobile()) {

                    // Ketika berpindah ke tampilan mobile,
                    // sidebar desktop tidak boleh memengaruhi layout.
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');

                } else {

                    // Ketika kembali ke desktop, sidebar mobile ditutup.
                    closeMobileSidebar();

                    // Mengembalikan kondisi sidebar desktop.
                    const savedState = localStorage.getItem('sidebarCollapsed');

                    if (savedState === 'true') {

                        sidebar.classList.add('collapsed');
                        mainContent.classList.add('expanded');

                    } else {

                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                    }
                }
            });

        });
    </script>
</body>
</html>