{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Istanbul - Admin | @yield('title')</title>

    <!-- Bootstrap 5 -->
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
            background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf1 100%);
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            font-size: 24px;
            font-weight: 800;
        }

        .sidebar-logo span {
            color: #f39c12;
        }

        .sidebar-logo small {
            font-size: 10px;
            display: block;
            color: rgba(255,255,255,0.6);
            margin-top: 5px;
        }

        .sidebar-user {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 24px;
            font-weight: 700;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
        }

        .sidebar-nav {
            padding: 20px 15px;
        }

        .nav-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.4);
            padding: 0 15px;
            margin-bottom: 15px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link i {
            width: 22px;
            font-size: 16px;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(231, 76, 60, 0.8);
            color: white;
        }

        /* ========== MAIN CONTENT ========== */
        .admin-main {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
        }

        /* ========== TOP BAR ========== */
        .top-bar {
            background: white;
            border-radius: 20px;
            padding: 12px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #1a1a2e;
        }

        .page-title p {
            font-size: 12px;
            margin: 0;
            color: #6c757d;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-badge {
            background: #f8f9fa;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Scrollbar */
        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #f39c12;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span>Istanbul</span>
                <small>Administration</small>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Administrateur' }}</div>
            <div class="user-role">Super Administrateur</div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-title">Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Rôles
            </a>
            <a href="{{ route('admin.logs') }}" class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Logs système
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" style="background: none; border: none; width: 100%; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="admin-main">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Aperçu général de votre restaurant')</p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>