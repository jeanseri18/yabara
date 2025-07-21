@extends('layouts.entreprise')

@section('title', 'Sélectionner une offre')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-briefcase me-2" style="color: #14224F;"></i>Sélectionner une offre</h2>
                    <p class="text-muted mb-0">Choisissez une offre d'emploi pour voir les candidatures</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des offres -->
    <div class="row">
        @forelse($offres as $offre)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="offre-card h-100" 
                     onclick="window.location.href='{{ route('entreprise.candidatures.kanban', ['offre' => $offre->id]) }}'">
                    
                    <!-- Header avec titre et bouton modifier -->
                    <div class="offre-header">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="offre-title">{{ $offre->titre }}</h3>
                            <button class="btn-modifier" onclick="event.stopPropagation(); window.location.href='{{ route('entreprise.offres.edit', $offre->id) }}'">
                                Modifier
                            </button>
                        </div>
                        
                        <!-- Badge CDI/CDD -->
                        <div class="mb-3">
                            <span class="badge-contrat">{{ $offre->typeContrat->nom ?? 'CDI' }}</span>
                        </div>
                    </div>

                    <!-- Informations entreprise -->
                    <div class="offre-company mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="company-logo">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="ms-3">
                                <div class="company-name">{{ $offre->entreprise->nom_entreprise ?? 'Entreprise' }}</div>
                                <div class="company-sector">{{ $offre->familleMetier->nom ?? 'Secteur non spécifié' }}</div>
                            </div>
                        </div>
                        
                        <div class="company-location">
                            <i class="fas fa-map-marker-alt me-2"></i>{{ $offre->lieu_poste ?? 'Non spécifiée' }}
                        </div>
                    </div>

                    <!-- Badges d'information -->
                    <div class="offre-badges mb-4">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="info-badge">
                                <i class="fas fa-graduation-cap me-1"></i>BAC + {{ $offre->niveau_diplome_requis ?? '3' }}
                            </span>
                            <span class="info-badge">
                                <i class="fas fa-clock me-1"></i>{{ $offre->experience_minimum  ?? '2-5 ' }} ans expérience
                            </span>
                            <span class="info-badge">
                                <i class="fas fa-users me-1"></i>{{ $offre->familleMetier->nom ?? 'Ressources Humaines' }}
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="offre-description mb-4">
                        <h4>Descriptif du poste</h4>
                        <p>{{ $offre->descriptif ? Str::limit($offre->descriptif, 120) : 'Ajoutez ici le descriptif complet pour le poste à pourvoir. Parlez des missions, de l\'environnement de travail, des compétences essentielles, etc.' }}</p>
                    </div>

                    <!-- Footer avec référence et statistiques -->
                    <div class="offre-footer">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="offre-reference">
                                <i class="fas fa-file-alt me-2"></i>Référence {{ $offre->reference_offre }}
                            </span>
                            <span class="offre-date">{{ $offre->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <!-- Statistiques des candidatures -->
                        <div class="candidatures-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $offre->candidatures_count ?? 0 }}</div>
                                <div class="stat-label">Candidatures</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $offre->candidatures->where('statut', 'preselctionnee')->count() ?? 0 }}</div>
                                <div class="stat-label">Présélectionnées</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $offre->candidatures->where('statut', 'retenue')->count() ?? 0 }}</div>
                                <div class="stat-label">Recrutées</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-briefcase fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucune offre d'emploi</h4>
                    <p class="text-muted mb-4">Vous n'avez pas encore publié d'offres d'emploi.</p>
                    <a href="{{ route('entreprise.offres.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Publier une offre
                    </a>
                </div>
            </div>
        @endforelse
    </div>
    
    @if($offres->count() > 0)
        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $offres->links() }}
            </div>
        </div>
    @endif
</div>

<style>
.offre-card {
    background:  #14224F;
    border-radius: 20px;
    padding: 24px;
    color: white;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    /* box-shadow: 0 4px 20px rgba(0,0,0,0.1); */
    position: relative;
    overflow: hidden;
}

.offre-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.2);
}

.offre-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.offre-header {
    position: relative;
    z-index: 2;
}

.offre-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #F6CD45;
    margin: 0;
    line-height: 1.2;
}

.btn-modifier {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-modifier:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-2px);
}

.badge-contrat {
    background: #F6CD45;
    color: #14224F;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.offre-company {
    position: relative;
    z-index: 2;
}

.company-logo {
    width: 48px;
    height: 48px;
    background: #FF6B35;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.company-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    margin-bottom: 2px;
}

.company-sector {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.7);
}

.company-location {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.8);
    margin-top: 8px;
}

.offre-badges {
    position: relative;
    z-index: 2;
}

.info-badge {
    background: rgba(255,255,255,0.15);
    color: white;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.offre-description {
    position: relative;
    z-index: 2;
}

.offre-description h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #F6CD45;
    margin-bottom: 12px;
}

.offre-description p {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.8);
    line-height: 1.5;
    margin: 0;
}

.offre-footer {
    position: relative;
    z-index: 2;
}

.offre-reference {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
}

.offre-date {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.7);
}

.candidatures-stats {
    display: flex;
    justify-content: space-between;
    background: rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #F6CD45;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.7);
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .offre-card {
        padding: 20px;
    }
    
    .offre-title {
        font-size: 1.3rem;
    }
    
    .candidatures-stats {
        flex-direction: column;
        gap: 12px;
    }
    
    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-number {
        font-size: 1.2rem;
        margin-bottom: 0;
    }
}
</style>
@endsection