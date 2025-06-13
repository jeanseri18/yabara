@extends('layouts.entreprise')

@section('title', 'Mes Badges')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-trophy me-2" style="color: #f6cd45;"></i>Mes Badges</h2>
                    <p class="text-muted mb-0">Découvrez vos récompenses et progressions</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de progression -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 text-white" style="background-color: #1040BB;">
                <div class="card-body text-center">
                    <i class="fas fa-medal fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ $stats['badges_obtenus'] }}</h3>
                    <small>Badges obtenus</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 text-white" style="background-color: #071D55;">
                <div class="card-body text-center">
                    <i class="fas fa-percentage fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ number_format($stats['pourcentage_completion'], 1) }}%</h3>
                    <small>Progression totale</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0" style="background-color: #f6cd45; color: #071D55;">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ $stats['points_total'] }}</h3>
                    <small>Points gagnés</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-gradient-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-crown fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ $stats['niveau_entreprise'] }}</h3>
                    <small>Niveau entreprise</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="btn-group" role="group" id="categoryFilters">
                                <input type="radio" class="btn-check" name="category" id="all" value="all" checked>
                                <label class="btn btn-outline-primary" for="all">Tous</label>
                                
                                <input type="radio" class="btn-check" name="category" id="recrutement" value="recrutement">
                                <label class="btn btn-outline-primary" for="recrutement">Recrutement</label>
                                
                                <input type="radio" class="btn-check" name="category" id="activite" value="activite">
                                <label class="btn btn-outline-primary" for="activite">Activité</label>
                                
                                <input type="radio" class="btn-check" name="category" id="performance" value="performance">
                                <label class="btn btn-outline-primary" for="performance">Performance</label>
                                
                                <input type="radio" class="btn-check" name="category" id="special" value="special">
                                <label class="btn btn-outline-primary" for="special">Spéciaux</label>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="status" id="obtained" value="obtained">
                                <label class="btn btn-outline-success" for="obtained">Obtenus</label>
                                
                                <input type="radio" class="btn-check" name="status" id="available" value="available" checked>
                                <label class="btn btn-outline-secondary" for="available">Tous</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des badges -->
    <div class="row g-4" id="badges-grid">
        @foreach($badges as $badge)
            <div class="col-lg-4 col-md-6 badge-item" 
                 data-category="{{ $badge['category'] }}" 
                 data-status="{{ $badge['obtained'] ? 'obtained' : 'available' }}">
                <div class="card badge-card h-100 {{ $badge['obtained'] ? 'badge-obtained' : 'badge-locked' }}">
                    <div class="card-body text-center position-relative">
                        <!-- Badge obtenu indicator -->
                        @if($badge['obtained'])
                            <div class="badge-obtained-indicator">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="badge-date">
                                {{ $badge['date_obtention']->format('d/m/Y') }}
                            </div>
                        @endif
                        
                        <!-- Icône du badge -->
                        <div class="badge-icon mb-3 {{ $badge['obtained'] ? 'obtained' : 'locked' }}">
                            <i class="{{ $badge['icon'] }} fa-3x"></i>
                        </div>
                        
                        <!-- Informations du badge -->
                        <h5 class="badge-title mb-2">{{ $badge['nom'] }}</h5>
                        <p class="badge-description text-muted mb-3">{{ $badge['description'] }}</p>
                        
                        <!-- Progression -->
                        @if(!$badge['obtained'])
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-{{ $badge['color'] }}" 
                                     style="width: {{ $badge['progression'] }}%"
                                     data-bs-toggle="tooltip" 
                                     title="{{ $badge['valeur_actuelle'] }}/{{ $badge['valeur_requise'] }}"></div>
                            </div>
                            <small class="text-muted">
                                {{ $badge['valeur_actuelle'] }}/{{ $badge['valeur_requise'] }} 
                                ({{ number_format($badge['progression'], 1) }}%)
                            </small>
                        @else
                            <div class="badge-rewards">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <i class="fas fa-star text-warning"></i>
                                        <small class="d-block">+{{ $badge['points'] }} pts</small>
                                    </div>
                                    <div class="col-6">
                                        <i class="fas fa-gift text-info"></i>
                                        <small class="d-block">{{ $badge['recompense'] }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Critères -->
                        <div class="badge-criteria mt-3">
                            <button class="btn btn-sm btn-outline-secondary" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#criteria-{{ $badge['id'] }}">
                                <i class="fas fa-info-circle me-1"></i>Critères
                            </button>
                            <div class="collapse mt-2" id="criteria-{{ $badge['id'] }}">
                                <div class="card card-body bg-light">
                                    <small class="text-muted">{{ $badge['criteres'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Section des récompenses -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-gift me-2"></i>Mes Récompenses</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="reward-item">
                                <div class="d-flex align-items-center">
                                    <div class="reward-icon bg-primary text-white me-3">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Visibilité renforcée</h6>
                                        <small class="text-muted">Vos offres apparaissent en priorité</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="reward-item">
                                <div class="d-flex align-items-center">
                                    <div class="reward-icon bg-success text-white me-3">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Crédits bonus</h6>
                                        <small class="text-muted">{{ $stats['credits_disponibles'] }} crédits disponibles</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="reward-item">
                                <div class="d-flex align-items-center">
                                    <div class="reward-icon bg-warning text-white me-3">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Réductions</h6>
                                        <small class="text-muted">Jusqu'à {{ $stats['reduction_max'] }}% sur les services</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Prochains objectifs -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0"><i class="fas fa-target me-2"></i>Prochains Objectifs</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($prochains_objectifs as $objectif)
                            <div class="col-md-6 mb-3">
                                <div class="objective-card">
                                    <div class="d-flex align-items-center">
                                        <div class="objective-icon me-3">
                                            <i class="{{ $objectif['icon'] }} fa-2x text-{{ $objectif['color'] }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $objectif['nom'] }}</h6>
                                            <div class="progress mb-1" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $objectif['color'] }}" 
                                                     style="width: {{ $objectif['progression'] }}%"></div>
                                            </div>
                                            <small class="text-muted">
                                                {{ $objectif['valeur_actuelle'] }}/{{ $objectif['valeur_requise'] }}
                                                ({{ number_format($objectif['progression'], 1) }}%)
                                            </small>
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
</div>

<!-- Modal de félicitations -->
<div class="modal fade" id="congratulationsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="congratulations-animation mb-4">
                    <i class="fas fa-trophy fa-4x text-warning"></i>
                </div>
                <h3 class="text-primary mb-3">Félicitations !</h3>
                <p class="lead mb-4">Vous avez obtenu un nouveau badge !</p>
                <div id="new-badge-info">
                    <!-- Informations du nouveau badge -->
                </div>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>Continuer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    overflow: hidden;
}

.badge-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.badge-obtained {
    border-color: #28a745;
    background: linear-gradient(135deg, #fff 0%, #f8fff9 100%);
}

.badge-locked {
    border-color: #dee2e6;
    background: #f8f9fa;
}

.badge-obtained:hover {
    border-color: #20c997;
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.2);
}

.badge-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    transition: all 0.3s ease;
}

.badge-icon.obtained {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.badge-icon.locked {
    background: #e9ecef;
    color: #6c757d;
}

.badge-obtained-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #28a745;
    color: white;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.badge-date {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
}

.badge-title {
    font-weight: 600;
    color: #2c3e50;
}

.badge-description {
    font-size: 0.875rem;
    line-height: 1.4;
}

.badge-rewards {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

.reward-item {
    padding: 1rem;
    border-radius: 8px;
    background: #f8f9fa;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.reward-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.reward-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.objective-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.objective-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.objective-icon {
    width: 60px;
    text-align: center;
}

.congratulations-animation {
    animation: bounce 1s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.badge-item {
    transition: all 0.3s ease;
}

.badge-item.hidden {
    display: none;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

@media (max-width: 768px) {
    .badge-icon {
        width: 60px;
        height: 60px;
    }
    
    .badge-icon i {
        font-size: 2rem !important;
    }
    
    .reward-icon {
        width: 40px;
        height: 40px;
    }
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
        const selectedCategory = $('input[name="category"]:checked').val();
        const selectedStatus = $('input[name="status"]:checked').val();
        
        $('.badge-item').each(function() {
            const category = $(this).data('category');
            const status = $(this).data('status');
            
            let showCategory = selectedCategory === 'all' || category === selectedCategory;
            let showStatus = selectedStatus === 'available' || status === selectedStatus;
            
            if (showCategory && showStatus) {
                $(this).removeClass('hidden').fadeIn(300);
            } else {
                $(this).addClass('hidden').fadeOut(300);
            }
        });
        
        // Mettre à jour le compteur
        setTimeout(function() {
            const visibleBadges = $('.badge-item:not(.hidden)').length;
            updateBadgeCount(visibleBadges);
        }, 300);
    }
    
    function updateBadgeCount(count) {
        // Ajouter un indicateur de nombre de badges visibles si nécessaire
        let countIndicator = $('#badge-count');
        if (countIndicator.length === 0) {
            countIndicator = $('<small id="badge-count" class="text-muted ms-2"></small>');
            $('h2').append(countIndicator);
        }
        countIndicator.text(`(${count} badge${count > 1 ? 's' : ''})`);
    }
    
    // Événements de filtrage
    $('input[name="category"], input[name="status"]').on('change', filterBadges);
    
    // Vérification des nouveaux badges
    function checkNewBadges() {
        $.get('{{ route("entreprise.badges.check-new") }}')
            .done(function(response) {
                if (response.new_badges && response.new_badges.length > 0) {
                    showNewBadgeModal(response.new_badges[0]);
                }
            });
    }
    
    function showNewBadgeModal(badge) {
        const badgeHtml = `
            <div class="new-badge-display">
                <div class="badge-icon obtained mb-3">
                    <i class="${badge.icon} fa-3x"></i>
                </div>
                <h4 class="text-primary mb-2">${badge.nom}</h4>
                <p class="text-muted mb-3">${badge.description}</p>
                <div class="badge-rewards">
                    <div class="row text-center">
                        <div class="col-6">
                            <i class="fas fa-star text-warning fa-2x"></i>
                            <p class="mb-0"><strong>+${badge.points} points</strong></p>
                        </div>
                        <div class="col-6">
                            <i class="fas fa-gift text-info fa-2x"></i>
                            <p class="mb-0"><strong>${badge.recompense}</strong></p>
                        </div>
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
                    pointerEvents: 'none',
                    borderRadius: '50%'
                });
                
                $('body').append(confetti);
                
                confetti.animate({
                    top: window.innerHeight + 'px',
                    left: '+=' + (Math.random() * 200 - 100) + 'px',
                    opacity: 0
                }, 3000, function() {
                    $(this).remove();
                });
            }, i * 50);
        }
    }
    
    // Animation des barres de progression
    function animateProgressBars() {
        $('.progress-bar').each(function() {
            const width = $(this).css('width');
            $(this).css('width', '0').animate({width: width}, 1000);
        });
    }
    
    // Initialisation
    filterBadges();
    animateProgressBars();
    
    // Vérifier les nouveaux badges au chargement
    setTimeout(checkNewBadges, 1000);
    
    // Animation au survol des badges
    $('.badge-card').on('mouseenter', function() {
        $(this).find('.badge-icon').addClass('animate__animated animate__pulse');
    }).on('mouseleave', function() {
        $(this).find('.badge-icon').removeClass('animate__animated animate__pulse');
    });
    
    // Effet de clic sur les badges obtenus
    $('.badge-obtained').on('click', function() {
        $(this).addClass('animate__animated animate__heartBeat');
        setTimeout(() => {
            $(this).removeClass('animate__animated animate__heartBeat');
        }, 1000);
    });
});
</script>
@endpush