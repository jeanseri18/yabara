<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Talent - YABARA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg, #1e3a8a 0%, #0066FF 100%); */
            min-height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .left-panel {
            flex: 1;
            background: url('/images/undraw_online-resume_z4sp 1.png') no-repeat center center / contain;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 1;
        }

        .logo {
            font-size: 4rem;
            font-weight: bold;
            color: #fbbf24;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            z-index: 1;
        }

        .right-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
        }

        .form-title {
            font-size: 2rem;
            font-weight: bold;
            color: #0066FF;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .progress-container {
            position: relative;
            height: 10px;
            background: #e5e7eb;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .progress-bar {
            height: 100%;
            background: #0066FF;
            border-radius: 5px;
            transition: width 0.3s ease;
            width: 0%;
        }

        .progress-label {
            position: absolute;
            bottom: -20px;
            right: 0;
            font-size: 0.875rem;
            color: #0066FF;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0066FF;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #0066FF;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .selection-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .selection-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .selection-card:hover {
            border-color: #0066FF;
            background-color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .selection-card.selected {
            border-color: #0066FF;
            background-color: #eff6ff;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
        }

        .selection-card .icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .selection-card .title {
            font-weight: 600;
            color: #0066FF;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .selection-card .description {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .avatar-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .avatar-option {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .avatar-option:hover {
            border-color: #0066FF;
            background-color: #f8fafc;
        }

        .avatar-option.selected {
            border-color: #0066FF;
            background-color: #eff6ff;
        }

        .avatar-option img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #0066FF;
            color: white;
        }

        .btn-primary:hover {
            background: #0066FF;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        


        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .back-link {
            color: #0066FF;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-panel {
                min-height: 200px;
            }

            .logo {
                font-size: 3rem;
            }

            .avatar-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
     
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <a href="{{ route('register') }}" class="back-link">← Retour au choix du type de compte</a>
                
                <h1 class="form-title">Inscription Talent</h1>
                <p class="form-subtitle">Créez votre profil talent en quelques étapes</p>
                
                <div class="progress-container">
                    <div class="progress-bar" id="progressBar"></div>
                    <div class="progress-label" id="progressLabel">0%</div>
                </div>

                @if ($errors->any())
                    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="error-container" style="display: none; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <ul id="error-list" style="list-style: none;">
                    </ul>
                </div>

                <form method="POST" action="{{ route('register.talent') }}" id="talentForm">
                    @csrf
                    
                    <!-- Étape 1: Informations de connexion -->
                    <div class="form-step active" data-step="1">
                        <div class="section-title">Informations de connexion</div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Confirmation du mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>
                        

                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" id="nextBtn1">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 2: Informations personnelles -->
                    <div class="form-step" data-step="2">
                        <div class="section-title">Informations personnelles</div>
                        
                        <div class="form-group">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="first_name" class="form-input" value="{{ old('first_name') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nom</label>
                            <input type="text" name="last_name" class="form-input" value="{{ old('last_name') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="phone" class="form-input" value="{{ old('phone') }}">
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn2">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn2">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 3: Pôle d'activité -->
                    <div class="form-step" data-step="3">
                        <div class="section-title">Choisissez votre pôle d'activité</div>
                        
                        <div class="selection-grid" id="poleGrid">
                            @foreach($poles as $pole)
                                <div class="selection-card" data-pole-id="{{ $pole->id }}">
                                    <span class="icon">{{ $pole->icone }}</span>
                                    <div class="title">{{ $pole->nom }}</div>
                                </div>
                            @endforeach
                        </div>
                        
                        <input type="hidden" name="pole_id" id="poleId" value="{{ old('pole_id') }}">
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn3">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn3">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 4: Famille de métier -->
                    <div class="form-step" data-step="4">
                        <div class="section-title">Choisissez votre famille de métier</div>
                        
                        <div class="selection-grid" id="familleGrid">
                            <!-- Les familles de métiers seront chargées dynamiquement -->
                        </div>
                        
                        <input type="hidden" name="famille_metier_id" id="familleMetierId" value="{{ old('famille_metier_id') }}">
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn4">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn4">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 5: Niveau de diplôme -->
                    <div class="form-step" data-step="5">
                        <div class="section-title">Choisissez votre niveau d'étude</div>
                        
                        <div class="selection-grid" id="diplomeGrid">
                            @foreach($niveauxDiplome as $niveau)
                                <div class="selection-card" data-diplome-id="{{ $niveau->id }}">
                                    <span class="icon">🎓</span>
                                    <div class="title">{{ $niveau->nom }}</div>
                                    @if($niveau->description)
                                        <div class="description">{{ $niveau->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <input type="hidden" name="niveau_diplome_id" id="niveauDiplomeId" value="{{ old('niveau_diplome_id') }}">
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn5">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn5">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 6: Choix de l'avatar -->
                    <div class="form-step" data-step="6">
                        <div class="section-title">Choisissez votre avatar</div>
                        
                        <div class="avatar-grid">
                            <div class="avatar-option" data-avatar="avatar1">
                                <div style="font-size: 3rem;">👩🏽‍💼</div>
                                <div>Avatar 1</div>
                            </div>
                            <div class="avatar-option" data-avatar="avatar2">
                                <div style="font-size: 3rem;">👨🏾‍💻</div>
                                <div>Avatar 2</div>
                            </div>
                            <div class="avatar-option" data-avatar="avatar3">
                                <div style="font-size: 3rem;">👩🏾‍🔬</div>
                                <div>Avatar 3</div>
                            </div>
                            <div class="avatar-option" data-avatar="avatar4">
                                <div style="font-size: 3rem;">👨🏽‍🎓</div>
                                <div>Avatar 4</div>
                            </div>
                            <div class="avatar-option" data-avatar="avatar5">
                                <div style="font-size: 3rem;">👩🏿‍💻</div>
                                <div>Avatar 5</div>
                            </div>
                            <div class="avatar-option" data-avatar="avatar6">
                                <div style="font-size: 3rem;">👨🏿‍💼</div>
                                <div>Avatar 6</div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="avatar_type" id="avatarType" value="">
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn6">Précédent</button>
                            <button type="submit" class="btn btn-primary">Créer mon compte</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Déclaration des variables globales
        let currentStep = 1;
        const totalSteps = 6;

        // Fonction pour afficher une étape spécifique
        function showStep(step) {
            // Masquer toutes les étapes
            document.querySelectorAll('.form-step').forEach(el => {
                el.classList.remove('active');
            });
            
            // Afficher l'étape courante
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            
            // Mettre à jour la barre de progression
            const progress = ((step - 1) / (totalSteps - 1)) * 100;
            document.getElementById('progressBar').style.width = `${progress}%`;
            document.getElementById('progressLabel').textContent = `${Math.round(progress)}%`;
        }

        // Fonction pour valider les champs d'une étape
        function validateStep(step) {
            const errorContainer = document.getElementById('error-container');
            const errorList = document.getElementById('error-list');
            errorList.innerHTML = '';
            errorContainer.style.display = 'none';
            let isValid = true;
            
            if (step === 1) {
                // Validation de l'étape 1 (Informations de connexion)
                const email = document.querySelector('input[name="email"]').value;
                const password = document.querySelector('input[name="password"]').value;
                const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
                
                if (!email) {
                    errorList.innerHTML += '<li>L\'email est obligatoire</li>';
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errorList.innerHTML += '<li>L\'email n\'est pas valide</li>';
                    isValid = false;
                }
                
                if (!password) {
                    errorList.innerHTML += '<li>Le mot de passe est obligatoire</li>';
                    isValid = false;
                } else if (password.length < 8) {
                    errorList.innerHTML += '<li>Le mot de passe doit contenir au moins 8 caractères</li>';
                    isValid = false;
                }
                
                if (password !== passwordConfirmation) {
                    errorList.innerHTML += '<li>Les mots de passe ne correspondent pas</li>';
                    isValid = false;
                }
            } else if (step === 2) {
                // Validation de l'étape 2 (Informations personnelles)
                const firstName = document.querySelector('input[name="first_name"]').value;
                const lastName = document.querySelector('input[name="last_name"]').value;
                
                if (!firstName) {
                    errorList.innerHTML += '<li>Le prénom est obligatoire</li>';
                    isValid = false;
                }
                
                if (!lastName) {
                    errorList.innerHTML += '<li>Le nom est obligatoire</li>';
                    isValid = false;
                }
            } else if (step === 3) {
                // Validation de l'étape 3 (Pôle d'activité)
                const poleId = document.getElementById('poleId').value;
                
                if (!poleId) {
                    errorList.innerHTML += '<li>Veuillez sélectionner un pôle d\'activité</li>';
                    isValid = false;
                }
            } else if (step === 4) {
                // Validation de l'étape 4 (Famille de métier)
                const familleMetierId = document.getElementById('familleMetierId').value;
                
                if (!familleMetierId) {
                    errorList.innerHTML += '<li>Veuillez sélectionner une famille de métier</li>';
                    isValid = false;
                }
            } else if (step === 5) {
                // Validation de l'étape 5 (Niveau de diplôme)
                const niveauDiplomeId = document.getElementById('niveauDiplomeId').value;
                
                if (!niveauDiplomeId) {
                    errorList.innerHTML += '<li>Veuillez sélectionner un niveau d\'étude</li>';
                    isValid = false;
                }
            } else if (step === 6) {
                // Validation de l'étape 6 (Choix de l'avatar)
                const avatarType = document.getElementById('avatarType').value;
                
                if (!avatarType) {
                    errorList.innerHTML += '<li>Veuillez sélectionner un avatar</li>';
                    isValid = false;
                }
            }
            
            if (!isValid) {
                errorContainer.style.display = 'block';
            }
            
            return isValid;
        }



        // Écouteurs d'événements pour les boutons
        document.getElementById('nextBtn1').addEventListener('click', function() {
            // Valider l'étape actuelle avant de passer à la suivante
            if (validateStep(currentStep)) {
                // Passer à l'étape suivante
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn2').addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        document.getElementById('nextBtn2').addEventListener('click', function() {
            // Valider l'étape actuelle avant de passer à la suivante
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn3').addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        document.getElementById('nextBtn3').addEventListener('click', function() {
            // Valider l'étape actuelle avant de passer à la suivante
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn4').addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        document.getElementById('nextBtn4').addEventListener('click', function() {
            // Valider l'étape actuelle avant de passer à la suivante
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn5').addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        document.getElementById('nextBtn5').addEventListener('click', function() {
            // Valider l'étape actuelle avant de passer à la suivante
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        document.getElementById('prevBtn6').addEventListener('click', function() {
            currentStep--;
            showStep(currentStep);
        });

        // Validation du formulaire avant soumission finale
        document.getElementById('talentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                this.submit();
            }
        });

        // Gestion des avatars
        document.querySelectorAll('.avatar-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.avatar-option').forEach(el => {
                    el.classList.remove('selected');
                });
                this.classList.add('selected');
                document.getElementById('avatarType').value = this.dataset.avatar;
            });
        });

        // Gestion des cartes de sélection de pôles
        document.querySelectorAll('#poleGrid .selection-card').forEach(card => {
            card.addEventListener('click', function() {
                // Désélectionner toutes les autres cartes
                document.querySelectorAll('#poleGrid .selection-card').forEach(el => {
                    el.classList.remove('selected');
                });
                
                // Sélectionner la carte cliquée
                this.classList.add('selected');
                
                // Mettre à jour le champ caché
                const poleId = this.dataset.poleId;
                document.getElementById('poleId').value = poleId;
                
                // Charger les familles de métiers pour ce pôle
                loadFamillesMetiers(poleId);
            });
        });

        // Gestion des cartes de sélection de familles de métiers
        function setupFamilleCards() {
            document.querySelectorAll('#familleGrid .selection-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Désélectionner toutes les autres cartes
                    document.querySelectorAll('#familleGrid .selection-card').forEach(el => {
                        el.classList.remove('selected');
                    });
                    
                    // Sélectionner la carte cliquée
                    this.classList.add('selected');
                    
                    // Mettre à jour le champ caché
                    document.getElementById('familleMetierId').value = this.dataset.familleId;
                });
            });
        }

        // Gestion des cartes de sélection de diplômes
        document.querySelectorAll('#diplomeGrid .selection-card').forEach(card => {
            card.addEventListener('click', function() {
                // Désélectionner toutes les autres cartes
                document.querySelectorAll('#diplomeGrid .selection-card').forEach(el => {
                    el.classList.remove('selected');
                });
                
                // Sélectionner la carte cliquée
                this.classList.add('selected');
                
                // Mettre à jour le champ caché
                document.getElementById('niveauDiplomeId').value = this.dataset.diplomeId;
            });
        });

        // Fonction pour charger les familles de métiers
        function loadFamillesMetiers(poleId) {
            const familleGrid = document.getElementById('familleGrid');
            
            if (poleId) {
                // Appel AJAX pour récupérer les familles de métiers
                fetch(`/api/familles-metiers/${poleId}`)
                    .then(response => response.json())
                    .then(familles => {
                        familleGrid.innerHTML = '';
                        familles.forEach(famille => {
                            const card = document.createElement('div');
                            card.className = 'selection-card';
                            card.dataset.familleId = famille.id;
                            card.innerHTML = `
                                <span class="icon">💼</span>
                                <div class="title">${famille.nom}</div>
                                ${famille.description ? `<div class="description">${famille.description}</div>` : ''}
                            `;
                            familleGrid.appendChild(card);
                        });
                        
                        // Réinitialiser les écouteurs d'événements
                        setupFamilleCards();
                        
                        // Présélectionner si une valeur existe
                        const oldFamilleId = '{{ old("famille_metier_id") }}';
                        if (oldFamilleId) {
                            const selectedCard = document.querySelector(`#familleGrid .selection-card[data-famille-id="${oldFamilleId}"]`);
                            if (selectedCard) {
                                selectedCard.classList.add('selected');
                                document.getElementById('familleMetierId').value = oldFamilleId;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des familles de métiers:', error);
                        familleGrid.innerHTML = '<div style="text-align: center; color: #dc2626; padding: 2rem;">Erreur de chargement des familles de métiers</div>';
                    });
            } else {
                familleGrid.innerHTML = '<div style="text-align: center; color: #6b7280; padding: 2rem;">Sélectionnez d\'abord un pôle d\'activité</div>';
            }
        }

        // Initialisation des sélections existantes
        document.addEventListener('DOMContentLoaded', function() {
            // Présélectionner le pôle si une valeur existe
            const oldPoleId = '{{ old("pole_id") }}';
            if (oldPoleId) {
                const selectedPoleCard = document.querySelector(`#poleGrid .selection-card[data-pole-id="${oldPoleId}"]`);
                if (selectedPoleCard) {
                    selectedPoleCard.classList.add('selected');
                    document.getElementById('poleId').value = oldPoleId;
                    loadFamillesMetiers(oldPoleId);
                }
            }
            
            // Présélectionner le diplôme si une valeur existe
            const oldDiplomeId = '{{ old("niveau_diplome_id") }}';
            if (oldDiplomeId) {
                const selectedDiplomeCard = document.querySelector(`#diplomeGrid .selection-card[data-diplome-id="${oldDiplomeId}"]`);
                if (selectedDiplomeCard) {
                    selectedDiplomeCard.classList.add('selected');
                    document.getElementById('niveauDiplomeId').value = oldDiplomeId;
                }
            }
        });
    </script>
</body>
</html>