@extends('layouts.client')

@section('title', 'Commande #' . $commande->id)

@section('content')
<div class="commande-detail-container">
    <!-- Fil d'ariane -->
    <div class="breadcrumb">
        <a href="{{ route('client.commandes.index') }}">Mes commandes</a>
        <i class="fas fa-chevron-right"></i>
        <span>Commande #{{ $commande->numero_commande ?? $commande->id }}</span>
    </div>

    <!-- En-tête -->
    <div class="detail-header">
        <div>
            <h1 class="detail-title">Commande #{{ $commande->numero_commande ?? $commande->id }}</h1>
            <p class="detail-date">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="status-badge status-{{ $commande->statut }}">
            @switch($commande->statut)
                @case('en_attente')
                    <i class="fas fa-clock"></i> En attente
                    @break
                @case('en_preparation')
                    <i class="fas fa-cooking"></i> En préparation
                    @break
                @case('pret')
                    <i class="fas fa-check"></i> Prêt
                    @break
                @case('livre')
                    <i class="fas fa-truck"></i> Livré
                    @break
                @case('annulee')
                    <i class="fas fa-times"></i> Annulée
                    @break
                @default
                    <i class="fas fa-clock"></i> {{ ucfirst($commande->statut) }}
            @endswitch
        </div>
    </div>

    <!-- Timeline statut -->
    <div class="timeline">
        <div class="timeline-step {{ $commande->statut != 'annulee' ? 'active' : '' }}">
            <div class="timeline-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="timeline-label">Commande passée</div>
            <div class="timeline-date">{{ $commande->created_at->format('d/m H:i') }}</div>
        </div>
        <div class="timeline-line {{ in_array($commande->statut, ['en_preparation', 'pret', 'livre']) ? 'active' : '' }}"></div>
        <div class="timeline-step {{ in_array($commande->statut, ['en_preparation', 'pret', 'livre']) ? 'active' : '' }}">
            <div class="timeline-icon"><i class="fas fa-cooking"></i></div>
            <div class="timeline-label">En préparation</div>
        </div>
        <div class="timeline-line {{ in_array($commande->statut, ['pret', 'livre']) ? 'active' : '' }}"></div>
        <div class="timeline-step {{ in_array($commande->statut, ['pret', 'livre']) ? 'active' : '' }}">
            <div class="timeline-icon"><i class="fas fa-check"></i></div>
            <div class="timeline-label">Prêt</div>
        </div>
        <div class="timeline-line {{ $commande->statut == 'livre' ? 'active' : '' }}"></div>
        <div class="timeline-step {{ $commande->statut == 'livre' ? 'active' : '' }}">
            <div class="timeline-icon"><i class="fas fa-truck"></i></div>
            <div class="timeline-label">Livré</div>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Liste des articles -->
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-utensils"></i> Articles commandés</h3>
            </div>
            <div class="card-body">
                <div class="items-list">
                    @if($commande->ligneCommandes && $commande->ligneCommandes->count() > 0)
                        @foreach($commande->ligneCommandes as $item)
                        <div class="item-row">
                            <div class="item-info">
                                <span class="item-name">{{ $item->menu->nom ?? 'Plat' }}</span>
                                <span class="item-quantity">x{{ $item->quantite }}</span>
                            </div>
                            <div class="item-price">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FC</div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3 text-muted">Aucun article trouvé</div>
                    @endif
                </div>
                
                <div class="totals">
                    <div class="total-row">
                        <span>Sous-total</span>
                        <span>{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span>
                    </div>
                    <div class="total-row">
                        <span>Frais de service (10%)</span>
                        <span>{{ number_format($commande->montant_total * 0.1, 0, ',', ' ') }} FC</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <span>{{ number_format($commande->montant_total * 1.1, 0, ',', ' ') }} FC</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations commande -->
        <div class="detail-card">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Informations</h3>
            </div>
            <div class="card-body">
                <div class="info-row">
                    <span class="info-label">Type :</span>
                    <span class="info-value">
                        @if($commande->type_commande == 'sur_place')
                            <i class="fas fa-chair"></i> Sur place
                        @else
                            <i class="fas fa-box"></i> À emporter
                        @endif
                    </span>
                </div>
                @if($commande->table)
                <div class="info-row">
                    <span class="info-label">Table :</span>
                    <span class="info-value">Table {{ $commande->table->numero }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Date :</span>
                    <span class="info-value">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($commande->notes)
                <div class="info-row">
                    <span class="info-label">Notes :</span>
                    <span class="info-value">{{ $commande->notes }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Statut :</span>
                    <span class="info-value">
                        @switch($commande->statut)
                            @case('en_attente') <span class="badge bg-warning">En attente</span> @break
                            @case('en_preparation') <span class="badge bg-info">En préparation</span> @break
                            @case('pret') <span class="badge bg-success">Prêt</span> @break
                            @case('livre') <span class="badge bg-secondary">Livré</span> @break
                            @case('annulee') <span class="badge bg-danger">Annulée</span> @break
                            @default <span class="badge bg-secondary">{{ $commande->statut }}</span>
                        @endswitch
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="detail-actions">
        <a href="{{ route('client.commandes.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        @if($commande->statut == 'en_attente')
            <button class="btn-cancel-large" onclick="cancelCommande({{ $commande->id }})">
                <i class="fas fa-times"></i> Annuler la commande
            </button>
        @endif
        <a href="{{ route('client.menu') }}" class="btn-order-large">
            <i class="fas fa-shopping-cart"></i> Commander à nouveau
        </a>
    </div>
</div>

<!-- Modal annulation -->
<div id="cancelModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Annuler la commande</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Êtes-vous sûr de vouloir annuler cette commande ?</p>
            <p class="warning-text">Cette action est irréversible.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Non, fermer</button>
            <button class="btn-danger" id="confirmCancelBtn">Oui, annuler</button>
        </div>
    </div>
</div>

<style>
.commande-detail-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1rem;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.85rem;
}

.breadcrumb a {
    color: #64748b;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: #ff9f43;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.detail-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.3rem;
}

.detail-date {
    color: #64748b;
    font-size: 0.85rem;
}

.status-badge {
    padding: 0.4rem 1.2rem;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.status-en_attente { background: #fff3e0; color: #ff9f43; }
.status-en_preparation { background: #e3f2fd; color: #2196f3; }
.status-pret { background: #e8f5e9; color: #4caf50; }
.status-livre { background: #e8eaf6; color: #5e35b1; }
.status-annulee { background: #ffebee; color: #e84393; }

/* Timeline */
.timeline {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    background: white;
    padding: 1.5rem;
    border-radius: 20px;
}

.timeline-step {
    text-align: center;
    flex: 1;
    position: relative;
    opacity: 0.4;
}

.timeline-step.active {
    opacity: 1;
}

.timeline-icon {
    width: 40px;
    height: 40px;
    background: #eef2f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem;
    color: #64748b;
}

.timeline-step.active .timeline-icon {
    background: linear-gradient(135deg, #ff9f43, #ff6b6b);
    color: white;
}

.timeline-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #1a1a2e;
}

.timeline-date {
    font-size: 0.6rem;
    color: #64748b;
}

.timeline-line {
    width: 60px;
    height: 2px;
    background: #eef2f6;
    margin: 0 -5px;
}

.timeline-line.active {
    background: linear-gradient(135deg, #ff9f43, #ff6b6b);
}

/* Grid */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.detail-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}

.card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eef2f6;
}

.card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.card-header h3 i {
    color: #ff9f43;
    margin-right: 8px;
}

.card-body {
    padding: 1rem 1.5rem;
}

/* Items */
.items-list {
    margin-bottom: 1rem;
}

.item-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eef2f6;
}

.item-info {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.item-name {
    font-weight: 500;
}

.item-quantity {
    font-size: 0.8rem;
    color: #64748b;
}

.totals {
    border-top: 1px solid #eef2f6;
    padding-top: 1rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.3rem 0;
    font-size: 0.85rem;
}

.grand-total {
    font-weight: 800;
    font-size: 1rem;
    color: #ff9f43;
    margin-top: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid #eef2f6;
}

/* Info */
.info-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.8rem;
}

.info-label {
    width: 100px;
    font-size: 0.8rem;
    color: #64748b;
}

.info-value {
    font-size: 0.85rem;
    color: #1a1a2e;
}

.badge {
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.7rem;
}
.bg-warning { background: #fff3e0; color: #ff9f43; }
.bg-info { background: #e3f2fd; color: #2196f3; }
.bg-success { background: #e8f5e9; color: #4caf50; }
.bg-secondary { background: #e8eaf6; color: #5e35b1; }
.bg-danger { background: #ffebee; color: #e84393; }

/* Actions */
.detail-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-back, .btn-cancel-large, .btn-order-large {
    padding: 0.6rem 1.5rem;
    border-radius: 40px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
}

.btn-back {
    background: #eef2f6;
    color: #64748b;
}

.btn-cancel-large {
    background: #ffebee;
    color: #e84393;
}

.btn-order-large {
    background: linear-gradient(135deg, #ff9f43, #ff6b6b);
    color: white;
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 450px;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eef2f6;
}

.modal-header h3 {
    margin: 0;
    color: #e84393;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.modal-body {
    padding: 1.5rem;
}

.warning-text {
    color: #e84393;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eef2f6;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-secondary {
    padding: 0.5rem 1rem;
    background: #eef2f6;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

.btn-danger {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #e84393, #fd79a8);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    .timeline {
        display: none;
    }
    .detail-actions {
        flex-direction: column;
    }
    .detail-actions a, .detail-actions button {
        justify-content: center;
    }
}
</style>

<script>
    let commandeIdToCancel = null;
    
    function cancelCommande(id) {
        commandeIdToCancel = id;
        document.getElementById('cancelModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
        commandeIdToCancel = null;
    }
    
    document.getElementById('confirmCancelBtn')?.addEventListener('click', async function() {
        if (!commandeIdToCancel) return;
        
        try {
            const response = await fetch(`/client/commandes/${commandeIdToCancel}/annuler`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                window.location.href = '{{ route("client.commandes.index") }}';
            } else {
                alert('Erreur: ' + (data.message || 'Impossible d\'annuler'));
                closeModal();
            }
        } catch (error) {
            alert('Une erreur est survenue');
            closeModal();
        }
    });
</script>
@endsection