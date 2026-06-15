@extends('layouts.client')

@section('title', 'Notre Menu - Restaurant Istanbul')

@section('content')
<div class="menu-page">
    <!-- Hero Section -->
    <div class="menu-hero">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">Notre Carte</h1>
                <p class="hero-subtitle">Découvrez nos délicieux plats préparés avec passion par nos chefs</p>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Barre de recherche avancée -->
        <div class="search-section mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-wrapper">
                        <div class="search-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un plat par nom, ingrédient...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Catégories -->
        <div class="categories-section mb-5">
            <div class="categories-slider">
                <button class="category-btn active" data-categorie="all">
                    <i class="fas fa-th-large"></i>
                    <span>Tous</span>
                </button>
                @foreach($categories as $categorie)
                <button class="category-btn" data-categorie="{{ $categorie->id }}">
                    <i class="fas {{ $categorie->icone ?? 'fa-utensils' }}"></i>
                    <span>{{ $categorie->nom }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Plats populaires -->
        @if(isset($platsPopulaires) && $platsPopulaires->count() > 0)
        <div class="popular-section mb-5">
            <div class="section-header">
                <h2 class="section-title">
                    <span class="title-icon"><i class="fas fa-fire-flame-curved"></i></span>
                    Les plus populaires
                </h2>
                <p class="section-subtitle">Nos clients les adorent</p>
            </div>
            <div class="popular-grid">
                @foreach($platsPopulaires as $menu)
                <div class="popular-card" data-id="{{ $menu->id }}">
                    <div class="popular-badge">Populaire</div>
                    <div class="popular-img">
                        @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->nom }}">
                        @else
                        <div class="img-placeholder">
                            <i class="fas fa-utensils"></i>
                        </div>
                        @endif
                    </div>
                    <div class="popular-body">
                        <h3 class="popular-title">{{ $menu->nom }}</h3>
                        <p class="popular-desc">{{ Str::limit($menu->description ?? 'Délicieux plat préparé avec soin', 70) }}</p>
                        <div class="popular-footer">
                            <div class="popular-price">{{ number_format($menu->prix, 0, ',', ' ') }} <small>FC</small></div>
                            <div class="popular-actions">
                                <div class="qty-wrapper">
                                    <button class="qty-minus" data-id="{{ $menu->id }}">-</button>
                                    <span class="qty-value" id="qty_pop_{{ $menu->id }}">1</span>
                                    <button class="qty-plus" data-id="{{ $menu->id }}">+</button>
                                </div>
                                <button class="add-to-cart-btn" onclick="ajouterAuPanier({{ $menu->id }}, document.getElementById('qty_pop_{{ $menu->id }}').innerText)">
                                    <i class="fas fa-cart-shopping"></i>
                                    <span>Ajouter</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Tous les plats -->
        <div class="all-items-section">
            <div class="section-header">
                <h2 class="section-title">
                    <span class="title-icon"><i class="fas fa-book-open"></i></span>
                    Notre carte complète
                </h2>
                <p class="section-subtitle">Explorez notre sélection de plats</p>
            </div>

            @if(isset($menus) && $menus->count() > 0)
            <div class="menu-grid" id="menusList">
                @foreach($menus as $menu)
                <div class="menu-card" data-categorie="{{ $menu->categorie_id }}" data-nom="{{ strtolower($menu->nom) }}" data-id="{{ $menu->id }}">
                    <div class="menu-card-img">
                        @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->nom }}">
                        @else
                        <div class="img-placeholder">
                            <i class="fas fa-utensils"></i>
                        </div>
                        @endif
                        <div class="menu-category-badge">{{ $menu->categorie->nom ?? '' }}</div>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $menu->nom }}</h3>
                        <p class="menu-card-desc">{{ Str::limit($menu->description ?? 'Délicieux plat préparé avec des ingrédients frais', 60) }}</p>
                        @if($menu->temps_preparation)
                        <div class="menu-card-time">
                            <i class="far fa-clock"></i> {{ $menu->temps_preparation }} min
                        </div>
                        @endif
                        <div class="menu-card-footer">
                            <div class="menu-card-price">{{ number_format($menu->prix, 0, ',', ' ') }} <small>FC</small></div>
                            <div class="menu-card-actions">
                                <div class="qty-wrapper-small">
                                    <button class="qty-minus-small" data-id="{{ $menu->id }}">-</button>
                                    <span class="qty-value-small" id="qty_{{ $menu->id }}">1</span>
                                    <button class="qty-plus-small" data-id="{{ $menu->id }}">+</button>
                                </div>
                                <button class="add-btn" onclick="ajouterAuPanier({{ $menu->id }}, document.getElementById('qty_{{ $menu->id }}').innerText)">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-5">
                {{ $menus->links() }}
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-utensils fa-4x"></i>
                <h3>Aucun plat disponible</h3>
                <p>Revenez plus tard pour découvrir notre carte</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* ========== MENU PAGE STYLES ========== */
    .menu-page {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Hero Section */
    .menu-hero {
        background: linear-gradient(135deg, #ff9f43 0%, #ff6b6b 100%);
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }
    .menu-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .menu-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .hero-content {
        position: relative;
        z-index: 2;
    }
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    .hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        max-width: 500px;
        margin: 0 auto;
    }

    /* Search Section */
    .search-wrapper {
        position: relative;
        background: white;
        border-radius: 60px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    .search-wrapper:focus-within {
        box-shadow: 0 15px 50px rgba(255,159,67,0.2);
        transform: translateY(-2px);
    }
    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #ff9f43;
        font-size: 1.2rem;
    }
    .search-input {
        width: 100%;
        padding: 18px 25px 18px 55px;
        border: none;
        border-radius: 60px;
        font-size: 1rem;
        outline: none;
    }

    /* Categories */
    .categories-slider {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 12px;
    }
    .category-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s;
    }
    .category-btn i {
        font-size: 1rem;
    }
    .category-btn:hover {
        border-color: #ff9f43;
        color: #ff9f43;
        transform: translateY(-2px);
    }
    .category-btn.active {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border-color: transparent;
        color: white;
        box-shadow: 0 5px 15px rgba(255,159,67,0.3);
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .title-icon {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    .section-subtitle {
        color: #64748b;
        font-size: 0.95rem;
    }

    /* Popular Grid */
    .popular-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }
    .popular-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        position: relative;
    }
    .popular-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    .popular-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
        z-index: 2;
    }
    .popular-img {
        height: 200px;
        overflow: hidden;
    }
    .popular-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .popular-card:hover .popular-img img {
        transform: scale(1.05);
    }
    .img-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #fff3e0, #ffe8d9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff9f43;
        font-size: 3rem;
    }
    .popular-body {
        padding: 1.5rem;
    }
    .popular-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1a1a2e;
    }
    .popular-desc {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    .popular-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .popular-price {
        font-size: 1.3rem;
        font-weight: 800;
        color: #ff9f43;
    }
    .popular-price small {
        font-size: 0.7rem;
        font-weight: 500;
    }
    .popular-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* Menu Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
    }
    .menu-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .menu-card-img {
        height: 180px;
        position: relative;
        overflow: hidden;
    }
    .menu-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .menu-card:hover .menu-card-img img {
        transform: scale(1.05);
    }
    .menu-category-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        backdrop-filter: blur(5px);
    }
    .menu-card-body {
        padding: 1.2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .menu-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1a1a2e;
    }
    .menu-card-desc {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0.8rem;
        line-height: 1.4;
        flex: 1;
    }
    .menu-card-time {
        font-size: 0.7rem;
        color: #ff9f43;
        margin-bottom: 0.8rem;
    }
    .menu-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    .menu-card-price {
        font-size: 1.2rem;
        font-weight: 800;
        color: #ff9f43;
    }
    .menu-card-price small {
        font-size: 0.65rem;
    }
    .menu-card-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* Quantity Selectors */
    .qty-wrapper, .qty-wrapper-small {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        border-radius: 30px;
        padding: 4px 8px;
    }
    .qty-wrapper button, .qty-wrapper-small button {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: white;
        color: #ff9f43;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .qty-wrapper button:hover, .qty-wrapper-small button:hover {
        background: #ff9f43;
        color: white;
        transform: scale(1.05);
    }
    .qty-value, .qty-value-small {
        min-width: 25px;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Add to Cart Button */
    .add-to-cart-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border: none;
        border-radius: 30px;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .add-to-cart-btn:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(255,107,107,0.3);
    }
    .add-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
    }
    .add-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 12px rgba(255,107,107,0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }
    .empty-state i {
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #1a1a2e;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }
    .pagination {
        gap: 8px;
    }
    .pagination .page-link {
        border-radius: 10px;
        color: #64748b;
        border: 1px solid #e9ecef;
        padding: 8px 14px;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border-color: transparent;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        .section-title {
            font-size: 1.5rem;
        }
        .popular-grid, .menu-grid {
            grid-template-columns: 1fr;
        }
        .category-btn span {
            display: none;
        }
        .category-btn {
            padding: 12px;
        }
        .category-btn i {
            margin: 0;
        }
        .popular-footer {
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
        }
        .popular-actions {
            justify-content: space-between;
        }
        .add-to-cart-btn {
            justify-content: center;
            flex: 1;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Gestion des quantités
    document.querySelectorAll('.qty-minus, .qty-minus-small').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const isPopular = this.classList.contains('qty-minus');
            const qtySpan = document.getElementById(isPopular ? `qty_pop_${id}` : `qty_${id}`);
            let qty = parseInt(qtySpan.innerText);
            if (qty > 1) {
                qtySpan.innerText = qty - 1;
            }
        });
    });

    document.querySelectorAll('.qty-plus, .qty-plus-small').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const isPopular = this.classList.contains('qty-plus');
            const qtySpan = document.getElementById(isPopular ? `qty_pop_${id}` : `qty_${id}`);
            let qty = parseInt(qtySpan.innerText);
            qtySpan.innerText = qty + 1;
        });
    });

    // Filtres par catégorie
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const categorie = this.dataset.categorie;
            document.querySelectorAll('.menu-card').forEach(item => {
                if(categorie === 'all' || item.dataset.categorie === categorie) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Recherche
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.menu-card').forEach(item => {
            const nom = item.dataset.nom;
            if(nom.includes(search)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        document.querySelectorAll('.popular-card').forEach(item => {
            const title = item.querySelector('.popular-title')?.textContent.toLowerCase() || '';
            if(title.includes(search)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Notification
    function showNotification(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `notification-toast ${type === 'error' ? 'error' : ''}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
        toast.style.cssText = 'position:fixed;bottom:30px;right:30px;background:#27ae60;color:white;padding:12px 20px;border-radius:10px;z-index:9999;animation:slideInRight 0.3s ease;box-shadow:0 5px 15px rgba(0,0,0,0.2);';
        if(type === 'error') toast.style.background = '#e84393';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Ajouter au panier
    window.ajouterAuPanier = async function(menuId, quantite) {
        try {
            const response = await fetch('{{ route("commande.ajouter-panier") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ menu_id: menuId, quantite: parseInt(quantite) })
            });
            const data = await response.json();
            if (data.success) {
                showNotification(data.message || 'Plat ajouté au panier !');
                if (typeof updateCartCount === 'function') updateCartCount();
            } else {
                showNotification(data.message || 'Erreur lors de l\'ajout', 'error');
            }
        } catch (error) {
            showNotification('Erreur de connexion', 'error');
        }
    };
</script>
@endpush
@endsection