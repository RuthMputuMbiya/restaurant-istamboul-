{{-- resources/views/gerant/tables/index.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Gestion des tables')
@section('page-title', 'Gestion des tables')
@section('page-subtitle', 'Configurez les tables du restaurant')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-chair text-info me-3"></i>Gestion des tables
                    </h1>
                    <p class="text-muted">Configurez les tables du restaurant</p>
                </div>
                <a href="{{ route('gerant.tables.create') }}" class="btn btn-info text-white rounded-pill px-4 py-2 shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Nouvelle table
                </a>
            </div>
        </div>
    </div>

    <!-- Plan des tables -->
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-header bg-info text-white rounded-top-4 py-3">
            <h5 class="mb-0"><i class="fas fa-map me-2"></i>Plan des tables</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 justify-content-center">
                @forelse($tables as $table)
                <div class="col-md-2 col-sm-3 col-4">
                    <div class="table-card {{ $table->statut }}">
                        <div class="table-icon">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="table-number">{{ $table->numero }}</div>
                        <div class="table-capacite">{{ $table->capacite }} places</div>
                        <div class="table-status">
                            @if($table->statut == 'libre')
                                <span class="badge bg-success">Libre</span>
                            @elseif($table->statut == 'occupee')
                                <span class="badge bg-danger">Occupée</span>
                            @else
                                <span class="badge bg-warning">Réservée</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-chair fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Aucune table enregistrée</p>
                    <a href="{{ route('gerant.tables.create') }}" class="btn btn-info btn-sm rounded-pill mt-2">
                        <i class="fas fa-plus me-1"></i>Ajouter une table
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Liste des tables -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-white rounded-top-4 py-3 border-0">
            <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Liste détaillée</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Numéro</th>
                            <th>Capacité</th>
                            <th>Zone</th>
                            <th>Statut</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tables as $table)
                        <tr>
                            <td><span class="fw-bold">{{ $table->numero }}</span></td>
                            <td><i class="fas fa-users me-1"></i> {{ $table->capacite }} personnes</span></td>
                            <td>
                                @if($table->zone == 'interieur')
                                    <span class="badge bg-primary">🏠 Intérieur</span>
                                @elseif($table->zone == 'terrasse')
                                    <span class="badge bg-success">🌞 Terrasse</span>
                                @else
                                    <span class="badge bg-secondary">✨ Salon privé</span>
                                @endif
                            </td>
                            <td>
                                @if($table->statut == 'libre')
                                    <span class="badge bg-success">Libre</span>
                                @elseif($table->statut == 'occupee')
                                    <span class="badge bg-danger">Occupée</span>
                                @else
                                    <span class="badge bg-warning">Réservée</span>
                                @endif
                            </td>
                            <td>
                                @if($table->est_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('gerant.tables.edit', $table) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- ✅ CORRECTION ICI : Utiliser route('gerant.tables.toggle') -->
                                    <form action="{{ route('tables.toggle', $table) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill" title="{{ $table->est_active ? 'Désactiver' : 'Activer' }}" onclick="return confirm('{{ $table->est_active ? 'Désactiver cette table ?' : 'Activer cette table ?' }}')">
                                            <i class="fas {{ $table->est_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            {{ $table->est_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('gerant.tables.destroy', $table) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette table ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-2 d-block"></i>
                                <p class="text-muted">Aucune table enregistrée</p>
                             </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-card {
        background: white;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid #e9ecef;
    }
    .table-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .table-card.libre { border-color: #28a745; background: #e8f8f5; }
    .table-card.occupee { border-color: #dc3545; background: #fdedec; }
    .table-card.reservee { border-color: #ffc107; background: #fff3cd; }
    .table-icon i { font-size: 24px; color: #6c757d; margin-bottom: 10px; display: block; }
    .table-number { font-size: 20px; font-weight: 800; }
    .table-capacite { font-size: 12px; color: #6c757d; margin: 5px 0; }
    .btn-group .btn {
        font-size: 11px;
        padding: 4px 10px;
    }
</style>
@endpush
@endsection