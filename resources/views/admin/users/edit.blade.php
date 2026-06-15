@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div>
                    <h1 class="display-5 fw-bold">Modifier l'utilisateur</h1>
                    <p class="text-muted">Modifiez les informations de {{ $user->name }}</p>
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
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom complet *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                <small class="text-muted">Laissez vide pour conserver le mot de passe actuel</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Rôle *</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="gerant" {{ old('role', $user->role) == 'gerant' ? 'selected' : '' }}>Gérant</option>
                                    <option value="serveur" {{ old('role', $user->role) == 'serveur' ? 'selected' : '' }}>Serveur</option>
                                    <option value="cuisiniere" {{ old('role', $user->role) == 'cuisiniere' ? 'selected' : '' }}>Cuisinier</option>
                                    <option value="client" {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>Client</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Banni</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            @if($user->avatar)
                                <div class="mt-2">
                                    <img src="{{ $user->avatar }}" alt="Avatar" width="50" class="rounded-circle">
                                    <small class="text-muted">Avatar actuel</small>
                                </div>
                            @endif
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $user->notes) }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations système</h5>
                </div>
                <div class="card-body">
                    <div class="system-info">
                        <div class="info-row">
                            <span>ID Utilisateur:</span>
                            <strong>#{{ $user->id }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Date d'inscription:</span>
                            <strong>{{ $user->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Dernière modification:</span>
                            <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Nombre de commandes:</span>
                            <strong>{{ $user->orders_count ?? 0 }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-danger w-100 mb-2" onclick="deleteUser({{ $user->id }})">
                        <i class="fas fa-trash"></i> Supprimer l'utilisateur
                    </button>
                    <button class="btn btn-info w-100" onclick="resetPassword({{ $user->id }})">
                        <i class="fas fa-key"></i> Réinitialiser le mot de passe
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.system-info {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid var(--gray-200);
}

.info-row span {
    color: var(--gray-600);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}
</style>

@push('scripts')
<script>
function deleteUser(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  window.location.href = '{{ route("admin.users.index") }}';
              } else {
                  alert('Erreur lors de la suppression');
              }
          });
    }
}

function resetPassword(id) {
    if(confirm('Envoyer un email de réinitialisation du mot de passe ?')) {
        fetch(`/admin/users/${id}/reset-password`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  alert('Email de réinitialisation envoyé !');
              } else {
                  alert('Erreur lors de l\'envoi');
              }
          });
    }
}
</script>
@endpush
@endsection