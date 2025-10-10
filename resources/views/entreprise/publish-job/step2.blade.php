@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 2')
@section('page-title', 'Publier une offre d\'emploi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec bouton retour -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('entreprise.offres.publier.step1', $offre->id) }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="mb-0" style="color: #0066FF; font-weight: 600;">Publier une offre d'emploi</h2>
            <p class="text-muted mb-0">Étape 2 sur 3 - Critères et exigences</p>
        </div>
    </div>

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
            <div class="card shadow-sm border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;">
                <div class="card-header bg-white border-0 py-4" style="border-radius: 15px 15px 0 0;">
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #0066FF, #004bb5); border-radius: 50%;">
                            <i class="bi bi-list-check text-white" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="mb-2" style="color: #2c3e50; font-weight: 600;">Étape 2 : Critères et exigences</h4>
                        <p class="text-muted mb-0">Définissez les critères de sélection et les conditions du poste</p>
                    </div>
                </div>
                <div class="card-body p-5">
                    <!-- Résumé de l'étape 1 -->
                    <div class="alert alert-info border-0 mb-4" style="background-color: rgba(40, 60, 90, 0.1);">
                        <h6 class="fw-bold mb-2" style="color: #0066FF;">
                            ℹ️
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
                            <label class="form-label fw-bold">
                                🎓
                                Niveau de diplôme requis *
                            </label>
                            <div class="text-center">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    @foreach($niveauxDiplome as $niveau)
                                        <span>{{ $niveau->nom }}</span>
                                    @endforeach
                                </div>
                                <div class="position-relative">
                                    <input type="range" class="form-range w-100" id="niveau_diplome_requis" name="niveau_diplome_requis" min="1" max="{{ $niveauxDiplome->count() }}" step="1" value="{{ old('niveau_diplome_requis', $offre->niveau_diplome_requis) ?? 1 }}" required>
                                    <div class="position-absolute w-100 d-flex justify-content-between text-muted" style="top: -1.5rem; font-size: 0.875rem;">
                                        @foreach($niveauxDiplome as $niveau)
                                            <span></span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="niveau_diplome_requis_value" name="niveau_diplome_requis_value" value="{{ old('niveau_diplome_requis', $offre->niveau_diplome_requis) ?? $niveauxDiplome->first()->id }}" required>
                        </div>

                        <!-- Expérience minimum -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                ⏰
                                Expérience minimum requise *
                            </label>
                            <div class="d-flex">
                                <div class="experience-card flex-fill text-center p-3" data-value="0-2" 
                                     style="cursor: pointer; transition: all 0.3s ease; {{ old('experience_minimum', $offre->experience_minimum) == '0-2' ? 'background-color: #007bff; color: white;' : 'background-color: #FFFFFFFF; color: black;' }} border: 2px solid black; border-right: 2px solid black; opacity: 1;">
                                    <h6 class="card-title mb-0" style="{{ old('experience_minimum', $offre->experience_minimum) == '0-2' ? 'color: white;' : 'color: black;' }}">0-2 ans</h6>
                                </div>
                                <div class="experience-card flex-fill text-center p-3" data-value="3-5" 
                                     style="cursor: pointer; transition: all 0.3s ease; {{ old('experience_minimum', $offre->experience_minimum) == '3-5' ? 'background-color: #007bff; color: white;' : 'background-color: #FFFFFFFF; color: black;' }} border: 2px solid black; border-right: 2px solid black; opacity: 1;">
                                    <h6 class="card-title mb-0" style="{{ old('experience_minimum', $offre->experience_minimum) == '3-5' ? 'color: white;' : 'color: black;' }}">3-5 ans</h6>
                                </div>
                                <div class="experience-card flex-fill text-center p-3" data-value="6-10" 
                                     style="cursor: pointer; transition: all 0.3s ease; {{ old('experience_minimum', $offre->experience_minimum) == '6-10' ? 'background-color: #007bff; color: white;' : 'background-color: #FFFFFFFF; color: black;' }} border: 2px solid black; border-right: 2px solid black; opacity: 1;">
                                    <h6 class="card-title mb-0" style="{{ old('experience_minimum', $offre->experience_minimum) == '6-10' ? 'color: white;' : 'color: black;' }}">6-10 ans</h6>
                                </div>
                                <div class="experience-card flex-fill text-center p-3" data-value="10+" 
                                     style="cursor: pointer; transition: all 0.3s ease; {{ old('experience_minimum', $offre->experience_minimum) == '10+' ? 'background-color: #007bff; color: white;' : 'background-color: #FFFFFFFF; color: black;' }} border: 2px solid black; opacity: 1;">
                                    <h6 class="card-title mb-0" style="{{ old('experience_minimum', $offre->experience_minimum) == '10+' ? 'color: white;' : 'color: black;' }}">+10 ans</h6>
                                </div>
                            </div>
                            <input type="hidden" id="experience_minimum" name="experience_minimum" value="{{ old('experience_minimum', $offre->experience_minimum) }}" required>
                        </div>

                        <!-- Rémunération -->
                        <div class="mb-4">
                            <label for="remuneration" class="form-label fw-bold">
                                💰
                                Rémunération annuelle (optionnel)
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-lg">
                            <input type="number" class="form-control" id="remuneration" name="remuneration" 
                                   placeholder="Ex: 35000" min="0" step="1000" value="{{ old('remuneration', $offre->remuneration) }}">
                            <span class="input-group-text">CFA / an</span>
                        </div>
                                    <div class="form-text">Salaire brut annuel (optionnel mais recommandé)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Lieu du poste -->
                        <div class="mb-4">
                            <label for="lieu_poste" class="form-label fw-bold">
                                📍
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
                                💻
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
                                ⭐
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
                                <button type="submit" class="btn btn-lg px-5" style="background-color: #0066FF; color: white;">
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
                <div class="spinner-border" style="color: #0066FF;" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3 mb-0">Sauvegarde en cours...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.diplome-card:hover {
    border-color: #0066FF !important;
    background-color: #f8f9ff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 34, 79, 0.15);
}

.experience-card:hover {
    opacity: 1 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 34, 79, 0.15);
}

.diplome-card.selected {
    border-color: #0066FF !important;
    background-color: #f8f9ff !important;
    border-width: 2px;
}

.experience-card {
    border-radius: 0;
    margin: 0;
    padding: 10px 15px;
    border-right: 2px solid black;
}

.experience-card:first-child {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
}

.experience-card:last-child {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
    border-right: none;
}

.card {
    border-radius: 8px;
}

.card-body h6 {
    font-weight: 600;
}

#niveau_diplome_requis {
    height: 10px;
    background: linear-gradient(to right, #0066FF, #0066FF);
    border-radius: 5px;
    --thumb-size: 20px;
}

#niveau_diplome_requis::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: var(--thumb-size);
    height: var(--thumb-size);
    background: #0066FF;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

#niveau_diplome_requis::-moz-range-thumb {
    width: var(--thumb-size);
    height: var(--thumb-size);
    background: #0066FF;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

#niveau_diplome_requis::-ms-thumb {
    width: var(--thumb-size);
    height: var(--thumb-size);
    background: #0066FF;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.form-control:focus, .form-select:focus {
    border-color: #0066FF;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(255, 107, 53, 0.3);
    transition: all 0.2s ease;
}

.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
}

.diplome-card:hover, .experience-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.15) !important;
}

.progress-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-bottom: 0.5rem;
    background-color: #e9ecef;
    color: #6c757d;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background: linear-gradient(135deg, #0066FF, #0066FF);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.step.completed .step-number {
    background-color: #28a745;
    color: white;
}

.step-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    text-align: center;
}

.step.active .step-title {
    color: #0066FF;
    font-weight: 600;
}

.form-check-input:checked {
    background-color: #0066FF;
    border-color: #0066FF;
}

.form-check-input:focus {
    border-color: #0066FF;
    box-shadow: 0 0 0 0.25rem rgba(0, 102, 255, 0.25);
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    
    .card-body {
        padding: 20px !important;
    }
    
    .progress-steps {
        gap: 1rem;
    }
    
    .step-title {
        font-size: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion des cartes sélectionnables pour l'expérience minimum
    $('.experience-card').click(function() {
        // Réinitialiser toutes les cartes avec le style par défaut
        $('.experience-card').css({
            'background-color': '#FFFFFFFF',
            'color': 'black',
            'opacity': '1'
        });
        $('.experience-card h6').css('color', 'black');
        
        // Appliquer le style sélectionné à la carte cliquée
        $(this).css({
            'background-color': '#007bff',
            'color': 'white',
            'opacity': '1'
        });
        $(this).find('h6').css('color', 'white');
        
        $('#experience_minimum').val($(this).data('value'));
    });

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

    // Update hidden input value based on slider position
    $('#niveau_diplome_requis').on('input', function() {
        const value = parseInt($(this).val());
        const niveauxDiplome = @json($niveauxDiplome->pluck('id')->toArray());
        $('#niveau_diplome_requis_value').val(niveauxDiplome[value - 1]);
    });

    // Initial value set
    $('#niveau_diplome_requis').trigger('input');
});
</script>
@endpush