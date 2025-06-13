@extends('layouts.entreprise')

@section('title', 'Mes offres d\'emploi')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-briefcase me-2" style="color: #1040BB;"></i>
                        Mes offres d'emploi
                    </h1>
                    <p class="text-muted mb-0">Gérez vos offres d'emploi et suivez leurs performances</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.offres.create') }}" class="btn text-white" style="background-color: #1040BB;">
                        <i class="fas fa-plus me-2"></i>
                        Publier une nouvelle offre
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background-color: #1040BB;">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-briefcase fa-2x opacity-75"></i>
                    </div>
                    <h3 class="mb-1">{{ $offres->total() }}</h3>
                    <p class="mb-0">Total offres</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background-color: #071D55;">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-eye fa-2x opacity-75"></i>
                    </div>
                    <h3 class="mb-1">{{ $offres->where('statut', 'publiee')->count() }}</h3>
                    <p class="mb-0">Offres actives</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-info text-white h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                    <h3 class="mb-1">{{ $offres->sum('nb_candidatures') }}</h3>
                    <p class="mb-0">Candidatures reçues</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-warning text-white h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-handshake fa-2x opacity-75"></i>
                    </div>
                    <h3 class="mb-1">{{ $offres->sum('nb_recrutes') }}</h3>
                    <p class="mb-0">Recrutements finalisés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="publiee" {{ request('statut') == 'publiee' ? 'selected' : '' }}>Publiée</option>
                                <option value="expiree" {{ request('statut') == 'expiree' ? 'selected' : '' }}>Expirée</option>
                                <option value="fermee" {{ request('statut') == 'fermee' ? 'selected' : '' }}>Fermée</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Période</label>
                            <select name="periode" class="form-select">
                                <option value="">Toutes les périodes</option>
                                <option value="7j" {{ request('periode') == '7j' ? 'selected' : '' }}>7 derniers jours</option>
                                <option value="30j" {{ request('periode') == '30j' ? 'selected' : '' }}>30 derniers jours</option>
                                <option value="3m" {{ request('periode') == '3m' ? 'selected' : '' }}>3 derniers mois</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-control" placeholder="Titre, référence..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i> Filtrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des offres -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Liste des offres ({{ $offres->total() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($offres->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Offre</th>
                                        <th>Statut</th>
                                        <th>Date publication</th>
                                        <th>Candidatures</th>
                                        <th>Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offres as $offre)
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $offre->titre }}</h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-hashtag me-1"></i>{{ $offre->reference_offre ?? 'Brouillon' }}
                                                        <span class="mx-2">•</span>
                                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu_poste }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-building me-1"></i>{{ $offre->pole->nom ?? '' }}
                                                        @if($offre->familleMetier)
                                                            - {{ $offre->familleMetier->nom }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($offre->statut)
                                                    @case('brouillon')
                                                        <span class="badge bg-secondary">Brouillon</span>
                                                        @break
                                                    @case('publiee')
                                                        <span class="badge bg-success">Publiée</span>
                                                        @break
                                                    @case('expiree')
                                                        <span class="badge bg-warning">Expirée</span>
                                                        @break
                                                    @case('fermee')
                                                        <span class="badge bg-danger">Fermée</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($offre->date_publication)
                                                    {{ $offre->date_publication->format('d/m/Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $offre->date_publication->diffForHumans() }}</small>
                                                @else
                                                    <span class="text-muted">Non publiée</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <h6 class="mb-0">{{ $offre->nb_candidatures }}</h6>
                                                        <small class="text-muted">Total</small>
                                                    </div>
                                                    @if($offre->nb_candidatures_nouvelles > 0)
                                                        <span class="badge bg-primary rounded-pill">{{ $offre->nb_candidatures_nouvelles }} nouvelles</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row g-1 text-center">
                                                    <div class="col-3">
                                                        <small class="d-block text-muted">Vues</small>
                                                        <strong>{{ $offre->nb_vues ?? 0 }}</strong>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="d-block text-muted">Présél.</small>
                                                        <strong>{{ $offre->nb_preselections }}</strong>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="d-block text-muted">Entret.</small>
                                                        <strong>{{ $offre->nb_entretiens }}</strong>
                                                    </div>
                                                    <div class="col-3">
                                                        <small class="d-block text-muted">Recrut.</small>
                                                        <strong class="text-success">{{ $offre->nb_recrutes }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if($offre->statut === 'brouillon')
                                                        <a href="{{ route('entreprise.offres.edit', $offre) }}" class="btn btn-outline-primary" title="Continuer l'édition">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('entreprise.candidatures.kanban', ['offre' => $offre->id]) }}" class="btn btn-outline-primary" title="Voir candidatures">
                                                            <i class="fas fa-users"></i>
                                                        </a>
                                                    @endif
                                                    <button class="btn btn-outline-secondary" title="Statistiques détaillées">
                                                        <i class="fas fa-chart-bar"></i>
                                                    </button>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" title="Plus d'actions">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Voir l'offre</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Dupliquer</a></li>
                                                            @if($offre->statut === 'publiee')
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-warning" href="#"><i class="fas fa-pause me-2"></i>Suspendre</a></li>
                                                            @endif
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Aucune offre d'emploi</h5>
                            <p class="text-muted mb-4">Vous n'avez pas encore publié d'offre d'emploi.</p>
                            <a href="{{ route('entreprise.offres.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Publier votre première offre
                            </a>
                        </div>
                    @endif
                </div>
                
                @if($offres->hasPages())
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Affichage de {{ $offres->firstItem() }} à {{ $offres->lastItem() }} sur {{ $offres->total() }} offres
                            </div>
                            <div>
                                {{ $offres->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #152747 0%, #1e3a5f 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f6cd45 0%, #ffc107 100%);
    color: #152747 !important;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}

.table tbody tr:hover {
    background-color: rgba(246, 205, 69, 0.05);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
// Auto-refresh des statistiques toutes les 30 secondes
setInterval(function() {
    // Logique de rafraîchissement des données en temps réel
}, 30000);

// Confirmation avant suppression
document.addEventListener('click', function(e) {
    if (e.target.closest('.text-danger')) {
        e.preventDefault();
        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.')) {
            // Logique de suppression
        }
    }
});
</script>
@endpush