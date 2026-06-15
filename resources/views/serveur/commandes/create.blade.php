@extends('layouts.serveur')

@section('title', 'Nouvelle commande')
@section('page-title', 'Nouvelle commande')
@section('page-subtitle', 'Créez une commande pour une table')

@section('serveur-content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-cart-plus text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Créer une nouvelle commande</h4>
                            <p class="text-muted mb-0 small">Remplissez les informations ci-dessous</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('serveur.commandes.store') }}" id="formCommande">
                        @csrf
                        
                        <!-- Sélection de la table -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-chair me-2 text-primary"></i>Table
                            </label>
                            <select name="table_id" class="form-select form-select-lg rounded-3 @error('table_id') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une table --</option>
                                @foreach($tables as $table)
                                <option value="{{ $table->id }}" 
                                    {{ isset($tableSelectionnee) && $tableSelectionnee->id == $table->id ? 'selected' : '' }}
                                    @if($table->statut != 'libre') disabled @endif>
                                    Table {{ $table->numero }} - Capacité: {{ $table->capacite }} personnes
                                    @if($table->statut == 'libre')
                                        <span class="text-success">✓ Libre</span>
                                    @elseif($table->statut == 'occupee')
                                        <span class="text-danger">✗ Occupée</span>
                                    @else
                                        <span class="text-warning">⏰ Réservée</span>
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i> Seules les tables libres sont disponibles
                            </div>
                        </div>

                        <!-- Type de commande -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-store me-2 text-primary"></i>Type de commande
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="type-option">
                                        <input type="radio" name="type_commande" value="sur_place" id="typeSurPlace" class="d-none" checked>
                                        <label for="typeSurPlace" class="type-card">
                                            <i class="fas fa-chair fa-2x mb-2"></i>
                                            <strong>Sur place</strong>
                                            <small>Client présent au restaurant</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="type-option">
                                        <input type="radio" name="type_commande" value="emporter" id="typeEmporter" class="d-none">
                                        <label for="typeEmporter" class="type-card">
                                            <i class="fas fa-box fa-2x mb-2"></i>
                                            <strong>À emporter</strong>
                                            <small>Commande à emporter</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Client (optionnel pour commande sur place) -->
                        <div class="mb-4" id="clientField">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-2 text-primary"></i>Client
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                <input type="text" name="client_nom" class="form-control rounded-end" placeholder="Nom du client (optionnel)">
                            </div>
                            <div class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle me-1"></i> Laissez vide pour un client anonyme
                            </div>
                        </div>

                        <!-- Sélection des plats -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-utensils me-2 text-primary"></i>Sélection des plats
                            </label>
                            <div class="border rounded-3 p-3" style="max-height: 400px; overflow-y: auto;">
                                @if(isset($menus) && $menus->count() > 0)
                                    @foreach($menus as $menu)
                                    <div class="plat-item d-flex justify-content-between align-items-center p-2 mb-2 rounded-3" style="border: 1px solid #e9ecef;">
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $menu->nom }}</div>
                                            <div class="small text-muted">{{ number_format($menu->prix, 0, ',', ' ') }} FC</div>
                                            @if($menu->categorie)
                                                <span class="badge bg-light text-dark mt-1">{{ $menu->categorie->nom }}</span>
                                            @endif
                                        </div>
                                        <div class="quantite-control d-flex align-items-center gap-2">
                                            <button type="button" class="btn-qty btn-minus" data-id="{{ $menu->id }}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span class="qty-value fw-bold" id="qty_{{ $menu->id }}">0</span>
                                            <button type="button" class="btn-qty btn-plus" data-id="{{ $menu->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Aucun plat disponible</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Instructions spéciales -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-pen me-2 text-primary"></i>Instructions spéciales
                            </label>
                            <textarea name="notes" class="form-control rounded-3" rows="3" placeholder="Ex: Sans oignons, bien cuit, etc..."></textarea>
                        </div>

                        <!-- Résumé des plats sélectionnés -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-receipt me-2 text-primary"></i>Résumé de la commande
                            </label>
                            <div class="border rounded-3 p-3 bg-light">
                                <div id="selectedItemsList" class="mb-2">
                                    <p class="text-muted text-center small mb-0">Aucun plat sélectionné</p>
                                </div>
                                <div class="border-top pt-2 mt-2">
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span id="totalPrice">0 FC</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden inputs pour les plats -->
                        <div id="selectedPlats"></div>

                        <!-- Boutons d'action -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary flex-grow-1 rounded-pill py-2" id="btnSubmit">
                                <i class="fas fa-check-circle me-2"></i>Créer la commande
                            </button>
                            <a href="{{ route('serveur.commandes.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Type de commande cards */
    .type-option {
        cursor: pointer;
    }
    .type-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        background: white;
    }
    .type-card i {
        color: #94a3b8;
    }
    .type-card strong {
        font-size: 1rem;
        margin-bottom: 4px;
    }
    .type-card small {
        font-size: 0.7rem;
        color: #94a3b8;
    }
    input[type="radio"]:checked + .type-card {
        border-color: #10b981;
        background: #f0fdf4;
    }
    input[type="radio"]:checked + .type-card i {
        color: #10b981;
    }
    input[type="radio"]:checked + .type-card small {
        color: #10b981;
    }

    /* Quantité buttons */
    .btn-qty {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-qty:hover {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    .qty-value {
        min-width: 30px;
        text-align: center;
    }

    /* Plat item hover */
    .plat-item:hover {
        background: #f8fafc;
    }

    /* Selected items list */
    .selected-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e8f0;
    }
    .selected-item:last-child {
        border-bottom: none;
    }
    .remove-item {
        cursor: pointer;
        color: #ef4444;
        transition: all 0.2s;
    }
    .remove-item:hover {
        transform: scale(1.1);
    }

    /* Form select */
    .form-select, .form-control {
        border: 1px solid #e2e8f0;
    }
    .form-select:focus, .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Prix des plats
    const plats = @json($menus->map(function($menu) {
        return ['id' => $menu->id, 'nom' => $menu->nom, 'prix' => $menu->prix];
    }));

    let panier = {};

    // Mettre à jour l'affichage du panier
    function updatePanier() {
        const container = document.getElementById('selectedItemsList');
        const totalSpan = document.getElementById('totalPrice');
        const platsContainer = document.getElementById('selectedPlats');
        
        let total = 0;
        let html = '';
        let platsHtml = '';
        
        for (const [id, quantite] of Object.entries(panier)) {
            const plat = plats.find(p => p.id == id);
            if (plat && quantite > 0) {
                const sousTotal = plat.prix * quantite;
                total += sousTotal;
                html += `
                    <div class="selected-item">
                        <div>
                            <span class="fw-bold">${quantite}x</span> ${plat.nom}
                        </div>
                        <div>
                            <span class="text-primary fw-bold me-3">${sousTotal.toLocaleString()} FC</span>
                            <span class="remove-item" onclick="retirerPlat(${id})">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                        </div>
                    </div>
                `;
                platsHtml += `<input type="hidden" name="plats[${id}][menu_id]" value="${id}">
                              <input type="hidden" name="plats[${id}][quantite]" value="${quantite}">`;
            }
        }
        
        if (html === '') {
            html = '<p class="text-muted text-center small mb-0">Aucun plat sélectionné</p>';
        }
        
        container.innerHTML = html;
        totalSpan.innerHTML = total.toLocaleString() + ' FC';
        platsContainer.innerHTML = platsHtml;
        
        // Activer/désactiver le bouton submit
        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.disabled = Object.keys(panier).length === 0;
        btnSubmit.style.opacity = Object.keys(panier).length === 0 ? '0.5' : '1';
    }
    
    // Ajouter un plat
    function ajouterPlat(menuId) {
        if (!panier[menuId]) {
            panier[menuId] = 0;
        }
        panier[menuId]++;
        document.getElementById(`qty_${menuId}`).innerText = panier[menuId];
        updatePanier();
    }
    
    // Retirer un plat
    function retirerPlat(menuId) {
        if (panier[menuId] && panier[menuId] > 0) {
            panier[menuId]--;
            if (panier[menuId] === 0) {
                delete panier[menuId];
            }
            const qtySpan = document.getElementById(`qty_${menuId}`);
            if (qtySpan) {
                qtySpan.innerText = panier[menuId] || 0;
            }
            updatePanier();
        }
    }
    
    // Supprimer un plat du panier
    window.retirerPlat = function(id) {
        delete panier[id];
        const qtySpan = document.getElementById(`qty_${id}`);
        if (qtySpan) {
            qtySpan.innerText = 0;
        }
        updatePanier();
    };
    
    // Initialiser les événements
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            ajouterPlat(id);
        });
    });
    
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            retirerPlat(id);
        });
    });
    
    // Type de commande toggle - champ client
    document.querySelectorAll('input[name="type_commande"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const clientField = document.getElementById('clientField');
            if (this.value === 'emporter') {
                clientField.style.display = 'block';
            } else {
                clientField.style.display = 'block';
            }
        });
    });
    
    // Validation du formulaire
    document.getElementById('formCommande').addEventListener('submit', function(e) {
        const tableSelect = document.querySelector('select[name="table_id"]');
        if (!tableSelect.value) {
            e.preventDefault();
            alert('Veuillez sélectionner une table');
            tableSelect.focus();
            return false;
        }
        
        if (Object.keys(panier).length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un plat');
            return false;
        }
    });
</script>
@endpush
@endsection