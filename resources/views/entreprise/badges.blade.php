@extends('layouts.entreprise')

@section('title', 'Salle de Trophées')

@section('content')
<div class="container px-4">
    <!-- Message aléatoire d'accueil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-primary border-0 shadow-sm" style="background: linear-gradient(135deg, #14224F, #1e3a8a); color: white;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-trophy fa-2x me-3" style="color: #f6cd45;"></i>
                    <div>
                        <h4 class="mb-1">{{ $messageAleatoire }}</h4>
                        <p class="mb-0 opacity-75">Bienvenue dans votre salle de trophées personnelle</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- En-tête avec barre de progression globale -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #f8f9fa, #ffffff);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">
                                <i class="fas fa-trophy me-2" style="color: #f6cd45;"></i>
                                Salle de Trophées
                                <span class="badge bg-primary ms-2">{{ $stats['badges_obtenus'] }}/{{ $stats['total_badges'] }}</span>
                            </h2>
                            <p class="text-muted mb-3">Découvrez vos récompenses et progressions dans votre aventure RH</p>
                            
                            <!-- Barre de progression globale -->
                            <div class="progress mb-2" style="height: 12px; border-radius: 10px;">
                                <div class="progress-bar bg-gradient-warning" 
                                     style="width: {{ $stats['pourcentage_completion'] }}%; border-radius: 10px;"
                                     data-bs-toggle="tooltip" 
                                     title="{{ number_format($stats['pourcentage_completion'], 1) }}% de progression">
                                </div>
                            </div>
                            <small class="text-muted">
                                <strong>{{ number_format($stats['pourcentage_completion'], 1) }}%</strong> de badges débloqués
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="niveau-badge">
                                <div class="niveau-circle">
                                    <i class="fas fa-crown fa-2x"></i>
                                    <div class="niveau-text">
                                        <strong>{{ $stats['niveau_entreprise'] }}</strong>
                                        <small>{{ $stats['points_total'] }} pts</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card obtained">
                <div class="stat-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['badges_obtenus'] }}</h3>
                    <p>Badges obtenus</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card progress container">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['pourcentage_completion'], 1) }}%</h3>
                    <p>Progression</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card points">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['points_total'] }}</h3>
                    <p>Points gagnés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card level">
                <div class="stat-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['niveau_entreprise'] }}</h3>
                    <p>Niveau actuel</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres améliorés -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8 col-md-12">
                            <div class="filter-section">
                                <h6 class="filter-section-title">
                                    <i class="fas fa-filter me-2"></i>
                                    Catégories
                                    <span class="filter-indicator" id="category-indicator">Tous</span>
                                </h6>
                                <div class="filter-tabs">
                                    <input type="radio" class="btn-check" name="category" id="all" value="all" checked>
                                    <label class="filter-tab" for="all">
                                        <i class="fas fa-th-large"></i>
                                        <span class="filter-text">Tous</span>
                                        <span class="filter-count" data-category="all">{{ count($badges) }}</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="category" id="recrutement" value="recrutement">
                                    <label class="filter-tab" for="recrutement">
                                        <i class="fas fa-handshake"></i>
                                        <span class="filter-text">Recrutement</span>
                                        <span class="filter-count" data-category="recrutement">0</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="category" id="activite" value="activite">
                                    <label class="filter-tab" for="activite">
                                        <i class="fas fa-chart-line"></i>
                                        <span class="filter-text">Activité</span>
                                        <span class="filter-count" data-category="activite">0</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="category" id="performance" value="performance">
                                    <label class="filter-tab" for="performance">
                                        <i class="fas fa-target"></i>
                                        <span class="filter-text">Performance</span>
                                        <span class="filter-count" data-category="performance">0</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="category" id="special" value="special">
                                    <label class="filter-tab" for="special">
                                        <i class="fas fa-gem"></i>
                                        <span class="filter-text">Spéciaux</span>
                                        <span class="filter-count" data-category="special">0</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="filter-section">
                                <h6 class="filter-section-title">
                                    <i class="fas fa-eye me-2"></i>
                                    Statut
                                    <span class="filter-indicator" id="status-indicator">Tous</span>
                                </h6>
                                <div class="status-filters">
                                    <input type="radio" class="btn-check" name="status" id="obtained" value="obtained">
                                    <label class="status-filter obtained" for="obtained">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="filter-text">Obtenus</span>
                                        <span class="filter-count">{{ $stats['badges_obtenus'] }}</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="status" id="locked" value="locked">
                                    <label class="status-filter locked" for="locked">
                                        <i class="fas fa-lock"></i>
                                        <span class="filter-text">Verrouillés</span>
                                        <span class="filter-count">{{ $stats['total_badges'] - $stats['badges_obtenus'] }}</span>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="status" id="available" value="available" checked>
                                    <label class="status-filter all" for="available">
                                        <i class="fas fa-eye"></i>
                                        <span class="filter-text">Tous</span>
                                        <span class="filter-count">{{ $stats['total_badges'] }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grille des badges avec effet immersif -->
    <div class="badges-container">
        <div class="row g-4" id="badges-grid">
            @foreach($badges as $badge)
                <div class="col-xl-3 col-lg-4 col-md-6 badge-item" 
                     data-category="{{ $badge['category'] }}" 
                     data-status="{{ $badge['obtained'] ? 'obtained' : 'available' }}">
                    <div class="card h-100 d-flex flex-column trophy-card {{ $badge['obtained'] ? 'trophy-obtained' : 'trophy-locked' }}" 
                         data-badge-id="{{ $badge['id'] }}">
                        
                        <!-- Effet de brillance pour les badges obtenus -->
                        @if($badge['obtained'])
                            <div class="shine-effect"></div>
                        @else
                            <div class="lock-overlay">
                                <i class="fas fa-lock fa-2x"></i>
                            </div>
                        @endif
                        
                        <div class="card-header trophy-header border-0 bg-transparent text-center">
                            <div class="trophy-icon {{ $badge['obtained'] ? 'obtained' : 'locked' }}">
                                <i class="{{ $badge['icon'] }} fa-2x"></i>
                            </div>
                            @if($badge['obtained'])
                                <div class="trophy-date">
                                    {{ $badge['date_obtention']->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body trophy-content text-center">
                            <h5 class="card-title trophy-title">{{ $badge['nom'] }}</h5>
                            <p class="card-text trophy-description">{{ $badge['description'] }}</p>
                            
                            @if($badge['obtained'])
                                <div class="trophy-message">
                                    <i class="fas fa-quote-left"></i>
                                    <em>{{ $badge['message_marketing'] }}</em>
                                </div>
                                
                                <div class="trophy-rewards">
                                    <div class="reward-item">
                                        <i class="fas fa-star text-warning"></i>
                                        <span>+{{ $badge['points'] }} pts</span>
                                    </div>
                                    <div class="reward-item">
                                        <i class="fas fa-gift text-info"></i>
                                        <span>{{ $badge['recompense'] }}</span>
                                    </div>
                                </div>
                            @else
                                <!-- Barre de progression -->
                                <div class="progress-section">
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $badge['color'] }}" 
                                             style="width: {{ $badge['progression'] }}%"
                                             data-bs-toggle="tooltip" 
                                             title="{{ number_format($badge['progression'], 1) }}% complété">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ number_format($badge['progression'], 1) }}% complété
                                    </small>
                                </div>
                                
                                <div class="unlock-hint">
                                    <i class="fas fa-info-circle"></i>
                                    <span>{{ $badge['criteres'] }}</span>
                                </div>
                            @endif
                        </div>
                        
                        
                        <!-- Bouton d'action -->
                        <div class="card-footer trophy-action border-0 bg-transparent text-center">
                            <button class="btn btn-sm {{ $badge['obtained'] ? 'btn-success' : 'btn-outline-primary' }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#badgeModal" 
                                    data-badge='@json($badge)'>
                                @if($badge['obtained'])
                                    <i class="fas fa-eye me-1"></i>Détails
                                @else
                                    <i class="fas fa-target me-1"></i>Objectif
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Prochains objectifs -->
    @if(count($prochains_objectifs) > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-target me-2"></i>
                        Prochains Objectifs
                        <span class="badge bg-light text-primary ms-2">{{ count($prochains_objectifs) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($prochains_objectifs as $objectif)
                            <div class="col-md-6 col-lg-4 mb-3">
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
                                                {{ number_format($objectif['progression'], 1) }}% complété
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
    @endif
</div>

<!-- Modal détaillé pour les badges -->
<div class="modal fade" id="badgeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trophy me-2"></i>
                    <span id="modal-badge-title">Détails du Badge</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-5">
                <div class="congratulations-animation mb-4">
                    <i class="fas fa-trophy fa-4x text-warning"></i>
                </div>
                <h3 class="text-primary mb-3">🎉 Félicitations ! 🎉</h3>
                <p class="lead mb-4">Vous avez obtenu un nouveau badge !</p>
                <div id="new-badge-info">
                    <!-- Informations du nouveau badge -->
                </div>
                <button type="button" class="btn btn-primary btn-lg" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>Continuer l'aventure
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styles pour la salle de trophées */
.badges-container {
    position: relative;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%);
    border-radius: 25px;
    padding: 2rem;
    margin: 1rem 0;
}

.trophy-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 25px;
    padding: 0;
    height: 100%;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    border: 3px solid transparent;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.5);
}

.trophy-card .card-header {
    padding: 1.5rem 1rem 1rem;
    background: transparent !important;
    border: none !important;
}

.trophy-card .card-body {
    padding: 0 1.5rem 1rem;
    flex-grow: 1;
}

.trophy-card .card-footer {
    padding: 1rem 1.5rem 1.5rem;
    background: transparent !important;
    border: none !important;
}

.trophy-card:hover {
    transform: translateY(-12px) scale(1.03) rotateX(5deg);
    box-shadow: 0 25px 60px rgba(0,0,0,0.2), 0 0 30px rgba(20, 34, 79, 0.1);
    border-color: rgba(20, 34, 79, 0.3);
}

.trophy-obtained {
    border-color: #28a745;
    background: linear-gradient(145deg, #ffffff 0%, #f0fff4 50%, #e8f5e8 100%);
    box-shadow: 0 12px 35px rgba(40, 167, 69, 0.25), 0 0 20px rgba(40, 167, 69, 0.1);
    position: relative;
}

.trophy-obtained::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    border-radius: 25px;
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.trophy-locked {
    border-color: #dee2e6;
    background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 50%, #dee2e6 100%);
    opacity: 0.7;
    filter: grayscale(0.3);
}

.trophy-obtained:hover {
    border-color: #20c997;
    box-shadow: 0 30px 70px rgba(40, 167, 69, 0.4), 0 0 40px rgba(40, 167, 69, 0.2);
    transform: translateY(-15px) scale(1.05) rotateX(8deg);
}

/* Effet de brillance amélioré */
.shine-effect {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, 
        transparent 20%, 
        rgba(255,255,255,0.1) 40%, 
        rgba(255,255,255,0.4) 50%, 
        rgba(255,255,255,0.1) 60%, 
        transparent 80%);
    transform: rotate(45deg);
    animation: shine 4s infinite;
    z-index: 2;
}

@keyframes shine {
    0% { transform: translateX(-150%) translateY(-150%) rotate(45deg); }
    50% { transform: translateX(0%) translateY(0%) rotate(45deg); }
    100% { transform: translateX(150%) translateY(150%) rotate(45deg); }
}

/* Effet de particules flottantes */
.trophy-obtained::after {
    content: '';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 6px;
    height: 6px;
    background: #ffd700;
    border-radius: 50%;
    box-shadow: 
        15px 10px 0 #ffd700,
        -10px 20px 0 #ff6b6b,
        20px -5px 0 #4ecdc4,
        -15px -10px 0 #45b7d1;
    animation: float-particles 6s infinite;
}

@keyframes float-particles {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
    25% { transform: translateY(-10px) rotate(90deg); opacity: 1; }
    50% { transform: translateY(-5px) rotate(180deg); opacity: 0.8; }
    75% { transform: translateY(-15px) rotate(270deg); opacity: 1; }
}



/* Overlay de verrouillage */
.lock-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #6c757d;
    opacity: 0.4;
    z-index: 1;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(5px);
}

/* Icône de trophée améliorée */
.trophy-icon {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 3px solid transparent;
}

.trophy-icon.obtained {
    background: linear-gradient(145deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
    color: white;
    box-shadow: 
        0 12px 30px rgba(40, 167, 69, 0.4),
        inset 0 2px 0 rgba(255,255,255,0.3),
        inset 0 -2px 0 rgba(0,0,0,0.1);
    animation: trophy-pulse 3s infinite;
    border-color: rgba(255,255,255,0.3);
}

.trophy-icon.obtained::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(45deg, #ffd700, #ff6b6b, #4ecdc4, #45b7d1);
    border-radius: 50%;
    z-index: -1;
    animation: rotate-border 4s linear infinite;
    opacity: 0.7;
}

@keyframes rotate-border {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.trophy-icon.locked {
    background: linear-gradient(145deg, #e9ecef 0%, #dee2e6 100%);
    color: #6c757d;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

@keyframes trophy-pulse {
    0%, 100% { 
        box-shadow: 
            0 12px 30px rgba(40, 167, 69, 0.4),
            inset 0 2px 0 rgba(255,255,255,0.3),
            inset 0 -2px 0 rgba(0,0,0,0.1);
        transform: scale(1);
    }
    50% { 
        box-shadow: 
            0 15px 40px rgba(40, 167, 69, 0.6),
            inset 0 2px 0 rgba(255,255,255,0.4),
            inset 0 -2px 0 rgba(0,0,0,0.1);
        transform: scale(1.05);
    }
}

/* Date d'obtention */
.trophy-date {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 500;
}

/* Contenu du trophée */
.trophy-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.trophy-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.trophy-message {
    background: #f8f9fa;
    border-left: 4px solid #28a745;
    padding: 0.75rem;
    margin: 1rem 0;
    border-radius: 0 8px 8px 0;
    font-style: italic;
    color: #495057;
}

/* Récompenses */
.trophy-rewards {
    display: flex;
    justify-content: space-around;
    margin: 1rem 0;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.reward-item {
    text-align: center;
    font-size: 0.85rem;
    font-weight: 600;
}

.reward-item i {
    display: block;
    margin-bottom: 0.25rem;
    font-size: 1.2rem;
}

/* Section de progression */
.progress-section {
    margin: 1rem 0;
}

.unlock-hint {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
    border-radius: 8px;
    padding: 0.5rem;
    font-size: 0.8rem;
    color: #1976d2;
    margin-top: 0.5rem;
}

/* Action du trophée */
.trophy-action {
    text-align: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

/* Statistiques rapides */
.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-card.obtained {
    border-color: #28a745;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.stat-card.progress {
    border-color: #17a2b8;
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.stat-card.points {
    border-color: #ffc107;
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: white;
}

.stat-card.level {
    border-color: #6f42c1;
    background: linear-gradient(135deg, #6f42c1, #5a32a3);
    color: white;
}

.stat-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-content p {
    margin: 0;
    opacity: 0.9;
    font-weight: 500;
}

/* Filtres améliorés */
.filter-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-tab {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    background: white;
    color: #6c757d;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    font-weight: 500;
}

.filter-tab:hover {
    border-color: #14224F;
    color: #14224F;
    transform: translateY(-2px);
}

.btn-check:checked + .filter-tab {
    background: #14224F;
    border-color: #14224F;
    color: white;
    box-shadow: 0 4px 15px rgba(20, 34, 79, 0.3);
}

.status-filters {
    display: flex;
    gap: 0.5rem;
}

.status-filter {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 20px;
    background: white;
    color: #6c757d;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.status-filter.obtained:hover {
    border-color: #28a745;
    color: #28a745;
}

.status-filter.all:hover {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-check:checked + .status-filter.obtained {
    background: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-check:checked + .status-filter.all {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
}

/* Niveau badge */
.niveau-badge {
    text-align: center;
}

.niveau-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f6cd45, #ffd700);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: #14224F;
    box-shadow: 0 8px 20px rgba(246, 205, 69, 0.4);
    animation: level-glow 3s infinite;
}

@keyframes level-glow {
    0%, 100% { box-shadow: 0 8px 20px rgba(246, 205, 69, 0.4); }
    50% { box-shadow: 0 8px 30px rgba(246, 205, 69, 0.6); }
}

.niveau-text {
    text-align: center;
    margin-top: 0.25rem;
}

.niveau-text strong {
    display: block;
    font-size: 0.9rem;
    font-weight: 700;
}

.niveau-text small {
    font-size: 0.7rem;
    opacity: 0.8;
}

/* Objectifs */
.objective-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.objective-card:hover {
    border-color: #14224F;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.objective-icon {
    width: 60px;
    text-align: center;
}

/* Animation de félicitations */
.congratulations-animation {
    animation: bounce-celebration 1s infinite;
}

@keyframes bounce-celebration {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-15px);
    }
    60% {
        transform: translateY(-8px);
    }
}

/* Masquer les badges filtrés */
.badge-item.hidden {
    display: none;
}

/* Effets d'entrée en scène */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.trophy-card {
    animation: fadeInUp 0.6s ease-out;
}

.trophy-card:nth-child(1) { animation-delay: 0.1s; }
.trophy-card:nth-child(2) { animation-delay: 0.2s; }
.trophy-card:nth-child(3) { animation-delay: 0.3s; }
.trophy-card:nth-child(4) { animation-delay: 0.4s; }
.trophy-card:nth-child(5) { animation-delay: 0.5s; }
.trophy-card:nth-child(6) { animation-delay: 0.6s; }

.stats-card {
    animation: fadeInScale 0.8s ease-out;
}

.welcome-message {
    animation: fadeInUp 0.8s ease-out;
}

.global-progress {
    animation: fadeInUp 1s ease-out 0.3s both;
}

/* Effet de survol global */
.badges-container:hover .trophy-card:not(:hover) {
    opacity: 0.7;
    transform: scale(0.95);
}

/* Responsive amélioré */
@media (max-width: 768px) {
    .trophy-card {
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        border-radius: 20px;
    }
    
    .trophy-icon {
        width: 70px;
        height: 70px;
    }
    
    .trophy-icon i {
        font-size: 1.5rem !important;
    }
    
    .stats-number {
        font-size: 2.5rem;
    }
    
    .filter-btn {
        padding: 0.6rem 1.5rem;
        font-size: 0.8rem;
        margin: 0.3rem;
    }
    
    .filter-tabs {
        justify-content: center;
    }
    
    .status-filters {
        justify-content: center;
        margin-top: 1rem;
    }
    
    .welcome-message {
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .main-trophy-title {
        font-size: 2rem;
    }
    
    .main-trophy-title::before,
    .main-trophy-title::after {
        display: none;
    }
    
    .global-progress {
        height: 20px;
        margin: 1rem 0;
    }
    
    .stats-card {
        padding: 1.5rem;
    }
    
    .niveau-circle {
        width: 80px;
        height: 80px;
    }
}

@media (max-width: 576px) {
    .badges-container {
        padding: 1rem;
        margin: 0.5rem 0;
    }
    
    .trophy-card {
        padding: 1rem;
    }
    
    .welcome-message {
        padding: 1.5rem;
    }
    
    .main-trophy-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
    }
}

/* Barre de progression globale améliorée */
.global-progress {
    background: linear-gradient(145deg, #e9ecef 0%, #dee2e6 100%);
    border-radius: 50px;
    height: 25px;
    overflow: hidden;
    position: relative;
    margin: 1.5rem 0;
    box-shadow: 
        inset 0 3px 6px rgba(0,0,0,0.15),
        0 2px 8px rgba(0,0,0,0.1);
    border: 2px solid rgba(255,255,255,0.8);
}

.global-progress-bar {
    background: linear-gradient(135deg, #28a745 0%, #20c997 25%, #17a2b8 50%, #6f42c1 75%, #e83e8c 100%);
    height: 100%;
    border-radius: 50px;
    transition: width 2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 
        0 0 20px rgba(40, 167, 69, 0.4),
        inset 0 2px 0 rgba(255,255,255,0.3);
}

.global-progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(255,255,255,0.2) 25%, 
        rgba(255,255,255,0.4) 50%, 
        rgba(255,255,255,0.2) 75%, 
        transparent 100%);
    animation: progress-shine 3s infinite;
}

.global-progress-bar::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    right: 2px;
    height: 4px;
    background: linear-gradient(90deg, rgba(255,255,255,0.6), rgba(255,255,255,0.2));
    border-radius: 50px;
}

@keyframes progress-shine {
    0% { transform: translateX(-150%); }
    100% { transform: translateX(150%); }
}

/* Titre principal amélioré */
.main-trophy-title {
    background: linear-gradient(135deg, #14224f 0%, #1a2b63 50%, #2c3e50 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 900;
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    font-size: 2.5rem;
    text-shadow: 0 4px 8px rgba(0,0,0,0.1);
    animation: title-glow 4s infinite alternate;
}

@keyframes title-glow {
    0% { filter: drop-shadow(0 0 5px rgba(20, 34, 79, 0.3)); }
    100% { filter: drop-shadow(0 0 15px rgba(20, 34, 79, 0.6)); }
}

.main-trophy-title::before {
    content: '🏆';
    position: absolute;
    left: -60px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2rem;
    animation: trophy-bounce 2s infinite;
}

.main-trophy-title::after {
    content: '🏆';
    position: absolute;
    right: -60px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2rem;
    animation: trophy-bounce 2s infinite 0.5s;
}

@keyframes trophy-bounce {
    0%, 100% { transform: translateY(-50%) scale(1); }
    50% { transform: translateY(-60%) scale(1.1); }
}

/* Message d'accueil amélioré */
.welcome-message {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #e3f2fd 100%);
    border: 3px solid transparent;
    background-clip: padding-box;
    border-radius: 25px;
    padding: 2.5rem;
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 
        0 15px 35px rgba(0,0,0,0.1),
        inset 0 2px 0 rgba(255,255,255,0.8);
    backdrop-filter: blur(10px);
}

.welcome-message::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #28a745, #20c997, #17a2b8, #6f42c1, #e83e8c, #28a745);
    border-radius: 25px;
    z-index: -1;
    animation: border-rotate 6s linear infinite;
}

@keyframes border-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.welcome-message::after {
    content: '';
    position: absolute;
    top: 10px;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(255,255,255,0.2) 25%, 
        rgba(255,255,255,0.4) 50%, 
        rgba(255,255,255,0.2) 75%, 
        transparent 100%);
    animation: welcome-shine 4s infinite;
    z-index: 1;
}

@keyframes welcome-shine {
    0% { left: -100%; }
    100% { left: 100%; }
}

.welcome-message h4 {
    position: relative;
    z-index: 2;
    background: linear-gradient(135deg, #14224f 0%, #1a2b63 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    margin-bottom: 1rem;
}

.welcome-message p {
    position: relative;
    z-index: 2;
    color: #495057;
    font-weight: 500;
}

/* Statistiques améliorées */
.stats-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    border: 3px solid transparent;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 
        0 10px 30px rgba(0,0,0,0.1),
        inset 0 1px 0 rgba(255,255,255,0.6);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, #28a745, #20c997, #17a2b8, #6f42c1);
    opacity: 0;
    transition: opacity 0.4s ease;
    border-radius: 20px;
    z-index: -1;
}

.stats-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 
        0 20px 50px rgba(0,0,0,0.15),
        0 0 30px rgba(40, 167, 69, 0.2);
    border-color: rgba(40, 167, 69, 0.3);
}

.stats-card:hover::before {
    opacity: 0.1;
}

.stats-number {
    font-size: 3rem;
    font-weight: 900;
    background: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.8rem;
    position: relative;
    animation: number-pulse 3s infinite;
}

@keyframes number-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.stats-label {
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.85rem;
    position: relative;
}

.stats-label::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #28a745, #20c997);
    transition: width 0.4s ease;
}

.stats-card:hover .stats-label::after {
    width: 60px;
}

/* Section de filtres */
.filter-section {
    margin-bottom: 1.5rem;
}

.filter-section-title {
    color: #495057;
    font-weight: 700;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filter-indicator {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: none;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    animation: indicator-pulse 2s infinite;
}

@keyframes indicator-pulse {
    0%, 100% { box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3); }
    50% { box-shadow: 0 4px 15px rgba(40, 167, 69, 0.5); }
}

/* Filtres de catégories */
.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
    align-items: center;
}

.filter-tab {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border: 3px solid #e9ecef;
    border-radius: 25px;
    padding: 0.8rem 1.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 600;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.8rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 120px;
    justify-content: center;
}

.filter-tab i {
    font-size: 1rem;
    transition: transform 0.3s ease;
}

.filter-tab .filter-text {
    flex: 1;
    text-align: center;
}

.filter-count {
    background: #6c757d;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    transition: all 0.3s ease;
}

.filter-tab::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(40, 167, 69, 0.1), transparent);
    transition: left 0.4s ease;
}

.filter-tab:hover::before {
    left: 100%;
}

.filter-tab:hover {
    border-color: #28a745;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2);
}

.filter-tab:hover i {
    transform: scale(1.1) rotate(5deg);
}

.filter-tab:hover .filter-count {
    background: #28a745;
    transform: scale(1.1);
}

.btn-check:checked + .filter-tab {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #20c997;
    color: white;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 
        0 10px 30px rgba(40, 167, 69, 0.4),
        0 0 20px rgba(40, 167, 69, 0.2);
    animation: active-filter 2s infinite;
}

.btn-check:checked + .filter-tab .filter-count {
    background: rgba(255, 255, 255, 0.9);
    color: #28a745;
    font-weight: 800;
}

@keyframes active-filter {
    0%, 100% { box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4), 0 0 20px rgba(40, 167, 69, 0.2); }
    50% { box-shadow: 0 15px 40px rgba(40, 167, 69, 0.6), 0 0 30px rgba(40, 167, 69, 0.4); }
}

/* Filtres de statut */
.status-filters {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.status-filter {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border: 3px solid #e9ecef;
    border-radius: 20px;
    padding: 0.8rem 1.2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 600;
    position: relative;
    overflow: hidden;
    font-size: 0.85rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    justify-content: space-between;
}

.status-filter i {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.status-filter .filter-text {
    flex: 1;
}

.status-filter .filter-count {
    background: #6c757d;
    color: white;
    border-radius: 15px;
    padding: 0.2rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 700;
    min-width: 30px;
    text-align: center;
    transition: all 0.3s ease;
}

.status-filter:hover {
    border-color: #28a745;
    transform: translateX(5px) scale(1.02);
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.2);
}

.status-filter:hover i {
    transform: scale(1.1);
}

.status-filter:hover .filter-count {
    background: #28a745;
    transform: scale(1.05);
}

.btn-check:checked + .status-filter {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #20c997;
    color: white;
    transform: translateX(8px) scale(1.05);
    box-shadow: 
        0 8px 25px rgba(40, 167, 69, 0.4),
        0 0 15px rgba(40, 167, 69, 0.2);
}

.btn-check:checked + .status-filter .filter-count {
    background: rgba(255, 255, 255, 0.9);
    color: #28a745;
    font-weight: 800;
}

/* Styles spécifiques pour les différents statuts */
.status-filter.obtained:hover {
    border-color: #28a745;
}

.btn-check:checked + .status-filter.obtained {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.status-filter.locked:hover {
    border-color: #dc3545;
}

.btn-check:checked + .status-filter.locked {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border-color: #c82333;
}

.btn-check:checked + .status-filter.locked .filter-count {
    color: #dc3545;
}

.status-filter.all:hover {
    border-color: #17a2b8;
}

.btn-check:checked + .status-filter.all {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border-color: #138496;
}

.btn-check:checked + .status-filter.all .filter-count {
    color: #17a2b8;
}

/* Modal amélioré */
.modal-content {
    border-radius: 25px;
    border: none;
    box-shadow: 
        0 25px 80px rgba(0,0,0,0.3),
        0 0 50px rgba(20, 34, 79, 0.1);
    backdrop-filter: blur(10px);
    overflow: hidden;
}

.modal-header {
    border-bottom: 3px solid transparent;
    border-radius: 25px 25px 0 0;
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #e3f2fd 100%);
    position: relative;
    padding: 2rem;
}

.modal-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #28a745, #20c997, #17a2b8);
}

.modal-body {
    padding: 2.5rem;
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    position: relative;
}

.modal-body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23000" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    pointer-events: none;
}

.modal-footer {
    border-top: 3px solid transparent;
    border-radius: 0 0 25px 25px;
    background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    padding: 2rem;
}

.modal-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #28a745, #20c997, #17a2b8);
}

.modal-title {
    background: linear-gradient(135deg, #14224f 0%, #1a2b63 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    font-size: 1.5rem;
}

/* Gradients personnalisés */
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #14224F) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
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
                $(this).removeClass('hidden').fadeIn(400);
            } else {
                $(this).addClass('hidden').fadeOut(400);
            }
        });
        
        // Mettre à jour le compteur
        setTimeout(function() {
            const visibleBadges = $('.badge-item:not(.hidden)').length;
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
    $('input[name="category"], input[name="status"]').on('change', filterBadges);
    
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