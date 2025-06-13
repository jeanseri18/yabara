@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 1/3')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête avec carte entreprise -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm text-white" style="background-color: #1040BB;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if($entreprise->logo_url)
                                <img src="{{ $entreprise->logo_url }}" alt="Logo" class="rounded-circle" width="80" height="80">
                            @else
                                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <h4 class="mb-1">{{ $entreprise->nom_entreprise }}</h4>
                            <p class="mb-1"><i class="fas fa-id-card me-2"></i>RCCM: {{ $entreprise->numero_legal }}</p>
                            <p class="mb-0"><i class="fas fa-users me-2"></i>Effectif: {{ $entreprise->effectif }} employés</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicateur de progression -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <div class="step-title">Informations générales</div>
                </div>
                <div class="step">
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

    <!-- Formulaire Étape 1 -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Informations générales</h5>
                </div>
                <div class="card-body p-4">
                    <form id="step1Form">
                        @csrf
                        
                        <!-- Titre du poste -->
                        <div class="mb-4">
                            <label for="titre" class="form-label fw-bold">Titre du poste <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="titre" name="titre" 
                                   placeholder="Ex: Développeur Full Stack Senior" maxlength="255" required>
                            <div class="form-text">Soyez précis et attractif dans le titre</div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Description du poste -->
                        <div class="mb-4">
                            <label for="descriptif" class="form-label fw-bold">Description du poste <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="descriptif" name="descriptif" rows="6" 
                                      placeholder="Décrivez les missions, responsabilités et environnement de travail..." 
                                      minlength="150" required></textarea>
                            <div class="d-flex justify-content-between">
                                <div class="form-text">Minimum 150 caractères pour une description complète</div>
                                <small class="text-muted"><span id="char-count">0</span>/150 caractères minimum</small>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Type de contrat -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Type de contrat <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                @foreach($typesContrat as $type)
                                <div class="col-md-6">
                                    <div class="card contract-card h-100" data-value="{{ $type->id }}">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-file-contract fa-2x text-primary mb-2"></i>
                                            <h6 class="card-title mb-1">{{ $type->nom }}</h6>
                                            <p class="card-text small text-muted">{{ $type->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="type_contrat_id" name="type_contrat_id" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Pôle d'activité -->
                        <div class="mb-4">
                            <label for="pole_id" class="form-label fw-bold">Pôle d'activité <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" id="pole_id" name="pole_id" required>
                                <option value="">Sélectionnez un pôle</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}">{{ $pole->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Famille de métier -->
                        <div class="mb-4">
                            <label for="famille_metier_id" class="form-label fw-bold">Famille de métier <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" id="famille_metier_id" name="famille_metier_id" required disabled>
                                <option value="">Sélectionnez d'abord un pôle</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
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

.step.active:not(:last-child)::after {
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

.step-title {
    font-size: 0.875rem;
    text-align: center;
    color: #6c757d;
}

.step.active .step-title {
    color: #0d6efd;
    font-weight: 600;
}

.contract-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.contract-card:hover {
    border-color: #0d6efd;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}

.contract-card.selected {
    border-color: #0d6efd;
    background-color: #f8f9ff;
}

.contract-card.selected .fa-file-contract {
    color: #0d6efd !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
}

#char-count {
    font-weight: 600;
}

#char-count.valid {
    color: #198754;
}

#char-count.invalid {
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let autoSaveTimeout;
    
    // Compteur de caractères
    $('#descriptif').on('input', function() {
        const count = $(this).val().length;
        const counter = $('#char-count');
        counter.text(count);
        
        if (count >= 150) {
            counter.removeClass('invalid').addClass('valid');
        } else {
            counter.removeClass('valid').addClass('invalid');
        }
        
        validateForm();
        scheduleAutoSave();
    });
    
    // Sélection du type de contrat
    $('.contract-card').on('click', function() {
        $('.contract-card').removeClass('selected');
        $(this).addClass('selected');
        $('#type_contrat_id').val($(this).data('value'));
        validateForm();
        scheduleAutoSave();
    });
    
    // Chargement des familles de métiers
    $('#pole_id').on('change', function() {
        const poleId = $(this).val();
        const familleSelect = $('#famille_metier_id');
        
        if (poleId) {
            familleSelect.prop('disabled', true).html('<option value="">Chargement...</option>');
            
            $.get(`/api/entreprise/familles-metiers/${poleId}`)
                .done(function(familles) {
                    familleSelect.html('<option value="">Sélectionnez une famille de métier</option>');
                    familles.forEach(function(famille) {
                        familleSelect.append(`<option value="${famille.id}">${famille.nom}</option>`);
                    });
                    familleSelect.prop('disabled', false);
                })
                .fail(function() {
                    familleSelect.html('<option value="">Erreur de chargement</option>');
                });
        } else {
            familleSelect.prop('disabled', true).html('<option value="">Sélectionnez d\'abord un pôle</option>');
        }
        
        validateForm();
        scheduleAutoSave();
    });
    
    // Validation en temps réel
    $('#titre, #famille_metier_id').on('change input', function() {
        validateForm();
        scheduleAutoSave();
    });
    
    // Validation du formulaire
    function validateForm() {
        const titre = $('#titre').val().trim();
        const descriptif = $('#descriptif').val().trim();
        const typeContrat = $('#type_contrat_id').val();
        const pole = $('#pole_id').val();
        const famille = $('#famille_metier_id').val();
        
        const isValid = titre.length > 0 && 
                       descriptif.length >= 150 && 
                       typeContrat && 
                       pole && 
                       famille;
        
        $('#nextBtn').prop('disabled', !isValid);
    }
    
    // Auto-sauvegarde
    function scheduleAutoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(autoSave, 2000);
    }
    
    function autoSave() {
        const formData = $('#step1Form').serialize();
        
        $.post('{{ route("entreprise.offres.save.step1") }}', formData)
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
    $('#step1Form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.post('{{ route("entreprise.offres.save.step1") }}', formData)
            .done(function(response) {
                if (response.success) {
                    window.location.href = `/entreprise/offres/publier/etape2/${response.offre_id}`;
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