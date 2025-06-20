@extends('layouts.entreprise')

@section('title', 'Dashboard Entreprise')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête avec informations entreprise -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 40px;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            @if($entreprise->logo)
                                <img src="{{ $entreprise->logo }}" alt="Logo" class="img-fluid rounded-circle" style="max-height: 80px;">
                            @else
                                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-1">{{ $entreprise->nom_entreprise }}</h3>
                            <p class="mb-1"><i class="fas fa-id-card me-2"></i>RCCM: {{ $entreprise->rccm }}</p>
                            <p class="mb-0"><i class="fas fa-users me-2"></i>Effectif: {{ $entreprise->effectif }} employés</p>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="company-status">
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background-color: #DEEDFC;">
                <div class="card-header" style="background-color: #DEEDFC;">
                    <h6 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Actions rapides</h6>
                </div>
                <div class="card-body" style="background-color: #DEEDFC;">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.offres.create') }}" class="btn bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-plus fa-2x mb-2"></i>
                                <span>Publier une offre</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.talent-search') }}" class="btn bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <span>Rechercher talents</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.candidatures.kanban') }}" class="btn bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-tasks fa-2x mb-2"></i>
                                <span>Suivi candidatures</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.parrainage.index') }}" class="btn bg-white w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-handshake fa-2x mb-2"></i>
                                <span>Parrainage</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres temporels -->
    <div class="row mb-4 mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0 me-3"><i class="fas fa-calendar-alt text-primary me-2"></i>Période d'analyse :</h6>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="periode" id="periode-7j" value="7j" checked>
                            <label class="btn btn-outline-primary" for="periode-7j">7 jours</label>

                            <input type="radio" class="btn-check" name="periode" id="periode-30j" value="30j">
                            <label class="btn btn-outline-primary" for="periode-30j">30 jours</label>

                            <input type="radio" class="btn-check" name="periode" id="periode-3m" value="3m">
                            <label class="btn btn-outline-primary" for="periode-3m">3 mois</label>

                            <input type="radio" class="btn-check" name="periode" id="periode-6m" value="6m">
                            <label class="btn btn-outline-primary" for="periode-6m">6 mois</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs principaux -->
    <div class="row mb-4" id="kpis-container">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 20px;">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-offres-publiees">{{ $kpis['offres_publiees'] ?? 0 }}</h3>
                    <p class="mb-1">Offres publiées</p>
                    <small class="opacity-75" id="kpi-offres-actives">({{ $kpis['offres_actives'] ?? 0 }} actives)</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 20px;">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-vues-offres">{{ number_format($kpis['vues_offres'] ?? 0) }}</h3>
                    <p class="mb-1">Vues sur offres</p>
                    <small class="opacity-75" id="kpi-taux-vue">{{ $kpis['taux_vue_moyen'] ?? 0 }}% en moyenne</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 20px;">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-candidatures">{{ $kpis['candidatures_recues'] ?? 0 }}</h3>
                    <p class="mb-1">Candidatures reçues</p>
                    <small class="opacity-75" id="kpi-entretiens">{{ $kpis['entretiens_programmes'] ?? 0 }} entretiens</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 text-white h-100" style="background: url('/images/bgcardmonitoring.png') no-repeat center center / cover;padding: 20px;">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-recrutements">{{ $kpis['recrutements_finalises'] ?? 0 }}</h3>
                    <p class="mb-1">Recrutements finalisés</p>
                    <small class="opacity-75" id="kpi-taux-conversion">{{ $kpis['taux_conversion'] ?? 0 }}% de conversion</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Graphique d'évolution -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-chart-area text-primary me-2"></i>Évolution des activités</h6>
                </div>
                <div class="card-body" style="position: relative; height: 400px;">
                    <canvas id="evolutionChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Répartition des candidatures -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Répartition candidatures</h6>
                </div>
                <div class="card-body" style="position: relative; height: 400px;">
                    <canvas id="repartitionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau performance par offre -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="fas fa-table text-info me-2"></i>Performance par offre</h6>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-success" onclick="exportTablePDF()">
                                <i class="fas fa-file-pdf me-1"></i>PDF
                            </button>
                            <button type="button" class="btn btn-outline-primary" onclick="exportTableExcel()">
                                <i class="fas fa-file-excel me-1"></i>Excel
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="performance-datatable">
                            <thead style="background-color: #14224A; color: white;">
                                <tr>
                                    <th>Offre</th>
                                    <th>Date publication</th>
                                    <th>Vues</th>
                                    <th>Candidatures</th>
                                    <th>Entretiens</th>
                                    <th>Recrutements</th>
                                    <th>Taux conversion</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="performance-tbody" style="background-color: white;">
                                @if(isset($offres_performance) && $offres_performance->count() > 0)
                                    @foreach($offres_performance as $offre)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $offre->titre }}</strong>
                                                    <br><small class="text-muted">{{ $offre->reference_offre }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $offre->date_publication ? $offre->date_publication->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ number_format($offre->nb_vues ?? 0) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $offre->nb_candidatures ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $offre->nb_entretiens ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $offre->nb_recrutes ?? 0 }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $taux = ($offre->nb_candidatures ?? 0) > 0 ? round((($offre->nb_recrutes ?? 0) / $offre->nb_candidatures) * 100, 1) : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-{{ $taux >= 20 ? 'success' : ($taux >= 10 ? 'warning' : 'danger') }}" 
                                                         style="width: {{ min($taux, 100) }}%">
                                                        {{ $taux }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $offre->statut === 'publiee' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($offre->statut) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('entreprise.candidatures.kanban', ['offre' => $offre->id]) }}" 
                                                       class="btn btn-outline-primary" title="Voir candidatures">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                    <a href="{{ route('entreprise.offres.edit', $offre->id) }}" 
                                                       class="btn btn-outline-secondary" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Aucune donnée pour cette période</h5>
                                            <p class="text-muted">Publiez des offres pour voir les statistiques apparaître ici.</p>
                                            <a href="{{ route('entreprise.offres.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Publier une offre
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545, #e83e8c);
}

.kpi-icon {
    opacity: 0.8;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 600;
}

.btn-group .btn {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
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
#performance-datatable thead th {
    background-color: #14224A !important;
    color: white !important;
    border-color: #14224A !important;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

/* Lignes du tbody */
#performance-datatable tbody tr {
    background-color: white !important;
}

#performance-datatable tbody tr:hover {
    background-color: rgba(20, 34, 74, 0.05) !important;
}

#performance-datatable tbody td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

@media (max-width: 768px) {
    .kpi-icon {
        font-size: 1.5rem !important;
    }
    
    .card-body h3 {
        font-size: 1.5rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin-bottom: 0.25rem;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        text-align: center;
        margin-bottom: 1rem;
    }
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

/* Assurer que les canvas ont une taille définie */
#evolutionChart, #repartitionChart {
    max-height: 350px !important;
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Variables globales pour stocker les données des graphiques
let chartData = {
    evolution_labels: {!! json_encode($evolution_labels ?? []) !!},
    evolution_offres: {!! json_encode($evolution_offres ?? []) !!},
    evolution_candidatures: {!! json_encode($evolution_candidatures ?? []) !!},
    evolution_recrutements: {!! json_encode($evolution_recrutements ?? []) !!},
    repartition_candidatures: {
        recues: {{ $repartition_candidatures['recues'] ?? 0 }},
        preselctionnees: {{ $repartition_candidatures['preselctionnees'] ?? 0 }},
        entretien: {{ $repartition_candidatures['entretien'] ?? 0 }},
        retenues: {{ $repartition_candidatures['retenues'] ?? 0 }}
    }
};

// Initialisation DataTables
let performanceDataTable;

function initDataTable() {
    if (performanceDataTable) {
        performanceDataTable.destroy();
    }
    
    performanceDataTable = $('#performance-datatable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tout"]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        columnDefs: [
            { targets: [2, 3, 4, 5, 6], className: 'text-center' },
            { targets: [8], orderable: false, searchable: false }
        ],
        order: [[1, 'desc']],
        drawCallback: function() {
            attachEventHandlers();
        }
    });
}

function attachEventHandlers() {
    // Réattacher les gestionnaires d'événements après chaque redraw
    $('.btn-delete').off('click').on('click', function(e) {
        e.preventDefault();
        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')) {
            window.location.href = $(this).attr('href');
        }
    });
}

$(document).ready(function() {
    // Attendre que le DOM soit complètement chargé
    setTimeout(function() {
        initCharts();
    }, 100);
    
    // Gestionnaire de changement de période
    $('input[name="periode"]').on('change', function() {
        const periode = $(this).val();
        updateDashboard(periode);
    });
    
    // Initialiser DataTables
    initDataTable();
});

function initCharts() {
    console.log('Initialisation des graphiques...');
    console.log('Données des graphiques:', chartData);
    
    // Vérifier que les éléments canvas existent
    const evolutionCanvas = document.getElementById('evolutionChart');
    const repartitionCanvas = document.getElementById('repartitionChart');
    
    if (!evolutionCanvas || !repartitionCanvas) {
        console.error('Canvas non trouvés');
        return;
    }
    
    // Détruire les graphiques existants s'ils existent
    if (window.evolutionChart) {
        window.evolutionChart.destroy();
    }
    if (window.repartitionChart) {
        window.repartitionChart.destroy();
    }
    
    try {
        // Graphique d'évolution
        const evolutionCtx = evolutionCanvas.getContext('2d');
        window.evolutionChart = new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: chartData.evolution_labels,
                datasets: [
                    {
                        label: 'Offres publiées',
                        data: chartData.evolution_offres,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Candidatures',
                        data: chartData.evolution_candidatures,
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Recrutements',
                        data: chartData.evolution_recrutements,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        console.log('Graphique évolution créé');
        
        // Graphique de répartition
        const repartitionCtx = repartitionCanvas.getContext('2d');
        window.repartitionChart = new Chart(repartitionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Reçues', 'Présélectionnées', 'En entretien', 'Retenues'],
                datasets: [{
                    data: [
                        chartData.repartition_candidatures.recues,
                        chartData.repartition_candidatures.preselctionnees,
                        chartData.repartition_candidatures.entretien,
                        chartData.repartition_candidatures.retenues
                    ],
                    backgroundColor: [
                        '#17a2b8',
                        '#ffc107', 
                        '#fd7e14',
                        '#28a745'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        console.log('Graphique répartition créé');
        
    } catch (error) {
        console.error('Erreur lors de la création des graphiques:', error);
    }
}

function updateDashboard(periode) {
    // Supprimer les anciens loaders s'ils existent
    $('.loading-overlay').remove();
    
    // Afficher un indicateur de chargement
    const loadingHtml = '<div class="loading-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 1000;"><div class="spinner-border text-primary"></div><span class="ms-2">Chargement...</span></div>';
    $('#kpis-container').css('position', 'relative').append(loadingHtml);
    
    $.get('{{ route("entreprise.dashboard.data") }}', { periode: periode })
        .done(function(data) {
            // Mettre à jour les KPIs
            $('#kpi-offres-publiees').text(data.kpis.offres_publiees);
            $('#kpi-offres-actives').text('(' + data.kpis.offres_actives + ' actives)');
            $('#kpi-vues-offres').text(data.kpis.vues_offres.toLocaleString());
            $('#kpi-taux-vue').text(data.kpis.taux_vue_moyen + '% en moyenne');
            $('#kpi-candidatures').text(data.kpis.candidatures_recues);
            $('#kpi-entretiens').text(data.kpis.entretiens_programmes + ' entretiens');
            $('#kpi-recrutements').text(data.kpis.recrutements_finalises);
            $('#kpi-taux-conversion').text(data.kpis.taux_conversion + '% de conversion');
            
            // Mettre à jour les données des graphiques
            chartData = {
                evolution_labels: data.evolution_labels,
                evolution_offres: data.evolution_offres,
                evolution_candidatures: data.evolution_candidatures,
                evolution_recrutements: data.evolution_recrutements,
                repartition_candidatures: data.repartition_candidatures
            };
            
            // Mettre à jour les graphiques
            if (window.evolutionChart) {
                window.evolutionChart.data.labels = data.evolution_labels;
                window.evolutionChart.data.datasets[0].data = data.evolution_offres;
                window.evolutionChart.data.datasets[1].data = data.evolution_candidatures;
                window.evolutionChart.data.datasets[2].data = data.evolution_recrutements;
                window.evolutionChart.update();
            }
            
            if (window.repartitionChart) {
                window.repartitionChart.data.datasets[0].data = [
                    data.repartition_candidatures.recues,
                    data.repartition_candidatures.preselctionnees,
                    data.repartition_candidatures.entretien,
                    data.repartition_candidatures.retenues
                ];
                window.repartitionChart.update();
            }
            
            // Mettre à jour le tableau
            updatePerformanceTable(data.offres_performance);
        })
        .fail(function(xhr, status, error) {
            console.error('Erreur AJAX:', xhr.responseText || error);
            let errorMessage = 'Erreur lors du chargement des données';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Service temporairement indisponible';
            } else if (xhr.status === 500) {
                errorMessage = 'Erreur serveur. Veuillez réessayer plus tard.';
            }
            
            showToast(errorMessage, 'error');
        })
        .always(function() {
            // Supprimer tous les loaders
            $('.loading-overlay').remove();
        });
}

function updatePerformanceTable(offres) {
    // Détruire le DataTable existant
    if (performanceDataTable) {
        performanceDataTable.destroy();
    }
    
    const tbody = $('#performance-tbody');
    tbody.empty();
    
    if (!offres || offres.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="9" class="text-center py-5">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune donnée pour cette période</h5>
                </td>
            </tr>
        `);
        // Réinitialiser DataTables même avec des données vides
        initDataTable();
        return;
    }
    
    offres.forEach(function(offre) {
        const taux = offre.nb_candidatures > 0 ? Math.round((offre.nb_recrutes / offre.nb_candidatures) * 100 * 10) / 10 : 0;
        const tauxClass = taux >= 20 ? 'success' : (taux >= 10 ? 'warning' : 'danger');
        
        tbody.append(`
            <tr>
                <td>
                    <div>
                        <strong>${offre.titre}</strong>
                        <br><small class="text-muted">${offre.reference_offre}</small>
                    </div>
                </td>
                <td>${offre.date_publication || '-'}</td>
                <td><span class="badge bg-info">${offre.nb_vues.toLocaleString()}</span></td>
                <td><span class="badge bg-warning">${offre.nb_candidatures}</span></td>
                <td><span class="badge bg-primary">${offre.nb_entretiens}</span></td>
                <td><span class="badge bg-success">${offre.nb_recrutes}</span></td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-${tauxClass}" style="width: ${Math.min(taux, 100)}%">
                            ${taux}%
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${offre.statut === 'publiee' ? 'success' : 'secondary'}">
                        ${offre.statut.charAt(0).toUpperCase() + offre.statut.slice(1)}
                    </span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="/entreprise/candidatures/kanban?offre=${offre.id}" class="btn btn-outline-primary" title="Voir candidatures">
                            <i class="fas fa-users"></i>
                        </a>
                        <a href="/entreprise/offres/${offre.id}/edit" class="btn btn-outline-secondary" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `);
    });
    
    // Réinitialiser DataTables après avoir ajouté les nouvelles données
    initDataTable();
}

function exportTablePDF() {
    const periode = $('input[name="periode"]:checked').val();
    
    // Afficher un indicateur de chargement
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Export PDF...';
    btn.disabled = true;
    
    // Créer un lien temporaire pour télécharger
    const link = document.createElement('a');
    link.href = '{{ route("entreprise.dashboard.export") }}?format=pdf&periode=' + periode;
    link.target = '_blank';
    
    // Simuler le clic et gérer les erreurs
    try {
        link.click();
        setTimeout(() => {
            showToast('Export PDF en cours...', 'info');
        }, 100);
    } catch (error) {
        console.error('Erreur export PDF:', error);
        showToast('Erreur lors de l\'export PDF', 'error');
    } finally {
        // Restaurer le bouton après un délai
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    }
}

function exportTableExcel() {
    const periode = $('input[name="periode"]:checked').val();
    
    // Afficher un indicateur de chargement
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Export Excel...';
    btn.disabled = true;
    
    // Créer un lien temporaire pour télécharger
    const link = document.createElement('a');
    link.href = '{{ route("entreprise.dashboard.export") }}?format=excel&periode=' + periode;
    link.download = 'dashboard_' + periode + '_' + new Date().toISOString().split('T')[0] + '.csv';
    
    // Simuler le clic et gérer les erreurs
    try {
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        setTimeout(() => {
            showToast('Export Excel terminé', 'success');
        }, 500);
    } catch (error) {
        console.error('Erreur export Excel:', error);
        showToast('Erreur lors de l\'export Excel', 'error');
    } finally {
        // Restaurer le bouton après un délai
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    }
}

function showToast(message, type) {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    let toastContainer = $('.toast-container');
    if (toastContainer.length === 0) {
        $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        toastContainer = $('.toast-container');
    }
    
    const toast = $(toastHtml);
    toastContainer.append(toast);
    
    const bsToast = new bootstrap.Toast(toast[0]);
    bsToast.show();
    
    toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}

// Debug : vérifier si Chart.js est chargé
if (typeof Chart === 'undefined') {
    console.error('Chart.js n\'est pas chargé !');
} else {
    console.log('Chart.js version:', Chart.version);
}
</script>
@endpush