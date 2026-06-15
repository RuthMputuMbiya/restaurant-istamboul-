{{-- resources/views/client/reservations/show.blade.php --}}
@extends('layouts.client')

@section('title', 'Détails réservation')

@section('client-content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('client.reservations.index') }}" class="btn btn-outline-secondary rounded-pill me-3">
            <i class="fas fa-arrow-left me-2"></i>Mes réservations
        </a>
        <div>
            <h1 class="display-6 fw-bold text-dark">
                <i class="fas fa-calendar-check text-primary me-3"></i>Détails de la réservation
            </h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Date</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Heure</div>
                            <div class="info-value">{{ $reservation->heure_reservation }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Table</div>
                            <div class="info-value">Table {{ $reservation->table->numero }} ({{ $reservation->table->capacite }} places)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Nombre de personnes</div>
                            <div class="info-value">{{ $reservation->nombre_personnes }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Statut</div>
                            <div class="info-value">
                                @if($reservation->statut == 'confirmee')
                                    <span class="badge bg-success">Confirmée</span>
                                @elseif($reservation->statut == 'en_attente')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($reservation->statut == 'terminee')
                                    <span class="badge bg-secondary">Terminée</span>
                                @else
                                    <span class="badge bg-danger">Annulée</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-label">Date de création</div>
                            <div class="info-value">{{ $reservation->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @if($reservation->notes)
                        <div class="col-12 mb-3">
                            <div class="info-label">Notes spéciales</div>
                            <div class="info-value">{{ $reservation->notes }}</div>
                        </div>
                        @endif
                    </div>

                    <div class="alert alert-info rounded-4 mt-3">
                        <i class="fas fa-clock me-2"></i>
                        Votre table sera réservée pour 15 minutes après l'heure choisie.
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        @if($reservation->statut == 'confirmee')
                        <a href="{{ route('client.reservations.edit', $reservation) }}" class="btn btn-warning rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <form action="{{ route('client.reservations.annuler', $reservation) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('Annuler cette réservation ?')">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('client.reservations.index') }}" class="btn btn-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }
    .info-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
    }
</style>
@endpush
@endsection