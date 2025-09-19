@extends('layouts.admin')

@section('title', 'Modifier une entreprise')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- En-tête -->
    <div class="row mb-4 pt-3">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <a href="{{ route('admin.users.entreprises') }}" class="btn btn-link p-0 me-3" style="color: #666;">
                    <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                </a>
                <div>
                    <h5 class="mb-0" style="color: #333; font-weight: 600;">Modifier une entreprise</h5>
                    <small class="text-muted">Modifier les informations de {{ $user->entreprise->nom_entreprise ?? $user->name }}.</small>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.entreprises.update', $user->id) }}">
        @csrf
        @method('PUT')
        
        <!-- Section Informations générales -->
        <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Informations générales</h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom_entreprise" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nom de l'entreprise</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" 
                                   value="{{ old('nom_entreprise', $user->entreprise->nom_entreprise ?? '') }}" 
                                   placeholder="Orange CI"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                   required>
                        </div>
                        @error('nom_entreprise')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="secteur" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Secteur d'activité</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-industry"></i>
                            </span>
                            <input type="text" class="form-control" id="secteur" name="secteur" 
                                   value="{{ old('secteur', $user->entreprise->secteur ?? '') }}" 
                                   placeholder="Numérique & Innovation"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;">
                        </div>
                        @error('secteur')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="effectif" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nombre de salariés</label>
                    <select class="form-select" id="effectif" name="effectif"
                            style="border: 1px solid #e0e0e0; padding: 12px; font-size: 14px;">
                        <option value="">Sélectionner la taille</option>
                        <option value="<50" {{ old('effectif', $user->entreprise->effectif ?? '') == '<50' ? 'selected' : '' }}>Moins de 50 employés</option>
                        <option value="50-100" {{ old('effectif', $user->entreprise->effectif ?? '') == '50-100' ? 'selected' : '' }}>50 à 100 employés</option>
                        <option value="100-500" {{ old('effectif', $user->entreprise->effectif ?? '') == '100-500' ? 'selected' : '' }}>100 à 500 employés</option>
                        <option value=">500" {{ old('effectif', $user->entreprise->effectif ?? '') == '>500' ? 'selected' : '' }}>Plus de 500 employés</option>
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
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Responsable RH</h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nom complet</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Koffi Aya Assetou"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                   required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="rh@entreprise.com"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;"
                                   required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Mot de passe -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="mb-3" style="color: #333; font-weight: 600;">Sécurité</h6>
                <p class="text-muted small mb-3">Laissez vide pour conserver le mot de passe actuel.</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Minimum 8 caractères"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label" style="color: #666; font-size: 14px; font-weight: 500;">Confirmer le nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f8f9fa; border: 1px solid #e0e0e0; color: #0066FF;">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" 
                                   placeholder="Confirmer le nouveau mot de passe"
                                   style="border: 1px solid #e0e0e0; border-left: none; padding: 12px; font-size: 14px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="d-flex justify-content-between mb-4">
            <form method="POST" action="{{ route('admin.users.entreprises.delete', $user->id) }}" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?')" 
                  style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger px-4" 
                        style="border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-trash me-2"></i>Supprimer
                </button>
            </form>
            
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.entreprises') }}" class="btn btn-outline-secondary px-4" 
                   style="border-radius: 8px; font-weight: 500; border-color: #ddd; color: #666;">
                    Annuler
                </a>
                <button type="submit" class="btn px-4" 
                        style="background: linear-gradient(135deg, #0066FF 0%, #0066FF 100%); color: white; border: none; border-radius: 8px; font-weight: 500;">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>
@endsection