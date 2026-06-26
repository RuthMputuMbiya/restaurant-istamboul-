@extends('layouts.serveur')

@section('title', 'Gestion des paiements')
@section('page-title', 'Paiements')
@section('page-subtitle', 'Encaissement des commandes')

@section('serveur-content')
<div class="container-fluid px-4 py-4">

   
    <!-- Paiements en ligne en attente -->
    @if(isset($paiementsEnAttente) && $paiementsEnAttente->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="fas fa-clock me-2"></i>Paiements en ligne en attente
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Téléphone</th>
                                    <th>Date</th>
                                    <th class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paiementsEnAttente as $paiement)
                                <td>
                                    <td class="ps-4 fw-bold">#{{ $paiement->commande_id }}</span>
                                    <td>{{ $paiement->commande->client->name ?? 'N/A' }}</span>
                                    <td class="fw-bold" style="color: #059669;">{{ number_format($paiement->montant, 0, ',', ' ') }} FC</span>
                                    <td>
                                        @if($paiement->mode_paiement == 'airtel_money')
                                            <span class="badge" style="background: #fef3c7; color: #d97706;"><i class="fas fa-phone-alt me-1"></i>Airtel Money</span>
                                        @elseif($paiement->mode_paiement == 'orange_money')
                                            <span class="badge" style="background: #fef3c7; color: #d97706;"><i class="fas fa-phone-alt me-1"></i>Orange Money</span>
                                        @else
                                            <span class="badge" style="background: #dbeafe; color: #1d4ed8;"><i class="fas fa-globe me-1"></i>Shwary</span>
                                        @endif
                                    </span>
                                    <td>
                                        @if($paiement->numero_telephone)
                                            <span class="fw-bold">+243 {{ $paiement->numero_telephone }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </span>
                                    <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
                                    <td class="pe-4">
                                        <form action="{{ route('serveur.paiement.confirmer', $paiement) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm" style="background: #059669; color: white; border-radius: 30px; padding: 5px 15px;">
                                                <i class="fas fa-check me-1"></i>Confirmer
                                            </button>
                                        </form>
                                    </span>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Commandes à encaisser sur place (Mobile Money uniquement) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-cash-register me-2"></i>Commandes à encaisser sur place
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Table</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th class="pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandesNonPayees ?? [] as $commande)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $commande->id }}</span>
                                    <td>Table {{ $commande->table->numero ?? 'N/A' }}</span>
                                    <td>{{ $commande->client->name ?? 'Sur place' }}</span>
                                    <td class="fw-bold" style="color: #059669;">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span>
                                    <td><span class="badge" style="background: #fef3c7; color: #d97706;">{{ ucfirst($commande->statut) }}</span></span>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                                    <td class="pe-4">
                                        <a href="{{ route('serveur.paiement.show', $commande) }}" class="btn btn-sm" style="background: #3b82f6; color: white; border-radius: 30px; padding: 5px 15px;">
                                            <i class="fas fa-credit-card me-1"></i>Encaisser
                                        </a>
                                    </span>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-check-circle fa-3x text-muted mb-3 d-block" style="color: #10b981;"></i>
                                        <p class="text-muted mb-0">Aucune commande à encaisser</p>
                                    </span>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers paiements -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="fas fa-history me-2"></i>Derniers paiements
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Commande</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Téléphone</th>
                                    <th>Référence</th>
                                    <th>Date</th>
                                    <th class="pe-4">Reçu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiementsRecents ?? [] as $paiement)
                                <tr>
                                    <td class="ps-4 fw-bold">#{{ $paiement->commande_id }}</span>
                                    <td>{{ $paiement->commande->client->name ?? 'N/A' }}</span>
                                    <td class="fw-bold" style="color: #059669;">{{ number_format($paiement->montant, 0, ',', ' ') }} FC</span>
                                    <td>
                                        @if($paiement->mode_paiement == 'airtel_money')
                                            <span class="badge" style="background: #fef3c7; color: #d97706;">Airtel Money</span>
                                        @elseif($paiement->mode_paiement == 'orange_money')
                                            <span class="badge" style="background: #fef3c7; color: #d97706;">Orange Money</span>
                                        @else
                                            <span class="badge" style="background: #dbeafe; color: #1d4ed8;">Shwary</span>
                                        @endif
                                    </span>
                                    <td>
                                        @if($paiement->numero_telephone)
                                            <span class="fw-bold text-primary">+243 {{ $paiement->numero_telephone }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </span>
                                    <td>{{ $paiement->reference ?? '-' }}</span>
                                    <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</span>
                                    <td class="pe-4">
                                        <a href="{{ route('serveur.paiement.recu', $paiement->commande_id) }}" class="btn btn-sm" style="background: #6c757d; color: white; border-radius: 30px; padding: 5px 12px;">
                                            <i class="fas fa-print me-1"></i>
                                        </a>
                                    </span>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">Aucun paiement enregistré</p>
                                    </span>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let lastPaymentCount = {{ $paiementsEnAttente->count() ?? 0 }};
    
    setInterval(function() {
        fetch('/serveur/paiement/check-new')
            .then(response => response.json())
            .then(data => {
                if(data.new_payments > lastPaymentCount) {
                    showToastNotification('Nouveau paiement reçu !', 'success');
                    setTimeout(() => location.reload(), 2000);
                    lastPaymentCount = data.new_payments;
                }
            })
            .catch(() => {});
    }, 10000);
    
    function showToastNotification(message, type) {
        const toast = document.createElement('div');
        toast.className = 'notification-toast';
        toast.innerHTML = `<i class="fas fa-credit-card me-2"></i>${message}`;
        toast.style.cssText = 'position:fixed;bottom:30px;right:30px;background:#10b981;color:white;padding:12px 20px;border-radius:10px;z-index:9999;animation:slideIn 0.3s ease;box-shadow:0 5px 15px rgba(0,0,0,0.2);';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }
</script>
@endpush

@push('styles')
<style>
    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s;
    }
    .stats-card:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    
    .stats-number { font-size: 28px; font-weight: 800; margin: 5px 0 0; }
    .stats-label { font-size: 11px; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .table td { vertical-align: middle; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
@endpush
@endsection