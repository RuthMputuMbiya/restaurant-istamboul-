@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="users-container">
    
    <!-- En-tête -->
    <div class="page-header">
        <div class="header-title">
            <h1>Gestion des utilisateurs</h1>
            <p class="text-muted">Gérez tous les utilisateurs de votre plateforme</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn-create">
                <i class="fas fa-plus"></i> Nouvel utilisateur
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card">
        <form method="GET" action="{{ route('admin.users.index') }}" class="filters-form">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="form-control-custom" placeholder="Rechercher un utilisateur..." value="{{ request('search') }}">
            </div>
            <select name="status" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banni</option>
            </select>
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filtrer
            </button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.users.index') }}" class="btn-reset">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Commandes</th>
                        <th>Inscrit le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">
                                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?background=2563eb&color=fff&name='.urlencode($user->name) }}" alt="{{ $user->name }}">
                                </div>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-id">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                         </span>
                        <td><span class="user-email">{{ $user->email }}</span></span>
                        <td>
                            <span class="status-badge status-{{ $user->status ?? 'active' }}">
                                {{ ucfirst($user->status ?? 'Actif') }}
                            </span>
                        </span>
                        <td>
                            <span class="orders-count">{{ $user->orders_count ?? 0 }}</span>
                        </span>
                        <td>{{ $user->created_at->format('d/m/Y') }}</span>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.show', $user) }}" class="action-btn view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="action-btn delete" onclick="deleteUser({{ $user->id }})" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </span>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Aucun utilisateur trouvé</p>
                        </span
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
                <span class="text-danger">Cette action est irréversible.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn-modal-confirm" id="confirmDelete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ============================================
   GESTION DES UTILISATEURS - DESIGN MODERNE
   COINS CARRÉS - PROFESSIONNEL
   ============================================ */

:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --primary-light: #60a5fa;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --danger-dark: #dc2626;
    --info: #8b5cf6;
    --dark: #1e293b;
    --gray: #64748b;
    --gray-light: #f8fafc;
    --white: #ffffff;
    --border: #e2e8f0;
    --shadow: 0 1px 3px rgba(0,0,0,0.1);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

.users-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem;
}

/* Coins carrés */
.page-header, .btn-create, .filters-card, .search-box,
.filter-select, .btn-filter, .btn-reset, .data-card,
.user-avatar, .status-badge, .action-btn, .pagination-wrapper,
.modal-content, .btn-modal-cancel, .btn-modal-confirm {
    border-radius: 0px !important;
}

/* ==========================================
   EN-TÊTE
   ========================================== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border);
}

.header-title h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.header-title p {
    font-size: 0.813rem;
    color: var(--gray);
    margin: 0.25rem 0 0;
}

.btn-create {
    background: var(--primary);
    color: var(--white);
    padding: 0.625rem 1.25rem;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    border: none;
    cursor: pointer;
}

.btn-create:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: var(--white);
}

/* ==========================================
   FILTRES
   ========================================== */
.filters-card {
    background: var(--white);
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
}

.filters-form {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.search-box {
    flex: 2;
    position: relative;
    min-width: 200px;
}

.search-box i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.875rem;
}

.form-control-custom {
    width: 100%;
    padding: 0.625rem 0.75rem 0.625rem 2.25rem;
    border: 1px solid var(--border);
    font-size: 0.875rem;
    transition: var(--transition);
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
}

.filter-select {
    padding: 0.625rem 0.75rem;
    border: 1px solid var(--border);
    font-size: 0.875rem;
    background: var(--white);
    cursor: pointer;
    min-width: 150px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

.btn-filter {
    background: var(--primary);
    border: none;
    padding: 0.625rem 1.25rem;
    color: var(--white);
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-filter:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-reset {
    background: var(--gray-light);
    padding: 0.625rem 1rem;
    color: var(--gray);
    text-decoration: none;
    font-size: 0.875rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-reset:hover {
    background: var(--border);
    color: var(--dark);
}

/* ==========================================
   TABLEAU
   ========================================== */
.data-card {
    background: var(--white);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    background: var(--gray-light);
    padding: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray);
    text-align: left;
    border-bottom: 1px solid var(--border);
}

.data-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
    font-size: 0.875rem;
}

.data-table tbody tr:hover {
    background: var(--gray-light);
}

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-info {
    flex: 1;
}

.user-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.875rem;
}

.user-id {
    font-size: 0.688rem;
    color: var(--gray);
}

.user-email {
    color: var(--dark);
}

/* Status badges */
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.688rem;
    font-weight: 500;
}

.status-active {
    background: #d1fae5;
    color: #059669;
}

.status-inactive {
    background: #fef3c7;
    color: #d97706;
}

.status-banned {
    background: #fee2e2;
    color: #dc2626;
}

.orders-count {
    display: inline-block;
    background: var(--gray-light);
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--dark);
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-light);
    color: var(--gray);
    border: none;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.action-btn.view {
    background: #e0e7ff;
    color: #4f46e5;
}

.action-btn.view:hover {
    background: #4f46e5;
    color: var(--white);
    transform: translateY(-2px);
}

.action-btn.edit {
    background: #fef3c7;
    color: #d97706;
}

.action-btn.edit:hover {
    background: #d97706;
    color: var(--white);
    transform: translateY(-2px);
}

.action-btn.delete {
    background: #fee2e2;
    color: #dc2626;
}

.action-btn.delete:hover {
    background: #dc2626;
    color: var(--white);
    transform: translateY(-2px);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--gray);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    display: block;
}

.empty-state p {
    margin: 0;
    font-size: 0.875rem;
}

/* Pagination */
.pagination-wrapper {
    padding: 1rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
}

.pagination-wrapper nav {
    display: inline-block;
}

.pagination-wrapper .pagination {
    margin: 0;
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.pagination-wrapper .page-item {
    list-style: none;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 0.5rem;
    background: var(--white);
    border: 1px solid var(--border);
    color: var(--gray);
    font-size: 0.813rem;
    text-decoration: none;
    transition: var(--transition);
}

.pagination-wrapper .page-link:hover {
    background: var(--gray-light);
    border-color: var(--primary);
    color: var(--primary);
}

.pagination-wrapper .active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
}

/* ==========================================
   MODAL
   ========================================== */
.modal-content {
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
}

.modal-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border);
    background: var(--gray-light);
}

.modal-title {
    font-size: 1rem;
    font-weight: 600;
}

.modal-body {
    padding: 1.25rem;
    text-align: center;
}

.modal-body i {
    font-size: 3rem;
    color: var(--warning);
    margin-bottom: 1rem;
    display: block;
}

.modal-body p {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.modal-body .text-danger {
    font-size: 0.75rem;
}

.modal-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.btn-modal-cancel {
    background: var(--gray-light);
    border: 1px solid var(--border);
    padding: 0.5rem 1rem;
    font-size: 0.813rem;
    cursor: pointer;
    transition: var(--transition);
}

.btn-modal-cancel:hover {
    background: var(--border);
}

.btn-modal-confirm {
    background: var(--danger);
    border: none;
    padding: 0.5rem 1rem;
    color: var(--white);
    font-size: 0.813rem;
    cursor: pointer;
    transition: var(--transition);
}

.btn-modal-confirm:hover {
    background: var(--danger-dark);
    transform: translateY(-2px);
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    opacity: 0.5;
}

.btn-close:hover {
    opacity: 1;
}

/* ==========================================
   RESPONSIVE
   ========================================== */
@media (max-width: 992px) {
    .filters-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        width: 100%;
    }
    
    .filter-select {
        width: 100%;
    }
    
    .btn-filter, .btn-reset {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }
    
    .data-table thead {
        display: none;
    }
    
    .data-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid var(--border);
    }
    
    .data-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid var(--border);
    }
    
    .data-table tbody td:last-child {
        border-bottom: none;
    }
    
    .data-table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--gray);
        width: 40%;
    }
    
    .action-buttons {
        justify-content: flex-end;
    }
}

@media (max-width: 480px) {
    .users-container {
        padding: 0.5rem;
    }
    
    .user-cell {
        flex-wrap: wrap;
    }
}
</style>
@endpush

@push('scripts')
<script>
let userIdToDelete = null;

function deleteUser(id) {
    userIdToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete')?.addEventListener('click', function() {
    if (userIdToDelete) {
        fetch(`/admin/users/${userIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              } else {
                  alert('Erreur lors de la suppression');
              }
          });
    }
});
</script>
@endpush
@endsection