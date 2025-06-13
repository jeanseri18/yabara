@extends('layouts.entreprise')

@section('title', 'Dashboard Entreprise')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête avec informations entreprise -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white">
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

    <!-- Filtres temporels -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-chart-line text-primary me-2"></i>Tableau de bord</h5>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="periode" id="semaine" value="semaine">
                            <label class="btn btn-outline-primary" for="semaine">Cette semaine</label>
                            
                            <input type="radio" class="btn-check" name="periode" id="mois" value="mois" checked>
                            <label class="btn btn-outline-primary" for="mois">Ce mois</label>
                            
                            <input type="radio" class="btn-check" name="periode" id="trimestre" value="trimestre">
                            <label class="btn btn-outline-primary" for="trimestre">Ce trimestre</label>
                            
                            <input type="radio" class="btn-check" name="periode" id="annee" value="annee">
                            <label class="btn btn-outline-primary" for="annee">Cette année</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs principaux -->
    <div class="row mb-4" id="kpis-container">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-info text-white h-100">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-offres-publiees">{{ $kpis['offres_publiees'] }}</h3>
                    <p class="mb-1">Offres publiées</p>
                    <small class="opacity-75" id="kpi-offres-actives">({{ $kpis['offres_actives'] }} actives)</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-success text-white h-100">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-vues-offres">{{ number_format($kpis['vues_offres']) }}</h3>
                    <p class="mb-1">Vues sur offres</p>
                    <small class="opacity-75" id="kpi-taux-vue">{{ $kpis['taux_vue_moyen'] }}% en moyenne</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-warning text-white h-100">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-candidatures">{{ $kpis['candidatures_recues'] }}</h3>
                    <p class="mb-1">Candidatures reçues</p>
                    <small class="opacity-75" id="kpi-entretiens">{{ $kpis['entretiens_programmes'] }} entretiens</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 bg-gradient-danger text-white h-100">
                <div class="card-body text-center">
                    <div class="kpi-icon mb-2">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h3 class="mb-1" id="kpi-recrutements">{{ $kpis['recrutements_finalises'] }}</h3>
                    <p class="mb-1">Recrutements finalisés</p>
                    <small class="opacity-75" id="kpi-taux-conversion">{{ $kpis['taux_conversion'] }}% de conversion</small>
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
                <div class="card-body">
                    <canvas id="evolutionChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Répartition des candidatures -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-chart-pie text-success me-2"></i>Répartition candidatures</h6>
                </div>
                <div class="card-body">
                    <canvas id="repartitionChart" height="300"></canvas>
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
                        <table class="table table-hover" id="performance-table">
                            <thead class="table-light">
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
                            <tbody id="performance-tbody">
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
                                            <span class="badge bg-info">{{ number_format($offre->nb_vues) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $offre->nb_candidatures }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $offre->nb_entretiens }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $offre->nb_recrutes }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $taux = $offre->nb_candidatures > 0 ? round(($offre->nb_recrutes / $offre->nb_candidatures) * 100, 1) : 0;
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
                            </tbody>
                        </table>
                    </div>
                    
                    @if($offres_performance->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune donnée pour cette période</h5>
                            <p class="text-muted">Publiez des offres pour voir les statistiques apparaître ici.</p>
                            <a href="{{ route('entreprise.offres.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Publier une offre
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Actions rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.offres.create') }}" class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-plus fa-2x mb-2"></i>
                                <span>Publier une offre</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.talent-search') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <span>Rechercher talents</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.candidatures.kanban') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-tasks fa-2x mb-2"></i>
                                <span>Suivi candidatures</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('entreprise.parrainage.index') }}" class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center" style="min-height: 100px;">
                                <i class="fas fa-handshake fa-2x mb-2"></i>
                                <span>Parrainage</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Initialiser les graphiques
    initCharts();
    
    // Gestionnaire de changement de période
    $('input[name="periode"]').on('change', function() {
        const periode = $(this).val();
        updateDashboard(periode);
    });
});

function initCharts() {
    // Graphique d'évolution
    const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
    window.evolutionChart = new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($evolution_labels) !!},
            datasets: [
                {
                    label: 'Offres publiées',
                    data: {!! json_encode($evolution_offres) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Candidatures',
                    data: {!! json_encode($evolution_candidatures) !!},
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Recrutements',
                    data: {!! json_encode($evolution_recrutements) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
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
                    beginAtZero: true
                }
            }
        }
    });
    
    // Graphique de répartition
    const repartitionCtx = document.getElementById('repartitionChart').getContext('2d');
    window.repartitionChart = new Chart(repartitionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Reçues', 'Présélectionnées', 'En entretien', 'Retenues'],
            datasets: [{
                data: [
                    {{ $repartition_candidatures['recues'] }},
                    {{ $repartition_candidatures['preselctionnees'] }},
                    {{ $repartition_candidatures['entretien'] }},
                    {{ $repartition_candidatures['retenues'] }}
                ],
                backgroundColor: [
                    '#17a2b8',
                    '#ffc107', 
                    '#fd7e14',
                    '#28a745'
                ]
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
}

function updateDashboard(periode) {
    // Afficher un indicateur de chargement
    $('#kpis-container').append('<div class="loading-overlay"><div class="spinner-border text-primary"></div></div>');
    
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
            
            // Mettre à jour les graphiques
            window.evolutionChart.data.labels = data.evolution_labels;
            window.evolutionChart.data.datasets[0].data = data.evolution_offres;
            window.evolutionChart.data.datasets[1].data = data.evolution_candidatures;
            window.evolutionChart.data.datasets[2].data = data.evolution_recrutements;
            window.evolutionChart.update();
            
            window.repartitionChart.data.datasets[0].data = [
                data.repartition_candidatures.recues,
                data.repartition_candidatures.preselctionnees,
                data.repartition_candidatures.entretien,
                data.repartition_candidatures.retenues
            ];
            window.repartitionChart.update();
            
            // Mettre à jour le tableau
            updatePerformanceTable(data.offres_performance);
        })
        .fail(function() {
            showToast('Erreur lors du chargement des données', 'error');
        })
        .always(function() {
            $('.loading-overlay').remove();
        });
}

function updatePerformanceTable(offres) {
    const tbody = $('#performance-tbody');
    tbody.empty();
    
    if (offres.length === 0) {
        tbody.append(`
            <tr>
                <td colspan="9" class="text-center py-5">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune donnée pour cette période</h5>
                </td>
            </tr>
        `);
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
}

function exportTablePDF() {
    const periode = $('input[name="periode"]:checked').val();
    window.open(`{{ route('entreprise.dashboard.export') }}?format=pdf&periode=${periode}`, '_blank');
}

function exportTableExcel() {
    const periode = $('input[name="periode"]:checked').val();
    window.open(`{{ route('entreprise.dashboard.export') }}?format=excel&periode=${periode}`, '_blank');
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
</script>
@endpush