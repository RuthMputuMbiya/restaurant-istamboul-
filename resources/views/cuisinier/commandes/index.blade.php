@extends('layouts.cuisinier')

@section('title', 'Commandes cuisine')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-cooking text-primary me-2"></i>Commandes en cuisine
            </h1>
            <p class="text-muted">Gérez la préparation des commandes</p>
        </div>
    </div>

    <!-- Onglets -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ $statut == 'en_attente' ? 'active' : '' }}" href="{{ route('cuisinier.commandes', ['statut' => 'en_attente']) }}">
                <i class="fas fa-clock me-1"></i> En attente
                @if($commandes->where('statut', 'en_attente')->count() > 0)
                <span class="badge bg-warning ms-1">{{ $commandes->where('statut', 'en_attente')->count() }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $statut == 'en_preparation' ? 'active' : '' }}" href="{{ route('cuisinier.commandes', ['statut' => 'en_preparation']) }}">
                <i class="fas fa-cooking me-1"></i> En préparation
                @if($commandes->where('statut', 'en_preparation')->count() > 0)
                <span class="badge bg-info ms-1">{{ $commandes->where('statut', 'en_preparation')->count() }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $statut == 'pret' ? 'active' : '' }}" href="{{ route('cuisinier.commandes', ['statut' => 'pret']) }}">
                <i class="fas fa-check-circle me-1"></i> Prêts à servir
                @if($commandes->where('statut', 'pret')->count() > 0)
                <span class="badge bg-success ms-1">{{ $commandes->where('statut', 'pret')->count() }}</span>
                @endif
            </a>
        </li>
    </ul>

    <div class="row">
        @forelse($commandes as $commande)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card commande-card h-100 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5">#{{ $commande->id }}</span>
                        <span class="badge {{ $commande->statut == 'en_attente' ? 'bg-warning' : ($commande->statut == 'en_preparation' ? 'bg-info' : 'bg-success') }}">
                            {{ $commande->statut == 'en_attente' ? 'En attente' : ($commande->statut == 'en_preparation' ? 'En préparation' : 'Prêt') }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Table / Client</small>
                        <div class="fw-bold">
                            @if($commande->table)
                            <i class="fas fa-chair me-1"></i> Table {{ $commande->table->numero }}
                            @else
                            <i class="fas fa-box me-1"></i> À emporter
                            @endif
                            @if($commande->client)
                            <br><small class="text-muted">{{ $commande->client->name }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Plats commandés</small>
                        <div class="items-list">
                            @foreach($commande->ligneCommandes as $item)
                            <div class="item-row">
                                <span class="item-name">{{ $item->menu->nom ?? 'Plat' }}</span>
                                <span class="item-qty">x{{ $item->quantite }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Total:</span>
                            <span class="fw-bold text-primary">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span>
                        </div>
                    </div>
                    @if($commande->notes)
                    <div class="alert alert-warning py-2 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        <small>{{ $commande->notes }}</small>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    @if($commande->statut == 'en_attente')
                    <form action="{{ route('cuisinier.commandes.demarrer', $commande->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info w-100 rounded-pill">
                            <i class="fas fa-play me-2"></i>Démarrer la préparation
                        </button>
                    </form>
                    @elseif($commande->statut == 'en_preparation')
                    <form action="{{ route('cuisinier.commandes.pret', $commande->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 rounded-pill">
                            <i class="fas fa-check-circle me-2"></i>Marquer comme prêt
                        </button>
                    </form>
                    @elseif($commande->statut == 'pret')
                    <div class="text-center text-success">
                        <i class="fas fa-check-circle me-1"></i> Prêt à être servi
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h4>Aucune commande</h4>
                <p class="text-muted">Toutes les commandes sont terminées</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .commande-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        border-radius: 16px;
    }
    .commande-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    .items-list {
        max-height: 150px;
        overflow-y: auto;
    }
    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        border-bottom: 1px dashed #e9ecef;
    }
    .item-name {
        font-size: 0.9rem;
    }
    .item-qty {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .nav-tabs .nav-link {
        border-radius: 30px;
        margin-right: 10px;
        padding: 8px 20px;
    }
    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
    }
    .btn {
        transition: all 0.3s;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Pas de scripts supplémentaires nécessaires
</script>
@endpush
@endsection