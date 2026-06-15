@extends('layouts.client')

@section('title', 'Modifier la réservation')

@section('content')
<div class="reservation-edit-container">
    <div class="form-header">
        <a href="{{ route('client.reservations.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 class="form-title">
            <i class="fas fa-edit"></i> Modifier la réservation
        </h1>
        <p class="form-subtitle">Modifiez les informations de votre réservation</p>
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

        @if($errors->any())
            <div class="alert alert-error">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-times-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('client.reservations.update', $reservation->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="date_reservation">
                        <i class="fas fa-calendar-alt"></i> Date <span class="required">*</span>
                    </label>
                    <input type="date" 
                           name="date_reservation" 
                           id="date_reservation" 
                           class="form-control"
                           value="{{ old('date_reservation', $reservation->date_reservation) }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="heure_reservation">
                        <i class="fas fa-clock"></i> Heure <span class="required">*</span>
                    </label>
                    <select name="heure_reservation" id="heure_reservation" class="form-control" required>
                        <option value="">Sélectionner une heure</option>
                        <option value="12:00" {{ old('heure_reservation', $reservation->heure_reservation) == '12:00' ? 'selected' : '' }}>12:00</option>
                        <option value="12:30" {{ old('heure_reservation', $reservation->heure_reservation) == '12:30' ? 'selected' : '' }}>12:30</option>
                        <option value="13:00" {{ old('heure_reservation', $reservation->heure_reservation) == '13:00' ? 'selected' : '' }}>13:00</option>
                        <option value="13:30" {{ old('heure_reservation', $reservation->heure_reservation) == '13:30' ? 'selected' : '' }}>13:30</option>
                        <option value="18:00" {{ old('heure_reservation', $reservation->heure_reservation) == '18:00' ? 'selected' : '' }}>18:00</option>
                        <option value="18:30" {{ old('heure_reservation', $reservation->heure_reservation) == '18:30' ? 'selected' : '' }}>18:30</option>
                        <option value="19:00" {{ old('heure_reservation', $reservation->heure_reservation) == '19:00' ? 'selected' : '' }}>19:00</option>
                        <option value="19:30" {{ old('heure_reservation', $reservation->heure_reservation) == '19:30' ? 'selected' : '' }}>19:30</option>
                        <option value="20:00" {{ old('heure_reservation', $reservation->heure_reservation) == '20:00' ? 'selected' : '' }}>20:00</option>
                        <option value="20:30" {{ old('heure_reservation', $reservation->heure_reservation) == '20:30' ? 'selected' : '' }}>20:30</option>
                        <option value="21:00" {{ old('heure_reservation', $reservation->heure_reservation) == '21:00' ? 'selected' : '' }}>21:00</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre_personnes">
                        <i class="fas fa-user-friends"></i> Nombre de personnes <span class="required">*</span>
                    </label>
                    <input type="number" 
                           name="nombre_personnes" 
                           id="nombre_personnes" 
                           class="form-control"
                           value="{{ old('nombre_personnes', $reservation->nombre_personnes) }}"
                           min="1"
                           max="20"
                           required>
                </div>

                <div class="form-group">
                    <label for="table_id">
                        <i class="fas fa-chair"></i> Table <span class="required">*</span>
                    </label>
                    <select name="table_id" id="table_id" class="form-control" required>
                        <option value="">Sélectionner une table</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}" 
                                {{ old('table_id', $reservation->table_id) == $table->id ? 'selected' : '' }}>
                                Table {{ $table->numero }} ({{ $table->capacite }} places) - {{ $table->zone ?? 'Salle' }}
                            </option>
                        @endforeach
                    </select>
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
                          placeholder="Allergies, préférences, occasion spéciale...">{{ old('notes', $reservation->notes) }}</textarea>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                La modification de la réservation est soumise à disponibilité de la table.
            </div>

            <div class="reservation-summary">
                <h3>Résumé de la réservation</h3>
                <div class="summary-content">
                    <div class="summary-row">
                        <span>📅 Date :</span>
                        <strong id="summaryDate">{{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>⏰ Heure :</span>
                        <strong id="summaryTime">{{ $reservation->heure_reservation }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>👥 Personnes :</span>
                        <strong id="summaryPeople">{{ $reservation->nombre_personnes }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>🪑 Table :</span>
                        <strong id="summaryTable">{{ $reservation->table->numero ?? 'Non assignée' }}</strong>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('client.reservations.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .reservation-edit-container {
        max-width: 700px;
        margin: 0 auto;
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 1rem;
        font-size: 0.85rem;
    }

    .back-link:hover {
        color: #ff9f43;
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }

    .form-title i {
        color: #ff9f43;
        margin-right: 10px;
    }

    .form-subtitle {
        color: #64748b;
    }

    .form-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
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
        padding: 0.8rem 1rem;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #ff9f43;
        box-shadow: 0 0 0 3px rgba(255,159,67,0.1);
    }

    select.form-control {
        cursor: pointer;
    }

    textarea.form-control {
        resize: vertical;
    }

    .alert {
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #e8f5e9;
        color: #4caf50;
    }

    .alert-error {
        background: #ffebee;
        color: #e84393;
    }

    .alert-info {
        background: #e3f2fd;
        color: #2196f3;
    }

    .alert ul {
        margin: 0;
        padding-left: 1rem;
    }

    .reservation-summary {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .reservation-summary h3 {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
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
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        color: #1a1a2e;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    .btn-primary {
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #ff9f43, #ff6b6b);
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,107,107,0.3);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
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
@endpush

@push('scripts')
<script>
    const dateInput = document.getElementById('date_reservation');
    const timeSelect = document.getElementById('heure_reservation');
    const peopleInput = document.getElementById('nombre_personnes');
    const tableSelect = document.getElementById('table_id');

    function updateSummary() {
        const date = dateInput.value;
        const time = timeSelect.value;
        const people = peopleInput.value;
        const table = tableSelect.options[tableSelect.selectedIndex]?.text;

        if (date) {
            const dateObj = new Date(date);
            document.getElementById('summaryDate').textContent = dateObj.toLocaleDateString('fr-FR', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
        
        if (time) {
            document.getElementById('summaryTime').textContent = time;
        }
        
        if (people) {
            document.getElementById('summaryPeople').textContent = people + ' personne(s)';
        }
        
        if (table) {
            document.getElementById('summaryTable').textContent = table;
        }
    }

    dateInput.addEventListener('change', updateSummary);
    timeSelect.addEventListener('change', updateSummary);
    peopleInput.addEventListener('input', updateSummary);
    tableSelect.addEventListener('change', updateSummary);
</script>
@endpush