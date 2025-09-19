@extends('layouts.talent')

@section('title', 'Parrainage')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Parrainage</h1>
        <p class="text-gray-600">Invite tes amis sur YABARA et gagne des récompenses ! 🏆</p>
    </div>

    <!-- Tableau de bord de parrainage -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">📊 Ton tableau de bord parrainage</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-200">
                <div class="text-2xl font-bold text-blue-600 mb-1">{{ $stats['invites'] }}</div>
                <div class="text-sm text-blue-700">Talents invités</div>
            </div>
            <div class="bg-green-50 rounded-lg p-4 text-center border border-green-200">
                <div class="text-2xl font-bold text-green-600 mb-1">{{ $stats['comptes_crees'] }}</div>
                <div class="text-sm text-green-700">Comptes créés</div>
            </div>
            <div class="bg-purple-50 rounded-lg p-4 text-center border border-purple-200">
                <div class="text-2xl font-bold text-purple-600 mb-1">{{ $stats['parrainages_valides'] }}</div>
                <div class="text-sm text-purple-700">Parrainages validés</div>
            </div>
            <div class="bg-yellow-50 rounded-lg p-4 text-center border border-yellow-200">
                @if($prochainBadge > 0)
                    <div class="text-2xl font-bold text-yellow-600 mb-1">{{ $prochainBadge }}</div>
                    <div class="text-sm text-yellow-700">Prochain badge dans</div>
                @else
                    <div class="text-2xl font-bold text-yellow-600 mb-1">🏆</div>
                    <div class="text-sm text-yellow-700">Badge débloqué !</div>
                @endif
            </div>
        </div>

        @if($prochainBadge > 0)
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="bi bi-trophy text-yellow-500 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Prochain badge débloqué dans : {{ $prochainBadge }} invitation{{ $prochainBadge > 1 ? 's' : '' }}</p>
                        <p class="text-sm text-gray-600">Continue à inviter tes amis pour débloquer des récompenses !</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Formulaire d'invitation -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">🎯 Inviter un(e) ami(e)</h2>
        
        <form action="{{ route('talent.parrainage.inviter') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Champ 1: Email -->
            <div>
                <label for="email_filleul" class="block text-sm font-medium text-gray-700 mb-1">
                    Adresse e-mail de ton ami(e) *
                </label>
                <input type="email" 
                       id="email_filleul" 
                       name="email_filleul" 
                       value="{{ old('email_filleul') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email_filleul') border-red-500 @enderror" 
                       placeholder="exemple@email.com"
                       required>
                <p class="text-sm text-gray-600 mt-1">
                    👉 Tu veux parrainer un(e) ami(e) ? Entre son adresse e-mail ici 👇
                </p>
                @error('email_filleul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ 2: Prénom -->
            <div>
                <label for="prenom_filleul" class="block text-sm font-medium text-gray-700 mb-1">
                    Prénom de ton ami(e) *
                </label>
                <input type="text" 
                       id="prenom_filleul" 
                       name="prenom_filleul" 
                       value="{{ old('prenom_filleul') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('prenom_filleul') border-red-500 @enderror" 
                       placeholder="Prénom"
                       required>
                @error('prenom_filleul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ 3: Référence CV (automatique) -->
            <div>
                <label for="reference_cv" class="block text-sm font-medium text-gray-700 mb-1">
                    Ta référence unique de CV
                </label>
                <input type="text" 
                       id="reference_cv" 
                       name="reference_cv" 
                       value="{{ $talent->reference_cv }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600" 
                       readonly>
                <p class="text-sm text-gray-600 mt-1">
                    💡 Si ton ami(e) crée un compte et indique ta référence CV, en tant que parrain tu gagnes des récompenses 🏆
                </p>
            </div>

            <!-- Bouton d'envoi -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium">
                    <i class="bi bi-send mr-2"></i>
                    Envoyer l'invitation
                </button>
            </div>
        </form>
    </div>

    <!-- Historique des invitations -->
    @if($parrainages->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">📋 Historique de tes invitations</h2>
            
            <div class="space-y-4">
                @foreach($parrainages as $parrainage)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="font-medium text-gray-800 mr-3">{{ $parrainage->nom_entreprise }}</h3>
                                    @if($parrainage->statut == 'en_attente')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                            <i class="bi bi-clock mr-1"></i>En attente
                                        </span>
                                    @elseif($parrainage->statut == 'valide')
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            <i class="bi bi-check-circle mr-1"></i>Validé
                                        </span>
                                    @elseif($parrainage->statut == 'expire')
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                            <i class="bi bi-x-circle mr-1"></i>Expiré
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mb-1">
                                    <i class="bi bi-envelope mr-1"></i>{{ $parrainage->email_entreprise }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    <i class="bi bi-calendar mr-1"></i>Invité le {{ $parrainage->date_invitation->format('d/m/Y à H:i') }}
                                </p>
                                @if($parrainage->talent_parraine_id)
                                    <p class="text-sm text-green-600 mt-1">
                                        <i class="bi bi-person-check mr-1"></i>Compte créé le {{ $parrainage->date_inscription ? $parrainage->date_inscription->format('d/m/Y') : $parrainage->created_at->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($parrainage->statut == 'valide')
                                    <div class="text-green-600">
                                        <i class="bi bi-trophy text-xl"></i>
                                    </div>
                                @elseif($parrainage->talent_parraine_id)
                                    <div class="text-blue-600">
                                        <i class="bi bi-person-plus text-xl"></i>
                                    </div>
                                @else
                                    <div class="text-gray-400">
                                        <i class="bi bi-hourglass text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $parrainages->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Alertes -->
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