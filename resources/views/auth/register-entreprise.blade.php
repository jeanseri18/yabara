<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Entreprise - YABARA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .left-panel {
            flex: 1;
            background: url('/images/undraw_interview_yz52 1.png') no-repeat center center / contain;
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
            color: #1f2937;
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
            background: #14224F;
            color: white;
        }

        .btn-primary:hover {
            background: #14224F;
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

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #0066FF;
            font-size: 0.9rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .selection-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .selection-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .selection-card:hover {
            border-color: #0066FF;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
            transform: translateY(-2px);
        }

        .selection-card.selected {
            border-color: #0066FF;
            background: #f8fafc;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
        }

        .selection-card .icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .selection-card .title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .selection-card .description {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.4;
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

            .form-row {
                grid-template-columns: 1fr;
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
                
                <h1 class="form-title">Inscription Entreprise</h1>
                <p class="form-subtitle">Créez votre compte entreprise pour recruter des talents</p>
                
                <div class="progress-container">
                    <div class="progress-bar" id="progressBar"></div>
                    <div class="progress-label" id="progressLabel">0%</div>
                </div>

                <!-- Affichage des erreurs Laravel -->
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

                <form method="POST" action="{{ route('register.entreprise') }}" id="entrepriseForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Étape 1: Informations de connexion -->
                    <div class="form-step active" data-step="1">
                        <div class="section-title">Informations de connexion</div>
                        
                        <div class="form-group">
                            <label class="form-label">Email professionnel</label>
                            <input type="email" name="email" class="form-input" required>
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
                    
                    <!-- Étape 2: Sélection du pôle d'activité -->
                    <div class="form-step" data-step="2">
                        <div class="section-title">Pôle d'activité</div>
                        
                        <div class="form-group">
                            <label class="form-label">Sélectionnez votre pôle d'activité</label>
                            <input type="hidden" name="pole_activite_id" id="pole_activite_id">
                            <div class="selection-grid" id="poles-grid">
                                @foreach($poles as $pole)
                                    <div class="selection-card" data-value="{{ $pole->id }}">
                                        <span class="icon">{{ $pole->icone }}</span>
                                        <div class="title">{{ $pole->nom }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn2">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn2">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 3: Informations entreprise -->
                    <div class="form-step" data-step="3">
                        <div class="section-title">Informations entreprise</div>
                        
                        <div class="form-group">
                            <label class="form-label">Nom de l'entreprise</label>
                            <input type="text" name="nom_entreprise" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Numéro légal (SIREN/SIRET/RCCM)</label>
                            <input type="text" name="numero_legal" class="form-input" placeholder="Optionnel">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Effectif de l'entreprise</label>
                            <select name="effectif" class="form-select">
                                <option value="">Sélectionnez l'effectif</option>
                                <option value="<50">Moins de 50 employés</option>
                                <option value="50-100">50 à 100 employés</option>
                                <option value="100-500">100 à 500 employés</option>
                                <option value=">500">Plus de 500 employés</option>
                            </select>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn3">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn3">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 4: Responsable RH -->
                    <div class="form-step" data-step="4">
                        <div class="section-title">Responsable RH</div>
                        
                        <div class="info-box">
                            ℹ️ Ces informations nous aideront à personnaliser votre expérience et faciliter les échanges avec les talents.
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Prénom du responsable RH</label>
                                <input type="text" name="responsable_rh_prenom" class="form-input" placeholder="Optionnel">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Nom du responsable RH</label>
                                <input type="text" name="responsable_rh_nom" class="form-input" placeholder="Optionnel">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Email du responsable RH</label>
                                <input type="email" name="responsable_rh_email" class="form-input" placeholder="Optionnel">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Téléphone du responsable RH</label>
                                <input type="tel" name="responsable_rh_telephone" class="form-input" placeholder="Optionnel">
                            </div>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn4">Précédent</button>
                            <button type="button" class="btn btn-primary" id="nextBtn4">Suivant</button>
                        </div>
                    </div>
                    
                    <!-- Étape 5: Logo de l'entreprise -->
                    <div class="form-step" data-step="5">
                        <div class="section-title">Logo de l'entreprise</div>
                        
                        <div class="info-box">
                            🎨 Ajoutez le logo de votre entreprise pour personnaliser votre profil (optionnel).
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Logo de l'entreprise</label>
                            <input type="file" name="logo_url" class="form-input" accept="image/*" style="padding: 0.5rem;">
                            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                                Formats acceptés : JPG, PNG, SVG. Taille maximale : 2MB.
                            </small>
                        </div>
                        
                        <div id="logo-preview" style="margin-top: 1rem; text-align: center; display: none;">
                            <img id="preview-image" src="" alt="Aperçu du logo" style="max-width: 200px; max-height: 200px; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px;">
                        </div>
                        
                        <div class="info-box">
                            📋 Votre compte sera vérifié par notre équipe avant activation. Vous recevrez un email de confirmation une fois la vérification terminée.
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary" id="prevBtn5">Précédent</button>
                            <button type="submit" class="btn btn-primary">Créer mon compte entreprise</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Déclaration des variables globales
        let currentStep = 1;
        const totalSteps = 5;

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
                // Validation de l'étape 2 (Sélection du pôle d'activité)
                const poleActivite = document.querySelector('input[name="pole_activite_id"]').value;
                
                if (!poleActivite) {
                    errorList.innerHTML += '<li>Veuillez sélectionner un pôle d\'activité</li>';
                    isValid = false;
                }
            } else if (step === 3) {
                // Validation de l'étape 3 (Informations entreprise)
                const nomEntreprise = document.querySelector('input[name="nom_entreprise"]').value;
                
                if (!nomEntreprise) {
                    errorList.innerHTML += '<li>Le nom de l\'entreprise est obligatoire</li>';
                    isValid = false;
                }
            } else if (step === 4) {
                // Validation de l'étape 4 (Responsable RH)
                // Ces champs sont optionnels, mais on peut ajouter des validations spécifiques si nécessaire
            } else if (step === 5) {
                // Validation de l'étape 5 (Logo de l'entreprise)
                // Le logo est optionnel, pas de validation nécessaire
            }
            
            if (!isValid) {
                errorContainer.style.display = 'block';
            }
            
            return isValid;
        }



        // Gestion des cartes sélectionnables
        document.querySelectorAll('.selection-card').forEach(card => {
            card.addEventListener('click', function() {
                // Retirer la sélection de toutes les cartes du même groupe
                const grid = this.closest('.selection-grid');
                grid.querySelectorAll('.selection-card').forEach(c => c.classList.remove('selected'));
                
                // Ajouter la sélection à la carte cliquée
                this.classList.add('selected');
                
                // Mettre à jour le champ caché correspondant
                const value = this.getAttribute('data-value');
                if (grid.id === 'poles-grid') {
                    document.getElementById('pole_activite_id').value = value;
                }
            });
        });

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
        
        // Gestion de l'aperçu du logo
        document.querySelector('input[name="logo_url"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('logo-preview');
            const previewImage = document.getElementById('preview-image');
            
            if (file) {
                // Vérifier la taille du fichier (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux. Taille maximale : 2MB.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Vérifier le type de fichier
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Type de fichier non autorisé. Formats acceptés : JPEG, JPG, PNG, SVG.');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }
                
                // Afficher l'aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
        
        // Validation du formulaire avant soumission finale
        document.getElementById('entrepriseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                this.submit();
            }
        });

        // Restaurer les sélections en cas d'erreur de validation
        document.addEventListener('DOMContentLoaded', function() {
            const poleValue = document.getElementById('pole_activite_id').value;
            if (poleValue) {
                const selectedCard = document.querySelector(`[data-value="${poleValue}"]`);
                if (selectedCard) {
                    selectedCard.classList.add('selected');
                }
            }
        });
    </script>
</body>
</html>