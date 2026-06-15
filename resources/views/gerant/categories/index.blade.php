{{-- resources/views/gerant/categories/index.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Gestion des catégories')
@section('page-title', 'Gestion des catégories')
@section('page-subtitle', 'Organisez votre menu par catégories')

@section('gerant-content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-tags text-primary me-3"></i>Catégories
                    </h1>
                    <p class="text-muted">Gérez les catégories de votre menu</p>
                </div>
                <a href="{{ route('gerant.categories.create') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Nouvelle catégorie
                </a>
            </div>
        </div>
    </div>

    <!-- Grille des catégories -->
    <div class="row g-4">
        @forelse($categories as $categorie)
        <div class="col-md-6 col-lg-4">
            <div class="category-card">
                <div class="category-card-header">
                    <div class="category-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('gerant.categories.edit', $categorie) }}">
                                    <i class="fas fa-edit text-warning me-2"></i>Modifier
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('gerant.categories.destroy', $categorie) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash me-2"></i>Supprimer
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="category-card-body">
                    <h4 class="category-name">{{ $categorie->nom }}</h4>
                    <p class="category-description">{{ $categorie->description ?? 'Aucune description' }}</p>
                    <div class="category-stats">
                        <span class="badge bg-primary">
                            <i class="fas fa-utensils me-1"></i>{{ $categorie->menus_count ?? 0 }} plats
                        </span>
                        <span class="badge bg-secondary">
                            <i class="fas fa-sort-numeric-down me-1"></i>Ordre: {{ $categorie->ordre ?? 0 }}
                        </span>
                    </div>
                </div>
                <div class="category-card-footer">
                    <a href="{{ route('gerant.menu.index', ['categorie' => $categorie->id]) }}" class="btn btn-outline-primary w-100 rounded-pill">
                        <i class="fas fa-eye me-2"></i>Voir les plats
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                <h4>Aucune catégorie</h4>
                <p class="text-muted">Commencez par créer votre première catégorie</p>
                <a href="{{ route('gerant.categories.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus-circle me-2"></i>Créer une catégorie
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .category-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .category-card-header {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .category-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .category-icon i {
        font-size: 24px;
        color: white;
    }
    .category-card-body {
        padding: 20px;
        flex: 1;
    }
    .category-name {
        font-weight: 800;
        margin-bottom: 10px;
        color: #1e293b;
    }
    .category-description {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 16px;
        line-height: 1.5;
    }
    .category-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .category-card-footer {
        padding: 0 20px 20px 20px;
    }
    .empty-state {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
</style>
@endpush
@endsection