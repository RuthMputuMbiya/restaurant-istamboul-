{{-- resources/views/admin/roles/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Créer un rôle')
@section('page-title', 'Créer un rôle')
@section('page-subtitle', 'Ajoutez un nouveau rôle au système')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-plus-circle text-success me-3"></i>Nouveau rôle
                    </h1>
                    <p class="text-muted">Ajoutez un nouveau rôle au système</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-success text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Informations du rôle</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom du rôle</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tag text-primary"></i>
                                </span>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror border-start-0" 
                                       id="nom" name="nom" value="{{ old('nom') }}" 
                                       placeholder="Ex: Superviseur, Assistant, Livreur..." required>
                            </div>
                            <small class="text-muted">Le slug (identifiant unique) sera généré automatiquement</small>
                            @error('nom')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Décrivez ce rôle... Ex: Ce rôle permet de gérer les commandes">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info rounded-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Information:</strong> Les permissions seront gérées ultérieurement.
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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

@push('styles')
<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #27ae60 0%, #1e7e34 100%);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .form-control:focus {
        border-color: #27ae60;
        box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.25);
    }
</style>
@endpush
@endsection