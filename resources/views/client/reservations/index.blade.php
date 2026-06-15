@extends('layouts.client')

@section('title', 'Mes réservations')

@section('content')
<div class="reservations-container">
    <!-- En-tête -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-calendar-check"></i> Mes réservations
            </h1>
            <p class="page-subtitle">Gérez vos réservations de tables</p>
        </div>
        <a href="{{ route('client.reservations.create') }}" class="btn-reserve-new">
            <i class="fas fa-plus"></i> Nouvelle réservation
        </a>
    </div>

    <!-- Statistiques -->
    <div class="stats-reservation">
        <div class="stat-res-card">
            <div class="stat-res-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-res-info">
                <span class="stat-res-value">{{ $reservations->where('statut', 'confirmee')->where('date_reservation', '>=', date('Y-m-d'))->count() }}</span>
                <span class="stat-res-label">À venir</span>
            </div>
        </div>
        <div class="stat-res-card">
            <div class="stat-res-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="stat-res-info">
                <span class="stat-res-value">{{ $reservations->where('date_reservation', '<', date('Y-m-d'))->count() }}</span>
                <span class="stat-res-label">Passées</span>
            </div>
        </div>
        <div class="stat-res-card">
            <div class="stat-res-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-res-info">
                <span class="stat-res-value">{{ $reservations->where('statut', 'annulee')->count() }}</span>
                <span class="stat-res-label">Annulées</span>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-reservation">
        <div class="filter-tabs">
            <a href="{{ route('client.reservations.index') }}" class="filter-tab {{ !request()->has('filtre') ? 'active' : '' }}">
                Toutes
            </a>
            <a href="{{ route('client.reservations.index', ['filtre' => 'a_venir']) }}" class="filter-tab {{ request('filtre') == 'a_venir' ? 'active' : '' }}">
                <i class="fas fa-calendar-day"></i> À venir
            </a>
            <a href="{{ route('client.reservations.index', ['filtre' => 'passee']) }}" class="filter-tab {{ request('filtre') == 'passee' ? 'active' : '' }}">
                <i class="fas fa-clock"></i> Passées
            </a>
            <a href="{{ route('client.reservations.index', ['filtre' => 'annulee']) }}" class="filter-tab {{ request('filtre') == 'annulee' ? 'active' : '' }}">
                <i class="fas fa-ban"></i> Annulées
            </a>
        </div>
    </div>

    <!-- Liste des réservations -->
    @if($reservations->count() > 0)
        <div class="reservations-list">
            @foreach($reservations as $resa)
            <div class="reservation-card">
                <div class="reservation-header">
                    <div class="reservation-date-large">
                        <span class="day">{{ \Carbon\Carbon::parse($resa->date_reservation)->format('d') }}</span>
                        <span class="month">{{ \Carbon\Carbon::parse($resa->date_reservation)->translatedFormat('M') }}</span>
                    </div>
                    <div class="reservation-info">
                        <div class="reservation-time">
                            <i class="far fa-clock"></i> {{ $resa->heure_reservation }}
                        </div>
                        <div class="reservation-details">
                            <span><i class="fas fa-user-friends"></i> {{ $resa->nombre_personnes }} personne(s)</span>
                            <span><i class="fas fa-chair"></i> Table {{ $resa->table_id }}</span>
                        </div>
                    </div>
                    <div class="reservation-status">
                        @if($resa->statut == 'confirmee')
                            <span class="status confirmed">
                                <i class="fas fa-check-circle"></i> Confirmée
                            </span>
                        @elseif($resa->statut == 'annulee')
                            <span class="status cancelled">
                                <i class="fas fa-times-circle"></i> Annulée
                            </span>
                        @elseif($resa->statut == 'terminee')
                            <span class="status completed">
                                <i class="fas fa-check-double"></i> Terminée
                            </span>
                        @else
                            <span class="status pending">
                                <i class="fas fa-hourglass-half"></i> En attente
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="reservation-body">
                    @if($resa->notes)
                        <div class="reservation-notes">
                            <i class="fas fa-comment"></i> {{ $resa->notes }}
                        </div>
                    @endif
                </div>
                
                <div class="reservation-footer">
                    @if($resa->statut == 'confirmee' && \Carbon\Carbon::parse($resa->date_reservation)->isFuture())
                        <button class="btn-cancel-res" onclick="cancelReservation({{ $resa->id }})">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    @endif
                    
                    @if($resa->statut == 'confirmee' && \Carbon\Carbon::parse($resa->date_reservation)->isToday())
                        <div class="reminder">
                            <i class="fas fa-bell"></i> Aujourd'hui à {{ $resa->heure_reservation }}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $reservations->appends(request()->query())->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-calendar-times fa-3x"></i>
            <h3>Aucune réservation</h3>
            <p>Vous n'avez pas encore effectué de réservation.</p>
            <a href="{{ route('client.reservations.create') }}" class="btn-reserve-empty">
                <i class="fas fa-calendar-plus"></i> Réserver une table
            </a>
        </div>
    @endif
</div>

<!-- Modal annulation -->
<div id="cancelModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Annuler la réservation</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
            <p class="warning-text">Cette action est irréversible.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Non, fermer</button>
            <button class="btn-danger" id="confirmCancelBtn">Oui, annuler</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .reservations-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* En-tête */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }

    .page-title i {
        color: #ff9f43;
        margin-right: 10px;
    }

    .page-subtitle {
        color: #64748b;
    }

    .btn-reserve-new {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 40px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-reserve-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,107,107,0.3);
        color: white;
    }

    /* Stats */
    .stats-reservation {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-res-card {
        background: white;
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }

    .stat-res-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #fff3e0, #ffe8d9);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff9f43;
        font-size: 1.2rem;
    }

    .stat-res-value {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1a1a2e;
        display: block;
    }

    .stat-res-label {
        font-size: 0.7rem;
        color: #64748b;
    }

    /* Filtres */
    .filters-reservation {
        margin-bottom: 2rem;
    }

    .filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        background: white;
        padding: 0.5rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .filter-tab {
        padding: 0.5rem 1.2rem;
        background: transparent;
        border-radius: 40px;
        text-decoration: none;
        color: #64748b;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .filter-tab:hover,
    .filter-tab.active {
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
    }

    /* Liste réservations */
    .reservations-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .reservation-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        transition: all 0.3s;
    }

    .reservation-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .reservation-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.2rem 1.5rem;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f6;
        flex-wrap: wrap;
    }

    .reservation-date-large {
        text-align: center;
        background: white;
        padding: 0.5rem 1rem;
        border-radius: 16px;
        min-width: 70px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .reservation-date-large .day {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ff9f43;
        display: block;
        line-height: 1;
    }

    .reservation-date-large .month {
        font-size: 0.7rem;
        color: #64748b;
        text-transform: uppercase;
    }

    .reservation-info {
        flex: 1;
    }

    .reservation-time {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.3rem;
    }

    .reservation-time i {
        color: #ff9f43;
        margin-right: 5px;
    }

    .reservation-details {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: #64748b;
    }

    .reservation-details i {
        margin-right: 3px;
    }

    .status {
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status.confirmed {
        background: #e8f5e9;
        color: #4caf50;
    }

    .status.cancelled {
        background: #ffebee;
        color: #e84393;
    }

    .status.completed {
        background: #e3f2fd;
        color: #2196f3;
    }

    .status.pending {
        background: #fff3e0;
        color: #ff9f43;
    }

    .reservation-body {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eef2f6;
    }

    .reservation-notes {
        font-size: 0.8rem;
        color: #64748b;
        background: #f8fafc;
        padding: 0.5rem 1rem;
        border-radius: 12px;
    }

    .reservation-notes i {
        color: #ff9f43;
        margin-right: 5px;
    }

    .reservation-footer {
        padding: 0.8rem 1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        background: #f8fafc;
    }

    .btn-cancel-res {
        padding: 0.4rem 1rem;
        background: #ffebee;
        color: #e84393;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
    }

    .btn-cancel-res:hover {
        background: #fecaca;
    }

    .reminder {
        font-size: 0.75rem;
        color: #ff9f43;
        background: #fff3e0;
        padding: 0.3rem 1rem;
        border-radius: 30px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 20px;
    }

    .empty-state i {
        margin-bottom: 1rem;
        color: #cbd5e1;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: #1a1a2e;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .btn-reserve-empty {
        display: inline-block;
        padding: 0.6rem 1.5rem;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        border-radius: 40px;
        text-decoration: none;
    }

    /* Modal */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 450px;
        overflow: hidden;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eef2f6;
    }

    .modal-header h3 {
        margin: 0;
        color: #e84393;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .warning-text {
        color: #e84393;
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #eef2f6;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-secondary {
        padding: 0.5rem 1rem;
        background: #eef2f6;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    .btn-danger {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #e84393, #fd79a8);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .stats-reservation {
            gap: 0.5rem;
        }
        
        .reservation-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-tabs {
            width: 100%;
            justify-content: center;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let reservationIdToCancel = null;
    
    function cancelReservation(id) {
        reservationIdToCancel = id;
        document.getElementById('cancelModal').style.display = 'flex';
    }
    
    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
        reservationIdToCancel = null;
    }
    
    document.getElementById('confirmCancelBtn')?.addEventListener('click', async function() {
        if (!reservationIdToCancel) return;
        
        try {
            const response = await fetch(`/client/reservations/${reservationIdToCancel}/annuler`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + (data.message || 'Impossible d\'annuler la réservation'));
                closeModal();
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
            closeModal();
        }
    });
</script>
@endpush