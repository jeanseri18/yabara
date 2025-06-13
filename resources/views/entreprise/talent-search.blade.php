@extends('layouts.entreprise')

@section('title', 'Recherche de Talents')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-search me-2" style="color: #1040BB;"></i>Recherche de Talents</h2>
                    <p class="text-muted mb-0">Trouvez les talents qui correspondent à vos besoins</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Filtres de recherche -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0"><i class="fas fa-filter me-2" style="color: #1040BB;"></i>Filtres de recherche</h6>
                </div>
                <div class="card-body p-3">
                    <form id="searchForm">
                        <!-- Pôle d'activité -->
                        <div class="mb-4">
                            <label for="pole_id" class="form-label fw-bold">Pôle d'activité</label>
                            <select class="form-select" id="pole_id" name="pole_id">
                                <option value="">Tous les pôles</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}">{{ $pole->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Famille de métier -->
                        <div class="mb-4">
                            <label for="famille_metier_id" class="form-label fw-bold">Famille de métier</label>
                            <select class="form-select" id="famille_metier_id" name="famille_metier_id" disabled>
                                <option value="">Sélectionnez un pôle d'abord</option>
                            </select>
                        </div>

                        <!-- Niveau de diplôme -->
                        <div class="mb-4">
                            <label for="niveau_diplome" class="form-label fw-bold">Niveau de diplôme</label>
                            <select class="form-select" id="niveau_diplome" name="niveau_diplome">
                                <option value="">Tous les niveaux</option>
                                @foreach($niveauxDiplome as $niveau)
                                    <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Expérience minimum -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Expérience minimum</label>
                            <div class="experience-filters">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="experience_min" id="exp_0" value="0">
                                    <label class="form-check-label" for="exp_0">Débutant (0 an)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="experience_min" id="exp_1" value="1">
                                    <label class="form-check-label" for="exp_1">1-2 ans</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="experience_min" id="exp_3" value="3">
                                    <label class="form-check-label" for="exp_3">3-5 ans</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="experience_min" id="exp_6" value="6">
                                    <label class="form-check-label" for="exp_6">6+ ans</label>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Rechercher
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                <i class="fas fa-undo me-2"></i>Réinitialiser
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Résultats de recherche -->
        <div class="col-lg-9">
            <!-- Statistiques de recherche -->
            <div class="search-stats mb-4">
                <div class="card border-0 bg-light">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <span class="text-muted">Résultats trouvés: </span>
                                <strong id="results-count">0</strong> talent(s)
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="view-mode" id="grid-view" checked>
                                    <label class="btn btn-outline-secondary btn-sm" for="grid-view">
                                        <i class="fas fa-th"></i>
                                    </label>
                                    <input type="radio" class="btn-check" name="view-mode" id="list-view">
                                    <label class="btn btn-outline-secondary btn-sm" for="list-view">
                                        <i class="fas fa-list"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de résultats -->
            <div id="search-results">
                <!-- État initial -->
                <div class="empty-state text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Utilisez les filtres pour rechercher des talents</h5>
                    <p class="text-muted">Affinez votre recherche avec les critères de gauche</p>
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination-container" class="d-flex justify-content-center mt-4" style="display: none !important;">
                <!-- Pagination sera générée dynamiquement -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de liaison à une offre -->
<div class="modal fade" id="linkOfferModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-link text-primary me-2"></i>Lier à une offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="talent-info mb-4">
                    <div class="d-flex align-items-center">
                        <div class="talent-avatar me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-1" id="talent-name">Nom du talent</h6>
                            <small class="text-muted" id="talent-ref">Référence CV</small>
                        </div>
                    </div>
                </div>
                
                <form id="linkOfferForm">
                    <input type="hidden" id="selected-talent-id" name="talent_id">
                    
                    <div class="mb-3">
                        <label for="offre_id" class="form-label fw-bold">Sélectionnez une offre</label>
                        <select class="form-select" id="offre_id" name="offre_id" required>
                            <option value="">Chargement des offres...</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>Le talent sera automatiquement ajouté à vos candidatures reçues.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmLink">
                    <i class="fas fa-link me-2"></i>Lier à l'offre
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.talent-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    overflow: hidden;
}

.talent-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #0d6efd;
}

.talent-avatar {
    position: relative;
}

.talent-avatar .avatar-bg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: 0 auto;
}

.talent-info {
    padding: 1rem;
}

.talent-ref {
    font-family: 'Courier New', monospace;
    font-weight: bold;
    color: #0d6efd;
}

.talent-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.skill-badge {
    background: #f8f9fa;
    color: #495057;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    border: 1px solid #dee2e6;
}

.experience-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(13, 110, 253, 0.9);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
}

.link-btn {
    transition: all 0.3s ease;
}

.link-btn:hover {
    transform: scale(1.05);
}

.empty-state {
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.search-loading {
    text-align: center;
    padding: 3rem;
}

.loading-spinner {
    width: 3rem;
    height: 3rem;
    border: 0.3rem solid #f3f3f3;
    border-top: 0.3rem solid #0d6efd;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.talent-card-list {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.talent-card-list:hover {
    border-color: #0d6efd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.experience-filters .form-check {
    margin-bottom: 0.5rem;
}

.sticky-top {
    position: sticky;
    top: 20px;
    z-index: 1020;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let currentPage = 1;
    let currentView = 'grid';
    
    // Chargement des familles de métiers
    $('#pole_id').on('change', function() {
        const poleId = $(this).val();
        const familleSelect = $('#famille_metier_id');
        
        if (poleId) {
            familleSelect.prop('disabled', true).html('<option value="">Chargement...</option>');
            
            $.get(`/api/entreprise/familles-metiers/${poleId}`)
                .done(function(familles) {
                    familleSelect.html('<option value="">Toutes les familles</option>');
                    familles.forEach(function(famille) {
                        familleSelect.append(`<option value="${famille.id}">${famille.nom}</option>`);
                    });
                    familleSelect.prop('disabled', false);
                })
                .fail(function() {
                    familleSelect.html('<option value="">Erreur de chargement</option>');
                });
        } else {
            familleSelect.prop('disabled', true).html('<option value="">Sélectionnez un pôle d\'abord</option>');
        }
    });
    
    // Changement de mode d'affichage
    $('input[name="view-mode"]').on('change', function() {
        currentView = $(this).attr('id') === 'grid-view' ? 'grid' : 'list';
        if ($('#search-results .talent-card, #search-results .talent-card-list').length > 0) {
            performSearch(currentPage);
        }
    });
    
    // Recherche
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        performSearch();
    });
    
    // Réinitialisation des filtres
    $('#resetFilters').on('click', function() {
        $('#searchForm')[0].reset();
        $('#famille_metier_id').prop('disabled', true).html('<option value="">Sélectionnez un pôle d\'abord</option>');
        $('#search-results').html(`
            <div class="empty-state text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Utilisez les filtres pour rechercher des talents</h5>
                <p class="text-muted">Affinez votre recherche avec les critères de gauche</p>
            </div>
        `);
        $('#results-count').text('0');
        $('#pagination-container').hide();
    });
    
    function performSearch(page = 1) {
        const formData = $('#searchForm').serialize() + `&page=${page}`;
        
        // Afficher le loader
        $('#search-results').html(`
            <div class="search-loading">
                <div class="loading-spinner"></div>
                <p class="text-muted">Recherche en cours...</p>
            </div>
        `);
        
        $.post('{{ route("entreprise.talents.search.post") }}', formData)
            .done(function(response) {
                displayResults(response);
            })
            .fail(function() {
                $('#search-results').html(`
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Erreur lors de la recherche. Veuillez réessayer.
                    </div>
                `);
            });
    }
    
    function displayResults(response) {
        const talents = response.data;
        $('#results-count').text(response.total);
        
        if (talents.length === 0) {
            $('#search-results').html(`
                <div class="empty-state text-center py-5">
                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun talent trouvé</h5>
                    <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                </div>
            `);
            $('#pagination-container').hide();
            return;
        }
        
        let html = '';
        
        if (currentView === 'grid') {
            html = '<div class="row g-4">';
            talents.forEach(function(talent) {
                html += createTalentCard(talent);
            });
            html += '</div>';
        } else {
            talents.forEach(function(talent) {
                html += createTalentListItem(talent);
            });
        }
        
        $('#search-results').html(html);
        
        // Pagination
        if (response.last_page > 1) {
            createPagination(response);
            $('#pagination-container').show();
        } else {
            $('#pagination-container').hide();
        }
    }
    
    function createTalentCard(talent) {
        const avatarColors = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#6f42c1', '#20c997'];
        const avatarColor = avatarColors[talent.id % avatarColors.length];
        
        return `
            <div class="col-md-6 col-lg-4">
                <div class="card talent-card h-100">
                    <div class="card-body text-center position-relative">
                        <div class="experience-badge">
                            ${talent.experience || 0}+ ans
                        </div>
                        <div class="talent-avatar mb-3">
                            <div class="avatar-bg" style="background-color: ${avatarColor}">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <h6 class="card-title mb-1">${talent.cv_reference}</h6>
                        <p class="text-muted small mb-2">${talent.famille_metier?.nom || 'Non spécifié'}</p>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-graduation-cap me-1"></i>${talent.niveau_etude || 'Non spécifié'}
                        </p>
                        <button class="btn btn-primary btn-sm link-btn" 
                                onclick="openLinkModal(${talent.id}, '${talent.cv_reference}')">
                            <i class="fas fa-link me-1"></i>Lier à une offre
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    function createTalentListItem(talent) {
        const avatarColors = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#6f42c1', '#20c997'];
        const avatarColor = avatarColors[talent.id % avatarColors.length];
        
        return `
            <div class="card talent-card-list">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background-color: ${avatarColor}; color: white;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="mb-1">${talent.cv_reference}</h6>
                            <p class="text-muted small mb-1">${talent.famille_metier?.nom || 'Non spécifié'}</p>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-graduation-cap me-1"></i>${talent.niveau_etude || 'Non spécifié'} • 
                                <i class="fas fa-clock me-1"></i>${talent.experience || 0}+ ans d'expérience
                            </p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-sm link-btn" 
                                    onclick="openLinkModal(${talent.id}, '${talent.cv_reference}')">
                                <i class="fas fa-link me-1"></i>Lier à une offre
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    function createPagination(response) {
        let html = '<nav><ul class="pagination">';
        
        // Bouton précédent
        if (response.current_page > 1) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="performSearch(${response.current_page - 1})">Précédent</a></li>`;
        }
        
        // Numéros de page
        for (let i = 1; i <= response.last_page; i++) {
            if (i === response.current_page) {
                html += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
            } else {
                html += `<li class="page-item"><a class="page-link" href="#" onclick="performSearch(${i})">${i}</a></li>`;
            }
        }
        
        // Bouton suivant
        if (response.current_page < response.last_page) {
            html += `<li class="page-item"><a class="page-link" href="#" onclick="performSearch(${response.current_page + 1})">Suivant</a></li>`;
        }
        
        html += '</ul></nav>';
        $('#pagination-container').html(html);
    }
    
    // Chargement des offres pour la liaison
    function loadOffers() {
        $.get('/api/entreprise/mes-offres')
            .done(function(offres) {
                let html = '<option value="">Sélectionnez une offre</option>';
                offres.forEach(function(offre) {
                    html += `<option value="${offre.id}">${offre.titre} (${offre.reference_offre})</option>`;
                });
                $('#offre_id').html(html);
            })
            .fail(function() {
                $('#offre_id').html('<option value="">Erreur de chargement</option>');
            });
    }
    
    // Liaison d'un talent à une offre
    $('#confirmLink').on('click', function() {
        const formData = $('#linkOfferForm').serialize();
        
        if (!$('#offre_id').val()) {
            alert('Veuillez sélectionner une offre');
            return;
        }
        
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Liaison...');
        
        $.post('{{ route("entreprise.talents.link") }}', formData + '&_token={{ csrf_token() }}')
            .done(function(response) {
                if (response.success) {
                    $('#linkOfferModal').modal('hide');
                    showToast(response.message, 'success');
                }
            })
            .fail(function() {
                showToast('Erreur lors de la liaison', 'error');
            })
            .always(function() {
                $('#confirmLink').prop('disabled', false).html('<i class="fas fa-link me-2"></i>Lier à l\'offre');
            });
    });
    
    // Fonctions globales
    window.openLinkModal = function(talentId, talentRef) {
        $('#selected-talent-id').val(talentId);
        $('#talent-name').text('Talent');
        $('#talent-ref').text(talentRef);
        loadOffers();
        $('#linkOfferModal').modal('show');
    };
    
    window.performSearch = performSearch;
    
    function showToast(message, type) {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastContainer = $('.toast-container');
        if (toastContainer.length === 0) {
            $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }
        
        const toast = $(toastHtml);
        $('.toast-container').append(toast);
        
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        
        toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
});
</script>
@endpush