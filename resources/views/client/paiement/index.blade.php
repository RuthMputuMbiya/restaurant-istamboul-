@extends('layouts.client')

@section('title', 'Paiement des commandes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">
            <i class="fas fa-credit-card me-2 text-primary"></i>
            Paiement des commandes
        </h1>
        <a href="{{ route('client.paiement.historique') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-history me-2"></i>Historique
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($commandes->count() > 0)
        <div class="row g-4">
            @foreach($commandes as $commande)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white rounded-top-4 py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                Commande #{{ $commande->id }}
                            </h5>
                            <span class="badge bg-warning rounded-pill px-3 py-2">
                                <i class="fas fa-clock me-1"></i> En attente
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">Table</small>
                                <p class="fw-bold mb-0">Table {{ $commande->table->numero ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Date</small>
                                <p class="fw-bold mb-0">{{ $commande->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="border rounded-3 p-3 mb-3">
                            <small class="text-muted">Produits commandés</small>
                            @foreach($commande->ligneCommandes as $ligne)
                            <div class="d-flex justify-content-between mt-2">
                                <span>{{ $ligne->quantite }}x {{ $ligne->menu->nom }}</span>
                                <span class="fw-bold">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
                            </div>
                            @endforeach
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <strong>Total à payer</strong>
                                <strong class="text-success fs-5">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</strong>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <a href="{{ route('form_payement', ['idcommande' => $commande->id]) }}" class="btn btn-primary rounded-pill py-2" style="background: linear-gradient(135deg, #f59e0b, #d97706); border: none;">
                                <i class="fas fa-credit-card me-2"></i>
                                Payer maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-credit-card fa-4x text-muted mb-3" style="opacity: 0.5;"></i>
                <h4 class="text-muted">Aucune commande à payer</h4>
                <p class="text-muted">Vous n'avez aucune commande en attente de paiement.</p>
                <a href="{{ route('client.menu') }}" class="btn btn-primary rounded-pill mt-3">
                    <i class="fas fa-utensils me-2"></i>Commander maintenant
                </a>
            </div>
        </div>
    @endif
</div>
@endsection