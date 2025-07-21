@extends('layouts.entreprise')

@section('title', 'Recherche de Talents')

@section('content')
<div class="container py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 " style="color:#14224F">🔍 Recherche de Talents</h1>
                    <p class="text-muted mb-0">Trouvez les talents qui correspondent à vos besoins</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-6">{{ $poles->count() }} pôles disponibles</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de recherche -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-funnel me-2"></i>Filtres de recherche
                    </h5>
                </div>
                <div class="card-body">
                    <form id="searchForm">
                        @csrf
                        
                        <!-- Sélection des Pôles -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="bi bi-diagram-3 me-1"></i>Pôle
                            </label>
                            <div class="row g-3" id="polesContainer">
                                <!-- Option "Tous les pôles" -->
                                <div class="col-md-6 col-lg-2">
                                    <div class="pole-card selected" data-pole-id="" data-pole-name="Tous">
                                        <div class="pole-content">
                                            <div class="pole-header">
                                                <span class="pole-number">TOUS</span>
                                            </div>
                                            <div class="pole-title">TOUS LES PÔLES</div>
                                         
                                           
                                        </div>
                                    </div>
                                </div>
                                @foreach($poles as $pole)
                                <div class="col-md-6 col-lg-2">
                                    <div class="pole-card" data-pole-id="{{ $pole->id }}" data-pole-name="{{ $pole->nom }}">
                                        <div class="pole-content">
                                            <div class="pole-header">
                                                <span class="pole-number">PÔLE {{ $pole->id }}</span>
                                            </div>
                                            <div class="pole-title">{{ strtoupper($pole->nom) }}</div>
                                            <div class="pole-subtitle">
                                                @if($pole->nom == 'TERTIAIRE')
                                                    (Services & Fonctions support)
                                                @elseif($pole->nom == 'SECONDAIRE')
                                                    (Industrie, Construction & Production)
                                                @elseif($pole->nom == 'COMMERCIAL & RELATION CLIENT')
                                                    
                                                @elseif($pole->nom == 'MÉTIERS PRATIQUES & ÉCONOMIE INFORMELLE')
                                                    
                                                @endif
                                            </div>
                                            <div class="pole-icon">
                                                @if($pole->nom == 'TERTIAIRE')
                                                    <i class="fas fa-users"></i>
                                                @elseif($pole->nom == 'SECONDAIRE')
                                                    <i class="fas fa-industry"></i>
                                                @elseif($pole->nom == 'COMMERCIAL & RELATION CLIENT')
                                                    <i class="fas fa-shield-alt"></i>
                                                @elseif($pole->nom == 'MÉTIERS PRATIQUES & ÉCONOMIE INFORMELLE')
                                                    <i class="fas fa-tools"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="pole_id" name="pole_id" value="">
                        </div>

                        <!-- Famille de métier -->
                        <div class="mb-4" id="familleMetierSection" style="display: none;">
                            <label class="form-label fw-semibold mb-3">
                                <i class="bi bi-briefcase me-1"></i>Famille de métier
                            </label>
                            <div class="row g-2" id="famillesContainer">
                                <!-- Les familles de métiers seront chargées ici -->
                            </div>
                            <input type="hidden" id="famille_metier_id" name="famille_metier_id" value="">
                        </div>

                        <!-- Années d'expérience -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="bi bi-clock-history me-1"></i>Année(s) minimum d'expériences
                            </label>
                            <div class="experience-buttons">
                                <button type="button" class="btn-experience selected" data-value="">Toutes les années</button>
                                <button type="button" class="btn-experience" data-value="0">0-2 ans</button>
                                <button type="button" class="btn-experience" data-value="3">3-5 ans</button>
                                <button type="button" class="btn-experience" data-value="6">6-10 ans</button>
                                <button type="button" class="btn-experience" data-value="10">+10 ans</button>
                            </div>
                            <input type="hidden" id="experience_min" name="experience_min" value="">
                        </div>

                        <!-- Niveau de diplôme -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="bi bi-mortarboard me-1"></i>Niveau de diplôme
                            </label>
                            <div class="diploma-slider-container">
                                <input type="range" id="diplomaRange" min="-1" max="{{ $niveauxDiplome->count() - 1 }}" value="-1" class="diploma-slider">
                                <div class="slider-labels">
                                    <span class="slider-label" data-value="">Tous</span>
                                    @foreach($niveauxDiplome as $index => $niveau)
                                        <span class="slider-label" data-value="{{ $niveau->id }}">{{ $niveau->nom }}</span>
                                    @endforeach
                                </div>
                                <div class="selected-diploma">
                                    <strong id="selectedDiploma">Tous les diplômes</strong>
                                </div>
                            </div>
                            <input type="hidden" id="niveau_diplome" name="niveau_diplome" value="">
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-search me-2"></i>Afficher les résultats
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 ms-3" id="resetForm">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone de chargement -->
    <div id="loadingSection" class="row mb-4" style="display: none;">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3 text-muted">Recherche en cours...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Résultats de recherche -->
    <div id="resultsSection" class="row" style="display: none;">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people me-2"></i>Résultats de recherche
                        </h5>
                        <span id="resultsCount" class="badge bg-primary fs-6"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="talentsGrid" class="row g-4">
                        <!-- Les résultats seront chargés ici via AJAX -->
                    </div>
                    
                    <!-- Pagination -->
                    <div id="paginationContainer" class="d-flex justify-content-center mt-4">
                        <!-- La pagination sera chargée ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message aucun résultat -->
    <div id="noResultsSection" class="row" style="display: none;">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body text-center py-5">
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">Aucun talent trouvé</h4>
                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour lier un talent à une offre -->
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
                        <input type="hidden" id="talent_id" name="talent_id" value="">
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

    <!-- Zone d'affichage des messages -->
    <div id="successMessage" class="alert alert-success alert-dismissible fade" role="alert" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1060; min-width: 300px;">
        <i class="bi bi-check-circle me-2"></i>
        <span id="successText"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="errorMessage" class="alert alert-danger alert-dismissible fade" role="alert" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 1060; min-width: 300px;">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <span id="errorText"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion de la sélection des pôles
    $('.pole-card').click(function() {
        // Désélectionner toutes les autres cartes
        $('.pole-card').removeClass('selected');
        // Sélectionner la carte cliquée
        $(this).addClass('selected');
        
        const poleId = $(this).data('pole-id');
        const poleName = $(this).data('pole-name');
        $('#pole_id').val(poleId);
        
        // Charger les familles de métiers pour ce pôle
        loadFamillesMetiers(poleId);
    });
    
    // Initialiser avec "Tous les pôles" sélectionné
    loadFamillesMetiers('');
    
    // Effectuer une recherche automatique au chargement pour afficher tous les talents
    setTimeout(function() {
        $('#searchForm').submit();
    }, 500);
    
    // Fonction pour charger les familles de métiers
    function loadFamillesMetiers(poleId) {
        if (poleId) {
            $.get(`/api/entreprise/familles-metiers/${poleId}`, function(data) {
                let html = `
                    <div class="col-auto">
                        <button type="button" class="btn-famille selected" data-value="">
                            Toutes les familles
                        </button>
                    </div>
                `;
                data.forEach(function(famille) {
                    html += `
                        <div class="col-auto">
                            <button type="button" class="btn-famille" data-value="${famille.id}">
                                ${famille.nom}
                            </button>
                        </div>
                    `;
                });
                $('#famillesContainer').html(html);
                $('#familleMetierSection').show();
                
                // Gérer la sélection des familles de métiers
                $('.btn-famille').click(function() {
                    $('.btn-famille').removeClass('selected');
                    $(this).addClass('selected');
                    $('#famille_metier_id').val($(this).data('value'));
                });
            }).fail(function() {
                $('#famillesContainer').html('<div class="col-12"><p class="text-danger">Erreur de chargement des familles de métiers</p></div>');
            });
        } else {
            // Afficher "Toutes les familles" même sans pôle sélectionné
            let html = `
                <div class="col-auto">
                    <button type="button" class="btn-famille selected" data-value="">
                        Toutes les familles
                    </button>
                </div>
            `;
            $('#famillesContainer').html(html);
            $('#familleMetierSection').show();
            $('#famille_metier_id').val('');
            
            // Gérer la sélection
            $('.btn-famille').click(function() {
                $('.btn-famille').removeClass('selected');
                $(this).addClass('selected');
                $('#famille_metier_id').val($(this).data('value'));
            });
        }
    }
    
    // Gestion des boutons d'expérience
    $('.btn-experience').click(function() {
        $('.btn-experience').removeClass('selected');
        $(this).addClass('selected');
        $('#experience_min').val($(this).data('value'));
    });
    
    // Gestion du slider de diplôme
    const diplomaLabels = ['Tous les diplômes', ...@json($niveauxDiplome->pluck('nom')->toArray())];
    const diplomaValues = ['', ...@json($niveauxDiplome->pluck('id')->toArray())];
    
    $('#diplomaRange').on('input', function() {
        const index = parseInt($(this).val()) + 1; // +1 car on commence à -1
        const diplomaName = diplomaLabels[index];
        const diplomaValue = diplomaValues[index];
        
        $('#selectedDiploma').text(diplomaName);
        $('#niveau_diplome').val(diplomaValue);
        
        // Mettre à jour la position du label actif
        $('.slider-label').removeClass('active');
        $('.slider-label').eq(index).addClass('active');
    });
    
    // Initialiser le slider
    $('#diplomaRange').trigger('input');

    // Gestion de la soumission du formulaire de recherche
    $('#searchForm').submit(function(e) {
        e.preventDefault();
        
        // Afficher le chargement
        $('#loadingSection').show();
        $('#resultsSection').hide();
        $('#noResultsSection').hide();
        
        // Préparer les données
        const formData = {
            pole_id: $('#pole_id').val(),
            famille_metier_id: $('#famille_metier_id').val(),
            experience_min: $('#experience_min').val(),
            niveau_diplome: $('#niveau_diplome').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        // Effectuer la recherche
        $.post('{{ route("entreprise.talents.search.post") }}', formData)
            .done(function(response) {
                displayResults(response);
            })
            .fail(function(xhr) {
                console.error('Erreur lors de la recherche:', xhr);
                $('#loadingSection').hide();
                alert('Une erreur est survenue lors de la recherche. Veuillez réessayer.');
            });
    });

    // Fonction pour afficher les résultats
    function displayResults(data) {
        $('#loadingSection').hide();
        
        if (data.data && data.data.length > 0) {
            $('#resultsCount').text(`${data.total} talent(s) trouvé(s)`);
            
            let html = '';
            data.data.forEach(function(talent) {
                html += createTalentCard(talent);
            });
            
            $('#talentsGrid').html(html);
            
            // Afficher la pagination si nécessaire
            if (data.last_page > 1) {
                displayPagination(data);
            } else {
                $('#paginationContainer').empty();
            }
            
            $('#resultsSection').show();
        } else {
            $('#noResultsSection').show();
        }
    }

    // Fonction pour créer une carte de talent
    function createTalentCard(talent) {
        const completionColor = talent.profile_completion_percentage >= 80 ? 'success' : 
                               talent.profile_completion_percentage >= 50 ? 'warning' : 'danger';
        
        return `
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm talent-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="avatar-circle">
                                    ${talent.user && talent.avatar_type ? 
                                        `<img src="${talent.avatar_type}" alt="Photo de profil" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">` : 
                                        `<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-weight: bold; font-size: 1.2rem;">
                                            ${talent.user && talent.user.name ? talent.user.name.split(' ').map(n => n.charAt(0)).join('').substring(0, 2).toUpperCase() : 'TL'}
                                        </div>`
                                    }
                                </div>
                            </div>
                            <div>
                                <h6 class="card-title mb-1 text-center">${talent.user ? talent.user.name : 'Nom non disponible'}</h6>
                                <p class="text-muted small mb-0 text-center">${talent.pole ? talent.pole.nom : 'Non spécifié'}</p>
                                <p class="text-muted small text-center">${talent.famille_metier ? talent.famille_metier.nom : 'Non spécifié'}</p>
                            </div>
                        </div>
                        
                        <!--div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Profil complété</small>
                                <small class="text-${completionColor}">${talent.profile_completion_percentage}%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${completionColor}" style="width: ${talent.profile_completion_percentage}%"></div>
                            </div>
                        </div-->
                        
                        <!-- Informations supplémentaires -->
                        <div class="mb-3">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <div class="fw-bold text-warning">${talent.annees_experience || 0} ans</div>
                                        <small class="text-muted">Expérience</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold text-info">${talent.niveau_diplome ? talent.niveau_diplome.nom : 'Non spécifié'}</div>
                                    <small class="text-muted">Diplôme</small>
                                </div>
                            </div>
                        </div>
                        
                        <!--<div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="fw-bold text-primary">${talent.total_applications || 0}</div>
                                    <small class="text-muted">Candidatures</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="fw-bold text-success">${talent.total_interviews || 0}</div>
                                    <small class="text-muted">Entretiens</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-info">${talent.total_offers_viewed || 0}</div>
                                <small class="text-muted">Offres vues</small>
                            </div>
                        </div> -->
                        
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-sm" onclick="viewTalentProfile(${talent.id})">
                                <i class="bi bi-eye me-1"></i>Voir le profil
                            </button>
                            <button class="btn btn-outline-primary btn-sm" onclick="linkToOffer(${talent.id})">
                                <i class="bi bi-link me-1"></i>Lier à une offre
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Fonction pour afficher la pagination
    function displayPagination(data) {
        let paginationHtml = '<nav><ul class="pagination justify-content-center">';
        
        // Bouton précédent
        if (data.current_page > 1) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page - 1}">Précédent</a></li>`;
        }
        
        // Pages
        for (let i = 1; i <= data.last_page; i++) {
            if (i === data.current_page) {
                paginationHtml += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }
        }
        
        // Bouton suivant
        if (data.current_page < data.last_page) {
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${data.current_page + 1}">Suivant</a></li>`;
        }
        
        paginationHtml += '</ul></nav>';
        $('#paginationContainer').html(paginationHtml);
        
        // Gestion des clics sur la pagination
        $('.page-link').click(function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                searchWithPage(page);
            }
        });
    }

    // Fonction pour rechercher avec pagination
    function searchWithPage(page) {
        $('#loadingSection').show();
        $('#resultsSection').hide();
        
        const formData = {
            pole_id: $('#pole_id').val(),
            famille_metier_id: $('#famille_metier_id').val(),
            experience_min: $('#experience_min').val(),
            niveau_diplome: $('#niveau_diplome').val(),
            page: page,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        $.post('{{ route("entreprise.talents.search.post") }}', formData)
            .done(function(response) {
                displayResults(response);
            })
            .fail(function(xhr) {
                console.error('Erreur lors de la recherche:', xhr);
                $('#loadingSection').hide();
                alert('Une erreur est survenue lors de la recherche. Veuillez réessayer.');
            });
    }

    // Réinitialiser le formulaire
    $('#resetForm').click(function() {
        // Réinitialiser les sélections
        $('.pole-card').removeClass('selected');
        $('.pole-card').first().addClass('selected'); // Sélectionner "Tous les pôles"
        $('.btn-famille').removeClass('selected');
        $('.btn-experience').removeClass('selected');
        $('.btn-experience').first().addClass('selected'); // Sélectionner "Toutes les années"
        
        // Réinitialiser les valeurs
        $('#pole_id').val('');
        $('#famille_metier_id').val('');
        $('#experience_min').val('');
        $('#niveau_diplome').val('');
        
        // Réinitialiser le slider à "Tous"
        $('#diplomaRange').val(-1).trigger('input');
        
        // Recharger les familles de métiers
        loadFamillesMetiers('');
        
        // Cacher les sections de résultats
        $('#resultsSection').hide();
        $('#noResultsSection').hide();
        $('#loadingSection').hide();
    });
});

// Fonctions globales pour les actions sur les talents
function viewTalentProfile(talentId) {
    // Rediriger vers la page de profil du talent
    window.location.href = '/entreprise/talents/profil/' + talentId;
}

function linkToOffer(talentId) {
    // Définir l'ID du talent dans le formulaire
    $('#talent_id').val(talentId);
    
    // Ouvrir la modal
    const modal = new bootstrap.Modal(document.getElementById('linkOfferModal'));
    modal.show();
}

function submitLinkOffer() {
    const talentId = $('#talent_id').val();
    const offreId = $('#offre_id').val();
    
    if (!offreId) {
        showErrorMessage('Veuillez sélectionner une offre d\'emploi.');
        return;
    }
    
    // Envoyer la requête AJAX
    $.ajax({
        url: '/entreprise/talents/lier-offre',
        method: 'POST',
        data: {
            talent_id: talentId,
            offre_id: offreId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Fermer la modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('linkOfferModal'));
            modal.hide();
            
            // Afficher le message de succès
            showSuccessMessage('Le talent a été lié avec succès à l\'offre d\'emploi.');
            
            // Réinitialiser le formulaire
            $('#linkOfferForm')[0].reset();
        },
        error: function(xhr) {
            let errorMessage = 'Une erreur est survenue lors de la liaison.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showErrorMessage(errorMessage);
        }
    });
}

function showSuccessMessage(message) {
    $('#successText').text(message);
    $('#successMessage').removeClass('show').addClass('show').show();
    
    // Faire défiler vers le haut pour voir le message
    $('html, body').animate({ scrollTop: 0 }, 300);
    
    // Masquer automatiquement après 5 secondes
    setTimeout(function() {
        $('#successMessage').removeClass('show');
        setTimeout(function() {
            $('#successMessage').hide();
        }, 150);
    }, 5000);
}

function showErrorMessage(message) {
    $('#errorText').text(message);
    $('#errorMessage').removeClass('show').addClass('show').show();
    
    // Faire défiler vers le haut pour voir le message
    $('html, body').animate({ scrollTop: 0 }, 300);
    
    // Masquer automatiquement après 5 secondes
    setTimeout(function() {
        $('#errorMessage').removeClass('show');
        setTimeout(function() {
            $('#errorMessage').hide();
        }, 150);
    }, 5000);
}
</script>

<style>
.talent-card {
    transition: transform 0.2s ease-in-out;
}

.talent-card:hover {
    transform: translateY(-5px);
}

.avatar-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #14224F, #f6cd45);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin: 0 auto;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

/* Styles pour les cartes de pôles */
.pole-card {
    background:  #14224F;
    border: 2px solid transparent;
    border-radius: 12px;
    padding: 20px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.pole-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.pole-card.selected {
    border-color: #fbbf24;
    box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.3);
    transform: translateY(-3px);
}

.pole-card h5 {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #fbbf24;
}

.pole-card p {
    font-size: 12px;
    margin: 0;
    opacity: 0.9;
}

.pole-icon {
    font-size: 24px;
    margin-bottom: 10px;
}

/* Styles pour les boutons d'expérience */
.btn-experience {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 20px;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-experience:hover {
    background: #e2e8f0;
    border-color: #cbd5e1;
}

.btn-experience.selected {
    background: #14224F;
    border-color: #14224F;
    color: white;
}

/* Styles pour les boutons de famille de métier */
.btn-famille {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 8px 16px;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    margin: 4px;
}

.btn-famille:hover {
    background: #e2e8f0;
    border-color: #94a3b8;
}

.btn-famille.selected {
    background: #14224F;
    border-color: #14224F;
    color: white;
}

/* Styles pour le slider de diplôme */
.diploma-slider-container {
    position: relative;
    padding: 20px 0;
}

.diploma-slider {
    width: 100%;
    height: 6px;
    border-radius: 3px;
    background: linear-gradient(to right, #fbbf24 0%, #f59e0b 100%);
    outline: none;
    -webkit-appearance: none;
}

.diploma-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #14224F;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.diploma-slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #14224F;
    cursor: pointer;
    border: 3px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.slider-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 12px;
    color: #64748b;
}

.slider-label {
    transition: all 0.3s ease;
}

.slider-label.active {
    color: #14224F;
    font-weight: 600;
    transform: scale(1.1);
}

.selected-diploma {
    text-align: center;
    margin-top: 15px;
    padding: 10px;
    background: #f0f9ff;
    border-radius: 8px;
    border-left: 4px solid #14224F;
}

.selected-diploma strong {
    color: #14224F;
    font-size: 16px;
}

/* Section cachée par défaut */
#familleMetierSection {
    display: none;
}
</style>
@endpush