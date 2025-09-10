@extends('layouts.entreprise')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2 text-dark fw-bold">Bienvenu chez {{ Auth::user()->entreprise->nom_entreprise ?? 'Orange CI' }}</h1>
                    <p class="text-muted mb-0">Vous êtes au 2 ème badge recrutement (Recruteur d'or) 🏆</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Offres publiées -->
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-white shadow-sm border-0 text-center py-4">
                <div class="card-body">
                    <h6 class="text-muted mb-2 fw-normal">Offres publiées</h6>
                    <h2 class="display-4 mb-0 fw-bold text-dark">{{ $stats['offres_publiees'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Vues totales -->
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-white shadow-sm border-0 text-center py-4">
                <div class="card-body">
                    <h6 class="text-muted mb-2 fw-normal">Vues totales<br>sur vos offres</h6>
                    <h2 class="display-4 mb-0 fw-bold text-dark">{{ number_format($stats['vues_totales']) }}</h2>
                </div>
            </div>
        </div>

        <!-- Candidatures -->
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-white shadow-sm border-0 text-center py-4">
                <div class="card-body">
                    <h6 class="text-muted mb-2 fw-normal">Candidatures<br>reçu ce mois</h6>
                    <h2 class="display-4 mb-0 fw-bold text-dark">{{ $stats['candidatures_mois'] }}</h2>
                </div>
            </div>
        </div>

        <!-- Taux de réponses -->
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-white shadow-sm border-0 text-center py-4">
                <div class="card-body">
                    <h6 class="text-muted mb-2 fw-normal">Taux de réponses<br>aux candidatures</h6>
                    <h2 class="display-4 mb-0 fw-bold text-dark">{{ $stats['taux_reponse'] }}%</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold text-dark">Performances par offre d'emploi</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th class="fw-normal">Offres</th>
                                            <th class="fw-normal text-center">Vues</th>
                                            <th class="fw-normal text-center">Candidatures</th>
                                            <th class="fw-normal text-center">Entretien</th>
                                            <th class="fw-normal text-center">Recruté</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($offres_performance as $offre)
                                        <tr>
                                            <td class="fw-semibold">{{ Str::limit($offre['titre'], 15) }}</td>
                                            <td class="text-center">{{ $offre['vues'] }}</td>
                                            <td class="text-center">{{ $offre['candidatures'] }}</td>
                                            <td class="text-center">{{ $offre['entretiens'] }}</td>
                                            <td class="text-center">{{ $offre['recrutes'] }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Aucune offre publiée</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="chart-container position-relative" style="height: 200px;">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row">
        <!-- À traiter -->
        <div class="col-lg-6 mb-4">
            <div class="card bg-white shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold text-dark">À traiter</h5>
                    
                    @if($candidatures_attente > 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-file-alt fa-2x text-muted"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $candidatures_attente }} candidature{{ $candidatures_attente > 1 ? 's' : '' }} en attente de lecture</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($offres_expirees > 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $offres_expirees }} offre{{ $offres_expirees > 1 ? 's' : '' }} expirée{{ $offres_expirees > 1 ? 's' : '' }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($candidatures_attente == 0 && $offres_expirees == 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Tout est à jour ! Aucune action requise.</div>
                        </div>
                    </div>
                    @else
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Astuce: Traitez rapidement vos candidatures pour améliorer votre taux de réponse</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activités récentes -->
        <div class="col-lg-6 mb-4">
            <div class="card bg-white shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="mb-4 fw-bold text-dark">Activités récentes</h5>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">10</span>
                        </div>
                        <div>
                            <div class="fw-semibold">Publier une offre</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <span class="badge bg-success rounded-circle" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">18</span>
                        </div>
                        <div>
                            <div class="fw-semibold">Assistant RH est sollicité par Community Manager</div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="text-muted small mb-2">Niveau 3 - Recruteur confirmé</div>
                        
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1 me-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: 75%;"></div>
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm px-3">Obtenir</button>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-trophy text-warning me-1"></i>
                            <i class="fas fa-trophy text-warning me-1"></i>
                            <i class="fas fa-trophy text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
body {
    background-color: #f8f9fa;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.display-4 {
    font-size: 2.5rem;
    font-weight: 700;
}

.table td, .table th {
    padding: 0.75rem 0.5rem;
    vertical-align: middle;
}

.badge {
    font-weight: 600;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    font-weight: 600;
}

.progress {
    border-radius: 4px;
    background-color: #e9ecef;
}

.progress-bar {
    border-radius: 4px;
}

h5 {
    font-size: 1.1rem;
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

.fw-normal {
    font-weight: 400 !important;
}

.chart-container {
    background-color: #f8f9fa;
    border-radius: 4px;
    padding: 15px;
}
</style>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simple line chart matching the image
const ctx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [@foreach($offres_performance as $offre)'{{ Str::limit($offre['titre'], 15) }}'{{ !$loop->last ? ',' : '' }}@endforeach],
        datasets: [{
            label: 'Performance',
            data: [@foreach($offres_performance as $offre){{ $offre['candidatures'] > 0 ? round(($offre['recrutes'] / $offre['candidatures']) * 100) : 0 }}{{ !$loop->last ? ',' : '' }}@endforeach],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: '#007bff',
            pointBorderColor: '#007bff',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                display: false
            },
            y: {
                display: false,
                beginAtZero: true
            }
        },
        elements: {
            point: {
                hoverRadius: 6
            }
        }
    }
});
</script>
@endsection