<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - YABARA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
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
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
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

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .account-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .account-type-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .account-type-card:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .account-type-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .account-type-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .account-type-description {
            font-size: 0.875rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .login-link {
            text-align: center;
            margin-top: 2rem;
            color: #6b7280;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
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

            .account-type-grid {
                grid-template-columns: 1fr;
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
                <h1 class="form-title">Inscription</h1>
                <p class="form-subtitle">Connectez-vous avec votre mail ou utilisez un qr depuis votre application</p>
                
                <div class="section-title">Type de compte</div>
                <p style="color: #6b7280; margin-bottom: 1rem; font-size: 0.9rem;">Sélectionnez un type</p>
                
                <div class="account-type-grid">
                    <a href="{{ route('register.talent') }}" class="account-type-card">
                        <span class="account-type-icon">👨🏾‍💻</span>
                        <div class="account-type-title">Talent</div>
                        <div class="account-type-description">Je recherche des opportunités professionnelles</div>
                    </a>
                    
                    <a href="{{ route('register.entreprise') }}" class="account-type-card">
                        <span class="account-type-icon">🏢</span>
                        <div class="account-type-title">Entreprise</div>
                        <div class="account-type-description">Je recrute des talents pour mon entreprise</div>
                    </a>
                </div>
                
                <div class="login-link">
                    Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>