{{-- resources/views/admin/commandes/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Commande #' . $commande->id)
@section('page-title', 'Détails de la commande')
@section('page-subtitle', 'Commande #' . $commande->id)

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row g-4">
        <!-- Informations commande -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">N° Commande</span>
                        <span class="info-value">{{ $commande->numero_commande ?? '#' . $commande->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date</span>
                        <span class="info-value">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Client</span>
                        <span class="info-value">{{ $commande->client->name ?? 'Anonyme' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $commande->client->telephone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Table</span>
                        <span class="info-value">{{ $commande->table->numero ?? 'Emporter' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Serveur</span>
                        <span class="info-value">{{ $commande->serveur->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut</span>
                        <span class="info-value">
                            @php
                                $statusClass = match($commande->statut) {
                                    'en_attente' => 'warning',
                                    'validee' => 'info',
                                    'en_preparation' => 'primary',
                                    'pret' => 'success',
                                    'paye' => 'success',
                                    'annulee' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="status-badge status-{{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des plats -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Plats commandés</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Plat</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Total</th>
                                    <th>Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->ligneCommandes as $ligne)
                                <tr>
                                    <td><strong>{{ $ligne->menu->nom }}</strong></span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ $ligne->quantite }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ number_format($ligne->sous_total, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>
                                        @if($ligne->instructions)
                                            <small class="text-muted"><i class="fas fa-info-circle"></i> {{ $ligne->instructions }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td colspan="2" class="fw-bold text-success fs-5">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($commande->notes)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-warning text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes spéciales</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $commande->notes }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Paiement -->
    @if($commande->paiement)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-info text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informations paiement</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-label">Montant payé</div>
                            <div class="info-value">{{ number_format($commande->paiement->montant, 0, ',', ' ') }} FC</div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Mode de paiement</div>
                            <div class="info-value">
                                @if($commande->paiement->mode_paiement == 'especes')
                                    Espèces
                                @elseif($commande->paiement->mode_paiement == 'airtel_money')
                                    Airtel Money
                                @elseif($commande->paiement->mode_paiement == 'orange_money')
                                    Orange Money
                                @else
                                    Carte bancaire
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Date paiement</div>
                            <div class="info-value">{{ $commande->paiement->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

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
    .status-badge {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    .status-warning { background: #fff3cd; color: #856404; }
    .status-info { background: #cce5ff; color: #004085; }
    .status-primary { background: #cce5ff; color: #004085; }
    .status-success { background: #d4edda; color: #155724; }
    .status-danger { background: #f8d7da; color: #721c24; }
</style>
@endpush
@endsection