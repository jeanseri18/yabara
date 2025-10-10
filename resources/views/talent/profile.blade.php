@extends('layouts.talent')

@section('title', 'Mon Profil')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="text-gray-600 mt-2">Gérez vos informations personnelles et professionnelles</p>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulaire de profil -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('talent.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- En-tête du formulaire -->
                <div class="bg-gradient-to-r from-[#0066FF] to-[#004BB8] px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">Informations personnelles</h2>
                </div>

                <div class="p-6">
                    <!-- Avatar et informations de base -->
                    <div class="flex flex-col md:flex-row gap-6 mb-8">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden mb-4">
                                @if($talent->avatar_type)
                                    <img src="{{ asset('storage/avatars/' . $talent->avatar_type) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-person text-4xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="text-center">
                                <label for="avatar" class="bg-[#0066FF] text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-[#004BB8] transition-colors">
                                    <i class="bi bi-camera mr-2"></i>Changer la photo
                                </label>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                            </div>
                        </div>

                        <!-- Informations de base -->
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prénom -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="{{ old('first_name', $talent->first_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0066FF] focus:border-transparent"
                                       required>
                                @error('first_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="{{ old('last_name', $talent->last_name) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0066FF] focus:border-transparent"
                                       required>
                                @error('last_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email (lecture seule) -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" id="email" name="email" 
                                       value="{{ $talent->user->email }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                                       readonly>
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input type="tel" id="phone" name="phone" 
                                       value="{{ old('phone', $talent->phone) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0066FF] focus:border-transparent">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations professionnelles -->
                    <div class="border-t pt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informations professionnelles</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pôle -->
                            <div>
                                <label for="pole_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pôle d'activité
                                </label>
                                <select id="pole_id" name="pole_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0066FF] focus:border-transparent">
                                    <option value="">Sélectionnez un pôle</option>
                                    @foreach($poles as $pole)
                                        <option value="{{ $pole->id }}" 
                                                {{ old('pole_id', $talent->pole_id) == $pole->id ? 'selected' : '' }}>
                                            {{ $pole->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pole_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Niveau de diplôme -->
                            <div>
                                <label for="niveau_diplome_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Niveau de diplôme
                                </label>
                                <select id="niveau_diplome_id" name="niveau_diplome_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0066FF] focus:border-transparent">
                                    <option value="">Sélectionnez un niveau</option>
                                    @foreach($niveauxDiplomes as $niveau)
                                        <option value="{{ $niveau->id }}" 
                                                {{ old('niveau_diplome_id', $talent->niveau_diplome_id) == $niveau->id ? 'selected' : '' }}>
                                            {{ $niveau->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('niveau_diplome_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations du CV -->
                    <div class="border-t pt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informations CV</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Référence CV -->
                            <div>
                                <label for="cv_reference" class="block text-sm font-medium text-gray-700 mb-2">
                                    Référence CV
                                </label>
                                <input type="text" id="cv_reference" name="cv_reference" 
                                       value="{{ $talent->cv_reference }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                                       readonly>
                            </div>

                            <!-- Pourcentage de completion -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Completion du profil
                                </label>
                                <div class="flex items-center">
                                    <div class="flex-1 bg-gray-200 rounded-full h-3 mr-3">
                                        <div class="bg-[#f6cd45] h-3 rounded-full transition-all duration-300" 
                                             style="width: {{ $talent->profile_completion_percentage }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ number_format($talent->profile_completion_percentage, 0) }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="border-t pt-8 flex justify-end space-x-4">
                        <button type="button" onclick="window.history.back()" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-[#0066FF] text-white rounded-lg hover:bg-[#004BB8] transition-colors">
                            <i class="bi bi-check-circle mr-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Prévisualisation de l'avatar
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarContainer = document.querySelector('.w-32.h-32');
            avatarContainer.innerHTML = `<img src="${e.target.result}" alt="Avatar" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection