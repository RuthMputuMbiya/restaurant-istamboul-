@extends('layouts.client')

@section('title', 'Réserver une table')

@section('content')
<div class="reservation-form-container">
    <div class="form-header">
        <a href="{{ route('client.reservations.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 class="form-title">
            <i class="fas fa-calendar-plus"></i> Réserver une table
        </h1>
        <p class="form-subtitle">Remplissez le formulaire pour réserver votre table</p>
    </div>

    <div class="form-card">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('client.reservations.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="date_reservation">
                    <i class="fas fa-calendar-alt"></i> Date <span class="required">*</span>
                </label>
                <input type="date" 
                       name="date_reservation" 
                       id="date_reservation" 
                       class="form-control @error('date_reservation') is-invalid @enderror"
                       value="{{ old('date_reservation') }}"
                       min="{{ date('Y-m-d') }}"
                       required>
                @error('date_reservation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="heure_reservation">
                        <i class="fas fa-clock"></i> Heure <span class="required">*</span>
                    </label>
                    <select name="heure_reservation" 
                            id="heure_reservation" 
                            class="form-control @error('heure_reservation') is-invalid @enderror"
                            required>
                        <option value="">Sélectionner une heure</option>
                        <option value="11:00" {{ old('heure_reservation') == '11:00' ? 'selected' : '' }}>11:00 - Matin</option>
                        <option value="11:30" {{ old('heure_reservation') == '11:30' ? 'selected' : '' }}>11:30 - Matin</option>
                        <option value="12:00" {{ old('heure_reservation') == '12:00' ? 'selected' : '' }}>12:00 - Déjeuner</option>
                        <option value="12:30" {{ old('heure_reservation') == '12:30' ? 'selected' : '' }}>12:30 - Déjeuner</option>
                        <option value="13:00" {{ old('heure_reservation') == '13:00' ? 'selected' : '' }}>13:00 - Déjeuner</option>
                        <option value="13:30" {{ old('heure_reservation') == '13:30' ? 'selected' : '' }}>13:30 - Déjeuner</option>
                        <option value="14:00" {{ old('heure_reservation') == '14:00' ? 'selected' : '' }}>14:00 - Déjeuner tardif</option>
                        <option value="18:00" {{ old('heure_reservation') == '18:00' ? 'selected' : '' }}>18:00 - Soir</option>
                        <option value="18:30" {{ old('heure_reservation') == '18:30' ? 'selected' : '' }}>18:30 - Soir</option>
                        <option value="19:00" {{ old('heure_reservation') == '19:00' ? 'selected' : '' }}>19:00 - Dîner</option>
                        <option value="19:30" {{ old('heure_reservation') == '19:30' ? 'selected' : '' }}>19:30 - Dîner</option>
                        <option value="20:00" {{ old('heure_reservation') == '20:00' ? 'selected' : '' }}>20:00 - Dîner</option>
                        <option value="20:30" {{ old('heure_reservation') == '20:30' ? 'selected' : '' }}>20:30 - Dîner</option>
                        <option value="21:00" {{ old('heure_reservation') == '21:00' ? 'selected' : '' }}>21:00 - Dîner</option>
                        <option value="21:30" {{ old('heure_reservation') == '21:30' ? 'selected' : '' }}>21:30 - Dîner tardif</option>
                        <option value="22:00" {{ old('heure_reservation') == '22:00' ? 'selected' : '' }}>22:00 - Soirée</option>
                    </select>
                    @error('heure_reservation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nombre_personnes">
                        <i class="fas fa-user-friends"></i> Personnes <span class="required">*</span>
                    </label>
                    <select name="nombre_personnes" 
                            id="nombre_personnes" 
                            class="form-control @error('nombre_personnes') is-invalid @enderror"
                            required>
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}" {{ old('nombre_personnes', 2) == $i ? 'selected' : '' }}>{{ $i }} personne(s)</option>
                        @endfor
                    </select>
                    @error('nombre_personnes')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes">
                    <i class="fas fa-comment"></i> Notes spéciales
                </label>
                <textarea name="notes" 
                          id="notes" 
                          class="form-control"
                          rows="3"
                          placeholder="Allergies, préférences, occasion spéciale...">{{ old('notes') }}</textarea>
            </div>

            <div class="reservation-summary">
                <h3>Résumé de votre réservation</h3>
                <div class="summary-content">
                    <div class="summary-row">
                        <span>📅 Date :</span>
                        <strong id="summaryDate">--</strong>
                    </div>
                    <div class="summary-row">
                        <span>⏰ Heure :</span>
                        <strong id="summaryTime">--</strong>
                    </div>
                    <div class="summary-row">
                        <span>👥 Personnes :</span>
                        <strong id="summaryPeople">--</strong>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">
                    Annuler
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-check-circle"></i> Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .reservation-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 1rem;
    }

    .form-header {
        margin-bottom: 1.5rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .back-link:hover {
        color: #ff9f43;
        transform: translateX(-3px);
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.3rem;
    }

    .form-title i {
        color: #ff9f43;
        margin-right: 8px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 0.85rem;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.85rem;
    }

    label i {
        color: #ff9f43;
        margin-right: 5px;
    }

    .required {
        color: #e84393;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #eef2f6;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #ff9f43;
        background: white;
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }

    .error-message {
        color: #e84393;
        font-size: 0.7rem;
        margin-top: 0.3rem;
        display: block;
    }

    .alert {
        padding: 0.8rem 1rem;
        border-radius: 12px;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
    }

    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        border-left: 4px solid #4caf50;
    }

    .alert-error {
        background: #ffebee;
        color: #c62828;
        border-left: 4px solid #e84393;
    }

    .reservation-summary {
        background: linear-gradient(135deg, #fff3e0, #ffe8d9);
        border-radius: 16px;
        padding: 1rem;
        margin: 1.5rem 0;
    }

    .reservation-summary h3 {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        color: #1a1a2e;
    }

    .summary-content {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        padding: 0.3rem 0;
        border-bottom: 1px dashed rgba(255,159,67,0.3);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row strong {
        color: #ff9f43;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .btn-secondary {
        padding: 0.7rem 1.5rem;
        background: #eef2f6;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-primary {
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,107,107,0.3);
    }

    @media (max-width: 500px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }
        
        .form-card {
            padding: 1rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    const dateInput = document.getElementById('date_reservation');
    const timeSelect = document.getElementById('heure_reservation');
    const peopleSelect = document.getElementById('nombre_personnes');

    function updateSummary() {
        const date = dateInput.value;
        const time = timeSelect.value;
        const people = peopleSelect.value;

        if (date) {
            const dateObj = new Date(date);
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = dateObj.toLocaleDateString('fr-FR', options);
            document.getElementById('summaryDate').textContent = formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);
        }
        
        if (time) {
            const timeOption = timeSelect.options[timeSelect.selectedIndex];
            const timeText = timeOption.textContent;
            document.getElementById('summaryTime').textContent = timeText;
        }
        
        if (people) {
            document.getElementById('summaryPeople').textContent = people + ' personne(s)';
        }
    }

    dateInput.addEventListener('change', updateSummary);
    timeSelect.addEventListener('change', updateSummary);
    peopleSelect.addEventListener('change', updateSummary);

    // Initialisation
    updateSummary();
</script>
@endsection