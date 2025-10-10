@extends('layouts.talent')

@section('title', 'Mon CV - Import & Création')

@section('page-title', 'Mon CV')

@section('head')
<!-- Bibliothèque html2pdf.js pour la génération de PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection

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
                <button class="tab-button active py-4 px-6 text-sm font-medium border-b-2 border-[#f6cd45] text-[#0066FF]" data-tab="ethics">
                    <i class="bi bi-shield-check mr-2"></i>
                    Explication pédagogique
                </button>
                <button class="tab-button py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="upload">
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
            <!-- Onglet Explication pédagogique + engagement éthique -->
            <div id="ethics-tab" class="tab-content">
                <div class="max-w-3xl mx-auto space-y-8">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-[#0066FF] mb-4">Notre engagement pour un recrutement éthique</h3>
                        <p class="text-gray-600">Chez YABARA, nous croyons en un recrutement fondé uniquement sur les compétences et l'expérience.</p>
                    </div>
                    
                    <!-- Première infobox -->
                    <div class="bg-blue-50 border-l-4 border-[#0066FF] p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="bi bi-eye-slash text-2xl text-[#0066FF]"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Pourquoi certaines informations sont grisées</h4>
                                <p class="text-gray-700">
                                    « Chez YABARA, nous croyons en un recrutement fondé sur les compétences. Vos informations personnelles sont masquées pour garantir un traitement équitable par tous les recruteurs. »
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Deuxième infobox -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="bi bi-shield-lock text-2xl text-green-600"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Confidentialité garantie</h4>
                                <p class="text-gray-700">
                                    « Vos informations personnelles (nom, email, téléphone) sont automatiquement masquées pour prévenir toute forme de biais ou de discrimination, seules vos compétences et expériences parlent pour vous. »
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Troisième infobox -->
                    <div class="bg-yellow-50 border-l-4 border-[#f6cd45] p-6 rounded-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <i class="bi bi-stars text-2xl text-yellow-600"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Impact positif pour l'équité</h4>
                                <p class="text-gray-700">
                                    « 💫 Chaque CV anonyme sur YABARA est un pas vers un recrutement sans préjugés, sans favoritisme, sans barrières. Merci d'y participer ! »
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-8">
                        <button type="button" onclick="document.querySelector('[data-tab=upload]').click()" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-arrow-right mr-2"></i>
                            Continuer vers l'import de CV
                        </button>
                    </div>
                </div>
            </div>
            
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
                    <!-- Message éthique en haut -->                
                    <div class="bg-gray-100 border border-gray-200 rounded-lg p-3 mb-4 text-sm text-gray-600 text-center">
                        <p>Ce CV respecte notre charte d'anonymisation. Les informations sensibles ne sont jamais visibles par les recruteurs.</p>
                    </div>
                    
                    <div class="bg-white border rounded-lg p-8 cv-preview-container" id="cv-preview">
                        <!-- Titre et sous-texte du CV anonyme -->
                        <div class="text-center mb-6">
                            <h1 class="text-2xl font-bold text-[#0066FF]">Mon CV Anonyme YABARA</h1>
                            <p class="text-gray-600 mt-2">Ce CV est visible par les recruteurs. Seules vos compétences et votre expérience parlent pour vous.</p>
                        </div>
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

                    <div class="mt-6 text-center flex justify-center gap-4">
                        <button onclick="window.print()" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-printer mr-2"></i>
                            Imprimer le CV
                        </button>
                        <button onclick="downloadPDF()" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-download mr-2"></i>
                            Télécharger PDF
                        </button>
                        <button onclick="shareCV()" class="bg-[#0066FF] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="bi bi-share mr-2"></i>
                            Partager
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

    // Masquer tous les onglets sauf l'onglet "Explication pédagogique" par défaut
    tabContents.forEach(content => {
        if (content.id !== 'ethics-tab') {
            content.classList.add('hidden');
        }
    });

    // Vérifier si l'URL contient un paramètre d'onglet
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');
    
    // Si un onglet est spécifié dans l'URL, l'activer
    if (activeTab) {
        const tabButton = document.querySelector(`[data-tab="${activeTab}"]`);
        if (tabButton) {
            // Simuler un clic sur l'onglet
            tabButton.click();
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Désactiver tous les onglets
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('text-gray-500');
                btn.classList.remove('text-[#0066FF]');
                btn.classList.add('border-transparent');
                btn.classList.remove('border-[#f6cd45]');
            });
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Activer l'onglet sélectionné
            this.classList.add('active');
            this.classList.remove('text-gray-500');
            this.classList.add('text-[#0066FF]');
            this.classList.remove('border-transparent');
            this.classList.add('border-[#f6cd45]');
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
    const previewButton = document.querySelector('[data-tab="preview"]');
    if (previewButton) {
        previewButton.click();
    }
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

// Fonction pour télécharger le CV en PDF
function downloadPDF() {
    // Vérifier si html2pdf est défini
    if (typeof html2pdf === 'undefined') {
        alert('La bibliothèque html2pdf n\'est pas chargée. Veuillez rafraîchir la page.');
        return;
    }

    // Récupérer le contenu du CV
    const cvElement = document.getElementById('cv-preview');
    if (!cvElement) {
        alert('Impossible de trouver le contenu du CV.');
        return;
    }

    // Créer une copie du CV pour ne pas modifier l'original
    const cvContent = cvElement.cloneNode(true);
    
    // Masquer les boutons dans la version PDF
    const buttonsContainer = cvContent.querySelector('.mt-6');
    if (buttonsContainer) {
        buttonsContainer.style.display = 'none';
    }
    
    // Configuration des options pour html2pdf
    const options = {
        margin: 10,
        filename: 'cv-yabara.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    // Générer et télécharger le PDF
    html2pdf()
        .from(cvContent)
        .set(options)
        .save()
        .catch(err => {
            console.error('Erreur lors de la génération du PDF:', err);
            alert('Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
        });
}



// Fonction pour partager le CV
function shareCV() {
    // Vérifier si l'API Web Share est disponible
    if (navigator.share) {
        // Créer un objet avec les données à partager
        navigator.share({
            title: 'Mon CV Yabara',
            text: 'Voici mon CV créé sur la plateforme Yabara',
            url: window.location.href
        })
        .then(() => console.log('Partage réussi'))
        .catch((error) => console.log('Erreur lors du partage:', error));
    } else {
        // Fallback si l'API Web Share n'est pas disponible
        const url = window.location.href;
        prompt('L\'API de partage n\'est pas disponible sur votre navigateur. Copiez ce lien pour partager votre CV:', url);
    }
}</script>

<!-- Meta tag pour CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection