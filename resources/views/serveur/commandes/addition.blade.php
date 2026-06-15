{{-- resources/views/serveur/commandes/addition.blade.php --}}
@extends('layouts.serveur')

@section('title', 'Paiement - Commande #' . $commande->id)

@section('serveur-content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('serveur.commandes.show', $commande) }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
        <div>
            <h1 class="display-6 fw-bold text-dark">
                <i class="fas fa-credit-card text-success me-3"></i>Paiement
            </h1>
            <p class="text-muted">Commande #{{ $commande->id }} - Table {{ $commande->table->numero }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Récapitulatif -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <h5 class="mb-0"><i class="fas fa-receipt text-primary me-2"></i>Récapitulatif</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Plat</th>
                                    <th>Qté</th>
                                    <th>Prix</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->ligneCommandes as $ligne)
                                <tr>
                                    <td>{{ $ligne->menu->nom }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ $ligne->quantite }}</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td>{{ number_format($ligne->sous_total, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL</span></span></span></span></span></span></span></span></span></span></span></span>
                                    <td class="fw-bold text-success fs-4">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span></span></span></span></span></span></span></span></span></span></span></span>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de paiement -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Mode de paiement</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('serveur.paiement.process', $commande) }}" id="paiementForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Sélectionnez le mode de paiement</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="payment-option" data-mode="especes">
                                        <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                                        <div class="mt-2">Espèces</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="payment-option" data-mode="airtel_money">
                                        <i class="fas fa-mobile-alt fa-3x text-danger"></i>
                                        <div class="mt-2">Airtel Money</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="payment-option" data-mode="orange_money">
                                        <i class="fas fa-mobile-alt fa-3x text-orange"></i>
                                        <div class="mt-2">Orange Money</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="payment-option" data-mode="carte">
                                        <i class="fas fa-credit-card fa-3x text-primary"></i>
                                        <div class="mt-2">Carte bancaire</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mode_paiement" id="modePaiement" required>
                        </div>

                        <div id="mobileMoneyFields" style="display: none;" class="mb-4">
                            <label class="form-label fw-bold">Numéro de téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">+243</span>
                                <input type="tel" name="numero_mobile" class="form-control rounded-end" placeholder="812345678">
                            </div>
                            <small class="text-muted">Entrez le numéro du client</small>
                        </div>

                        <div id="especesFields" style="display: none;" class="mb-4">
                            <label class="form-label fw-bold">Montant reçu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">FC</span>
                                <input type="number" name="montant_recu" class="form-control" step="100" placeholder="Montant donné par le client">
                            </div>
                            <div id="monnaieInfo" class="mt-2 small text-muted"></div>
                        </div>

                        <div id="carteFields" style="display: none;" class="mb-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Paiement par carte bancaire - Terminal de paiement disponible
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 mt-3">
                            <i class="fas fa-check-circle me-2"></i>Valider le paiement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #27ae60 0%, #1e7e34 100%);
    }
    .payment-option {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .payment-option:hover { border-color: #27ae60; background: #e8f8f5; }
    .payment-option.selected { border-color: #27ae60; background: #e8f8f5; }
    .text-orange { color: #f39c12; }
</style>
@endpush

@push('scripts')
<script>
    $('.payment-option').click(function() {
        $('.payment-option').removeClass('selected');
        $(this).addClass('selected');
        
        let mode = $(this).data('mode');
        $('#modePaiement').val(mode);
        
        $('#mobileMoneyFields, #especesFields, #carteFields').hide();
        
        if(mode === 'airtel_money' || mode === 'orange_money') {
            $('#mobileMoneyFields').show();
        } else if(mode === 'especes') {
            $('#especesFields').show();
        } else if(mode === 'carte') {
            $('#carteFields').show();
        }
    });
    
    $('input[name="montant_recu"]').on('input', function() {
        let montantRecu = parseFloat($(this).val()) || 0;
        let total = {{ $commande->montant_total }};
        let monnaie = montantRecu - total;
        
        if(monnaie >= 0) {
            $('#monnaieInfo').html(`<span class="text-success">Monnaie à rendre: ${monnaie.toLocaleString()} FC</span>`);
        } else {
            $('#monnaieInfo').html(`<span class="text-danger">Montant insuffisant: Manque ${Math.abs(monnaie).toLocaleString()} FC</span>`);
        }
    });
</script>
@endpush
@endsection