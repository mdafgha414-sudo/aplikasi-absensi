<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Timetrix</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        
        /* Navbar Login */
        .auth-navbar {
            background: #ffffff;
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .auth-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: #1e293b;
            display: flex;
            align-items: center;
        }
        .auth-navbar .navbar-brand i {
            font-size: 1.5rem;
            color: #3b82f6;
            margin-right: 10px;
        }
        .auth-navbar .btn-signin {
            border: 2px solid #3b82f6;
            color: #3b82f6;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 0.9rem;
        }
        .auth-navbar .btn-signin:hover {
            background: #3b82f6;
            color: #fff;
        }
        .auth-navbar .btn-signup {
            background: #3b82f6;
            border: 2px solid #3b82f6;
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 0.9rem;
        }
        .auth-navbar .btn-signup:hover {
            background: #2563eb;
            border-color: #2563eb;
        }

        /* Responsif untuk HP */
        @media (max-width: 576px) {
            .auth-navbar .navbar-brand {
                font-size: 1rem;
            }
            .auth-navbar .btn-signin, 
            .auth-navbar .btn-signup {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR LOGIN (Gunakan Icon, bukan Emoji) -->
    <nav class="auth-navbar navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <!-- Icon SVG Bootstrap Icons -->
                <i class="bi bi-clipboard-check-fill"></i> Timetrix
            </a>
            <div class="d-flex gap-2">
                <a href="/login" class="btn btn-signin">Sign In</a>
                <a href="/register" class="btn btn-signup">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- KONTEN LOGIN -->
    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>