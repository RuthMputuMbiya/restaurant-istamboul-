@extends('layouts.serveur')

@section('title', 'Détails commande #' . $commande->id)
@section('page-title', 'Commande #' . $commande->id)
@section('page-subtitle', 'Détails complets de la commande')

@section('serveur-content')
<div class="container-fluid px-4 py-4">
    
    <div class="row g-4">
        <!-- Colonne gauche - Détails commande -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="fas fa-receipt text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">Commande #{{ $commande->id }}</h4>
                            <p class="text-muted mb-0 small">Passée le {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <!-- Liste des plats -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th class="pe-4 text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($commande->ligneCommandes as $ligne)
                                @php $sousTotal = $ligne->quantite * $ligne->prix_unitaire; $total += $sousTotal; @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="product-icon me-3">
                                                <i class="fas fa-utensils text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $ligne->menu->nom }}</strong>
                                                @if($ligne->instructions)
                                                    <br><small class="text-muted"><i class="fas fa-info-circle me-1"></i>{{ $ligne->instructions }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </span>
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ $ligne->quantite }}</span>
                                    </span>
                                    <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
                                    <td class="pe-4 text-end fw-bold text-primary">{{ number_format($sousTotal, 0, ',', ' ') }} FC</span>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-active">
                                <tr>
                                    <td colspan="3" class="ps-4 fw-bold">Total à payer</td>
                                    <td class="pe-4 text-end fw-bold fs-5 text-success">{{ number_format($total, 0, ',', ' ') }} FC</td>
                                </table>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Informations et actions -->
        <div class="col-lg-5">
            <!-- Informations commande -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle text-info me-2"></i>Informations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-chair me-2 text-muted"></i>Table
                        </div>
                        <div class="info-value fw-bold">Table {{ $commande->table->numero ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user me-2 text-muted"></i>Client
                        </div>
                        <div class="info-value">
                            @if($commande->client)
                                {{ $commande->client->name }}
                            @else
                                <span class="text-muted">Client anonyme</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-tag me-2 text-muted"></i>Type
                        </div>
                        <div class="info-value">
                            @if($commande->type_commande == 'sur_place')
                                <span class="badge bg-primary">Sur place</span>
                            @else
                                <span class="badge bg-warning">À emporter</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-clock me-2 text-muted"></i>Statut
                        </div>
                        <div class="info-value">
                            @php
                                $statusConfig = [
                                    'en_attente' => ['class' => 'warning', 'icon' => 'fa-clock', 'text' => 'En attente'],
                                    'validee' => ['class' => 'info', 'icon' => 'fa-check-circle', 'text' => 'Validée'],
                                    'en_preparation' => ['class' => 'primary', 'icon' => 'fa-spinner fa-spin', 'text' => 'En préparation'],
                                    'pret' => ['class' => 'success', 'icon' => 'fa-check-double', 'text' => 'Prête'],
                                    'servi' => ['class' => 'secondary', 'icon' => 'fa-hand-peace', 'text' => 'Servie']
                                ];
                                $status = $statusConfig[$commande->statut] ?? ['class' => 'secondary', 'icon' => 'fa-question', 'text' => $commande->statut];
                            @endphp
                            <span class="badge bg-{{ $status['class'] }} rounded-pill px-3 py-2">
                                <i class="fas {{ $status['icon'] }} me-1"></i> {{ $status['text'] }}
                            </span>
                        </div>
                    </div>
                    @if($commande->notes)
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-pen me-2 text-muted"></i>Notes
                        </div>
                        <div class="info-value small bg-light p-2 rounded-3">
                            {{ $commande->notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-warning me-2"></i>Actions
                    </h5>
                </div>
                <div class="card-body">
                    @if($commande->statut == 'en_attente')
                    <form action="{{ route('serveur.commandes.valider', $commande->id) }}" method="POST" class="d-grid mb-2">
                        @csrf
                        <button type="submit" class="btn btn-info rounded-pill py-2">
                            <i class="fas fa-check-circle me-2"></i>Valider la commande
                        </button>
                    </form>
                    @endif

                    @if($commande->statut == 'validee')
                    <form action="{{ route('serveur.commandes.envoyer-cuisine', $commande->id) }}" method="POST" class="d-grid mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary rounded-pill py-2">
                            <i class="fas fa-utensils me-2"></i>Envoyer en cuisine
                        </button>
                    </form>
                    @endif

                    @if($commande->statut == 'pret')
                    <form action="{{ route('serveur.commandes.servir', $commande->id) }}" method="POST" class="d-grid mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success rounded-pill py-2">
                            <i class="fas fa-hand-sparkles me-2"></i>Servir la commande
                        </button>
                    </form>
                    @endif

                    @if($commande->statut == 'pret')
                    <a href="{{ route('serveur.paiement.show', $commande->id) }}" class="btn btn-warning rounded-pill w-100 py-2 mb-2">
                        <i class="fas fa-credit-card me-2"></i>Encaisser
                    </a>
                    @endif

                    <hr>
                    
                    <a href="{{ route('serveur.commandes.index') }}" class="btn btn-outline-secondary rounded-pill w-100 py-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        font-size: 0.85rem;
        color: #64748b;
    }
    .info-value {
        font-size: 0.9rem;
        font-weight: 500;
    }
    .product-icon {
        width: 35px;
        height: 35px;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush
@endsection