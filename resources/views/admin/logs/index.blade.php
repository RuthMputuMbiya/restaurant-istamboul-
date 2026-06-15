{{-- resources/views/admin/logs/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Logs système')
@section('page-title', 'Logs système')
@section('page-subtitle', 'Consultez les logs de l\'application')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-history text-info me-3"></i>Logs système
                    </h1>
                    <p class="text-muted">Consultez les logs de l'application</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.logs.download') }}" class="btn btn-outline-success rounded-pill px-4">
                        <i class="fas fa-download me-2"></i>Télécharger
                    </a>
                    <form action="{{ route('admin.logs.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Vider tous les logs ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                            <i class="fas fa-trash me-2"></i>Vider
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select id="levelFilter" class="form-select rounded-pill">
                        <option value="all">Tous les niveaux</option>
                        <option value="error">Erreurs</option>
                        <option value="warning">Avertissements</option>
                        <option value="info">Informations</option>
                        <option value="debug">Debug</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" id="searchLog" class="form-control rounded-pill" placeholder="🔍 Rechercher dans les logs...">
                </div>
                <div class="col-md-4">
                    <button id="resetFilters" class="btn btn-outline-secondary rounded-pill w-100">
                        <i class="fas fa-undo-alt me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des logs -->
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-white rounded-top-4 py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>Historique des logs
                </h5>
                <span class="badge bg-secondary rounded-pill">{{ count($logs) }} entrées</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="logs-container" style="max-height: 600px; overflow-y: auto;">
                @forelse($logs as $log)
                <div class="log-entry log-{{ $log['level'] }}" data-level="{{ $log['level'] }}" data-content="{{ strtolower($log['content']) }}">
                    <div class="log-header">
                        <span class="log-level">
                            <i class="fas {{ $log['icon'] }}"></i>
                            {{ strtoupper($log['level']) }}
                        </span>
                        <span class="log-time">
                            <i class="far fa-clock"></i>
                            {{ now()->format('d/m/Y H:i:s') }}
                        </span>
                    </div>
                    <div class="log-message">
                        <code>{{ $log['content'] }}</code>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun log trouvé</h5>
                    <p class="text-muted">Les logs apparaîtront ici</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .logs-container {
        font-family: 'Courier New', monospace;
        font-size: 13px;
    }
    
    .log-entry {
        border-bottom: 1px solid #e9ecef;
        padding: 12px 20px;
        transition: background 0.2s ease;
    }
    
    .log-entry:hover {
        background: #f8f9fa;
    }
    
    .log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .log-level {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .log-error .log-level {
        background: #e74c3c20;
        color: #e74c3c;
    }
    
    .log-warning .log-level {
        background: #f39c1220;
        color: #f39c12;
    }
    
    .log-info .log-level {
        background: #3498db20;
        color: #3498db;
    }
    
    .log-debug .log-level {
        background: #6c757d20;
        color: #6c757d;
    }
    
    .log-time {
        font-size: 11px;
        color: #6c757d;
    }
    
    .log-message code {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 8px;
        display: block;
        white-space: pre-wrap;
        word-break: break-all;
        font-size: 12px;
        color: #2c3e50;
    }
</style>
@endpush

@push('scripts')
<script>
    function filterLogs() {
        let level = $('#levelFilter').val();
        let search = $('#searchLog').val().toLowerCase();
        
        $('.log-entry').each(function() {
            let show = true;
            let logLevel = $(this).data('level');
            let logContent = $(this).data('content');
            
            if(level !== 'all' && logLevel !== level) show = false;
            if(search && !logContent.includes(search)) show = false;
            
            $(this).toggle(show);
        });
    }
    
    $('#levelFilter, #searchLog').on('change keyup', filterLogs);
    
    $('#resetFilters').click(function() {
        $('#levelFilter').val('all');
        $('#searchLog').val('');
        filterLogs();
    });
</script>
@endpush
@endsection