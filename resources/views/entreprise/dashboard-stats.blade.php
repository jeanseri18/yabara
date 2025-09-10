@extends('layouts.entreprise')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-3 text-dark fw-bold">Tableau de bord</h1>
                    
                    <!-- Dropdown Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">
                            <span>Ce mois ci</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                            <li><a class="dropdown-item active" href="#">Ce mois ci</a></li>
                            <li><a class="dropdown-item" href="#">Ce trimestre</a></li>
                            <li><a class="dropdown-item" href="#">Cette année</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Statistics Cards -->
        <div class="col-lg-6">
            <div class="row">
                <!-- Candidatures ce mois -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/portfolio_16805985.png') }}" alt="Candidatures" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="text-muted small mb-1">+{{ $kpis['candidatures_mois'] ?? 0 }} ce mois ci</div>
                                <div class="fw-bold text-success">Candidatures</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vu sur les offres -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/vues.png') }}" alt="Vues" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Vu sur les offres</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ number_format($kpis['vues_totales'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profils visités -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/profils.png') }}" alt="Profils" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Profils visités</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $kpis['profils_visites'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Talents liés aux offres -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/talents.png') }}" alt="Talents" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Talents liés aux offres</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $kpis['talents_lies'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entretiens programmés -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/messages.png') }}" alt="Entretiens" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Entretiens programmés</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $kpis['entretiens_programmes'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Candidats recrutés -->
                <div class="col-12 mb-3">
                    <div class="card bg-white shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="icon-container me-3">
                                <div class="icon-wrapper" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/candidatures.png') }}" alt="Recrutés" style="width: 40px; height: 40px; object-fit: contain;">
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">Candidats recrutés</div>
                                <div class="h5 mb-0 fw-bold text-dark">{{ $kpis['candidats_recrutes'] ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Charts -->
        <div class="col-lg-6">
            <!-- Candidatures publiées Chart -->
            <div class="card bg-white shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Candidatures publiées</h6>
                    <div class="chart-container" style="height: 200px;">
                        <canvas id="candidaturesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Types de contrat Chart -->
            <div class="card bg-white shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Repartitions des candidatures</h6>
                    <div class="row align-items-center">
                        <div class="col-8">
                            <div class="chart-container" style="height: 150px;">
                                <canvas id="contractTypesChart"></canvas>
                            </div>
                        </div>
                        <div class="col-4">
                            @if(isset($repartition_candidatures) && count($repartition_candidatures) > 0)
                                    @php
                                        $total = collect($repartition_candidatures)->sum('count');
                                    @endphp
                                    @foreach($repartition_candidatures as $type => $data)
                                        @php
                                            $pourcentage = $total > 0 ? round(($data['count'] / $total) * 100, 1) : 0;
                                        @endphp
                                        <div class="legend-item d-flex align-items-center mb-2">
                                            <div class="legend-color rounded-circle me-2" style="width: 12px; height: 12px; background-color: {{ $data['color'] }};"></div>
                                            <span class="small">{{ $data['label'] }} <strong>{{ $pourcentage }}%</strong></span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="legend-item d-flex align-items-center mb-2">
                                        <div class="legend-color bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                        <span class="small">Aucune donnée disponible</span>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Candidats recrutés Section -->
            <div class="card bg-white shadow-sm border-0">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Candidats recrutés</h6>
                    <div class="d-flex align-items-center">
                        <div class="icon-container me-3">
                            <div class="icon-wrapper bg-info bg-opacity-10 rounded-3 p-2 position-relative" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('images/messages.png') }}" alt="Messages" style="width: 32px; height: 32px; object-fit: contain;">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">1</span>
                            </div>
                        </div>
                        <div>
                            <div class="fw-semibold">Messages et notifications</div>
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

.icon-wrapper {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.legend-color {
    flex-shrink: 0;
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

.chart-container {
    position: relative;
}

.h5 {
    font-size: 1.5rem;
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
</style>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Candidatures Chart
const ctxCandidatures = document.getElementById('candidaturesChart').getContext('2d');
const candidaturesChart = new Chart(ctxCandidatures, {
    type: 'line',
    data: {
        labels: {!! json_encode($evolutionData['evolution_labels'] ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin']) !!},
        datasets: [{
            data: {!! json_encode($evolutionData['evolution_candidatures'] ?? [0, 0, 0, 0, 0, 0]) !!},
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: '#0d6efd',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
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
                display: true,
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6c757d'
                }
            },
            y: {
                display: true,
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                },
                ticks: {
                    color: '#6c757d'
                }
            }
        }
    }
});

// Contract Types Donut Chart
const ctxContract = document.getElementById('contractTypesChart').getContext('2d');
@php
    $repartitionLabels = [];
    $repartitionData = [];
    $repartitionColors = [];
    if(isset($repartition_candidatures) && count($repartition_candidatures) > 0) {
        foreach($repartition_candidatures as $data) {
            $repartitionLabels[] = $data['label'];
            $repartitionData[] = $data['count'];
            $repartitionColors[] = $data['color'];
        }
    }
@endphp
const contractChart = new Chart(ctxContract, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($repartitionLabels) !!},
        datasets: [{
            data: {!! json_encode($repartitionData) !!},
            backgroundColor: {!! json_encode($repartitionColors) !!},
            borderWidth: 0,
            cutout: '70%'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Bootstrap dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap dropdowns if Bootstrap JS is loaded
    if (typeof bootstrap !== 'undefined') {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    }
});
</script>
@endsection