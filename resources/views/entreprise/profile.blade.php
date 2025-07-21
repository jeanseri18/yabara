@extends('layouts.entreprise')

@section('title', 'Profil Entreprise')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-building me-2" style="color: #14224F;"></i>Profil Entreprise</h2>
                    <p class="text-muted mb-0">Gérez les informations de votre entreprise</p>
                </div>
                <div>
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background-color: #14224F; color: white;">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('entreprise.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom_entreprise" class="form-label fw-bold">Nom de l'entreprise *</label>
                                <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" 
                                       value="{{ old('nom_entreprise', $entreprise->nom_entreprise) }}" required>
                                @error('nom_entreprise')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="numero_legal" class="form-label fw-bold">Numéro légal</label>
                                <input type="text" class="form-control" id="numero_legal" name="numero_legal" 
                                       value="{{ old('numero_legal', $entreprise->numero_legal) }}">
                                @error('numero_legal')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pole_activite_id" class="form-label fw-bold">Pôle d'activité *</label>
                                <select class="form-select" id="pole_activite_id" name="pole_activite_id" required>
                                    <option value="">Sélectionnez un pôle</option>
                                    @foreach($poles as $pole)
                                        <option value="{{ $pole->id }}" 
                                                {{ old('pole_activite_id', $entreprise->pole_activite_id) == $pole->id ? 'selected' : '' }}>
                                            {{ $pole->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pole_activite_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="effectif" class="form-label fw-bold">Effectif</label>
                                <select class="form-select" id="effectif" name="effectif">
                                    <option value="">Sélectionnez l'effectif</option>
                                    <option value="<50" {{ old('effectif', $entreprise->effectif) == '<50' ? 'selected' : '' }}>Moins de 50 employés</option>
                                    <option value="50-100" {{ old('effectif', $entreprise->effectif) == '50-100' ? 'selected' : '' }}>50 à 100 employés</option>
                                    <option value="100-500" {{ old('effectif', $entreprise->effectif) == '100-500' ? 'selected' : '' }}>100 à 500 employés</option>
                                    <option value=">500" {{ old('effectif', $entreprise->effectif) == '>500' ? 'selected' : '' }}>Plus de 500 employés</option>
                                </select>
                                @error('effectif')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="responsable_rh_prenom" class="form-label fw-bold">Prénom du responsable RH</label>
                                <input type="text" class="form-control" id="responsable_rh_prenom" name="responsable_rh_prenom" 
                                       value="{{ old('responsable_rh_prenom', $entreprise->responsable_rh_prenom) }}">
                                @error('responsable_rh_prenom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="responsable_rh_nom" class="form-label fw-bold">Nom du responsable RH</label>
                                <input type="text" class="form-control" id="responsable_rh_nom" name="responsable_rh_nom" 
                                       value="{{ old('responsable_rh_nom', $entreprise->responsable_rh_nom) }}">
                                @error('responsable_rh_nom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="responsable_rh_email" class="form-label fw-bold">Email du responsable RH</label>
                                <input type="email" class="form-control" id="responsable_rh_email" name="responsable_rh_email" 
                                       value="{{ old('responsable_rh_email', $entreprise->responsable_rh_email) }}">
                                @error('responsable_rh_email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="responsable_rh_telephone" class="form-label fw-bold">Téléphone du responsable RH</label>
                                <input type="tel" class="form-control" id="responsable_rh_telephone" name="responsable_rh_telephone" 
                                       value="{{ old('responsable_rh_telephone', $entreprise->responsable_rh_telephone) }}">
                                @error('responsable_rh_telephone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label fw-bold">Logo de l'entreprise</label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="previewLogo(this)">
                            <small class="text-muted">Formats acceptés: JPG, PNG, GIF. Taille max: 2MB</small>
                            
                            <!-- Prévisualisation du logo -->
                            <div class="mt-2" id="logo-preview-container">
                                @if($entreprise->logo_url)
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $entreprise->logo_url }}" alt="Logo actuel" class="img-thumbnail" style="max-height: 100px;" id="logo-preview">
                                        <div>
                                            <!-- <p class="small text-muted mb-1">Logo actuel</p> -->
                                            <!-- <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeLogo()">
                                                <i class="fas fa-trash me-1"></i>Supprimer
                                            </button> -->
                                        </div>
                                    </div>
                                    <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                @else
                                    <img src="" alt="Prévisualisation du logo" class="img-thumbnail d-none" style="max-height: 100px;" id="logo-preview">
                                    <p class="small text-muted mt-1 d-none" id="logo-preview-text">Prévisualisation du nouveau logo</p>
                                @endif
                            </div>
                            
                            @error('logo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn" style="background-color: #14224F; color: white;">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Paramètres de notification -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background-color: #14224F; color: white;">
                    <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Notifications</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('entreprise.profile.notifications') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notif_nouvelle_candidature" 
                                   name="notif_nouvelle_candidature" value="1"
                                   {{ $entreprise->notif_nouvelle_candidature ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_nouvelle_candidature">
                                Nouvelle candidature reçue
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="notif_deplacement_kanban" 
                                   name="notif_deplacement_kanban" value="1"
                                   {{ $entreprise->notif_deplacement_kanban ? 'checked' : '' }}>
                            <label class="form-check-label" for="notif_deplacement_kanban">
                                Déplacement dans le kanban
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-sm" style="background-color: #f6cd45; color: #14224F;">
                            <i class="fas fa-save me-2"></i>Sauvegarder
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistiques du profil -->
            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background-color: #f6cd45; color: #14224F;">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h4 class="mb-1" style="color: #14224F;">{{ $entreprise->total_offres_publiees ?? 0 }}</h4>
                            <small class="text-muted">Offres publiées</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="mb-1" style="color: #14224F;">{{ $entreprise->total_candidatures_recues ?? 0 }}</h4>
                            <small class="text-muted">Candidatures reçues</small>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <span class="badge {{ $entreprise->is_verified ? 'bg-success' : 'bg-warning' }}">
                            <i class="fas {{ $entreprise->is_verified ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                            {{ $entreprise->is_verified ? 'Entreprise vérifiée' : 'En attente de vérification' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewLogo(input) {
        const file = input.files[0];
        const preview = document.getElementById('logo-preview');
        const previewText = document.getElementById('logo-preview-text');
        
        if (file) {
            // Vérifier la taille du fichier (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Le fichier est trop volumineux. Taille maximum: 2MB');
                input.value = '';
                return;
            }
            
            // Vérifier le type de fichier
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format de fichier non supporté. Utilisez JPG, PNG ou GIF.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (previewText) {
                    previewText.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(file);
        }
    }
    
    function removeLogo() {
        if (confirm('Êtes-vous sûr de vouloir supprimer le logo ?')) {
            document.getElementById('remove_logo').value = '1';
            document.getElementById('logo-preview-container').innerHTML = '<p class="text-muted">Logo supprimé - sera effectif après enregistrement</p>';
        }
    }
</script>
@endsection