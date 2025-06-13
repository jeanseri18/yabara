@extends('layouts.entreprise')

@section('title', 'Suivi des Candidatures')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-tasks me-2" style="color: #1040BB;"></i>Suivi des Candidatures</h2>
                    <p class="text-muted mb-0">Gérez vos candidatures avec le tableau Kanban</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
                    </a>
                    <button class="btn text-white" style="background-color: #1040BB;" data-bs-toggle="modal" data-bs-target="#filtersModal">
                        <i class="fas fa-filter me-2"></i>Filtres
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 text-white" style="background-color: #1040BB;">
                <div class="card-body text-center">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <h4 class="mb-0" id="stat-recues">{{ $stats['candidatures_recues'] ?? 0 }}</h4>
                    <small>Candidatures reçues</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background-color: #f6cd45; color: #071D55;">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x mb-2"></i>
                    <h4 class="mb-0" id="stat-preselections">{{ $stats['preselections'] ?? 0 }}</h4>
                    <small>Présélectionnées</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 text-white" style="background-color: #071D55;">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-2x mb-2"></i>
                    <h4 class="mb-0" id="stat-entretiens">{{ $stats['entretiens'] ?? 0 }}</h4>
                    <small>En entretiens</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4 class="mb-0" id="stat-recrutes">{{ $stats['recrutes'] ?? 0 }}</h4>
                    <small>Recrutés</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau Kanban -->
    <div class="kanban-board">
        <div class="row g-3">
            <!-- Colonne 1: Candidatures reçues -->
            <div class="col-lg-3">
                <div class="kanban-column" data-status="candidature_recue">
                    <div class="kanban-header bg-info text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-inbox me-2"></i>
                                <span class="fw-bold">Candidatures reçues</span>
                            </div>
                            <span class="badge bg-white text-info" id="count-candidature_recue">0</span>
                        </div>
                    </div>
                    <div class="kanban-body" id="column-candidature_recue">
                        <div class="kanban-loading text-center py-4">
                            <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                            <p class="small text-muted mt-2">Chargement...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 2: Présélectionnées -->
            <div class="col-lg-3">
                <div class="kanban-column" data-status="preselctionnee">
                    <div class="kanban-header bg-warning text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-star me-2"></i>
                                <span class="fw-bold">Présélectionnées</span>
                            </div>
                            <span class="badge bg-white text-warning" id="count-preselctionnee">0</span>
                        </div>
                    </div>
                    <div class="kanban-body" id="column-preselctionnee">
                        <div class="kanban-loading text-center py-4">
                            <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                            <p class="small text-muted mt-2">Chargement...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 3: En entretiens -->
            <div class="col-lg-3">
                <div class="kanban-column" data-status="entretien">
                    <div class="kanban-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-comments me-2"></i>
                                <span class="fw-bold">En entretiens</span>
                            </div>
                            <span class="badge bg-white text-primary" id="count-entretien">0</span>
                        </div>
                    </div>
                    <div class="kanban-body" id="column-entretien">
                        <div class="kanban-loading text-center py-4">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <p class="small text-muted mt-2">Chargement...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne 4: Recrutés -->
            <div class="col-lg-3">
                <div class="kanban-column" data-status="retenue">
                    <div class="kanban-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-check-circle me-2"></i>
                                <span class="fw-bold">Recrutés</span>
                            </div>
                            <span class="badge bg-white text-success" id="count-retenue">0</span>
                        </div>
                    </div>
                    <div class="kanban-body" id="column-retenue">
                        <div class="kanban-loading text-center py-4">
                            <div class="spinner-border spinner-border-sm text-success" role="status"></div>
                            <p class="small text-muted mt-2">Chargement...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de filtres -->
<div class="modal fade" id="filtersModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-filter text-primary me-2"></i>Filtres</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="filtersForm">
                    <div class="mb-3">
                        <label for="filter_offre" class="form-label">Offre d'emploi</label>
                        <select class="form-select" id="filter_offre" name="offre_id">
                            <option value="">Toutes les offres</option>
                            @foreach($offres as $offre)
                                <option value="{{ $offre->id }}">{{ $offre->titre }} ({{ $offre->reference_offre }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="filter_periode" class="form-label">Période</label>
                        <select class="form-select" id="filter_periode" name="periode">
                            <option value="">Toute période</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                            <option value="quarter">Ce trimestre</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="filter_famille_metier" class="form-label">Famille de métier</label>
                        <select class="form-select" id="filter_famille_metier" name="famille_metier_id">
                            <option value="">Toutes les familles</option>
                            @foreach($famillesMetiers as $famille)
                                <option value="{{ $famille->id }}">{{ $famille->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-outline-secondary" id="resetFilters">Réinitialiser</button>
                <button type="button" class="btn btn-primary" id="applyFilters">Appliquer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de détails candidature -->
<div class="modal fade" id="candidatureModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user text-primary me-2"></i>Détails de la candidature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="candidature-details">
                <!-- Contenu chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <div id="candidature-actions">
                    <!-- Actions dynamiques selon le statut -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.kanban-board {
    min-height: 600px;
}

.kanban-column {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    height: 600px;
    display: flex;
    flex-direction: column;
}

.kanban-header {
    padding: 1rem;
    border-radius: 12px 12px 0 0;
}

.kanban-body {
    flex: 1;
    padding: 1rem;
    overflow-y: auto;
    min-height: 0;
}

.kanban-card {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    cursor: move;
    transition: all 0.3s ease;
    border-left: 4px solid #dee2e6;
}

.kanban-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.kanban-card.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.kanban-card.drag-over {
    border-left-color: #0d6efd;
    background: #f0f8ff;
}

.candidate-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    margin-right: 0.75rem;
}

.candidate-info h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.candidate-meta {
    font-size: 0.875rem;
    color: #6c757d;
}

.candidate-meta i {
    width: 16px;
    text-align: center;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
}

.status-candidature_recue {
    background: #e3f2fd;
    color: #1976d2;
}

.status-preselctionnee {
    background: #fff3e0;
    color: #f57c00;
}

.status-entretien {
    background: #e8f5e8;
    color: #388e3c;
}

.status-retenue {
    background: #e8f5e8;
    color: #2e7d32;
}

.kanban-empty {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.kanban-empty i {
    font-size: 2rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.drop-zone {
    min-height: 100px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    transition: all 0.3s ease;
}

.drop-zone.drag-over {
    border-color: #0d6efd;
    background: #f0f8ff;
    color: #0d6efd;
}

.candidate-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.candidate-actions .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.timeline-item {
    border-left: 2px solid #dee2e6;
    padding-left: 1rem;
    margin-bottom: 1rem;
    position: relative;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -6px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #0d6efd;
}

.timeline-item:last-child {
    border-left-color: transparent;
}

@media (max-width: 991.98px) {
    .kanban-column {
        height: auto;
        margin-bottom: 1rem;
    }
    
    .kanban-body {
        max-height: 400px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    let currentFilters = {};
    
    // Initialisation du Kanban
    initializeKanban();
    loadCandidatures();
    
    function initializeKanban() {
        const columns = document.querySelectorAll('.kanban-body');
        
        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'drag-over',
                chosenClass: 'dragging',
                onEnd: function(evt) {
                    const candidatureId = evt.item.dataset.candidatureId;
                    const newStatus = evt.to.closest('.kanban-column').dataset.status;
                    const oldStatus = evt.from.closest('.kanban-column').dataset.status;
                    
                    if (newStatus !== oldStatus) {
                        updateCandidatureStatus(candidatureId, newStatus, oldStatus, evt.item);
                    }
                }
            });
        });
    }
    
    function loadCandidatures() {
        const params = new URLSearchParams(currentFilters);
        
        $.get(`{{ route('entreprise.candidatures.data') }}?${params.toString()}`)
            .done(function(response) {
                displayCandidatures(response.candidatures);
                updateStats(response.stats);
            })
            .fail(function() {
                showToast('Erreur lors du chargement des candidatures', 'error');
            });
    }
    
    function displayCandidatures(candidatures) {
        // Vider toutes les colonnes
        $('.kanban-body').each(function() {
            $(this).empty();
        });
        
        // Grouper par statut
        const grouped = {};
        candidatures.forEach(candidature => {
            const status = candidature.statut_entreprise;
            if (!grouped[status]) {
                grouped[status] = [];
            }
            grouped[status].push(candidature);
        });
        
        // Afficher dans chaque colonne
        Object.keys(grouped).forEach(status => {
            const column = $(`#column-${status}`);
            const cards = grouped[status].map(createCandidatureCard).join('');
            column.html(cards);
            
            // Mettre à jour le compteur
            $(`#count-${status}`).text(grouped[status].length);
        });
        
        // Afficher message vide pour les colonnes sans candidatures
        $('.kanban-body').each(function() {
            if ($(this).children().length === 0) {
                const status = $(this).attr('id').replace('column-', '');
                $(this).html(createEmptyState(status));
                $(`#count-${status}`).text('0');
            }
        });
    }
    
    function createCandidatureCard(candidature) {
        const avatarColors = ['#0d6efd', '#198754', '#dc3545', '#ffc107', '#6f42c1', '#20c997'];
        const avatarColor = avatarColors[candidature.id % avatarColors.length];
        
        const dateCreation = new Date(candidature.created_at).toLocaleDateString('fr-FR');
        
        return `
            <div class="kanban-card" data-candidature-id="${candidature.id}" onclick="showCandidatureDetails(${candidature.id})">
                <div class="d-flex align-items-start">
                    <div class="candidate-avatar" style="background-color: ${avatarColor}">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="candidate-info flex-grow-1">
                        <h6>${candidature.talent.cv_reference}</h6>
                        <div class="candidate-meta">
                            <div class="mb-1">
                                <i class="fas fa-briefcase"></i>
                                ${candidature.offre_emploi.titre}
                            </div>
                            <div class="mb-1">
                                <i class="fas fa-calendar"></i>
                                ${dateCreation}
                            </div>
                            <div class="mb-1">
                                <i class="fas fa-graduation-cap"></i>
                                ${candidature.talent.niveau_etude || 'Non spécifié'}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="status-badge status-${candidature.statut_entreprise}">
                                ${getStatusLabel(candidature.statut_entreprise)}
                            </span>
                            <small class="text-muted">
                                ${candidature.offre_emploi.reference_offre}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    function createEmptyState(status) {
        const messages = {
            'candidature_recue': 'Aucune candidature reçue',
            'preselctionnee': 'Aucune candidature présélectionnée',
            'entretien': 'Aucun entretien programmé',
            'retenue': 'Aucune candidature retenue'
        };
        
        return `
            <div class="kanban-empty">
                <i class="fas fa-inbox"></i>
                <p>${messages[status] || 'Aucune candidature'}</p>
            </div>
        `;
    }
    
    function updateCandidatureStatus(candidatureId, newStatus, oldStatus, cardElement) {
        // Animation de chargement
        $(cardElement).addClass('updating');
        
        $.post('{{ route("entreprise.candidatures.update.status") }}', {
            candidature_id: candidatureId,
            status: newStatus,
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                
                // Mettre à jour les compteurs
                updateColumnCount(oldStatus, -1);
                updateColumnCount(newStatus, 1);
                
                // Mettre à jour les stats globales
                updateStats(response.stats);
                
                // Animation de succès
                if (newStatus === 'retenue') {
                    showConfetti();
                }
            }
        })
        .fail(function() {
            // Remettre la carte à sa position d'origine
            $(`#column-${oldStatus}`).append(cardElement);
            showToast('Erreur lors de la mise à jour', 'error');
        })
        .always(function() {
            $(cardElement).removeClass('updating');
        });
    }
    
    function updateColumnCount(status, delta) {
        const counter = $(`#count-${status}`);
        const currentCount = parseInt(counter.text()) || 0;
        counter.text(Math.max(0, currentCount + delta));
    }
    
    function updateStats(stats) {
        $('#stat-recues').text(stats.candidatures_recues || 0);
        $('#stat-preselections').text(stats.preselections || 0);
        $('#stat-entretiens').text(stats.entretiens || 0);
        $('#stat-recrutes').text(stats.recrutes || 0);
    }
    
    function getStatusLabel(status) {
        const labels = {
            'candidature_recue': 'Reçue',
            'preselctionnee': 'Présélectionnée',
            'entretien': 'Entretien',
            'retenue': 'Retenue'
        };
        return labels[status] || status;
    }
    
    // Gestion des filtres
    $('#applyFilters').on('click', function() {
        currentFilters = {
            offre_id: $('#filter_offre').val(),
            periode: $('#filter_periode').val(),
            famille_metier_id: $('#filter_famille_metier').val()
        };
        
        // Supprimer les valeurs vides
        Object.keys(currentFilters).forEach(key => {
            if (!currentFilters[key]) {
                delete currentFilters[key];
            }
        });
        
        loadCandidatures();
        $('#filtersModal').modal('hide');
    });
    
    $('#resetFilters').on('click', function() {
        $('#filtersForm')[0].reset();
        currentFilters = {};
        loadCandidatures();
        $('#filtersModal').modal('hide');
    });
    
    // Fonction globale pour afficher les détails
    window.showCandidatureDetails = function(candidatureId) {
        $('#candidature-details').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2">Chargement des détails...</p>
            </div>
        `);
        
        $('#candidatureModal').modal('show');
        
        $.get(`{{ route('entreprise.candidatures.details', ':id') }}`.replace(':id', candidatureId))
            .done(function(response) {
                $('#candidature-details').html(response.html);
                $('#candidature-actions').html(response.actions);
            })
            .fail(function() {
                $('#candidature-details').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Erreur lors du chargement des détails
                    </div>
                `);
            });
    };
    
    function showConfetti() {
        // Animation de confettis simple
        const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
        
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = $('<div>').css({
                    position: 'fixed',
                    top: '-10px',
                    left: Math.random() * window.innerWidth + 'px',
                    width: '10px',
                    height: '10px',
                    backgroundColor: colors[Math.floor(Math.random() * colors.length)],
                    zIndex: 9999,
                    pointerEvents: 'none'
                });
                
                $('body').append(confetti);
                
                confetti.animate({
                    top: window.innerHeight + 'px',
                    left: '+=' + (Math.random() * 200 - 100) + 'px'
                }, 3000, function() {
                    $(this).remove();
                });
            }, i * 50);
        }
    }
    
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
    
    // Actualisation automatique toutes les 30 secondes
    setInterval(function() {
        loadCandidatures();
    }, 30000);
});
</script>
@endpush