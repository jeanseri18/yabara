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
                        <div class="emoji-wrapper" style="font-size: 48px; height: 48px; line-height: 48px; text-align: center; color: #0066FF;">
                            📋
                        </div>
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
                        <div class="emoji-wrapper" style="font-size: 48px; height: 48px; line-height: 48px; text-align: center; color: #28a745;">
                            ✅
                        </div>
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
                        <div class="emoji-wrapper" style="font-size: 48px; height: 48px; line-height: 48px; text-align: center; color: #17a2b8;">
                            👥
                        </div>
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
                        <div class="emoji-wrapper" style="font-size: 48px; height: 48px; line-height: 48px; text-align: center; color: #ffc107;">
                            🤝
                        </div>
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
                    <form method="GET" class="row g-3">
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
                    <h6 class="fw-bold text-dark mb-0">Liste des offres ({{ $offres->total() }})</h6>
                </div>
                <div class="card-body" style="padding:20px;">
                    @if($offres->count() > 0)
                        <div class="row g-4">
                            @foreach($offres as $offre)
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-radius: 12px; height: 150px;"
                                         onclick="window.location.href='{{ route('entreprise.candidatures.kanban', ['offre' => $offre->id]) }}'"
                                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                                        
                                        <!-- Corps de la carte -->
                                        <div class="card-body d-flex justify-content-between align-items-center" style="padding: 20px;">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-2 fw-bold text-dark">{{ $offre->titre }}</h5>
                                                <div class="mb-2">
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
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $offre->lieu_poste }}
                                                </small>
                                            </div>
                                            
                                            <div class="text-end">
                                                <div class="mb-2">
                                                    <small class="text-muted">Candidatures</small>
                                                    <div class="h5 mb-0">{{ $offre->nb_candidatures }}</div>
                                                    @if($offre->nb_candidatures_nouvelles > 0)
                                                        <span class="badge bg-primary rounded-pill">{{ $offre->nb_candidatures_nouvelles }} nouvelles</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                             @endforeach
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
body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
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

/* Styles DataTables personnalisés */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 1rem;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 0.375rem 0.75rem;
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

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
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

/* En-têtes personnalisés */
#offres-datatable thead th {
    background-color: #0066FF !important;
    color: white !important;
    border-color: #0066FF !important;
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
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6">>' +
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