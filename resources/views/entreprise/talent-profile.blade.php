@extends('layouts.entreprise')

@section('title', 'Profil du Talent')

@section('content')
<div class="container py-4">
    <!-- En-tête avec bouton retour -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('entreprise.talents.search') }}" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left me-1"></i>Retour à la recherche
                    </a>
                    <div>
                        <h1 class="h3 mb-1 text-primary">👤 Profil du Talent</h1>
                        <p class="text-muted mb-0">Informations détaillées du candidat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone d'affichage des messages -->
    <div class="row mb-3">
        <div class="col-12">
            <div id="successMessage" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
                <i class="bi bi-check-circle me-2"></i>
                <span id="successText"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div id="errorMessage" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none;">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <span id="errorText"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Informations personnelles -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Photo de profil -->
                        <div class="col-md-3 text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($talent->avatar_type)
                                    <img src="{{ asset('storage/avatars/$talent->avatar_type') }}" 
                                         alt="Photo de profil" 
                                         class="rounded-circle border border-3 border-primary" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle border border-3 border-primary d-flex align-items-center justify-content-center" 
                                         style="width: 150px; height: 150px; background-color: #f8f9fa;">
                                        <i class="bi bi-person-circle text-muted" style="font-size: 80px;"></i>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0">
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle"></i>
                                    </span>
                                </div>
                            </div>
                            <h4 class="text-primary mt-3 mb-1">{{ $talent->user->name ?? 'Nom non disponible' }}</h4>
                            <p class="text-muted mb-0">{{ $talent->familleMetier->nom ?? 'Métier non spécifié' }}</p>
                        </div>
                        
                        <!-- Informations personnelles -->
                        <div class="col-md-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Informations personnelles</h6>
                            <p><strong>Email:</strong> {{ $talent->user->email ?? 'Non renseigné' }}</p>
                            <p><strong>Téléphone:</strong> {{ $talent->telephone ?? 'Non renseigné' }}</p>
                            <p><strong>Date de naissance:</strong> {{ $talent->date_naissance ? \Carbon\Carbon::parse($talent->date_naissance)->format('d/m/Y') : 'Non renseignée' }}</p>
                            <p><strong>Lieu de naissance:</strong> {{ $talent->lieu_naissance ?? 'Non renseigné' }}</p>
                        </div>
                        
                        <!-- Informations de contact et localisation -->
                        <div class="col-md-5">
                            <h6 class="text-primary mb-3"><i class="bi bi-geo-alt me-2"></i>Localisation & Contact</h6>
                            <p><strong>Adresse:</strong> {{ $talent->adresse ?? 'Non renseignée' }}</p>
                            <p><strong>Ville:</strong> {{ $talent->ville ?? 'Non renseignée' }}</p>
                            <p><strong>Nationalité:</strong> {{ $talent->nationalite ?? 'Non renseignée' }}</p>
                            <p><strong>Situation matrimoniale:</strong> {{ $talent->situation_matrimoniale ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profil professionnel -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Profil professionnel</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pôle:</strong> {{ $talent->pole->nom ?? 'Non spécifié' }}</p>
                            <p><strong>Famille de métier:</strong> {{ $talent->familleMetier->nom ?? 'Non spécifiée' }}</p>
                            <p><strong>Niveau de diplôme:</strong> {{ $talent->niveauDiplome->nom ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Années d'expérience:</strong> {{ $talent->annees_experience ?? 'Non renseignées' }}</p>
                            <p><strong>Salaire souhaité:</strong> {{ $talent->salaire_souhaite ? number_format($talent->salaire_souhaite, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}</p>
                            <p><strong>Disponibilité:</strong> {{ $talent->disponibilite ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                    
                    @if($talent->bio)
                    <div class="mt-3">
                        <strong>Biographie:</strong>
                        <p class="mt-2">{{ $talent->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Expériences professionnelles -->
            @if($talent->experiencesProfessionnelles && $talent->experiencesProfessionnelles->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Expériences professionnelles</h5>
                </div>
                <div class="card-body">
                    @foreach($talent->experiencesProfessionnelles as $experience)
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="text-primary">{{ $experience->poste }}</h6>
                        <p class="mb-1"><strong>{{ $experience->entreprise }}</strong></p>
                        <p class="text-muted mb-2">
                            {{ \Carbon\Carbon::parse($experience->date_debut)->format('m/Y') }} - 
                            {{ $experience->date_fin ? \Carbon\Carbon::parse($experience->date_fin)->format('m/Y') : 'En cours' }}
                        </p>
                        @if($experience->description)
                        <p>{{ $experience->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Formations -->
            @if($talent->formations && $talent->formations->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-dark">
                    <h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Formations</h5>
                </div>
                <div class="card-body">
                    @foreach($talent->formations as $formation)
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="text-primary">{{ $formation->diplome }}</h6>
                        <p class="mb-1"><strong>{{ $formation->etablissement }}</strong></p>
                        <p class="text-muted mb-2">{{ $formation->annee_obtention }}</p>
                        @if($formation->mention)
                        <p><strong>Mention:</strong> {{ $formation->mention }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Statistiques -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <div class="fw-bold text-primary h4">{{ $talent->candidatures->count() }}</div>
                            <small class="text-muted">Candidatures</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success h4">{{ $talent->profile_completion_percentage ?? 0 }}%</div>
                            <small class="text-muted">Profil complété</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compétences -->
            @if($talent->competences && $talent->competences->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Compétences</h5>
                </div>
                <div class="card-body">
                    @foreach($talent->competences as $competence)
                    <span class="badge bg-light text-dark me-2 mb-2">{{ $competence->nom }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Langues -->
            @if($talent->langues && $talent->langues->count() > 0)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-translate me-2"></i>Langues</h5>
                </div>
                <div class="card-body">
                    @foreach($talent->langues as $langue)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $langue->nom }}</span>
                        <span class="badge bg-primary">{{ $langue->niveau }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="linkToOffer({{ $talent->id }})">
                            <i class="bi bi-link me-1"></i>Lier à une offre
                        </button>
                        <!-- <button class="btn btn-outline-primary" onclick="contactTalent({{ $talent->id }})">
                            <i class="bi bi-envelope me-1"></i>Contacter
                        </button>
                        <button class="btn btn-outline-success" onclick="addToFavorites({{ $talent->id }})">
                            <i class="bi bi-heart me-1"></i>Ajouter aux favoris
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour lier à une offre -->
<div class="modal fade" id="linkOfferModal" tabindex="-1" aria-labelledby="linkOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkOfferModalLabel">Lier le talent à une offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="linkOfferForm">
                    @csrf
                    <input type="hidden" id="talent_id" name="talent_id" value="{{ $talent->id }}">
                    <div class="mb-3">
                        <label for="offre_id" class="form-label">Sélectionner une offre d'emploi</label>
                        <select class="form-select" id="offre_id" name="offre_id" required>
                            <option value="">Choisir une offre...</option>
                            @if(Auth::user()->entreprise && Auth::user()->entreprise->offresEmploi)
                                @foreach(Auth::user()->entreprise->offresEmploi->where('statut', 'publiee') as $offre)
                                    <option value="{{ $offre->id }}">{{ $offre->titre }} - {{ $offre->lieu_poste }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Le talent sera automatiquement ajouté aux candidatures de l'offre sélectionnée.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="submitLinkOffer()">Lier à l'offre</button>
            </div>
        </div>
    </div>
</div>

<script>
function linkToOffer(talentId) {
    // Ouvrir la modal pour sélectionner une offre
    const modal = new bootstrap.Modal(document.getElementById('linkOfferModal'));
    modal.show();
}

function submitLinkOffer() {
    const form = document.getElementById('linkOfferForm');
    const formData = new FormData(form);
    
    // Vérifier qu'une offre est sélectionnée
    if (!formData.get('offre_id')) {
        alert('Veuillez sélectionner une offre d\'emploi.');
        return;
    }
    
    // Envoyer la requête AJAX
    fetch('{{ route("entreprise.talents.link") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Fermer la modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('linkOfferModal'));
            modal.hide();
            
            // Afficher le message de succès
            showSuccessMessage('Talent lié à l\'offre avec succès!');
            
            // Optionnel: recharger la page ou mettre à jour l'interface
            // location.reload();
        } else {
            showErrorMessage('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showErrorMessage('Une erreur est survenue lors de la liaison.');
    });
}

function contactTalent(talentId) {
    // TODO: Implémenter le contact du talent
    alert('Fonctionnalité à implémenter: Contacter le talent ' + talentId);
}

function addToFavorites(talentId) {
    // TODO: Implémenter l'ajout aux favoris
    alert('Fonctionnalité à implémenter: Ajouter le talent ' + talentId + ' aux favoris');
}

// Fonctions pour afficher les messages
function showSuccessMessage(message) {
    const successDiv = document.getElementById('successMessage');
    const successText = document.getElementById('successText');
    
    successText.textContent = message;
    successDiv.style.display = 'block';
    successDiv.classList.add('show');
    
    // Faire défiler vers le haut pour voir le message
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Masquer automatiquement après 5 secondes
    setTimeout(() => {
        successDiv.classList.remove('show');
        setTimeout(() => {
            successDiv.style.display = 'none';
        }, 150);
    }, 5000);
}

function showErrorMessage(message) {
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    errorText.textContent = message;
    errorDiv.style.display = 'block';
    errorDiv.classList.add('show');
    
    // Faire défiler vers le haut pour voir le message
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Masquer automatiquement après 7 secondes (plus long pour les erreurs)
    setTimeout(() => {
        errorDiv.classList.remove('show');
        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 150);
    }, 7000);
}
</script>
@endsection