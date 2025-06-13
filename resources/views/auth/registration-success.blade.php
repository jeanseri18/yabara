<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription réussie - YABARA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .success-container {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 0.8s ease-out 0.3s both;
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0, 0, 0);
            }
            40%, 43% {
                transform: translate3d(0, -15px, 0);
            }
            70% {
                transform: translate3d(0, -7px, 0);
            }
            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .checkmark {
            width: 50px;
            height: 50px;
            stroke: white;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .checkmark-path {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: draw 0.8s ease-out 0.5s forwards;
        }

        @keyframes draw {
            to {
                stroke-dashoffset: 0;
            }
        }

        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            animation: fadeIn 0.6s ease-out 0.7s both;
        }

        .success-message {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeIn 0.6s ease-out 0.9s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            animation: fadeIn 0.6s ease-out 1.1s both;
        }

        .user-info h3 {
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .user-info p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .next-steps {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: left;
            animation: fadeIn 0.6s ease-out 1.3s both;
        }

        .next-steps h4 {
            color: #1e40af;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .next-steps ul {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            color: #374151;
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
            font-size: 0.95rem;
        }

        .next-steps li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 0.6s ease-out 1.5s both;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        @media (max-width: 640px) {
            .success-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .success-title {
                font-size: 2rem;
            }

            .success-message {
                font-size: 1.1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="confetti"></div>
    
    <div class="success-container">
        <div class="success-icon">
            <svg class="checkmark" viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-path" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>

        <h1 class="success-title">Félicitations !</h1>
        
        <p class="success-message">
            Votre compte a été créé avec succès sur YABARA.
        </p>

        <div class="user-info">
            <h3>Informations du compte</h3>
            <p><strong>Type :</strong> {{ ucfirst($userType) }}</p>
            <p><strong>Email :</strong> {{ $user->email }}</p>
            @if($userType === 'talent')
                @if($user->talent->first_name)
                    <p><strong>Nom :</strong> {{ $user->talent->first_name }} {{ $user->talent->last_name }}</p>
                @else
                    <p><strong>Statut :</strong> Profil à compléter</p>
                @endif
                @if($user->talent->pole)
                    <p><strong>Pôle d'activité :</strong> {{ $user->talent->pole->icone }} {{ $user->talent->pole->nom }}</p>
                @endif
            @else
                @if($user->entreprise->nom_entreprise)
                     <p><strong>Entreprise :</strong> {{ $user->entreprise->nom_entreprise }}</p>
                 @else
                     <p><strong>Statut :</strong> Profil entreprise à compléter</p>
                 @endif
                 @if($user->entreprise->pole)
                     <p><strong>Secteur :</strong> {{ $user->entreprise->pole->nom }}</p>
                 @endif
            @endif
        </div>

        @if($userType === 'talent')
        <div class="next-steps">
            <h4>
                <span>🎯</span>
                Prochaines étapes pour optimiser votre profil
            </h4>
            <ul>
                <li>Complétez vos expériences professionnelles</li>
                <li>Ajoutez vos formations et certifications</li>
                <li>Listez vos compétences techniques</li>
                <li>Renseignez les langues que vous maîtrisez</li>
                <li>Importez ou créez votre CV</li>
            </ul>
        </div>
        @else
        <div class="next-steps">
            <h4>
                <span>🚀</span>
                Prochaines étapes pour votre entreprise
            </h4>
            <ul>
                <li>Complétez le profil de votre entreprise</li>
                <li>Publiez votre première offre d'emploi</li>
                <li>Explorez la base de talents YABARA</li>
                <li>Configurez vos préférences de recrutement</li>
                <li>Découvrez nos outils de mise en relation</li>
            </ul>
        </div>
        @endif

        <div class="action-buttons">
            @if($userType === 'talent')
                <a href="{{ route('profile.dashboard') }}" class="btn btn-primary">
                    Compléter mon profil
                </a>
            @else
                <a href="{{ route('entreprise.dashboard') }}" class="btn btn-primary">
                    Accéder au tableau de bord
                </a>
            @endif
            <a href="{{ route('welcome') }}" class="btn btn-secondary">
                Retour à l'accueil
            </a>
        </div>
    </div>

    <script>
        // Animation de confettis
        function createConfetti() {
            const confettiContainer = document.querySelector('.confetti');
            const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3', '#54a0ff'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'absolute';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                confetti.style.animationDelay = Math.random() * 2 + 's';
                confetti.style.animation = 'fall linear infinite';
                confettiContainer.appendChild(confetti);
            }
        }

        // CSS pour l'animation de chute
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                0% {
                    transform: translateY(-100vh) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(100vh) rotate(720deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Lancer les confettis après un délai
        setTimeout(createConfetti, 1000);
    </script>
</body>
</html>