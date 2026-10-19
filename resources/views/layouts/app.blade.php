<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Absensi</title>
    <!-- Memanggil Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📋 Absensi App</a>
            <div class="d-flex">
                @auth
                    <span class="navbar-text me-3 text-white">
                        Halo, <strong>{{ Auth::user()->name }}</strong> ({{ ucfirst(Auth::user()->role) }})
                    </span>
                    <form action="/logout" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light text-danger fw-bold">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container">
        <!-- Tempat memasukkan konten dari halaman lain -->
        @yield('content') 
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>