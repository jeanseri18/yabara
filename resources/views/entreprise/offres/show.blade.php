@extends('layouts.entreprise')

@section('title', 'Détails de l\'offre')

@section('content')
<div class="container px-4">
    <div class="row">
        <!-- Sidebar -->
    
        
        <!-- Main Content -->
        <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">{{ $offre->titre }}</h2>
                    <p class="text-muted mb-0">Référence: {{ $offre->reference_offre ?? 'Non assignée' }}</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Retour à la liste
                    </a>
                    <a href="{{ route('entreprise.offres.edit', $offre) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>

            <!-- Statut de l'offre -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Statut</h6>
                                    @if($offre->statut === 'publiee')
                                        <span class="badge bg-success fs-6">Publiée</span>
                                    @elseif($offre->statut === 'suspendue')
                                        <span class="badge bg-warning fs-6">Suspendue</span>
                                    @else
                                        <span class="badge bg-secondary fs-6">Brouillon</span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Date de publication</h6>
                                    <p class="mb-0">{{ $offre->date_publication ? $offre->date_publication->format('d/m/Y') : 'Non publiée' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Candidatures reçues</h6>
                                    <p class="mb-0 fw-bold text-primary">{{ $offre->candidatures->count() }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted mb-1">Date de création</h6>
                                    <p class="mb-0">{{ $offre->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails de l'offre -->
            <div class="row">
                <div class="col-md-8">
                    <!-- Description du poste -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Description du poste</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-muted">Descriptif</h6>
                                <p class="mb-0">{{ $offre->descriptif }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations du poste -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations du poste</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Type de contrat</h6>
                                    <p class="mb-0">{{ $offre->typeContrat->nom ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Pôle d'activité</h6>
                                    <p class="mb-0">{{ $offre->pole->nom ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Famille de métier</h6>
                                    <p class="mb-0">{{ $offre->familleMetier->nom ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Lieu du poste</h6>
                                    <p class="mb-0">{{ $offre->lieu_poste ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Niveau de diplôme requis</h6>
                                    <p class="mb-0">{{ $offre->niveauDiplome->nom ?? 'Non spécifié' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Expérience minimum</h6>
                                    <p class="mb-0">{{ $offre->experience_minimum ?? 0 }} an(s)</p>
                                </div>
                                @if($offre->remuneration)
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Rémunération</h6>
                                    <p class="mb-0">{{ number_format($offre->remuneration, 0, ',', ' ') }} FCFA</p>
                                </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Télétravail</h6>
                                    <p class="mb-0">
                                        @if($offre->teletravail)
                                            <span class="badge bg-success">Possible</span>
                                        @else
                                            <span class="badge bg-secondary">Non</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Mobilité requise</h6>
                                    <p class="mb-0">
                                        @if($offre->mobilite_requise)
                                            <span class="badge bg-warning">Oui</span>
                                        @else
                                            <span class="badge bg-success">Non</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Actions rapides</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('entreprise.offres.candidatures', $offre) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-users me-2"></i>Voir les candidatures ({{ $offre->candidatures->count() }})
                                </a>
                                <a href="{{ route('entreprise.offres.statistiques', $offre) }}" class="btn btn-outline-info">
                                    <i class="fas fa-chart-bar me-2"></i>Statistiques détaillées
                                </a>
                                <form action="{{ route('entreprise.offres.duplicate', $offre) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-copy me-2"></i>Dupliquer l'offre
                                    </button>
                                </form>
                                @if($offre->statut === 'publiee')
                                    <button type="button" class="btn btn-outline-warning" onclick="toggleOffreStatus({{ $offre->id }}, 'suspend')">
                                        <i class="fas fa-pause me-2"></i>Suspendre l'offre
                                    </button>
                                @elseif($offre->statut === 'suspendue')
                                    <button type="button" class="btn btn-outline-success" onclick="toggleOffreStatus({{ $offre->id }}, 'activate')">
                                        <i class="fas fa-play me-2"></i>Réactiver l'offre
                                    </button>
                                @endif
                                @if($offre->candidatures->count() === 0)
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteOffre({{ $offre->id }})">
                                        <i class="fas fa-trash me-2"></i>Supprimer l'offre
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    @if($offre->candidatures->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Aperçu des candidatures</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h4 class="text-primary mb-0">{{ $offre->candidatures->where('statut_entreprise', 'candidature_recue')->count() }}</h4>
                                        <small class="text-muted">Nouvelles</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-2">
                                        <h4 class="text-warning mb-0">{{ $offre->candidatures->where('statut_entreprise', 'preselctionnee')->count() }}</h4>
                                        <small class="text-muted">Présélectionnées</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <h4 class="text-info mb-0">{{ $offre->candidatures->where('statut_entreprise', 'entretien')->count() }}</h4>
                                        <small class="text-muted">Entretiens</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-2">
                                        <h4 class="text-success mb-0">{{ $offre->candidatures->where('statut_entreprise', 'retenue')->count() }}</h4>
                                        <small class="text-muted">Recrutées</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleOffreStatus(offreId, action) {
    if (confirm(action === 'suspend' ? 'Êtes-vous sûr de vouloir suspendre cette offre ?' : 'Êtes-vous sûr de vouloir réactiver cette offre ?')) {
        fetch(`/entreprise/offres/${offreId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ action: action })
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

function deleteOffre(offreId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.')) {
        fetch(`/entreprise/offres/${offreId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.href = '{{ route("entreprise.offres.index") }}', 1000);
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

function showToast(message, type) {
    // Implémentation simple du toast
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