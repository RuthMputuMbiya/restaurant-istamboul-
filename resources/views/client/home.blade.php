{{-- resources/views/client/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Menu - ISTAMBOUL')

@section('content')
<div class="client-home">
    <div class="container py-4">

        <!-- ========================================== -->
        <!-- EN-TÊTE DE BIENVENUE -->
        <!-- ========================================== -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <div class="welcome-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-0">Bienvenue chez ISTAMBOUL !</h1>
                            <p class="mb-0">Découvrez notre délicieuse carte et profitez d'une expérience culinaire unique</p>
                        </div>
                    </div>
                    <div class="welcome-stats">
                        <div class="stat-mini">
                            <i class="fas fa-utensils"></i>
                            <span>{{ $totalPlats ?? 0 }} plats</span>
                        </div>
                        <div class="stat-mini">
                            <i class="fas fa-star"></i>
                            <span>4.8/5</span>
                        </div>
                        <div class="stat-mini">
                            <i class="fas fa-clock"></i>
                            <span>Livraison 30min</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CATÉGORIES -->
        <!-- ========================================== -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="categories-wrapper">
                    <div class="categories-header">
                        <h3>
                            <i class="fas fa-tags text-primary me-2"></i>
                            Catégories
                        </h3>
                    </div>
                    <div class="categories-list">
                        <button class="cat-filter active" data-cat="all">
                            <i class="fas fa-th-large me-1"></i> Tous
                        </button>
                        @foreach($categories as $cat)
                        <button class="cat-filter" data-cat="{{ $cat->id }}">
                            <i class="fas fa-tag me-1"></i> {{ $cat->nom }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- LISTE DES PLATS -->
        <!-- ========================================== -->
        <div class="row g-4" id="productsGrid">
            @forelse($products as $product)
            <div class="col-md-6 col-lg-4 product-item" data-cat="{{ $product->categorie_id }}">
                <div class="product-card">
                    <div class="product-img">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nom }}">
                        @else
                            <div class="img-placeholder">
                                <i class="fas fa-utensils fa-3x"></i>
                            </div>
                        @endif
                        @if($product->est_populaire)
                            <span class="popular-tag">
                                <i class="fas fa-fire"></i> Populaire
                            </span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h5 class="product-name">{{ $product->nom }}</h5>
                        <p class="product-desc">{{ Str::limit($product->description, 60) }}</p>
                        <div class="product-price">
                            <span class="price-fc">{{ number_format($product->prix, 0, ',', ' ') }} FC</span>
                            @if($product->prix_usd)
                                <span class="price-usd">${{ number_format($product->prix_usd, 2, ',', ' ') }}</span>
                            @endif
                        </div>
                        <div class="product-action">
                            @if($product->est_disponible)
                                <button class="btn-add" onclick="addToCart({{ $product->id }})">
                                    <i class="fas fa-shopping-cart me-2"></i> Ajouter
                                </button>
                            @else
                                <span class="badge bg-secondary">Indisponible</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-menu">
                    <i class="fas fa-utensils fa-4x mb-3"></i>
                    <h4>Aucun plat disponible</h4>
                    <p>Le menu sera bientôt disponible</p>
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- PANIER FLOTTANT -->
<!-- ========================================== -->
<div class="cart-fab" onclick="toggleCart()">
    <i class="fas fa-shopping-cart"></i>
    <span class="cart-count" id="cartCount">0</span>
</div>

<!-- ========================================== -->
<!-- PANIER SIDEBAR -->
<!-- ========================================== -->
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-sidebar-header">
        <h5><i class="fas fa-shopping-cart me-2"></i>Mon panier</h5>
        <button class="close-sidebar" onclick="toggleCart()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="cart-items-list" id="cartItemsList">
        <div class="empty-cart-msg">
            <i class="fas fa-cart-shopping fa-3x mb-3"></i>
            <p>Votre panier est vide</p>
        </div>
    </div>
    <div class="cart-sidebar-footer">
        <div class="cart-total-row">
            <span>Total</span>
            <strong id="cartTotalAmount">0 FC</strong>
        </div>
        <button class="btn-checkout" onclick="goToCheckout()">
            <i class="fas fa-credit-card me-2"></i> Commander
        </button>
    </div>
</div>

@push('styles')
<style>
    .client-home {
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 20px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        color: white;
    }
    .welcome-content {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .welcome-icon {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.15);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .welcome-icon i {
        font-size: 28px;
        color: #f39c12;
    }
    .welcome-stats {
        display: flex;
        gap: 15px;
    }
    .stat-mini {
        background: rgba(255,255,255,0.1);
        padding: 8px 18px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .stat-mini i {
        color: #f39c12;
    }

    /* Categories */
    .categories-wrapper {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .categories-header h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1e293b;
    }
    .categories-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .cat-filter {
        background: #f1f5f9;
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
    }
    .cat-filter:hover, .cat-filter.active {
        background: #f39c12;
        color: white;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .product-img {
        height: 180px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }
    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }
    .popular-tag {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #f39c12;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .product-info {
        padding: 15px;
    }
    .product-name {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .product-desc {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    .product-price {
        margin-bottom: 12px;
    }
    .price-fc {
        font-size: 18px;
        font-weight: 800;
        color: #f39c12;
    }
    .price-usd {
        font-size: 11px;
        color: #94a3b8;
        margin-left: 8px;
    }
    .btn-add {
        width: 100%;
        background: #f39c12;
        border: none;
        padding: 10px;
        border-radius: 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-add:hover {
        background: #e67e22;
    }

    /* Empty Menu */
    .empty-menu {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
    }

    /* Cart FAB */
    .cart-fab {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: all 0.3s;
    }
    .cart-fab:hover {
        transform: scale(1.1);
    }
    .cart-fab i {
        font-size: 24px;
        color: white;
    }
    .cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ef4444;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }

    /* Cart Sidebar */
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100vh;
        background: white;
        box-shadow: -5px 0 30px rgba(0,0,0,0.15);
        z-index: 1001;
        transition: right 0.3s;
        display: flex;
        flex-direction: column;
    }
    .cart-sidebar.open {
        right: 0;
    }
    .cart-sidebar-header {
        padding: 20px;
        background: #1a1a2e;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .close-sidebar {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }
    .cart-items-list {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }
    .empty-cart-msg {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
    }
    .cart-sidebar-footer {
        padding: 20px;
        border-top: 1px solid #e9ecef;
    }
    .cart-total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 700;
    }
    .btn-checkout {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        cursor: pointer;
    }
    .btn-checkout:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .welcome-card {
            flex-direction: column;
            text-align: center;
        }
        .welcome-content {
            flex-direction: column;
        }
        .cart-sidebar {
            width: 100%;
            right: -100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function addToCart(productId) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ menu_id: productId, quantite: 1 })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                updateCartCount();
                loadCart();
                showToast('Plat ajouté au panier');
            }
        });
    }

    function updateCartCount() {
        fetch('/cart/count')
            .then(res => res.json())
            .then(data => {
                document.getElementById('cartCount').innerText = data.count || 0;
            });
    }

    function loadCart() {
        fetch('/cart/items')
            .then(res => res.json())
            .then(data => renderCart(data));
    }

    function renderCart(data) {
        const container = document.getElementById('cartItemsList');
        const totalSpan = document.getElementById('cartTotalAmount');
        
        if(!data.items || data.items.length === 0) {
            container.innerHTML = '<div class="empty-cart-msg"><i class="fas fa-cart-shopping fa-3x mb-3"></i><p>Votre panier est vide</p></div>';
            totalSpan.innerHTML = '0 FC';
            return;
        }

        let html = '';
        let total = 0;
        data.items.forEach(item => {
            total += item.prix * item.quantite;
            html += `
                <div class="cart-item" style="display:flex; gap:15px; padding:12px 0; border-bottom:1px solid #e9ecef;">
                    <div style="flex:1;">
                        <div style="font-weight:600;">${item.nom}</div>
                        <div style="font-size:12px; color:#f39c12;">${item.prix.toLocaleString()} FC</div>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <button onclick="updateQty(${item.id}, ${item.quantite - 1})" style="width:28px; height:28px; border-radius:50%; border:1px solid #e2e8f0;">-</button>
                        <span>${item.quantite}</span>
                        <button onclick="updateQty(${item.id}, ${item.quantite + 1})" style="width:28px; height:28px; border-radius:50%; border:1px solid #e2e8f0;">+</button>
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
        totalSpan.innerHTML = total.toLocaleString() + ' FC';
    }

    function updateQty(menuId, newQty) {
        if(newQty <= 0) {
            removeItem(menuId);
            return;
        }
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ menu_id: menuId, quantite: newQty })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                updateCartCount();
                loadCart();
            }
        });
    }

    function removeItem(menuId) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ menu_id: menuId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                updateCartCount();
                loadCart();
            }
        });
    }

    function toggleCart() {
        document.getElementById('cartSidebar').classList.toggle('open');
    }

    function goToCheckout() {
        window.location.href = '{{ route("client.commande.panier") }}';
    }

    function showToast(msg) {
        const toast = document.createElement('div');
        toast.innerHTML = `<i class="fas fa-check-circle me-2"></i>${msg}`;
        toast.style.cssText = 'position:fixed; bottom:100px; right:30px; background:#27ae60; color:white; padding:12px 24px; border-radius:50px; z-index:2000;';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }

    // Filtres
    document.querySelectorAll('.cat-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.cat-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.cat;
            document.querySelectorAll('.product-item').forEach(item => {
                if(cat === 'all' || item.dataset.cat == cat) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        updateCartCount();
    });
</script>
@endpush
@endsection