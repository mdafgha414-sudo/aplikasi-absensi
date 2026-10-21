<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-bg: #2a1b54;
            --sidebar-hover: #3d2a72;
            --sidebar-active: #4a3585;
            --text-muted-light: #a89cc8;
            --sidebar-width: 260px;
        }

        body { 
            background-color: #f8f9fa; 
            overflow-x: hidden; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: all 0.3s ease;
        }
        
        /* --- STYLING SIDEBAR --- */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            padding-top: 20px;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
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
        }
        .sidebar-brand i { color: #5ce1e6; font-size: 28px; margin-right: 10px; }
        .sidebar-brand span { font-size: 12px; font-weight: 400; color: var(--text-muted-light); display: block; margin-top: -5px; }

        .sidebar-menu { list-style: none; padding: 0 15px; margin: 0; }
        .sidebar-menu .menu-label { font-size: 11px; text-transform: uppercase; color: var(--text-muted-light); padding: 15px 10px 5px 10px; font-weight: 600; letter-spacing: 1px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 15px; color: #e2e1e9; text-decoration: none; font-weight: 500; font-size: 14px; border-radius: 8px; margin-bottom: 5px; transition: all 0.2s; }
        .sidebar-menu li a i { margin-right: 12px; font-size: 18px; width: 24px; text-align: center; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background-color: var(--sidebar-active); color: #ffffff; }
        
        .logout-btn { color: #ff8a8a !important; }
        .logout-btn:hover { background-color: rgba(255, 138, 138, 0.1) !important; }

        /* --- STYLING KONTEN UTAMA --- */
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
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            margin-bottom: 25px;
        }

        .btn-toggle-sidebar {
            background-color: #f4f6f9;
            border: 1px solid #eaeaea;
            color: #333;
            border-radius: 8px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.2s;
        }
        .btn-toggle-sidebar:hover {
            background-color: #e2e6ea;
        }
    </style>
</head>
<body>

    <!-- ========================================== -->
    <!-- SIDEBAR (Hanya muncul jika sudah login)    -->
    <!-- ========================================== -->
    @auth
    <nav class="sidebar" id="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-clipboard-check"></i>
            <div>
                Absensi App
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
            @endif

            <!-- Menu GURU -->
            @if(Auth::user()->role === 'guru')
                <li><a href="/guru/dashboard" class="{{ request()->is('guru/dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Guru</a></li>
                <li><a href="/guru/jurnal" class="{{ request()->is('guru/jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Nilai Jurnal Siswa</a></li>
            @endif

            <!-- Menu ADMIN -->
            @if(Auth::user()->role === 'admin')
                <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
            @endif

            <!-- Bagian Bawah Sidebar -->
            <li class="menu-label mt-4">Pengaturan</li>
            <li><a href="#"><i class="bi bi-gear"></i> Pengaturan</a></li>
            
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
                {{-- PENGECEKAN AGAR TIDAK ERROR SAAT LOGOUT --}}
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
    
    <!-- Script JavaScript untuk Toggle Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Cek status sidebar dari localStorage (agar tidak reset saat refresh)
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && sidebar) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            // Fungsi saat tombol diklik (cek dulu apakah tombolnya ada)
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');

                    // Simpan status ke localStorage
                    if (sidebar.classList.contains('collapsed')) {
                        localStorage.setItem('sidebarCollapsed', 'true');
                    } else {
                        localStorage.setItem('sidebarCollapsed', 'false');
                    }
                });
            }
        });
    </script>



</body>
</html>