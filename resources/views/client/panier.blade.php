@extends('layouts.client')

@section('title', 'Mon panier')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-shopping-cart me-2 text-primary"></i>
            Mon panier
        </h1>
        <a href="{{ route('client.menu') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
        </a>
    </div>

    @if($commande && $commande->ligneCommandes->count() > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Produit</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire</th>
                                        <th>Total</th>
                                        <th class="pe-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commande->ligneCommandes as $ligne)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="product-img">
                                                    @if($ligne->menu->image)
                                                        <img src="{{ Storage::url($ligne->menu->image) }}" alt="{{ $ligne->menu->nom }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                                                    @else
                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong>{{ $ligne->menu->nom }}</strong>
                                                    <small class="d-block text-muted">{{ $ligne->menu->categorie->nom ?? 'Plat' }}</small>
                                                </div>
                                            </div>
                                        </span>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <button class="btn btn-sm btn-outline-secondary rounded-circle qty-minus" data-id="{{ $ligne->id }}" data-qty="{{ $ligne->quantite - 1 }}" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <span class="fw-bold" id="qty-{{ $ligne->id }}">{{ $ligne->quantite }}</span>
                                                <button class="btn btn-sm btn-outline-secondary rounded-circle qty-plus" data-id="{{ $ligne->id }}" data-qty="{{ $ligne->quantite + 1 }}" style="width: 30px; height: 30px;">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                         </span>
                                        <td class="fw-bold">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
                                        <td class="fw-bold text-primary" id="total-{{ $ligne->id }}">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
                                        <td class="pe-4">
                                            <form action="{{ url('/retirer-panier/' . $ligne->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </span>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-active">
                                    <tr>
                                        <th colspan="3" class="text-end ps-4">Total</th>
                                        <th class="text-success fs-5">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</th>
                                        <th class="pe-4"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Récapitulatif</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frais de service (10%)</span>
                            <span>{{ number_format($commande->montant_total * 0.1, 0, ',', ' ') }} FC</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total à payer</strong>
                            <strong class="text-success fs-5">{{ number_format($commande->montant_total * 1.1, 0, ',', ' ') }} FC</strong>
                        </div>

                        <form method="POST" action="{{ url('/valider-commande') }}" id="commandeForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-store me-2"></i>Type de commande
                                </label>
                                <div class="d-flex gap-3">
                                    <label class="flex-fill">
                                        <input type="radio" name="type_commande" value="sur_place" class="form-check-input me-2" checked>
                                        Sur place
                                    </label>
                                    <label class="flex-fill">
                                        <input type="radio" name="type_commande" value="emporter" class="form-check-input me-2">
                                        À emporter
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3" id="tableField">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-chair me-2"></i>Choisissez votre table
                                </label>
                                <select name="table_id" class="form-select rounded-3">
                                    <option value="">Sélectionner une table</option>
                                    @foreach($tables as $table)
                                    <option value="{{ $table->id }}">Table {{ $table->numero }} ({{ $table->capacite }} places)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-pen me-2"></i>Instructions spéciales
                                </label>
                                <textarea name="notes" class="form-control rounded-3" rows="3" placeholder="Ex: Sans oignons, bien cuit..."></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary rounded-pill py-2">
                                    <i class="fas fa-check-circle me-2"></i>Confirmer la commande
                                </button>
                                <form action="{{ url('/vider-panier') }}" method="POST" onsubmit="return confirm('Vider tout le panier ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger rounded-pill w-100 py-2">
                                        <i class="fas fa-trash-alt me-2"></i>Vider le panier
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3" style="opacity: 0.5;"></i>
                <h4 class="text-muted">Votre panier est vide</h4>
                <p class="text-muted">Ajoutez des plats depuis notre menu</p>
                <a href="{{ route('client.menu') }}" class="btn btn-primary rounded-pill mt-3">
                    <i class="fas fa-utensils me-2"></i>Découvrir le menu
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
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
            body: JSON.stringify({ ligne_id: itemId, quantite: newQuantity })
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  location.reload();
              }
          }).catch(() => {});
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
@endpush