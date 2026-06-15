<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Istanbul - Gérant | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf1 100%);
            min-height: 100vh;
        }
        .gerant-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: white;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .sidebar-header { padding: 25px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo { font-size: 24px; font-weight: 800; }
        .sidebar-logo span { color: #10b981; }
        .sidebar-logo small { font-size: 10px; display: block; color: rgba(255,255,255,0.5); margin-top: 5px; }
        .sidebar-user { padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .user-avatar {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 28px;
            font-weight: 700;
        }
        .user-name { font-weight: 700; margin-bottom: 4px; font-size: 16px; }
        .user-role { font-size: 12px; color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.1); display: inline-block; padding: 3px 12px; border-radius: 20px; }
        .sidebar-nav { padding: 20px 15px; }
        .nav-title { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,0.4); padding: 0 15px; margin-bottom: 15px; }
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar-nav .nav-link i { width: 22px; font-size: 16px; }
        .sidebar-nav .nav-link:hover { background: rgba(255,255,255,0.1); color: white; transform: translateX(5px); }
        .sidebar-nav .nav-link.active { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .sidebar-footer { position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); }
        .logout-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .logout-btn:hover { background: rgba(239, 68, 68, 0.8); color: white; }
        .gerant-main { margin-left: 280px; padding: 20px; min-height: 100vh; }
        .top-bar {
            background: white;
            border-radius: 20px;
            padding: 15px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-title h2 { font-size: 18px; font-weight: 700; margin: 0; color: #1e293b; }
        .page-title p { font-size: 12px; margin: 0; color: #64748b; }
        .date-badge { background: #f1f5f9; padding: 8px 16px; border-radius: 40px; font-size: 13px; font-weight: 500; color: #1e293b; }
        @media (max-width: 768px) {
            .gerant-sidebar { transform: translateX(-100%); }
            .gerant-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="gerant-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span>Istanbul</span>
                <small>Espace Gérant</small>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Gérant' }}</div>
            <div class="user-role">
                <i class="fas fa-crown me-1"></i> Gérant
            </div>
        </div>

        <!-- ========================================== -->
        <!-- LIENS AVEC URLS DIRECTES - PLUS DE route() -->
        <!-- ========================================== -->
        <div class="sidebar-nav">
            <div class="nav-title">Menu Principal</div>
            
            <a href="/gerant/dashboard" class="nav-link">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            
            <a href="/gerant/menu" class="nav-link">
                <i class="fas fa-utensils"></i> Gestion du menu
            </a>
            
            <a href="/gerant/categories" class="nav-link">
                <i class="fas fa-tags"></i> Catégories
            </a>
            
            <a href="/gerant/tables" class="nav-link">
                <i class="fas fa-chair"></i> Tables
            </a>
            
            <a href="/gerant/statistiques" class="nav-link">
                <i class="fas fa-chart-line"></i> Statistiques
            </a>
            
            <a href="/gerant/reservations" class="nav-link">
                <i class="fas fa-calendar-check"></i> Réservations
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <div class="gerant-main">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Gérez votre restaurant efficacement')</p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>
        @yield('gerant-content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>