{{-- resources/views/gerant/menu/create.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Ajouter un plat')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('gerant.menu.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-plus-circle text-success me-3"></i>Nouveau plat
                    </h1>
                    <p class="text-muted">Ajoutez un nouveau plat au menu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Informations du plat</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('gerant.menu.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="categorie_id" class="form-label fw-bold">Catégorie</label>
                                <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="nom" class="form-label fw-bold">Nom du plat</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="prix" class="form-label fw-bold">Prix (FC) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">FC</span>
                                    <input type="number" step="100" class="form-control @error('prix') is-invalid @enderror" 
                                           id="prix" name="prix" value="{{ old('prix') }}" required>
                                </div>
                                <small class="text-muted">Prix en Francs Congolais</small>
                                @error('prix')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="prix_usd" class="form-label fw-bold">Prix (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$ USD</span>
                                    <input type="number" step="0.5" class="form-control @error('prix_usd') is-invalid @enderror" 
                                           id="prix_usd" name="prix_usd" value="{{ old('prix_usd') }}">
                                </div>
                                <small class="text-muted">Prix en Dollars américains (optionnel)</small>
                                @error('prix_usd')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="temps_preparation" class="form-label fw-bold">Temps de préparation (min)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-clock"></i></span>
                                    <input type="number" class="form-control @error('temps_preparation') is-invalid @enderror" 
                                           id="temps_preparation" name="temps_preparation" value="{{ old('temps_preparation', 15) }}" required>
                                </div>
                                @error('temps_preparation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="image" class="form-label fw-bold">Image du plat</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG (max 2MB)</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="alert alert-info rounded-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>1 USD ≈ 2280 FC</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="est_disponible" name="est_disponible" value="1" {{ old('est_disponible', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="est_disponible">Disponible à la commande</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="est_populaire" name="est_populaire" value="1" {{ old('est_populaire') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="est_populaire">Marquer comme plat populaire</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('gerant.menu.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection