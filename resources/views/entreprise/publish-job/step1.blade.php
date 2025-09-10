@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 1')
@section('page-title', 'Publier une offre d\'emploi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header avec bouton retour -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="mb-0" style="color: #ff6b35; font-weight: 600;">Publier une offre d'emploi</h2>
            <p class="text-muted mb-0">Créez votre offre en 3 étapes simples</p>
        </div>
    </div>

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
            <div class="card shadow-sm border-0" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;">
                <div class="card-header bg-white border-0 py-4" style="border-radius: 15px 15px 0 0;">
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #ff6b35, #f7931e); border-radius: 50%;">
                            <i class="bi bi-briefcase text-white" style="font-size: 24px;"></i>
                        </div>
                        <h4 class="mb-2" style="color: #2c3e50; font-weight: 600;">Étape 1 : Informations générales</h4>
                        <p class="text-muted mb-0">Décrivez votre offre d'emploi et définissez le poste</p>
                    </div>
                </div>
                <div class="card-body p-5">
                    <form id="step1Form">
                        @csrf
                        
                        <!-- Titre du poste -->
                        <div class="mb-4">
                            <label for="titre" class="form-label fw-bold">
                                🏷️
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
                                📝
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
                            <label class="form-label fw-bold">
                                📄
                                Type de contrat *
                            </label>
                            <div class="row g-3">
                                @foreach($typesContrat as $type)
                                    <div class="col-md-6">
                                        <div class="card contract-card h-100" data-value="{{ $type->id }}" 
                                             style="cursor: pointer; transition: all 0.3s ease; {{ old('type_contrat_id', $offre->type_contrat_id ?? '') == $type->id ? 'border-color: #0066FF; background-color: #f8f9ff;' : 'border-color: #dee2e6;' }}">
                                            <div class="card-body text-center p-3">
                                                <h6 class="card-title mb-0" style="color: #0066FF;">{{ $type->nom }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="type_contrat_id" name="type_contrat_id" value="{{ old('type_contrat_id', $offre->type_contrat_id ?? '') }}" required>
                        </div>

                        <!-- Pôle d'activité -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                🏢
                                Pôle d'activité *
                            </label>
                            <div class="row g-3">
                                @foreach($poles as $pole)
                                    <div class="col-md-6">
                                        <div class="card pole-card h-100" data-value="{{ $pole->id }}" 
                                             style="cursor: pointer; transition: all 0.3s ease; {{ old('pole_id', $offre->pole_id ?? '') == $pole->id ? 'border-color: #0066FF; background-color: #f8f9ff;' : 'border-color: #dee2e6;' }}">
                                            <div class="card-body text-center p-3">
                                                <h6 class="card-title mb-0" style="color: #0066FF;">{{ $pole->nom }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="pole_id" name="pole_id" value="{{ old('pole_id', $offre->pole_id ?? '') }}" required>
                        </div>

                        <!-- Famille de métier -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                👥
                                Famille de métier *
                            </label>
                            <div id="famille-metier-container">
                                @if($offre && $offre->familleMetier)
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card famille-card h-100" data-value="{{ $offre->famille_metier_id }}" 
                                                 style="cursor: pointer; transition: all 0.3s ease; border-color: #0066FF; background-color: #f8f9ff;">
                                                <div class="card-body text-center p-3">
                                                    <h6 class="card-title mb-0" style="color: #0066FF;">{{ $offre->familleMetier->nom }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info text-center">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Sélectionnez d'abord un pôle d'activité
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" id="famille_metier_id" name="famille_metier_id" value="{{ old('famille_metier_id', $offre->famille_metier_id ?? '') }}" required>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour
                            </a>
                            <button type="submit" class="btn btn-lg px-5" style="background-color: #0066FF; color: white;">
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
.contract-card:hover,
.pole-card:hover,
.famille-card:hover {
    border-color: #0066FF !important;
    background-color: #f8f9ff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(20, 34, 79, 0.15);
}

.contract-card.selected,
.pole-card.selected,
.famille-card.selected {
    border-color: #0066FF !important;
    background-color: #f8f9ff !important;
    border-width: 2px;
}

.card {
    border-radius: 8px;
}

.card-body h6 {
    font-weight: 600;
}
</style>
@endpush

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

    // Gestion des cartes sélectionnables pour le type de contrat
    $('.contract-card').click(function() {
        $('.contract-card').css({
            'border-color': '#dee2e6',
            'background-color': 'white'
        });
        $(this).css({
            'border-color': '#0066FF',
            'background-color': '#f8f9ff'
        });
        $('#type_contrat_id').val($(this).data('value'));
    });

    // Gestion des cartes sélectionnables pour le pôle d'activité
    $('.pole-card').click(function() {
        $('.pole-card').css({
            'border-color': '#dee2e6',
            'background-color': 'white'
        });
        $(this).css({
            'border-color': '#0066FF',
            'background-color': '#f8f9ff'
        });
        const poleId = $(this).data('value');
        $('#pole_id').val(poleId);
        
        // Charger les familles de métiers
        loadFamillesMetiers(poleId);
    });

    // Gestion des cartes sélectionnables pour la famille de métier
    $(document).on('click', '.famille-card', function() {
        $('.famille-card').css({
            'border-color': '#dee2e6',
            'background-color': 'white'
        });
        $(this).css({
            'border-color': '#0066FF',
            'background-color': '#f8f9ff'
        });
        $('#famille_metier_id').val($(this).data('value'));
    });

    // Fonction pour charger les familles de métiers
    function loadFamillesMetiers(poleId) {
        const container = $('#famille-metier-container');
        
        if (poleId) {
            container.html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Chargement...</span></div></div>');
            
            $.ajax({
                url: `/api/entreprise/familles-metiers/${poleId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    let html = '<div class="row g-3">';
                    
                    // Vérifier si data est un tableau
                    const familles = Array.isArray(data) ? data : (data.familles || []);
                    
                    if (familles.length > 0) {
                        familles.forEach(function(famille) {
                            html += `
                                <div class="col-md-6">
                                    <div class="card famille-card h-100" data-value="${famille.id}" 
                                         style="cursor: pointer; transition: all 0.3s ease; border-color: #dee2e6;">
                                        <div class="card-body text-center p-3">
                                            <h6 class="card-title mb-0" style="color: #0066FF;">${famille.nom}</h6>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="alert alert-warning text-center"><i class="bi bi-exclamation-triangle me-2"></i>Aucune famille de métier disponible</div>';
                    }
                    
                    html += '</div>';
                    container.html(html);
                    $('#famille_metier_id').val('');
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', xhr.status, xhr.responseText);
                    
                    let errorMessage = 'Erreur de chargement';
                    if (xhr.status === 404) {
                        errorMessage = 'Endpoint introuvable (404)';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Erreur serveur (500)';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Accès interdit (403)';
                    }
                    
                    container.html(`<div class="alert alert-danger text-center"><i class="bi bi-exclamation-circle me-2"></i>${errorMessage}</div>`);
                }
            });
        } else {
            container.html('<div class="alert alert-info text-center"><i class="bi bi-info-circle me-2"></i>Sélectionnez d\'abord un pôle d\'activité</div>');
            $('#famille_metier_id').val('');
        }
    }

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

@section('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #ff6b35;
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

    .contract-card:hover, .pole-card:hover {
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
        background: linear-gradient(135deg, #ff6b35, #f7931e);
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
        color: #ff6b35;
        font-weight: 600;
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
@endsection