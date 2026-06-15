{{-- resources/views/gerant/dashboard.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Aperçu général de votre restaurant')

@section('gerant-content')
<div class="container-fluid px-0">

    <!-- ========================================== -->
    <!-- CARTES STATISTIQUES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Commandes totales</div>
                    <div class="stat-value">{{ $commandesAujourdhui ?? 0 }}</div>
                    <span class="stat-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> +12%
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Chiffre d'affaires</div>
                    <div class="stat-value">{{ number_format($chiffreAffaires ?? 0, 0, ',', ' ') }} FC</div>
                    <span class="stat-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> +8%
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Clients inscrits</div>
                    <div class="stat-value">{{ $totalClients ?? 0 }}</div>
                    <span class="stat-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> +5%
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Tables libres</div>
                    <div class="stat-value">{{ $tablesLibres ?? 0 }} / {{ $totalTables ?? 0 }}</div>
                    <span class="stat-trend trend-up">
                        <i class="fas fa-arrow-up me-1"></i> +2
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- DEUXIÈME LIGNE DE STATS -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Réservations aujourd'hui</div>
                    <div class="stat-value">{{ $reservationsJour ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Commandes en attente</div>
                    <div class="stat-value">{{ $commandesEnAttente ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">En préparation</div>
                    <div class="stat-value">{{ $commandesEnPreparation ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- GRAPHIQUE ET TOP PLATS -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Évolution du chiffre d'affaires
                    </h5>
                    <p class="widget-subtitle">7 derniers jours</p>
                </div>
                <div class="widget-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="fas fa-trophy text-warning me-2"></i>
                        Top 5 plats
                    </h5>
                    <p class="widget-subtitle">Les plus vendus</p>
                </div>
                <div class="widget-body">
                    @forelse($topPlats ?? [] as $index => $plat)
                    <div class="rank-item">
                        <div class="rank-number">{{ $index + 1 }}</div>
                        <div class="rank-info">
                            <div class="rank-name">{{ $plat->nom }}</div>
                            <div class="rank-sales">{{ $plat->total_ventes }} ventes</div>
                        </div>
                        <div class="rank-percent">
                            {{ round(($plat->total_ventes / ($topPlats->first()->total_ventes ?? 1)) * 100) }}%
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-chart-simple fa-3x text-muted mb-2"></i>
                        <p class="text-muted">Aucune donnée disponible</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- DERNIÈRES COMMANDES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="data-card">
                <div class="data-header">
                    <h5 class="data-title">
                        <i class="fas fa-clock text-warning me-2"></i>
                        Dernières commandes
                    </h5>
                    <a href="#" class="btn-view-all" onclick="alert('Voir toutes les commandes - Page en construction')">Voir tout</a>
                </div>
                <div class="data-body p-0">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Table</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresCommandes ?? [] as $commande)
                                <tr>
                                    <td>#{{ $commande->id }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ number_format($commande->montant_total ?? 0, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @php
                                            $statusClass = match($commande->statut) {
                                                'validee' => 'status-warning',
                                                'en_preparation' => 'status-info',
                                                'pret', 'paye' => 'status-success',
                                                default => 'status-secondary'
                                            };
                                            $statusText = match($commande->statut) {
                                                'validee' => 'Validée',
                                                'en_preparation' => 'En préparation',
                                                'pret' => 'Prête',
                                                'paye' => 'Payée',
                                                default => ucfirst($commande->statut ?? 'En attente')
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                        <p class="text-muted">Aucune commande récente</p>
                                    </span>
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
    <!-- ACTIONS RAPIDES -->
    <!-- ========================================== -->
    <div class="row">
        <div class="col-12">
            <div class="quick-actions">
                <div class="quick-header">
                    <i class="fas fa-bolt me-2"></i> Actions rapides
                </div>
                <div class="quick-grid">
                    <a href="#" class="quick-btn" onclick="alert('Gestion du menu - Page en construction')">
                        <i class="fas fa-utensils"></i> Gérer le menu
                    </a>
                    <a href="#" class="quick-btn" onclick="alert('Gestion des catégories - Page en construction')">
                        <i class="fas fa-tags"></i> Catégories
                    </a>
                    <a href="#" class="quick-btn" onclick="alert('Gestion des tables - Page en construction')">
                        <i class="fas fa-chair"></i> Tables
                    </a>
                    <a href="#" class="quick-btn" onclick="alert('Statistiques - Page en construction')">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                    <a href="#" class="quick-btn" onclick="alert('Réservations - Page en construction')">
                        <i class="fas fa-calendar-alt"></i> Réservations
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-primary .stat-icon { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .stat-success .stat-icon { background: linear-gradient(135deg, #bccac5 0%, #0a7682 100%); }
    .stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-info .stat-icon { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-icon i { font-size: 24px; color: white; }
    .stat-info { flex: 1; }
    .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-value { font-size: 24px; font-weight: 800; margin: 5px 0 0 0; color: #1e293b; }
    .stat-trend { font-size: 11px; display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; }
    .trend-up { background: #e8f8f5; color: #08446e; }

    /* Widget Cards */
    .widget-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
    }
    .widget-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
    }
    .widget-title { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .widget-subtitle { font-size: 12px; color: #64748b; margin: 5px 0 0 0; }
    .widget-body { padding: 20px; }

    /* Data Cards */
    .data-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .data-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .data-title { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
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

    /* Data Table */
    .data-table { width: 100%; }
    .data-table th {
        background: #f8fafc;
        padding: 12px 15px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Status Badges */
    .status-badge { padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 600; display: inline-block; }
    .status-warning { background: #fef3c7; color: #d97706; }
    .status-info { background: #dbeafe; color: #2563eb; }
    .status-success { background: #d1fae5; color: #083f6e; }
    .status-secondary { background: #f1f5f9; color: #64748b; }

    /* Rank Items */
    .rank-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .rank-number {
        width: 30px;
        height: 30px;
        background: #f59e0b;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }
    .rank-info { flex: 1; }
    .rank-name { font-weight: 600; font-size: 14px; }
    .rank-sales { font-size: 11px; color: #64748b; }
    .rank-percent { font-weight: 700; color: #10b981; }

    /* Quick Actions */
    .quick-actions {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 20px;
        padding: 25px;
    }
    .quick-header {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .quick-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .quick-btn {
        background: rgba(255,255,255,0.1);
        padding: 10px 22px;
        border-radius: 40px;
        color: white;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .quick-btn:hover {
        background: #055569;
        color: white;
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des ventes
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($joursSemaine ?? ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']) !!},
            datasets: [{
                label: 'Chiffre d\'affaires (FC)',
                data: {!! json_encode($ventesParJour ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#10b981',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@endsection