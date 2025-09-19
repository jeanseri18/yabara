@extends('layouts.entreprise')

@section('title', 'Profil du Talent')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- En-tête -->
    <div class="row mb-4 pt-3">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <a href="{{ route('entreprise.talents.search') }}" class="btn btn-link p-0 me-3" style="color: #666;">
                    <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                </a>
                <div>
                    <h5 class="mb-0" style="color: #333; font-weight: 600;">Profil du Talent</h5>
                    <small class="text-muted">Informations détaillées du candidat</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone d'affichage des messages -->
    <div class="row mb-3">
        <div class="col-12">
            <div id="successMessage" class="alert alert-success alert-dismissible fade border-0" role="alert" style="display: none; border-radius: 12px;">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successText"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div id="errorMessage" class="alert alert-danger alert-dismissible fade border-0" role="alert" style="display: none; border-radius: 12px;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <span id="errorText"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Profil principal -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row">
                <!-- Photo de profil -->
                <div class="col-md-3 text-center mb-4">
                    <div class="position-relative d-inline-block">
                        @if($talent->avatar_type)
                            <img src="{{ asset('storage/avatars/'.$talent->avatar_type) }}" 
                                 alt="Photo de profil" 
                                 class="rounded-circle border border-3" 
                                 style="width: 120px; height: 120px; object-fit: cover; border-color: #0066FF !important;">
                        @else
                            <div class="rounded-circle border border-3 d-flex align-items-center justify-content-center" 
                                 style="width: 120px; height: 120px; background-color: #f8f9fa; border-color: #0066FF !important;">
                                <i class="fas fa-user text-muted" style="font-size: 50px;"></i>
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0">
                            <span class="badge bg-success rounded-circle p-2">
                                <i class="fas fa-check" style="font-size: 10px;"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="mt-3 mb-1" style="color: #333; font-weight: 600;">{{ $talent->user->name ?? 'Nom non disponible' }}</h4>
                    <p class="text-muted mb-0" style="font-size: 14px;">{{ $talent->familleMetier->nom ?? 'Métier non spécifié' }}</p>
                </div>
                
                <!-- Informations personnelles -->
                <div class="col-md-4 mb-3">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-user me-2" style="color: #0066FF;"></i>Informations personnelles</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Email</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->user->email ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Téléphone</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->telephone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Date de naissance</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->date_naissance ? \Carbon\Carbon::parse($talent->date_naissance)->format('d/m/Y') : 'Non renseignée' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Lieu de naissance</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->lieu_naissance ?? 'Non renseigné' }}</span>
                    </div>
                </div>
                
                <!-- Informations de contact et localisation -->
                <div class="col-md-5 mb-3">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-map-marker-alt me-2" style="color: #0066FF;"></i>Localisation & Contact</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Adresse</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->adresse ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Ville</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->ville ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Nationalité</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->nationalite ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Situation matrimoniale</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->situation_matrimoniale ?? 'Non renseignée' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profil professionnel -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-briefcase me-2" style="color: #0066FF;"></i>Profil professionnel</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Pôle</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->pole->nom ?? 'Non spécifié' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Famille de métier</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->familleMetier->nom ?? 'Non spécifiée' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Niveau de diplôme</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->niveauDiplome->nom ?? 'Non spécifié' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Années d'expérience</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->annees_experience ?? 'Non renseignées' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Salaire souhaité</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->salaire_souhaite ? number_format($talent->salaire_souhaite, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Disponibilité</small>
                        <span style="font-size: 14px; color: #333;">{{ $talent->disponibilite ?? 'Non renseignée' }}</span>
                    </div>
                </div>
            </div>
            
            @if($talent->bio)
            <div class="mt-3">
                <small class="text-muted d-block mb-2" style="font-size: 12px;">Biographie</small>
                <p class="mb-0" style="font-size: 14px; color: #333; line-height: 1.5;">{{ $talent->bio }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Expériences professionnelles -->
            @if($talent->experiencesProfessionnelles && $talent->experiencesProfessionnelles->count() > 0)
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-building me-2" style="color: #0066FF;"></i>Expériences professionnelles</h6>
                    @foreach($talent->experiencesProfessionnelles as $experience)
                    <div class="border-bottom pb-3 mb-3">
                        <h6 style="color: #333; font-weight: 600; font-size: 15px;">{{ $experience->poste }}</h6>
                        <p class="mb-1" style="font-weight: 500; font-size: 14px; color: #666;">{{ $experience->entreprise }}</p>
                        <p class="text-muted mb-2" style="font-size: 13px;">
                            {{ \Carbon\Carbon::parse($experience->date_debut)->format('m/Y') }} - 
                            {{ $experience->date_fin ? \Carbon\Carbon::parse($experience->date_fin)->format('m/Y') : 'En cours' }}
                        </p>
                        @if($experience->description)
                        <p style="font-size: 14px; color: #333; line-height: 1.5;">{{ $experience->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Formations -->
            @if($talent->formations && $talent->formations->count() > 0)
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-graduation-cap me-2" style="color: #0066FF;"></i>Formations</h6>
                    @foreach($talent->formations as $formation)
                    <div class="border-bottom pb-3 mb-3">
                        <h6 style="color: #333; font-weight: 600; font-size: 15px;">{{ $formation->diplome }}</h6>
                        <p class="mb-1" style="font-weight: 500; font-size: 14px; color: #666;">{{ $formation->etablissement }}</p>
                        <p class="text-muted mb-2" style="font-size: 13px;">{{ $formation->annee_obtention }}</p>
                        @if($formation->mention)
                        <p style="font-size: 14px; color: #333;"><strong>Mention:</strong> {{ $formation->mention }}</p>
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
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-chart-line me-2" style="color: #0066FF;"></i>Statistiques</h6>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="fw-bold h4" style="color: #0066FF;">{{ $talent->candidatures->count() }}</div>
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
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-cog me-2" style="color: #0066FF;"></i>Compétences</h6>
                    <div class="d-flex flex-wrap">
                        @foreach($talent->competences as $competence)
                        <span class="badge me-2 mb-2" style="background-color: #f8f9fa; color: #333; border: 1px solid #e0e0e0; font-size: 12px; padding: 6px 12px; border-radius: 20px;">{{ $competence->nom }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Langues -->
            @if($talent->langues && $talent->langues->count() > 0)
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-language me-2" style="color: #0066FF;"></i>Langues</h6>
                    @foreach($talent->langues as $langue)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span style="font-size: 14px; color: #333;">{{ $langue->nom }}</span>
                        <span class="badge" style="background-color: #0066FF; font-size: 11px;">{{ $langue->niveau }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-bolt me-2" style="color: #0066FF;"></i>Actions</h6>
                    <div class="d-grid">
                        <button class="btn px-4 py-3 mb-2" onclick="linkToOffer({{ $talent->id }})" 
                                style="background-color: #007bff; color: white; border-radius: 25px; font-weight: 500; font-size: 14px; border: none;">
                            <i class="fas fa-link me-1"></i>Lier à une offre
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour lier à une offre -->
<div class="modal fade" id="linkOfferModal" tabindex="-1" aria-labelledby="linkOfferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e0e0e0;">
                <h5 class="modal-title" id="linkOfferModalLabel" style="color: #333; font-weight: 600;">Lier le talent à une offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="linkOfferForm">
                    @csrf
                    <input type="hidden" id="talent_id" name="talent_id" value="{{ $talent->id }}">
                    <div class="mb-3">
                        <label for="offre_id" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Sélectionner une offre d'emploi</label>
                        <select class="form-select" id="offre_id" name="offre_id" required
                                style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px; border-radius: 8px;">
                            <option value="">Choisir une offre...</option>
                            @if(Auth::user()->entreprise && Auth::user()->entreprise->offresEmploi)
                                @foreach(Auth::user()->entreprise->offresEmploi->where('statut', 'publiee') as $offre)
                                    <option value="{{ $offre->id }}">{{ $offre->titre }} - {{ $offre->lieu_poste }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="alert alert-info border-0" style="background-color: #e7f3ff; border-radius: 8px;">
                        <i class="fas fa-info-circle me-2"></i>
                        Le talent sera automatiquement ajouté aux candidatures de l'offre sélectionnée.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0;">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 20px;">Annuler</button>
                <button type="button" class="btn" onclick="submitLinkOffer()" 
                        style="background-color: #007bff; color: white; border-radius: 20px; border: none; padding: 8px 24px;">Lier à l'offre</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    window.scrollTo({ top: 0, behavior: 'uxsage' });
    
    // Masquer automatiquement après 7 secondes (plus long pour les erreurs)
    setTimeout(() => {
        errorDiv.classList.remove('show');
        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 150);
    }, 7000);
}
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        transition: all 0.2s ease;
    }
    
    .card {
        transition: box-shadow 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }

    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        
        .card-body {
            padding: 20px !important;
        }
        
        .row > .col-md-3,
        .row > .col-md-4,
        .row > .col-md-5,
        .row > .col-md-6 {
            margin-bottom: 20px;
        }
    }
</style>
@endsection