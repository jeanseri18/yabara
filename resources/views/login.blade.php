<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - YABARA</title>
    <meta name="description" content="Connectez-vous à votre compte YABARA">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Couleurs YABARA */
        :root {
            --yabara-blue: #152747;
            --yabara-gold: #f6cd45;
            --yabara-white: #FFFFFF;
            --yabara-black: #000000;
            --yabara-dark-gray: #2F2F2F;
            --yabara-gray: #666666;
            --yabara-light-gray: #F3F2EF;
            
            --spacing-xs: 8px;
            --spacing-sm: 16px;
            --spacing-md: 24px;
            --spacing-lg: 32px;
            --spacing-xl: 48px;
            
            --radius-sm: 4px;
            --radius-md: 8px;
        }
        
        .yabara-font {
            font-family: 'Inter', Arial, sans-serif;
        }
        
        .btn-yabara {
            background-color: var(--yabara-blue);
            color: var(--yabara-white);
            border: 1.5px solid var(--yabara-blue);
            border-radius: var(--radius-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
        }
        
        .btn-yabara:hover {
            background-color: #1a2d52;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(21, 39, 71, 0.3);
        }
        
        .input-yabara {
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-sm);
            padding: var(--spacing-sm);
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .input-yabara:focus {
            outline: none;
            border-color: var(--yabara-blue);
            box-shadow: 0 0 0 3px rgba(21, 39, 71, 0.1);
        }
        
        .checkbox-yabara {
            accent-color: var(--yabara-blue);
        }
        
        .link-yabara {
            color: var(--yabara-blue);
            text-decoration: none;
            font-weight: 500;
        }
        
        .link-yabara:hover {
            text-decoration: underline;
        }
        
        .bg-pattern {
            background: linear-gradient(135deg, var(--yabara-blue) 0%, #1a2d52 100%);
            position: relative;
            overflow: hidden;
        }
        
        .bg-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(246, 205, 69, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(246, 205, 69, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }
        
        .logo-text {
            font-size: 48px;
            font-weight: 800;
            color: var(--yabara-gold);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 2px;
        }
    </style>
</head>
<body class="yabara-font bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Partie gauche avec le logo et le design -->
        <div class="hidden lg:flex lg:w-1/2 bg-pattern items-center justify-center relative">
            <div class="text-center z-10">
                <h1 class="logo-text mb-4">YABARA</h1>
                <p class="text-white text-xl font-light opacity-90">Forcément, tu vas trouver</p>
            </div>
        </div>
        
        <!-- Partie droite avec le formulaire de connexion -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo mobile -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-3xl font-bold" style="color: var(--yabara-blue);">YABARA</h1>
                </div>
                
                <!-- Titre de connexion -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold" style="color: var(--yabara-black);">Connexion</h2>
                </div>
                
                <!-- Formulaire -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Champ email -->
                    <div>
                        <label for="email" class="block text-sm font-medium" style="color: var(--yabara-dark-gray);">Email</label>
                        <div class="mt-1">
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                class="input-yabara" 
                                placeholder="votre@email.com"
                            >
                        </div>
                    </div>
                    
                    <!-- Champ mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium" style="color: var(--yabara-dark-gray);">Mot de passe</label>
                        <div class="mt-1 relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                class="input-yabara" 
                                placeholder="••••••••••"
                            >
                        </div>
                    </div>
                    
                    <!-- Options -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="checkbox-yabara h-4 w-4 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm" style="color: var(--yabara-gray);">garder la session</label>
                        </div>
                        
                        <div class="text-sm">
                            <a href="#" class="link-yabara">Mot de passe oublié</a>
                        </div>
                    </div>
                    
                    <!-- Bouton de connexion -->
                    <div>
                        <button type="submit" class="btn-yabara">
                            valider
                        </button>
                    </div>
                    
                    <!-- Séparateur -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50" style="color: var(--yabara-gray);">ou</span>
                        </div>
                    </div>
                    
                    <!-- Connexion OTP -->
                    <div>
                        <button type="button" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium" style="color: var(--yabara-dark-gray); background-color: var(--yabara-white);" onclick="alert('Fonctionnalité OTP à implémenter')">
                            Se connecter via OTP
                        </button>
                    </div>
                </form>
                
                <!-- Lien d'inscription -->
                <div class="mt-8 text-center">
                    <p class="text-sm" style="color: var(--yabara-gray);">
                        Vous n'avez pas de compte? 
                        <a href="{{ route('register') }}" class="link-yabara">Créer un compte</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>