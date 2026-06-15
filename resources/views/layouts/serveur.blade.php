<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Istanbul - Serveur | @yield('title')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* ============================================= */
        /* SIDEBAR MODERN DESIGN */
        /* ============================================= */
        .serveur-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 5px 0 30px rgba(0,0,0,0.2);
        }
        
        .sidebar-header { 
            padding: 30px 20px; 
            text-align: center; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        .sidebar-logo { 
            font-size: 28px; 
            font-weight: 800; 
        }
        
        .sidebar-logo span { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .sidebar-logo small { 
            font-size: 10px; 
            display: block; 
            color: rgba(255,255,255,0.6); 
            margin-top: 8px; 
        }

        .sidebar-user { 
            padding: 25px 20px; 
            text-align: center; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
            font-weight: 700;
            border: 3px solid rgba(255,255,255,0.3);
        }
        
        .user-name { 
            font-weight: 700; 
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .user-role { 
            font-size: 12px; 
            color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.1);
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
        }

        .sidebar-nav { 
            padding: 20px 15px; 
        }
        
        .nav-title { 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            color: rgba(255,255,255,0.4); 
            padding: 0 15px; 
            margin-bottom: 15px; 
            font-weight: 600;
        }
        
        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-nav .nav-link i { 
            width: 22px; 
            font-size: 16px; 
        }
        
        .sidebar-nav .nav-link:hover { 
            background: rgba(255,255,255,0.15); 
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar-nav .nav-link.active { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(240,147,251,0.3);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-weight: 500;
        }
        
        .logout-btn:hover { 
            background: linear-gradient(135deg, #f5576c 0%, #fc4a1a 100%);
            color: white;
            transform: translateX(5px);
        }

        /* ============================================= */
        /* MAIN CONTENT */
        /* ============================================= */
        .serveur-main { 
            margin-left: 280px; 
            padding: 25px 30px; 
            min-height: 100vh; 
        }

        /* Top Bar */
        .top-bar {
            background: white;
            border-radius: 20px;
            padding: 15px 25px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .page-title h2 { 
            font-size: 20px; 
            font-weight: 800; 
            margin: 0; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .page-title p { 
            font-size: 12px; 
            margin: 5px 0 0; 
            color: #6c757d; 
        }
        
        .top-bar-right { 
            display: flex; 
            align-items: center; 
            gap: 20px; 
        }
        
        .date-badge-top {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        
        .stats-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }
        
        .stats-icon {
            width: 55px;
            height: 55px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stats-primary .stats-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .stats-warning .stats-icon { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }
        .stats-success .stats-icon { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
        .stats-info .stats-icon { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); color: white; }
        .stats-danger .stats-icon { background: linear-gradient(135deg, #f5576c 0%, #fc4a1a 100%); color: white; }
        
        .stats-number {
            font-size: 32px;
            font-weight: 800;
            color: #2c3e50;
            margin: 10px 0;
        }
        
        .stats-label {
            font-size: 13px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Tables Grid */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
        }
        
        .table-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }
        
        .table-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .table-card.libre {
            border-color: #43e97b;
            background: linear-gradient(135deg, #e8f8f5, #d1f2eb);
        }
        
        .table-card.occupee {
            border-color: #f5576c;
            background: linear-gradient(135deg, #fdedec, #fadbd8);
        }
        
        .table-card.reservee {
            border-color: #fa709a;
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        }
        
        .table-number {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .table-capacite {
            font-size: 12px;
            color: #6c757d;
            margin: 8px 0;
        }

        /* Badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-en_attente { background: #fef3c7; color: #d97706; }
        .status-validee { background: #dbeafe; color: #2563eb; }
        .status-en_preparation { background: #ede9fe; color: #7c3aed; }
        .status-pret { background: #d1fae5; color: #059669; }
        .status-paye { background: #d1fae5; color: #059669; }

        /* Scrollbar */
        .serveur-sidebar::-webkit-scrollbar { width: 5px; }
        .serveur-sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
        .serveur-sidebar::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; }

        @media (max-width: 768px) {
            .serveur-sidebar { transform: translateX(-100%); }
            .serveur-main { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="serveur-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span>Istanbul</span>
                <small>Espace Serveur</small>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Serveur' }}</div>
            <div class="user-role">👨‍🍳 Serveur</div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-title">📋 Navigation</div>
            
            <a href="/serveur/dashboard" class="nav-link {{ request()->is('serveur/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Tableau de bord
            </a>
            
            <a href="/serveur/tables" class="nav-link {{ request()->is('serveur/tables') ? 'active' : '' }}">
                <i class="fas fa-chair"></i> Tables
            </a>
            
            <a href="/serveur/commandes" class="nav-link {{ request()->is('serveur/commandes*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Commandes
            </a>
            
            <!-- NOUVEAU LIEN PAIEMENT -->
            <a href="/serveur/paiement" class="nav-link {{ request()->is('serveur/paiement*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Paiements
            </a>
            
            <a href="/serveur/planning" class="nav-link {{ request()->is('serveur/planning') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Planning
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

    <!-- MAIN CONTENT -->
    <div class="serveur-main">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Gérez les commandes et les tables')</p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge-top">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                    <i class="fas fa-clock ms-2"></i> {{ now()->format('H:i') }}
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('serveur-content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>