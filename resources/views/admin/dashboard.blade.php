{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Aperçu général de votre restaurant')

@section('content')
<div class="admin-dashboard">

    <!-- ========== STATS CARDS ========== -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Utilisateurs</div>
                    <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> +12%
                    </div>
                </div>
                <div class="stat-bg">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-green">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Commandes aujourd'hui</div>
                    <div class="stat-value">{{ $commandesJour ?? 0 }}</div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> +8%
                    </div>
                </div>
                <div class="stat-bg">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Revenus du mois</div>
                    <div class="stat-value">{{ number_format($revenusMois ?? 0, 0, ',', ' ') }} FC</div>
                    <div class="stat-trend up">
                        <i class="fas fa-arrow-up"></i> +15%
                    </div>
                </div>
                <div class="stat-bg">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Note moyenne</div>
                    <div class="stat-value">{{ $noteMoyenne ?? 4.8 }}</div>
                    <div class="stat-trend up">
                        <i class="fas fa-star"></i> Excellent
                    </div>
                </div>
                <div class="stat-bg">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== CHARTS SECTION ========== -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <div>
                        <h5 class="chart-title">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Évolution des commandes
                        </h5>
                        <p class="chart-subtitle">Statistiques des 7 derniers jours</p>
                    </div>
                    <div>
                        <select class="period-select" id="chartPeriod">
                            <option value="7" selected>7 jours</option>
                            <option value="30">30 jours</option>
                            <option value="90">90 jours</option>
                        </select>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="commandesChart" height="320"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="fas fa-chart-pie text-success me-2"></i>
                        Rôles utilisateurs
                    </h5>
                    <p class="chart-subtitle">Distribution des utilisateurs</p>
                </div>
                <div class="chart-body text-center">
                    <canvas id="rolesChart" height="240"></canvas>
                    <div class="legend mt-4">
                        @php
                            $roleColors = ['admin' => '#e74c3c', 'gerant' => '#f39c12', 'serveur' => '#3498db', 'cuisinier' => '#2ecc71', 'client' => '#9b59b6'];
                            $roleNames = ['admin' => 'Admin', 'gerant' => 'Gérant', 'serveur' => 'Serveur', 'cuisinier' => 'Cuisinier', 'client' => 'Client'];
                        @endphp
                        @foreach($rolesDistribution ?? [] as $role)
                        <div class="legend-item">
                            <span class="legend-dot" style="background: {{ $roleColors[$role->slug] ?? '#95a5a6' }}"></span>
                            <span>{{ $roleNames[$role->slug] ?? ucfirst($role->slug) }}</span>
                            <span class="legend-value">{{ $role->count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== DERNIÈRES COMMANDES ========== -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="data-card">
                <div class="data-header">
                    <div>
                        <h5 class="data-title">
                            <i class="fas fa-clock text-warning me-2"></i>
                            Dernières commandes
                        </h5>
                        <p class="data-subtitle">Les 5 dernières commandes passées</p>
                    </div>
                    <a href="{{ route('admin.commandes.index') }}" class="btn-outline-custom">
                        <i class="fas fa-eye me-1"></i> Voir toutes
                    </a>
                </div>
                <div class="data-body p-0">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>N° Commande</th>
                                    <th>Client</th>
                                    <th>Table</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dernieresCommandes ?? [] as $commande)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $commande->id }}</span>
                                        <br>
                                        <small class="text-muted">{{ $commande->numero_commande ?? '' }}</small>
                                    </td>
                                    <td>
                                        {{ $commande->client->name ?? 'Anonyme' }}
                                        <br>
                                        <small class="text-muted">{{ $commande->client->telephone ?? '' }}</small>
                                    </td>
                                    <td>
                                        @if($commande->table)
                                            Table {{ $commande->table->numero }}
                                        @else
                                            <span class="text-muted">Emporter</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @php
                                            $statusClass = match($commande->statut) {
                                                'en_attente' => 'warning',
                                                'validee' => 'info',
                                                'en_preparation' => 'primary',
                                                'pret' => 'success',
                                                'servi' => 'success',
                                                'paye' => 'success',
                                                'annulee' => 'danger',
                                                default => 'secondary'
                                            };
                                            $statusText = match($commande->statut) {
                                                'en_attente' => 'En attente',
                                                'validee' => 'Validée',
                                                'en_preparation' => 'En préparation',
                                                'pret' => 'Prêt',
                                                'servi' => 'Servi',
                                                'paye' => 'Payé',
                                                'annulee' => 'Annulé',
                                                default => ucfirst($commande->statut ?? 'Inconnu')
                                            };
                                        @endphp
                                        <span class="status-badge status-{{ $statusClass }}">{{ $statusText }}</span>
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        <a href="{{ route('admin.commandes.show', $commande) }}" class="action-btn" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
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

    <!-- ========== DERNIERS UTILISATEURS ========== -->
    <div class="row g-4">
        <div class="col-12">
            <div class="data-card">
                <div class="data-header">
                    <div>
                        <h5 class="data-title">
                            <i class="fas fa-user-plus text-info me-2"></i>
                            Derniers utilisateurs inscrits
                        </h5>
                        <p class="data-subtitle">Les 5 derniers comptes créés</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn-outline-custom">
                        <i class="fas fa-eye me-1"></i> Voir tous
                    </a>
                </div>
                <div class="data-body p-0">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers ?? [] as $user)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar" style="background: linear-gradient(135deg, {{ $roleColors[$user->role->slug ?? 'client'] ?? '#2c3e50' }} 0%, #1a252f 100%);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</span></td>
                                    <td>
                                        @php
                                            $badgeMap = ['admin' => 'badge-danger', 'gerant' => 'badge-warning', 'serveur' => 'badge-info', 'cuisinier' => 'badge-success', 'client' => 'badge-secondary'];
                                        @endphp
                                        <span class="role-badge {{ $badgeMap[$user->role->slug ?? 'client'] }}">
                                            {{ $roleNames[$user->role->slug ?? 'client'] ?? 'Client' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="action-btn">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                        <p class="text-muted">Aucun utilisateur récent</p>
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

</div>

@push('styles')
<style>
    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 22px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }
    .stat-icon i { font-size: 28px; color: white; }
    .stat-blue .stat-icon { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); }
    .stat-green .stat-icon { background: linear-gradient(135deg, #27ae60 0%, #1e7e34 100%); }
    .stat-orange .stat-icon { background: linear-gradient(135deg, #f39c12 0%, #d68910 100%); }
    .stat-purple .stat-icon { background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); }
    .stat-info { flex: 1; position: relative; z-index: 2; }
    .stat-label { font-size: 12px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-value { font-size: 28px; font-weight: 800; margin: 5px 0; color: #1a1a2e; }
    .stat-trend { font-size: 12px; display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; }
    .stat-trend.up { background: #e8f8f5; color: #27ae60; }
    .stat-bg { position: absolute; right: -15px; bottom: -15px; font-size: 80px; opacity: 0.05; z-index: 1; }

    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
    }
    .chart-header { padding: 20px 24px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .chart-title { font-size: 16px; font-weight: 700; margin: 0; color: #1a1a2e; }
    .chart-subtitle { font-size: 12px; color: #6c757d; margin: 5px 0 0 0; }
    .period-select { background: #f8f9fa; border: none; border-radius: 40px; padding: 6px 15px; font-size: 13px; }
    .chart-body { padding: 20px; }

    /* Data Cards */
    .data-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .data-header { padding: 20px 24px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .data-title { font-size: 16px; font-weight: 700; margin: 0; color: #1a1a2e; }
    .data-subtitle { font-size: 12px; color: #6c757d; margin: 5px 0 0 0; }
    .btn-outline-custom { background: #f8f9fa; padding: 6px 16px; border-radius: 40px; color: #3498db; text-decoration: none; font-size: 12px; font-weight: 500; transition: all 0.2s; }
    .btn-outline-custom:hover { background: #3498db; color: white; }

    /* Custom Table */
    .custom-table { width: 100%; margin-bottom: 0; }
    .custom-table thead th { background: #f8f9fa; padding: 14px 20px; font-size: 12px; font-weight: 600; color: #6c757d; border-bottom: 1px solid #e9ecef; }
    .custom-table tbody td { padding: 14px 20px; vertical-align: middle; border-bottom: 1px solid #e9ecef; }
    .custom-table tbody tr:hover { background: #f8f9fa; }

    .user-cell { display: flex; align-items: center; gap: 12px; }
    .user-avatar { width: 38px; height: 38px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; }

    .role-badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .badge-danger { background: #e74c3c20; color: #e74c3c; }
    .badge-warning { background: #f39c1220; color: #f39c12; }
    .badge-info { background: #3498db20; color: #3498db; }
    .badge-success { background: #27ae6020; color: #27ae60; }
    .badge-secondary { background: #6c757d20; color: #6c757d; }

    .action-btn { width: 32px; height: 32px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: #f8f9fa; color: #6c757d; transition: all 0.2s; }
    .action-btn:hover { background: #3498db; color: white; }

    .status-badge {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    .status-warning { background: #fff3cd; color: #856404; }
    .status-info { background: #cce5ff; color: #004085; }
    .status-primary { background: #cce5ff; color: #004085; }
    .status-success { background: #d4edda; color: #155724; }
    .status-danger { background: #f8d7da; color: #721c24; }
    .status-secondary { background: #e2e3e5; color: #383d41; }

    .legend { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 12px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 3px; }
    .legend-value { font-weight: 700; color: #1a1a2e; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique commandes
    const ctx = document.getElementById('commandesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($joursSemaine ?? ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']) !!},
            datasets: [{
                label: 'Commandes',
                data: {!! json_encode($commandesParJour ?? [12, 19, 15, 17, 14, 22, 25]) !!},
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.05)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3498db',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: '#e9ecef' } }, x: { grid: { display: false } } }
        }
    });

    // Graphique rôles
    const ctx2 = document.getElementById('rolesChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($rolesLabels ?? ['Admin', 'Gérant', 'Serveur', 'Cuisinier', 'Client']) !!},
            datasets: [{
                data: {!! json_encode($rolesData ?? [2, 3, 8, 5, 45]) !!},
                backgroundColor: ['#e74c3c', '#f39c12', '#3498db', '#27ae60', '#9b59b6'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, cutout: '65%' }
    });
</script>
@endpush
@endsection