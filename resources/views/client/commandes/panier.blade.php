@extends('layouts.client')

@section('title', 'Mon panier - Restaurant Istanbul')

@section('content')
<div class="cart-page">
    <div class="container">
        <!-- Header Section -->
        <div class="cart-header">
            <div class="cart-header-content">
                <a href="{{ route('client.menu') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Continuer les achats</span>
                </a>
                <div class="cart-title">
                    <div class="cart-icon-wrapper">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count-badge-large">{{ count($plats) }}</span>
                    </div>
                    <h1>Mon panier</h1>
                    <p>Vérifiez et validez votre commande</p>
                </div>
            </div>
        </div>

        @if(empty($plats) || count($plats) == 0)
        <!-- Empty Cart -->
        <div class="empty-cart">
            <div class="empty-cart-animation">
                <div class="empty-cart-icon">
                    <i class="fas fa-cart-shopping"></i>
                    <div class="empty-cart-glow"></div>
                </div>
                <div class="empty-cart-shopping-bag">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
            <h3>Votre panier est vide</h3>
            <p>Découvrez notre carte et ajoutez vos plats préférés</p>
            <a href="{{ route('client.menu') }}" class="btn-explore">
                <i class="fas fa-utensils"></i>
                <span>Explorer la carte</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @else
        <div class="cart-content">
            <div class="cart-items-section">
                <!-- Cart Header -->
                <div class="cart-items-header">
                    <div class="header-product">Produit</div>
                    <div class="header-price">Prix unitaire</div>
                    <div class="header-quantity">Quantité</div>
                    <div class="header-total">Total</div>
                    <div class="header-action"></div>
                </div>

                <!-- Cart Items -->
                <div class="cart-items-list">
                    @foreach($plats as $item)
                    <div class="cart-item" data-id="{{ $item['id'] }}">
                        <div class="item-product">
                            <div class="item-image">
                                @if($item['menu']->image)
                                    <img src="{{ Storage::url($item['menu']->image) }}" alt="{{ $item['menu']->nom }}">
                                @else
                                    <div class="item-image-placeholder">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="item-info">
                                <h4 class="item-name">{{ $item['menu']->nom }}</h4>
                                <div class="item-category">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $item['menu']->categorie->nom ?? 'Plat' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="item-price">
                            <span class="price-value">{{ number_format($item['prix_unitaire'], 0, ',', ' ') }}</span>
                            <span class="price-currency">FC</span>
                        </div>
                        <div class="item-quantity">
                            <div class="quantity-control">
                                <button class="qty-btn qty-minus" data-id="{{ $item['id'] }}" data-qty="{{ $item['quantite'] - 1 }}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="qty-number" id="qty_{{ $item['id'] }}">{{ $item['quantite'] }}</span>
                                <button class="qty-btn qty-plus" data-id="{{ $item['id'] }}" data-qty="{{ $item['quantite'] + 1 }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="item-total">
                            <span class="total-amount" id="total_{{ $item['id'] }}">{{ number_format($item['sous_total'], 0, ',', ' ') }}</span>
                            <span class="total-currency">FC</span>
                        </div>
                        <div class="item-action">
                            <form action="{{ url('/retirer-panier/' . $item['id']) }}" method="POST" onsubmit="return confirm('Supprimer ce produit du panier ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Continue Shopping Link -->
                <div class="continue-shopping">
                    <a href="{{ route('client.menu') }}" class="continue-link">
                        <i class="fas fa-chevron-left"></i>
                        <span>Ajouter d'autres plats</span>
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-header">
                    <h3>Récapitulatif</h3>
                    <i class="fas fa-receipt"></i>
                </div>

                <div class="summary-body">
                    <div class="summary-row">
                        <span>Sous-total</span>
                        <span id="sous-total">{{ number_format($total, 0, ',', ' ') }} FC</span>
                    </div>
                    <div class="summary-row">
                        <span>Frais de service (10%)</span>
                        <span id="frais-service">{{ number_format($total * 0.1, 0, ',', ' ') }} FC</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row total">
                        <span>Total à payer</span>
                        <span class="total-price" id="grand-total">{{ number_format($total * 1.1, 0, ',', ' ') }} FC</span>
                    </div>
                </div>

                <!-- FORMULAIRE DE VALIDATION -->
                <form method="POST" action="{{ url('/valider-commande') }}" class="checkout-form" id="commandeForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-store"></i>
                            Type de commande
                        </label>
                        <div class="type-selector">
                            <label class="type-option">
                                <input type="radio" name="type_commande" value="sur_place" checked>
                                <span class="type-content">
                                    <i class="fas fa-chair"></i>
                                    <strong>Sur place</strong>
                                    <small>Dégustez sur place</small>
                                </span>
                            </label>
                            <label class="type-option">
                                <input type="radio" name="type_commande" value="emporter">
                                <span class="type-content">
                                    <i class="fas fa-box"></i>
                                    <strong>À emporter</strong>
                                    <small>Emportez vos plats</small>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div id="tableField" class="form-group" style="display: none;">
                        <label class="form-label">
                            <i class="fas fa-table"></i>
                            Choisissez votre table
                        </label>
                        <select name="table_id" class="form-select-modern">
                            <option value="">Sélectionner une table</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">Table {{ $table->numero }} ({{ $table->capacite }} places)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-pen"></i>
                            Instructions spéciales
                        </label>
                        <textarea name="notes" class="form-textarea" rows="3" placeholder="Ex: Sans oignons, bien cuit, etc..."></textarea>
                    </div>

                    <div class="summary-actions">
                        <button type="submit" class="btn-checkout" id="submitCommande">
                            <i class="fas fa-check-circle"></i>
                            <span>Confirmer la commande</span>
                        </button>
                        <form method="POST" action="{{ url('/vider-panier') }}" onsubmit="return confirm('Vider tout le panier ?')">
                            @csrf
                            <button type="submit" class="btn-clear">
                                <i class="fas fa-trash-alt"></i>
                                <span>Vider le panier</span>
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* ========== CART PAGE STYLES ========== */
.cart-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Header */
.cart-header {
    margin-bottom: 2rem;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s;
}

.back-link:hover {
    color: #f59e0b;
    transform: translateX(-3px);
}

.cart-title {
    text-align: center;
}

.cart-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.cart-icon-wrapper i {
    font-size: 3rem;
    color: #f59e0b;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    padding: 1rem;
    border-radius: 30px;
}

.cart-count-badge-large {
    position: absolute;
    top: -5px;
    right: -10px;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.cart-title h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}

.cart-title p {
    color: #64748b;
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 30px;
    position: relative;
    overflow: hidden;
}

.empty-cart-animation {
    position: relative;
    display: inline-block;
    margin-bottom: 2rem;
}

.empty-cart-icon {
    position: relative;
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-cart-icon i {
    font-size: 3rem;
    color: #f59e0b;
}

.empty-cart-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(245,158,11,0.2) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.empty-cart-shopping-bag {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background: #f59e0b;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    animation: bounce 1s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
    50% { opacity: 1; transform: translate(-50%, -50%) scale(1.2); }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.empty-cart h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #1a1a2e;
}

.empty-cart p {
    color: #64748b;
    margin-bottom: 1.5rem;
}

.btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 2rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-explore:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(245,158,11,0.3);
    color: white;
}

/* Cart Content */
.cart-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 2rem;
}

.cart-items-header {
    display: grid;
    grid-template-columns: 3fr 1fr 1.2fr 1.2fr 0.5fr;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 15px;
    margin-bottom: 1rem;
    font-weight: 600;
    color: #64748b;
    font-size: 0.85rem;
}

.cart-items-list {
    background: white;
    border-radius: 20px;
    overflow: hidden;
}

.cart-item {
    display: grid;
    grid-template-columns: 3fr 1fr 1.2fr 1.2fr 0.5fr;
    align-items: center;
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid #eef2f6;
    transition: all 0.3s;
}

.cart-item:hover {
    background: #fafbfc;
}

.item-product {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.item-image {
    width: 70px;
    height: 70px;
    border-radius: 15px;
    overflow: hidden;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f59e0b;
}

.item-info h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #1a1a2e;
}

.item-category {
    font-size: 0.7rem;
    color: #f59e0b;
}

.item-category i {
    margin-right: 0.25rem;
}

.item-price, .item-total {
    font-weight: 600;
    font-size: 1rem;
}

.item-price .price-currency, .item-total .total-currency {
    font-size: 0.7rem;
    font-weight: normal;
    color: #64748b;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #f8f9fa;
    padding: 0.3rem;
    border-radius: 40px;
    width: fit-content;
}

.qty-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    background: white;
    color: #f59e0b;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.qty-btn:hover {
    background: #f59e0b;
    color: white;
    transform: scale(1.05);
}

.qty-number {
    min-width: 30px;
    text-align: center;
    font-weight: 600;
}

.remove-btn {
    background: none;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
}

.remove-btn:hover {
    transform: scale(1.1);
    color: #dc2626;
}

.continue-shopping {
    margin-top: 1rem;
    text-align: center;
}

.continue-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s;
}

.continue-link:hover {
    color: #f59e0b;
    gap: 0.8rem;
}

/* Order Summary */
.order-summary {
    background: white;
    border-radius: 24px;
    padding: 1.5rem;
    position: sticky;
    top: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eef2f6;
    margin-bottom: 1.5rem;
}

.summary-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    margin: 0;
}

.summary-header i {
    font-size: 1.5rem;
    color: #f59e0b;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #64748b;
}

.summary-divider {
    border-top: 1px dashed #eef2f6;
    margin: 1rem 0;
}

.summary-row.total {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1a1a2e;
}

.total-price {
    color: #f59e0b;
    font-size: 1.2rem;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #1a1a2e;
}

.type-selector {
    display: flex;
    gap: 1rem;
}

.type-option {
    flex: 1;
    cursor: pointer;
}

.type-option input {
    display: none;
}

.type-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 16px;
    border: 2px solid transparent;
    transition: all 0.3s;
    text-align: center;
}

.type-content i {
    font-size: 1.5rem;
    color: #64748b;
}

.type-content strong {
    font-size: 0.9rem;
}

.type-content small {
    font-size: 0.7rem;
    color: #64748b;
}

.type-option input:checked + .type-content {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-color: #f59e0b;
}

.type-option input:checked + .type-content i {
    color: #f59e0b;
}

.form-select-modern, .form-textarea {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 1px solid #eef2f6;
    border-radius: 16px;
    font-size: 0.9rem;
    transition: all 0.3s;
    background: #f8f9fa;
}

.form-select-modern:focus, .form-textarea:focus {
    outline: none;
    border-color: #f59e0b;
    background: white;
}

.summary-actions {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin-top: 1.5rem;
}

.btn-checkout, .btn-clear {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    padding: 1rem;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    width: 100%;
}

.btn-checkout {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245,158,11,0.3);
}

.btn-clear {
    background: #fee2e2;
    color: #ef4444;
}

.btn-clear:hover {
    background: #fecaca;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .cart-content {
        grid-template-columns: 1fr;
    }
    
    .cart-items-header {
        display: none;
    }
    
    .cart-item {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .item-product {
        width: 100%;
    }
    
    .item-price, .item-quantity, .item-total, .item-action {
        width: auto;
        flex: 1;
    }
}

@media (max-width: 768px) {
    .cart-title h1 {
        font-size: 1.5rem;
    }
    
    .type-selector {
        flex-direction: column;
    }
    
    .cart-item {
        flex-direction: column;
        text-align: center;
    }
    
    .item-product {
        flex-direction: column;
    }
    
    .quantity-control {
        margin: 0 auto;
    }
}
</style>

<script>
    // Type de commande toggle
    document.querySelectorAll('input[name="type_commande"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const tableField = document.getElementById('tableField');
            if(tableField) {
                tableField.style.display = this.value === 'sur_place' ? 'block' : 'none';
            }
        });
    });
    
    // Mise à jour quantité
    function updateQuantity(itemId, newQuantity) {
        fetch('/update-panier', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ligne_id: itemId,
                quantite: newQuantity
            })
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  location.reload();
              }
          }).catch(error => {
              console.error('Erreur:', error);
          });
    }
    
    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const newQty = parseInt(this.dataset.qty);
            if(newQty > 0) {
                updateQuantity(id, newQty);
            } else if(confirm('Supprimer ce plat du panier ?')) {
                updateQuantity(id, 0);
            }
        });
    });
    
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const newQty = parseInt(this.dataset.qty);
            updateQuantity(id, newQty);
        });
    });
</script>
@endsection