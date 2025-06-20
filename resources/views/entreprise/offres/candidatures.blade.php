@extends('layouts.entreprise')

@section('title', 'Candidatures - ' . $offre->titre)

@section('content')
<div class="container-fluid px-4">
    <div class="row">
 
        
        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Candidatures</h2>
                    <p class="text-muted mb-0">{{ $offre->titre }} - {{ $candidatures->count() }} candidature(s)</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.offres.show', $offre) }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Retour à l'offre
                    </a>
                    <a href="{{ route('entreprise.kanban') }}" class="btn btn-primary">
                        <i class="fas fa-columns"></i> Vue Kanban
                    </a>
                </div>
            </div>

            <!-- Filtres -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('entreprise.offres.candidatures', $offre) }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="candidature_recue" {{ request('statut') === 'candidature_recue' ? 'selected' : '' }}>Candidature reçue</option>
                                <option value="preselctionnee" {{ request('statut') === 'preselctionnee' ? 'selected' : '' }}>Présélectionnée</option>
                                <option value="entretien" {{ request('statut') === 'entretien' ? 'selected' : '' }}>Entretien</option>
                                <option value="retenue" {{ request('statut') === 'retenue' ? 'selected' : '' }}>Retenue</option>
                                <option value="refusee" {{ request('statut') === 'refusee' ? 'selected' : '' }}>Refusée</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ request('date_fin') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="recherche" class="form-label">Recherche</label>
                            <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Nom, prénom, email..." value="{{ request('recherche') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> Filtrer
                            </button>
                            <a href="{{ route('entreprise.offres.candidatures', $offre) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-primary mb-0">{{ $toutesLesCandidatures->where('statut_entreprise', 'candidature_recue')->count() }}</h4>
                            <small class="text-muted">Nouvelles</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-warning mb-0">{{ $toutesLesCandidatures->where('statut_entreprise', 'preselctionnee')->count() }}</h4>
                            <small class="text-muted">Présélectionnées</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-info mb-0">{{ $toutesLesCandidatures->where('statut_entreprise', 'entretien')->count() }}</h4>
                            <small class="text-muted">Entretiens</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-success mb-0">{{ $toutesLesCandidatures->where('statut_entreprise', 'retenue')->count() }}</h4>
                            <small class="text-muted">Retenues</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-danger mb-0">{{ $toutesLesCandidatures->where('statut_entreprise', 'refusee')->count() }}</h4>
                            <small class="text-muted">Refusées</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="text-dark mb-0">{{ $toutesLesCandidatures->count() }}</h4>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des candidatures -->
            @if($candidatures->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Liste des candidatures</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Candidat</th>
                                        <th>Date de candidature</th>
                                        <th>Statut</th>
                                        <th>Expérience</th>
                                        <th>Localisation</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatures as $candidature)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="talent-profile-card me-3">
                                                        <div class="talent-avatar">
                                                            <img src="https://via.placeholder.com/60x60/283C5A/ffffff?text={{ strtoupper(substr($candidature->talent->prenom, 0, 1)) }}" 
                                                                 alt="{{ $candidature->talent->prenom }} {{ $candidature->talent->nom }}" 
                                                                 class="rounded-circle" 
                                                                 width="60" 
                                                                 height="60">
                                                        </div>
                                                    </div>
                                                    <div class="talent-info">
                                                        <h6 class="mb-1 fw-bold">{{ $candidature->talent->prenom }} {{ $candidature->talent->nom }}</h6>
                                                        <p class="mb-1 text-primary fw-medium">
                                                            @if($candidature->talent->experiences->count() > 0)
                                                                {{ $candidature->talent->experiences->first()->poste ?? 'Développeur web et mobile' }}
                                                            @else
                                                                Développeur web et mobile
                                                            @endif
                                                        </p>
                                                        <small class="text-muted">
                                                            @if($candidature->talent->experiences->count() > 0)
                                                                {{ $candidature->talent->experiences->sum('duree_mois') }} mois d'expérience
                                                            @else
                                                                Débutant
                                                            @endif
                                                            @if($candidature->talent->niveau_etude)
                                                                • {{ $candidature->talent->niveau_etude }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $candidature->created_at->format('d/m/Y H:i') }}</span>
                                            </td>
                                            <td>
                                                @switch($candidature->statut_entreprise)
                                                    @case('candidature_recue')
                                                        <span class="badge bg-primary">Candidature reçue</span>
                                                        @break
                                                    @case('preselctionnee')
                                                        <span class="badge bg-warning">Présélectionnée</span>
                                                        @break
                                                    @case('entretien')
                                                        <span class="badge bg-info">Entretien</span>
                                                        @break
                                                    @case('retenue')
                                                        <span class="badge bg-success">Retenue</span>
                                                        @break
                                                    @case('refusee')
                                                        <span class="badge bg-danger">Refusée</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $candidature->statut_entreprise }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($candidature->talent->experiences->count() > 0)
                                                    {{ $candidature->talent->experiences->sum('duree_mois') }} mois
                                                @else
                                                    <span class="text-muted">Débutant</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $candidature->talent->ville ?? 'Non renseignée' }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewCandidature({{ $candidature->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if($candidature->statut_entreprise === 'candidature_recue')
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatut({{ $candidature->id }}, 'preselctionnee')">Présélectionner</a></li>
                                                            @endif
                                                            @if(in_array($candidature->statut_entreprise, ['candidature_recue', 'preselctionnee']))
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatut({{ $candidature->id }}, 'entretien')">Programmer entretien</a></li>
                                                            @endif
                                                            @if(in_array($candidature->statut_entreprise, ['candidature_recue', 'preselctionnee', 'entretien']))
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatut({{ $candidature->id }}, 'retenue')">Retenir</a></li>
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatut({{ $candidature->id }}, 'refusee')">Refuser</a></li>
                                                            @endif
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#" onclick="downloadCV({{ $candidature->talent->id }})">Télécharger CV</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if($candidatures instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $candidatures->links() }}
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune candidature trouvée</h5>
                        <p class="text-muted">Il n'y a pas encore de candidatures pour cette offre ou aucune candidature ne correspond à vos critères de recherche.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour voir les détails de la candidature -->
<div class="modal fade" id="candidatureModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la candidature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="candidatureModalBody">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.talent-profile-card {
    display: flex;
    align-items: center;
}

.talent-avatar img {
    border: 3px solid #f8f9fa;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.talent-avatar img:hover {
    transform: scale(1.05);
}

.talent-info h6 {
    color: #283C5A;
    font-size: 16px;
    margin-bottom: 4px;
}

.talent-info p {
    color: #007bff;
    font-size: 14px;
    margin-bottom: 2px;
}

.talent-info small {
    color: #6c757d;
    font-size: 12px;
    line-height: 1.4;
}

/* Amélioration de l'affichage du tableau */
.table td {
    vertical-align: middle;
    padding: 16px 12px;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #283C5A;
    padding: 12px;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}
</style>
@endpush

@push('scripts')
<script>
function viewCandidature(candidatureId) {
    // Charger les détails de la candidature dans le modal
    fetch(`/entreprise/candidatures/${candidatureId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('candidatureModalBody').innerHTML = data.html;
                new bootstrap.Modal(document.getElementById('candidatureModal')).show();
            } else {
                showToast('Erreur lors du chargement des détails', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Erreur lors du chargement des détails', 'error');
        });
}

function updateStatut(candidatureId, nouveauStatut) {
    const messages = {
        'preselctionnee': 'présélectionner cette candidature',
        'entretien': 'programmer un entretien pour cette candidature',
        'retenue': 'retenir cette candidature',
        'refusee': 'refuser cette candidature'
    };
    
    if (confirm(`Êtes-vous sûr de vouloir ${messages[nouveauStatut]} ?`)) {
        fetch(`/entreprise/candidatures/${candidatureId}/statut`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ statut: nouveauStatut })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Une erreur est survenue', 'error');
        });
    }
}

function downloadCV(talentId) {
    window.open(`/entreprise/talents/${talentId}/cv`, '_blank');
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '9999';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush
@endsection