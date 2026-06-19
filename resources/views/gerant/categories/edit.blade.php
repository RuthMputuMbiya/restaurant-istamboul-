@extends('layouts.gerant')

@section('title', 'Modifier la catégorie')
@section('page-title', 'Modifier la catégorie')
@section('page-subtitle', 'Modifiez les informations de la catégorie')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center flex-wrap gap-3">
                <a href="{{ route('gerant.categories.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-edit text-warning me-3"></i>Modifier la catégorie
                    </h1>
                    <p class="text-muted">Modifiez les informations de la catégorie</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-tag text-warning me-2"></i>{{ $category->nom }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('gerant.categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom de la catégorie <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tag text-primary"></i>
                                </span>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror border-start-0" 
                                       id="nom" name="nom" value="{{ old('nom', $category->nom) }}" required>
                            </div>
                            @error('nom')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ordre" class="form-label fw-bold">Ordre d'affichage</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-sort-numeric-down text-primary"></i>
                                </span>
                                <input type="number" class="form-control @error('ordre') is-invalid @enderror border-start-0" 
                                       id="ordre" name="ordre" value="{{ old('ordre', $category->ordre) }}" min="0">
                            </div>
                            <small class="text-muted">Les catégories avec un ordre plus petit apparaissent en premier</small>
                            @error('ordre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('gerant.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-warning rounded-pill px-4">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .card-header {
        border-bottom: 1px solid #e2e8f0;
    }
</style>
@endpush
@endsection