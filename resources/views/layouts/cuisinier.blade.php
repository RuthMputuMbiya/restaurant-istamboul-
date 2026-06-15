{{-- resources/views/layouts/cuisinier.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ISTAMBOUL - Cuisine | @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        /* ========================================== */
        /* NAVBAR MODERNE */
        /* ========================================== */
        .navbar-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: white !important;
        }

        .navbar-brand span {
            color: #f59e0b;
        }

        .navbar-brand small {
            font-size: 0.7rem;
            background: rgba(245,158,11,0.2);
            padding: 4px 10px;
            border-radius: 30px;
            margin-left: 10px;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 20px !important;
            border-radius: 30px;
            margin: 0 3px;
        }

        .nav-link:hover, .nav-link.active {
            color: #f59e0b !important;
            background: rgba(245,158,11,0.1);
        }

        .nav-link i {
            margin-right: 8px;
        }

        /* Zone utilisateur */
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.08);
            padding: 5px 18px 5px 10px;
            border-radius: 50px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            color: white;
        }

        .user-name {
            font-weight: 600;
            color: white;
            font-size: 14px;
        }

        .btn-logout {
            background: rgba(255,255,255,0.1);
            border: none;
            padding: 6px 18px;
            border-radius: 30px;
            color: #f1f5f9;
            transition: all 0.2s;
            font-size: 13px;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            min-height: calc(100vh - 160px);
            padding: 30px;
        }

        /* ========================================== */
        /* FOOTER */
        /* ========================================== */
        .footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #94a3b8;
            padding: 15px 0;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* ========================================== */
        /* ANIMATIONS */
        /* ========================================== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeInUp 0.4s ease-out forwards;
        }

        /* ========================================== */
        /* SCROLLBAR */
        /* ========================================== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #f59e0b; border-radius: 10px; }

        @media (max-width: 768px) {
            .main-content { padding: 15px; }
            .user-name { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ========================================== -->
    <!-- NAVIGATION -->
    <!-- ========================================== -->
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('cuisinier.dashboard') }}">
                <i class="fas fa-utensils me-2"></i> ISTAMBOUL
                <small><i class="fas fa-fire me-1"></i> Cuisine</small>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cuisinier.dashboard') ? 'active' : '' }}" href="{{ route('cuisinier.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <!-- UTILISER UNE URL DIRECTE AU LIEU DE route() -->
                        <a class="nav-link {{ request()->routeIs('cuisinier.commandes*') ? 'active' : '' }}" href="/cuisinier/commandes">
                            <i class="fas fa-clipboard-list"></i> Commandes
                        </a>
                    </li>
                </ul>
                
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
                    </div>
                    <span class="user-name">{{ Auth::user()->name ?? 'Cuisinier' }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Quitter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========================================== -->
    <!-- MAIN CONTENT -->
    <!-- ========================================== -->
    <main class="main-content fade-in">
        @yield('cuisinier-content')
    </main>

    <!-- ========================================== -->
    <!-- FOOTER -->
    <!-- ========================================== -->
    <footer class="footer">
        <div class="container-fluid px-4">
            <p class="mb-0">
                <i class="fas fa-copyright me-1"></i> {{ date('Y') }} Restaurant ISTAMBOUL - Tous droits réservés
            </p>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- SCRIPTS -->
    <!-- ========================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>