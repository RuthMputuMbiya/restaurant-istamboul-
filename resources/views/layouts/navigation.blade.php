<nav class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-utensils"></i>
            <span>RestoManager</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <div class="sidebar-menu">
        <div class="user-info">
            <div class="avatar">
                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?background=2c3e50&color=fff&name='.urlencode(Auth::user()->name ?? 'User') }}" alt="Avatar">
            </div>
            <div class="user-details">
                <h4>{{ Auth::user()->name ?? 'Invité' }}</h4>
                <span class="role-badge">{{ Auth::user()->role ?? 'Client' }}</span>
            </div>
        </div>
        
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            
            @auth
                @if(Auth::user()->role == 'admin')
                    <li class="nav-divider">Administration</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.roles') }}" class="nav-link">
                            <i class="fas fa-user-tag"></i>
                            <span>Rôles</span>
                        </a>
                    </li>
                @endif
                
                @if(in_array(Auth::user()->role, ['gerant', 'admin']))
                    <li class="nav-divider">Gestion</li>
                    <li class="nav-item">
                        <a href="{{ route('produits.index') }}" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Produits</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('commandes.index') }}" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Commandes</span>
                        </a>
                    </li>
                @endif
                
                @if(Auth::user()->role == 'cuisiniere')
                    <li class="nav-divider">Cuisine</li>
                    <li class="nav-item">
                        <a href="{{ route('cuisine.commandes') }}" class="nav-link">
                            <i class="fas fa-fire"></i>
                            <span>Commandes en attente</span>
                        </a>
                    </li>
                @endif
                
                @if(Auth::user()->role == 'serveur')
                    <li class="nav-divider">Service</li>
                    <li class="nav-item">
                        <a href="{{ route('serveur.tables') }}" class="nav-link">
                            <i class="fas fa-chair"></i>
                            <span>Tables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('serveur.commandes') }}" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Mes commandes</span>
                        </a>
                    </li>
                @endif
                
                <li class="nav-divider">Compte</li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="fas fa-user-circle"></i>
                        <span>Mon profil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Connexion</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="fas fa-user-plus"></i>
                        <span>Inscription</span>
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<style>
    .sidebar {
        width: 280px;
        background: linear-gradient(180deg, #1a2a3a 0%, #0f1a24 100%);
        color: white;
        transition: all 0.3s ease;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        z-index: 1000;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .sidebar.collapsed {
        width: 80px;
    }
    
    .sidebar.collapsed .sidebar-header span,
    .sidebar.collapsed .user-details,
    .sidebar.collapsed .nav-link span {
        display: none;
    }
    
    .sidebar.collapsed .nav-link i {
        margin: 0;
        font-size: 1.3rem;
    }
    
    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding: 12px;
    }
    
    .sidebar-header {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.3rem;
        font-weight: 700;
    }
    
    .logo i {
        font-size: 1.8rem;
        color: var(--accent);
    }
    
    .sidebar-toggle {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }
    
    .sidebar-toggle:hover {
        transform: rotate(90deg);
    }
    
    .user-info {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 20px;
    }
    
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--accent);
    }
    
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .user-details h4 {
        font-size: 1rem;
        margin: 0;
        font-weight: 600;
    }
    
    .role-badge {
        font-size: 0.75rem;
        background: rgba(243,156,18,0.2);
        color: var(--accent);
        padding: 3px 8px;
        border-radius: 12px;
    }
    
    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .nav-item {
        margin: 5px 15px;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: white;
        transform: translateX(5px);
    }
    
    .nav-link.active {
        background: linear-gradient(135deg, var(--accent) 0%, #e67e22 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(243,156,18,0.3);
    }
    
    .nav-link i {
        width: 24px;
        font-size: 1.1rem;
    }
    
    .nav-divider {
        padding: 10px 20px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255,255,255,0.5);
        margin-top: 15px;
    }
    
    .content-wrapper {
        margin-left: 280px;
        transition: all 0.3s ease;
    }
    
    .sidebar.collapsed + .content-wrapper {
        margin-left: 80px;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
        
        .content-wrapper {
            margin-left: 0 !important;
        }
    }
</style>

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('collapsed');
    });
    
    // Mobile toggle
    if (window.innerWidth <= 768) {
        document.querySelector('.sidebar').classList.add('collapsed');
    }
</script>