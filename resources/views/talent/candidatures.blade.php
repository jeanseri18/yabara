@extends('layouts.talent')

@section('title', 'Mes candidatures')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Suivi de mes candidatures</h1>
        <p class="text-gray-600">Suivez l'évolution de vos candidatures en temps réel</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-600">Total</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['en_attente'] }}</div>
            <div class="text-sm text-gray-600">En attente</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $stats['preselectionnes'] }}</div>
            <div class="text-sm text-gray-600">Présélectionnés</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">{{ $stats['entretiens'] }}</div>
            <div class="text-sm text-gray-600">Entretiens</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $stats['retenus'] }}</div>
            <div class="text-sm text-gray-600">Retenus</div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
        <form method="GET" action="{{ route('talent.candidatures') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label for="statut_entreprise" class="block text-sm font-medium text-gray-700 mb-1">Statut entreprise</label>
                <select id="statut_entreprise" name="statut_entreprise" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="candidature_recue" {{ request('statut_entreprise') == 'candidature_recue' ? 'selected' : '' }}>Candidature reçue</option>
                    <option value="preselctionnee" {{ request('statut_entreprise') == 'preselctionnee' ? 'selected' : '' }}>Présélectionnée</option>
                    <option value="entretien" {{ request('statut_entreprise') == 'entretien' ? 'selected' : '' }}>Entretien</option>
                    <option value="retenue" {{ request('statut_entreprise') == 'retenue' ? 'selected' : '' }}>Retenue</option>
                    <option value="refusee" {{ request('statut_entreprise') == 'refusee' ? 'selected' : '' }}>Refusée</option>
                </select>
            </div>
            <div class="flex-1 min-w-48">
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Mon statut</label>
                <select id="statut" name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous mes statuts</option>
                    <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="acceptee" {{ request('statut') == 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                    <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusée</option>
                    <option value="retiree" {{ request('statut') == 'retiree' ? 'selected' : '' }}>Retirée</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="bi bi-funnel mr-1"></i> Filtrer
                </button>
                <a href="{{ route('talent.candidatures') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    <i class="bi bi-arrow-clockwise mr-1"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des candidatures -->
    @if($candidatures->count() > 0)
        <div class="space-y-6">
            @foreach($candidatures as $candidature)
                <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                    <!-- En-tête de la candidature -->
                    <div class="p-6 border-b">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    <a href="{{ route('talent.offres.show', $candidature->offreEmploi->id) }}" class="hover:text-blue-600">
                                        {{ $candidature->offreEmploi->titre }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-2">
                                    <i class="bi bi-building mr-1"></i>
                                    {{ $candidature->offreEmploi->entreprise->nom_entreprise }}
                                </p>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    @if($candidature->offreEmploi->lieu_poste)
                                        <span><i class="bi bi-geo-alt mr-1"></i>{{ $candidature->offreEmploi->lieu_poste }}</span>
                                    @endif
                                    @if($candidature->offreEmploi->typeContrat)
                                        <span><i class="bi bi-briefcase mr-1"></i>{{ $candidature->offreEmploi->typeContrat->nom }}</span>
                                    @endif
                                    <span><i class="bi bi-calendar mr-1"></i>Candidaté le {{ $candidature->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($candidature->statut_talent == 'en_attente' && $candidature->statut_entreprise == 'candidature_recue')
                                    <form action="{{ route('talent.candidatures.retirer', $candidature->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cette candidature ?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            <i class="bi bi-x-circle mr-1"></i>Retirer
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('talent.offres.show', $candidature->offreEmploi->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="bi bi-eye mr-1"></i>Voir l'offre
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline des étapes -->
                    <div class="p-6">
                        <div class="relative">
                            <!-- Ligne de progression -->
                            <div class="absolute top-6 left-0 w-full h-0.5 bg-gray-200"></div>
                            <div class="absolute top-6 left-0 h-0.5 bg-blue-500 transition-all duration-500" 
                                 style="width: {{ $candidature->statut_entreprise == 'candidature_recue' ? '25%' : ($candidature->statut_entreprise == 'preselctionnee' ? '50%' : ($candidature->statut_entreprise == 'entretien' ? '75%' : ($candidature->statut_entreprise == 'retenue' ? '100%' : '0%'))) }}"></div>
                            
                            <!-- Étapes -->
                            <div class="relative flex justify-between">
                                <!-- Étape 1: Validation Yabara -->
                                <div class="flex flex-col items-center text-center" style="width: 23%">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 {{ $candidature->statut_entreprise != 'refusee' ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                        @if($candidature->statut_entreprise == 'refusee')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <i class="bi bi-check-lg"></i>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-sm mb-1">Validée par Yabara ✅</h4>
                                    <p class="text-xs text-gray-600 leading-tight">
                                        Votre candidature a été validée par notre équipe 🎯, elle a été envoyée à l'entreprise pour étude
                                    </p>
                                </div>

                                <!-- Étape 2: Validation entreprise -->
                                <div class="flex flex-col items-center text-center" style="width: 23%">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 {{ in_array($candidature->statut_entreprise, ['preselctionnee', 'entretien', 'retenue']) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                        @if(in_array($candidature->statut_entreprise, ['preselctionnee', 'entretien', 'retenue']))
                                            <i class="bi bi-check-lg"></i>
                                        @elseif($candidature->statut_entreprise == 'refusee')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <i class="bi bi-clock"></i>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-sm mb-1">Validée par l'entreprise ✅</h4>
                                    <p class="text-xs text-gray-600 leading-tight">
                                        L'entreprise a sélectionné votre profil, elle souhaite en savoir plus sur vous ! 🙌
                                    </p>
                                </div>

                                <!-- Étape 3: Entretien -->
                                <div class="flex flex-col items-center text-center" style="width: 23%">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 {{ in_array($candidature->statut_entreprise, ['entretien', 'retenue']) ? 'bg-purple-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                        @if(in_array($candidature->statut_entreprise, ['entretien', 'retenue']))
                                            <i class="bi bi-chat-dots"></i>
                                        @elseif($candidature->statut_entreprise == 'refusee')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <i class="bi bi-clock"></i>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-sm mb-1">Entretien en cours 📈</h4>
                                    <p class="text-xs text-gray-600 leading-tight">
                                        Vous êtes en processus de recrutement, un entretien est prévu ou en cours de planification 🗓️
                                    </p>
                                </div>

                                <!-- Étape 4: Candidature retenue -->
                                <div class="flex flex-col items-center text-center" style="width: 23%">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2 {{ $candidature->statut_entreprise == 'retenue' ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600' }}">
                                        @if($candidature->statut_entreprise == 'retenue')
                                            <i class="bi bi-trophy"></i>
                                        @elseif($candidature->statut_entreprise == 'refusee')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <i class="bi bi-clock"></i>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-sm mb-1">Candidature retenue ✅</h4>
                                    <p class="text-xs text-gray-600 leading-tight">
                                        🥳 Félicitations ! L'entreprise a décidé de vous retenir pour le poste, un membre de son équipe prendra contact avec vous très bientôt.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Statut actuel -->
                        <div class="mt-6 p-4 rounded-lg {{ $candidature->statut_entreprise == 'retenue' ? 'bg-green-50 border border-green-200' : ($candidature->statut_entreprise == 'refusee' ? 'bg-red-50 border border-red-200' : 'bg-blue-50 border border-blue-200') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($candidature->statut_entreprise == 'candidature_recue')
                                        <i class="bi bi-clock text-blue-600 mr-2"></i>
                                        <span class="font-medium text-blue-800">Candidature en cours d'examen</span>
                                    @elseif($candidature->statut_entreprise == 'preselctionnee')
                                        <i class="bi bi-check-circle text-green-600 mr-2"></i>
                                        <span class="font-medium text-green-800">Profil présélectionné</span>
                                    @elseif($candidature->statut_entreprise == 'entretien')
                                        <i class="bi bi-chat-dots text-purple-600 mr-2"></i>
                                        <span class="font-medium text-purple-800">Entretien programmé</span>
                                    @elseif($candidature->statut_entreprise == 'retenue')
                                        <i class="bi bi-trophy text-green-600 mr-2"></i>
                                        <span class="font-medium text-green-800">Candidature retenue ! 🎉</span>
                                    @elseif($candidature->statut_entreprise == 'refusee')
                                        <i class="bi bi-x-circle text-red-600 mr-2"></i>
                                        <span class="font-medium text-red-800">Candidature non retenue</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600">
                                    Mis à jour le {{ $candidature->updated_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                            @if($candidature->lettre_motivation)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-sm text-gray-700"><strong>Votre message :</strong></p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $candidature->lettre_motivation }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $candidatures->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border p-8 text-center">
            <div class="text-gray-400 mb-4">
                <i class="bi bi-send text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune candidature</h3>
            <p class="text-gray-600 mb-4">Vous n'avez pas encore postulé à des offres d'emploi.</p>
            <a href="{{ route('talent.offres') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                <i class="bi bi-briefcase mr-2"></i>Découvrir les offres
            </a>
        </div>
    @endif
</div>

@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-alert">
        <div class="flex items-center">
            <i class="bi bi-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-alert">
        <div class="flex items-center">
            <i class="bi bi-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

@push('scripts')
<script>
// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');
    
    if (successAlert) {
        successAlert.style.opacity = '0';
        setTimeout(() => successAlert.remove(), 300);
    }
    
    if (errorAlert) {
        errorAlert.style.opacity = '0';
        setTimeout(() => errorAlert.remove(), 300);
    }
}, 5000);
</script>
@endpush
@endsection