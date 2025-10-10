@extends('layouts.entreprise')

@section('title', 'Mes offres d\'emploi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-3 text-dark fw-bold">
                        <i class="fas fa-briefcase me-2" style="color: #0066FF;"></i>
                        Mes offres d'emploi
                    </h1>
                    <p class="text-muted mb-0">🎯 Parce que recruter, c'est bien plus qu'un CV : c'est une rencontre humaine. Visualisez, sélectionnez, recrutez... simplement</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.offres.create') }}" class="btn text-white" style="background-color: #0066FF; border-radius: 8px; padding: 12px 24px; font-weight: 600;">
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
            <div class="card bg-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="icon-container me-3">
                        <img src="{{ asset('images/dashboard.png') }}" alt="Total offres" style="width: 48px; height: 48px; object-fit: contain;">
                    </div>
                    <div>
                        <div class="fw-bold">Total offres</div>
                        <div class="h5 mb-0 fw-bold text-dark">{{ $offres->total() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="icon-container me-3">
                        <img src="{{ asset('images/vues.png') }}" alt="Offres actives" style="width: 48px; height: 48px; object-fit: contain;">
                    </div>
                    <div>
                        <div class="fw-bold">Offres actives</div>
                        <div class="h5 mb-0 fw-bold text-dark">{{ $offres->where('statut', 'publiee')->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="icon-container me-3">
                        <img src="{{ asset('images/candidatures.png') }}" alt="Candidatures reçues" style="width: 48px; height: 48px; object-fit: contain;">
                    </div>
                    <div>
                        <div class="fw-bold">Candidatures reçues</div>
                        <div class="h5 mb-0 fw-bold text-dark">{{ $offres->sum('nb_candidatures') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-white shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="icon-container me-3">
                        <img src="{{ asset('images/recrutes.png') }}" alt="Recrutements finalisés" style="width: 48px; height: 48px; object-fit: contain;">
                    </div>
                    <div>
                        <div class="fw-bold">Recrutements finalisés</div>
                        <div class="h5 mb-0 fw-bold text-dark">{{ $offres->sum('nb_recrutes') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('entreprise.offres.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Statut</label>
                            <select name="statut" class="form-select" style="border-radius: 8px; border: 1px solid #dee2e6;">
                                <option value="">Tous les statuts</option>
                                <option value="brouillon" {{ request('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                <option value="publiee" {{ request('statut') == 'publiee' ? 'selected' : '' }}>Publiée</option>
                                <option value="suspendue" {{ request('statut') == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
                                <option value="expiree" {{ request('statut') == 'expiree' ? 'selected' : '' }}>Expirée</option>
                                <option value="fermee" {{ request('statut') == 'fermee' ? 'selected' : '' }}>Fermée</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Période</label>
                            <select name="periode" class="form-select" style="border-radius: 8px; border: 1px solid #dee2e6;">
                                <option value="">Toutes les périodes</option>
                                <option value="7j" {{ request('periode') == '7j' ? 'selected' : '' }}>7 derniers jours</option>
                                <option value="30j" {{ request('periode') == '30j' ? 'selected' : '' }}>30 derniers jours</option>
                                <option value="3m" {{ request('periode') == '3m' ? 'selected' : '' }}>3 derniers mois</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Recherche</label>
                            <input type="text" name="search" class="form-control" placeholder="Titre, référence..." value="{{ request('search') }}" style="border-radius: 8px; border: 1px solid #dee2e6;">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i> Filtrer
                                </button>
                                <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i> Réinitialiser
                                </a>
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
                    <h6 class="fw-bold text-dark mb-0">Liste des offres ({{ $offres->total() }})</h6>
                </div>
                <div class="card-body" style="padding:20px;">
                    @if($offres->count() > 0)
                        <div class="row">
                            @foreach($offres as $offre)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 offre-card">
                                        <!-- En-tête de la carte avec statut et date -->
                                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                            <div>
                                                @switch($offre->statut)
                                                    @case('brouillon')
                                                        <span class="badge bg-secondary">Brouillon</span>
                                                        @break
                                                    @case('publiee')
                                                        <span class="badge bg-success">Publiée</span>
                                                        @break
                                                    @case('suspendue')
                                                        <span class="badge bg-warning text-dark">Suspendue</span>
                                                        @break
                                                    @case('expiree')
                                                        <span class="badge bg-warning">Expirée</span>
                                                        @break
                                                    @case('fermee')
                                                        <span class="badge bg-danger">Fermée</span>
                                                        @break
                                                @endswitch
                                            </div>
                                            <small class="text-muted">{{ $offre->created_at->format('d/m/Y') }}</small>
                                        </div>
                                        
                                        <!-- Corps de la carte -->
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-dark mb-2">{{ $offre->titre }}</h5>
                                            <p class="card-text text-muted mb-3">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu_poste }}
                                            </p>
                                            
                                            <!-- Statistiques -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <span class="d-block fw-bold">{{ $offre->nb_candidatures }}</span>
                                                        <small class="text-muted">Candidatures</small>
                                                    </div>
                                                    @if($offre->nb_candidatures_nouvelles > 0)
                                                        <div>
                                                            <span class="d-block fw-bold text-primary">{{ $offre->nb_candidatures_nouvelles }}</span>
                                                            <small class="text-primary">Nouvelles</small>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <small class="text-muted">Expire le:</small>
                                                    <span class="d-block">
                                                        @if($offre->date_expiration)
                                                            {{ \Carbon\Carbon::parse($offre->date_expiration)->format('d/m/Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Pied de carte avec actions -->
                                        <div class="card-footer bg-white border-top-0 pt-0">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('entreprise.candidatures.kanban', ['offre' => $offre->id]) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Voir les candidatures">
                                                    <i class="fas fa-users me-1"></i> Candidatures
                                                </a>
                                                <div>
                                                    <a href="{{ route('entreprise.offres.edit', $offre->id) }}" 
                                                       class="btn btn-sm btn-outline-secondary me-1" 
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @if($offre->statut == 'publiee')
                                                                <li><a class="dropdown-item" href="#" onclick="toggleOffreStatus({{ $offre->id }}, 'suspend')"><i class="fas fa-pause me-2"></i>Suspendre</a></li>
                                                            @elseif($offre->statut == 'suspendue')
                                                                <li><a class="dropdown-item" href="#" onclick="toggleOffreStatus({{ $offre->id }}, 'activate')"><i class="fas fa-play me-2"></i>Activer</a></li>
                                                            @endif
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteOffre({{ $offre->id }})"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $offres->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Aucune offre d'emploi</h5>
                            <p class="text-muted mb-4">Vous n'avez pas encore publié d'offre d'emploi.</p>
                            <a href="{{ route('entreprise.offres.create') }}" class="btn " style="background-color: #0066FF; color:white">
                                <i class="fas fa-plus me-2"></i>
                                Publier votre première offre
                            </a>
                        </div>
                    @endif
                </div>
                

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

<style>
body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.offre-card {
    border: 1px solid rgba(0,0,0,.08);
}

.offre-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1)!important;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
    border-top-left-radius: 10px !important;
    border-top-right-radius: 10px !important;
}

.card-footer {
    background-color: transparent;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
}

.btn-outline-secondary {
    border: 1px solid #dee2e6;
    color: #6c757d;
    background-color: white;
    border-radius: 8px;
    padding: 8px 16px;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

.dropdown-menu {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.dropdown-item {
    padding: 8px 16px;
    border-radius: 4px;
    margin: 2px 8px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.active {
    background-color: #0d6efd;
    color: white;
}

.text-dark {
    color: #212529 !important;
}

.text-muted {
    color: #6c757d !important;
}

.fw-bold {
    font-weight: 700 !important;
}

.fw-semibold {
    font-weight: 600 !important;
}



.page-link {
    border-radius: 8px !important;
    margin: 0 2px;
    border: 1px solid #dee2e6;
}

.page-item.active .page-link {
    background-color: #0066FF;
    border-color: #0066FF;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
}

.btn-outline-primary:hover {
    background-color: #0066FF;
    border-color: #0066FF;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .table-responsive {
        border-radius: 12px;
    }
    
    .btn-group-sm .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table-fixed {
        table-layout: auto;
    }
    
    .table-fixed th,
    .table-fixed td {
        min-width: 120px;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        text-align: center;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')

<script>
$(document).ready(function() {
    // Gestion des toasts
    $('.toast').toast('show');

    // Auto-refresh des statistiques toutes les 30 secondes
    setInterval(function() {
        $.get(window.location.href, function(data) {
            var newStats = $(data).find('.stats-container').html();
            $('.stats-container').html(newStats);
        });
    }, 30000);
});

// Fonction pour supprimer une offre
function deleteOffre(offreId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.')) {
        // Créer un formulaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/entreprise/offres/${offreId}`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Ajouter la méthode DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Soumettre le formulaire
        document.body.appendChild(form);
        form.submit();
    }
}

// Fonction pour changer le statut d'une offre
function toggleOffreStatus(offreId, action) {
    const confirmMessage = action === 'suspend' ? 
        'Êtes-vous sûr de vouloir suspendre cette offre ?' : 
        'Êtes-vous sûr de vouloir activer cette offre ?';
    
    if (confirm(confirmMessage)) {
        // Créer un formulaire pour changer le statut
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/entreprise/offres/${offreId}/toggle-status`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Ajouter l'action
        const actionField = document.createElement('input');
        actionField.type = 'hidden';
        actionField.name = 'action';
        actionField.value = action;
        form.appendChild(actionField);
        
        // Soumettre le formulaire
        document.body.appendChild(form);
        form.submit();
    }
}

// Fonction pour afficher des notifications toast
function showToast(message, type = 'info') {
    // Créer l'élément toast
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(toast);
    
    // Supprimer automatiquement après 5 secondes
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}
</script>
@endpush