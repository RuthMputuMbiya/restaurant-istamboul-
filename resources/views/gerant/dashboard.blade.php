@extends('layouts.gerant')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Aperçu général de votre restaurant')

@section('gerant-content')
<div class="container-fluid px-0">

    <!-- ========================================== -->
    <!-- EN-TÊTE AVEC STATS RAPIDES -->
    <!-- ========================================== -->
    <div class="dashboard-header mb-4">
        <div class="header-left">
            <h2 class="header-title">👋 Bonjour, {{ Auth::user()->name ?? 'Gérant' }} !</h2>
            <p class="header-subtitle">Voici un aperçu de l'activité de votre restaurant</p>
        </div>
        <div class="header-right">
            <div class="header-date">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ now()->translatedFormat('l d F Y') }}
            </div>
            <div class="header-badge">
                <span class="badge-dot"></span>
                En ligne
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4 CARTES PRINCIPALES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-gradient-1">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3 class="stat-card-value">{{ number_format($chiffreAffaires ?? 0, 0, ',', ' ') }}</h3>
                        <p class="stat-card-label">Chiffre d'affaires total</p>
                        <div class="stat-card-sub">
                            <span class="text-light opacity-75 small">{{ $caJour ?? 0 }} FC aujourd'hui</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-gradient-2">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3 class="stat-card-value">{{ $commandesAujourdhui ?? 0 }}</h3>
                        <p class="stat-card-label">Commandes aujourd'hui</p>
                        <div class="stat-card-sub">
                            <span class="text-light opacity-75 small">{{ $totalCommandes ?? 0 }} au total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-gradient-3">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3 class="stat-card-value">{{ $reservationsJour ?? 0 }}</h3>
                        <p class="stat-card-label">Réservations du jour</p>
                        <div class="stat-card-sub">
                            <span class="text-light opacity-75 small">{{ $reservationsTotal ?? 0 }} au total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-gradient-4">
                <div class="stat-card-body">
                    <div class="stat-card-icon">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="stat-card-info">
                        <h3 class="stat-card-value">{{ $tauxOccupation ?? 0 }}%</h3>
                        <p class="stat-card-label">Tables occupées</p>
                        <div class="stat-card-sub">
                            <span class="text-light opacity-75 small">{{ $tablesOccupees ?? 0 }}/{{ $totalTables ?? 0 }} tables</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- STATUTS DES COMMANDES -->
    <!-- ========================================== -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="status-strip">
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-warning"></span>
                    <span class="status-strip-label">En attente</span>
                    <span class="status-strip-value">{{ $statsCommandes['en_attente'] ?? 0 }}</span>
                </div>
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-primary"></span>
                    <span class="status-strip-label">Validées</span>
                    <span class="status-strip-value">{{ $statsCommandes['validee'] ?? 0 }}</span>
                </div>
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-info"></span>
                    <span class="status-strip-label">En préparation</span>
                    <span class="status-strip-value">{{ $statsCommandes['en_preparation'] ?? 0 }}</span>
                </div>
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-success"></span>
                    <span class="status-strip-label">Prêtes</span>
                    <span class="status-strip-value">{{ $statsCommandes['pret'] ?? 0 }}</span>
                </div>
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-secondary"></span>
                    <span class="status-strip-label">Servies</span>
                    <span class="status-strip-value">{{ $statsCommandes['servi'] ?? 0 }}</span>
                </div>
                <div class="status-strip-item">
                    <span class="status-strip-dot bg-success"></span>
                    <span class="status-strip-label">Payées</span>
                    <span class="status-strip-value">{{ $statsCommandes['paye'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- GRAPHIQUE + TOP PLATS -->
    <!-- ========================================== -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="widget-card">
                <div class="widget-header">
                    <div>
                        <h5 class="widget-title">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Évolution du chiffre d'affaires
                        </h5>
                        <p class="widget-subtitle">7 derniers jours</p>
                    </div>
                    <div class="widget-header-actions">
                        <span class="widget-total">
                            <span class="text-muted">Total : </span>
                            <strong>{{ number_format(array_sum($ventesParJour ?? [0]), 0, ',', ' ') }} FC</strong>
                        </span>
                    </div>
                </div>
                <div class="widget-body">
                    <canvas id="salesChart" height="280"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget-card">
                <div class="widget-header">
                    <div>
                        <h5 class="widget-title">
                            <i class="fas fa-trophy text-warning me-2"></i>
                            Top 5 plats
                        </h5>
                        <p class="widget-subtitle">Les plus vendus</p>
                    </div>
                </div>
                <div class="widget-body">
                    @if(isset($topPlats) && $topPlats->count() > 0)
                        @foreach($topPlats as $index => $plat)
                        <div class="rank-item">
                            <div class="rank-number rank-{{ $index + 1 }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="rank-info">
                                <div class="rank-name">{{ $plat->nom }}</div>
                                <div class="rank-sales">
                                    <i class="fas fa-shopping-bag me-1"></i>
                                    {{ $plat->total_ventes }} ventes
                                </div>
                            </div>
                            <div class="rank-percent">
                                <div class="rank-bar" style="width: {{ round(($plat->total_ventes / ($topPlats->first()->total_ventes ?? 1)) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state text-center py-4">
                            <div class="empty-state-icon">
                                <i class="fas fa-chart-simple"></i>
                            </div>
                            <p class="empty-state-text">Aucune donnée disponible</p>
                            <span class="empty-state-sub">Les ventes apparaîtront ici</span>
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
                    <div>
                        <h5 class="widget-title">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Dernières commandes
                        </h5>
                        <p class="widget-subtitle">5 dernières commandes enregistrées</p>
                    </div>
                    <!-- LIEN CORRIGE - Utilise gerant.statistiques au lieu de gerant.commandes -->
                    <a href="{{ route('gerant.statistiques') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="widget-body p-0">
                    @if(isset($dernieresCommandes) && $dernieresCommandes->count() > 0)
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Table</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dernieresCommandes as $commande)
                                    <tr>
                                        <td>
                                            <span class="commande-number">#{{ $commande->id }}</span>
                                        </td>
                                        <td>
                                            <span class="table-badge">
                                                <i class="fas fa-chair me-1"></i>
                                                Table {{ $commande->table->numero ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $commande->user->name ?? '---' }}</td>
                                        <td>
                                            <span class="montant">{{ number_format($commande->montant_total ?? 0, 0, ',', ' ') }} FC</span>
                                        </td>
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
                                        <td class="text-muted small">
                                            {{ $commande->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <div class="empty-state-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <p class="empty-state-text">Aucune commande récente</p>
                            <span class="empty-state-sub">Les commandes apparaîtront ici</span>
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
    /* HEADER MODERNE */
    /* ========================================== */
    .dashboard-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 24px;
        padding: 28px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .header-title {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    .header-subtitle {
        font-size: 14px;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }
    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2;
    }
    .header-date {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        padding: 8px 16px;
        background: rgba(255,255,255,0.08);
        border-radius: 30px;
    }
    .header-badge {
        color: #4ade80;
        font-size: 13px;
        padding: 8px 16px;
        background: rgba(74,222,128,0.12);
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #4ade80;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    /* ========================================== */
    /* STAT CARDS GRADIENT */
    /* ========================================== */
    .stat-card {
        border-radius: 20px;
        padding: 24px;
        color: #fff;
        transition: all 0.3s ease;
        height: 100%;
        min-height: 140px;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .stat-card-gradient-1 {
        background: linear-gradient(135deg, #1e3a5f 0%, #1a365d 100%);
    }
    .stat-card-gradient-2 {
        background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
    }
    .stat-card-gradient-3 {
        background: linear-gradient(135deg, #234e7c 0%, #1a365d 100%);
    }
    .stat-card-gradient-4 {
        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
    }
    .stat-card-body {
        display: flex;
        align-items: center;
        gap: 18px;
        height: 100%;
    }
    .stat-card-icon {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.12);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .stat-card-info {
        flex: 1;
    }
    .stat-card-value {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }
    .stat-card-label {
        font-size: 12px;
        opacity: 0.7;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card-sub {
        margin-top: 4px;
    }

    /* ========================================== */
    /* STATUS STRIP */
    /* ========================================== */
    .status-strip {
        background: #fff;
        border-radius: 20px;
        padding: 16px 24px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .status-strip-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        background: #f8fafc;
        border-radius: 30px;
    }
    .status-strip-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-strip-label {
        font-size: 12px;
        color: #64748b;
    }
    .status-strip-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
        min-width: 20px;
        text-align: center;
    }

    /* ========================================== */
    /* WIDGET CARDS */
    /* ========================================== */
    .widget-card {
        background: #fff;
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
    .widget-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .widget-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    .widget-body {
        padding: 20px;
    }
    .widget-total {
        font-size: 14px;
    }
    .widget-total strong {
        color: #1e293b;
    }

    /* ========================================== */
    /* TABLE */
    /* ========================================== */
    .data-table {
        width: 100%;
        margin-bottom: 0;
    }
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

    .commande-number {
        font-weight: 700;
        color: #1e293b;
    }
    .table-badge {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #475569;
    }
    .montant {
        font-weight: 600;
        color: #1e293b;
    }

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
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }
    .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); }
    .rank-3 { background: linear-gradient(135deg, #fb923c, #f97316); }
    .rank-4 { background: #cbd5e1; color: #475569; }
    .rank-5 { background: #e2e8f0; color: #64748b; }
    .rank-info { flex: 1; }
    .rank-name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .rank-sales { font-size: 11px; color: #64748b; }
    .rank-percent {
        width: 60px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .rank-bar {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    /* ========================================== */
    /* EMPTY STATE */
    /* ========================================== */
    .empty-state-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }
    .empty-state-text {
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }
    .empty-state-sub {
        font-size: 13px;
        color: #94a3b8;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        .header-title { font-size: 18px; }
        .header-right { flex-wrap: wrap; justify-content: center; }
        .stat-card-value { font-size: 22px; }
        .status-strip { padding: 12px 16px; gap: 6px; }
        .status-strip-item { padding: 4px 10px; }
        .status-strip-label { font-size: 10px; }
        .status-strip-value { font-size: 14px; }
        .widget-header { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 576px) {
        .stat-card { min-height: 110px; padding: 16px; }
        .stat-card-icon { width: 40px; height: 40px; font-size: 18px; }
        .stat-card-value { font-size: 20px; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des ventes avec dégradé
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    gradient.addColorStop(0.5, 'rgba(16, 185, 129, 0.1)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.01)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($joursSemaine ?? ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']) !!},
            datasets: [{
                label: 'Chiffre d\'affaires (FC)',
                data: {!! json_encode($ventesParJour ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                borderColor: '#10b981',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#10b981',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#e2e8f0',
                    cornerRadius: 12,
                    padding: 12,
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
                    grid: { color: 'rgba(226, 232, 240, 0.5)' },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'k';
                            }
                            return value;
                        },
                        color: '#94a3b8'
                    }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
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