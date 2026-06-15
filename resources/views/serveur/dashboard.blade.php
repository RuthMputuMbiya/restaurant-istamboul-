@extends('layouts.serveur')

@section('title', 'Dashboard Serveur')

@section('serveur-content')
<div class="container-fluid px-4 py-4">

    <!-- ========================================== -->
    <!-- EN-TÊTE -->
    <!-- ========================================== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-header">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <div class="header-title">
                        <h1 class="fw-bold mb-0">Espace Serveur</h1>
                        <p class="text-muted mb-0">Gestion des tables et commandes</p>
                    </div>
                </div>
                <div class="header-right">
                    <div class="date-badge">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->translatedFormat('l d F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- CARTES STATISTIQUES - 3 CARTES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-primary-light">
                    <i class="fas fa-chair text-primary"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Tables libres</div>
                    <div class="stats-number">{{ $tablesLibres ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-warning-light">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Commandes en cours</div>
                    <div class="stats-number">{{ $commandesEnCoursTotal ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-icon bg-success-light">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-label">Commandes prêtes</div>
                    <div class="stats-number">{{ $commandesPretesTotal ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION PRINCIPALE - 2 COLONNES -->
    <!-- ========================================== -->
    <div class="row g-4">
        
        <!-- Plan des tables -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chair text-primary me-2"></i>Plan des tables
                    </h5>
                </div>
                <div class="card-body">
                    <div class="tables-grid">
                        @forelse($tables ?? [] as $table)
                        <div class="table-card {{ $table->statut }}">
                            <div class="table-number">{{ $table->numero }}</div>
                            <div class="table-capacite">
                                <i class="fas fa-users"></i> {{ $table->capacite }}
                            </div>
                            <div class="table-status mt-1">
                                @if($table->statut == 'libre')
                                    <span class="badge bg-success px-3">Libre</span>
                                @elseif($table->statut == 'occupee')
                                    <span class="badge bg-danger px-3">Occupée</span>
                                @else
                                    <span class="badge bg-warning px-3">Réservée</span>
                                @endif
                            </div>
                            @if($table->statut == 'libre')
                            <a href="/serveur/commandes/create?table_id={{ $table->id }}" class="btn-commander mt-2">
                                <i class="fas fa-plus"></i> Commander
                            </a>
                            @endif
                        </div>
                        @empty
                        <div class="col-12 text-center py-4">
                            <p class="text-muted">Aucune table configurée</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes actives (liste simplifiée) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>Commandes en cours
                        <span class="badge bg-warning ms-2">{{ $commandesEnCoursTotal ?? 0 }}</span>
                    </h5>
                    <a href="/serveur/commandes" class="btn-view-all">
                        <i class="fas fa-eye me-1"></i> Voir tout
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Table</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandesActives ?? [] as $commande)
                                <tr>
                                    <td>
                                        <span class="fw-bold">Table {{ $commande->table->numero ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($commande->client)
                                            {{ $commande->client->name }}
                                        @else
                                            <span class="text-muted">Sur place</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</td>
                                    <td>
                                        @php
                                            $badgeClass = match($commande->statut) {
                                                'en_attente' => 'warning',
                                                'validee' => 'info',
                                                'en_preparation' => 'primary',
                                                'pret' => 'success',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }} rounded-pill px-3 py-2">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="/serveur/commandes/{{ $commande->id }}" class="btn-action" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Aucune commande active</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- COMMANDES PRÊTES À SERVIR -->
    <!-- ========================================== -->
    @if(isset($commandesPretesList) && $commandesPretesList->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fas fa-bell me-2"></i>
                        Commandes prêtes à servir 
                        <span class="badge bg-success ms-2">{{ $commandesPretesList->count() }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Table</th>
                                    <th>Plats</th>
                                    <th>Temps</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesPretesList as $commande)
                                <tr>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</td>
                                    <td>
                                        @foreach($commande->ligneCommandes as $ligne)
                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $ligne->quantite }}x {{ $ligne->menu->nom }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $commande->created_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <form action="/serveur/commandes/{{ $commande->id }}/servir" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                <i class="fas fa-utensils me-1"></i> Servir
                                            </button>
                                        </form>
                                    </td>
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

    <!-- ========================================== -->
    <!-- ACTIONS RAPIDES -->
    <!-- ========================================== -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="quick-actions">
                <div class="quick-header">
                    <i class="fas fa-bolt me-2"></i> Actions rapides
                </div>
                <div class="quick-grid">
                    <a href="/serveur/commandes/create" class="quick-btn">
                        <i class="fas fa-cart-plus"></i> Nouvelle commande
                    </a>
                    <a href="/serveur/paiement" class="quick-btn">
                        <i class="fas fa-credit-card"></i> Encaissement
                    </a>
                    <a href="/serveur/tables" class="quick-btn">
                        <i class="fas fa-chair"></i> Gérer les tables
                    </a>
                    <a href="/serveur/planning" class="quick-btn">
                        <i class="fas fa-calendar-alt"></i> Planning
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 0;
    }
    .header-left { display: flex; align-items: center; gap: 20px; }
    .header-icon {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
    }
    .header-icon i { font-size: 28px; color: white; }
    .date-badge {
        background: #f1f5f9;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 500;
        color: #475569;
    }

    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .stats-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .bg-primary-light { background: #dbeafe; }
    .bg-warning-light { background: #fef3c7; }
    .bg-success-light { background: #d1fae5; }
    
    .stats-content { flex: 1; }
    .stats-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .stats-number { font-size: 28px; font-weight: 800; margin: 5px 0 0; color: #1e293b; }

    /* Tables Grid */
    .tables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }
    .table-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 12px;
        text-align: center;
        transition: all 0.2s ease;
    }
    .table-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .table-card.libre { border-color: #10b981; background: #f0fdf4; }
    .table-card.occupee { border-color: #ef4444; background: #fef2f2; }
    .table-card.reservee { border-color: #f59e0b; background: #fffbeb; }
    .table-number { font-size: 20px; font-weight: 800; color: #1e293b; }
    .table-capacite { font-size: 10px; color: #64748b; margin: 5px 0; }
    .btn-commander {
        display: inline-block;
        margin-top: 8px;
        padding: 4px 12px;
        background: #10b981;
        color: white;
        border-radius: 20px;
        font-size: 10px;
        text-decoration: none;
    }
    .btn-commander:hover { background: #059669; }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #64748b;
        transition: all 0.2s;
    }
    .btn-action:hover { background: #3b82f6; color: white; }
    .btn-view-all {
        background: #f1f5f9;
        padding: 5px 15px;
        border-radius: 30px;
        color: #3b82f6;
        text-decoration: none;
        font-size: 12px;
        transition: all 0.2s;
    }
    .btn-view-all:hover { background: #3b82f6; color: white; }

    /* Quick Actions */
    .quick-actions {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #e2e8f0;
    }
    .quick-header {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .quick-grid { display: flex; flex-wrap: wrap; gap: 12px; }
    .quick-btn {
        background: white;
        padding: 8px 20px;
        border-radius: 40px;
        color: #475569;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #e2e8f0;
    }
    .quick-btn:hover { background: #f59e0b; color: white; border-color: #f59e0b; }

    .table th, .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
</style>
@endpush
@endsection