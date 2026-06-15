@extends('layouts.client')

@section('title', 'Mes commandes')

@section('content')
<div class="orders-page">
    <div class="container">
        <!-- Header Section -->
        <div class="orders-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div>
                    <h1 class="header-title">Mes commandes</h1>
                    <p class="header-subtitle">Suivez l'évolution de vos commandes en temps réel</p>
                </div>
            </div>
            <a href="{{ route('client.menu') }}" class="btn-new-order">
                <i class="fas fa-plus-circle"></i>
                <span>Nouvelle commande</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card stat-total">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="stat-info">
                    <span class="stat-value">{{ $commandes->total() }}</span>
                    <span class="stat-label">Total commandes</span>
                </div>
            </div>
            <div class="stat-card stat-warning">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <span class="stat-value">{{ $commandes->where('statut', 'en_attente')->count() }}</span>
                    <span class="stat-label">En attente</span>
                </div>
            </div>
            <div class="stat-card stat-info">
                <div class="stat-icon"><i class="fas fa-cooking"></i></div>
                <div class="stat-info">
                    <span class="stat-value">{{ $commandes->where('statut', 'en_preparation')->count() }}</span>
                    <span class="stat-label">En préparation</span>
                </div>
            </div>
            <div class="stat-card stat-success">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <span class="stat-value">{{ $commandes->where('statut', 'pret')->count() }}</span>
                    <span class="stat-label">Prêtes</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-wrapper">
            <div class="filters-container">
                <div class="filter-label"><i class="fas fa-filter"></i><span>Filtrer par :</span></div>
                <div class="filter-buttons">
                    <a href="{{ route('client.commandes.index') }}" class="filter-chip {{ !request('statut') ? 'active' : '' }}"><i class="fas fa-th-large"></i><span>Toutes</span></a>
                    <a href="{{ route('client.commandes.index', ['statut' => 'en_attente']) }}" class="filter-chip {{ request('statut') == 'en_attente' ? 'active' : '' }}"><i class="fas fa-clock"></i><span>En attente</span></a>
                    <a href="{{ route('client.commandes.index', ['statut' => 'en_preparation']) }}" class="filter-chip {{ request('statut') == 'en_preparation' ? 'active' : '' }}"><i class="fas fa-cooking"></i><span>En préparation</span></a>
                    <a href="{{ route('client.commandes.index', ['statut' => 'pret']) }}" class="filter-chip {{ request('statut') == 'pret' ? 'active' : '' }}"><i class="fas fa-check-double"></i><span>Prêt</span></a>
                    <a href="{{ route('client.commandes.index', ['statut' => 'livre']) }}" class="filter-chip {{ request('statut') == 'livre' ? 'active' : '' }}"><i class="fas fa-truck"></i><span>Livré</span></a>
                    <a href="{{ route('client.commandes.index', ['statut' => 'annulee']) }}" class="filter-chip {{ request('statut') == 'annulee' ? 'active' : '' }}"><i class="fas fa-ban"></i><span>Annulée</span></a>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        @if($commandes->count() > 0)
            <div class="orders-list">
                @foreach($commandes as $commande)
                <div class="order-card" data-status="{{ $commande->statut }}">
                    <div class="order-card-header">
                        <div class="order-info">
                            <div class="order-number"><i class="fas fa-hashtag"></i><span>{{ $commande->numero_commande ?? $commande->id }}</span></div>
                            <div class="order-date"><i class="far fa-calendar-alt"></i><span>{{ $commande->created_at->format('d/m/Y') }}</span><span class="order-time">{{ $commande->created_at->format('H:i') }}</span></div>
                        </div>
                        <div class="status-badge status-{{ $commande->statut }}">
                            <div class="status-dot"></div>
                            <span>
                                @switch($commande->statut)
                                    @case('en_attente') En attente @break
                                    @case('validee') Validée @break
                                    @case('en_preparation') En préparation @break
                                    @case('pret') Prêt @break
                                    @case('recuperee') Récupérée @break
                                    @case('annulee') Annulée @break
                                    @default {{ ucfirst($commande->statut) }}
                                @endswitch
                            </span>
                        </div>
                    </div>

                    <div class="order-card-body">
                        <div class="order-items">
                            <div class="items-icon"><i class="fas fa-utensils"></i></div>
                            <div class="items-info">
                                <span class="items-count">{{ $commande->ligneCommandes->sum('quantite') }} articles</span>
                                <span class="items-detail">
                                    @foreach($commande->ligneCommandes->take(2) as $item)
                                        {{ $item->menu->nom }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                    @if($commande->ligneCommandes->count() > 2)
                                        <span class="more-items">+{{ $commande->ligneCommandes->count() - 2 }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="order-total">
                            <span class="total-label">Total</span>
                            <span class="total-value">{{ number_format($commande->montant_total, 0, ',', ' ') }} <small>FC</small></span>
                        </div>
                    </div>

                    <div class="order-card-footer">
                        <a href="{{ route('client.commandes.show', $commande->id) }}" class="btn-details"><i class="fas fa-eye"></i><span>Détails</span></a>
                        
                        @if($commande->statut == 'en_attente')
                            <button class="btn-cancel" onclick="annulerCommande({{ $commande->id }})"><i class="fas fa-times"></i><span>Annuler</span></button>
                        @endif
                        
                        @if($commande->statut == 'pret')
                            <button class="btn-success" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 30px; padding: 8px 20px;" onclick="confirmerRecuperation({{ $commande->id }})">
                                <i class="fas fa-check-circle me-1"></i> Je récupère ma commande
                            </button>
                        @endif
                        
                        @if($commande->statut == 'recuperee')
                            <div class="ready-badge" style="background: #6c757d;"><i class="fas fa-check-circle me-1"></i> Récupérée</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pagination-container">{{ $commandes->appends(request()->query())->links() }}</div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-shopping-bag"></i><div class="empty-state-glow"></div></div>
                <h3>Aucune commande</h3>
                <p>Vous n'avez pas encore passé de commande.</p>
                <a href="{{ route('client.menu') }}" class="btn-order-now"><i class="fas fa-shopping-cart"></i><span>Commander maintenant</span><i class="fas fa-arrow-right"></i></a>
            </div>
        @endif
    </div>
</div>

<style>
.orders-page { background: linear-gradient(135deg, #f5f7fb 0%, #f0f2f6 100%); min-height: 100vh; padding: 2rem 0; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
.orders-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem; }
.header-content { display: flex; align-items: center; gap: 1rem; }
.header-icon { width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(245,158,11,0.3); }
.header-icon i { font-size: 1.8rem; color: white; }
.header-title { font-size: 1.8rem; font-weight: 800; color: #1a1a2e; margin-bottom: 0.25rem; }
.header-subtitle { color: #64748b; font-size: 0.9rem; }
.btn-new-order { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; }
.btn-new-order:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,158,11,0.4); color: white; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
.stat-card { background: white; border-radius: 20px; padding: 1.2rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
.stat-icon { width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 0.5rem; }
.stat-card.stat-total .stat-icon { background: rgba(108,92,231,0.1); color: #6c5ce7; }
.stat-card.stat-warning .stat-icon { background: rgba(245,158,11,0.1); color: #f59e0b; }
.stat-card.stat-info .stat-icon { background: rgba(33,150,243,0.1); color: #2196f3; }
.stat-card.stat-success .stat-icon { background: rgba(16,185,129,0.1); color: #10b981; }
.stat-icon i { font-size: 1.3rem; }
.stat-value { font-size: 1.8rem; font-weight: 800; display: block; color: #1e293b; }
.stat-label { font-size: 0.7rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
.filters-wrapper { background: white; border-radius: 60px; padding: 0.5rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.filters-container { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.filter-label { display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem; background: #f8f9fa; border-radius: 40px; color: #64748b; font-size: 0.8rem; }
.filter-buttons { display: flex; flex-wrap: wrap; gap: 0.5rem; flex: 1; }
.filter-chip { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.2rem; background: transparent; border-radius: 40px; text-decoration: none; color: #64748b; font-size: 0.8rem; font-weight: 500; transition: all 0.3s; }
.filter-chip:hover { background: rgba(245,158,11,0.1); color: #f59e0b; }
.filter-chip.active { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; box-shadow: 0 4px 10px rgba(245,158,11,0.3); }
.order-card { background: white; border-radius: 16px; overflow: hidden; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 1rem; }
.order-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
.order-card-header { display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 1.2rem; background: #fafbfc; border-bottom: 1px solid #e2e8f0; }
.order-info { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
.order-number { display: flex; align-items: center; gap: 0.5rem; font-weight: 700; font-size: 0.9rem; color: #1e293b; }
.order-number i { color: #f59e0b; }
.order-date { display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: #64748b; }
.order-time { background: #e2e8f0; padding: 0.15rem 0.5rem; border-radius: 20px; }
.status-badge { display: flex; align-items: center; gap: 0.5rem; padding: 0.3rem 0.8rem; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
.status-en_attente { background: #fef3c7; color: #d97706; }
.status-validee { background: #dbeafe; color: #2563eb; }
.status-en_preparation { background: #e0e7ff; color: #4f46e5; }
.status-pret { background: #d1fae5; color: #059669; }
.status-recuperee { background: #e2e3e5; color: #6c757d; }
.status-annulee { background: #fee2e2; color: #dc2626; }
.order-card-body { display: flex; justify-content: space-between; align-items: center; padding: 0.8rem 1.2rem; }
.order-items { display: flex; align-items: center; gap: 0.75rem; }
.items-icon { width: 35px; height: 35px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f59e0b; }
.items-info { display: flex; flex-direction: column; }
.items-count { font-weight: 600; font-size: 0.8rem; }
.items-detail { font-size: 0.65rem; color: #64748b; }
.order-total { text-align: right; }
.total-label { font-size: 0.65rem; color: #64748b; display: block; }
.total-value { font-size: 1rem; font-weight: 800; color: #f59e0b; }
.order-card-footer { display: flex; gap: 0.5rem; justify-content: flex-end; padding: 0.8rem 1.2rem; background: #fafbfc; border-top: 1px solid #e2e8f0; }
.btn-details, .btn-cancel { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3rem 0.8rem; border-radius: 30px; text-decoration: none; font-size: 0.7rem; font-weight: 500; transition: all 0.3s; cursor: pointer; border: none; }
.btn-details { background: #e2e8f0; color: #64748b; }
.btn-details:hover { background: #cbd5e1; color: #f59e0b; }
.btn-cancel { background: #fee2e2; color: #dc2626; }
.btn-cancel:hover { background: #fecaca; transform: scale(0.98); }
.ready-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3rem 0.8rem; background: #10b981; color: white; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
.empty-state { text-align: center; padding: 3rem; background: white; border-radius: 24px; }
.empty-state-icon { position: relative; width: 80px; height: 80px; margin: 0 auto 1rem; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.empty-state-icon i { font-size: 2.5rem; color: #f59e0b; }
.pagination-container { margin-top: 1.5rem; display: flex; justify-content: center; }
@media (max-width: 768px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    .order-card-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    .order-card-body { flex-direction: column; gap: 0.5rem; align-items: flex-start; }
    .order-total { text-align: left; width: 100%; }
}
</style>

<script>
function annulerCommande(id) {
    if(confirm('Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.')) {
        fetch(`/client/commandes/${id}/annuler`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  location.reload();
              } else {
                  alert('Erreur lors de l\'annulation');
              }
          });
    }
}

function confirmerRecuperation(commandeId) {
    if(confirm('Confirmez-vous que vous avez récupéré votre commande ?')) {
        fetch(`/client/commandes/${commandeId}/recuperer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erreur de connexion');
        });
    }
}
</script>
@endsection