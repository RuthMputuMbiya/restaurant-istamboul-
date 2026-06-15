@extends('layouts.client')

@section('title', $menu->nom)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.menu') }}">Menu</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $menu->categorie->nom ?? '' }}</a></li>
            <li class="breadcrumb-item active">{{ $menu->nom }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <div class="plat-detail-img">
                @if($menu->image)
                <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->nom }}" class="img-fluid rounded-4">
                @else
                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-utensils fa-5x text-muted"></i>
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="plat-detail-info">
                <span class="badge bg-primary mb-3">{{ $menu->categorie->nom ?? 'Plat' }}</span>
                <h1 class="display-6 fw-bold">{{ $menu->nom }}</h1>
                <p class="text-muted mt-3">{{ $menu->description }}</p>
                <div class="my-4">
                    <div class="d-flex align-items-center gap-3">
                        <span class="h2 text-primary fw-bold">{{ number_format($menu->prix, 0, ',', ' ') }} FC</span>
                        @if($menu->temps_preparation)
                        <span class="text-muted">
                            <i class="fas fa-clock me-1"></i> Préparation: {{ $menu->temps_preparation }} min
                        </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="quantity-selector">
                        <input type="number" id="quantite" class="form-control form-control-lg" value="1" min="1" style="width: 80px;">
                    </div>
                    <button class="btn btn-primary btn-lg rounded-pill px-5" onclick="ajouterAuPanier({{ $menu->id }}, document.getElementById('quantite').value)">
                        <i class="fas fa-cart-plus me-2"></i>Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($similaires->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Plats similaires</h3>
        <div class="row">
            @foreach($similaires as $similaire)
            <div class="col-md-3 mb-4">
                <div class="plat-card">
                    <div class="plat-img">
                        @if($similaire->image)
                        <img src="{{ Storage::url($similaire->image) }}" alt="{{ $similaire->nom }}">
                        @else
                        <div class="bg-light h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-utensils fa-2x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="plat-body">
                        <h6 class="plat-title">{{ $similaire->nom }}</h6>
                        <div class="plat-price">{{ number_format($similaire->prix, 0, ',', ' ') }} FC</div>
                        <button class="btn-add-cart-sm mt-2 w-100" onclick="ajouterAuPanier({{ $similaire->id }}, 1)">
                            <i class="fas fa-cart-plus me-2"></i>Ajouter
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .plat-detail-img img {
        width: 100%;
        height: auto;
        border-radius: 20px;
    }
    .plat-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s;
        height: 100%;
    }
    .plat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .plat-img {
        height: 150px;
        overflow: hidden;
    }
    .plat-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .plat-body {
        padding: 1rem;
    }
    .plat-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .plat-price {
        font-weight: 700;
        color: #ff9f43;
        margin-bottom: 0.5rem;
    }
    .btn-add-cart-sm {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        border: none;
        padding: 8px;
        border-radius: 30px;
        transition: all 0.3s;
    }
    .btn-add-cart-sm:hover {
        transform: scale(1.02);
        cursor: pointer;
    }
</style>
@endpush
@endsection