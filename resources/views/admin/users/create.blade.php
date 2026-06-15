@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div>
                    <h1 class="display-5 fw-bold">Créer un utilisateur</h1>
                    <p class="text-muted">Ajoutez un nouvel utilisateur à la plateforme</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom complet *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mot de passe *</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Confirmer le mot de passe *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Rôle *</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="gerant" {{ old('role') == 'gerant' ? 'selected' : '' }}>Gérant</option>
                                    <option value="serveur" {{ old('role') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                                    <option value="cuisiniere" {{ old('role') == 'cuisiniere' ? 'selected' : '' }}>Cuisinier</option>
                                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Banni</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes supplémentaires</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <p>Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.</p>
                    </div>
                    
                    <div class="info-box mt-3">
                        <i class="fas fa-shield-alt"></i>
                        <p>Le mot de passe doit contenir au moins 8 caractères.</p>
                    </div>
                    
                    <div class="info-box mt-3">
                        <i class="fas fa-envelope"></i>
                        <p>Un email de bienvenue sera envoyé à l'utilisateur après création.</p>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Permissions par rôle</h5>
                </div>
                <div class="card-body">
                    <div class="role-permission">
                        <strong>Administrateur:</strong>
                        <small>Accès total à toutes les fonctionnalités</small>
                    </div>
                    <div class="role-permission mt-2">
                        <strong>Gérant:</strong>
                        <small>Gestion des produits, commandes et statistiques</small>
                    </div>
                    <div class="role-permission mt-2">
                        <strong>Serveur:</strong>
                        <small>Gestion des tables et commandes</small>
                    </div>
                    <div class="role-permission mt-2">
                        <strong>Cuisinier:</strong>
                        <small>Gestion des commandes en cuisine</small>
                    </div>
                    <div class="role-permission mt-2">
                        <strong>Client:</strong>
                        <small>Passer des commandes et voir son historique</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.form-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
}

.info-box {
    display: flex;
    gap: 12px;
    padding: 12px;
    background: var(--gray-100);
    border-radius: 10px;
    font-size: 0.85rem;
}

.info-box i {
    font-size: 1.2rem;
    color: var(--primary);
    margin-top: 2px;
}

.info-box p {
    margin: 0;
    flex: 1;
}

.role-permission {
    padding: 10px;
    background: var(--gray-100);
    border-radius: 8px;
}

.role-permission strong {
    display: block;
    margin-bottom: 5px;
    color: var(--primary);
}

.role-permission small {
    color: var(--gray-600);
}
</style>
@endsection