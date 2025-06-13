@extends('layouts.admin')

@section('title', 'Administration')
@section('page-title', 'Tableau de bord administrateur')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Statistiques -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="bi bi-people text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Utilisateurs</h3>
                <p class="text-3xl font-bold text-blue-600">1,234</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="bi bi-building text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Entreprises</h3>
                <p class="text-3xl font-bold text-green-600">89</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="bi bi-person-badge text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Talents</h3>
                <p class="text-3xl font-bold text-yellow-600">567</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="bi bi-briefcase text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Offres</h3>
                <p class="text-3xl font-bold text-purple-600">156</p>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques et tableaux -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Activité récente -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Nouvelle inscription entreprise</span>
                    <span class="text-xs text-gray-400">Il y a 2 minutes</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Nouveau talent inscrit</span>
                    <span class="text-xs text-gray-400">Il y a 15 minutes</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Offre d'emploi publiée</span>
                    <span class="text-xs text-gray-400">Il y a 1 heure</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières inscriptions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Dernières inscriptions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-person text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Jean Dupont</p>
                            <p class="text-xs text-gray-500">Talent - Développeur</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">Aujourd'hui</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="bi bi-building text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">TechCorp SARL</p>
                            <p class="text-xs text-gray-500">Entreprise - IT</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">Hier</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection