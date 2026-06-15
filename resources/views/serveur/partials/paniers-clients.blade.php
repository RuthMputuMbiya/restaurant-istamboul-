@if($commandesClient->count() > 0)
    @foreach($commandesClient as $commande)
    <div class="panier-item mb-3 p-3 border rounded-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold mb-0"><i class="fas fa-user-circle text-primary me-1"></i> {{ $commande->client->name ?? 'Client' }}</h6>
                <small class="text-muted">Commande #{{ $commande->id }} - {{ $commande->created_at->diffForHumans() }}</small>
            </div>
            <span class="badge bg-warning text-dark">En attente</span>
        </div>
        <hr class="my-2">
        @foreach($commande->ligneCommandes as $ligne)
        <div class="d-flex justify-content-between mb-1">
            <span><span class="fw-bold">{{ $ligne->quantite }}x</span> {{ $ligne->menu->nom }}</span>
            <span class="text-primary fw-bold">{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
        </div>
        @endforeach
        <hr class="my-2">
        <div class="d-flex justify-content-between align-items-center">
            <strong>Total:</strong>
            <strong class="text-success fs-5">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</strong>
        </div>
        <div class="mt-3">
            <a href="/serveur/commandes/{{ $commande->id }}" class="btn btn-primary w-100 rounded-pill">
                <i class="fas fa-eye me-1"></i> Voir la commande
            </a>
        </div>
    </div>
    @endforeach
@else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-3x text-muted mb-3 d-block"></i>
        <p class="text-muted mb-0">Aucune commande client en attente</p>
    </div>
@endif