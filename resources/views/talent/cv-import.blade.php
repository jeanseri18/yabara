@extends('layouts.talent')

@section('title', 'Mon CV - Import & Création')

@section('page-title', 'Mon CV')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header avec score de complétion -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Gestion de votre CV</h2>
                <p class="text-gray-600 mt-1">Importez votre CV existant ou créez-le manuellement</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Score de complétion</div>
                <div class="flex items-center mt-1">
                    <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                        <div class="bg-[#f6cd45] h-2 rounded-full transition-all duration-300" id="completion-bar" style="width: 0%"></div>
                    </div>
                    <span class="text-lg font-semibold text-[#0066FF]" id="completion-score">0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex">
                <button class="tab-button active py-4 px-6 text-sm font-medium border-b-2 border-[#f6cd45] text-[#0066FF]" data-tab="upload">
                    <i class="bi bi-cloud-upload mr-2"></i>
                    Importer un CV
                </button>
                <button class="tab-button py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="manual">
                    <i class="bi bi-pencil-square mr-2"></i>
                    Saisie manuelle
                </button>
                <button class="tab-button py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="preview">
                    <i class="bi bi-eye mr-2"></i>
                    Prévisualisation
                </button>
            </nav>
        </div>

        <!-- Contenu des onglets -->
        <div class="p-6">
            <!-- Onglet Upload -->
            <div id="upload-tab" class="tab-content">
                <div class="max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 hover:border-[#f6cd45] transition-colors" id="drop-zone">
                            <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Glissez-déposez votre CV ici</h3>
                            <p class="text-gray-500 mb-4">ou cliquez pour sélectionner un fichier</p>
                            <input type="file" id="cv-file" name="cv_file" accept=".pdf,.doc,.docx" class="hidden">
                            <button type="button" onclick="document.getElementById('cv-file').click()" class="bg-[#0066FF] text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Choisir un fichier
                            </button>
                            <p class="text-xs text-gray-400 mt-2">Formats acceptés: PDF, DOC, DOCX (max 5MB)</p>
                        </div>
                    </div>

                    <!-- CV existant -->
                    @if($talent && $talent->cv_original_path)
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="bi bi-file-earmark-pdf text-green-600 text-xl mr-3"></i>
                                <div>
                                    <p class="font-medium text-green-800">{{ $talent->cv_original_name }}</p>
                                    <p class="text-sm text-green-600">CV importé avec succès</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('talent.cv.view') }}" target="_blank" class="text-green-600 hover:text-green-800">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button onclick="deleteCv()" class="text-red-600 hover:text-red-800">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Barre de progression -->
                    <div id="upload-progress" class="hidden mt-6">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-[#f6cd45] h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2" id="upload-status">Upload en cours...</p>
                    </div>
                </div>
            </div>

            <!-- Onglet Saisie manuelle -->
            <div id="manual-tab" class="tab-content hidden">
                <form id="cv-form">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Colonne gauche: Formulaires -->
                        <div class="space-y-8">
                            <!-- Expériences professionnelles -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="bi bi-briefcase mr-2 text-[#0066FF]"></i>
                                        Expériences professionnelles
                                    </h3>
                                    <button type="button" onclick="addExperience()" class="bg-[#f6cd45] text-[#0066FF] px-3 py-1 rounded text-sm hover:bg-yellow-400 transition-colors">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div id="experiences-container">
                                    @forelse($experiences as $index => $experience)
                                    <div class="experience-item bg-white p-4 rounded border mb-3">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <input type="text" name="experiences[{{ $index }}][poste]" value="{{ $experience->poste }}" placeholder="Poste occupé" class="form-input">
                                            <input type="text" name="experiences[{{ $index }}][entreprise]" value="{{ $experience->entreprise }}" placeholder="Entreprise" class="form-input">
                                            <input type="month" name="experiences[{{ $index }}][date_debut]" value="{{ $experience->date_debut }}" placeholder="Date de début" class="form-input">
                                            <input type="month" name="experiences[{{ $index }}][date_fin]" value="{{ $experience->date_fin }}" placeholder="Date de fin" class="form-input" {{ $experience->en_cours ? 'disabled' : '' }}>
                                        </div>
                                        <div class="mt-3">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="experiences[{{ $index }}][en_cours]" {{ $experience->en_cours ? 'checked' : '' }} class="mr-2" onchange="toggleEndDate(this)">
                                                <span class="text-sm text-gray-600">Poste actuel</span>
                                            </label>
                                        </div>
                                        <textarea name="experiences[{{ $index }}][description]" placeholder="Description des missions et réalisations" class="form-input mt-3" rows="3">{{ $experience->description }}</textarea>
                                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-sm">Aucune expérience ajoutée. Cliquez sur "Ajouter" pour commencer.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Formations -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="bi bi-mortarboard mr-2 text-[#0066FF]"></i>
                                        Formations
                                    </h3>
                                    <button type="button" onclick="addFormation()" class="bg-[#f6cd45] text-[#0066FF] px-3 py-1 rounded text-sm hover:bg-yellow-400 transition-colors">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div id="formations-container">
                                    @forelse($formations as $index => $formation)
                                    <div class="formation-item bg-white p-4 rounded border mb-3">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <input type="text" name="formations[{{ $index }}][diplome]" value="{{ $formation->diplome }}" placeholder="Diplôme" class="form-input">
                                            <input type="text" name="formations[{{ $index }}][etablissement]" value="{{ $formation->etablissement }}" placeholder="Établissement" class="form-input">
                                            <input type="number" name="formations[{{ $index }}][annee_obtention]" value="{{ $formation->annee_obtention }}" placeholder="Année d'obtention" class="form-input" min="1950" max="2030">
                                            <input type="text" name="formations[{{ $index }}][mention]" value="{{ $formation->mention }}" placeholder="Mention (optionnel)" class="form-input">
                                        </div>
                                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-sm">Aucune formation ajoutée. Cliquez sur "Ajouter" pour commencer.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Compétences -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="bi bi-gear mr-2 text-[#0066FF]"></i>
                                        Compétences
                                    </h3>
                                    <button type="button" onclick="addCompetence()" class="bg-[#f6cd45] text-[#0066FF] px-3 py-1 rounded text-sm hover:bg-yellow-400 transition-colors">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div id="competences-container">
                                    @forelse($competences as $index => $competence)
                                    <div class="competence-item bg-white p-4 rounded border mb-3">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <input type="text" name="competences[{{ $index }}][nom]" value="{{ $competence->nom }}" placeholder="Nom de la compétence" class="form-input">
                                            <select name="competences[{{ $index }}][niveau]" class="form-input">
                                                <option value="debutant" {{ $competence->niveau == 'debutant' ? 'selected' : '' }}>Débutant</option>
                                                <option value="intermediaire" {{ $competence->niveau == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                                <option value="avance" {{ $competence->niveau == 'avance' ? 'selected' : '' }}>Avancé</option>
                                                <option value="expert" {{ $competence->niveau == 'expert' ? 'selected' : '' }}>Expert</option>
                                            </select>
                                            <select name="competences[{{ $index }}][type]" class="form-input">
                                                <option value="technique" {{ $competence->type == 'technique' ? 'selected' : '' }}>Technique</option>
                                                <option value="soft" {{ $competence->type == 'soft' ? 'selected' : '' }}>Soft Skills</option>
                                                <option value="outils" {{ $competence->type == 'outils' ? 'selected' : '' }}>Outils</option>
                                            </select>
                                        </div>
                                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-sm">Aucune compétence ajoutée. Cliquez sur "Ajouter" pour commencer.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Langues -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="bi bi-translate mr-2 text-[#0066FF]"></i>
                                        Langues
                                    </h3>
                                    <button type="button" onclick="addLangue()" class="bg-[#f6cd45] text-[#0066FF] px-3 py-1 rounded text-sm hover:bg-yellow-400 transition-colors">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                                <div id="langues-container">
                                    @forelse($langues as $index => $langue)
                                    <div class="langue-item bg-white p-4 rounded border mb-3">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <input type="text" name="langues[{{ $index }}][nom]" value="{{ $langue->nom }}" placeholder="Langue" class="form-input">
                                            <select name="langues[{{ $index }}][niveau]" class="form-input">
                                                <option value="debutant" {{ $langue->niveau == 'debutant' ? 'selected' : '' }}>Débutant</option>
                                                <option value="intermediaire" {{ $langue->niveau == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                                <option value="avance" {{ $langue->niveau == 'avance' ? 'selected' : '' }}>Avancé</option>
                                                <option value="natif" {{ $langue->niveau == 'natif' ? 'selected' : '' }}>Natif</option>
                                            </select>
                                        </div>
                                        <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-sm">Aucune langue ajoutée. Cliquez sur "Ajouter" pour commencer.</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex space-x-4">
                                <button type="submit" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                    <i class="bi bi-check-circle mr-2"></i>
                                    Sauvegarder le CV
                                </button>
                                <button type="button" onclick="previewCv()" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                                    <i class="bi bi-eye mr-2"></i>
                                    Prévisualiser
                                </button>
                            </div>
                        </div>

                        <!-- Colonne droite: Conseils -->
                        <div class="space-y-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h4 class="font-semibold text-blue-900 mb-3">
                                    <i class="bi bi-lightbulb mr-2"></i>
                                    Conseils pour un CV efficace
                                </h4>
                                <ul class="text-sm text-blue-800 space-y-2">
                                    <li class="flex items-start">
                                        <i class="bi bi-check-circle-fill text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                                        Utilisez des verbes d'action pour décrire vos expériences
                                    </li>
                                    <li class="flex items-start">
                                        <i class="bi bi-check-circle-fill text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                                        Quantifiez vos réalisations avec des chiffres
                                    </li>
                                    <li class="flex items-start">
                                        <i class="bi bi-check-circle-fill text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                                        Adaptez vos compétences au poste visé
                                    </li>
                                    <li class="flex items-start">
                                        <i class="bi bi-check-circle-fill text-blue-600 mr-2 mt-0.5 flex-shrink-0"></i>
                                        Mentionnez vos formations les plus récentes
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                <h4 class="font-semibold text-yellow-900 mb-3">
                                    <i class="bi bi-exclamation-triangle mr-2"></i>
                                    Points d'attention
                                </h4>
                                <ul class="text-sm text-yellow-800 space-y-2">
                                    <li class="flex items-start">
                                        <i class="bi bi-dot"></i>
                                        Évitez les informations personnelles sensibles
                                    </li>
                                    <li class="flex items-start">
                                        <i class="bi bi-dot"></i>
                                        Vérifiez l'orthographe et la grammaire
                                    </li>
                                    <li class="flex items-start">
                                        <i class="bi bi-dot"></i>
                                        Restez concis et pertinent
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Onglet Prévisualisation -->
            <div id="preview-tab" class="tab-content hidden">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white border rounded-lg p-8" id="cv-preview">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->talent->first_name ?? 'Prénom' }} {{ Auth::user()->talent->last_name ?? 'Nom' }}</h2>
                            <p class="text-gray-600">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Expériences -->
                        <div id="preview-experiences" class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Expériences professionnelles</h3>
                            <div id="experiences-list"></div>
                        </div>

                        <!-- Formations -->
                        <div id="preview-formations" class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Formations</h3>
                            <div id="formations-list"></div>
                        </div>

                        <!-- Compétences -->
                        <div id="preview-competences" class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Compétences</h3>
                            <div id="competences-list"></div>
                        </div>

                        <!-- Langues -->
                        <div id="preview-langues">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Langues</h3>
                            <div id="langues-list"></div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <button onclick="window.print()" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-printer mr-2"></i>
                            Imprimer le CV
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-input {
    @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
}

.tab-button.active {
    @apply border-[#f6cd45] text-[#0066FF];
}

.tab-content {
    @apply block;
}

.tab-content.hidden {
    @apply hidden;
}

@media print {
    body * {
        visibility: hidden;
    }
    #cv-preview, #cv-preview * {
        visibility: visible;
    }
    #cv-preview {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>

<script>
// Variables globales
let experienceIndex = {{ $experiences->count() }};
let formationIndex = {{ $formations->count() }};
let competenceIndex = {{ $competences->count() }};
let langueIndex = {{ $langues->count() }};

// Gestion des onglets
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les onglets
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Désactiver tous les onglets
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Activer l'onglet sélectionné
            this.classList.add('active');
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Mettre à jour la prévisualisation si nécessaire
            if (tabName === 'preview') {
                updatePreview();
            }
        });
    });

    // Initialiser le score de complétion
    updateCompletionScore();

    // Gestion du drag & drop
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('cv-file');

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-[#f6cd45]');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-[#f6cd45]');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-[#f6cd45]');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            uploadCv();
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            uploadCv();
        }
    });

    // Gestion du formulaire
    document.getElementById('cv-form').addEventListener('submit', function(e) {
        e.preventDefault();
        saveCvData();
    });
});

// Fonctions pour ajouter des éléments
function addExperience() {
    const container = document.getElementById('experiences-container');
    const emptyMessage = container.querySelector('p');
    if (emptyMessage) emptyMessage.remove();
    
    const html = `
        <div class="experience-item bg-white p-4 rounded border mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="experiences[${experienceIndex}][poste]" placeholder="Poste occupé" class="form-input">
                <input type="text" name="experiences[${experienceIndex}][entreprise]" placeholder="Entreprise" class="form-input">
                <input type="month" name="experiences[${experienceIndex}][date_debut]" placeholder="Date de début" class="form-input">
                <input type="month" name="experiences[${experienceIndex}][date_fin]" placeholder="Date de fin" class="form-input">
            </div>
            <div class="mt-3">
                <label class="flex items-center">
                    <input type="checkbox" name="experiences[${experienceIndex}][en_cours]" class="mr-2" onchange="toggleEndDate(this)">
                    <span class="text-sm text-gray-600">Poste actuel</span>
                </label>
            </div>
            <textarea name="experiences[${experienceIndex}][description]" placeholder="Description des missions et réalisations" class="form-input mt-3" rows="3"></textarea>
            <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    experienceIndex++;
}

function addFormation() {
    const container = document.getElementById('formations-container');
    const emptyMessage = container.querySelector('p');
    if (emptyMessage) emptyMessage.remove();
    
    const html = `
        <div class="formation-item bg-white p-4 rounded border mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="formations[${formationIndex}][diplome]" placeholder="Diplôme" class="form-input">
                <input type="text" name="formations[${formationIndex}][etablissement]" placeholder="Établissement" class="form-input">
                <input type="number" name="formations[${formationIndex}][annee_obtention]" placeholder="Année d'obtention" class="form-input" min="1950" max="2030">
                <input type="text" name="formations[${formationIndex}][mention]" placeholder="Mention (optionnel)" class="form-input">
            </div>
            <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    formationIndex++;
}

function addCompetence() {
    const container = document.getElementById('competences-container');
    const emptyMessage = container.querySelector('p');
    if (emptyMessage) emptyMessage.remove();
    
    const html = `
        <div class="competence-item bg-white p-4 rounded border mb-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="competences[${competenceIndex}][nom]" placeholder="Nom de la compétence" class="form-input">
                <select name="competences[${competenceIndex}][niveau]" class="form-input">
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire" selected>Intermédiaire</option>
                    <option value="avance">Avancé</option>
                    <option value="expert">Expert</option>
                </select>
                <select name="competences[${competenceIndex}][type]" class="form-input">
                    <option value="technique" selected>Technique</option>
                    <option value="soft">Soft Skills</option>
                    <option value="outils">Outils</option>
                </select>
            </div>
            <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    competenceIndex++;
}

function addLangue() {
    const container = document.getElementById('langues-container');
    const emptyMessage = container.querySelector('p');
    if (emptyMessage) emptyMessage.remove();
    
    const html = `
        <div class="langue-item bg-white p-4 rounded border mb-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="langues[${langueIndex}][nom]" placeholder="Langue" class="form-input">
                <select name="langues[${langueIndex}][niveau]" class="form-input">
                    <option value="debutant">Débutant</option>
                    <option value="intermediaire" selected>Intermédiaire</option>
                    <option value="avance">Avancé</option>
                    <option value="natif">Natif</option>
                </select>
            </div>
            <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800 text-sm mt-2">
                <i class="bi bi-trash"></i> Supprimer
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    langueIndex++;
}

// Fonction pour supprimer un élément
function removeItem(button) {
    const item = button.closest('.experience-item, .formation-item, .competence-item, .langue-item');
    const container = item.parentElement;
    item.remove();
    
    // Ajouter un message si le container est vide
    if (container.children.length === 0) {
        const type = container.id.replace('-container', '').slice(0, -1);
        const messages = {
            'experience': 'Aucune expérience ajoutée. Cliquez sur "Ajouter" pour commencer.',
            'formation': 'Aucune formation ajoutée. Cliquez sur "Ajouter" pour commencer.',
            'competence': 'Aucune compétence ajoutée. Cliquez sur "Ajouter" pour commencer.',
            'langue': 'Aucune langue ajoutée. Cliquez sur "Ajouter" pour commencer.'
        };
        container.innerHTML = `<p class="text-gray-500 text-sm">${messages[type]}</p>`;
    }
}

// Fonction pour basculer la date de fin
function toggleEndDate(checkbox) {
    const dateFinInput = checkbox.closest('.experience-item').querySelector('input[name*="[date_fin]"]');
    if (checkbox.checked) {
        dateFinInput.disabled = true;
        dateFinInput.value = '';
    } else {
        dateFinInput.disabled = false;
    }
}

// Fonction d'upload du CV
function uploadCv() {
    const fileInput = document.getElementById('cv-file');
    const file = fileInput.files[0];
    
    if (!file) return;
    
    // Vérifier le type de fichier
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format de fichier non supporté. Veuillez choisir un fichier PDF, DOC ou DOCX.');
        return;
    }
    
    // Vérifier la taille du fichier (5MB max)
    if (file.size > 5 * 1024 * 1024) {
        alert('Le fichier est trop volumineux. Taille maximum: 5MB.');
        return;
    }
    
    const formData = new FormData();
    formData.append('cv_file', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // Afficher la barre de progression
    const progressContainer = document.getElementById('upload-progress');
    const progressBar = document.getElementById('progress-bar');
    const uploadStatus = document.getElementById('upload-status');
    
    progressContainer.classList.remove('hidden');
    progressBar.style.width = '0%';
    uploadStatus.textContent = 'Upload en cours...';
    
    // Simuler la progression
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 90) progress = 90;
        progressBar.style.width = progress + '%';
    }, 200);
    
    fetch('{{ route("talent.cv.upload") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        clearInterval(progressInterval);
        progressBar.style.width = '100%';
        
        if (data.success) {
            uploadStatus.textContent = 'Upload terminé avec succès!';
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            uploadStatus.textContent = 'Erreur: ' + (data.error || 'Upload échoué');
            uploadStatus.classList.add('text-red-600');
        }
    })
    .catch(error => {
        clearInterval(progressInterval);
        uploadStatus.textContent = 'Erreur de connexion';
        uploadStatus.classList.add('text-red-600');
        console.error('Error:', error);
    });
}

// Fonction pour sauvegarder les données du CV
function saveCvData() {
    const form = document.getElementById('cv-form');
    const formData = new FormData(form);
    
    // Convertir en JSON pour l'envoi
    const data = {};
    const experiences = [];
    const formations = [];
    const competences = [];
    const langues = [];
    
    // Traiter les expériences
    document.querySelectorAll('.experience-item').forEach((item, index) => {
        const exp = {
            poste: item.querySelector('input[name*="[poste]"]').value,
            entreprise: item.querySelector('input[name*="[entreprise]"]').value,
            date_debut: item.querySelector('input[name*="[date_debut]"]').value,
            date_fin: item.querySelector('input[name*="[date_fin]"]').value,
            description: item.querySelector('textarea[name*="[description]"]').value,
            en_cours: item.querySelector('input[name*="[en_cours]"]').checked
        };
        if (exp.poste && exp.entreprise) {
            experiences.push(exp);
        }
    });
    
    // Traiter les formations
    document.querySelectorAll('.formation-item').forEach((item, index) => {
        const form = {
            diplome: item.querySelector('input[name*="[diplome]"]').value,
            etablissement: item.querySelector('input[name*="[etablissement]"]').value,
            annee_obtention: item.querySelector('input[name*="[annee_obtention]"]').value,
            mention: item.querySelector('input[name*="[mention]"]').value
        };
        if (form.diplome && form.etablissement) {
            formations.push(form);
        }
    });
    
    // Traiter les compétences
    document.querySelectorAll('.competence-item').forEach((item, index) => {
        const comp = {
            nom: item.querySelector('input[name*="[nom]"]').value,
            niveau: item.querySelector('select[name*="[niveau]"]').value,
            type: item.querySelector('select[name*="[type]"]').value
        };
        if (comp.nom) {
            competences.push(comp);
        }
    });
    
    // Traiter les langues
    document.querySelectorAll('.langue-item').forEach((item, index) => {
        const lang = {
            nom: item.querySelector('input[name*="[nom]"]').value,
            niveau: item.querySelector('select[name*="[niveau]"]').value
        };
        if (lang.nom) {
            langues.push(lang);
        }
    });
    
    const jsonData = {
        experiences: experiences,
        formations: formations,
        competences: competences,
        langues: langues,
        _token: document.querySelector('input[name="_token"]').value
    };
    
    fetch('{{ route("talent.cv.save") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('CV sauvegardé avec succès!');
            updateCompletionScore(data.completion_score);
        } else {
            alert('Erreur: ' + (data.error || 'Sauvegarde échouée'));
        }
    })
    .catch(error => {
        alert('Erreur de connexion');
        console.error('Error:', error);
    });
}

// Fonction pour mettre à jour le score de complétion
function updateCompletionScore(score = null) {
    if (score === null) {
        // Calculer le score basé sur les éléments présents
        score = 0;
        if (document.querySelectorAll('.experience-item').length > 0) score += 25;
        if (document.querySelectorAll('.formation-item').length > 0) score += 25;
        if (document.querySelectorAll('.competence-item').length > 0) score += 25;
        if (document.querySelectorAll('.langue-item').length > 0) score += 25;
    }
    
    document.getElementById('completion-bar').style.width = score + '%';
    document.getElementById('completion-score').textContent = score + '%';
}

// Fonction pour prévisualiser le CV
function previewCv() {
    // Basculer vers l'onglet prévisualisation
    document.querySelector('[data-tab="preview"]').click();
}

// Fonction pour mettre à jour la prévisualisation
function updatePreview() {
    // Expériences
    const experiencesList = document.getElementById('experiences-list');
    experiencesList.innerHTML = '';
    document.querySelectorAll('.experience-item').forEach(item => {
        const poste = item.querySelector('input[name*="[poste]"]').value;
        const entreprise = item.querySelector('input[name*="[entreprise]"]').value;
        const dateDebut = item.querySelector('input[name*="[date_debut]"]').value;
        const dateFin = item.querySelector('input[name*="[date_fin]"]').value;
        const description = item.querySelector('textarea[name*="[description]"]').value;
        const enCours = item.querySelector('input[name*="[en_cours]"]').checked;
        
        if (poste && entreprise) {
            const html = `
                <div class="mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-gray-900">${poste}</h4>
                            <p class="text-gray-600">${entreprise}</p>
                        </div>
                        <div class="text-sm text-gray-500">
                            ${dateDebut ? new Date(dateDebut).toLocaleDateString('fr-FR', {year: 'numeric', month: 'long'}) : ''}
                            ${dateFin && !enCours ? ' - ' + new Date(dateFin).toLocaleDateString('fr-FR', {year: 'numeric', month: 'long'}) : ''}
                            ${enCours ? ' - Présent' : ''}
                        </div>
                    </div>
                    ${description ? `<p class="text-gray-700 mt-2">${description}</p>` : ''}
                </div>
            `;
            experiencesList.insertAdjacentHTML('beforeend', html);
        }
    });
    
    // Formations
    const formationsList = document.getElementById('formations-list');
    formationsList.innerHTML = '';
    document.querySelectorAll('.formation-item').forEach(item => {
        const diplome = item.querySelector('input[name*="[diplome]"]').value;
        const etablissement = item.querySelector('input[name*="[etablissement]"]').value;
        const annee = item.querySelector('input[name*="[annee_obtention]"]').value;
        const mention = item.querySelector('input[name*="[mention]"]').value;
        
        if (diplome && etablissement) {
            const html = `
                <div class="mb-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-gray-900">${diplome}</h4>
                            <p class="text-gray-600">${etablissement}</p>
                            ${mention ? `<p class="text-sm text-gray-500">${mention}</p>` : ''}
                        </div>
                        <div class="text-sm text-gray-500">
                            ${annee || ''}
                        </div>
                    </div>
                </div>
            `;
            formationsList.insertAdjacentHTML('beforeend', html);
        }
    });
    
    // Compétences
    const competencesList = document.getElementById('competences-list');
    competencesList.innerHTML = '';
    const competencesByType = {};
    
    document.querySelectorAll('.competence-item').forEach(item => {
        const nom = item.querySelector('input[name*="[nom]"]').value;
        const niveau = item.querySelector('select[name*="[niveau]"]').value;
        const type = item.querySelector('select[name*="[type]"]').value;
        
        if (nom) {
            if (!competencesByType[type]) {
                competencesByType[type] = [];
            }
            competencesByType[type].push({nom, niveau});
        }
    });
    
    Object.keys(competencesByType).forEach(type => {
        const typeLabels = {
            'technique': 'Compétences techniques',
            'soft': 'Soft Skills',
            'outils': 'Outils'
        };
        
        const html = `
            <div class="mb-4">
                <h5 class="font-medium text-gray-800 mb-2">${typeLabels[type]}</h5>
                <div class="flex flex-wrap gap-2">
                    ${competencesByType[type].map(comp => `
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            ${comp.nom} <span class="text-xs">(${comp.niveau})</span>
                        </span>
                    `).join('')}
                </div>
            </div>
        `;
        competencesList.insertAdjacentHTML('beforeend', html);
    });
    
    // Langues
    const languesList = document.getElementById('langues-list');
    languesList.innerHTML = '';
    document.querySelectorAll('.langue-item').forEach(item => {
        const nom = item.querySelector('input[name*="[nom]"]').value;
        const niveau = item.querySelector('select[name*="[niveau]"]').value;
        
        if (nom) {
            const html = `
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mr-2 mb-2 inline-block">
                    ${nom} <span class="text-xs">(${niveau})</span>
                </span>
            `;
            languesList.insertAdjacentHTML('beforeend', html);
        }
    });
}

// Fonction pour supprimer le CV
function deleteCv() {
    if (confirm('Êtes-vous sûr de vouloir supprimer votre CV ?')) {
        // Implémenter la suppression du CV
        alert('Fonctionnalité à implémenter');
    }
}
</script>

<!-- Meta tag pour CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection