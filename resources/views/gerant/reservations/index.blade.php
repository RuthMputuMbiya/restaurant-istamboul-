{{-- resources/views/gerant/reservations/index.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Gestion des réservations')
@section('page-title', 'Gestion des réservations')
@section('page-subtitle', 'Gérez toutes les réservations du restaurant')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-calendar-check text-primary me-3"></i>Réservations
                    </h1>
                    <p class="text-muted">Gérez toutes les réservations du restaurant</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="date" id="filtreDate" class="form-control rounded-pill" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <select id="filtreStatut" class="form-select rounded-pill">
                        <option value="all">Tous les statuts</option>
                        <option value="confirmee">Confirmée</option>
                        <option value="en_attente">En attente</option>
                        <option value="terminee">Terminée</option>
                        <option value="annulee">Annulée</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchClient" class="form-control rounded-pill" placeholder="🔍 Nom du client...">
                </div>
                <div class="col-md-3">
                    <button id="resetFiltres" class="btn btn-outline-secondary rounded-pill w-100">
                        <i class="fas fa-undo-alt me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des réservations -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-white rounded-top-4 py-3 border-0">
            <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Liste des réservations</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="reservationsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Table</th>
                            <th>Personnes</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $reservation->client->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $reservation->client->telephone ?? 'N/A' }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</td>
                            <td>{{ $reservation->heure_reservation }}</td>
                            <td><span class="badge bg-info">Table {{ $reservation->table->numero ?? 'N/A' }}</span></td>
                            <td><i class="fas fa-users me-1"></i> {{ $reservation->nombre_personnes }}</td>
                            <td>
                                @if($reservation->statut == 'confirmee')
                                    <span class="badge bg-success rounded-pill">Confirmée</span>
                                @elseif($reservation->statut == 'en_attente')
                                    <span class="badge bg-warning rounded-pill">En attente</span>
                                @elseif($reservation->statut == 'terminee')
                                    <span class="badge bg-secondary rounded-pill">Terminée</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">Annulée</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-sm btn-outline-info rounded-pill me-1" onclick="showDetails({{ json_encode($reservation) }})">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($reservation->statut == 'confirmee')
                                        <form action="{{ route('gerant.reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Annuler cette réservation ?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Aucune réservation trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filtrerReservations() {
        let date = $('#filtreDate').val();
        let statut = $('#filtreStatut').val();
        let client = $('#searchClient').val().toLowerCase();

        $('#reservationsTable tbody tr').each(function() {
            let show = true;
            let rowDate = $(this).find('td:eq(1)').text().split('/').reverse().join('-');
            let rowStatut = $(this).find('td:eq(5)').text().trim();
            let rowClient = $(this).find('td:eq(0) .fw-bold').text().toLowerCase();
            
            if(date && rowDate !== date) show = false;
            if(statut !== 'all' && !rowStatut.toLowerCase().includes(statut)) show = false;
            if(client && !rowClient.includes(client)) show = false;
            
            $(this).toggle(show);
        });
    }

    function showDetails(reservation) {
        alert(`Client: ${reservation.client.name}\nDate: ${reservation.date_reservation}\nHeure: ${reservation.heure_reservation}\nTable: ${reservation.table.numero}\nPersonnes: ${reservation.nombre_personnes}`);
    }

    $('#filtreDate, #filtreStatut, #searchClient').on('change keyup', filtrerReservations);
    $('#resetFiltres').click(function() {
        $('#filtreDate').val('{{ date("Y-m-d") }}');
        $('#filtreStatut').val('all');
        $('#searchClient').val('');
        filtrerReservations();
    });
</script>
@endpush
@endsection