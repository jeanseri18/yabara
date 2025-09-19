@extends('layouts.admin')

@section('title', 'Paramètres et réglages')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- Bandeau d'actions rapides -->
    <div class="sticky-top bg-white border-bottom shadow-sm mb-4" style="top: 0; z-index: 1020; margin: -1rem -1rem 1rem -1rem; padding: 1rem;">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0" style="color: #333; font-weight: 600;">
                <i class="fas fa-cog me-2" style="color: #0066FF;"></i>
                Paramètres et réglages
            </h4>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm" onclick="scrollToSection('profile')">
                    <i class="fas fa-edit me-1"></i> Modifier profil
                </button>
                <button class="btn btn-outline-warning btn-sm" onclick="scrollToSection('notifications')">
                    <i class="fas fa-bell me-1"></i> Gérer notifications
                </button>
                <a href="mailto:support@yabara.com" class="btn btn-outline-info btn-sm">
                    <i class="fas fa-comments me-1"></i> Support YABARA
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-door-open me-1"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
            <i class="fas fa-check-circle me-2" style="color: #155724;"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Section Mon compte -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;" id="profile">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="color: #333; font-weight: 600;">
                        <i class="fas fa-user-circle me-2" style="color: #0066FF;"></i>
                        Mon compte
                    </h5>
                    
                    <form method="POST" action="{{ route('admin.settings.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nom & prénom</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Adresse e-mail admin</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                       required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Numéro de téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $user->phone) }}"
                                       style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                       placeholder="+225 XX XX XX XX">
                            </div>
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Photo/avatar (facultatif)</label>
                            <div class="d-flex align-items-center">
                                <div class="position-relative me-3">
                                    <div id="avatarPreview" class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px; border: 2px solid #e0e0e0; overflow: hidden;">
                                        @if($admin && $admin->avatar)
                                             <img src="{{ asset('storage/avatars/' . $admin->avatar) }}" alt="Avatar" class="w-100 h-100" style="object-fit: cover;">
                                         @else
                                             <i class="fas fa-user" style="color: #999; font-size: 24px;"></i>
                                         @endif
                                    </div>
                                    <!-- Indicateur de chargement -->
                                    <div id="avatarLoader" class="position-absolute top-0 start-0 w-100 h-100 rounded-circle d-none align-items-center justify-content-center" 
                                         style="background: rgba(255, 107, 53, 0.8); backdrop-filter: blur(2px);">
                                        <div class="spinner-border spinner-border-sm text-white" role="status">
                                            <span class="visually-hidden">Chargement...</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="file" id="avatarInput" name="avatar" class="form-control" accept="image/*" style="font-size: 14px;" onchange="previewAvatar(this)">
                                    <small class="text-muted">Format recommandé : carré, 200x200px minimum</small>
                                    <div id="avatarStatus" class="small mt-1"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn px-4" 
                                    style="background: linear-gradient(135deg, #0066FF 0%, #0066FF 100%); color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Section Sécurité -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="color: #333; font-weight: 600;">
                        <i class="fas fa-shield-alt me-2" style="color: #0066FF;"></i>
                        Sécurité du compte
                    </h5>
                    
                    <!-- Modifier le mot de passe -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="color: #666; font-weight: 500;">
                                <i class="fas fa-lock me-2"></i>Modifier le mot de passe
                            </span>
                            <button class="btn btn-outline-secondary btn-sm" onclick="togglePasswordForm()">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                        
                        <div id="passwordForm" style="display: none;">
                            <form method="POST" action="{{ route('admin.settings.password.update') }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="current_password" 
                                           placeholder="Mot de passe actuel" required
                                           style="border: 1px solid #e0e0e0; padding: 10px; font-size: 14px;">
                                    @error('current_password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password" 
                                           placeholder="Nouveau mot de passe" required
                                           style="border: 1px solid #e0e0e0; padding: 10px; font-size: 14px;">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="password_confirmation" 
                                           placeholder="Confirmer le nouveau mot de passe" required
                                           style="border: 1px solid #e0e0e0; padding: 10px; font-size: 14px;">
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i>Modifier
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Authentification double facteur -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="color: #666; font-weight: 500;">
                                <i class="fas fa-mobile-alt me-2"></i>Authentification double facteur
                            </span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                <label class="form-check-label" for="twoFactorAuth"></label>
                            </div>
                        </div>
                        <small class="text-muted">Sécurisez votre compte avec un code QR</small>
                    </div>
                    
                    <!-- Déconnexion tous appareils -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span style="color: #666; font-weight: 500;">
                                    <i class="fas fa-exclamation-triangle me-2" style="color: #dc3545;"></i>Déconnexion tous les appareils
                                </span>
                                <br><small class="text-muted">Bouton d'urgence en cas de problème</small>
                            </div>
                            <form method="POST" action="{{ route('admin.settings.logout-all') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter de tous les appareils ?')">
                                    <i class="fas fa-sign-out-alt me-1"></i>Déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Journal des connexions -->
                    <div>
                        <h6 style="color: #666; font-weight: 500; margin-bottom: 15px;">
                            <i class="fas fa-eye me-2"></i>Journal des connexions
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr style="background: #f8f9fa;">
                                        <th style="font-size: 12px; color: #666;">Date</th>
                                        <th style="font-size: 12px; color: #666;">IP</th>
                                        <th style="font-size: 12px; color: #666;">Lieu estimé</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-size: 12px;">{{ now()->format('d/m/Y H:i') }}</td>
                                        <td style="font-size: 12px;">{{ request()->ip() }}</td>
                                        <td style="font-size: 12px;">Abidjan, CI</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px;">{{ now()->subHours(2)->format('d/m/Y H:i') }}</td>
                                        <td style="font-size: 12px;">192.168.1.100</td>
                                        <td style="font-size: 12px;">Abidjan, CI</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section Préférences de gestion -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;" id="notifications">
                <div class="card-body p-4">
                    <h5 class="mb-3" style="color: #333; font-weight: 600;">
                        <i class="fas fa-sliders-h me-2" style="color: #0066FF;"></i>
                        Préférences de gestion
                    </h5>
                    
                    <form method="POST" action="{{ route('admin.settings.preferences.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6 style="color: #666; font-weight: 500; margin-bottom: 15px;">
                                    <i class="fas fa-bell me-2"></i>Notifications à recevoir
                                </h6>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifications[]" value="nouvelles_candidatures" id="notif1">
                                    <label class="form-check-label" for="notif1" style="font-size: 14px;">
                                        Nouvelles candidatures
                                    </label>
                                </div>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="notifications[]" value="entreprises_inactives" id="notif2">
                                    <label class="form-check-label" for="notif2" style="font-size: 14px;">
                                        Entreprises inactives
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="notifications[]" value="talents_entretien" id="notif3">
                                    <label class="form-check-label" for="notif3" style="font-size: 14px;">
                                        Talents en entretien
                                    </label>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="weekly_recap" id="weeklyRecap">
                                    <label class="form-check-label" for="weeklyRecap" style="font-size: 14px;">
                                        <i class="fas fa-envelope me-1"></i>Recevoir un récap hebdomadaire
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 style="color: #666; font-weight: 500; margin-bottom: 15px;">
                                    <i class="fas fa-palette me-2"></i>Mode d'affichage
                                </h6>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="display_mode" value="extended" id="displayExtended" checked>
                                    <label class="form-check-label" for="displayExtended" style="font-size: 14px;">
                                        Vue étendue
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="display_mode" value="condensed" id="displayCondensed">
                                    <label class="form-check-label" for="displayCondensed" style="font-size: 14px;">
                                        Vue condensée
                                    </label>
                                </div>
                                
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="dark_mode" id="darkMode">
                                    <label class="form-check-label" for="darkMode" style="font-size: 14px;">
                                        <i class="fas fa-moon me-1"></i>Mode nuit
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn px-4" 
                                    style="background: linear-gradient(135deg, #0066FF 0%, #0066FF 100%); color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-save me-2"></i>Enregistrer les préférences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordForm() {
    const form = document.getElementById('passwordForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function scrollToSection(sectionId) {
    document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
}

function previewAvatar(input) {
    const preview = document.getElementById('avatarPreview');
    const loader = document.getElementById('avatarLoader');
    const status = document.getElementById('avatarStatus');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Vérification du type de fichier
        if (!file.type.startsWith('image/')) {
            status.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Veuillez sélectionner une image valide</span>';
            return;
        }
        
        // Vérification de la taille (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            status.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>L\'image ne doit pas dépasser 5MB</span>';
            return;
        }
        
        // Afficher le loader
        loader.classList.remove('d-none');
        loader.classList.add('d-flex');
        status.innerHTML = '<span class="text-info"><i class="fas fa-upload me-1"></i>Chargement de l\'image...</span>';
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Simuler un délai de chargement pour l'effet visuel
            setTimeout(() => {
                // Créer une image pour la prévisualisation
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '50%';
                
                // Remplacer le contenu de la prévisualisation
                preview.innerHTML = '';
                preview.appendChild(img);
                
                // Masquer le loader
                loader.classList.add('d-none');
                loader.classList.remove('d-flex');
                
                // Afficher le message de succès
                status.innerHTML = '<span class="text-success"><i class="fas fa-check-circle me-1"></i>Image chargée avec succès</span>';
                
                // Effacer le message après 3 secondes
                setTimeout(() => {
                    status.innerHTML = '';
                }, 3000);
            }, 800); // Délai de 800ms pour l'effet visuel
        };
        
        reader.onerror = function() {
            loader.classList.add('d-none');
            loader.classList.remove('d-flex');
            status.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Erreur lors du chargement de l\'image</span>';
        };
        
        reader.readAsDataURL(file);
    }
}
</script>
@endsection