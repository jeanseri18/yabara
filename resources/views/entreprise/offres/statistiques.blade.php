@extends('layouts.entreprise')

@section('title', 'Statistiques - ' . $offre->titre)

@section('content')
<div class="container px-4">
    <div class="row">
        <!-- Sidebar -->

        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Statistiques détaillées</h2>
                    <p class="text-muted mb-0">{{ $offre->titre }}</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.offres.show', $offre) }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Retour à l'offre
                    </a>
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Imprimer
                    </button>
                </div>
            </div>

            <!-- Métriques principales -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                            <h3 class="text-primary mb-0">{{ $statistiques['vues'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Vues de l'offre</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x text-info mb-2"></i>
                            <h3 class="text-info mb-0">{{ $statistiques['candidatures_total'] }}</h3>
                            <p class="text-muted mb-0">Candidatures reçues</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-percentage fa-2x text-warning mb-2"></i>
                            <h3 class="text-warning mb-0">{{ $statistiques['taux_conversion'] }}%</h3>
                            <p class="text-muted mb-0">Taux de conversion</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                            <h3 class="text-success mb-0">{{ $statistiques['candidatures_retenues'] }}</h3>
                            <p class="text-muted mb-0">Candidats retenus</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Graphique des candidatures par statut -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Répartition par statut</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statutChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Évolution des candidatures -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Évolution des candidatures</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="evolutionChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Statistiques détaillées -->
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Détails par statut</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Statut</th>
                                            <th>Nombre</th>
                                            <th>Pourcentage</th>
                                            <th>Évolution</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">Candidatures reçues</span>
                                            </td>
                                            <td>{{ $statistiques['par_statut']['candidature_recue'] ?? 0 }}</td>
                                            <td>{{ $statistiques['candidatures_total'] > 0 ? round(($statistiques['par_statut']['candidature_recue'] ?? 0) / $statistiques['candidatures_total'] * 100, 1) : 0 }}%</td>
                                            <td>
                                                <span class="text-muted">-</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-warning">Présélectionnées</span>
                                            </td>
                                            <td>{{ $statistiques['par_statut']['preselctionnee'] ?? 0 }}</td>
                                            <td>{{ $statistiques['candidatures_total'] > 0 ? round(($statistiques['par_statut']['preselctionnee'] ?? 0) / $statistiques['candidatures_total'] * 100, 1) : 0 }}%</td>
                                            <td>
                                                @if(($statistiques['par_statut']['candidature_recue'] ?? 0) > 0)
                                                    <span class="text-info">{{ round(($statistiques['par_statut']['preselctionnee'] ?? 0) / ($statistiques['par_statut']['candidature_recue'] ?? 1) * 100, 1) }}% des reçues</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-info">Entretiens</span>
                                            </td>
                                            <td>{{ $statistiques['par_statut']['entretien'] ?? 0 }}</td>
                                            <td>{{ $statistiques['candidatures_total'] > 0 ? round(($statistiques['par_statut']['entretien'] ?? 0) / $statistiques['candidatures_total'] * 100, 1) : 0 }}%</td>
                                            <td>
                                                @if(($statistiques['par_statut']['preselctionnee'] ?? 0) > 0)
                                                    <span class="text-info">{{ round(($statistiques['par_statut']['entretien'] ?? 0) / ($statistiques['par_statut']['preselctionnee'] ?? 1) * 100, 1) }}% des présélectionnées</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-success">Retenues</span>
                                            </td>
                                            <td>{{ $statistiques['par_statut']['retenue'] ?? 0 }}</td>
                                            <td>{{ $statistiques['candidatures_total'] > 0 ? round(($statistiques['par_statut']['retenue'] ?? 0) / $statistiques['candidatures_total'] * 100, 1) : 0 }}%</td>
                                            <td>
                                                @if(($statistiques['par_statut']['entretien'] ?? 0) > 0)
                                                    <span class="text-success">{{ round(($statistiques['par_statut']['retenue'] ?? 0) / ($statistiques['par_statut']['entretien'] ?? 1) * 100, 1) }}% des entretiens</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="badge bg-danger">Non retenues</span>
                                            </td>
                                            <td>{{ $statistiques['par_statut']['refusee'] ?? 0 }}</td>
                                            <td>{{ $statistiques['candidatures_total'] > 0 ? round(($statistiques['par_statut']['refusee'] ?? 0) / $statistiques['candidatures_total'] * 100, 1) : 0 }}%</td>
                                            <td>
                                                <span class="text-muted">-</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations sur l'offre -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations de l'offre</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Date de publication</h6>
                                <p class="mb-0">{{ $offre->date_publication ? $offre->date_publication->format('d/m/Y') : 'Non publiée' }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Durée de publication</h6>
                                <p class="mb-0">
                                    @if($offre->date_publication)
                                        {{ $offre->date_publication->diffInDays(now()) }} jour(s)
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Statut actuel</h6>
                                <p class="mb-0">
                                    @if($offre->statut === 'publiee')
                                        <span class="badge bg-success">Publiée</span>
                                    @elseif($offre->statut === 'suspendue')
                                        <span class="badge bg-warning">Suspendue</span>
                                    @else
                                        <span class="badge bg-secondary">Brouillon</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Type de contrat</h6>
                                <p class="mb-0">{{ $offre->typeContrat->nom ?? 'Non spécifié' }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Lieu du poste</h6>
                                <p class="mb-0">{{ $offre->lieu_poste ?? 'Non spécifié' }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Moyenne candidatures/jour</h6>
                                <p class="mb-0">
                                    @if($offre->date_publication && $statistiques['candidatures_total'] > 0)
                                        {{ round($statistiques['candidatures_total'] / max(1, $offre->date_publication->diffInDays(now())), 1) }}
                                    @else
                                        0
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse des profils -->
            @if($statistiques['candidatures_total'] > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user-graduate me-2"></i>Analyse des profils candidats</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted">Répartition par expérience</h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Débutants (0-2 ans)</small>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-info" style="width: {{ $statistiques['experience']['debutant'] ?? 0 }}%">{{ $statistiques['experience']['debutant'] ?? 0 }}%</div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Expérimentés (3-5 ans)</small>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-warning" style="width: {{ $statistiques['experience']['experimente'] ?? 0 }}%">{{ $statistiques['experience']['experimente'] ?? 0 }}%</div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Seniors (5+ ans)</small>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" style="width: {{ $statistiques['experience']['senior'] ?? 0 }}%">{{ $statistiques['experience']['senior'] ?? 0 }}%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Top 5 des villes</h6>
                                    @if(isset($statistiques['villes']) && count($statistiques['villes']) > 0)
                                        @foreach(array_slice($statistiques['villes'], 0, 5) as $ville => $count)
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>{{ $ville ?: 'Non renseignée' }}</span>
                                                <span class="badge bg-secondary">{{ $count }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">Aucune donnée disponible</p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted">Recommandations</h6>
                                    <div class="alert alert-info">
                                        @if($statistiques['taux_conversion'] < 5)
                                            <small><i class="fas fa-lightbulb"></i> Votre taux de conversion est faible. Considérez réviser les critères de l'offre.</small>
                                        @elseif($statistiques['taux_conversion'] > 20)
                                            <small><i class="fas fa-thumbs-up"></i> Excellent taux de conversion ! Votre offre attire les bons profils.</small>
                                        @else
                                            <small><i class="fas fa-check"></i> Taux de conversion correct. Continuez sur cette voie.</small>
                                        @endif
                                    </div>
                                    @if($statistiques['candidatures_total'] > 50)
                                        <div class="alert alert-warning">
                                            <small><i class="fas fa-exclamation-triangle"></i> Beaucoup de candidatures reçues. Pensez à affiner vos critères.</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique en camembert pour les statuts
const statutCtx = document.getElementById('statutChart').getContext('2d');
const statutChart = new Chart(statutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Candidatures reçues', 'Présélectionnées', 'Entretiens', 'Retenues', 'Non retenues'],
        datasets: [{
            data: [
                {{ $statistiques['par_statut']['candidature_recue'] ?? 0 }},
                {{ $statistiques['par_statut']['preselctionnee'] ?? 0 }},
                {{ $statistiques['par_statut']['entretien'] ?? 0 }},
                {{ $statistiques['par_statut']['retenue'] ?? 0 }},
                {{ $statistiques['par_statut']['refusee'] ?? 0 }}
            ],
            backgroundColor: [
                '#007bff',
                '#ffc107',
                '#17a2b8',
                '#28a745',
                '#dc3545'
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

// Graphique d'évolution des candidatures
const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
const evolutionChart = new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($statistiques['evolution']['labels'] ?? []) !!},
        datasets: [{
            label: 'Candidatures par jour',
            data: {!! json_encode($statistiques['evolution']['data'] ?? []) !!},
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
@endsection