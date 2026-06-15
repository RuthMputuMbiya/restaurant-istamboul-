{{-- resources/views/gerant/statistiques/index.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques')
@section('page-subtitle', 'Analysez les performances de votre restaurant')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-chart-bar text-primary me-3"></i>Statistiques
                    </h1>
                    <p class="text-muted">Analysez les performances de votre restaurant</p>
                </div>
                <div>
                    <form action="{{ route('gerant.statistiques.export') }}" method="GET" class="d-inline">
                        <select name="periode" class="form-select d-inline-block w-auto me-2 rounded-pill">
                            <option value="jour">Aujourd'hui</option>
                            <option value="semaine">Cette semaine</option>
                            <option value="mois" selected>Ce mois</option>
                            <option value="annee">Cette année</option>
                        </select>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fas fa-download me-2"></i>Exporter PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-box stat-primary">
                <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($caMois ?? 0, 0, ',', ' ') }} FC</h3>
                    <p>Chiffre d'affaires</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box stat-success">
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-info">
                    <h3>{{ $commandesMois ?? 0 }}</h3>
                    <p>Commandes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box stat-info">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h3>{{ $reservationsMois ?? 0 }}</h3>
                    <p>Réservations</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box stat-warning">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="stat-info">
                    <h3>{{ number_format($panierMoyen ?? 0, 0, ',', ' ') }} FC</h3>
                    <p>Panier moyen</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">Évolution du chiffre d'affaires</h5>
                </div>
                <div class="widget-body">
                    <canvas id="caChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">Modes de paiement</h5>
                </div>
                <div class="widget-body text-center">
                    <canvas id="paiementChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top plats -->
    <div class="row">
        <div class="col-12">
            <div class="widget-card">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="fas fa-trophy text-warning me-2"></i>Top 5 plats les plus vendus
                    </h5>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr><th>#</th><th>Plat</th><th class="text-end">Ventes</th></tr>
                            </thead>
                            <tbody>
                                @forelse($topPlats ?? [] as $index => $plat)
                                <tr>
                                    <td><span class="rank-badge">{{ $index + 1 }}</span></td>
                                    <td>{{ $plat->nom }}</td>
                                    <td class="text-end fw-bold">{{ $plat->total_ventes }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4">Aucune donnée disponible</td></tr>
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
    .stat-box {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        height: 100%;
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
    .stat-success .stat-icon { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-info .stat-icon { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-warning .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-icon i { font-size: 24px; color: white; }
    .stat-info h3 { font-size: 22px; font-weight: 800; margin: 0; }
    .stat-info p { margin: 5px 0 0 0; color: #6c757d; font-size: 13px; }
    .widget-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
    }
    .widget-header { padding: 18px 22px; border-bottom: 1px solid #e9ecef; }
    .widget-title { font-size: 16px; font-weight: 700; margin: 0; }
    .widget-body { padding: 20px; }
    .rank-badge {
        width: 28px;
        height: 28px;
        background: #f59e0b;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('caChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($joursSemaine ?? ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim']) !!},
            datasets: [{
                label: 'CA (FC)',
                data: {!! json_encode($ventesParJour ?? [0,0,0,0,0,0,0]) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    new Chart(document.getElementById('paiementChart'), {
        type: 'doughnut',
        data: {
            labels: ['Espèces', 'Mobile Money', 'Carte'],
            datasets: [{
                data: [60, 25, 15],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6']
            }]
        }
    });
</script>
@endpush
@endsection