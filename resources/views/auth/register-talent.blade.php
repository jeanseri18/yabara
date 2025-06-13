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
            background: linear-gradient(135deg, #1e3a8a 0%, #1F335C 100%);
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
            background: linear-gradient(135deg, #1e3a8a 0%, #1F335C 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
            opacity: 0.3;
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
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .step-line {
            position: absolute;
            top: 50%;
            left: 30px;
            right: 30px;
            height: 2px;
            background: #e5e7eb;
            z-index: 1;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #6b7280;
            position: relative;
            z-index: 2;
        }

        .step.active {
            background: #1F335C;
            color: white;
        }

        .step.completed {
            background: #10b981;
            color: white;
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
            color: #1f2937;
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
            border-color: #1F335C;
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
            border-color: #1F335C;
            background-color: #f8fafc;
        }

        .avatar-option.selected {
            border-color: #1F335C;
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
            background: #1F335C;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
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
            color: #1F335C;
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
            <div class="logo">YABARA</div>
        </div>
        
        <div class="right-panel">
            <div class="form-container">
                <a href="{{ route('register') }}" class="back-link">← Retour au choix du type de compte</a>
                
                <h1 class="form-title">Inscription Talent</h1>
                <p class="form-subtitle">Créez votre profil talent en quelques étapes</p>
                
                <div class="step-indicator">
                    <div class="step-line"></div>
                    <div class="step active" data-step="1">1</div>
                    <div class="step" data-step="2">2</div>
                    <div class="step" data-step="3">3</div>
                    <div class="step" data-step="4">4</div>
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
                    
                    <!-- Étape 3: Informations professionnelles -->
                    <div class="form-step" data-step="3">
                        <div class="section-title">Informations professionnelles</div>
                        
                        <div class="form-group">
                            <label class="form-label">Pôle d'activité</label>
                            <select name="pole_id" class="form-select" id="poleSelect">
                                <option value="">Sélectionnez un pôle</option>
                                @foreach($poles as $pole)
                                    <option value="{{ $pole->id }}" {{ old('pole_id') == $pole->id ? 'selected' : '' }}>
                                        {{ $pole->icone }} {{ $pole->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Famille de métier</label>
                            <select name="famille_metier_id" class="form-select" id="familleMetierSelect">
                                <option value="">Sélectionnez d'abord un pôle</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Niveau d'étude</label>
                            <select name="niveau_etude" class="form-select">
                                <option value="">Sélectionnez votre niveau</option>
                                <option value="BAC" {{ old('niveau_etude') == 'BAC' ? 'selected' : '' }}>BAC</option>
                                <option value="BAC+1" {{ old('niveau_etude') == 'BAC+1' ? 'selected' : '' }}>BAC+1</option>
                                <option value="BAC+2" {{ old('niveau_etude') == 'BAC+2' ? 'selected' : '' }}>BAC+2</option>
                                <option value="BAC+3" {{ old('niveau_etude') == 'BAC+3' ? 'selected' : '' }}>BAC+3</option>
                                <option value="BAC+4" {{ old('niveau_etude') == 'BAC+4' ? 'selected' : '' }}>BAC+4</option>
                                <option value="BAC+5" {{ old('niveau_etude') == 'BAC+5' ? 'selected' : '' }}>BAC+5</option>
                                <option value="BAC+6" {{ old('niveau_etude') == 'BAC+6' ? 'selected' : '' }}>BAC+6</option>
                                <option value="BAC+7" {{ old('niveau_etude') == 'BAC+7' ? 'selected' : '' }}>BAC+7</option>
                                <option value="BAC+8" {{ old('niveau_etude') == 'BAC+8' ? 'selected' : '' }}>BAC+8</option>
                            </select>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn3">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn3">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 4: Choix de l'avatar -->
                    <div class="form-step" data-step="4">
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
                            <button type="button" class="btn btn-secondary" id="prevBtn4">Précédent</button>
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
        const totalSteps = 4;

        // Fonction pour afficher une étape spécifique
        function showStep(step) {
            // Masquer toutes les étapes
            document.querySelectorAll('.form-step').forEach(el => {
                el.classList.remove('active');
            });
            
            // Afficher l'étape courante
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            
            // Mettre à jour les indicateurs
            document.querySelectorAll('.step').forEach((el, index) => {
                el.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    el.classList.add('completed');
                } else if (index + 1 === step) {
                    el.classList.add('active');
                }
            });
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
                // Validation de l'étape 3 (Informations professionnelles)
                // Ces champs sont optionnels, mais on peut ajouter des validations spécifiques si nécessaire
            } else if (step === 4) {
                // Validation de l'étape 4 (Choix de l'avatar)
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

        // Gestion des familles de métiers
        document.getElementById('poleSelect').addEventListener('change', function() {
            const poleId = this.value;
            const familleSelect = document.getElementById('familleMetierSelect');
            
            if (poleId) {
                // Appel AJAX pour récupérer les familles de métiers
                fetch(`/api/familles-metiers/${poleId}`)
                    .then(response => response.json())
                    .then(familles => {
                        familleSelect.innerHTML = '<option value="">Sélectionnez une famille de métier</option>';
                        familles.forEach(famille => {
                            const selected = '{{ old("famille_metier_id") }}' == famille.id ? 'selected' : '';
                            familleSelect.innerHTML += `<option value="${famille.id}" ${selected}>${famille.nom}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des familles de métiers:', error);
                        familleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    });
            } else {
                familleSelect.innerHTML = '<option value="">Sélectionnez d\'abord un pôle</option>';
            }
        });
    </script>
</body>
</html>