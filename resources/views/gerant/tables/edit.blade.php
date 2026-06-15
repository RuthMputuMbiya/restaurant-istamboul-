{{-- resources/views/gerant/tables/edit.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Modifier la table')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('gerant.tables.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-edit text-warning me-3"></i>Modifier la table
                    </h1>
                    <p class="text-muted">Modifiez les informations de la table {{ $table->numero }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-chair me-2"></i>Table {{ $table->numero }}</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('gerant.tables.update', $table) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="numero" class="form-label fw-bold">Numéro de table</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-hashtag text-warning"></i>
                                </span>
                                <input type="text" class="form-control @error('numero') is-invalid @enderror border-start-0" 
                                       id="numero" name="numero" value="{{ old('numero', $table->numero) }}" required>
                            </div>
                            @error('numero')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="capacite" class="form-label fw-bold">Capacité</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-users text-warning"></i>
                                </span>
                                <input type="number" class="form-control @error('capacite') is-invalid @enderror border-start-0" 
                                       id="capacite" name="capacite" value="{{ old('capacite', $table->capacite) }}" min="1" max="20" required>
                            </div>
                            @error('capacite')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="zone" class="form-label fw-bold">Zone</label>
                            <select class="form-select @error('zone') is-invalid @enderror" id="zone" name="zone" required>
                                <option value="interieur" {{ old('zone', $table->zone) == 'interieur' ? 'selected' : '' }}>🏠 Intérieur</option>
                                <option value="terrasse" {{ old('zone', $table->zone) == 'terrasse' ? 'selected' : '' }}>🌞 Terrasse</option>
                                <option value="salon" {{ old('zone', $table->zone) == 'salon' ? 'selected' : '' }}>✨ Salon privé</option>
                            </select>
                            @error('zone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('gerant.tables.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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