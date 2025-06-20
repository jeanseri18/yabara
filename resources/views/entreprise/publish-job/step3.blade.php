@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 3')
@section('page-title', 'Publier une offre d\'emploi')

@section('content')
<div class="container-fluid">
    <!-- Progress Steps -->
    <div class="progress-steps mb-5">
        <div class="step completed">
            <div class="step-number"><i class="bi bi-check"></i></div>
            <div class="step-title">Informations générales</div>
        </div>
        <div class="step completed">
            <div class="step-number"><i class="bi bi-check"></i></div>
            <div class="step-title">Critères & Exigences</div>
        </div>
        <div class="step active">
            <div class="step-number">3</div>
            <div class="step-title">Validation & Publication</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="mb-0 text-center" style="color: #283C5A;">
                        <i class="bi bi-eye me-2"></i>
                        Étape 3 : Validation et publication
                    </h4>
                    <p class="text-muted text-center mb-0 mt-2">Vérifiez les informations et publiez votre offre d'emploi</p>
                </div>
                <div class="card-body p-5">
                    <!-- Aperçu de l'offre -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border rounded-3 p-4 mb-4" style="background-color: #f8f9fa;">
                                <h5 class="fw-bold mb-3" style="color: #283C5A;">
                                    <i class="bi bi-file-text me-2"></i>
                                    Aperçu de votre offre
                                </h5>
                                
                                <!-- Titre et informations principales -->
                                <div class="mb-4">
                                    <h3 class="fw-bold mb-2" style="color: #283C5A;">{{ $offre->titre }}</h3>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-primary px-3 py-2">{{ $offre->typeContrat->nom ?? 'Type non défini' }}</span>
                                        <span class="badge bg-secondary px-3 py-2">{{ $offre->pole->nom ?? 'Pôle non défini' }}</span>
                                        <span class="badge bg-info px-3 py-2">{{ $offre->familleMetier->nom ?? 'Métier non défini' }}</span>
                                    </div>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $offre->lieu_poste ?? 'Lieu non défini' }}
                                    </p>
                                    @if($offre->remuneration)
                                        <p class="text-success fw-bold mb-2">
                                            <i class="bi bi-currency-euro me-1"></i>
                                            {{ number_format($offre->remuneration, 0, ',', ' ') }} € / an
                                        </p>
                                    @endif
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-2">Description du poste</h6>
                                    <div class="text-muted" style="white-space: pre-line;">{{ $offre->descriptif }}</div>
                                </div>

                                <!-- Exigences -->
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-3">Exigences du poste</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <i class="bi bi-mortarboard me-2" style="color: #f6cd45;"></i>
                                                <strong>Diplôme :</strong> {{ $offre->niveauDiplome->nom ?? 'Non défini' }}
                                            </p>
                                            <p class="mb-2">
                                                <i class="bi bi-clock-history me-2" style="color: #f6cd45;"></i>
                                                <strong>Expérience :</strong> 
                                                @if($offre->experience_minimum == 0)
                                                    Débutant accepté
                                                @else
                                                    {{ $offre->experience_minimum }} an(s) minimum
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($offre->teletravail || $offre->mobilite_requise)
                                                <p class="mb-2">
                                                    <i class="bi bi-laptop me-2" style="color: #f6cd45;"></i>
                                                    <strong>Modalités :</strong>
                                                    @if($offre->teletravail)
                                                        <span class="badge bg-success ms-1">Télétravail</span>
                                                    @endif
                                                    @if($offre->mobilite_requise)
                                                        <span class="badge bg-warning ms-1">Mobilité requise</span>
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($offre->competences_recherchees)
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Compétences recherchées</h6>
                                        <div class="text-muted" style="white-space: pre-line;">{{ $offre->competences_recherchees }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Panneau de publication -->
                        <div class="col-lg-4">
                            <div class="card border-0" style="background-color: #f8f9fa;">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3" style="color: #283C5A;">
                                        <i class="bi bi-rocket me-2"></i>
                                        Publication de l'offre
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted">Statut actuel</small>
                                        <p class="fw-bold mb-0">
                                            @if($offre->statut === 'brouillon')
                                                <span class="badge bg-warning">Brouillon</span>
                                            @elseif($offre->statut === 'publiee')
                                                <span class="badge bg-success">Publiée</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if($offre->statut === 'brouillon')
                                        <div class="mb-3">
                                            <small class="text-muted">Après publication</small>
                                            <ul class="list-unstyled small mt-2">
                                                <li><i class="bi bi-check text-success me-2"></i>Visible par les talents</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Référence automatique</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Statistiques de vues</li>
                                                <li><i class="bi bi-check text-success me-2"></i>Réception de candidatures</li>
                                            </ul>
                                        </div>

                                        <div class="mb-3">
                                            <label for="duree_publication" class="form-label fw-bold">Durée de publication</label>
                                            <select class="form-select" id="duree_publication" name="duree_publication">
                                                <option value="30">30 jours</option>
                                                <option value="60" selected>60 jours</option>
                                                <option value="90">90 jours</option>
                                            </select>
                                        </div>

                                        <div class="alert alert-info border-0 small">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Vous pourrez modifier ou désactiver cette offre à tout moment depuis votre tableau de bord.
                                        </div>
                                    @endif

                                    @if($offre->reference_offre)
                                        <div class="mb-3">
                                            <small class="text-muted">Référence</small>
                                            <p class="fw-bold mb-0">{{ $offre->reference_offre }}</p>
                                        </div>
                                    @endif

                                    @if($offre->date_publication)
                                        <div class="mb-3">
                                            <small class="text-muted">Date de publication</small>
                                            <p class="fw-bold mb-0">{{ $offre->date_publication->format('d/m/Y à H:i') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions de modification -->
                            <div class="mt-3">
                                <h6 class="fw-bold mb-3" style="color: #283C5A;">
                                    <i class="bi bi-pencil me-2"></i>
                                    Modifications
                                </h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('entreprise.offres.publier.step1', $offre->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil me-2"></i>
                                        Modifier les informations
                                    </a>
                                    <a href="{{ route('entreprise.offres.publier.step2', $offre->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-list-check me-2"></i>
                                        Modifier les critères
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('entreprise.offres.publier.step2', $offre->id) }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour
                            </a>
                        <div>
                            @if($offre->statut === 'brouillon')
                                <button type="button" class="btn btn-outline-primary btn-lg px-4 me-3" id="saveAsDraft">
                                    <i class="bi bi-save me-2"></i>
                                    Sauvegarder en brouillon
                                </button>
                                <button type="button" class="btn btn-lg px-5" style="background-color: #28a745; color: white;" id="publishOffer">
                                    <i class="bi bi-rocket me-2"></i>
                                    Publier l'offre
                                </button>
                            @else
                                <a href="{{ route('entreprise.offres.index') }}" class="btn btn-lg px-5" style="background-color: #283C5A; color: white;">
                                    <i class="bi bi-list me-2"></i>
                                    Voir mes offres
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de publication -->
<div class="modal fade" id="confirmPublishModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" style="color: #283C5A;">
                    <i class="bi bi-rocket me-2"></i>
                    Confirmer la publication
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir publier cette offre d'emploi ?</p>
                <div class="alert alert-info border-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Une fois publiée, votre offre sera visible par tous les talents de la plateforme et vous commencerez à recevoir des candidatures.
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn" style="background-color: #28a745; color: white;" id="confirmPublish">
                    <i class="bi bi-rocket me-2"></i>
                    Publier maintenant
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center py-5">
                <div class="spinner-border" style="color: #283C5A;" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3 mb-0" id="loadingText">Traitement en cours...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de succès -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle" style="font-size: 4rem; color: #28a745;"></i>
                </div>
                <h4 class="fw-bold mb-3" style="color: #283C5A;">Offre publiée avec succès !</h4>
                <p class="text-muted mb-4">Votre offre d'emploi est maintenant visible par tous les talents de YABARA.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('entreprise.offres.index') }}" class="btn btn-lg" style="background-color: #283C5A; color: white;">
                        <i class="bi bi-list me-2"></i>
                        Voir mes offres
                    </a>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Publication de l'offre
    $('#publishOffer').click(function() {
        $('#confirmPublishModal').modal('show');
    });

    $('#confirmPublish').click(function() {
        $('#confirmPublishModal').modal('hide');
        $('#loadingModal').modal('show');
        $('#loadingText').text('Publication en cours...');
        
        const dureePublication = $('#duree_publication').val();
        
        $.ajax({
            url: '{{ route("entreprise.offres.publish", $offre->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'publier',
                duree_publication: dureePublication
            },
            success: function(response) {
                $('#loadingModal').modal('hide');
                
                if (response.success) {
                    $('#successModal').modal('show');
                }
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                
                let errorMessage = 'Une erreur est survenue lors de la publication.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                alert(errorMessage);
            }
        });
    });

    // Sauvegarde en brouillon
    $('#saveAsDraft').click(function() {
        $('#loadingModal').modal('show');
        $('#loadingText').text('Sauvegarde en cours...');
        
        $.ajax({
            url: '{{ route("entreprise.offres.publish", $offre->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'sauvegarder'
            },
            success: function(response) {
                $('#loadingModal').modal('hide');
                
                // Afficher un message de succès
                const alert = $(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        Votre offre a été sauvegardée en brouillon.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                
                $('.card-body').prepend(alert);
                
                // Faire défiler vers le haut
                $('html, body').animate({ scrollTop: 0 }, 500);
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                alert('Erreur lors de la sauvegarde. Veuillez réessayer.');
            }
        });
    });
});
</script>
@endpush