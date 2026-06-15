{{-- resources/views/client/menu/categorie.blade.php --}}
@extends('layouts.client')

@section('title', $categorie->nom . ' - Menu')

@section('client-content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Tout le menu
        </a>
        <div>
            <h1 class="display-6 fw-bold text-dark">
                <i class="fas fa-tag text-primary me-3"></i>{{ $categorie->nom }}
            </h1>
            <p class="text-muted">{{ $categorie->description ?? 'Découvrez nos délicieux plats' }}</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($plats as $plat)
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
                    @if($plat->est_populaire)
                        <span class="plat-badge">Populaire</span>
                    @endif
                </div>
                <div class="plat-body">
                    <h5 class="plat-title">{{ $plat->nom }}</h5>
                    <p class="plat-description">{{ Str::limit($plat->description, 80) }}</p>
                    <div class="plat-footer">
                        <span class="plat-price">{{ number_format($plat->prix, 0, ',', ' ') }} FC</span>
                        @if($plat->est_disponible)
                            <button class="btn-add-cart btn btn-sm btn-success rounded-pill" data-id="{{ $plat->id }}" data-nom="{{ $plat->nom }}" data-prix="{{ $plat->prix }}">
                                <i class="fas fa-cart-plus me-1"></i> Ajouter
                            </button>
                        @else
                            <span class="badge bg-secondary">Indisponible</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state text-center py-5">
                <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
                <h4>Aucun plat dans cette catégorie</h4>
                <p class="text-muted">Revenez bientôt pour découvrir nos nouveautés</p>
                <a href="{{ route('menu.index') }}" class="btn btn-primary rounded-pill">Voir tout le menu</a>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $plats->links() }}
    </div>
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
        height: 200px;
        position: relative;
        overflow: hidden;
    }
    .plat-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .plat-card:hover .plat-image img { transform: scale(1.05); }
    .plat-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }
    .plat-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #f39c12;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .plat-body { padding: 15px; }
    .plat-title { font-weight: 700; margin-bottom: 8px; }
    .plat-description { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    .plat-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .plat-price {
        font-size: 18px;
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
                    showToast('success', 'Plat ajouté au panier');
                }
            }
        });
    });
    
    function showToast(type, message) {
        let toast = $(`<div class="toast-custom ${type}">${message}</div>`);
        $('body').append(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>
@endpush
@endsection