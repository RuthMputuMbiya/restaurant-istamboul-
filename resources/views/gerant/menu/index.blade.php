{{-- resources/views/gerant/menu/index.blade.php --}}
@extends('layouts.gerant')

@section('title', 'Gestion du menu')
@section('page-title', 'Gestion du menu')
@section('page-subtitle', 'Gérez tous les plats du restaurant')

@section('gerant-content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 fw-bold text-dark">
                        <i class="fas fa-utensils text-success me-3"></i>Gestion du menu
                    </h1>
                    <p class="text-muted">Gérez tous les plats du restaurant</p>
                </div>
                <a href="{{ route('gerant.menu.create') }}" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Nouveau plat
                </a>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <select id="categorieFiltre" class="form-select rounded-pill">
                        <option value="all">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" id="searchPlat" class="form-control rounded-pill" placeholder="🔍 Rechercher un plat...">
                </div>
                <div class="col-md-3">
                    <select id="disponibleFiltre" class="form-select rounded-pill">
                        <option value="all">Tous les statuts</option>
                        <option value="1">Disponible</option>
                        <option value="0">Indisponible</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button id="resetFiltres" class="btn btn-outline-secondary rounded-pill w-100">
                        <i class="fas fa-undo-alt me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des plats par catégorie -->
    @foreach($categories as $categorie)
    <div class="card border-0 shadow-lg rounded-4 mb-4" data-categorie-id="{{ $categorie->id }}">
        <div class="card-header bg-success text-white rounded-top-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tag me-2"></i>{{ $categorie->nom }}
                    <span class="badge bg-light text-dark ms-2">{{ $categorie->menus->count() }} plats</span>
                </h5>
                <a href="{{ route('gerant.menu.create') }}?categorie={{ $categorie->id }}" class="btn btn-sm btn-light rounded-pill">
                    <i class="fas fa-plus me-1"></i>Ajouter
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px">Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix (FC)</th>
                            <th>Temps</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorie->menus as $plat)
                        <tr data-nom="{{ strtolower($plat->nom) }}" data-disponible="{{ $plat->est_disponible ? '1' : '0' }}">
                            <td>
                                @if($plat->image && Storage::disk('public')->exists($plat->image))
                                    <img src="{{ asset('storage/' . $plat->image) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-utensils text-white fa-sm"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $plat->nom }}</td>
                            <td>{{ Str::limit($plat->description, 50) }}</td>
                            <td>
                                <span class="text-primary fw-bold">{{ number_format($plat->prix, 0, ',', ' ') }} FC</span>
                            </td>
                           
                            <td><i class="fas fa-clock me-1 text-muted"></i>{{ $plat->temps_preparation }} min</span></span></span></span></span></span></span></span></span></span></span></span>
                            <td>
                                @if($plat->est_disponible)
                                    <span class="badge bg-success rounded-pill">Disponible</span>
                                @else
                                    <span class="badge bg-danger rounded-pill">Indisponible</span>
                                @endif
                             </span></span></span></span></span></span></span></span></span></span></span></span>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('gerant.menu.edit', $plat) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('gerant.menu.toggle', $plat) }}" method="POST" class="d-inline me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill" title="{{ $plat->est_disponible ? 'Rendre indisponible' : 'Rendre disponible' }}">
                                            <i class="fas {{ $plat->est_disponible ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('gerant.menu.destroy', $plat) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce plat ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                             </span></span></span></span></span></span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-info-circle fa-2x text-muted mb-2 d-block"></i>
                                <span class="text-muted">Aucun plat dans cette catégorie</span>
                                <br>
                                <a href="{{ route('gerant.menu.create') }}?categorie={{ $categorie->id }}" class="btn btn-sm btn-primary rounded-pill mt-2">
                                    <i class="fas fa-plus me-1"></i>Ajouter un plat
                                </a>
                             </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
    function filtrerPlats() {
        let categorie = $('#categorieFiltre').val();
        let search = $('#searchPlat').val().toLowerCase();
        let disponible = $('#disponibleFiltre').val();

        if(categorie === 'all') {
            $('.card.mb-4').show();
        } else {
            $('.card.mb-4').hide();
            $(`.card.mb-4[data-categorie-id="${categorie}"]`).show();
        }

        $('.table tbody tr').each(function() {
            let show = true;
            let nom = $(this).data('nom');
            let statut = $(this).data('disponible');
            
            if(search && nom && !nom.includes(search)) show = false;
            if(disponible !== 'all' && statut && statut !== disponible) show = false;
            
            $(this).toggle(show);
        });
    }

    $('#categorieFiltre, #searchPlat, #disponibleFiltre').on('change keyup', filtrerPlats);
    
    $('#resetFiltres').click(function() {
        $('#categorieFiltre').val('all');
        $('#searchPlat').val('');
        $('#disponibleFiltre').val('all');
        filtrerPlats();
    });
</script>
@endpush
@endsection