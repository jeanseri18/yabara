@extends('layouts.talent')

@section('title', $offre->titre)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('talent.offres') }}" class="hover:text-blue-600">Offres d'emploi</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="text-gray-800">{{ $offre->titre }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2">
            <!-- En-tête de l'offre -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $offre->titre }}</h1>
                        <div class="flex items-center text-gray-600 mb-2">
                            <i class="bi bi-building mr-2"></i>
                            <span class="text-lg">{{ $offre->entreprise->nom_entreprise }}</span>
                        </div>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            @if($offre->lieu_poste)
                                <div class="flex items-center">
                                    <i class="bi bi-geo-alt mr-1"></i>
                                    {{ $offre->lieu_poste }}
                                </div>
                            @endif
                            @if($offre->typeContrat)
                                <div class="flex items-center">
                                    <i class="bi bi-briefcase mr-1"></i>
                                    {{ $offre->typeContrat->nom }}
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="bi bi-calendar mr-1"></i>
                                Publié le {{ $offre->date_publication->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    @if($offre->typeContrat)
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $offre->typeContrat->nom }}
                        </span>
                    @endif
                </div>

                @if($offre->salaire_min && $offre->salaire_max)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <i class="bi bi-currency-euro text-green-600 mr-2"></i>
                            <span class="text-green-800 font-medium">
                                Salaire : {{ number_format($offre->salaire_min, 0, ',', ' ') }} - {{ number_format($offre->salaire_max, 0, ',', ' ') }} € brut/an
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Description de l'offre -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Description du poste</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($offre->descriptif)) !!}
                </div>
            </div>

            <!-- Profil recherché -->
            @if($offre->profil_recherche)
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Profil recherché</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($offre->profil_recherche)) !!}
                    </div>
                </div>
            @endif

            <!-- Avantages -->
            @if($offre->avantages)
                <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Avantages</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($offre->avantages)) !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Candidature -->
            <div class="bg-white rounded-lg shadow-sm border p-6 mb-6 sticky top-6">
                @if($aCandidature)
                    <div class="text-center">
                        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                            <i class="bi bi-check-circle text-2xl mb-2"></i>
                            <p class="font-medium">Candidature envoyée</p>
                            <p class="text-sm">Vous avez déjà postulé à cette offre</p>
                        </div>
                        <a href="{{ route('talent.offres') }}" class="w-full bg-gray-600 text-white py-3 px-4 rounded-md hover:bg-gray-700 transition-colors inline-block text-center">
                            Voir d'autres offres
                        </a>
                    </div>
                @else
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Postuler à cette offre</h3>
                    <form action="{{ route('talent.offres.postuler', $offre->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="message_motivation" class="block text-sm font-medium text-gray-700 mb-2">
                                Message de motivation (optionnel)
                            </label>
                            <textarea id="message_motivation" name="message_motivation" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Expliquez pourquoi vous êtes intéressé(e) par cette offre..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            <i class="bi bi-send mr-2"></i>
                            Postuler maintenant
                        </button>
                    </form>
                @endif
            </div>

            <!-- Informations complémentaires -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                <div class="space-y-3">
                    @if($offre->pole)
                        <div class="flex items-center">
                            <i class="bi bi-tag text-gray-400 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-600">Pôle</span>
                                <p class="font-medium">{{ $offre->pole->nom }}</p>
                            </div>
                        </div>
                    @endif

                    @if($offre->familleMetier)
                        <div class="flex items-center">
                            <i class="bi bi-diagram-3 text-gray-400 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-600">Famille métier</span>
                                <p class="font-medium">{{ $offre->familleMetier->nom }}</p>
                            </div>
                        </div>
                    @endif

                    @if($offre->niveauDiplome)
                        <div class="flex items-center">
                            <i class="bi bi-mortarboard text-gray-400 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-600">Niveau requis</span>
                                <p class="font-medium">{{ $offre->niveauDiplome->nom }}</p>
                            </div>
                        </div>
                    @endif

                    @if($offre->experience_requise)
                        <div class="flex items-center">
                            <i class="bi bi-clock-history text-gray-400 mr-3"></i>
                            <div>
                                <span class="text-sm text-gray-600">Expérience</span>
                                <p class="font-medium">{{ $offre->experience_requise }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center">
                        <i class="bi bi-eye text-gray-400 mr-3"></i>
                        <div>
                            <span class="text-sm text-gray-600">Vues</span>
                            <p class="font-medium">{{ $offre->nb_vues ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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