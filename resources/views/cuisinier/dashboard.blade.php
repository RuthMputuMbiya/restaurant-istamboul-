@extends('layouts.cuisinier')

@section('title', 'Dashboard Cuisinier')
@section('page-title', 'Espace Cuisinier')
@section('page-subtitle', 'Gestion des commandes en cuisine')

@section('cuisinier-content')
<div class="container-fluid px-4 py-4">

    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card stats-primary">
                <div class="stats-icon"><i class="fas fa-clock"></i></div>
                <div class="stats-content">
                    <div class="stats-label">À préparer</div>
                    <div class="stats-number">{{ $commandesValidees->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-warning">
                <div class="stats-icon"><i class="fas fa-fire"></i></div>
                <div class="stats-content">
                    <div class="stats-label">En préparation</div>
                    <div class="stats-number">{{ $commandesEnPreparation->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card stats-success">
                <div class="stats-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stats-content">
                    <div class="stats-label">Prêtes</div>
                    <div class="stats-number">{{ $commandesPretes->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commandes à préparer -->
    @if($commandesValidees->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-clock me-2"></i>Commandes à préparer
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Table</th>
                                    <th>Plats</th>
                                    <th>Date</th>
                                    <th class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesValidees as $commande)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $commande->id }}</span>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</span>
                                    <td>
                                        @foreach($commande->ligneCommandes as $ligne)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $ligne->quantite }}x {{ $ligne->menu->nom }}</span>
                                        @endforeach
                                    </span>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                                    <td class="pe-4">
                                        <form action="{{ route('cuisinier.commandes.demarrer', $commande->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm" style="background: #3b82f6; color: white; border-radius: 30px; padding: 5px 15px;">
                                                <i class="fas fa-play me-1"></i>Démarrer
                                            </button>
                                        </form>
                                    </span>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Commandes en préparation -->
    @if($commandesEnPreparation->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="fas fa-fire me-2"></i>En préparation
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Table</th>
                                    <th>Plats</th>
                                    <th>Temps</th>
                                    <th class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesEnPreparation as $commande)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $commande->id }}</span>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</span>
                                    <td>
                                        @foreach($commande->ligneCommandes as $ligne)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $ligne->quantite }}x {{ $ligne->menu->nom }}</span>
                                        @endforeach
                                    </span>
                                    <td>{{ $commande->updated_at->diffForHumans() }}</span>
                                    <td class="pe-4">
                                        <form action="{{ route('cuisinier.commandes.pret', $commande->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm" style="background: #10b981; color: white; border-radius: 30px; padding: 5px 15px;">
                                                <i class="fas fa-check me-1"></i>Marquer prêt
                                            </button>
                                        </form>
                                    </span>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Commandes prêtes -->
    @if($commandesPretes->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fas fa-check-circle me-2"></i>Commandes prêtes à servir
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Table</th>
                                    <th>Plats</th>
                                    <th>Prêt depuis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesPretes as $commande)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $commande->id }}</span>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</span>
                                    <td>
                                        @foreach($commande->ligneCommandes as $ligne)
                                            <span class="badge bg-secondary me-1 mb-1">{{ $ligne->quantite }}x {{ $ligne->menu->nom }}</span>
                                        @endforeach
                                    </span>
                                    <td>{{ $commande->updated_at->diffForHumans() }}</span>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($commandesValidees->count() == 0 && $commandesEnPreparation->count() == 0 && $commandesPretes->count() == 0)
    <div class="text-center py-5">
        <i class="fas fa-check-circle fa-4x text-success mb-3 d-block"></i>
        <h4 class="text-muted">Aucune commande en cuisine</h4>
        <p class="text-muted">Les commandes apparaîtront ici lorsqu'elles seront validées</p>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s;
    }
    .stats-card:hover { transform: translateY(-3px); }
    
    .stats-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    .stats-primary .stats-icon { background: #3b82f6; }
    .stats-warning .stats-icon { background: #f59e0b; }
    .stats-success .stats-icon { background: #10b981; }
    
    .stats-number { font-size: 28px; font-weight: 800; margin: 5px 0 0; color: #1e293b; }
    .stats-label { font-size: 12px; color: #6c757d; text-transform: uppercase; }
    
    .table td { vertical-align: middle; }
    .badge { font-weight: 500; }
</style>
@endpush