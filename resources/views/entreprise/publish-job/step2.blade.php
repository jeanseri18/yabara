@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 2')
@section('page-title', 'Publier une offre d\'emploi')

@section('content')
<div class="container-fluid">
    <!-- Progress Steps -->
    <div class="progress-steps mb-5">
        <div class="step completed">
            <div class="step-number"><i class="bi bi-check"></i></div>
            <div class="step-title">Informations générales</div>
        </div>
        <div class="step active">
            <div class="step-number">2</div>
            <div class="step-title">Critères & Exigences</div>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <div class="step-title">Validation & Publication</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="mb-0 text-center" style="color: #283C5A;">
                        <i class="bi bi-list-check me-2"></i>
                        Étape 2 : Critères et exigences du poste
                    </h4>
                    <p class="text-muted text-center mb-0 mt-2">Définissez les critères de sélection et les conditions du poste</p>
                </div>
                <div class="card-body p-5">
                    <!-- Résumé de l'étape 1 -->
                    <div class="alert alert-info border-0 mb-4" style="background-color: rgba(40, 60, 90, 0.1);">
                        <h6 class="fw-bold mb-2" style="color: #283C5A;">
                            <i class="bi bi-info-circle me-2"></i>
                            Récapitulatif de votre offre
                        </h6>
                        <p class="mb-1"><strong>Poste :</strong> {{ $offre->titre }}</p>
                        <p class="mb-1"><strong>Type :</strong> {{ $offre->typeContrat->nom ?? 'Non défini' }}</p>
                        <p class="mb-0"><strong>Secteur :</strong> {{ $offre->pole->nom ?? 'Non défini' }} - {{ $offre->familleMetier->nom ?? 'Non défini' }}</p>
                    </div>

                    <form id="step2Form">
                        @csrf
                        
                        <!-- Niveau de diplôme requis -->
                        <div class="mb-4">
                            <label for="niveau_diplome_requis" class="form-label fw-bold">
                                <i class="bi bi-mortarboard me-2" style="color: #f6cd45;"></i>
                                Niveau de diplôme requis *
                            </label>
                            <select class="form-select form-select-lg" id="niveau_diplome_requis" name="niveau_diplome_requis" required>
                                <option value="">Sélectionnez le niveau minimum requis</option>
                                @foreach($niveauxDiplome as $niveau)
                                    <option value="{{ $niveau->id }}" {{ old('niveau_diplome_requis', $offre->niveau_diplome_requis) == $niveau->id ? 'selected' : '' }}>
                                        {{ $niveau->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Expérience minimum -->
                        <div class="mb-4">
                            <label for="experience_minimum" class="form-label fw-bold">
                                <i class="bi bi-clock-history me-2" style="color: #f6cd45;"></i>
                                Expérience minimum requise *
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-select form-select-lg" id="experience_minimum" name="experience_minimum" required>
                                        <option value="">Sélectionnez l'expérience</option>
                                        <option value="0" {{ old('experience_minimum', $offre->experience_minimum) == '0' ? 'selected' : '' }}>Débutant accepté (0 an)</option>
                                        <option value="1" {{ old('experience_minimum', $offre->experience_minimum) == '1' ? 'selected' : '' }}>1 an minimum</option>
                                        <option value="2" {{ old('experience_minimum', $offre->experience_minimum) == '2' ? 'selected' : '' }}>2 ans minimum</option>
                                        <option value="3" {{ old('experience_minimum', $offre->experience_minimum) == '3' ? 'selected' : '' }}>3 ans minimum</option>
                                        <option value="5" {{ old('experience_minimum', $offre->experience_minimum) == '5' ? 'selected' : '' }}>5 ans minimum</option>
                                        <option value="10" {{ old('experience_minimum', $offre->experience_minimum) == '10' ? 'selected' : '' }}>10 ans et plus</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Rémunération -->
                        <div class="mb-4">
                            <label for="remuneration" class="form-label fw-bold">
                                <i class="bi bi-currency-euro me-2" style="color: #f6cd45;"></i>
                                Rémunération (optionnel)
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-lg">
                            <input type="number" class="form-control" id="remuneration" name="remuneration" 
                                   placeholder="Ex: 35000" min="0" step="1000" value="{{ old('remuneration', $offre->remuneration) }}">
                            <span class="input-group-text">€ / an</span>
                        </div>
                                    <div class="form-text">Salaire brut annuel (optionnel mais recommandé)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Lieu du poste -->
                        <div class="mb-4">
                            <label for="lieu_poste" class="form-label fw-bold">
                                <i class="bi bi-geo-alt me-2" style="color: #f6cd45;"></i>
                                Lieu du poste *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="lieu_poste" name="lieu_poste" 
                                   placeholder="Ex: Paris, Lyon, Télétravail, France entière..." 
                                   value="{{ old('lieu_poste', $offre->lieu_poste) }}" required>
                            <div class="form-text">Ville, région ou précisez si le poste est en télétravail</div>
                        </div>

                        <!-- Options de travail -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-laptop me-2" style="color: #f6cd45;"></i>
                                Modalités de travail
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="teletravail" name="teletravail" value="1" 
                                               {{ old('teletravail', $offre->teletravail) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="teletravail">
                                            Télétravail possible
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mobilite_requise" name="mobilite_requise" value="1" 
                                               {{ old('mobilite_requise', $offre->mobilite_requise) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mobilite_requise">
                                            Mobilité requise
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Compétences recherchées (optionnel) -->
                        <div class="mb-4">
                            <label for="competences_recherchees" class="form-label fw-bold">
                                <i class="bi bi-star me-2" style="color: #f6cd45;"></i>
                                Compétences clés recherchées (optionnel)
                            </label>
                            <textarea class="form-control" id="competences_recherchees" name="competences_recherchees" rows="4" 
                                      placeholder="Listez les compétences techniques et soft skills importantes pour ce poste...">{{ old('competences_recherchees', $offre->competences_recherchees) }}</textarea>
                            <div class="form-text">Ces informations aideront les candidats à mieux comprendre vos attentes</div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('entreprise.offres.publier.step1', $offre->id ?? null) }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-lg px-4 me-3" id="saveAsDraft">
                                    <i class="bi bi-save me-2"></i>
                                    Sauvegarder
                                </button>
                                <button type="submit" class="btn btn-lg px-5" style="background-color: #283C5A; color: white;">
                                    Continuer
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                <p class="mt-3 mb-0">Sauvegarde en cours...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Soumission du formulaire
    $('#step2Form').submit(function(e) {
        e.preventDefault();
        
        $('#loadingModal').modal('show');
        
        $.ajax({
            url: '{{ route("entreprise.offres.save.step2", $offre->id) }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = `/entreprise/offres/publier/etape3/{{ $offre->id }}`;
                }
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Veuillez corriger les erreurs suivantes :\n';
                    
                    Object.keys(errors).forEach(function(key) {
                        errorMessage += `- ${errors[key][0]}\n`;
                    });
                    
                    alert(errorMessage);
                } else {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            }
        });
    });

    // Sauvegarde en brouillon
    $('#saveAsDraft').click(function() {
        $('#loadingModal').modal('show');
        
        $.ajax({
            url: '{{ route("entreprise.offres.save.step2", $offre->id) }}',
            method: 'POST',
            data: $('#step2Form').serialize(),
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

    // Validation en temps réel
    $('#remuneration').on('input', function() {
        const value = parseInt($(this).val());
        if (value && value < 0) {
            $(this).val('');
        }
    });
});
</script>
@endpush