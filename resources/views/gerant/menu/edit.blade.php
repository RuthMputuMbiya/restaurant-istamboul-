{{-- resources/views/gerant/menu/edit.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Modifier le plat')

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
                        <i class="fas fa-edit text-warning me-3"></i>Modifier le plat
                    </h1>
                    <p class="text-muted">Modifiez les informations du plat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>{{ $menu->nom }}</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('gerant.menu.update', $menu) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="categorie_id" class="form-label fw-bold">Catégorie</label>
                                <select class="form-select @error('categorie_id') is-invalid @enderror" id="categorie_id" name="categorie_id" required>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}" {{ old('categorie_id', $menu->categorie_id) == $categorie->id ? 'selected' : '' }}>
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
                                       id="nom" name="nom" value="{{ old('nom', $menu->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $menu->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="prix" class="form-label fw-bold">Prix (FC)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">FC</span>
                                    <input type="number" step="100" class="form-control @error('prix') is-invalid @enderror" 
                                           id="prix" name="prix" value="{{ old('prix', $menu->prix) }}" required>
                                </div>
                                @error('prix')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="temps_preparation" class="form-label fw-bold">Temps de préparation (min)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-clock"></i></span>
                                    <input type="number" class="form-control @error('temps_preparation') is-invalid @enderror" 
                                           id="temps_preparation" name="temps_preparation" value="{{ old('temps_preparation', $menu->temps_preparation) }}" required>
                                </div>
                                @error('temps_preparation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="image" class="form-label fw-bold">Image du plat</label>
                                @if($menu->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($menu->image) }}" class="rounded" width="80" height="80" style="object-fit: cover;">
                                        <small class="text-muted d-block">Image actuelle</small>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*">
                                <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="est_disponible" name="est_disponible" value="1" {{ old('est_disponible', $menu->est_disponible) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="est_disponible">Disponible à la commande</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="est_populaire" name="est_populaire" value="1" {{ old('est_populaire', $menu->est_populaire) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="est_populaire">Marquer comme plat populaire</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('gerant.menu.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
@endsection