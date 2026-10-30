<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
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
            z-index: 1050;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0,0,0,0.03);
            border-right: 1px solid #bae6fd;
        }

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

        /* Style saat di halaman pengaturan (sidebar & topbar hilang) */
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

        @media (max-width: 991px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.show-mobile { left: 0; }
            .main-content { margin-left: 0; padding: 15px; }
            .main-content.full-screen { padding: 15px; }
            .sidebar-overlay {
                display: none; position: fixed; top: 0; left: 0;
                width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.5);
                z-index: 1040; backdrop-filter: blur(2px); opacity: 0; transition: opacity 0.3s ease;
            }
            .sidebar-overlay.show { display: block; opacity: 1; }
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

            @if(Auth::user()->role === 'user')
                <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
                <li><a href="{{ url('/absensi') }}" class="{{ request()->is('absensi') ? 'active' : '' }}"><i class="bi bi-calendar2-check"></i> Isi Absensi</a></li>
                <li><a href="{{ url('/absensi/riwayat') }}" class="{{ request()->is('absensi/riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat Absensi</a></li>
                <li><a href="{{ url('/jurnal') }}" class="{{ request()->is('jurnal') ? 'active' : '' }}"><i class="bi bi-journal-text"></i> Jurnal Harian PKL</a></li>
                <li><a href="{{ url('/izin') }}" class="{{ request()->is('izin') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Pengajuan Izin</a></li>
            @endif

            @if(Auth::user()->role === 'guru')
                <li><a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Guru</a></li>
                <li><a href="{{ route('guru.jurnal') }}" class="{{ request()->routeIs('guru.jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Nilai Jurnal Siswa</a></li>
                <li><a href="{{ route('guru.izin') }}" class="{{ request()->routeIs('guru.izin*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Laporan Absensi & Izin</a></li>
                
                <!-- MENU ALASAN KETERLAMBATAN GURU -->
                <li><a href="{{ route('guru.alasan-keterlambatan') }}" class="{{ request()->routeIs('guru.alasan-keterlambatan') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Alasan Keterlambatan</a></li>
                
                <li><a href="{{ route('qr.show') }}" class="{{ request()->routeIs('qr.show') ? 'active' : '' }}"><i class="bi bi-qr-code"></i> Tampilkan QR Absensi</a></li>
            @endif

            @if(Auth::user()->role === 'pembimbing')
                <li><a href="{{ route('pembimbing.dashboard') }}" class="{{ request()->routeIs('pembimbing.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard Pembimbing</a></li>
                <li><a href="{{ route('pembimbing.jurnal') }}" class="{{ request()->routeIs('pembimbing.jurnal') ? 'active' : '' }}"><i class="bi bi-journal-check"></i> Nilai Jurnal Siswa</a></li>
                <li>
                    <a href="{{ route('pembimbing.laporan-absensi') }}"
                       class="{{ request()->routeIs('pembimbing.laporan-absensi') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> Laporan Absensi
                    </a>
                </li>

                <li>
                    <a href="{{ url('/pembimbing/alasan-keterlambatan') }}"
                       class="{{ request()->is('pembimbing/alasan-keterlambatan*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Alasan Keterlambatan
                    </a>
                </li>

                <li>
                    <a href="{{ route('pembimbing.izin') }}"
                       class="{{ request()->routeIs('pembimbing.izin*') ? 'active' : '' }}">
                        <i class="bi bi-envelope-paper"></i> Daftar Izin Siswa
                    </a>
                </li>

                <li>
                    <a href="{{ route('qr.show') }}"
                       class="{{ request()->routeIs('qr.show') ? 'active' : '' }}">
                        <i class="bi bi-qr-code"></i> Tampilkan QR Absensi
                    </a>
                </li>
            @endif

            @if(Auth::user()->role === 'admin')
                <li><a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
            @endif

            <!-- MENU PENGATURAN -->
            <li class="menu-label mt-4">Pengaturan</li>
            
            @if (Auth::user()->role === 'admin')
                <li><a href="{{ url('/admin/setting') }}" class="{{ request()->is('admin/setting') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan Jam</a></li>
            @else
                <li><a href="{{ route('pengaturan') }}" class="{{ request()->is('pengaturan') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan Profil</a></li>
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
                <button class="btn-toggle-sidebar me-3" id="toggleSidebar">
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
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.toggle('show-mobile');
                        overlay.classList.toggle('show');
                    } else {
                        sidebar.classList.toggle('collapsed');
                        mainContent.classList.toggle('expanded');
                        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show-mobile');
                    overlay.classList.remove('show');
                });
            }

            if (window.innerWidth >= 992 && localStorage.getItem('sidebarCollapsed') === 'true') {
                if (sidebar) sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        });
    </script>
</body>
</html>