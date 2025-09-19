@extends('layouts.admin')

@section('title', 'Administration')
@section('page-title', 'Admin')
@section('full-page', true)

@push('styles')
<style>
    .dashboard-container {
        background: #f8fafc;
        min-height: 100vh;
        padding: 20px;
        color: #1f2937;
    }
    
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .period-selector {
        background: white;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        color: #374151;
        padding: 8px 16px;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .stat-icon {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .chart-title {
        color: #1f2937;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .alerts-insights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .alert-item {
        background: rgba(255, 193, 7, 0.1);
        border-left: 3px solid #ffc107;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-radius: 4px;
    }
    
    .insight-item {
        background: rgba(13, 202, 240, 0.1);
        border-left: 3px solid #0dcaf0;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border-radius: 4px;
    }
    
    .metric-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 8px;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 4px;
        transition: width 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .charts-grid,
        .alerts-insights-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Custom Header -->
    <div class="dashboard-header">
        <h1 style="font-size: 2rem; font-weight: bold; margin: 0; color: #1f2937;">Admin</h1>
        <div style="display: flex; align-items: center; gap: 20px;">
            <select class="period-selector" id="periodSelector">
                <option value="mois" {{ $periode == 'mois' ? 'selected' : '' }}>Le mois dernier</option>
                <option value="semaine" {{ $periode == 'semaine' ? 'selected' : '' }}>La semaine dernière</option>
                <option value="trimestre" {{ $periode == 'trimestre' ? 'selected' : '' }}>Le trimestre dernier</option>
                <option value="annee" {{ $periode == 'annee' ? 'selected' : '' }}>L'année dernière</option>
            </select>
            <div style="display: flex; align-items: center; gap: 10px; color: #374151;">
                <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                <span>{{ Auth::user()->email }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #6b7280; cursor: pointer; padding: 5px; transition: color 0.2s;" title="Déconnexion" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#6b7280'">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.2rem;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['talents_inscrits']) }}</div>
            <div class="stat-label">Talents inscrits</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['offres_publiees']) }}</div>
            <div class="stat-label">Offres publiées</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['recrutements_realises']) }}</div>
            <div class="stat-label">Recrutements réalisés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-number">{{ number_format($stats['candidatures_deposees']) }}</div>
            <div class="stat-label">Candidatures déposées</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Evolution Chart -->
        <div class="chart-card">
            <div class="chart-title">Candidatures au fil du temps</div>
            <canvas id="evolutionChart" width="400" height="200"></canvas>
        </div>
        
        <!-- Pie Chart -->
        <div class="chart-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div class="metric-circle" style="background: conic-gradient(#4ade80 0deg {{ ($repartitionData['contrats']->where('nom', 'CDI')->first()->count ?? 0) / max($repartitionData['contrats']->sum('count'), 1) * 360 }}deg, #06b6d4 {{ ($repartitionData['contrats']->where('nom', 'CDI')->first()->count ?? 0) / max($repartitionData['contrats']->sum('count'), 1) * 360 }}deg {{ (($repartitionData['contrats']->where('nom', 'CDI')->first()->count ?? 0) + ($repartitionData['contrats']->where('nom', 'CDD')->first()->count ?? 0)) / max($repartitionData['contrats']->sum('count'), 1) * 360 }}deg, #8b5cf6 {{ (($repartitionData['contrats']->where('nom', 'CDI')->first()->count ?? 0) + ($repartitionData['contrats']->where('nom', 'CDD')->first()->count ?? 0)) / max($repartitionData['contrats']->sum('count'), 1) * 360 }}deg 360deg);">
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: bold;">{{ $stats['taux_transformation'] }}%</div>
                        <div style="font-size: 0.8rem; opacity: 0.8;">Contrat</div>
                    </div>
                </div>
                <div style="flex: 1; margin-left: 20px;">
                    @foreach($repartitionData['contrats'] as $contrat)
                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                        <div style="width: 12px; height: 12px; border-radius: 50%; background: {{ $loop->index == 0 ? '#4ade80' : ($loop->index == 1 ? '#06b6d4' : '#8b5cf6') }}; margin-right: 8px;"></div>
                        <span style="font-size: 0.9rem;">{{ $contrat->nom }} ({{ number_format($contrat->count / max($repartitionData['contrats']->sum('count'), 1) * 100, 1) }}%)</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom Section -->
    <div class="charts-grid">
        <!-- Recruitment Stats -->
        <div class="chart-card">
            <div class="chart-title">Recrutements par pôle</div>
            <div style="display: flex; justify-content: space-around; align-items: end; height: 120px; margin-top: 20px;">
                @php
                    $maxCount = $repartitionData['poles']->max('count') ?: 1;
                @endphp
                @foreach($repartitionData['poles']->take(3) as $pole)
                <div style="text-align: center; width: 120px;">
                    <div style="width: 40px; height: {{ ($pole->count / $maxCount) * 80 }}px; background: linear-gradient(to top, #4ade80, #22d3ee); border-radius: 4px; margin: 0 auto 8px;"></div>
                    <div style="font-size: 0.7rem; opacity: 0.8; line-height: 1.2; word-wrap: break-word;">{{ $pole->nom }}</div>
                </div>
                @endforeach
            </div>
            
            <div style="margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: bold;">{{ $stats['taux_offres_zero_candidature'] }}%</div>
                        <div style="font-size: 0.8rem; opacity: 0.8;">Offres sans candidature</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.2rem; font-weight: bold;">{{ $stats['delai_moyen_recrutement'] }}J</div>
                        <div style="font-size: 0.8rem; opacity: 0.8;">Délai moyen de recrutement</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.2rem; font-weight: bold;">{{ $stats['delai_moyen_recrutement'] }}J</div>
                        <div style="font-size: 0.8rem; opacity: 0.8;">Délai moyen de recrutement</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Metrics -->
        <div class="chart-card">
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <div style="text-align: center;">
                    <div class="metric-circle" style="background: conic-gradient(#10b981 0deg {{ min($stats['taux_transformation'], 100) * 3.6 }}deg, rgba(255,255,255,0.2) {{ min($stats['taux_transformation'], 100) * 3.6 }}deg 360deg);">
                        {{ $stats['taux_transformation'] }}%
                    </div>
                    <div style="font-size: 0.9rem; opacity: 0.8;">Recrutements par pôle</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alerts and Insights -->
    <div class="alerts-insights-grid">
        <!-- Alerts -->
        <div class="chart-card">
            <div class="chart-title">Alertes</div>
            @foreach($alertes as $alerte)
            <div class="alert-item">
                <div style="font-size: 0.9rem; margin-bottom: 4px;">🟡 {{ $alerte['message'] }}</div>
                @if(isset($alerte['action']))
                <div style="font-size: 0.8rem; opacity: 0.8;">{{ $alerte['action'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
        
        <!-- Insights -->
        <div class="chart-card">
            <div class="chart-title">Insights</div>
            @foreach($insights as $insight)
            <div class="insight-item">
                <div style="font-size: 0.9rem; margin-bottom: 4px;">🔵 {{ $insight['message'] }}</div>
                @if(isset($insight['action']))
                <div style="font-size: 0.8rem; opacity: 0.8;">{{ $insight['action'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Evolution Chart
const ctx = document.getElementById('evolutionChart').getContext('2d');
const evolutionChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($evolutionData['candidatures'])) !!},
        datasets: [{
            label: 'Candidatures',
            data: {!! json_encode(array_values($evolutionData['candidatures'])) !!},
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: 'white'
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                },
                ticks: {
                    color: 'white'
                }
            }
        }
    }
});

// Period Selector
document.getElementById('periodSelector').addEventListener('change', function() {
    window.location.href = '{{ route("admin.dashboard") }}?periode=' + this.value;
});
</script>
@endpush
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">Aujourd'hui</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-building text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">TechCorp SARL</p>
                            <p class="text-xs text-gray-500">Entreprise - IT</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">Hier</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
