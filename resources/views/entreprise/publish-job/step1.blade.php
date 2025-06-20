@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 1')
@section('page-title', 'Publier une offre d\'emploi')

@section('content')
<div class="container-fluid">
    <!-- Progress Steps -->
    <div class="progress-steps mb-5">
        <div class="step active">
            <div class="step-number">1</div>
            <div class="step-title">Informations générales</div>
        </div>
        <div class="step">
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
                        <i class="bi bi-briefcase me-2"></i>
                        Étape 1 : Informations générales de l'offre
                    </h4>
                    <p class="text-muted text-center mb-0 mt-2">Décrivez votre offre d'emploi et définissez le poste</p>
                </div>
                <div class="card-body p-5">
                    <form id="step1Form">
                        @csrf
                        
                        <!-- Titre du poste -->
                        <div class="mb-4">
                            <label for="titre" class="form-label fw-bold">
                                <i class="bi bi-tag me-2" style="color: #f6cd45;"></i>
                                Titre du poste *
                            </label>
                            <input type="text" class="form-control form-control-lg" id="titre" name="titre" 
                                   placeholder="Ex: Développeur Full Stack, Chef de projet, Commercial..." 
                                   value="{{ old('titre', $offre->titre ?? '') }}" required>
                            <div class="form-text">Soyez précis et attractif dans le titre</div>
                        </div>

                        <!-- Description du poste -->
                        <div class="mb-4">
                            <label for="descriptif" class="form-label fw-bold">
                                <i class="bi bi-file-text me-2" style="color: #f6cd45;"></i>
                                Description du poste *
                            </label>
                            <textarea class="form-control" id="descriptif" name="descriptif" rows="8" 
                                      placeholder="Décrivez les missions, responsabilités, environnement de travail..." required>{{ old('descriptif', $offre->descriptif ?? '') }}</textarea>
                            <div class="form-text">
                                <span id="charCount">0</span>/2000 caractères (minimum 150 caractères)
                            </div>
                        </div>

                        <!-- Type de contrat -->
                        <div class="mb-4">
                            <label for="type_contrat_id" class="form-label fw-bold">
                                <i class="bi bi-file-earmark-text me-2" style="color: #f6cd45;"></i>
                                Type de contrat *
                            </label>
                            <select class="form-select form-select-lg" id="type_contrat_id" name="type_contrat_id" required>
                                <option value="">Sélectionnez le type de contrat</option>
                                @foreach($typesContrat as $type)
                                    <option value="{{ $type->id }}" {{ old('type_contrat_id', $offre->type_contrat_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pôle d'activité -->
                        <div class="mb-4">
                            <label for="pole_id" class="form-label fw-bold">
                                <i class="bi bi-diagram-3 me-2" style="color: #f6cd45;"></i>
                                Pôle d'activité *
                            </label>
                            <select class="form-select form-select-lg" id="pole_id" name="pole_id" required>
                                <option value="">Sélectionnez un pôle d'activité</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}" {{ old('pole_id', $offre->pole_id ?? '') == $pole->id ? 'selected' : '' }}>
                                        {{ $pole->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Famille de métier -->
                        <div class="mb-4">
                            <label for="famille_metier_id" class="form-label fw-bold">
                                <i class="bi bi-people me-2" style="color: #f6cd45;"></i>
                                Famille de métier *
                            </label>
                            <select class="form-select form-select-lg" id="famille_metier_id" name="famille_metier_id" required {{ !$offre || !$offre->pole_id ? 'disabled' : '' }}>
                                @if($offre && $offre->familleMetier)
                                    <option value="{{ $offre->famille_metier_id }}" selected>{{ $offre->familleMetier->nom }}</option>
                                @else
                                    <option value="">Sélectionnez d'abord un pôle d'activité</option>
                                @endif
                            </select>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour
                            </a>
                            <button type="submit" class="btn btn-lg px-5" style="background-color: #283C5A; color: white;">
                                Continuer
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
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
<script>$(document).ready(function() {
    // Initialiser le compteur de caractères
    function updateCharCount() {
        const count = $('#descriptif').val().length;
        $('#charCount').text(count);
        
        if (count < 150) {
            $('#charCount').removeClass('text-success').addClass('text-danger');
        } else {
            $('#charCount').removeClass('text-danger').addClass('text-success');
        }
    }
    
    // Compteur de caractères pour la description
    $('#descriptif').on('input', updateCharCount);
    
    // Initialiser le compteur au chargement
    updateCharCount();

    // Chargement des familles de métiers selon le pôle sélectionné
    $('#pole_id').change(function() {
        console.log('Pôle changé');
        const poleId = $(this).val();
        const familleSelect = $('#famille_metier_id');
        
        console.log('Pôle sélectionné:', poleId); // Debug
        
        if (poleId) {
            familleSelect.prop('disabled', true).html('<option value="">Chargement...</option>');
            
            // Ajouter le token CSRF et améliorer la gestion d'erreur
            $.ajax({
                url: `/api/entreprise/familles-metiers/${poleId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    console.log('Données reçues:', data); // Debug
                    
                    let options = '<option value="">Sélectionnez une famille de métier</option>';
                    
                    // Vérifier si data est un tableau
                    if (Array.isArray(data)) {
                        data.forEach(function(famille) {
                            options += `<option value="${famille.id}">${famille.nom}</option>`;
                        });
                    } else if (data.familles && Array.isArray(data.familles)) {
                        // Si les données sont dans une propriété 'familles'
                        data.familles.forEach(function(famille) {
                            options += `<option value="${famille.id}">${famille.nom}</option>`;
                        });
                    } else {
                        console.error('Format de données inattendu:', data);
                        options = '<option value="">Aucune famille disponible</option>';
                    }
                    
                    familleSelect.html(options).prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', xhr.status, xhr.responseText); // Debug détaillé
                    
                    let errorMessage = 'Erreur de chargement';
                    if (xhr.status === 404) {
                        errorMessage = 'Endpoint introuvable (404)';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Erreur serveur (500)';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Accès interdit (403)';
                    }
                    
                    familleSelect.html(`<option value="">${errorMessage}</option>`);
                }
            });
        } else {
            familleSelect.prop('disabled', true).html('<option value="">Sélectionnez d\'abord un pôle d\'activité</option>');
        }
    });

    // Soumission du formulaire
    $('#step1Form').submit(function(e) {
        e.preventDefault();
        
        // Validation de la description
        const descriptif = $('#descriptif').val();
        if (descriptif.length < 150) {
            alert('La description doit contenir au minimum 150 caractères.');
            return;
        }
        
        $('#loadingModal').modal('show');
        
        $.ajax({
            url: '{{ route("entreprise.offres.save.step1") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = `/entreprise/offres/publier/etape2/${response.offre_id}`;
                }
            },
            error: function(xhr) {
                $('#loadingModal').modal('hide');
                
                console.error('Erreur lors de la soumission:', xhr.status, xhr.responseText);
                
                if (xhr.status === 422) {
                    const response = xhr.responseJSON;
                    let errorMessage = response.message || 'Erreur de validation';
                    
                    if (response.errors) {
                        errorMessage += ':\n';
                        Object.keys(response.errors).forEach(function(key) {
                            errorMessage += `- ${response.errors[key][0]}\n`;
                        });
                    }
                    
                    alert(errorMessage);
                } else if (xhr.status === 500) {
                    const response = xhr.responseJSON;
                    const message = response && response.message ? response.message : 'Erreur serveur. Veuillez réessayer.';
                    alert(message);
                } else {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            }
        });
    });
});
</script>
@endpush