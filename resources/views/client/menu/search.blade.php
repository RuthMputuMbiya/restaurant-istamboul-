{{-- resources/views/client/menu/search.blade.php --}}
@extends('layouts.client')

@section('title', 'Résultats de recherche')

@section('client-content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-2"></i>Retour au menu
            </a>
        </div>
        <div>
            <form action="{{ route('client.menu.search') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="q" class="form-control rounded-pill" value="{{ $search }}" placeholder="Rechercher...">
                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="search-header mb-4">
        <h1 class="display-6 fw-bold text-dark">
            <i class="fas fa-search text-primary me-3"></i>Résultats pour "{{ $search }}"
        </h1>
        <p class="text-muted">{{ $plats->total() }} plat(s) trouvé(s)</p>
    </div>

    @if($plats->count() > 0)
    <div class="row g-4">
        @foreach($plats as $plat)
        <div class="col-md-6 col-lg-4">
            <div class="plat-card">
                <div class="plat-image">
                    @if($plat->image)
                        <img src="{{ Storage::url($plat->image) }}" alt="{{ $plat->nom }}">
                    @else
                        <div class="plat-placeholder">
                            <i class="fas fa-utensils fa-3x"></i>
                        </div>
                    @endif
                </div>
                <div class="plat-body">
                    <h5 class="plat-title">{{ $plat->nom }}</h5>
                    <p class="plat-description">{{ Str::limit($plat->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="plat-price">{{ number_format($plat->prix, 0, ',', ' ') }} FC</span>
                        @if($plat->est_disponible)
                            <button class="btn-add-cart btn btn-sm btn-success rounded-pill" data-id="{{ $plat->id }}">
                                <i class="fas fa-cart-plus me-1"></i> Ajouter
                            </button>
                        @else
                            <span class="badge bg-secondary">Indisponible</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $plats->links() }}
    </div>
    @else
    <div class="empty-state text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h4>Aucun résultat trouvé</h4>
        <p class="text-muted">Essayez avec d'autres mots-clés</p>
        <a href="{{ route('menu.index') }}" class="btn btn-primary rounded-pill">Voir tout le menu</a>
    </div>
    @endif
</div>

@push('styles')
<style>
    .plat-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        height: 100%;
    }
    .plat-card:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .plat-image {
        height: 180px;
        position: relative;
        overflow: hidden;
    }
    .plat-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .plat-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }
    .plat-body { padding: 15px; }
    .plat-title { font-weight: 700; margin-bottom: 8px; }
    .plat-description { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    .plat-price {
        font-size: 16px;
        font-weight: 800;
        color: #27ae60;
    }
    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 60px;
    }
</style>
@endpush

@push('scripts')
<script>
    $('.btn-add-cart').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: '{{ route("client.commande.ajouter-panier") }}',
            method: 'POST',
            data: {
                menu_id: id,
                quantite: 1,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    $('#cartCount').text(response.count);
                    alert('Plat ajouté au panier');
                }
            }
        });
    });
</script>
@endpush
@endsection