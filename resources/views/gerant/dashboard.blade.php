@extends('layouts.gerant')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Aperçu général de votre restaurant')

@section('gerant-content')
<div class="container-fluid px-0">

    <!-- ========================================== -->
    <!-- EN-TÊTE D'ACCUEIL -->
    <!-- ========================================== -->
    <div class="welcome-section mb-4">
        <div class="welcome-card">
            <div class="welcome-content">
                <div>
                    <h2 class="welcome-title">👋 Bonjour, {{ Auth::user()->name ?? 'Gérant' }} !</h2>
                    <p class="welcome-subtitle">Voici un aperçu de l'activité de votre restaurant</p>
                </div>
                <div class="welcome-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>
    </div>

  

    <!-- ========================================== -->
    <!-- DEUXIÈME LIGNE - 3 CARTES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card stat-card-alt">
                <div class="stat-icon bg-primary-light">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $reservationsJour ?? 0 }}</div>
                    <div class="stat-label">Réservations aujourd'hui</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-alt">
                <div class="stat-icon bg-success-light">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $commandesEnAttente ?? 0 }}</div>
                    <div class="stat-label">Commandes en attente</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card stat-card-alt">
                <div class="stat-icon bg-warning-light">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $commandesEnPreparation ?? 0 }}</div>
                    <div class="stat-label">En préparation</div>
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
                    @if(isset($topPlats) && $topPlats->count() > 0)
                        @foreach($topPlats as $index => $plat)
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
                        @endforeach
                    @else
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-chart-simple fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">Aucune donnée disponible</p>
                            <span class="text-muted small">Les ventes apparaîtront ici</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- DERNIÈRES COMMANDES -->
    <!-- ========================================== -->
    <div class="row g-4">
        <div class="col-12">
            <div class="widget-card">
                <div class="widget-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-warning me-2"></i>
                        <h5 class="widget-title mb-0">Dernières commandes</h5>
                    </div>
                    <span class="text-muted small">5 dernières commandes</span>
                </div>
                <div class="widget-body p-0">
                    @if(isset($dernieresCommandes) && $dernieresCommandes->count() > 0)
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
                                    @foreach($dernieresCommandes as $commande)
                                    <tr>
                                        <td>#{{ $commande->id }}</td>
                                        <td>Table {{ $commande->table->numero ?? 'N/A' }}</td>
                                        <td>{{ number_format($commande->montant_total ?? 0, 0, ',', ' ') }} FC</td>
                                        <td>
                                            @php
                                                $statusConfig = [
                                                    'en_attente' => ['class' => 'status-warning', 'text' => 'En attente'],
                                                    'validee' => ['class' => 'status-info', 'text' => 'Validée'],
                                                    'en_preparation' => ['class' => 'status-primary', 'text' => 'En préparation'],
                                                    'pret' => ['class' => 'status-success', 'text' => 'Prête'],
                                                    'paye' => ['class' => 'status-success', 'text' => 'Payée'],
                                                    'servi' => ['class' => 'status-secondary', 'text' => 'Servie'],
                                                ];
                                                $config = $statusConfig[$commande->statut] ?? ['class' => 'status-secondary', 'text' => ucfirst($commande->statut)];
                                            @endphp
                                            <span class="status-badge {{ $config['class'] }}">{{ $config['text'] }}</span>
                                        </td>
                                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">Aucune commande récente</p>
                            <span class="text-muted small">Les commandes apparaîtront ici</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* ========================================== */
    /* WELCOME SECTION */
    /* ========================================== */
    .welcome-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 24px;
        padding: 30px 35px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::before {
        content: '🍽️';
        position: absolute;
        bottom: -20px;
        right: 20px;
        font-size: 120px;
        opacity: 0.08;
    }
    .welcome-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .welcome-subtitle {
        font-size: 14px;
        opacity: 0.8;
        margin: 0;
    }
    .welcome-date {
        font-size: 14px;
        opacity: 0.8;
        padding: 8px 16px;
        background: rgba(255,255,255,0.12);
        border-radius: 30px;
        backdrop-filter: blur(10px);
    }
    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        position: relative;
        z-index: 2;
    }

    /* ========================================== */
    /* STAT CARDS */
    /* ========================================== */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
    }
    .stat-card-alt {
        background: #f8fafc;
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        flex-shrink: 0;
    }
    .bg-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-success { background: linear-gradient(135deg, #10b981, #059669); }
    .bg-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .bg-info { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .bg-primary-light { background: rgba(59,130,246,0.12); color: #3b82f6; }
    .bg-success-light { background: rgba(16,185,129,0.12); color: #10b981; }
    .bg-warning-light { background: rgba(245,158,11,0.12); color: #f59e0b; }

    .stat-info { flex: 1; }
    .stat-value { font-size: 26px; font-weight: 800; color: #1e293b; line-height: 1.2; }
    .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

    /* ========================================== */
    /* WIDGET CARDS */
    /* ========================================== */
    .widget-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
        height: 100%;
    }
    .widget-header {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .widget-title { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .widget-subtitle { font-size: 12px; color: #64748b; margin: 0; }
    .widget-body { padding: 20px; }

    /* ========================================== */
    /* TABLE */
    /* ========================================== */
    .data-table { width: 100%; margin-bottom: 0; }
    .data-table th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover { background: #f8fafc; }

    /* ========================================== */
    /* STATUS BADGES */
    /* ========================================== */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-warning { background: #fef3c7; color: #d97706; }
    .status-info { background: #dbeafe; color: #2563eb; }
    .status-primary { background: #e0e7ff; color: #4f46e5; }
    .status-success { background: #d1fae5; color: #059669; }
    .status-secondary { background: #f1f5f9; color: #64748b; }

    /* ========================================== */
    /* RANK ITEMS */
    /* ========================================== */
    .rank-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .rank-item:last-child { border-bottom: none; }
    .rank-number {
        width: 32px;
        height: 32px;
        background: #f59e0b;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }
    .rank-info { flex: 1; }
    .rank-name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .rank-sales { font-size: 11px; color: #64748b; }
    .rank-percent { font-weight: 700; color: #10b981; font-size: 14px; }

    /* ========================================== */
    /* EMPTY STATE */
    /* ========================================== */
    .empty-state {
        padding: 30px 20px;
    }
    .empty-state i {
        opacity: 0.3;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }
        .welcome-title { font-size: 20px; }
        .stat-value { font-size: 22px; }
        .stat-card { padding: 16px; }
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
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#10b981',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' FC';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#e2e8f0' },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'k';
                            }
                            return value;
                        }
                    }
                },
                x: { grid: { display: false } }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>
@endpush
@endsection