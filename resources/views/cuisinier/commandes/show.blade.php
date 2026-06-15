{{-- resources/views/cuisinier/commandes/show.blade.php --}}
@extends('layouts.cuisinier')

@section('title', 'Commande #' . $commande->id)

@section('cuisinier-content')
<div class="container-fluid px-4 py-4">

    <!-- ========================================== -->
    <!-- EN-TÊTE -->
    <!-- ========================================== -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('cuisinier.commandes') }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
        <div>
            <h1 class="display-6 fw-bold text-dark">
                <i class="fas fa-receipt text-primary me-3"></i>Commande #{{ $commande->id }}
            </h1>
            <p class="text-muted">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Détails commande -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-list-ul me-2"></i>Détails de la commande</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Plat</th>
                                    <th>Quantité</th>
                                    <th>Instructions</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->ligneCommandes as $ligne)
                                <tr>
                                    <td>
                                        <strong>{{ $ligne->menu->nom }}</strong>
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ $ligne->quantite }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @if($ligne->instructions)
                                            <span class="badge bg-info">{{ $ligne->instructions }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @if($ligne->statut == 'pret')
                                            <span class="badge bg-success">✓ Prêt</span>
                                        @elseif($ligne->statut == 'en_preparation')
                                            <span class="badge bg-info">⏳ En préparation</span>
                                        @else
                                            <span class="badge bg-warning">⏰ En attente</span>
                                        @endif
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @if($ligne->statut == 'en_attente')
                                            <form action="{{ route('cuisinier.commandes.demarrer', $commande) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill">
                                                    <i class="fas fa-play"></i> Démarrer
                                                </button>
                                            </form>
                                        @elseif($ligne->statut == 'en_preparation')
                                            <form action="{{ route('cuisinier.commandes.pret', $commande) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                                    <i class="fas fa-check"></i> Marquer prêt
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations commande -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-info text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Table</span>
                        <span class="info-value">Table {{ $commande->table->numero ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Client</span>
                        <span class="info-value">{{ $commande->client->name ?? 'Anonyme' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut commande</span>
                        <span class="info-value">
                            @if($commande->statut == 'en_preparation')
                                <span class="badge bg-info">En préparation</span>
                            @elseif($commande->statut == 'pret')
                                <span class="badge bg-success">Prête</span>
                            @else
                                <span class="badge bg-warning">En attente</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Heure commande</span>
                        <span class="info-value">{{ $commande->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Progression -->
            <div class="card border-0 shadow-lg rounded-4 mt-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Progression</h5>
                </div>
                <div class="card-body">
                    @php
                        $total = $commande->ligneCommandes->count();
                        $prets = $commande->ligneCommandes->where('statut', 'pret')->count();
                        $progress = $total > 0 ? ($prets / $total) * 100 : 0;
                    @endphp
                    <div class="text-center mb-3">
                        <div class="display-4 fw-bold text-success">{{ $prets }}/{{ $total }}</div>
                        <small class="text-muted">plats prêts</small>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="text-center mt-3">
                        <small>{{ round($progress) }}% complété</small>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($commande->notes)
            <div class="card border-0 shadow-lg rounded-4 mt-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $commande->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Action globale -->
            @if($commande->statut == 'validee')
            <div class="card border-0 shadow-lg rounded-4 mt-4">
                <div class="card-body">
                    <form action="{{ route('cuisinier.commandes.demarrer', $commande) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100 rounded-pill py-2">
                            <i class="fas fa-play me-2"></i>Démarrer toute la commande
                        </button>
                    </form>
                </div>
            </div>
            @endif

            @if($commande->statut == 'en_preparation')
            <div class="card border-0 shadow-lg rounded-4 mt-4">
                <div class="card-body">
                    <form action="{{ route('cuisinier.commandes.pret', $commande) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2" onclick="return confirm('Tous les plats sont-ils prêts ?')">
                            <i class="fas fa-check-circle me-2"></i>Marquer toute la commande comme prête
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-weight: 600; color: #6c757d; }
    .info-value { font-weight: 500; color: #1e293b; }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
</style>
@endpush
@endsection