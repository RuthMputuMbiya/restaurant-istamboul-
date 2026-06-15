@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div>
                    <h1 class="display-5 fw-bold">Détails de l'utilisateur</h1>
                    <p class="text-muted">Informations complètes sur {{ $user->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profil -->
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-avatar">
                        <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?background='.str_replace('#', '', $user->role_color ?? '2c3e50').'&color=fff&size=120&name='.urlencode($user->name) }}" alt="{{ $user->name }}">
                    </div>
                    <h3 class="mt-3 mb-1">{{ $user->name }}</h3>
                    <span class="role-badge" style="background: {{ $user->role_color ?? '#6c757d' }}20; color: {{ $user->role_color ?? '#6c757d' }}">
                        <i class="fas {{ $user->role_icon }}"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    <div class="mt-3">
                        <span class="status-badge status-{{ $user->status ?? 'active' }}">
                            {{ ucfirst($user->status ?? 'Actif') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Informations de contact</h5>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <small>Email</small>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        @if($user->phone)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <small>Téléphone</small>
                                <p>{{ $user->phone }}</p>
                            </div>
                        </div>
                        @endif
                        @if($user->address)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <small>Adresse</small>
                                <p>{{ $user->address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->orders_count ?? 0 }}</div>
                            <div class="stat-label">Commandes</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($user->total_spent ?? 0, 0, ',', ' ') }} CFA</div>
                            <div class="stat-label">Dépensé</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $user->created_at->format('d/m/Y') }}</div>
                            <div class="stat-label">Membre depuis</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activités et commandes -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders">
                                Commandes
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#activities">
                                Activités récentes
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes">
                                Notes
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Commandes -->
                        <div class="tab-pane fade show active" id="orders">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#Commande</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->orders ?? [] as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($order->total, 0, ',', ' ') }} CFA</td>
                                            <td>
                                                <span class="status-badge status-{{ $order->status }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewOrder({{ $order->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                                <p>Aucune commande</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Activités -->
                        <div class="tab-pane fade" id="activities">
                            <div class="activities-timeline">
                                @forelse($user->activities ?? [] as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="fas {{ $activity->icon }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p>{{ $activity->description }}</p>
                                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                    <p>Aucune activité récente</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="tab-pane fade" id="notes">
                            <div class="notes-section">
                                @if($user->notes)
                                <div class="note-item">
                                    <p>{{ $user->notes }}</p>
                                    <small class="text-muted">Dernière modification: {{ $user->updated_at->diffForHumans() }}</small>
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="fas fa-sticky-note fa-2x text-muted mb-2"></i>
                                    <p>Aucune note</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--primary);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.info-item i {
    font-size: 1.2rem;
    color: var(--primary);
    margin-top: 3px;
}

.info-item small {
    display: block;
    color: var(--gray-600);
    font-size: 0.7rem;
    margin-bottom: 2px;
}

.info-item p {
    margin: 0;
    font-size: 0.9rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    text-align: center;
}

.stat-item {
    padding: 10px;
    background: var(--gray-100);
    border-radius: 10px;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--gray-600);
}

.timeline-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--gray-200);
}

.timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

.timeline-content {
    flex: 1;
}

.timeline-content p {
    margin: 0 0 5px 0;
}

.note-item {
    padding: 15px;
    background: var(--gray-100);
    border-radius: 10px;
    border-left: 3px solid var(--primary);
}

.nav-tabs .nav-link {
    color: var(--gray-600);
    border: none;
    padding: 10px 20px;
}

.nav-tabs .nav-link.active {
    color: var(--primary);
    border-bottom: 2px solid var(--primary);
    background: transparent;
}
</style>

@push('scripts')
<script>
function viewOrder(orderId) {
    window.location.href = `/commandes/${orderId}`;
}
</script>
@endpush
@endsection