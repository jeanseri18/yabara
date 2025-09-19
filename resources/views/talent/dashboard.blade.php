@extends('layouts.talent')

@section('title', 'Dashboard - Badges & Trophées')
@section('page-title', 'Mon Tableau de Bord')

@section('content')
<!-- Header personnalisé avec phrase motivationnelle -->
<div class="bg-gradient-to-r from-[#0066FF] to-[#1e3a8a] rounded-xl shadow-lg p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 opacity-10">
        <i class="bi bi-trophy text-9xl"></i>
    </div>
    <div class="relative z-10">
        <div class="flex items-center mb-4">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 overflow-hidden">
                @if($talent->avatar_type)
                    <img src="{{ asset('storage/avatars/' . $talent->avatar_type) }}" alt="Photo de profil" class="w-full h-full object-cover rounded-full">
                @else
                    <i class="bi bi-person-circle text-3xl text-[#f6cd45]"></i>
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    🎉 Bienvenue {{ $talent->first_name ?? Auth::user()->name ?? 'Talent' }} — Voici ton tableau de bord YABARA
                </h1>
                <p class="text-blue-100 text-lg">{{ $phrase_du_jour }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Section Mes statistiques -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="bi bi-graph-up text-[#0066FF] mr-3"></i>
        📊 Mes statistiques
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Offres consultées -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-500 rounded-full">
                    <i class="bi bi-eye text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600">{{ $stats['offres_consultees'] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700">Offres consultées</h3>
            <p class="text-sm text-gray-500 mt-1">Découvertes récentes</p>
        </div>

        <!-- Candidatures envoyées -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-500 rounded-full">
                    <i class="bi bi-send text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-green-600">{{ $stats['candidatures_envoyees'] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700">📤 Candidatures</h3>
            <p class="text-sm text-gray-500 mt-1">Envoyées avec succès</p>
        </div>

        <!-- Offres favorites -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-500 rounded-full">
                    <i class="bi bi-heart text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-red-600">{{ $stats['offres_favorites'] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700">❤️ Favoris</h3>
            <p class="text-sm text-gray-500 mt-1">Offres sauvegardées</p>
        </div>

        <!-- Entretiens réalisés -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-500 rounded-full">
                    <i class="bi bi-mic text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-purple-600">{{ $stats['entretiens_realises'] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700">🎤 Entretiens</h3>
            <p class="text-sm text-gray-500 mt-1">En cours ou réalisés</p>
        </div>

        <!-- Parrainages actifs -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-500 rounded-full">
                    <i class="bi bi-people text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-yellow-600">{{ $stats['parrainages_actifs'] }}</span>
            </div>
            <h3 class="font-semibold text-gray-700">👥 Parrainages</h3>
            <p class="text-sm text-gray-500 mt-1">Talents accompagnés</p>
        </div>
    </div>
</div>

<!-- Section Mes badges -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="bi bi-award text-[#f6cd45] mr-3"></i>
        🏅 Mes badges — partie gamification
    </h2>
    
    <!-- Onglets -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex">
                <button class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-[#0066FF] text-[#0066FF] bg-blue-50" 
                        onclick="switchTab('debloques')">
                    🔓 Mes badges débloqués ({{ count($badges_debloques) }})
                </button>
                <button class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700" 
                        onclick="switchTab('a-debloquer')">
                    🔐 Badges à débloquer ({{ count($badges_disponibles) - count($badges_debloques) }})
                </button>
            </nav>
        </div>
        
        <!-- Contenu onglet badges débloqués -->
        <div id="tab-debloques" class="tab-content p-6">
            @if(count($badges_debloques) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($badges_debloques as $badge_key)
                        @php $badge = $badges_disponibles[$badge_key]; @endphp
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border-2 border-green-200 hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <div class="text-center">
                                <div class="text-4xl mb-3 animate-bounce">{{ explode(' ', $badge['nom'])[0] }}</div>
                                <h3 class="font-bold text-green-800 mb-2">{{ substr($badge['nom'], strpos($badge['nom'], ' ') + 1) }}</h3>
                                <p class="text-sm text-green-600">{{ $badge['description'] }}</p>
                                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-200 text-green-800">
                                    <i class="bi bi-check-circle mr-1"></i>
                                    Débloqué !
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-award text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Aucun badge débloqué pour le moment</h3>
                    <p class="text-gray-500">Continue à utiliser la plateforme pour débloquer tes premiers badges !</p>
                </div>
            @endif
        </div>
        
        <!-- Contenu onglet badges à débloquer -->
        <div id="tab-a-debloquer" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($badges_disponibles as $badge_key => $badge)
                    @if(!in_array($badge_key, $badges_debloques))
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border-2 border-gray-200 hover:shadow-lg transition-all duration-300 opacity-75">
                            <div class="text-center">
                                <div class="text-4xl mb-3 grayscale">{{ explode(' ', $badge['nom'])[0] }}</div>
                                <h3 class="font-bold text-gray-600 mb-2">{{ substr($badge['nom'], strpos($badge['nom'], ' ') + 1) }}</h3>
                                <p class="text-sm text-gray-500">{{ $badge['description'] }}</p>
                                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                    <i class="bi bi-lock mr-1"></i>
                                    À débloquer
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Progression du profil -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
        <i class="bi bi-person-gear text-[#0066FF] mr-3"></i>
        Progression de ton profil
    </h3>
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Complétude du profil</span>
            <span class="text-sm font-bold text-[#0066FF]">{{ $stats['profil_completude'] }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-[#0066FF] to-[#f6cd45] h-3 rounded-full transition-all duration-500" 
                 style="width: {{ $stats['profil_completude'] }}%"></div>
        </div>
    </div>
    
    @if($stats['profil_completude'] < 100)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-800 mb-2">🚀 Prochaines étapes pour compléter ton profil :</h4>
            <ul class="text-sm text-blue-700 space-y-1">
                @if(!$talent || !$talent->cv_reference)
                    <li class="flex items-center"><i class="bi bi-circle text-blue-400 mr-2"></i> Importer ou créer ton CV</li>
                @endif
                @if(!$talent || $talent->cvExperiences->isEmpty())
                    <li class="flex items-center"><i class="bi bi-circle text-blue-400 mr-2"></i> Ajouter tes expériences professionnelles</li>
                @endif
                @if(!$talent || $talent->cvCompetences->isEmpty())
                    <li class="flex items-center"><i class="bi bi-circle text-blue-400 mr-2"></i> Renseigner tes compétences techniques</li>
                @endif
                @if(!$talent || $talent->cvLangues->isEmpty())
                    <li class="flex items-center"><i class="bi bi-circle text-blue-400 mr-2"></i> Indiquer tes langues parlées</li>
                @endif
            </ul>
        </div>
    @else
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
            <i class="bi bi-check-circle text-green-500 text-2xl mb-2"></i>
            <p class="font-semibold text-green-800">🎉 Félicitations ! Ton profil est complet à 100% !</p>
            <p class="text-sm text-green-600 mt-1">Tu maximises tes chances d'être remarqué par les recruteurs.</p>
        </div>
    @endif
</div>

<!-- Actions rapides -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('talent.cv.import') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-l-4 border-[#0066FF]">
        <div class="flex items-center mb-4">
            <i class="bi bi-file-earmark-arrow-up text-[#0066FF] text-2xl mr-3"></i>
            <h3 class="font-semibold text-gray-800">Mon CV</h3>
        </div>
        <p class="text-sm text-gray-600">Importer ou créer ton CV anonyme</p>
    </a>
    
    <a href="{{ route('talent.offres') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-l-4 border-[#f6cd45]">
        <div class="flex items-center mb-4">
            <i class="bi bi-search text-[#f6cd45] text-2xl mr-3"></i>
            <h3 class="font-semibold text-gray-800">Offres d'emploi</h3>
        </div>
        <p class="text-sm text-gray-600">Découvrir les opportunités</p>
    </a>
    
    <a href="{{ route('talent.candidatures') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-l-4 border-green-500">
        <div class="flex items-center mb-4">
            <i class="bi bi-list-check text-green-500 text-2xl mr-3"></i>
            <h3 class="font-semibold text-gray-800">Mes candidatures</h3>
        </div>
        <p class="text-sm text-gray-600">Suivre tes candidatures</p>
    </a>
    
    <a href="{{ route('talent.parrainage') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:scale-105 border-l-4 border-purple-500">
        <div class="flex items-center mb-4">
            <i class="bi bi-people text-purple-500 text-2xl mr-3"></i>
            <h3 class="font-semibold text-gray-800">Parrainage</h3>
        </div>
        <p class="text-sm text-gray-600">Parrainer d'autres talents</p>
    </a>
</div>

<script>
function switchTab(tabName) {
    // Masquer tous les contenus d'onglets
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Désactiver tous les boutons d'onglets
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-[#0066FF]', 'text-[#0066FF]', 'bg-blue-50');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Afficher le contenu de l'onglet sélectionné
    document.getElementById('tab-' + tabName).classList.remove('hidden');
    
    // Activer le bouton de l'onglet sélectionné
    event.target.classList.add('active', 'border-[#0066FF]', 'text-[#0066FF]', 'bg-blue-50');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}

// Animation des badges au chargement
document.addEventListener('DOMContentLoaded', function() {
    const badges = document.querySelectorAll('.animate-bounce');
    badges.forEach((badge, index) => {
        setTimeout(() => {
            badge.style.animationDelay = `${index * 0.1}s`;
        }, 100);
    });
});
</script>
@endsection