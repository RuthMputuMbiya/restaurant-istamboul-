@extends('layouts.client')

@section('title', 'Paiement réussi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x" style="color: #10b981;"></i>
                    </div>
                    
                    <h2 class="mb-3" style="color: #1a1a2e;">Paiement réussi !</h2>
                    <p class="text-muted mb-4">Votre commande a été payée avec succès.</p>
                    
                    <div class="rounded-3 p-3 mb-4 text-start" style="background: #f8fafc;">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Commande</small>
                                <p class="fw-bold mb-0">#{{ $commande->id }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Montant payé</small>
                                <p class="fw-bold mb-0" style="color: #10b981;">{{ number_format($paiement->montant ?? $commande->montant_total, 0, ',', ' ') }} FC</p>
                            </div>
                            <div class="col-6 mt-2">
                                <small class="text-muted">Mode de paiement</small>
                                <p class="mb-0">{{ ucfirst($paiement->mode_paiement ?? 'Shwary') }}</p>
                            </div>
                            <div class="col-6 mt-2">
                                <small class="text-muted">Référence</small>
                                <p class="mb-0">{{ $paiement->reference ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert rounded-3" style="background: #fef3c7; border: none; color: #d97706;">
                        <i class="fas fa-info-circle me-2"></i>
                        Le serveur a été notifié. Votre commande va être préparée.
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('client.commandes.index') }}" class="btn rounded-pill px-4 text-white" style="background: linear-gradient(135deg, #667eea, #764ba2); border: none;">
                            <i class="fas fa-shopping-bag me-2"></i>Voir mes commandes
                        </a>
                        <a href="{{ route('client.menu') }}" class="btn rounded-pill px-4" style="background: white; border: 1px solid #e9ecef; color: #64748b;">
                            <i class="fas fa-utensils me-2"></i>Continuer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fa-check-circle {
        animation: scaleIn 0.5s ease;
    }
    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        80% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: 1; }
    }
</style>
@endpush