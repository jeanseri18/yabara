@extends('layouts.entreprise')

@section('title', 'Salle de Trophées')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- En-tête -->
    <div class="row mb-4 pt-3">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <div>
                    <h5 class="mb-0" style="color: #333; font-weight: 600;">Salle de Trophées</h5>
                    <small class="text-muted">Découvrez vos récompenses et progressions</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <div class="rounded-circle border border-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: #0066FF; border-color: #0066FF !important;">
                            <i class="fas fa-trophy text-white" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <h6 class="mt-2 mb-1" style="color: #333; font-weight: 600;">{{ $stats['badges_obtenus'] }}/{{ $stats['total_badges'] }}</h6>
                    <small class="text-muted">Badges obtenus</small>
                </div>
                
                <div class="col-md-3 mb-3">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-chart-line me-2" style="color: #0066FF;"></i>Progression</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Completion</small>
                        <div class="progress mb-1" style="height: 8px; border-radius: 4px;">
                            <div class="progress-bar" style="background-color: #0066FF; width: {{ $stats['pourcentage_completion'] }}%;"></div>
                        </div>
                        <span style="font-size: 14px; color: #333;">{{ number_format($stats['pourcentage_completion'], 1) }}%</span>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-star me-2" style="color: #0066FF;"></i>Points</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Total gagné</small>
                        <span style="font-size: 18px; color: #333; font-weight: 600;">{{ $stats['points_total'] }}</span>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-crown me-2" style="color: #0066FF;"></i>Niveau</h6>
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Niveau actuel</small>
                        <span style="font-size: 18px; color: #333; font-weight: 600;">{{ $stats['niveau_entreprise'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres simplifiés -->
    <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
        <div class="card-body p-4">
            <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-filter me-2" style="color: #0066FF;"></i>Filtres</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Statut</small>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="status" id="all-status" value="all" checked>
                            <label class="btn btn-outline-primary" for="all-status" style="border-radius: 20px 0 0 20px; font-size: 14px;">Tous</label>
                            
                            <input type="radio" class="btn-check" name="status" id="obtained-status" value="obtained">
                            <label class="btn btn-outline-primary" for="obtained-status" style="font-size: 14px;">Obtenus</label>
                            
                            <input type="radio" class="btn-check" name="status" id="locked-status" value="locked">
                            <label class="btn btn-outline-primary" for="locked-status" style="border-radius: 0 20px 20px 0; font-size: 14px;">Verrouillés</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2">
                        <small class="text-muted d-block" style="font-size: 12px;">Catégorie</small>
                        <select class="form-select" name="category" style="border-radius: 20px; font-size: 14px;">
                            <option value="all">Toutes les catégories</option>
                            <option value="recrutement">Recrutement</option>
                            <option value="activite">Activité</option>
                            <option value="performance">Performance</option>
                            <option value="special">Spéciaux</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des badges -->
    <div class="row">
        @foreach($badges as $badge)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3" 
                 data-category="{{ $badge['category'] }}" 
                 data-status="{{ $badge['obtained'] ? 'obtained' : 'locked' }}">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;" data-badge-id="{{ $badge['id'] }}">
                    <div class="card-body p-4 text-center">
                        <!-- Icône du badge -->
                        <div class="mb-3">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background-color: {{ $badge['obtained'] ? '#0066FF' : '#f8f9fa' }}; border: 2px solid {{ $badge['obtained'] ? '#0066FF' : '#e0e0e0' }};">
                                <i class="{{ $badge['icon'] }} {{ $badge['obtained'] ? 'text-white' : 'text-muted' }}" style="font-size: 24px;"></i>
                            </div>
                            @if($badge['obtained'])
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success rounded-circle p-1">
                                        <i class="fas fa-check" style="font-size: 8px;"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Titre et description -->
                        <h6 class="mb-2" style="color: #333; font-weight: 600;">{{ $badge['nom'] }}</h6>
                        <p class="text-muted mb-3" style="font-size: 13px;">{{ $badge['description'] }}</p>
                        
                        @if($badge['obtained'])
                            <!-- Badge obtenu -->
                            <div class="mb-3">
                                <small class="text-muted d-block" style="font-size: 11px;">Obtenu le</small>
                                <span style="font-size: 12px; color: #333;">{{ $badge['date_obtention']->format('d/m/Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <span class="badge me-2" style="background-color: #fff3cd; color: #856404; font-size: 11px;">
                                    <i class="fas fa-star me-1"></i>+{{ $badge['points'] }} pts
                                </span>
                            </div>
                        @else
                            <!-- Badge verrouillé -->
                            <div class="mb-3">
                                <div class="progress mb-2" style="height: 6px; border-radius: 3px;">
                                    <div class="progress-bar" style="background-color: #0066FF; width: {{ $badge['progression'] }}%;"></div>
                                </div>
                                <small class="text-muted">{{ number_format($badge['progression'], 1) }}% complété</small>
                            </div>
                        @endif
                        
                        <!-- Bouton d'action -->
                        <button class="btn btn-sm {{ $badge['obtained'] ? 'btn-outline-success' : 'btn-outline-primary' }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#badgeModal" 
                                data-badge='@json($badge)'
                                style="border-radius: 20px; font-size: 12px; padding: 6px 16px;">
                            @if($badge['obtained'])
                                <i class="fas fa-eye me-1"></i>Voir détails
                            @else
                                <i class="fas fa-target me-1"></i>Objectif
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Prochains objectifs -->
    @if(count($prochains_objectifs) > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: #0066FF;">
                            <i class="fas fa-target text-white" style="font-size: 16px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1" style="color: #333; font-weight: 600;">Prochains Objectifs</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">{{ count($prochains_objectifs) }} objectifs disponibles</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($prochains_objectifs as $objectif)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; background-color: #f8f9fa;">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-3" 
                                                 style="width: 35px; height: 35px; background-color: #fff; border: 2px solid #e0e0e0;">
                                                <i class="{{ $objectif['icon'] }} text-muted" style="font-size: 14px;"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-2" style="color: #333; font-weight: 600; font-size: 13px;">{{ $objectif['nom'] }}</h6>
                                                <div class="progress mb-1" style="height: 4px; border-radius: 2px;">
                                                    <div class="progress-bar" style="background-color: #0066FF; width: {{ $objectif['progression'] }}%;"></div>
                                                </div>
                                                <small class="text-muted" style="font-size: 11px;">
                                                    {{ number_format($objectif['progression'], 1) }}% complété
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal détaillé pour les badges -->
<div class="modal fade" id="badgeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm" style="border-radius: 12px;">
            <div class="modal-header border-0 bg-white">
                <h5 class="modal-title" style="color: #333; font-weight: 600;">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                         style="width: 30px; height: 30px; background-color: #0066FF;">
                        <i class="fas fa-trophy text-white" style="font-size: 12px;"></i>
                    </div>
                    <span id="modal-badge-title">Détails du Badge</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="modal-badge-content">
                    <!-- Contenu dynamique -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de félicitations -->
<div class="modal fade" id="congratulationsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm" style="border-radius: 12px;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background-color: #0066FF;">
                        <i class="fas fa-trophy text-white" style="font-size: 32px;"></i>
                    </div>
                </div>
                <h4 class="mb-3" style="color: #333; font-weight: 600;">🎉 Félicitations ! 🎉</h4>
                <p class="text-muted mb-4" style="font-size: 14px;">Vous avez obtenu un nouveau badge !</p>
                <div id="new-badge-info" class="mb-4">
                    <!-- Informations du nouveau badge -->
                </div>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="border-radius: 20px; padding: 8px 24px;">
                    <i class="fas fa-check me-2"></i>Continuer l'aventure
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styles épurés pour les badges */
.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
}









</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation des tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Filtrage des badges
    function filterBadges() {
        const selectedCategory = $('select[name="category"]').val();
        const selectedStatus = $('input[name="status"]:checked').val();
        
        $('[data-category]').each(function() {
            const category = $(this).data('category');
            const status = $(this).data('status');
            
            let showCategory = selectedCategory === 'all' || category === selectedCategory;
            let showStatus = selectedStatus === 'all' || status === selectedStatus;
            
            if (showCategory && showStatus) {
                $(this).removeClass('hidden').fadeIn(400);
            } else {
                $(this).addClass('hidden').fadeOut(400);
            }
        });
        
        // Mettre à jour le compteur
        setTimeout(function() {
            const visibleBadges = $('[data-category]:not(.hidden)').length;
            updateBadgeCount(visibleBadges);
        }, 400);
    }
    
    function updateBadgeCount(count) {
        // Ajouter un indicateur de nombre de badges visibles
        let countIndicator = $('#badge-count');
        if (countIndicator.length === 0) {
            countIndicator = $('<small id="badge-count" class="text-muted ms-2"></small>');
            $('h2').first().append(countIndicator);
        }
        countIndicator.text(`(${count} badge${count > 1 ? 's' : ''} affiché${count > 1 ? 's' : ''})`);
    }
    
    // Événements de filtrage
    $('input[name="status"], select[name="category"]').on('change', filterBadges);
    
    // Modal de détails des badges
    $('#badgeModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const badge = button.data('badge');
        
        $('#modal-badge-title').text(badge.nom);
        
        let content = `
            <div class="text-center mb-4">
                <div class="trophy-icon ${badge.obtained ? 'obtained' : 'locked'} mx-auto">
                    <i class="${badge.icon} fa-3x"></i>
                </div>
                <h4 class="mt-3">${badge.nom}</h4>
                <p class="text-muted">${badge.description}</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-target me-2"></i>Critères</h6>
                    <p class="text-muted">${badge.criteres}</p>
                    
                    <h6><i class="fas fa-star me-2"></i>Récompenses</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-coins text-warning me-2"></i>${badge.points} points</li>
                        <li><i class="fas fa-gift text-info me-2"></i>${badge.recompense}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6><i class="fas fa-chart-line me-2"></i>Progression</h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar bg-${badge.color}" style="width: ${badge.progression}%"></div>
                    </div>
                    <p class="text-muted">${badge.progression.toFixed(1)}% complété</p>
                    
                    ${badge.obtained ? `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Badge obtenu !</strong><br>
                            <em>"${badge.message_marketing}"</em>
                        </div>
                    ` : `
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Continuez vos efforts !</strong><br>
                            Vous êtes sur la bonne voie pour débloquer ce badge.
                        </div>
                    `}
                </div>
            </div>
        `;
        
        $('#modal-badge-content').html(content);
    });
    
    // Animation des barres de progression
    function animateProgressBars() {
        $('.progress-bar').each(function() {
            const width = $(this).css('width');
            $(this).css('width', '0').animate({width: width}, 1500);
        });
    }
    
    // Vérification des nouveaux badges
    function checkNewBadges() {
        $.get('{{ route("entreprise.badges.check-new") }}')
            .done(function(response) {
                if (response.new_badges && response.new_badges.length > 0) {
                    showNewBadgeModal(response.new_badges[0]);
                }
            })
            .fail(function() {
                console.log('Erreur lors de la vérification des nouveaux badges');
            });
    }
    
    function showNewBadgeModal(badge) {
        const badgeHtml = `
            <div class="new-badge-display">
                <div class="trophy-icon obtained mb-3 mx-auto">
                    <i class="${badge.icon} fa-3x"></i>
                </div>
                <h4 class="text-primary mb-2">${badge.nom}</h4>
                <p class="text-muted mb-3">${badge.description}</p>
                <div class="alert alert-success">
                    <em>"${badge.message_marketing}"</em>
                </div>
                <div class="trophy-rewards">
                    <div class="reward-item">
                        <i class="fas fa-star text-warning"></i>
                        <span>+${badge.points} points</span>
                    </div>
                    <div class="reward-item">
                        <i class="fas fa-gift text-info"></i>
                        <span>${badge.recompense}</span>
                    </div>
                </div>
            </div>
        `;
        
        $('#new-badge-info').html(badgeHtml);
        $('#congratulationsModal').modal('show');
        
        // Animation de confettis
        showConfetti();
    }
    
    function showConfetti() {
        const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ffc107', '#28a745'];
        
        for (let i = 0; i < 100; i++) {
            setTimeout(() => {
                const confetti = $('<div>').css({
                    position: 'fixed',
                    top: '-10px',
                    left: Math.random() * window.innerWidth + 'px',
                    width: '8px',
                    height: '8px',
                    backgroundColor: colors[Math.floor(Math.random() * colors.length)],
                    zIndex: 9999,
                    pointerEvents: 'none',
                    borderRadius: '50%'
                });
                
                $('body').append(confetti);
                
                confetti.animate({
                    top: window.innerHeight + 'px',
                    left: '+=' + (Math.random() * 300 - 150) + 'px',
                    opacity: 0
                }, 4000, function() {
                    $(this).remove();
                });
            }, i * 30);
        }
    }
    
    // Initialisation
    filterBadges();
    animateProgressBars();
    
    // Vérifier les nouveaux badges au chargement
    setTimeout(checkNewBadges, 2000);
    
    // Animation au survol des trophées
    $('.trophy-card').on('mouseenter', function() {
        if ($(this).hasClass('trophy-obtained')) {
            $(this).find('.trophy-icon').addClass('animate__animated animate__pulse');
        }
    }).on('mouseleave', function() {
        $(this).find('.trophy-icon').removeClass('animate__animated animate__pulse');
    });
    
    // Effet de clic sur les badges obtenus
    $('.trophy-obtained').on('click', function(e) {
        if (!$(e.target).is('button')) {
            $(this).addClass('animate__animated animate__heartBeat');
            setTimeout(() => {
                $(this).removeClass('animate__animated animate__heartBeat');
            }, 1000);
        }
    });
});
</script>
@endpush