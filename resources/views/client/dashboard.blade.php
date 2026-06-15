@extends('layouts.client')

@section('title', 'Tableau de bord')

@section('content')
<div class="dashboard-container">

    <!-- ========================================== -->
    <!-- SECTION HERO - PROFIL UTILISATEUR -->
    <!-- ========================================== -->
    <div class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-avatar">
                    <span class="avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    <span class="avatar-status online"></span>
                </div>
                <div class="hero-info">
                    <h1 class="hero-greeting">Bonjour, <span class="hero-name">{{ Auth::user()->name }}</span></h1>
                    <p class="hero-subtitle">Bienvenue sur votre espace client Restaurant Istanbul</p>
                    <div class="hero-badge">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Membre depuis {{ Auth::user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-date">
                    <div class="hero-date-day">{{ now()->format('d') }}</div>
                    <div class="hero-date-info">
                        <div class="hero-date-month">{{ now()->translatedFormat('F') }}</div>
                        <div class="hero-date-year">{{ now()->format('Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION STATISTIQUES - 4 CARTES -->
    <!-- ========================================== -->
    <div class="stats-grid">
        <div class="stat-card-v2 stat-card-reservations-v2">
            <div class="stat-card-v2-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card-v2-content">
                <span class="stat-card-v2-label">Réservations</span>
                <div class="stat-card-v2-value">{{ $totalReservations ?? 0 }}</div>
                <div class="stat-card-v2-footer">
                    <span class="stat-card-v2-trend">
                        <i class="fas fa-chart-line"></i> Total
                    </span>
                </div>
            </div>
            <div class="stat-card-v2-bg">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>

        <div class="stat-card-v2 stat-card-commandes-v2">
            <div class="stat-card-v2-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-card-v2-content">
                <span class="stat-card-v2-label">Commandes</span>
                <div class="stat-card-v2-value">{{ $totalCommandes ?? 0 }}</div>
                <div class="stat-card-v2-footer">
                    <span class="stat-card-v2-trend">
                        <i class="fas fa-chart-line"></i> Total
                    </span>
                </div>
            </div>
            <div class="stat-card-v2-bg">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>

        <div class="stat-card-v2 stat-card-depenses-v2">
            <div class="stat-card-v2-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-v2-content">
                <span class="stat-card-v2-label">Total dépensé</span>
                <div class="stat-card-v2-value">{{ number_format($totalDepense ?? 0, 0, ',', ' ') }} <small>FC</small></div>
                <div class="stat-card-v2-footer">
                    <span class="stat-card-v2-trend">
                        <i class="fas fa-wallet"></i> À vie
                    </span>
                </div>
            </div>
            <div class="stat-card-v2-bg">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>

        <!-- CARTE PAIEMENTS EN LIGNE -->
        <div class="stat-card-v2 stat-card-paiements-v2">
            <div class="stat-card-v2-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stat-card-v2-content">
                <span class="stat-card-v2-label">Paiements en ligne</span>
                <div class="stat-card-v2-value">{{ $totalPaiementsEnLigne ?? 0 }}</div>
                <div class="stat-card-v2-footer">
                    <span class="stat-card-v2-trend">
                        <i class="fas fa-check-circle"></i> Validés
                    </span>
                </div>
            </div>
            <div class="stat-card-v2-bg">
                <i class="fas fa-credit-card"></i>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION COMMANDES À PAYER -->
    <!-- ========================================== -->
    @if(isset($commandesAPayer) && $commandesAPayer->count() > 0)
    <div class="payment-alert-section">
        <div class="payment-alert-header">
            <i class="fas fa-bell"></i>
            <span>Commandes en attente de paiement</span>
        </div>
        <div class="payment-alert-body">
            @foreach($commandesAPayer as $commande)
            <div class="payment-alert-item">
                <div class="payment-info">
                    <div class="payment-commande">Commande #{{ $commande->id }}</div>
                    <div class="payment-amount">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</div>
                    <div class="payment-date">{{ $commande->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <a href="{{ route('client.paiement.index') }}" class="payment-btn">
                    <i class="fas fa-credit-card"></i>
                    <span>Payer maintenant</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- ========================================== -->
    <!-- SECTION PROCHAINE RÉSERVATION -->
    <!-- ========================================== -->
    @if(isset($prochaineReservation) && $prochaineReservation)
    <div class="next-reservation-section">
        <div class="next-reservation-header">
            <i class="fas fa-bell"></i>
            <span>Prochaine réservation</span>
        </div>
        <div class="next-reservation-body">
            <div class="next-reservation-info">
                <div class="next-reservation-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ \Carbon\Carbon::parse($prochaineReservation->date_reservation)->translatedFormat('l d F Y') }}</span>
                </div>
                <div class="next-reservation-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ \Carbon\Carbon::parse($prochaineReservation->heure_reservation)->format('H:i') }}</span>
                </div>
                <div class="next-reservation-item">
                    <i class="fas fa-chair"></i>
                    <span>Table {{ $prochaineReservation->table->numero ?? 'N/A' }}</span>
                </div>
                <div class="next-reservation-item">
                    <i class="fas fa-users"></i>
                    <span>{{ $prochaineReservation->nombre_personnes }} personne(s)</span>
                </div>
            </div>
            <a href="{{ route('client.reservations.index') }}" class="next-reservation-link">
                Gérer <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- ========================================== -->
    <!-- SECTION ACTIONS RAPIDES -->
    <!-- ========================================== -->
    <div class="actions-grid">
        <a href="{{ route('client.reservations.create') }}" class="action-card-v2 action-reserve">
            <div class="action-card-v2-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="action-card-v2-content">
                <h4>Réserver une table</h4>
                <p>Réservez votre table en ligne en quelques clics</p>
            </div>
            <div class="action-card-v2-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
        <a href="{{ route('client.menu') }}" class="action-card-v2 action-commander">
            <div class="action-card-v2-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="action-card-v2-content">
                <h4>Passer commande</h4>
                <p>Commandez vos plats préférés et faites-vous livrer</p>
            </div>
            <div class="action-card-v2-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
        <a href="{{ route('client.paiement.index') }}" class="action-card-v2 action-payer">
            <div class="action-card-v2-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="action-card-v2-content">
                <h4>Payer en ligne</h4>
                <p>Réglez vos commandes en toute sécurité</p>
            </div>
            <div class="action-card-v2-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
        <a href="{{ route('client.commandes.index') }}" class="action-card-v2 action-suivi">
            <div class="action-card-v2-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="action-card-v2-content">
                <h4>Suivi commandes</h4>
                <p>Suivez l'état de vos commandes en temps réel</p>
            </div>
            <div class="action-card-v2-arrow">
                <i class="fas fa-arrow-right"></i>
            </div>
        </a>
    </div>

    <!-- ========================================== -->
    <!-- SECTION DERNIÈRES ACTIVITÉS -->
    <!-- ========================================== -->
    <div class="activities-grid">
        <!-- Dernières commandes -->
        <div class="activity-card">
            <div class="activity-card-header">
                <div class="activity-card-title">
                    <i class="fas fa-clock"></i>
                    <h3>Dernières commandes</h3>
                </div>
                <a href="{{ route('client.commandes.index') }}" class="activity-card-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-card-body">
                @if(isset($commandesRecentes) && $commandesRecentes->count() > 0)
                    <div class="activity-table">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>N° commande</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commandesRecentes as $commande)
                                <tr>
                                    <td><span class="order-id">#{{ $commande->id }}</span></td>
                                    <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                                    <td class="amount">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</span>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'en_attente' => 'status-warning',
                                                'validee' => 'status-info',
                                                'en_preparation' => 'status-info',
                                                'pret' => 'status-success',
                                                'paye' => 'status-success',
                                                'servi' => 'status-primary',
                                            ];
                                        @endphp
                                        <span class="status {{ $statusClasses[$commande->statut] ?? 'status-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-activity">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <p>Aucune commande pour le moment</p>
                        <a href="{{ route('client.menu') }}" class="empty-btn">Découvrir le menu</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dernières réservations -->
        <div class="activity-card">
            <div class="activity-card-header">
                <div class="activity-card-title">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Dernières réservations</h3>
                </div>
                <a href="{{ route('client.reservations.index') }}" class="activity-card-link">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="activity-card-body">
                @if(isset($reservationsRecentes) && $reservationsRecentes->count() > 0)
                    <div class="activity-table">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Table</th>
                                    <th>Personnes</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservationsRecentes as $reservation)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->heure_reservation)->format('H:i') }}</td>
                                    <td>Table {{ $reservation->table->numero ?? 'N/A' }}</td>
                                    <td>{{ $reservation->nombre_personnes }}</td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'confirmee' => 'status-success',
                                                'terminee' => 'status-secondary',
                                                'annulee' => 'status-danger',
                                            ];
                                        @endphp
                                        <span class="status {{ $statusClasses[$reservation->statut] ?? 'status-warning' }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-activity">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <p>Aucune réservation pour le moment</p>
                        <a href="{{ route('client.reservations.create') }}" class="empty-btn">Réserver une table</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* ========================================== */
    /* CONTAINER PRINCIPAL */
    /* ========================================== */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px 40px;
    }

    /* ========================================== */
    /* SECTION HERO - PROFIL UTILISATEUR */
    /* ========================================== */
    .hero-section {
        position: relative;
        margin-bottom: 40px;
        border-radius: 32px;
        overflow: hidden;
    }
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        z-index: 0;
    }
    .hero-background::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(245, 158, 11, 0.1);
        border-radius: 50%;
    }
    .hero-background::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(245, 158, 11, 0.08);
        border-radius: 50%;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        padding: 32px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .hero-left {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }
    .hero-avatar {
        position: relative;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);
    }
    .avatar-initials {
        font-size: 28px;
        font-weight: 700;
        color: white;
    }
    .avatar-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid white;
    }
    .hero-info {
        color: white;
    }
    .hero-greeting {
        font-size: 24px;
        font-weight: 500;
        margin: 0 0 8px 0;
    }
    .hero-name {
        font-weight: 800;
        color: #f59e0b;
    }
    .hero-subtitle {
        font-size: 14px;
        opacity: 0.8;
        margin: 0 0 12px 0;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 12px;
    }
    .hero-right {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .hero-date-day {
        font-size: 48px;
        font-weight: 800;
        color: white;
        line-height: 1;
    }
    .hero-date-info {
        border-left: 1px solid rgba(255,255,255,0.3);
        padding-left: 16px;
    }
    .hero-date-month {
        font-size: 16px;
        font-weight: 600;
        color: #f59e0b;
    }
    .hero-date-year {
        font-size: 12px;
        opacity: 0.7;
    }

    /* CARTE PAIEMENTS */
    .stat-card-paiements-v2 .stat-card-v2-icon { 
        background: linear-gradient(135deg, #8b5cf6, #7c3aed); 
    }

    /* ========================================== */
    /* SECTION ALERTE PAIEMENT */
    /* ========================================== */
    .payment-alert-section {
        background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%);
        border-radius: 20px;
        margin-bottom: 40px;
        overflow: hidden;
        border-left: 4px solid #f59e0b;
    }
    .payment-alert-header {
        background: #f59e0b;
        padding: 12px 24px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 0 30px 30px 0;
    }
    .payment-alert-body {
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .payment-alert-item {
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .payment-info {
        display: flex;
        gap: 30px;
        align-items: center;
        flex-wrap: wrap;
    }
    .payment-commande {
        font-weight: 700;
        color: #1a1a2e;
    }
    .payment-amount {
        font-size: 1.2rem;
        font-weight: 800;
        color: #f59e0b;
    }
    .payment-date {
        font-size: 0.8rem;
        color: #64748b;
    }
    .payment-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s;
    }
    .payment-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16,185,129,0.3);
        color: white;
    }

    /* ========================================== */
    /* GRILLE STATISTIQUES */
    /* ========================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    .stat-card-v2 {
        background: white;
        border-radius: 24px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }
    .stat-card-v2:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .stat-card-v2-icon {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        flex-shrink: 0;
    }
    .stat-card-reservations-v2 .stat-card-v2-icon { background: linear-gradient(135deg, #3b82f6, #1e40af); }
    .stat-card-commandes-v2 .stat-card-v2-icon { background: linear-gradient(135deg, #10b981, #047857); }
    .stat-card-depenses-v2 .stat-card-v2-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-card-paiements-v2 .stat-card-v2-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .stat-card-v2-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }
    .stat-card-v2-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        font-weight: 600;
    }
    .stat-card-v2-value {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        margin: 8px 0;
        line-height: 1;
    }
    .stat-card-v2-value small {
        font-size: 16px;
        font-weight: 500;
    }
    .stat-card-v2-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .stat-card-v2-trend {
        font-size: 11px;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .stat-card-v2-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 70px;
        opacity: 0.05;
        z-index: 1;
    }

    /* ========================================== */
    /* SECTION PROCHAINE RÉSERVATION */
    /* ========================================== */
    .next-reservation-section {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-radius: 20px;
        margin-bottom: 40px;
        overflow: hidden;
        border-left: 4px solid #f59e0b;
    }
    .next-reservation-header {
        background: #f59e0b;
        padding: 12px 24px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 0 30px 30px 0;
    }
    .next-reservation-body {
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .next-reservation-info {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
    }
    .next-reservation-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #92400e;
        font-size: 14px;
    }
    .next-reservation-item i {
        width: 18px;
        color: #f59e0b;
    }
    .next-reservation-link {
        background: #f59e0b;
        color: white;
        padding: 10px 28px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }
    .next-reservation-link:hover {
        background: #d97706;
        transform: translateY(-2px);
    }

    /* ========================================== */
    /* GRILLE ACTIONS RAPIDES */
    /* ========================================== */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    .action-card-v2 {
        background: white;
        border-radius: 20px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .action-card-v2:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .action-card-v2-icon {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    .action-reserve .action-card-v2-icon { background: linear-gradient(135deg, #3b82f6, #1e40af); }
    .action-commander .action-card-v2-icon { background: linear-gradient(135deg, #10b981, #047857); }
    .action-payer .action-card-v2-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .action-suivi .action-card-v2-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .action-card-v2-content {
        flex: 1;
    }
    .action-card-v2-content h4 {
        margin: 0 0 5px 0;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .action-card-v2-content p {
        margin: 0;
        font-size: 13px;
        color: #64748b;
    }
    .action-card-v2-arrow {
        color: #cbd5e1;
        transition: all 0.3s;
    }
    .action-card-v2:hover .action-card-v2-arrow {
        transform: translateX(5px);
        color: #f59e0b;
    }

    /* ========================================== */
    /* GRILLE DERNIÈRES ACTIVITÉS */
    /* ========================================== */
    .activities-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
    .activity-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .activity-card:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .activity-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .activity-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .activity-card-title i {
        color: #f59e0b;
        font-size: 18px;
    }
    .activity-card-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .activity-card-link {
        color: #f59e0b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .activity-card-link:hover {
        color: #d97706;
    }
    .activity-card-body {
        padding: 0;
    }

    /* ========================================== */
    /* TABLEAUX MODERNES */
    /* ========================================== */
    .modern-table {
        width: 100%;
    }
    .modern-table thead th {
        background: #f8fafc;
        padding: 14px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #eef2f6;
    }
    .modern-table tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        vertical-align: middle;
    }
    .modern-table tbody tr:hover {
        background: #fffbeb;
    }
    .order-id {
        font-family: monospace;
        font-weight: 700;
        color: #f59e0b;
    }
    .amount {
        font-weight: 600;
        color: #1e293b;
    }
    .status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-success { background: #d1fae5; color: #059669; }
    .status-warning { background: #fef3c7; color: #d97706; }
    .status-info { background: #dbeafe; color: #2563eb; }
    .status-danger { background: #fee2e2; color: #dc2626; }
    .status-primary { background: #e0e7ff; color: #4f46e5; }
    .status-secondary { background: #f1f5f9; color: #64748b; }

    /* ========================================== */
    /* ÉTAT VIDE */
    /* ========================================== */
    .empty-activity {
        text-align: center;
        padding: 48px 24px;
    }
    .empty-icon {
        width: 60px;
        height: 60px;
        background: #f8fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        color: #cbd5e1;
    }
    .empty-activity p {
        margin: 0 0 16px 0;
        color: #94a3b8;
        font-size: 13px;
    }
    .empty-btn {
        background: #f59e0b;
        color: white;
        padding: 8px 24px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s;
    }
    .empty-btn:hover {
        background: #d97706;
        transform: translateY(-2px);
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .actions-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1024px) {
        .stats-grid { gap: 16px; }
        .activities-grid { grid-template-columns: 1fr; }
        .hero-content { padding: 24px; flex-direction: column; text-align: center; }
        .hero-left { justify-content: center; }
    }
    @media (max-width: 768px) {
        .dashboard-container { padding: 0 16px 32px; }
        .stats-grid { grid-template-columns: 1fr; }
        .actions-grid { grid-template-columns: 1fr; }
        .hero-avatar { width: 60px; height: 60px; }
        .avatar-initials { font-size: 20px; }
        .hero-greeting { font-size: 18px; }
        .stat-card-v2-value { font-size: 28px; }
        .payment-info { gap: 15px; }
        .payment-alert-item { flex-direction: column; text-align: center; }
    }
</style>
@endpush
@endsection