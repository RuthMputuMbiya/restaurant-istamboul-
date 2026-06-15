{{-- resources/views/admin/commandes/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des commandes')
@section('page-title', 'Commandes')
@section('page-subtitle', 'Gérez toutes les commandes du restaurant')

@section('content')
<div class="container-fluid px-4">

    <!-- Filtres -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <select id="statutFilter" class="form-select rounded-pill">
                        <option value="all">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="validee">Validée</option>
                        <option value="en_preparation">En préparation</option>
                        <option value="pret">Prêt</option>
                        <option value="servi">Servi</option>
                        <option value="paye">Payé</option>
                        <option value="annulee">Annulé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" id="dateFilter" class="form-control rounded-pill" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchFilter" class="form-control rounded-pill" placeholder="🔍 N° commande ou client...">
                </div>
                <div class="col-md-3">
                    <button id="resetFilters" class="btn btn-outline-secondary rounded-pill w-100">
                        <i class="fas fa-undo-alt me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-white rounded-top-4 py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Liste des commandes</h5>
                <span class="badge bg-secondary rounded-pill">{{ $commandes->total() }} commandes</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="commandesTable">
                    <thead class="table-light">
                        <tr>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Table</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandes as $commande)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#{{ $commande->id }}</span>
                                <br>
                                <small class="text-muted">{{ $commande->numero_commande ?? 'N/A' }}</small>
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
                                <div class="btn-group">
                                    <a href="{{ route('admin.commandes.show', $commande) }}" class="btn-action" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                             </span></span></span></span></span></span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Aucune commande trouvée</p>
                             </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $commandes->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
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
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #6c757d;
        transition: all 0.2s;
    }
    .btn-action:hover { background: #0d6efd; color: white; }
</style>
@endpush

@push('scripts')
<script>
    function filterTable() {
        let statut = $('#statutFilter').val();
        let date = $('#dateFilter').val();
        let search = $('#searchFilter').val().toLowerCase();

        $('#commandesTable tbody tr').each(function() {
            let show = true;
            let rowStatut = $(this).find('td:eq(4)').text().trim().toLowerCase().replace(/\s+/g, '_');
            let rowDate = $(this).find('td:eq(5)').text().split(' ')[0].split('/').reverse().join('-');
            let rowText = $(this).text().toLowerCase();

            if(statut !== 'all' && !rowStatut.includes(statut)) show = false;
            if(date && rowDate !== date) show = false;
            if(search && !rowText.includes(search)) show = false;
            
            $(this).toggle(show);
        });
    }

    $('#statutFilter, #dateFilter, #searchFilter').on('change keyup', filterTable);
    $('#resetFilters').click(function() {
        $('#statutFilter').val('all');
        $('#dateFilter').val('{{ date("Y-m-d") }}');
        $('#searchFilter').val('');
        filterTable();
    });
</script>
@endpush
@endsection