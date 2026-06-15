@extends('layouts.serveur')

@section('title', 'Paiement - Commande #' . $commande->id)

@section('serveur-content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('serveur.paiement.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
        <div>
            <h1 class="display-6 fw-bold text-dark">
                <i class="fas fa-credit-card text-success me-3"></i>Paiement
            </h1>
            <p class="text-muted">Commande #{{ $commande->id }} - Table {{ $commande->table->numero ?? 'Emporter' }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Récapitulatif de la commande -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-receipt me-2"></i>Récapitulatif de la commande
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="invoice-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Désignation</th>
                                    <th class="text-center">Qté</th>
                                    <th class="text-end">Prix unit.</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->ligneCommandes as $ligne)
                                <tr>
                                    <td class="ps-4">
                                        <strong>{{ $ligne->menu->nom }}</strong>
                                        @if($ligne->instructions)
                                            <br><small class="text-muted"><i class="fas fa-info-circle"></i> {{ $ligne->instructions }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $ligne->quantite }}</td>
                                    <td class="text-end">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</td>
                                    <td class="text-end pe-4">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FC</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr class="bg-light">
                                    <td colspan="3" class="text-end fw-bold ps-4">SOUS-TOTAL</td>
                                    <td class="text-end pe-4">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="3" class="text-end fw-bold ps-4">SERVICE (10%)</td>
                                    <td class="text-end pe-4">{{ number_format($commande->montant_total * 0.1, 0, ',', ' ') }} FC</td>
                                </tr>
                                <tr class="bg-success bg-opacity-10">
                                    <td colspan="3" class="text-end fw-bold fs-5 ps-4">TOTAL À PAYER</td>
                                    <td class="text-end pe-4 fw-bold fs-5 text-success">{{ number_format($commande->montant_total * 1.1, 0, ',', ' ') }} FC</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de paiement -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fas fa-credit-card me-2"></i>Mode de paiement
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('serveur.paiement.process', $commande) }}" id="paiementForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-3">Sélectionnez le mode de paiement</label>
                            <div class="row g-3">
                                <!-- Airtel Money -->
                                <div class="col-6">
                                    <div class="payment-option" data-mode="airtel_money">
                                        <div class="payment-icon">
                                            <i class="fas fa-mobile-alt fa-3x"></i>
                                        </div>
                                        <div class="mt-2 fw-bold">Airtel Money</div>
                                        <small>Paiement mobile</small>
                                    </div>
                                </div>
                                <!-- Orange Money -->
                                <div class="col-6">
                                    <div class="payment-option" data-mode="orange_money">
                                        <div class="payment-icon">
                                            <i class="fas fa-mobile-alt fa-3x"></i>
                                        </div>
                                        <div class="mt-2 fw-bold">Orange Money</div>
                                        <small>Paiement mobile</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mode_paiement" id="modePaiement" required>
                        </div>

                        <!-- Champ pour Mobile Money -->
                        <div id="mobileMoneyFields" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold">
                                <i class="fas fa-phone me-2 text-primary"></i>Numéro de téléphone Mobile Money
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">+243</span>
                                <input type="tel" name="numero_telephone" class="form-control border-start-0" placeholder="812 345 678" maxlength="9">
                            </div>
                            <small class="text-muted mt-1 d-block">
                                <i class="fas fa-info-circle me-1"></i>Entrez le numéro Airtel Money ou Orange Money du client (ex: 812345678)
                            </small>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Notes
                            </label>
                            <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="Informations complémentaires..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 mt-2">
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
    .payment-option {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 20px 15px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .payment-option:hover {
        border-color: #10b981;
        background: #f0fdf4;
        transform: translateY(-3px);
    }
    .payment-option.selected {
        border-color: #10b981;
        background: #f0fdf4;
        box-shadow: 0 5px 15px rgba(16,185,129,0.15);
    }
    .payment-option .payment-icon i {
        font-size: 32px;
        color: #6c757d;
    }
    .payment-option.selected .payment-icon i {
        color: #10b981;
    }
    .invoice-table {
        width: 100%;
        margin-bottom: 0;
    }
    .invoice-table th, .invoice-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    .invoice-table th {
        background: #f8f9fa;
        font-weight: 600;
        font-size: 12px;
        color: #64748b;
    }
    .invoice-table tfoot td {
        border-bottom: none;
        padding: 10px 8px;
    }
    .form-control:focus, .input-group-text:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 0.2rem rgba(16,185,129,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Sélection des options de paiement
        $('.payment-option').click(function() {
            $('.payment-option').removeClass('selected');
            $(this).addClass('selected');
            
            let mode = $(this).data('mode');
            $('#modePaiement').val(mode);
            
            // Afficher le champ téléphone pour les deux modes
            $('#mobileMoneyFields').show();
        });
        
        // Sélectionner Airtel Money par défaut
        $('.payment-option[data-mode="airtel_money"]').addClass('selected');
        $('#modePaiement').val('airtel_money');
        $('#mobileMoneyFields').show();
    });
</script>
@endpush
@endsection