@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 2/3')

@section('content')
<div class="container-fluid px-4">
    <!-- Indicateur de progression -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress-steps">
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-title">Informations générales</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-title">Spécificités du poste</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-title">Résumé & Publication</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Résumé étape 1 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-1"><i class="fas fa-briefcase text-primary me-2"></i>{{ $offre->titre }}</h6>
                            <small class="text-muted">{{ $offre->typeContrat->nom ?? 'Type de contrat' }} • {{ $offre->familleMetier->nom ?? 'Famille métier' }}</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('entreprise.offres.publier.step1') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire Étape 2 -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-cogs text-primary me-2"></i>Spécificités du poste</h5>
                </div>
                <div class="card-body p-4">
                    <form id="step2Form">
                        @csrf
                        
                        <!-- Niveau de diplôme requis -->
                        <div class="mb-5">
                            <label class="form-label fw-bold mb-3">Niveau de diplôme requis <span class="text-danger">*</span></label>
                            <div class="diploma-slider">
                                <div class="slider-track">
                                    @foreach($niveauxDiplome as $index => $niveau)
                                    <div class="slider-step" data-value="{{ $niveau->id }}" data-level="{{ $niveau->niveau }}">
                                        <div class="step-dot"></div>
                                        <div class="step-label">{{ $niveau->nom }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="hidden" id="niveau_diplome_requis" name="niveau_diplome_requis" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Expérience minimum -->
                        <div class="mb-5">
                            <label class="form-label fw-bold mb-3">Expérience minimum requise <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="experience-card" data-value="0">
                                        <div class="card-icon">
                                            <i class="fas fa-seedling"></i>
                                        </div>
                                        <div class="card-title">Débutant</div>
                                        <div class="card-subtitle">0 an</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="experience-card" data-value="1">
                                        <div class="card-icon">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                        <div class="card-title">Junior</div>
                                        <div class="card-subtitle">1-2 ans</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="experience-card" data-value="3">
                                        <div class="card-icon">
                                            <i class="fas fa-tree"></i>
                                        </div>
                                        <div class="card-title">Confirmé</div>
                                        <div class="card-subtitle">3-5 ans</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="experience-card" data-value="6">
                                        <div class="card-icon">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                        <div class="card-title">Senior</div>
                                        <div class="card-subtitle">6+ ans</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="experience_minimum" name="experience_minimum" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Rémunération -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-bold mb-0">Rémunération (optionnel)</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="showSalary">
                                    <label class="form-check-label" for="showSalary">Afficher publiquement</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">FCFA</span>
                                <input type="number" class="form-control" id="remuneration" name="remuneration" 
                                       placeholder="Ex: 500000" min="0" step="1000">
                                <span class="input-group-text">/ mois</span>
                            </div>
                            <div class="form-text">La rémunération peut être masquée aux candidats si vous le souhaitez</div>
                        </div>

                        <!-- Lieu de poste -->
                        <div class="mb-4">
                            <label for="lieu_poste" class="form-label fw-bold">Lieu du poste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="lieu_poste" name="lieu_poste" 
                                   placeholder="Ex: Douala, Cameroun" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Options télétravail et mobilité -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">Options de travail</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card h-100 option-card" data-option="teletravail">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-home fa-2x text-primary mb-3"></i>
                                            <h6 class="card-title">Télétravail possible</h6>
                                            <p class="card-text small text-muted">Le poste peut être exercé à distance</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="teletravail" name="teletravail" value="1">
                                                <label class="form-check-label" for="teletravail">Autoriser le télétravail</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 option-card" data-option="mobilite">
                                        <div class="card-body text-center p-4">
                                            <i class="fas fa-plane fa-2x text-primary mb-3"></i>
                                            <h6 class="card-title">Mobilité requise</h6>
                                            <p class="card-text small text-muted">Le poste nécessite des déplacements</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="mobilite_requise" name="mobilite_requise" value="1">
                                                <label class="form-check-label" for="mobilite_requise">Mobilité nécessaire</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('entreprise.offres.publier.step1') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Étape précédente
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="nextBtn" disabled>
                                Étape suivante <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-sauvegarde indicator -->
<div class="position-fixed bottom-0 end-0 p-3">
    <div class="toast" id="autoSaveToast" role="alert">
        <div class="toast-body">
            <i class="fas fa-save text-success me-2"></i>Sauvegarde automatique effectuée
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.progress-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    max-width: 200px;
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: 60%;
    width: 100%;
    height: 2px;
    background: #dee2e6;
    z-index: 1;
}

.step.active:not(:last-child)::after,
.step.completed:not(:last-child)::after {
    background: #0d6efd;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #dee2e6;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.step.active .step-number {
    background: #0d6efd;
    color: white;
}

.step.completed .step-number {
    background: #198754;
    color: white;
}

.step-title {
    font-size: 0.875rem;
    text-align: center;
    color: #6c757d;
}

.step.active .step-title,
.step.completed .step-title {
    color: #0d6efd;
    font-weight: 600;
}

.diploma-slider {
    position: relative;
    padding: 20px 0;
}

.slider-track {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.slider-track::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 4px;
    background: #dee2e6;
    transform: translateY(-50%);
    z-index: 1;
}

.slider-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    position: relative;
    z-index: 2;
}

.step-dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #dee2e6;
    transition: all 0.3s ease;
    margin-bottom: 8px;
}

.slider-step:hover .step-dot,
.slider-step.active .step-dot {
    border-color: #0d6efd;
    background: #0d6efd;
}

.step-label {
    font-size: 0.75rem;
    text-align: center;
    color: #6c757d;
    max-width: 80px;
}

.slider-step.active .step-label {
    color: #0d6efd;
    font-weight: 600;
}

.experience-card {
    border: 2px solid #dee2e6;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.experience-card:hover {
    border-color: #0d6efd;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}

.experience-card.selected {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.card-icon {
    font-size: 2rem;
    color: #6c757d;
    margin-bottom: 12px;
}

.experience-card.selected .card-icon {
    color: #0d6efd;
}

.card-title {
    font-weight: 600;
    margin-bottom: 4px;
    color: #212529;
}

.card-subtitle {
    font-size: 0.875rem;
    color: #6c757d;
}

.option-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.option-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
}

.option-card.checked {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let autoSaveTimeout;
    
    // Sélection du niveau de diplôme
    $('.slider-step').on('click', function() {
        $('.slider-step').removeClass('active');
        $(this).addClass('active');
        $('#niveau_diplome_requis').val($(this).data('value'));
        validateForm();
        scheduleAutoSave();
    });
    
    // Sélection de l'expérience
    $('.experience-card').on('click', function() {
        $('.experience-card').removeClass('selected');
        $(this).addClass('selected');
        $('#experience_minimum').val($(this).data('value'));
        validateForm();
        scheduleAutoSave();
    });
    
    // Gestion des options de travail
    $('input[type="checkbox"]').on('change', function() {
        const card = $(this).closest('.option-card');
        if ($(this).is(':checked')) {
            card.addClass('checked');
        } else {
            card.removeClass('checked');
        }
        scheduleAutoSave();
    });
    
    // Validation en temps réel
    $('#lieu_poste, #remuneration').on('input', function() {
        validateForm();
        scheduleAutoSave();
    });
    
    // Validation du formulaire
    function validateForm() {
        const niveauDiplome = $('#niveau_diplome_requis').val();
        const experience = $('#experience_minimum').val();
        const lieu = $('#lieu_poste').val().trim();
        
        const isValid = niveauDiplome && experience !== '' && lieu.length > 0;
        
        $('#nextBtn').prop('disabled', !isValid);
    }
    
    // Auto-sauvegarde
    function scheduleAutoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(autoSave, 2000);
    }
    
    function autoSave() {
        const formData = $('#step2Form').serialize();
        
        $.post('{{ route("entreprise.offres.save.step2", $offre->id) }}', formData)
            .done(function(response) {
                if (response.success) {
                    showAutoSaveToast();
                }
            })
            .fail(function() {
                console.log('Erreur lors de la sauvegarde automatique');
            });
    }
    
    function showAutoSaveToast() {
        const toast = new bootstrap.Toast(document.getElementById('autoSaveToast'));
        toast.show();
    }
    
    // Soumission du formulaire
    $('#step2Form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.post('{{ route("entreprise.offres.save.step2", $offre->id) }}', formData)
            .done(function(response) {
                if (response.success) {
                    window.location.href = '{{ route("entreprise.offres.publier.step3", $offre->id) }}';
                }
            })
            .fail(function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                
                // Afficher les erreurs
                Object.keys(errors).forEach(function(field) {
                    const input = $(`[name="${field}"]`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(errors[field][0]);
                });
            });
    });
});
</script>
@endpush