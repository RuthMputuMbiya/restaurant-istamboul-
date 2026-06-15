@extends('layouts.serveur')

@section('title', 'Gestion des tables')

@section('serveur-content')
<div class="tables-page">
    <div class="container-fluid px-4 py-4">

        <!-- Header -->
        <div class="page-header mb-4">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-chair"></i>
                </div>
                <div>
                    <h1 class="page-title">Gestion des tables</h1>
                    <p class="page-subtitle">Visualisez et gérez l'état de toutes les tables</p>
                </div>
            </div>
            <button class="btn-refresh" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i> Actualiser
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['libres'] ?? 0 }}</span>
                    <span class="stat-label">Tables libres</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['occupees'] ?? 0 }}</span>
                    <span class="stat-label">Tables occupées</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['reservees'] ?? 0 }}</span>
                    <span class="stat-label">Tables réservées</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
                    <span class="stat-label">Total tables</span>
                </div>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="tables-grid">
            @forelse($tables as $table)
            <div class="table-card {{ $table->statut }}">
                <div class="table-number">{{ $table->numero }}</div>
                <div class="table-capacity">
                    <i class="fas fa-users"></i> {{ $table->capacite }} places
                </div>
                <div class="table-status">
                    @if($table->statut == 'libre')
                        <span><i class="fas fa-check-circle"></i> Libre</span>
                    @elseif($table->statut == 'occupee')
                        <span><i class="fas fa-circle"></i> Occupée</span>
                    @else
                        <span><i class="fas fa-clock"></i> Réservée</span>
                    @endif
                </div>
                @if($table->statut == 'libre')
                <a href="/serveur/commandes/create?table_id={{ $table->id }}" class="btn-order">
                    <i class="fas fa-plus"></i> Commander
                </a>
                @endif
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-chair fa-4x"></i>
                <h3>Aucune table configurée</h3>
                <p>Veuillez contacter l'administrateur</p>
            </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    .tables-page {
        background: linear-gradient(135deg, #f5f7fb 0%, #f0f2f6 100%);
        min-height: 100vh;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        padding: 20px 25px;
        border-radius: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .header-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(255,107,107,0.3);
    }
    .header-icon i { font-size: 1.6rem; color: white; }
    .page-title { font-size: 1.6rem; font-weight: 800; margin: 0; color: #1a1a2e; }
    .page-subtitle { font-size: 0.8rem; color: #64748b; margin-top: 5px; }
    .btn-refresh {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #eef2f6;
        border: none;
        border-radius: 40px;
        color: #64748b;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-refresh:hover {
        background: #ff9f43;
        color: white;
        transform: translateY(-2px);
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-icon i { font-size: 1.5rem; color: white; }
    .stat-icon.green { background: linear-gradient(135deg, #27ae60, #1e7e34); }
    .stat-icon.red { background: linear-gradient(135deg, #e74c3c, #c0392b); }
    .stat-icon.orange { background: linear-gradient(135deg, #f39c12, #e67e22); }
    .stat-icon.blue { background: linear-gradient(135deg, #3498db, #2980b9); }
    .stat-value { font-size: 1.8rem; font-weight: 800; display: block; color: #1a1a2e; }
    .stat-label { font-size: 0.7rem; color: #64748b; }
    .tables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
    }
    .table-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    .table-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .table-card.libre { background: #e8f8f5; border-color: #27ae60; }
    .table-card.occupee { background: #fdedec; border-color: #e74c3c; }
    .table-card.reservee { background: #fff3cd; border-color: #f39c12; }
    .table-number { font-size: 28px; font-weight: 800; margin-bottom: 8px; }
    .table-card.libre .table-number { color: #27ae60; }
    .table-card.occupee .table-number { color: #e74c3c; }
    .table-card.reservee .table-number { color: #f39c12; }
    .table-capacity { font-size: 12px; color: #64748b; margin: 8px 0; }
    .btn-order {
        display: inline-block;
        margin-top: 12px;
        padding: 8px 16px;
        background: #27ae60;
        color: white;
        border-radius: 30px;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-order:hover { background: #219a52; transform: scale(1.02); }
    .empty-state { text-align: center; padding: 60px; background: white; border-radius: 20px; }
    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; text-align: center; }
        .header-left { flex-direction: column; }
    }
</style>
@endsection