<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Restaurant Istanbul') - Espace Client</title>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @stack('styles')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1a1a2e;
            line-height: 1.5;
            overflow-x: hidden;
        }
        
        :root {
            --primary: #f59e0b;
            --primary-dark: #d97706;
            --success: #10b981;
            --danger: #ef4444;
            --gray: #64748b;
            --border: #eef2f6;
        }
        
        .client-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--border);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .logo-text {
            font-size: 1.3rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .logo-sub {
            font-size: 0.7rem;
            color: var(--gray);
            display: block;
        }
        
        .nav-menu {
            flex: 1;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            color: var(--gray);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .nav-item i {
            width: 22px;
        }
        
        .nav-item:hover {
            background: #fffbeb;
            color: var(--primary);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        
        .nav-divider {
            height: 1px;
            background: var(--border);
            margin: 0.5rem 0;
        }
        
        .nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--gray);
            padding: 0.5rem 1rem;
            font-weight: 600;
        }
        
        /* Badge panier dans sidebar */
        .badge-panier {
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }
        
        .sidebar-footer {
            padding: 1rem 1.5rem 1.5rem;
            border-top: 1px solid var(--border);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }
        
        .user-name {
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        .user-email {
            font-size: 0.7rem;
            color: var(--gray);
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 0.7rem;
            background: #fee2e2;
            color: var(--danger);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: var(--danger);
            color: white;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }
        
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
        }
        
        .top-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        /* Icône panier header */
        .cart-icon {
            position: relative;
            color: var(--gray);
            font-size: 1.2rem;
            text-decoration: none;
            padding: 0.5rem;
        }
        
        .cart-icon:hover {
            color: var(--primary);
        }
        
        .cart-count-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .page-content {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        
        .footer {
            background: white;
            padding: 1rem 2rem;
            text-align: center;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--gray);
        }
        
        /* Notification */
        .notification-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--success);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .notification-toast.error {
            background: var(--danger);
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="client-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('client.dashboard') }}" class="logo">
                    <div class="logo-icon"><i class="fas fa-utensils"></i></div>
                    <div>
                        <span class="logo-text">Restaurant Istanbul</span>
                        <small class="logo-sub">Espace Client</small>
                    </div>
                </a>
            </div>
            
            <nav class="nav-menu">
                <div class="nav-label">Menu principal</div>
                
                <a href="{{ route('client.dashboard') }}" class="nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Tableau de bord</span>
                </a>
                
                <a href="{{ route('client.menu') }}" class="nav-item {{ request()->routeIs('client.menu') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span>Notre menu</span>
                </a>
                
                <a href="{{ route('client.commandes.index') }}" class="nav-item {{ request()->routeIs('client.commandes.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Mes commandes</span>
                </a>
                
                <a href="{{ route('client.reservations.index') }}" class="nav-item {{ request()->routeIs('client.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Mes réservations</span>
                </a>
                
                <a href="{{ route('client.paiement.index') }}" class="nav-item {{ request()->routeIs('client.paiement.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Paiement en ligne</span>
                </a>
                
                <div class="nav-divider"></div>
                
                <div class="nav-label">Actions rapides</div>
                
                <a href="{{ route('client.reservations.create') }}" class="nav-item">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Réserver une table</span>
                </a>
                
                <a href="{{ route('client.menu') }}" class="nav-item">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Passer commande</span>
                </a>
                
                <a href="{{ route('commande.panier') }}" class="nav-item">
                    <i class="fas fa-cart-shopping"></i>
                    <span>Mon panier</span>
                    @php
                        $panierCount = 0;
                        $commandePanier = \App\Models\Commande::where('client_id', Auth::id())->where('statut', 'panier')->first();
                        if($commandePanier) {
                            $panierCount = \App\Models\LigneCommande::where('commande_id', $commandePanier->id)->count();
                        }
                    @endphp
                    @if($panierCount > 0)
                        <span class="badge-panier">{{ $panierCount }}</span>
                    @endif
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(Auth::user()->name ?? 'C', 0, 1) }}</div>
                    <div>
                        <div class="user-name">{{ Auth::user()->name ?? 'Client' }}</div>
                        <div class="user-email">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                </form>
            </div>
        </aside>
        
        <main class="main-content">
            <div class="top-bar">
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
                <div></div>
                <div class="top-actions">
                    <a href="{{ route('commande.panier') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartCountBadge" class="cart-count-badge" style="display: none;">0</span>
                    </a>
                </div>
            </div>
            
            <div class="page-content">
                @yield('content')
            </div>
            
            <footer class="footer">
                <p>&copy; {{ date('Y') }} Restaurant Istanbul - Tous droits réservés</p>
            </footer>
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Sidebar toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        if(menuToggle) {
            menuToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
        }
        
        // Fonction de notification
        function showNotification(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `notification-toast ${type === 'error' ? 'error' : ''}`;
            toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>${message}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
        
        // Mettre à jour le compteur panier
        function updateCartCount() {
            fetch('/panier-count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('cartCountBadge');
                    const sidebarBadge = document.querySelector('.badge-panier');
                    if(badge) {
                        badge.textContent = data.count;
                        badge.style.display = data.count > 0 ? 'flex' : 'none';
                    }
                    if(sidebarBadge) {
                        if(data.count > 0) {
                            sidebarBadge.textContent = data.count;
                            sidebarBadge.style.display = 'inline-flex';
                        } else {
                            sidebarBadge.style.display = 'none';
                        }
                    }
                })
                .catch(err => console.error('Erreur updateCartCount:', err));
        }
        
        // Ajouter au panier - Version corrigée
        window.ajouterAuPanier = async function(menuId, quantite) {
            console.log('Ajout au panier:', { menu_id: menuId, quantite: quantite });
            try {
                const response = await fetch('/ajouter-panier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        menu_id: menuId, 
                        quantite: parseInt(quantite) 
                    })
                });
                
                const data = await response.json();
                console.log('Réponse:', data);
                
                if (data.success) {
                    showNotification(data.message, 'success');
                    updateCartCount();
                    
                    // Animation sur l'icône panier
                    const cartIcon = document.querySelector('.cart-icon');
                    if(cartIcon) {
                        cartIcon.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            cartIcon.style.transform = 'scale(1)';
                        }, 200);
                    }
                } else {
                    showNotification(data.message || 'Erreur lors de l\'ajout', 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Erreur de connexion au serveur: ' + error.message, 'error');
            }
        };
        
        // Fonction de test pour vérifier l'API
        window.testAjoutPanier = async function() {
            console.log('=== TEST AJOUT PANIER ===');
            try {
                const response = await fetch('/ajouter-panier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ menu_id: 1, quantite: 1 })
                });
                
                const data = await response.json();
                console.log('Résultat du test:', data);
                
                if (data.success) {
                    showNotification('✅ Test réussi: ' + data.message, 'success');
                    updateCartCount();
                } else {
                    showNotification('❌ Test échoué: ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Erreur test:', error);
                showNotification('❌ Erreur: ' + error.message, 'error');
            }
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            console.log('Page chargée - Fonctions disponibles:');
            console.log('- ajouterAuPanier(menuId, quantite)');
            console.log('- testAjoutPanier()');
        });
    </script>
    
    @stack('scripts')
</body>
</html>