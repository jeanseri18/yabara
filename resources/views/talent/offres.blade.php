@extends('layouts.talent')

@section('title', 'Offres d\'emploi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Offres d'emploi disponibles</h1>
        <p class="text-gray-600">Découvrez les opportunités qui correspondent à votre profil</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <form method="GET" action="{{ route('talent.offres') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div>
                    <label for="recherche" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <input type="text" id="recherche" name="recherche" value="{{ request('recherche') }}"
                           placeholder="Titre, entreprise, description..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Pôle -->
                <div>
                    <label for="pole_id" class="block text-sm font-medium text-gray-700 mb-1">Pôle</label>
                    <select id="pole_id" name="pole_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les pôles</option>
                        @foreach($poles as $pole)
                            <option value="{{ $pole->id }}" {{ request('pole_id') == $pole->id ? 'selected' : '' }}>
                                {{ $pole->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type de contrat -->
                <div>
                    <label for="type_contrat_id" class="block text-sm font-medium text-gray-700 mb-1">Type de contrat</label>
                    <select id="type_contrat_id" name="type_contrat_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les contrats</option>
                        @foreach($typesContrat as $type)
                            <option value="{{ $type->id }}" {{ request('type_contrat_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lieu -->
                <div>
                    <label for="lieu" class="block text-sm font-medium text-gray-700 mb-1">Lieu</label>
                    <input type="text" id="lieu" name="lieu" value="{{ request('lieu') }}"
                           placeholder="Ville, région..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    {{ $offres->total() }} offre(s) trouvée(s)
                </div>
                <div class="space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="bi bi-search mr-1"></i> Rechercher
                    </button>
                    <a href="{{ route('talent.offres') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        <i class="bi bi-arrow-clockwise mr-1"></i> Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des offres -->
    @if($offres->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($offres as $offre)
                <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <!-- En-tête de l'offre -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                    <a href="{{ route('talent.offres.show', $offre->id) }}" class="hover:text-blue-600">
                                        {{ $offre->titre }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="bi bi-building mr-1"></i>
                                    {{ $offre->entreprise->nom_entreprise }}
                                </p>
                            </div>
                            @if($offre->typeContrat)
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                    {{ $offre->typeContrat->nom }}
                                </span>
                            @endif
                        </div>

                        <!-- Informations clés -->
                        <div class="space-y-2 mb-4">
                            @if($offre->lieu_poste)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="bi bi-geo-alt mr-2"></i>
                                    {{ $offre->lieu_poste }}
                                </div>
                            @endif
                            @if($offre->pole)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="bi bi-tag mr-2"></i>
                                    {{ $offre->pole->nom }}
                                </div>
                            @endif
                            @if($offre->salaire_min && $offre->salaire_max)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="bi bi-currency-euro mr-2"></i>
                                    {{ number_format($offre->salaire_min, 0, ',', ' ') }} - {{ number_format($offre->salaire_max, 0, ',', ' ') }} €
                                </div>
                            @endif
                        </div>

                        <!-- Description courte -->
                        <p class="text-sm text-gray-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($offre->descriptif), 120) }}
                        </p>

                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <div class="text-xs text-gray-500">
                                <i class="bi bi-calendar mr-1"></i>
                                Publié le {{ $offre->date_publication->format('d/m/Y') }}
                            </div>
                            <a href="{{ route('talent.offres.show', $offre->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                                Voir l'offre
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $offres->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border p-8 text-center">
            <div class="text-gray-400 mb-4">
                <i class="bi bi-briefcase text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune offre trouvée</h3>
            <p class="text-gray-600 mb-4">Aucune offre d'emploi ne correspond à vos critères de recherche.</p>
            <a href="{{ route('talent.offres') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                Voir toutes les offres
            </a>
        </div>
    @endif
</div>

@push('styles')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection