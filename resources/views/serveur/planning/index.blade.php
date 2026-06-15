@extends('layouts.serveur')

@section('title', 'Planning des réservations')

@section('serveur-content')
<div class="planning-page">
    <div class="container-fluid px-4 py-4">

        <!-- Header -->
        <div class="page-header mb-4">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h1 class="page-title">Planning des réservations</h1>
                    <p class="page-subtitle">Gérez toutes les réservations clients</p>
                </div>
            </div>
            <div class="date-display">
                <i class="fas fa-calendar-day"></i>
                <span>{{ now()->translatedFormat('l d F Y') }}</span>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-today"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['aujourdhui'] ?? 0 }}</span>
                    <span class="stat-label">Réservations aujourd'hui</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['semaine'] ?? 0 }}</span>
                    <span class="stat-label">Cette semaine</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-value">{{ $stats['mois'] ?? 0 }}</span>
                    <span class="stat-label">Ce mois</span>
                </div>
            </div>
        </div>

        <!-- Reservations Table -->
        <div class="reservations-table-wrapper">
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar"></i> Date</th>
                        <th><i class="fas fa-clock"></i> Heure</th>
                        <th><i class="fas fa-chair"></i> Table</th>
                        <th><i class="fas fa-user"></i> Client</th>
                        <th><i class="fas fa-user-friends"></i> Personnes</th>
                        <th><i class="fas fa-phone"></i> Téléphone</th>
                        <th><i class="fas fa-info-circle"></i> Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                    <tr>
                        <td class="date-cell">
                            <span class="date-day">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m') }}</span>
                            <span class="date-week">{{ \Carbon\Carbon::parse($reservation->date_reservation)->translatedFormat('l') }}</span>
                        </td>
                        <td class="time-cell">{{ $reservation->heure_reservation }}</td>
                        <td>Table {{ $reservation->table->numero ?? 'N/A' }}</td>
                        <td>
                            <div class="client-name">
                                <div class="client-avatar">{{ substr($reservation->client->name ?? 'C', 0, 1) }}</div>
                                <span>{{ $reservation->client->name ?? 'Client' }}</span>
                            </div>
                        </td>
                        <td>{{ $reservation->nombre_personnes }}</td>
                        <td>{{ $reservation->client->telephone ?? 'Non renseigné' }}</td>
                        <td>
                            <span class="status-badge status-{{ $reservation->statut ?? 'confirmee' }}">
                                <i class="fas fa-check-circle"></i> Confirmée
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-calendar-check fa-4x"></i>
                            <h3>Aucune réservation</h3>
                            <p>Aucune réservation n'a été trouvée</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
    .planning-page {
        background: linear-gradient(135deg, #f5f7fb 0%, #f0f2f6 100%);
        min-height: 100vh;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        padding: 20px 25px;
        border-radius: 24px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .header-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(155,89,182,0.3);
    }
    .header-icon i { font-size: 1.6rem; color: white; }
    .page-title { font-size: 1.6rem; font-weight: 800; margin: 0; color: #1a1a2e; }
    .page-subtitle { font-size: 0.8rem; color: #64748b; margin-top: 5px; }
    .date-display {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        background: #eef2f6;
        border-radius: 40px;
        font-weight: 500;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-icon i { font-size: 1.5rem; color: white; }
    .stat-icon.purple { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
    .stat-icon.blue { background: linear-gradient(135deg, #3498db, #2980b9); }
    .stat-icon.green { background: linear-gradient(135deg, #27ae60, #1e7e34); }
    .stat-value { font-size: 1.8rem; font-weight: 800; display: block; color: #1a1a2e; }
    .stat-label { font-size: 0.7rem; color: #64748b; }
    .reservations-table-wrapper {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .reservations-table {
        width: 100%;
        border-collapse: collapse;
    }
    .reservations-table thead th {
        padding: 18px 20px;
        background: #f8fafc;
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        border-bottom: 1px solid #eef2f6;
    }
    .reservations-table tbody tr {
        border-bottom: 1px solid #eef2f6;
        transition: all 0.3s;
    }
    .reservations-table tbody tr:hover { background: #fafbfc; }
    .reservations-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
    }
    .date-cell {
        display: flex;
        flex-direction: column;
    }
    .date-day { font-weight: 700; font-size: 1rem; }
    .date-week { font-size: 0.7rem; color: #ff9f43; }
    .time-cell { font-weight: 600; font-size: 1rem; }
    .client-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .client-avatar {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
        background: #e8f5e9;
        color: #4caf50;
    }
    .empty-state {
        text-align: center;
        padding: 60px !important;
    }
    .empty-state i { color: #cbd5e1; margin-bottom: 15px; }
    .empty-state h3 { font-size: 1.2rem; margin-bottom: 8px; }
    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: 1fr; }
        .reservations-table { display: block; overflow-x: auto; }
    }
</style>
@endsection