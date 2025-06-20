<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Export PDF - {{ $periode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .report-period {
            font-size: 12px;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .kpi-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .kpi-row {
            display: table-row;
        }
        .kpi-cell {
            display: table-cell;
            width: 25%;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }
        .kpi-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .kpi-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $entreprise->nom ?? 'Entreprise' }}</div>
        <div class="report-title">Rapport Dashboard</div>
        <div class="report-period">Période: {{ ucfirst($periode) }} - Généré le {{ now()->format('d/m/Y à H:i') }}</div>
    </div>

    <!-- KPIs Section -->
    <div class="section">
        <div class="section-title">Indicateurs Clés de Performance</div>
        <div class="kpi-grid">
            <div class="kpi-row">
                <div class="kpi-cell">
                    <div class="kpi-value">{{ $kpis['total_offres'] ?? 0 }}</div>
                    <div class="kpi-label">Total Offres</div>
                </div>
                <div class="kpi-cell">
                    <div class="kpi-value">{{ $kpis['offres_actives'] ?? 0 }}</div>
                    <div class="kpi-label">Offres Actives</div>
                </div>
                <div class="kpi-cell">
                    <div class="kpi-value">{{ $kpis['total_candidatures'] ?? 0 }}</div>
                    <div class="kpi-label">Total Candidatures</div>
                </div>
                <div class="kpi-cell">
                    <div class="kpi-value">{{ $kpis['candidatures_recues'] ?? 0 }}</div>
                    <div class="kpi-label">Candidatures Reçues</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance des Offres -->
    <div class="section">
        <div class="section-title">Performance des Offres d'Emploi</div>
        @if(isset($offres_performance) && count($offres_performance) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Titre de l'offre</th>
                        <th>Date de publication</th>
                        <th>Statut</th>
                        <th>Candidatures reçues</th>
                        <th>Taux de réponse</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offres_performance as $offre)
                        <tr>
                            <td>{{ $offre->titre }}</td>
                            <td>{{ $offre->created_at->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($offre->statut) }}</td>
                            <td>{{ $offre->candidatures_count ?? 0 }}</td>
                            <td>{{ $offre->candidatures_count > 0 ? number_format(($offre->candidatures_count / 100) * 100, 1) : '0' }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Aucune donnée de performance disponible pour cette période</div>
        @endif
    </div>

    <!-- Répartition des Candidatures -->
    <div class="section">
        <div class="section-title">Répartition des Candidatures par Statut</div>
        @if(isset($repartition) && array_sum($repartition) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Statut</th>
                        <th>Nombre</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = array_sum($repartition); @endphp
                    @foreach($repartition as $statut => $count)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $statut)) }}</td>
                            <td>{{ $count }}</td>
                            <td>{{ $total > 0 ? number_format(($count / $total) * 100, 1) : '0' }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Aucune candidature disponible pour cette période</div>
        @endif
    </div>

    <!-- Évolution des Activités -->
    <div class="section">
        <div class="section-title">Évolution des Activités (7 derniers jours)</div>
        @if(isset($evolution) && count($evolution['dates']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nouvelles Offres</th>
                        <th>Nouvelles Candidatures</th>
                        <th>Recrutements</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evolution['dates'] as $index => $date)
                        <tr>
                            <td>{{ $date }}</td>
                            <td>{{ $evolution['offres'][$index] ?? 0 }}</td>
                            <td>{{ $evolution['candidatures'][$index] ?? 0 }}</td>
                            <td>{{ $evolution['recrutements'][$index] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Aucune donnée d'évolution disponible pour cette période</div>
        @endif
    </div>

    <div class="footer">
        <p>Rapport généré automatiquement par YABARA - Plateforme de recrutement</p>
        <p>{{ url('/') }}</p>
    </div>
</body>
</html>