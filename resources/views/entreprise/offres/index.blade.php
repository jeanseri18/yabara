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
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 40px;">
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
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 40px;">
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
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 40px;">
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
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 40px;">
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
                                <option value="suspendue" {{ request('statut') == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
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
                        <!-- <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-1"></i> Filtrer
                                </button>
                            </div>
                        </div> -->
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
                <div class="card-body" style="padding:20px;">
                    @if($offres->count() > 0)
                        <!-- <div class="table-responsive"> -->
                            <table class="table table-hover mb-0" id="offres-datatable">
                                <thead style="background-color: #14224A; color: white;">
                                    <tr  style="background-color: #14224A; color: white;">
                                        <th>Offre</th>
                                        <th>Statut</th>
                                        <th>Date publication</th>
                                        <th>Candidatures</th>
                                        <th>Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: white;">
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
                                                    <a href="{{ route('entreprise.offres.statistiques', $offre->id) }}" class="btn btn-outline-secondary" title="Statistiques détaillées">
                                                        <i class="fas fa-chart-bar"></i>
                                                    </a>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" title="Plus d'actions">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="{{ route('entreprise.offres.show', $offre) }}"><i class="fas fa-eye me-2"></i>Voir l'offre</a></li>
                                                            <!-- <li>
                                                                <form action="{{ route('entreprise.offres.duplicate', $offre->id) }}" method="POST" >
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-copy me-2"></i>Dupliquer
                                                                    </button>
                                                                </form>
                                                            </li> -->
                                                            @if($offre->statut === 'publiee')
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a class="dropdown-item text-warning" href="#" onclick="toggleOffreStatus({{ $offre->id }}, 'suspend')"><i class="fas fa-pause me-2"></i>Suspendre</a></li>
                                                            @endif
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteOffre({{ $offre->id }})"><i class="fas fa-trash me-2"></i>Supprimer</a></li>
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
                
                <!-- DataTables gérera la pagination automatiquement -->
                <!-- <div class="card-footer bg-white border-top">
                    <div class="text-center text-muted small">
                        Pagination gérée par DataTables
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

/* Styles DataTables personnalisés */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 1rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.375rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 0.375rem;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #14224A !important;
    border-color: #14224A !important;
    color: white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #1040BB !important;
    border-color: #1040BB !important;
    color: white !important;
}

/* En-têtes personnalisés */
#offres-datatable thead th {
    background-color: #14224A !important;
    color: white !important;
    border-color: #14224A !important;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

/* Lignes du tbody */
#offres-datatable tbody tr {
    background-color: white !important;
}

#offres-datatable tbody tr:hover {
    background-color: rgba(20, 34, 74, 0.05) !important;
}

#offres-datatable tbody td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.table-fixed {
    table-layout: fixed;
    width: 100%;
}

.table-fixed th,
.table-fixed td {
    word-wrap: break-word;
    overflow-wrap: break-word;
    vertical-align: middle;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Responsive */
@media (max-width: 768px) {
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
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
let dataTable;

$(document).ready(function() {
    // Initialisation de DataTables
    dataTable = $('#offres-datatable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        columnDefs: [
            {
                targets: [5], // Colonne Actions
                orderable: false,
                searchable: false
            },
            {
                targets: [1], // Colonne Statut
                orderable: true,
                searchable: true
            }
        ],
        order: [[2, 'desc']], // Trier par date de publication par défaut
        drawCallback: function() {
            // Réappliquer les événements après chaque redraw
            attachEventHandlers();
        }
    });
    
    // Attacher les gestionnaires d'événements initiaux
    attachEventHandlers();
    
    // Gestion des filtres personnalisés
    initCustomFilters();
});

// Fonction pour initialiser les filtres personnalisés
function initCustomFilters() {
    // Filtrage par statut
    $('select[name="statut"]').on('change', function() {
        const statut = $(this).val();
        if (statut === '') {
            dataTable.column(1).search('').draw();
        } else {
            dataTable.column(1).search(statut).draw();
        }
    });
    
    // Recherche personnalisée
    $('input[name="search"]').on('keyup', function() {
        dataTable.search($(this).val()).draw();
    });
    
    // Bouton de filtrage
    $('button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        
        const statut = $('select[name="statut"]').val();
        const search = $('input[name="search"]').val();
        
        // Appliquer les filtres
        if (statut === '') {
            dataTable.column(1).search('').draw();
        } else {
            dataTable.column(1).search(statut).draw();
        }
        
        dataTable.search(search).draw();
    });
}

// Fonction pour attacher les gestionnaires d'événements
function attachEventHandlers() {
    // Gestion des dropdowns Bootstrap
    $('.dropdown-toggle').dropdown();
    
    // Gestion des boutons statistiques
    // $('.btn-outline-secondary[title="Statistiques détaillées"]').off('click').on('click', function(e) {
    //     e.preventDefault();
    //     // Logique pour afficher les statistiques détaillées
    //     showToast('Fonctionnalité en développement', 'info');
    // });
}

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

// Auto-refresh des statistiques toutes les 30 secondes
setInterval(function() {
    // Logique de rafraîchissement des données en temps réel
    // Vous pouvez recharger les données via AJAX ici
}, 30000);
</script>
@endpush