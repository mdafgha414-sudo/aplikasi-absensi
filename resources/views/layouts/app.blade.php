<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetrix</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            /* Warna Baru: Navy Blue Elegan */
            --sidebar-bg: #1e293b; 
            --sidebar-hover: #334155;
            --sidebar-active: #3b82f6;
            --text-muted-light: #94a3b8;
            --sidebar-width: 260px;
        }

        body { 
            background-color: #f1f5f9; /* Background abu-abu kebiruan yang lebih bersih */
            overflow-x: hidden; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* --- STYLING SIDEBAR (Desktop) --- */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            padding-top: 20px;
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        .sidebar.collapsed {
            left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-brand {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            padding: 0 25px 25px 25px;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 15px;
        }
        .sidebar-brand i { color: #38bdf8; font-size: 28px; margin-right: 12px; }
        .sidebar-brand span { font-size: 12px; font-weight: 400; color: var(--text-muted-light); display: block; margin-top: -5px; letter-spacing: 0.5px; }

        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; }
        .sidebar-menu .menu-label { font-size: 11px; text-transform: uppercase; color: var(--text-muted-light); padding: 15px 10px 5px 10px; font-weight: 700; letter-spacing: 1px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 15px; color: #cbd5e1; text-decoration: none; font-weight: 500; font-size: 14px; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s; }
        .sidebar-menu li a i { margin-right: 12px; font-size: 18px; width: 24px; text-align: center; }
        .sidebar-menu li a:hover { background-color: var(--sidebar-hover); color: #ffffff; }
        .sidebar-menu li a.active { background-color: var(--sidebar-active); color: #ffffff; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3); }
        
        .logout-btn { color: #f87171 !important; font-weight: 600 !important; }
        .logout-btn:hover { background-color: rgba(248, 113, 113, 0.1) !important; }

        /* --- STYLING KONTEN UTAMA (Desktop) --- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* --- STYLING TOPBAR --- */
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

        .btn-toggle-sidebar {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            border-radius: 8px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .btn-toggle-sidebar:hover { background-color: #f8fafc; }

        /* ========================================= */
        /* --- PERBAIKAN UNTUK MOBILE (OFFCANVAS) --- */
        /* ========================================= */
        @media (max-width: 991px) {
            /* Di HP, sidebar disembunyikan ke kiri secara default */
            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }
            
            /* Saat tombol diklik (class collapsed dihapus), sidebar meluncur masuk */
            .sidebar.show-mobile {
                left: 0;
            }

            /* Konten utama di HP tidak memiliki margin kiri */
            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            /* Background gelap transparan di belakang sidebar saat terbuka */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(15, 23, 42, 0.6);
                z-index: 1040;
                backdrop-filter: blur(2px);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <!-- OVERLAY GELAP (Hanya muncul di HP saat sidebar terbuka) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ========================================== -->
    <!-- SIDEBAR                                    -->
    <!-- ========================================== -->
    @auth
    <nav class="sidebar" id="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-clipboard-check"></i>
            <div>
                Timetrix
                <span>Academic Portal</span>
            </div>
        </a>

        <ul class="sidebar-menu">
            <li class="menu-label">Menu Utama</li>

            <!-- Menu USER (Siswa) -->
            @if(Auth::user()->role === 'user')
                <li><a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
                <li><a href="/absensi" class="{{ request()->is('absensi') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Isi Absensi</a></li>
                <li><a href="/absensi/riwayat" class="{{ request()->is('absensi/riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Absensi</a></li>
                <li><a href="/jurnal" class="{{ request()->is('jurnal') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Jurnal Harian PKL</a></li>
                <li><a href="/izin" class="{{ request()->is('izin') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Pengajuan Izin</a></li>
            @endif

            <!-- Menu GURU -->
            @if(Auth::user()->role === 'guru')
                <li><a href="/guru/dashboard" class="{{ request()->is('guru/dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Guru</a></li>
                <li><a href="/guru/jurnal" class="{{ request()->is('guru/jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Nilai Jurnal Siswa</a></li>

                  <!-- TAMBAHKAN MENU INI -->
    <li><a href="/guru/izin" class="{{ request()->is('guru/izin') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Daftar Izin Siswa</a></li>
            @endif

            <!-- Menu ADMIN -->
            @if(Auth::user()->role === 'admin')
                <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
            @endif

            <!-- Bagian Bawah Sidebar -->
            <li class="menu-label mt-4">Pengaturan</li>
            <li><a href="/admin/setting" class="{{ request()->is('admin/setting') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan</a></li>
            
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
    @endauth

    <!-- ========================================== -->
    <!-- KONTEN UTAMA                               -->
    <!-- ========================================== -->
    <div class="main-content" id="main-content">
        
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="d-flex align-items-center">
                <!-- TOMBOL HAMBURGER (Hanya muncul jika sudah login) -->
                @auth
                <button class="btn-toggle-sidebar me-3" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 fw-bold text-dark d-none d-sm-block">Dashboard</h5>
                @endauth
            </div>
            
            <div class="d-flex align-items-center">
                @if(Auth::check())
                    <span class="me-3 fw-bold text-muted d-none d-sm-inline" style="font-size: 14px;">Halo, {{ Auth::user()->name }}</span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Tempat konten dinamis -->
        @yield('content') 
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script JavaScript untuk Toggle Sidebar (Responsive) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebarOverlay');

            // Cek lebar layar
            const isMobile = window.innerWidth < 992;

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        // --- LOGIKA UNTUK MOBILE ---
                        sidebar.classList.toggle('show-mobile');
                        overlay.classList.toggle('show');
                    } else {
                        // --- LOGIKA UNTUK DESKTOP ---
                        sidebar.classList.toggle('collapsed');
                        mainContent.classList.toggle('expanded');
                        
                        // Simpan status ke localStorage (Hanya untuk desktop)
                        if (sidebar.classList.contains('collapsed')) {
                            localStorage.setItem('sidebarCollapsed', 'true');
                        } else {
                            localStorage.setItem('sidebarCollapsed', 'false');
                        }
                    }
                });
            }

            // Tutup sidebar jika overlay diklik (di mobile)
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show-mobile');
                    overlay.classList.remove('show');
                });
            }

            // Cek status sidebar saat halaman dimuat (khusus desktop)
            if (window.innerWidth >= 992) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed && sidebar) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            }
        });
    </script>
</body>
</html>