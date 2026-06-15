@extends('layouts.serveur')

@section('title', 'Commandes')

@section('serveur-content')
<div class="commandes-page">
    <div class="container-fluid px-4 py-4">

        <!-- Header -->
        <div class="page-header mb-4">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h1 class="page-title">Commandes</h1>
                    <p class="page-subtitle">Gérez toutes les commandes des clients</p>
                </div>
            </div>
            <a href="/serveur/commandes/create" class="btn-new">
                <i class="fas fa-plus-circle"></i> Nouvelle commande
            </a>
        </div>

        <!-- Stats -->
        <div class="stats-mini-grid mb-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon warning"><i class="fas fa-clock"></i></div>
                <div><span class="stat-mini-value">{{ $commandes->where('statut', 'en_attente')->count() }}</span><span class="stat-mini-label">En attente</span></div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-icon info"><i class="fas fa-cooking"></i></div>
                <div><span class="stat-mini-value">{{ $commandes->where('statut', 'en_preparation')->count() }}</span><span class="stat-mini-label">En préparation</span></div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-icon success"><i class="fas fa-check-circle"></i></div>
                <div><span class="stat-mini-value">{{ $commandes->where('statut', 'pret')->count() }}</span><span class="stat-mini-label">Prêts</span></div>
            </div>
            <div class="stat-mini-card">
                <div class="stat-mini-icon total"><i class="fas fa-chart-line"></i></div>
                <div><span class="stat-mini-value">{{ $commandes->total() }}</span><span class="stat-mini-label">Total</span></div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-bar mb-4">
            <div class="filter-group">
                <button class="filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> Toutes</button>
                <button class="filter-btn" data-filter="en_attente"><i class="fas fa-clock"></i> En attente</button>
                <button class="filter-btn" data-filter="en_preparation"><i class="fas fa-cooking"></i> En préparation</button>
                <button class="filter-btn" data-filter="pret"><i class="fas fa-check-circle"></i> Prêts</button>
            </div>
            <div class="search-box"><i class="fas fa-search"></i><input type="text" id="searchCommande" placeholder="Rechercher..."></div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table class="commandes-table">
                <thead><tr><th>#</th><th>Table</th><th>Client</th><th>Total</th><th>Date</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($commandes as $commande)
                    <tr data-status="{{ $commande->statut }}">
                        <td class="commande-id">#{{ $commande->id }}</td>
                        <td><span class="table-badge"><i class="fas fa-chair"></i> Table {{ $commande->table->numero ?? 'N/A' }}</span></td>
                        <td><div class="client-info"><div class="client-avatar">{{ substr($commande->client->name ?? 'C', 0, 1) }}</div><span>{{ $commande->client->name ?? 'Client' }}</span></div></td>
                        <td class="commande-total">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</td>
                        <td><div class="date-info"><span class="date-day">{{ $commande->created_at->format('d/m') }}</span><span class="date-time">{{ $commande->created_at->format('H:i') }}</span></div></td>
                        <td>@if($commande->statut == 'en_attente')<span class="status-badge warning"><i class="fas fa-clock"></i> En attente</span>@elseif($commande->statut == 'en_preparation')<span class="status-badge info"><i class="fas fa-cooking"></i> En préparation</span>@elseif($commande->statut == 'pret')<span class="status-badge success"><i class="fas fa-check-circle"></i> Prêt</span>@else<span class="status-badge secondary">{{ $commande->statut }}</span>@endif</td>
                        <td><div class="action-buttons"><a href="/serveur/commandes/{{ $commande->id }}" class="action-btn view"><i class="fas fa-eye"></i></a></div></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="empty-state"><i class="fas fa-inbox fa-4x"></i><h3>Aucune commande</h3><p>Commencez par créer une nouvelle commande</p><a href="/serveur/commandes/create" class="btn-empty">Nouvelle commande</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper mt-4">{{ $commandes->links() }}</div>

    </div>
</div>

<style>
    .commandes-page { background: linear-gradient(135deg, #f5f7fb 0%, #f0f2f6 100%); min-height: 100vh; }
    .page-header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px 25px; border-radius: 24px; }
    .header-left { display: flex; align-items: center; gap: 18px; }
    .header-icon { width: 55px; height: 55px; background: linear-gradient(135deg, #ff9f43, #ff6b6b); border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(255,107,107,0.3); }
    .header-icon i { font-size: 1.6rem; color: white; }
    .page-title { font-size: 1.6rem; font-weight: 800; margin: 0; }
    .btn-new { display: flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, #ff9f43, #ff6b6b); color: white; border-radius: 50px; text-decoration: none; font-weight: 600; }
    .stats-mini-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .stat-mini-card { background: white; border-radius: 20px; padding: 15px 20px; display: flex; align-items: center; gap: 15px; }
    .stat-mini-icon { width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; }
    .stat-mini-icon.warning { background: #fff3e0; color: #ff9f43; }
    .stat-mini-icon.info { background: #e3f2fd; color: #2196f3; }
    .stat-mini-icon.success { background: #e8f5e9; color: #4caf50; }
    .stat-mini-icon.total { background: #e8eaf6; color: #5e35b1; }
    .stat-mini-icon i { font-size: 1.2rem; }
    .stat-mini-value { font-size: 1.3rem; font-weight: 800; display: block; }
    .stat-mini-label { font-size: 0.7rem; color: #64748b; }
    .filters-bar { display: flex; justify-content: space-between; align-items: center; background: white; padding: 12px 20px; border-radius: 60px; }
    .filter-group { display: flex; gap: 8px; }
    .filter-btn { padding: 8px 18px; background: transparent; border: 1px solid #e9ecef; border-radius: 40px; cursor: pointer; }
    .filter-btn.active { background: linear-gradient(135deg, #ff9f43, #ff6b6b); color: white; border-color: transparent; }
    .search-box { display: flex; align-items: center; gap: 8px; background: #f8f9fa; padding: 8px 16px; border-radius: 40px; }
    .search-box input { border: none; background: none; outline: none; }
    .table-wrapper { background: white; border-radius: 24px; overflow: hidden; }
    .commandes-table { width: 100%; border-collapse: collapse; }
    .commandes-table th { padding: 15px 20px; background: #f8fafc; font-size: 0.8rem; color: #64748b; }
    .commandes-table td { padding: 15px 20px; border-bottom: 1px solid #eef2f6; }
    .commande-id { font-weight: 700; color: #ff9f43; }
    .table-badge { display: inline-flex; align-items: center; gap: 6px; background: #eef2f6; padding: 5px 12px; border-radius: 30px; font-size: 0.8rem; }
    .client-info { display: flex; align-items: center; gap: 10px; }
    .client-avatar { width: 32px; height: 32px; background: linear-gradient(135deg, #ff9f43, #ff6b6b); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; }
    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 600; }
    .status-badge.warning { background: #fff3e0; color: #ff9f43; }
    .status-badge.info { background: #e3f2fd; color: #2196f3; }
    .status-badge.success { background: #e8f5e9; color: #4caf50; }
    .action-btn { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; background: #eef2f6; color: #64748b; }
    .action-btn.view:hover { background: #ff9f43; color: white; }
    .empty-state { text-align: center; padding: 60px; }
    .pagination-wrapper { display: flex; justify-content: center; }
    @media (max-width: 992px) { .stats-mini-grid { grid-template-columns: repeat(2, 1fr); } .filters-bar { flex-direction: column; border-radius: 20px; } }
</style>

<script>
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.commandes-table tbody tr').forEach(row => {
                if(filter === 'all' || row.dataset.status === filter) row.style.display = '';
                else row.style.display = 'none';
            });
        });
    });
    document.getElementById('searchCommande')?.addEventListener('keyup', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.commandes-table tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
        });
    });
</script>
@endsection