@extends('layouts.entreprise')

@section('title', 'Tableau de Bord Entreprise')
@section('page-title', 'Tableau de bord Entreprise')

@section('content')
<!-- Carte de bienvenue -->
<div style="background-color: #071D55;" class="rounded-lg shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->entreprise->nom_entreprise ?? 'Entreprise' }} !</h2>
            <p style="color: #f6cd45;">Gérez vos offres d'emploi et trouvez les meilleurs talents sur YABARA</p>
        </div>
        <div class="hidden md:block">
            <i class="bi bi-building text-6xl" style="color: #f6cd45;"></i>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full" style="background-color: #1040BB; color: white;">
                <i class="bi bi-briefcase text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Offres actives</h3>
                <p class="text-3xl font-bold" style="color: #1040BB;">12</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full" style="background-color: #f6cd45; color: #071D55;">
                <i class="bi bi-envelope text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Candidatures</h3>
                <p class="text-3xl font-bold" style="color: #f6cd45;">47</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full" style="background-color: #071D55; color: white;">
                <i class="bi bi-eye text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Vues profil</h3>
                <p class="text-3xl font-bold" style="color: #071D55;">156</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full" style="background-color: #1040BB; color: white;">
                <i class="bi bi-people text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Talents vus</h3>
                <p class="text-3xl font-bold" style="color: #1040BB;">89</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides et contenu principal -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Actions rapides -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
            <div class="space-y-3">
                <a href="#" class="flex items-center p-3 rounded-lg hover:opacity-80 transition" style="background-color: #f6cd45;">
                    <i class="bi bi-plus-circle mr-3" style="color: #071D55;"></i>
                    <span style="color: #071D55; font-weight: 500;">Publier une offre</span>
                </a>
                <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <i class="bi bi-people mr-3" style="color: #1040BB;"></i>
                    <span class="text-gray-700">Parcourir les talents</span>
                </a>
                <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <i class="bi bi-building-gear mr-3" style="color: #1040BB;"></i>
                    <span class="text-gray-700">Modifier le profil</span>
                </a>
            </div>
        </div>

        <!-- Progression du profil -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Profil entreprise</h3>
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Complétude</span>
                    <span>85%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full" style="background-color: #f6cd45; width: 85%"></div>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <p class="mb-2">✅ Informations générales</p>
                <p class="mb-2">✅ Secteur d'activité</p>
                <p class="mb-2">✅ Description</p>
                <p class="mb-2">⏳ Logo et images</p>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="lg:col-span-2">
        <!-- Mes offres récentes -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Mes offres récentes</h3>
                <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #1040BB;">Voir toutes</a>
            </div>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900">Développeur Full Stack</h4>
                        <div class="flex space-x-2">
                            <span class="text-xs px-2 py-1 rounded" style="background-color: #f6cd45; color: #071D55;">Active</span>
                            <span class="text-xs px-2 py-1 rounded" style="background-color: #1040BB; color: white;">15 candidatures</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">CDI • Abidjan, Cocody • 800k - 1.2M FCFA</p>
                    <p class="text-gray-500 text-sm mb-3">Recherche développeur expérimenté en React et Laravel...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Publiée il y a 3 jours</span>
                        <div class="flex space-x-2">
                            <button class="text-sm hover:opacity-80" style="color: #1040BB;">
                                <i class="bi bi-eye"></i> Voir
                            </button>
                            <button class="text-sm hover:opacity-80" style="color: #1040BB;">
                                <i class="bi bi-pencil"></i> Modifier
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900">Designer UX/UI</h4>
                        <div class="flex space-x-2">
                            <span class="text-xs px-2 py-1 rounded" style="background-color: #f6cd45; color: #071D55;">Active</span>
                            <span class="text-xs px-2 py-1 rounded" style="background-color: #1040BB; color: white;">8 candidatures</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">CDD • Abidjan, Plateau • 600k - 900k FCFA</p>
                    <p class="text-gray-500 text-sm mb-3">Recherche designer créatif pour projets innovants...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Publiée il y a 1 semaine</span>
                        <div class="flex space-x-2">
                            <button class="text-sm hover:opacity-80" style="color: #1040BB;">
                                <i class="bi bi-eye"></i> Voir
                            </button>
                            <button class="text-sm hover:opacity-80" style="color: #1040BB;">
                                <i class="bi bi-pencil"></i> Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Candidatures récentes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Candidatures récentes</h3>
                <a href="#" class="text-sm font-medium hover:opacity-80" style="color: #1040BB;">Voir toutes</a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #1040BB;">
                            <i class="bi bi-person text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Candidat anonyme #1234</p>
                            <p class="text-sm text-gray-500">Développeur Full Stack • 5 ans d'expérience</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs px-2 py-1 rounded" style="background-color: #f6cd45; color: #071D55;">En attente</span>
                        <button class="hover:opacity-80" style="color: #1040BB;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: #071D55;">
                            <i class="bi bi-person text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Candidat anonyme #5678</p>
                            <p class="text-sm text-gray-500">Designer UX/UI • 3 ans d'expérience</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs px-2 py-1 rounded" style="background-color: #071D55; color: white;">Acceptée</span>
                        <button class="hover:opacity-80" style="color: #1040BB;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection