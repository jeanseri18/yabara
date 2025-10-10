@extends('layouts.admin')

@section('title', 'Recherche de Talents - Assistant RH')
@section('page-title', 'Assistant RH Intelligent')

@push('styles')
<style>
    /* Variables CSS */
    :root {
        --primary-color: #0066FF;
        --secondary-color: #f6cd45;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    /* Layout principal */
    .talent-search-container {
        display: flex;
        min-height: calc(100vh - 120px);
        gap: 1.5rem;
    }

    /* Sidebar Assistant */
    .search-sidebar {
        width: 350px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 1rem;
    }

    .assistant-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-100);
    }

    .assistant-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), #4f46e5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .results-counter {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .counter-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        display: block;
    }

    /* Navigation par pôles */
    .poles-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .poles-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .pole-tab {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
    }

    .pole-tab:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
    }

    .pole-tab.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .pole-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .pole-name {
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1.2;
    }

    /* Familles de métiers */
    .familles-section {
        margin-bottom: 1.5rem;
    }

    .familles-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .famille-card {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .famille-card:hover {
        background: var(--gray-100);
        border-color: var(--primary-color);
    }

    .famille-card.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .famille-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: var(--primary-color);
        font-size: 0.875rem;
    }

    .famille-card.active .famille-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    /* Filtres d'expérience */
    .experience-buttons {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .btn-experience {
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 0.75rem 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-experience:hover {
        background: var(--gray-100);
        border-color: var(--primary-color);
    }

    .btn-experience.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    /* Slider de diplôme */
    .diploma-section {
        margin-bottom: 1.5rem;
    }

    .diploma-slider {
        margin: 1rem 0;
    }

    .filter-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .filter-options .btn-experience {
        grid-column: span 2;
    }

    .filter-options .btn-experience:first-child {
        grid-column: span 2;
    }

    /* Styles pour les filtres */
    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        background: white;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .filter-select:disabled {
        background: var(--gray-100);
        color: var(--gray-500);
        cursor: not-allowed;
    }

    /* Boutons d'action */
    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 2rem;
    }

    .btn-search, .btn-reset {
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-search {
        background: var(--primary-color);
        color: white;
    }

    .btn-search:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .btn-reset:hover {
        background: var(--gray-300);
        transform: translateY(-1px);
    }

    /* Tags de filtres actifs */
    .active-filters {
        margin-bottom: 1.5rem;
    }

    .filter-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .filter-tag {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-tag .remove {
        cursor: pointer;
        font-weight: 700;
    }

    /* Zone de résultats */
    .results-area {
        flex: 1;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .results-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-100);
    }

    .results-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .view-toggle {
        display: flex;
        background: var(--gray-100);
        border-radius: 8px;
        padding: 0.25rem;
    }

    .view-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-btn.active {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Cartes de talents */
    .talents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .talent-card {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .talent-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .talent-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .talent-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), #4f46e5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .talent-info h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0 0 0.25rem 0;
    }

    .talent-reference {
        font-size: 0.875rem;
        color: var(--primary-color);
        font-weight: 500;
    }

    .talent-details {
        margin-bottom: 1rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--gray-100);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.875rem;
        color: var(--gray-500);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-900);
    }

    /* Actions rapides */
    .talent-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .action-btn {
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--gray-200);
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .action-btn.primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .action-btn.success {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .action-btn.warning {
        background: var(--warning-color);
        border-color: var(--warning-color);
        color: white;
    }

    .action-btn.secondary {
        background: var(--gray-100);
        border-color: var(--gray-200);
        color: var(--gray-700);
    }

    /* Badge de statut */
    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-disponible {
        background: #dcfce7;
        color: #166534;
    }

    .status-recherche {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-indisponible {
        background: #fef2f2;
        color: #991b1b;
    }

    /* Favoris */
    .favorite-btn {
        position: absolute;
        top: 1rem;
        left: 1rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: white;
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .favorite-btn:hover {
        background: var(--warning-color);
        border-color: var(--warning-color);
        color: white;
    }

    .favorite-btn.active {
        background: var(--warning-color);
        border-color: var(--warning-color);
        color: white;
    }

    /* États vides */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gray-500);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: var(--gray-300);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .talent-search-container {
            flex-direction: column;
        }
        
        .search-sidebar {
            width: 100%;
            position: static;
        }
        
        .poles-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .poles-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .talents-grid {
            grid-template-columns: 1fr;
        }
        
        .experience-buttons {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="p-6">
    <div class="talent-search-container">
        <!-- Sidebar Assistant RH -->
        <div class="search-sidebar">
            <!-- En-tête Assistant -->
            <div class="assistant-header">
                <div class="assistant-icon">
                    <i class="bi bi-robot"></i>
                </div>
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">Assistant RH Intelligent</h2>
                <p style="font-size: 0.875rem; color: var(--gray-500); margin: 0.5rem 0 0 0;">Trouvez le talent parfait</p>
            </div>

            <!-- Compteur de résultats -->
            <div class="results-counter">
                <span class="counter-number" id="resultsCount">{{ $talents->total() }}</span>
                <span style="font-size: 0.875rem; color: var(--gray-600);">talents correspondant(s)</span>
            </div>

            <!-- Sélection du pôle -->
            <div class="filter-group">
                <label for="pole-select" class="filter-label">
                    <i class="bi bi-grid-3x3-gap"></i>
                    Pôle métier
                </label>
                <select id="pole-select" class="form-select filter-select">
                    <option value="">Tous les pôles</option>
                    @if(isset($poles))
                        @foreach($poles as $pole)
                            <option value="{{ $pole->id }}">{{ $pole->nom }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Sélection des familles de métiers -->
            <div class="filter-group">
                <label for="famille-select" class="filter-label">
                    <i class="bi bi-briefcase"></i>
                    Famille de métier
                </label>
                <select id="famille-select" class="form-select filter-select" disabled>
                    <option value="">Sélectionnez d'abord un pôle</option>
                </select>
            </div>

            <!-- Sélection de l'expérience -->
            <div class="filter-group">
                <label for="experience-select" class="filter-label">
                    <i class="bi bi-clock-history"></i>
                    Années d'expérience
                </label>
                <select id="experience-select" class="form-select filter-select">
                    <option value="">Toutes les expériences</option>
                    <option value="0">0-2 ans</option>
                    <option value="3">3-5 ans</option>
                    <option value="6">6-10 ans</option>
                    <option value="10">10+ ans</option>
                </select>
            </div>

            <!-- Sélection du niveau de diplôme -->
            <div class="filter-group">
                <label for="diplome-select" class="filter-label">
                    <i class="bi bi-mortarboard"></i>
                    Niveau de diplôme
                </label>
                <select id="diplome-select" class="form-select filter-select">
                    <option value="">Tous les diplômes</option>
                    @if(isset($niveauxDiplomes))
                        @foreach($niveauxDiplomes as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Filtres actifs -->
            <div class="active-filters" id="activeFilters" style="display: none;">
                <div class="section-title">
                    <i class="bi bi-funnel"></i>
                    Filtres actifs
                </div>
                <div class="filter-tags" id="filterTags">
                    <!-- Tags générés dynamiquement -->
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="action-buttons">
                <button type="button" class="btn-search" onclick="performSearch()">
                    <i class="bi bi-search"></i>
                    Rechercher
                </button>
                <button type="button" class="btn-reset" onclick="resetAllFilters()">
                    <i class="bi bi-arrow-clockwise"></i>
                    Réinitialiser
                </button>
            </div>
        </div>

        <!-- Zone de résultats -->
        <div class="results-area">
            <!-- En-tête des résultats -->
            <div class="results-header">
                <div>
                    <h1 class="results-title">Talents trouvés</h1>
                    <p style="color: var(--gray-500); margin: 0;">Découvrez les profils qui correspondent à vos critères</p>
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="cards">
                        <i class="bi bi-grid"></i>
                    </button>
                    <button class="view-btn" data-view="list">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            <!-- Grille des talents -->
            <div class="talents-grid" id="talentsGrid">
                @if($talents->count() > 0)
                    @foreach($talents as $talent)
                    <div class="talent-card" data-talent-id="{{ $talent->id }}">
                        <!-- Bouton favori -->
                        <button class="favorite-btn" onclick="toggleFavorite({{ $talent->id }})">
                            <i class="bi bi-star"></i>
                        </button>

                        <!-- Badge de statut -->
                        @if($talent->talent)
                            @if($talent->talent->disponibilite == 'disponible')
                                <div class="status-badge status-disponible">
                                    <i class="bi bi-check-circle"></i> Disponible
                                </div>
                            @elseif($talent->talent->disponibilite == 'en_recherche')
                                <div class="status-badge status-recherche">
                                    <i class="bi bi-search"></i> En recherche
                                </div>
                            @else
                                <div class="status-badge status-indisponible">
                                    <i class="bi bi-pause-circle"></i> Indisponible
                                </div>
                            @endif
                        @endif

                        <!-- En-tête du talent -->
                        <div class="talent-header">
                            <div class="talent-avatar">
                                @if($talent->talent && $talent->talent->avatar_type)
                                    <img src="{{ asset('storage/avatars/'.$talent->talent->avatar_type) }}" 
                                         alt="{{ $talent->name }}" 
                                         class="rounded-circle" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <i class="fas fa-user" style="font-size: 24px;"></i>
                                @endif
                            </div>
                            <div class="talent-info">
                                <h3>{{ $talent->name }}</h3>
                                <div class="talent-reference">
                                    @if($talent->talent && $talent->talent->cv_reference)
                                        <i class="bi bi-file-earmark-text"></i> {{ $talent->talent->cv_reference }}
                                    @else
                                        <i class="bi bi-file-earmark-text"></i> REF-{{ str_pad($talent->id, 4, '0', STR_PAD_LEFT) }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Détails du talent -->
                        <div class="talent-details">
                            @if($talent->talent)
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="bi bi-briefcase"></i>
                                        Pôle
                                    </div>
                                    <div class="detail-value">{{ $talent->talent->pole->nom ?? 'Non spécifié' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="bi bi-tools"></i>
                                        Famille
                                    </div>
                                    <div class="detail-value">{{ $talent->talent->familleMetier->nom ?? 'Non spécifiée' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="bi bi-clock-history"></i>
                                        Expérience
                                    </div>
                                    <div class="detail-value">
                                        @php
                                            $totalExp = 0;
                                            if($talent->talent->experiencesProfessionnelles) {
                                                foreach($talent->talent->experiencesProfessionnelles as $exp) {
                                                    $debut = \Carbon\Carbon::parse($exp->date_debut);
                                                    $fin = $exp->date_fin ? \Carbon\Carbon::parse($exp->date_fin) : \Carbon\Carbon::now();
                                                    $totalExp += $debut->diffInYears($fin);
                                                }
                                            }
                                        @endphp
                                        {{ $totalExp }} ans
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">
                                        <i class="bi bi-mortarboard"></i>
                                        Diplôme
                                    </div>
                                    <div class="detail-value">{{ $talent->talent->niveauDiplome->nom ?? 'Non spécifié' }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions rapides -->
                        <div class="talent-actions">
                            <button class="action-btn primary" onclick="viewProfile({{ $talent->id }})">
                                <i class="bi bi-eye"></i>
                                Voir profil
                            </button>
                            <button class="action-btn success" onclick="linkToOffer({{ $talent->id }})">
                                <i class="bi bi-link-45deg"></i>
                                Lier offre
                            </button>
                            <button class="action-btn warning" onclick="shareToCompany({{ $talent->id }})">
                                <i class="bi bi-share"></i>
                                Partager
                            </button>
                            <button class="action-btn secondary" onclick="contactTalent({{ $talent->id }})">
                                <i class="bi bi-envelope"></i>
                                Contacter
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Aucun talent trouvé</h3>
                        <p>Essayez d'ajuster vos critères de recherche pour trouver plus de résultats.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($talents->hasPages())
                <div style="margin-top: 2rem; display: flex; justify-content: center;">
                    {{ $talents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Variables globales
let currentFilters = {
    pole: '',
    famille: '',
    experience: '',
    diplome: ''
};

let favorites = JSON.parse(localStorage.getItem('talent_favorites') || '[]');

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    initializeFilters();
    loadFavorites();
    updateResultsCount();
    
    // Gestionnaire pour le bouton de recherche
    const searchBtn = document.querySelector('.btn-search');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            performSearch();
        });
    }
    
    // Gestionnaire pour le bouton de réinitialisation
    const resetBtn = document.querySelector('.btn-reset');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            resetAllFilters();
        });
    }
});

// Initialiser tous les filtres
function initializeFilters() {
    initializeSelectFilters();
}

// Initialiser les filtres select
function initializeSelectFilters() {
    const poleSelect = document.getElementById('pole-select');
    const familleSelect = document.getElementById('famille-select');
    const experienceSelect = document.getElementById('experience-select');
    const diplomeSelect = document.getElementById('diplome-select');
    
    // Gestionnaire pour pôle
    if (poleSelect) {
        poleSelect.addEventListener('change', function() {
            const poleValue = this.value;
            currentFilters.pole = poleValue;
            
            // Charger les familles de métiers pour ce pôle
            loadFamillesMetiers(poleValue);
            
            // Mettre à jour les filtres actifs
            updateActiveFilters();
            updateResultsCount();
        });
    }
    
    // Gestionnaire pour famille de métier
    if (familleSelect) {
        familleSelect.addEventListener('change', function() {
            currentFilters.famille = this.value;
            updateActiveFilters();
            updateResultsCount();
        });
    }
    
    // Gestionnaire pour expérience
    if (experienceSelect) {
        experienceSelect.addEventListener('change', function() {
            currentFilters.experience = this.value;
            updateActiveFilters();
            updateResultsCount();
        });
    }
    
    // Gestionnaire pour diplôme
    if (diplomeSelect) {
        diplomeSelect.addEventListener('change', function() {
            currentFilters.diplome = this.value;
            updateActiveFilters();
            updateResultsCount();
        });
    }
}



// Charger les familles de métiers
function loadFamillesMetiers(poleId) {
    const familleSelect = document.getElementById('famille-select');
    
    if (!familleSelect) {
        console.error('Element famille-select non trouvé');
        return;
    }
    
    // Réinitialiser le select
    familleSelect.innerHTML = '<option value="">Toutes les familles</option>';
    
    if (poleId) {
        // Activer le select
        familleSelect.disabled = false;
        
        // Utiliser les données simulées pour le moment
        const familles = getFamillesByPole(poleId);
        familles.forEach(famille => {
            const option = document.createElement('option');
            option.value = famille.id;
            option.textContent = famille.nom;
            familleSelect.appendChild(option);
        });
    } else {
        // Désactiver le select si aucun pôle sélectionné
        familleSelect.disabled = true;
        familleSelect.innerHTML = '<option value="">Sélectionnez d\'abord un pôle</option>';
    }
    
    // Réinitialiser la valeur sélectionnée
    currentFilters.famille = '';
    familleSelect.value = '';
}

// Fonction utilitaire pour obtenir les familles par pôle (simulation)
function getFamillesByPole(poleId) {
    // Mapping des familles par pôle ID
    const famillesData = {
        '1': [{id: 1, nom: 'Développement Web'}, {id: 2, nom: 'UX/UI Design'}, {id: 3, nom: 'Data Science'}],
        '2': [{id: 4, nom: 'Génie Civil'}, {id: 5, nom: 'Mécanique'}, {id: 6, nom: 'Électricité'}],
        '3': [{id: 7, nom: 'Comptabilité'}, {id: 8, nom: 'Finance'}, {id: 9, nom: 'Ressources Humaines'}],
        '4': [{id: 10, nom: 'Vente B2B'}, {id: 11, nom: 'Marketing Digital'}, {id: 12, nom: 'Relation Client'}],
        '5': [{id: 13, nom: 'Artisanat'}, {id: 14, nom: 'Services à la personne'}, {id: 15, nom: 'Restauration'}]
    };
    return famillesData[poleId] || [];
}

// Fonction de recherche
function performSearch() {
    const searchBtn = document.querySelector('.btn-search');
    const originalText = searchBtn.textContent;
    
    // Animation du bouton
    searchBtn.textContent = 'Recherche...';
    searchBtn.disabled = true;
    
    // Collecter les filtres actifs
    const filters = {
        pole: document.getElementById('pole-select').value,
        famille: document.getElementById('famille-select').value,
        experience: document.getElementById('experience-select').value,
        diplome: document.getElementById('diplome-select').value
    };
    
    // Construire l'URL avec les paramètres de recherche
    const params = new URLSearchParams();
    if (filters.pole) params.append('pole', filters.pole);
    if (filters.famille) params.append('famille', filters.famille);
    if (filters.experience) params.append('experience', filters.experience);
    if (filters.diplome) params.append('diplome', filters.diplome);
    
    // Rediriger vers la page avec les filtres
    const url = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    
    // Restaurer le bouton avant la redirection
    searchBtn.textContent = originalText;
    searchBtn.disabled = false;
    
    // Rediriger
    window.location.href = url;
}

// Fonction de réinitialisation
function resetAllFilters() {
    // Réinitialiser tous les select
    document.getElementById('pole-select').value = '';
    document.getElementById('famille-select').value = '';
    document.getElementById('experience-select').value = '';
    document.getElementById('diplome-select').value = '';
    
    // Désactiver le select des familles
    const familleSelect = document.getElementById('famille-select');
    familleSelect.disabled = true;
    familleSelect.innerHTML = '<option value="">Sélectionnez d\'abord un pôle</option>';
    
    // Réinitialiser les filtres actuels
    currentFilters = {
        pole: '',
        famille: '',
        experience: '',
        diplome: ''
    };
    
    // Mettre à jour l'affichage
    updateActiveFilters();
    updateResultsCount();
    
    // Afficher un message de confirmation
    showNotification('Filtres réinitialisés', 'info');
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Supprimer automatiquement après 3 secondes
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Mettre à jour les filtres actifs
function updateActiveFilters() {
    const activeFiltersDiv = document.getElementById('activeFilters');
    const filterTagsDiv = document.getElementById('filterTags');
    
    let tags = [];
    
    // Ajouter les tags pour chaque filtre actif
    if (currentFilters.pole) {
        const poleTab = document.querySelector(`[data-pole="${currentFilters.pole}"]`);
        if (poleTab) {
            tags.push({
                type: 'pole',
                label: poleTab.querySelector('.pole-name').textContent,
                value: currentFilters.pole
            });
        }
    }
    
    if (currentFilters.famille) {
        const familleSelect = document.getElementById('familleSelect');
        const selectedOption = familleSelect.options[familleSelect.selectedIndex];
        if (selectedOption) {
            tags.push({
                type: 'famille',
                label: selectedOption.textContent,
                value: currentFilters.famille
            });
        }
    }
    
    if (currentFilters.experience) {
        const experienceSelect = document.getElementById('experienceSelect');
        const selectedOption = experienceSelect.options[experienceSelect.selectedIndex];
        if (selectedOption) {
            tags.push({
                type: 'experience',
                label: selectedOption.textContent,
                value: currentFilters.experience
            });
        }
    }
    
    if (currentFilters.diplome) {
        const diplomeSelect = document.getElementById('diplomeSelect');
        const selectedOption = diplomeSelect.options[diplomeSelect.selectedIndex];
        if (selectedOption) {
            tags.push({
                type: 'diplome',
                label: selectedOption.textContent,
                value: currentFilters.diplome
            });
        }
    }
    
    // Afficher ou masquer la section des filtres actifs
    if (tags.length > 0) {
        activeFiltersDiv.style.display = 'block';
        filterTagsDiv.innerHTML = tags.map(tag => `
            <div class="filter-tag" data-type="${tag.type}" data-value="${tag.value}">
                <span>${tag.label}</span>
                <span class="remove" onclick="removeFilter('${tag.type}', '${tag.value}')">
                    ×
                </span>
            </div>
        `).join('');
    } else {
        activeFiltersDiv.style.display = 'none';
    }
}

// Supprimer un filtre
function removeFilter(type, value) {
    switch(type) {
        case 'pole':
            currentFilters.pole = '';
            const poleSelect = document.getElementById('pole-select');
            if (poleSelect) {
                poleSelect.value = '';
                loadFamillesMetiers('');
            }
            break;
        case 'famille':
            currentFilters.famille = '';
            const familleSelect = document.getElementById('famille-select');
            if (familleSelect) {
                familleSelect.value = '';
            }
            break;
        case 'experience':
            currentFilters.experience = '';
            const experienceSelect = document.getElementById('experience-select');
            if (experienceSelect) {
                experienceSelect.value = '';
            }
            break;
        case 'diplome':
            currentFilters.diplome = '';
            const diplomeSelect = document.getElementById('diplome-select');
            if (diplomeSelect) {
                diplomeSelect.value = '';
            }
            break;
    }
    
    updateActiveFilters();
    updateResultsCount();
}

// Réinitialiser tous les filtres
function resetAllFilters() {
    currentFilters = {
        pole: '',
        famille: '',
        experience: '',
        diplome: ''
    };
    
    // Réinitialiser les selects
    const poleSelect = document.getElementById('pole-select');
    const familleSelect = document.getElementById('famille-select');
    const experienceSelect = document.getElementById('experience-select');
    const diplomeSelect = document.getElementById('diplome-select');
    
    if (poleSelect) poleSelect.value = '';
    if (familleSelect) {
        familleSelect.value = '';
        familleSelect.disabled = true;
    }
    if (experienceSelect) experienceSelect.value = '';
    if (diplomeSelect) diplomeSelect.value = '';
    
    loadFamillesMetiers('');
    updateActiveFilters();
    updateResultsCount();
    
    showNotification('Filtres réinitialisés', 'info');
}

// Mettre à jour le compteur de résultats
function updateResultsCount() {
    // Simuler le comptage (à remplacer par une requête AJAX réelle)
    let count = {{ $talents->total() }};
    
    // Appliquer les filtres (simulation)
    if (currentFilters.pole) count = Math.floor(count * 0.7);
    if (currentFilters.famille) count = Math.floor(count * 0.5);
    if (currentFilters.experience) count = Math.floor(count * 0.6);
    if (currentFilters.diplome) count = Math.floor(count * 0.8);
    
    document.getElementById('resultsCount').textContent = count;
}

// Rechercher les talents
function searchTalents() {
    // Construire les paramètres de recherche
    const params = new URLSearchParams();
    if (currentFilters.pole) params.append('pole', currentFilters.pole);
    if (currentFilters.famille) params.append('famille', currentFilters.famille);
    if (currentFilters.experience) params.append('experience', currentFilters.experience);
    if (currentFilters.diplome) params.append('diplome', currentFilters.diplome);
    
    // Recharger la page avec les filtres
    window.location.href = window.location.pathname + '?' + params.toString();
}

// Actions sur les talents
function viewProfile(talentId) {
    // Ouvrir le profil dans un modal ou slide latéral
    console.log('Voir profil du talent:', talentId);
    // Ici, vous pouvez ouvrir un modal avec les détails du talent
}

function linkToOffer(talentId) {
    // Ouvrir une fenêtre contextuelle pour lier à une offre
    const offerRef = prompt('Référence de l\'offre d\'emploi:');
    if (offerRef) {
        console.log('Lier le talent', talentId, 'à l\'offre', offerRef);
        // Faire la requête AJAX pour lier le talent à l'offre
    }
}

function shareToCompany(talentId) {
    // Ouvrir un formulaire pour partager avec une entreprise
    console.log('Partager le talent', talentId, 'avec une entreprise');
    // Ici, vous pouvez ouvrir un modal avec la liste des entreprises
}

function contactTalent(talentId) {
    // Ouvrir l'interface de contact
    console.log('Contacter le talent:', talentId);
    // Ici, vous pouvez ouvrir un modal de composition d'email
}

// Gestion des favoris
function toggleFavorite(talentId) {
    const index = favorites.indexOf(talentId);
    const btn = document.querySelector(`[onclick="toggleFavorite(${talentId})"]`);
    
    if (index > -1) {
        // Retirer des favoris
        favorites.splice(index, 1);
        btn.classList.remove('active');
        btn.querySelector('i').className = 'bi bi-star';
    } else {
        // Ajouter aux favoris
        favorites.push(talentId);
        btn.classList.add('active');
        btn.querySelector('i').className = 'bi bi-star-fill';
    }
    
    localStorage.setItem('talent_favorites', JSON.stringify(favorites));
}

// Charger les favoris au démarrage
function loadFavorites() {
    favorites.forEach(talentId => {
        const btn = document.querySelector(`[onclick="toggleFavorite(${talentId})"]`);
        if (btn) {
            btn.classList.add('active');
            btn.querySelector('i').className = 'bi bi-star-fill';
        }
    });
}

// Basculer entre vue grille et liste
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const view = this.dataset.view;
        const talentsGrid = document.getElementById('talentsGrid');
        
        if (view === 'list') {
            talentsGrid.classList.add('list-view');
        } else {
            talentsGrid.classList.remove('list-view');
        }
    });
});
</script>
@endpush