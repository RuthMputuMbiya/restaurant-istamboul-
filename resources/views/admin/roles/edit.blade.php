{{-- resources/views/admin/roles/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Modifier le rôle')
@section('page-title', 'Modifier le rôle')
@section('page-subtitle', 'Modifiez les informations du rôle')

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
                        <i class="fas fa-edit text-warning me-3"></i>Modifier le rôle
                    </h1>
                    <p class="text-muted">Modifiez les informations du rôle "{{ $role->nom }}"</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-warning text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Informations du rôle</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nom" class="form-label fw-bold">Nom du rôle</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tag text-primary"></i>
                                </span>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror border-start-0" 
                                       id="nom" name="nom" value="{{ old('nom', $role->nom) }}" required>
                            </div>
                            <small class="text-muted">Ex: Administrateur, Gérant, Serveur...</small>
                            @error('nom')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Décrivez ce rôle...">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info rounded-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Information:</strong> Le slug "{{ $role->slug }}" sera automatiquement mis à jour.
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }
    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>
@endpush
@endsection