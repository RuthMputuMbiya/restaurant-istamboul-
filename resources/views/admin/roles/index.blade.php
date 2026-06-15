{{-- resources/views/admin/roles/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des rôles')
@section('page-title', 'Gestion des rôles')
@section('page-subtitle', 'Gérez les rôles et leurs permissions')

@section('content')
<div class="roles-index">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-tags text-primary me-3"></i>Rôles
                    </h1>
                    <p class="text-muted">Gérez les rôles des utilisateurs</p>
                </div>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="fas fa-plus-circle me-2"></i>Nouveau rôle
                </a>
            </div>
        </div>
    </div>

    <!-- Liste des rôles -->
    <div class="row g-4">
        @forelse($roles ?? [] as $role)
        <div class="col-md-6 col-lg-4">
            <div class="role-card">
                <div class="role-header">
                    <div class="role-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="role-title">
                        <h5 class="mb-0">{{ $role->nom }}</h5>
                        <small class="text-muted">Slug: {{ $role->slug }}</small>
                    </div>
                    <div class="role-actions">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.roles.edit', $role) }}">
                                        <i class="fas fa-edit text-warning me-2"></i>Modifier
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Supprimer ce rôle ?')">
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
                </div>
                <div class="role-body">
                    <div class="description">
                        <i class="fas fa-align-left me-2 text-muted"></i>
                        {{ $role->description ?? 'Aucune description' }}
                    </div>
                    <div class="stats mt-3">
                        <div class="stat">
                            <i class="fas fa-users text-primary"></i>
                            <span>{{ $role->users_count ?? 0 }} utilisateurs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-tags fa-4x text-muted mb-3"></i>
                <h4>Aucun rôle</h4>
                <p class="text-muted">Commencez par créer votre premier rôle</p>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-plus-circle me-2"></i>Créer un rôle
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .role-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid;
        border-left-color: #3498db;
    }
    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .role-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    .role-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .role-icon i {
        font-size: 24px;
        color: white;
    }
    .role-title {
        flex: 1;
    }
    .role-title h5 {
        font-weight: 700;
    }
    .description {
        font-size: 13px;
        color: #6c757d;
        line-height: 1.5;
    }
    .stats {
        display: flex;
        gap: 15px;
        padding-top: 10px;
        border-top: 1px solid #e9ecef;
    }
    .stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #6c757d;
    }
    .empty-state {
        text-align: center;
        padding: 60px;
        background: white;
        border-radius: 20px;
    }
</style>
@endpush
@endsection