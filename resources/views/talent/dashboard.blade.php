@extends('layouts.talent')

@section('title', 'Mon Tableau de Bord')
@section('page-title', 'Tableau de bord Talent')

@section('content')
<!-- Carte de bienvenue -->
<div class="bg-gradient-to-r from-[#152747] to-[#1e3a8a] rounded-lg shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->talent->first_name ?? 'Talent' }} !</h2>
            <p class="text-blue-100">Gérez votre profil et trouvez votre prochain emploi sur YABARA</p>
        </div>
        <div class="hidden md:block">
            <i class="bi bi-person-workspace text-6xl text-[#f6cd45]"></i>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="bi bi-eye text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Vues du profil</h3>
                <p class="text-3xl font-bold text-blue-600">24</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="bi bi-send text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Candidatures</h3>
                <p class="text-3xl font-bold text-green-600">8</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="bi bi-chat-dots text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Messages</h3>
                <p class="text-3xl font-bold text-yellow-600">3</p>
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
                <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <i class="bi bi-person-gear text-[#152747] mr-3"></i>
                    <span class="text-gray-700">Compléter mon profil</span>
                </a>
                <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <i class="bi bi-file-earmark-arrow-up text-[#152747] mr-3"></i>
                    <span class="text-gray-700">Mettre à jour mon CV</span>
                </a>
                <a href="#" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <i class="bi bi-search text-[#152747] mr-3"></i>
                    <span class="text-gray-700">Rechercher des offres</span>
                </a>
            </div>
        </div>

        <!-- Progression du profil -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Progression du profil</h3>
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Complétude</span>
                    <span>75%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-[#f6cd45] h-2 rounded-full" style="width: 75%"></div>
                </div>
            </div>
            <div class="text-sm text-gray-600">
                <p class="mb-2">✅ Informations personnelles</p>
                <p class="mb-2">✅ Formation</p>
                <p class="mb-2">⏳ Expériences professionnelles</p>
                <p class="mb-2">❌ Compétences techniques</p>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="lg:col-span-2">
        <!-- Offres recommandées -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Offres recommandées pour vous</h3>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900">Développeur Full Stack</h4>
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Nouveau</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">TechCorp SARL • Abidjan, Cocody</p>
                    <p class="text-gray-500 text-sm mb-3">Recherche développeur expérimenté en React et Laravel...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Il y a 2 heures</span>
                        <button class="bg-[#152747] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#1e3a8a] transition">
                            Postuler
                        </button>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold text-gray-900">Designer UX/UI</h4>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Urgent</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">Creative Agency • Abidjan, Plateau</p>
                    <p class="text-gray-500 text-sm mb-3">Agence créative recherche designer pour projets innovants...</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Il y a 1 jour</span>
                        <button class="bg-[#152747] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#1e3a8a] transition">
                            Postuler
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Activité récente</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Candidature envoyée pour "Développeur Backend"</span>
                    <span class="text-xs text-gray-400">Il y a 2 heures</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Profil consulté par TechStart SARL</span>
                    <span class="text-xs text-gray-400">Hier</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">CV mis à jour</span>
                    <span class="text-xs text-gray-400">Il y a 3 jours</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection