@extends('layouts.entreprise')

@section('title', 'Modifier vos informations')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- En-tête -->
    <div class="row mb-4 pt-3">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <a href="{{ route('entreprise.dashboard') }}" class="btn btn-link p-0 me-3" style="color: #666;">
                    <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                </a>
                <div>
                    <h5 class="mb-0" style="color: #333; font-weight: 600;">Modifier vos informations</h5>
                    <small class="text-muted">Ces informations seront visibles sur vos offres d'emploi.</small>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('entreprise.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Section Informations générales -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Informations générales</h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom_entreprise" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nom complet</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" 
                                   value="{{ old('nom_entreprise', $entreprise->nom_entreprise) }}" 
                                   placeholder="Orange CI"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                   required>
                        </div>
                        @error('nom_entreprise')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="logo" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Logo</label>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($entreprise->logo_url)
                                    <img src="{{ $entreprise->logo_url }}" alt="Logo" class="rounded" style="width: 40px; height: 40px; object-fit: cover;" id="logo-preview">
                                @else
                                    <div class="bg-warning rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" id="logo-preview">
                                        <i class="fas fa-building text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="previewLogo(this)"
                                   style="border: 1px solid #e0e0e0; padding: 8px; font-size: 14px;">
                        </div>
                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numero_legal" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">RCCM/SIRET</label>
                        <input type="text" class="form-control" id="numero_legal" name="numero_legal" 
                               value="{{ old('numero_legal', $entreprise->numero_legal) }}" 
                               placeholder="CI - ABJ - 2017 - B 1234"
                               style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                        @error('numero_legal')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="pole_activite_id" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Secteur</label>
                        <select class="form-select" id="pole_activite_id" name="pole_activite_id" required
                                style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                            <option value="">Numérique & Innovation</option>
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
                </div>

                <div class="mb-3">
                    <label for="effectif" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nombre de salariés</label>
                    <select class="form-select" id="effectif" name="effectif"
                            style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                        <option value="">Plus de 500 salariés</option>
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
        </div>

        <!-- Section Responsable RH -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Informations générales</h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="responsable_rh_nom" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nom</label>
                        <input type="text" class="form-control" id="responsable_rh_nom" name="responsable_rh_nom" 
                               value="{{ old('responsable_rh_nom', $entreprise->responsable_rh_nom) }}"
                               placeholder="Koffi"
                               style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                        @error('responsable_rh_nom')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="responsable_rh_prenom" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Prénom</label>
                        <input type="text" class="form-control" id="responsable_rh_prenom" name="responsable_rh_prenom" 
                               value="{{ old('responsable_rh_prenom', $entreprise->responsable_rh_prenom) }}"
                               placeholder="Aya Assetou Victorial"
                               style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                        @error('responsable_rh_prenom')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="responsable_rh_telephone" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #666;">
                                +225
                            </span>
                            <input type="tel" class="form-control" id="responsable_rh_telephone" name="responsable_rh_telephone" 
                                   value="{{ old('responsable_rh_telephone', $entreprise->responsable_rh_telephone) }}"
                                   placeholder="0707070707"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;">
                        </div>
                        @error('responsable_rh_telephone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="responsable_rh_email" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Mot de passe</label>
                        <input type="password" class="form-control" 
                               placeholder="****************"
                               style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;"
                               readonly>
                        <small class="text-muted">
                            <a href="#" style="color: #007bff; text-decoration: none;">Modifier le mot de passe</a>
                        </small>
                    </div>
                </div>

                <!-- Email dans une ligne séparée -->
                <div class="mb-3">
                    <input type="hidden" name="responsable_rh_email" value="{{ old('responsable_rh_email', $entreprise->responsable_rh_email) }}">
                </div>
            </div>
        </div>

        <!-- Section Notifications -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Informations générales</h6>
                
                <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input me-3" type="checkbox" id="notif_nouvelle_candidature" 
                           name="notif_nouvelle_candidature" value="1"
                           {{ $entreprise->notif_nouvelle_candidature ? 'checked' : '' }}
                           style="transform: scale(1.2);">
                    <label class="form-check-label flex-grow-1" for="notif_nouvelle_candidature" style="color: #333; font-size: 14px;">
                        Recevoir un mail quand on reçoit sa postule
                    </label>
                </div>
                
                <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input me-3" type="checkbox" id="notif_profil_consulte" 
                           name="notif_profil_consulte" value="1" checked
                           style="transform: scale(1.2);">
                    <label class="form-check-label flex-grow-1" for="notif_profil_consulte" style="color: #333; font-size: 14px;">
                        Être notifié quand un profil est déplacé dans le kanban
                    </label>
                </div>
                
                <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input me-3" type="checkbox" id="notif_deplacement_kanban" 
                           name="notif_deplacement_kanban" value="1"
                           {{ $entreprise->notif_deplacement_kanban ? 'checked' : '' }}
                           style="transform: scale(1.2);">
                    <label class="form-check-label flex-grow-1" for="notif_deplacement_kanban" style="color: #333; font-size: 14px;">
                        Recevoir les actualités de Yabara
                    </label>
                </div>
            </div>
        </div>

        <!-- Section Sécurité -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Sécurité et actions sensibles</h6>
                
                <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input me-3" type="checkbox" id="notif_email_principal" 
                           name="notif_email_principal" value="1" checked
                           style="transform: scale(1.2);">
                    <label class="form-check-label flex-grow-1" for="notif_email_principal" style="color: #333; font-size: 14px;">
                        Modifier l'adresse e-mail principale
                    </label>
                </div>
                
                <div class="form-check d-flex align-items-center mb-3">
                    <input class="form-check-input me-3" type="checkbox" id="notif_mot_de_passe" 
                           name="notif_mot_de_passe" value="1" checked
                           style="transform: scale(1.2);">
                    <label class="form-check-label flex-grow-1" for="notif_mot_de_passe" style="color: #333; font-size: 14px;">
                        Réinitialiser le mot de passe
                    </label>
                </div>
            </div>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="text-center pb-4">
            <button type="submit" class="btn px-5 py-3" style="background-color: #007bff; color: white; border-radius: 25px; font-weight: 500; font-size: 16px; border: none; min-width: 200px;">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewLogo(input) {
        const file = input.files[0];
        const preview = document.getElementById('logo-preview');
        
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
                preview.className = 'rounded';
                preview.style.width = '40px';
                preview.style.height = '40px';
                preview.style.objectFit = 'cover';
            };
            reader.readAsDataURL(file);
        }
    }

    // Amélioration de l'UX des checkboxes
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.style.accentColor = '#007bff';
    });
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        transition: all 0.2s ease;
    }
    
    .card {
        transition: box-shadow 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection