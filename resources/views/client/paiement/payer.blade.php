@extends('layouts.client')

@section('title', 'Paiement - Commande #'.$commande->id)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-white rounded-top-4 py-3 border-0">
                    <h4 class="mb-0 fw-bold text-center">
                        <i class="fas fa-credit-card me-2 text-primary"></i>
                        Paiement Commande #{{ $commande->id }}
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Récapitulatif -->
                    <div class="text-center mb-4">
                        <h2 class="text-success">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</h2>
                        <p class="text-muted">Montant à payer</p>
                        <div class="border-top my-3"></div>
                    </div>
                    
                    <form method="POST" action="{{ route('client.paiement.process', $commande) }}" id="paiementForm">
                        @csrf
                        
                        <!-- Sélection du mode de paiement -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-money-bill-wave me-2"></i>Mode de paiement
                            </label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="payment-option">
                                        <input type="radio" name="mode_paiement" value="airtel_money" required>
                                        <div class="payment-card">
                                            <div class="payment-icon">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Airtel_logo.svg/1200px-Airtel_logo.svg.png" alt="Airtel" style="width: 40px;">
                                            </div>
                                            <strong>Airtel Money</strong>
                                            <small>Payez avec Airtel Money</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="payment-option">
                                        <input type="radio" name="mode_paiement" value="orange_money">
                                        <div class="payment-card">
                                            <div class="payment-icon">
                                                <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/3/32/Orange_Money_logo.svg/1200px-Orange_Money_logo.svg.png" alt="Orange" style="width: 40px;">
                                            </div>
                                            <strong>Orange Money</strong>
                                            <small>Payez avec Orange Money</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="payment-option">
                                        <input type="radio" name="mode_paiement" value="especes">
                                        <div class="payment-card">
                                            <i class="fas fa-money-bill-wave fa-3x"></i>
                                            <strong>Espèces</strong>
                                            <small>Paiement à la livraison</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label class="payment-option">
                                        <input type="radio" name="mode_paiement" value="carte">
                                        <div class="payment-card">
                                            <i class="fas fa-credit-card fa-3x"></i>
                                            <strong>Carte bancaire</strong>
                                            <small>Visa, Mastercard</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('mode_paiement')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Champ numéro de téléphone (pour Mobile Money) -->
                        <div class="mb-4" id="telephoneField" style="display: none;">
                            <label class="form-label fw-bold">
                                <i class="fas fa-phone me-2"></i>Numéro de téléphone Mobile Money
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">+243</span>
                                <input type="tel" name="numero_telephone" id="numero_telephone" class="form-control form-control-lg" placeholder="812345678" maxlength="9">
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Entrez le numéro associé à votre compte {{ $mode ?? 'Mobile Money' }}
                            </small>
                            <div id="telephoneError" class="text-danger small mt-1"></div>
                        </div>
                        
                        <!-- Récapitulatif -->
                        <div class="alert alert-info rounded-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>En cliquant sur "Payer", vous autorisez le débit de {{ number_format($commande->montant_total, 0, ',', ' ') }} FC sur votre compte Mobile Money.</small>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success rounded-pill py-3 btn-payer" id="btnPayer">
                                <i class="fas fa-check-circle me-2"></i>Confirmer le paiement
                            </button>
                            <a href="{{ route('client.paiement.index') }}" class="btn btn-outline-secondary rounded-pill py-2">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const telephoneField = document.getElementById('telephoneField');
    const telephoneInput = document.getElementById('numero_telephone');
    const radioButtons = document.querySelectorAll('input[name="mode_paiement"]');
    const btnPayer = document.getElementById('btnPayer');
    const telephoneError = document.getElementById('telephoneError');
    
    // Afficher/cacher le champ téléphone selon le mode de paiement
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if(this.value === 'airtel_money' || this.value === 'orange_money') {
                telephoneField.style.display = 'block';
                telephoneInput.setAttribute('required', 'required');
            } else {
                telephoneField.style.display = 'none';
                telephoneInput.removeAttribute('required');
                telephoneError.textContent = '';
            }
        });
    });
    
    // Validation avant soumission
    document.getElementById('paiementForm').addEventListener('submit', function(e) {
        const selectedMode = document.querySelector('input[name="mode_paiement"]:checked');
        
        if (!selectedMode) {
            e.preventDefault();
            alert('Veuillez sélectionner un mode de paiement');
            return false;
        }
        
        if ((selectedMode.value === 'airtel_money' || selectedMode.value === 'orange_money')) {
            const telephone = telephoneInput.value.trim();
            if (!telephone) {
                e.preventDefault();
                telephoneError.textContent = 'Le numéro de téléphone est requis';
                telephoneInput.focus();
                return false;
            }
            if (!/^[0-9]{9}$/.test(telephone)) {
                e.preventDefault();
                telephoneError.textContent = 'Le numéro doit contenir 9 chiffres (ex: 812345678)';
                telephoneInput.focus();
                return false;
            }
            telephoneError.textContent = '';
        }
        
        // Désactiver le bouton pour éviter double soumission
        btnPayer.disabled = true;
        btnPayer.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Traitement en cours...';
    });
</script>
@endpush

@push('styles')
<style>
    .payment-option {
        cursor: pointer;
        width: 100%;
        display: block;
    }
    .payment-option input {
        display: none;
    }
    .payment-card {
        border: 2px solid #e9ecef;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s;
    }
    .payment-option input:checked + .payment-card {
        border-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        transform: translateY(-3px);
    }
    .payment-card i, .payment-icon {
        font-size: 32px;
        display: block;
        margin-bottom: 10px;
        color: #f59e0b;
    }
    .payment-card strong {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .payment-card small {
        font-size: 11px;
        color: #6c757d;
    }
    .btn-payer {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        font-size: 16px;
        font-weight: 600;
    }
    .btn-payer:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16,185,129,0.3);
    }
    .btn-payer:disabled {
        opacity: 0.7;
        transform: none;
    }
</style>
@endpush
@endsection