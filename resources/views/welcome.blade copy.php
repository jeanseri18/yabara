<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YABARA - Forcément, tu vas trouver</title>
    <meta name="description" content="Plateforme de recrutement sans discrimination. CV anonymes, mise en relation équitable entre talents et entreprises en Côte d'Ivoire.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Nouvelle palette de couleurs */
        :root {
            /* Couleurs principales */
            --yabara-blue: #1040BB;      /* Bleu principal */
            --yabara-gold: #ffbf1d;      /* Jaune/Orange */
            --yabara-white: #ffffff;     /* Blanc */
            --yabara-black: #000000;     /* Noir */
            --yabara-dark-gray: #000000; /* Textes noirs */
            --yabara-gray: #000000;      /* Gris remplacé par noir */
            --yabara-light-gray: #ffffff; /* Arrière-plans blancs */
            
            /* Système d'espacement - Base unit 8px */
            --spacing-xs: 8px;
            --spacing-sm: 16px;
            --spacing-md: 24px;
            --spacing-lg: 32px;
            --spacing-xl: 48px;
            
            /* Border radius */
            --radius-sm: 4px;
            --radius-md: 8px;
        }
        
        /* Typography */
        .yabara-font {
            font-family: 'Inter', Arial, sans-serif;
        }
        
        /* Hiérarchie typographique */
        .yabara-h1 {
            font-size: 32px;
            font-weight: bold;
            line-height: 1.2;
            color: var(--yabara-blue);
        }
        
        .yabara-h2 {
            font-size: 24px;
            font-weight: 500;
            line-height: 1.3;
            color: var(--yabara-blue);
        }
        
        .yabara-h3 {
            font-size: 20px;
            font-weight: 500;
            line-height: 1.4;
            color: var(--yabara-blue);
        }
        
        .yabara-body {
            font-size: 16px;
            font-weight: 400;
            line-height: 1.5;
            color: var(--yabara-dark-gray);
        }
        
        .yabara-small {
            font-size: 14px;
            font-weight: 400;
            line-height: 1.4;
            color: var(--yabara-gray);
        }
        
        .yabara-caption {
            font-size: 12px;
            font-weight: 400;
            line-height: 1.3;
            color: var(--yabara-gray);
        }
        
        /* Button Styles */
        .btn-yabara {
            background-color: var(--yabara-gold);
            color: var(--yabara-blue);
            border: 1.5px solid var(--yabara-gold);
            border-radius: var(--radius-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-yabara:hover {
            background-color: var(--yabara-gold);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(246, 205, 69, 0.3);
        }
        
        .btn-yabara-outline {
            background-color: transparent;
            color: var(--yabara-gold);
            border: 1.5px solid var(--yabara-gold);
            border-radius: var(--radius-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-yabara-outline:hover {
            background-color: var(--yabara-gold);
            color: var(--yabara-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(246, 205, 69, 0.3);
        }
        
        /* Card Styles */
        .yabara-card {
            background: var(--yabara-white);
            border: 1px solid var(--yabara-light-gray);
            border-radius: var(--radius-md);
            padding: var(--spacing-md);
            box-shadow: 0 2px 4px rgba(47, 47, 47, 0.1);
            transition: all 0.3s ease;
        }
        
        .yabara-card:hover {
            box-shadow: 0 8px 16px rgba(21, 39, 71, 0.15);
            transform: translateY(-2px);
            border-color: var(--yabara-gold);
        }
        
        /* Success/Error States */
        .yabara-success {
            color: var(--yabara-blue);
            background-color: rgba(21, 39, 71, 0.1);
            border: 1px solid var(--yabara-blue);
            border-radius: var(--radius-sm);
            padding: var(--spacing-xs) var(--spacing-sm);
        }
        
        .yabara-error {
            color: #000000;
            background-color: rgba(0, 0, 0, 0.1);
            border: 1px solid #000000;
            border-radius: var(--radius-sm);
            padding: var(--spacing-xs) var(--spacing-sm);
        }
        
        .yabara-notification {
            color: var(--yabara-gold);
            background-color: rgba(246, 205, 69, 0.1);
            border: 1px solid var(--yabara-gold);
            border-radius: var(--radius-sm);
            padding: var(--spacing-xs) var(--spacing-sm);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes rotateIn {
            from { opacity: 0; transform: rotate(-200deg); }
            to { opacity: 1; transform: rotate(0deg); }
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(100px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }
        @keyframes heartbeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.3); }
            28% { transform: scale(1); }
            42% { transform: scale(1.3); }
            70% { transform: scale(1); }
        }
        @keyframes glow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blink {
            50% { border-color: transparent; }
        }
        @keyframes morphing {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        @keyframes particleFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(-60px) rotate(240deg); }
        }
        
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 3s ease-in-out infinite; }
        .animate-slideInRight { animation: slideInRight 0.8s ease-out forwards; }
        .animate-slideInLeft { animation: slideInLeft 0.8s ease-out forwards; }
        .animate-bounceIn { animation: bounceIn 1s ease-out forwards; }
        .animate-rotateIn { animation: rotateIn 1s ease-out forwards; }
        .animate-zoomIn { animation: zoomIn 0.6s ease-out forwards; }
        .animate-slideInUp { animation: slideInUp 0.8s ease-out forwards; }
        .animate-wiggle { animation: wiggle 2s ease-in-out infinite; }
        .animate-heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
        .animate-glow { animation: glow 2s ease-in-out infinite; }
        .animate-morphing { animation: morphing 8s ease-in-out infinite; }
        .animate-particle { animation: particleFloat 6s ease-in-out infinite; }
        
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 191, 29, 0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        
        /* Effets de parallax et 3D */
        .parallax-element {
            transform-style: preserve-3d;
            transition: transform 0.1s ease-out;
        }
        
        /* Effets de glassmorphism améliorés */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Effets de hover avancés */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(16, 64, 187, 0.15);
        }
        
        /* Effets de texte */
        .text-gradient {
            background: linear-gradient(135deg, var(--yabara-gold), #ffbf1d, #ffbf1d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Particules flottantes */
        .floating-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--yabara-gold);
            border-radius: 50%;
            opacity: 0.6;
        }
        
        /* Typography Override */
        body { 
            font-family: 'Inter', Arial, sans-serif;
        }
        
        /* Gradient Styles */
        .hero-gradient {
            background-color: var(--yabara-blue);
        }
        
        .yabara-gradient {
            background: linear-gradient(135deg, var(--yabara-blue), #1040BB);
        }
        
        .gold-gradient {
            background: linear-gradient(135deg, var(--yabara-gold), #ffbf1d, #ffbf1d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Glass Effect */
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(16, 64, 187, 0.15);
        }
        
        /* Layout System */
        .section-hidden { opacity: 0; }
        
        .yabara-container { 
            max-width: 1200px;
            margin-left: auto; 
            margin-right: auto; 
            padding-left: var(--spacing-sm); 
            padding-right: var(--spacing-sm); 
        }
        
        .container-custom { 
            max-width: 85rem; 
            margin-left: auto; 
            margin-right: auto; 
            padding-left: 1rem; 
            padding-right: 1rem; 
        }
        
        /* Section Spacing */
        .yabara-section {
            padding: var(--spacing-xl) 0;
        }
        
        /* Grid System */
        .yabara-grid {
            display: grid;
            gap: var(--spacing-sm);
        }
        
        .yabara-grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .yabara-grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .yabara-grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }
        
        /* Icon Styles */
        .yabara-icon {
            width: var(--spacing-md);
            height: var(--spacing-md);
            color: var(--yabara-blue);
        }
        
        .yabara-icon-lg {
            width: var(--spacing-lg);
            height: var(--spacing-lg);
            color: var(--yabara-blue);
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 767px) {
            .yabara-grid-2,
            .yabara-grid-3,
            .yabara-grid-4 {
                grid-template-columns: 1fr;
            }
            
            .yabara-container {
                padding-left: var(--spacing-sm);
                padding-right: var(--spacing-sm);
            }
        }
        
        @media (min-width: 768px) and (max-width: 1023px) {
            .yabara-grid-3,
            .yabara-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* Legacy Colors */
        .yabara-blue { background-color: var(--yabara-blue); }
        .yabara-gold { color: var(--yabara-gold); }
    </style>
</head>
<body class="bg-white yabara-font" x-data="{ mobileMenuOpen: false }">
    <!-- Header Navigation -->
    <header class="hero-gradient text-white pb-16 md:pb-24 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse-slow"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse-slow"></div>
            
            <!-- Particules flottantes -->
            <div class="floating-particle animate-particle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="floating-particle animate-particle" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
            <div class="floating-particle animate-particle" style="top: 30%; left: 70%; animation-delay: 2s;"></div>
            <div class="floating-particle animate-particle" style="top: 80%; left: 20%; animation-delay: 3s;"></div>
            <div class="floating-particle animate-particle" style="top: 10%; left: 90%; animation-delay: 4s;"></div>
            
            <!-- Formes géométriques animées -->
            <div class="absolute top-1/4 left-1/4 w-16 h-16 border-2 border-yellow-400/30 rotate-45 animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-1/4 right-1/4 w-12 h-12 bg-yellow-400/20 rounded-full animate-morphing"></div>
        </div>
        
        <!-- Navigation -->
        <nav class="bg-white/10 backdrop-blur-md border-b border-white/20 relative z-10">
            <div class="container-custom">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <div class="text-3xl font-bold text-white">YABARA</div>
                        <div class="hidden md:block text-sm yabara-gold font-medium">Forcément, tu vas trouver</div>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <a href="#fonctionnalites" class="text-white/90 hover:text-[#f6cd45] transition-colors font-medium">Fonctionnalités</a>
                        <a href="#poles" class="text-white/90 hover:text-[#f6cd45] transition-colors font-medium">Secteurs</a>
                        <a href="#entreprises" class="text-white/90 hover:text-[#f6cd45] transition-colors font-medium">Entreprises</a>
                        <a href="#contact" class="text-white/90 hover:text-[#f6cd45] transition-colors font-medium">Contact</a>
                    </nav>
                    
                    <!-- CTA Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="bg-white/20 text-white px-6 py-2 rounded-full font-medium hover:bg-white/30 transition backdrop-blur-sm border border-white/30 transform hover:scale-105 duration-200">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" class="bg-[#f6cd45] text-[#152747] px-6 py-2 rounded-full font-semibold hover:bg-[#f7d463] transition transform hover:scale-105 duration-200">
                            S'inscrire
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="container-custom relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center pt-16 md:pt-20">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-white/20">
                        <span class="text-[#f6cd45] text-sm font-medium">🚀 Recrutement sans discrimination</span>
                    </div>
                    
                    <h1 class="yabara-h1 text-white mb-6 leading-tight" style="font-size: 48px;">
                        <span class="text-white animate-slideInLeft">Le recrutement</span><br>
                        <span class="text-gradient animate-heartbeat" style="animation-delay: 0.3s;">équitable</span><br>
                        <span class="text-white animate-slideInRight" style="animation-delay: 0.6s;">en Côte d'Ivoire</span>
                    </h1>
                    
                    <p class="yabara-body text-white/80 leading-relaxed max-w-2xl mb-8">
                        Découvrez YABARA, la première plateforme de recrutement avec <strong>CV anonymes</strong>. 
                        Talents et entreprises se rencontrent sur la base des <strong>compétences</strong>, pas des préjugés.
                    </p>
                    
                    <!-- Key Features Pills -->
                    <div class="flex flex-wrap gap-3 mb-8">
                        <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium border border-white/30">
                            🎯 CV Anonymes
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium border border-white/30">
                            🤝 5 Pôles Métiers
                        </span>
                        <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium border border-white/30">
                            🏆 Gamification
                        </span>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <button class="bg-[#f6cd45] text-[#152747] px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover-lift animate-bounceIn" style="animation-delay: 0.9s;">
                            <i class="bi bi-person-check mr-2 animate-wiggle"></i>Je suis un talent
                        </button>
                        <button class="glass-card text-white px-8 py-4 rounded-xl font-bold text-lg border border-white/30 transition-all duration-300 transform hover:scale-105 hover:bg-white/20 animate-zoomIn" style="animation-delay: 1.2s;">
                            <i class="bi bi-building mr-2 animate-pulse"></i>Je recrute
                        </button>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 text-center">
                        <div class="glass-card rounded-xl p-4 border border-white/20 hover-lift animate-slideInUp" style="animation-delay: 1.8s;">
                            <div class="text-2xl font-bold text-gradient animate-heartbeat">1000+</div>
                            <div class="text-sm text-white/80 animate-fadeInUp" style="animation-delay: 2.1s;">Talents inscrits</div>
                        </div>
                        <div class="glass-card rounded-xl p-4 border border-white/20 hover-lift animate-slideInUp" style="animation-delay: 2.1s;">
                            <div class="text-2xl font-bold text-gradient animate-glow animate-heartbeat">150+</div>
                            <div class="text-sm text-white/80 animate-fadeInUp" style="animation-delay: 2.4s;">Entreprises</div>
                        </div>
                        <div class="glass-card rounded-xl p-4 border border-white/20 hover-lift animate-slideInUp" style="animation-delay: 2.4s;">
                            <div class="text-2xl font-bold text-gradient animate-heartbeat">500+</div>
                            <div class="text-sm text-white/80 animate-fadeInUp" style="animation-delay: 2.7s;">Recrutements</div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Image/Animation -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative animate-slideInRight" style="animation-delay: 1.5s;">
                        <div class="w-80 h-80 md:w-96 md:h-96 bg-gradient-to-br from-[#f6cd45] to-[#f7d463] rounded-3xl shadow-2xl animate-float relative overflow-hidden hover-lift animate-morphing">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#152747]/20 to-transparent"></div>
                            <div class="absolute inset-0 shimmer"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-[#152747] animate-bounceIn" style="animation-delay: 2s;">
                                    <div class="text-6xl mb-4 animate-rotateIn" style="animation-delay: 2.3s;">🎯</div>
                                    <div class="text-2xl font-bold mb-2 animate-slideInUp" style="animation-delay: 2.6s;">CV Anonymes</div>
                                    <div class="text-sm opacity-80 animate-fadeInUp" style="animation-delay: 2.9s;">CVYB0675BC</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating elements -->
                        <div class="absolute -top-4 -right-4 glass-card rounded-full p-3 animate-heartbeat border border-white/30 animate-bounceIn" style="animation-delay: 3.2s;">
                            <span class="text-2xl animate-wiggle">🚀</span>
                        </div>
                        <div class="absolute -bottom-4 -left-4 glass-card rounded-full p-3 animate-pulse border border-white/30 animate-zoomIn" style="animation-delay: 3.5s;">
                            <span class="text-2xl animate-float">🎊</span>
                        </div>
                        
                        <!-- Cercles décoratifs -->
                        <div class="absolute top-1/2 -left-8 w-4 h-4 bg-white/30 rounded-full animate-particle" style="animation-delay: 4s;"></div>
                        <div class="absolute top-1/4 -right-6 w-6 h-6 bg-yellow-300/40 rounded-full animate-float" style="animation-delay: 4.3s;"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Comment ça marche Section -->
    <section class="py-20 bg-white -mt-12 relative z-10 section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="yabara-h1 mb-4 text-[#152747]">Comment ça marche ?</h2>
                <p class="yabara-body max-w-3xl mx-auto text-[#152747]/80">
                    Un processus simple et équitable en 3 étapes pour connecter talents et entreprises
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Étape 1 -->
                <div class="yabara-card p-8 shadow-lg card-hover hover-lift animate-slideInUp" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto bg-[#152747]/10 animate-bounceIn" style="animation-delay: 0.5s;">
                        <i class="bi bi-file-earmark-text text-2xl text-[#152747] animate-wiggle"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="yabara-h3 mb-4 text-[#152747] animate-fadeInUp" style="animation-delay: 0.8s;">1. Créez votre profil</h3>
                        <p class="yabara-body mb-4 text-[#152747]/80 animate-fadeInUp" style="animation-delay: 1.1s;">
                            Talents : Importez votre CV qui sera automatiquement anonymisé<br>
                            Entreprises : Publiez vos offres d'emploi
                        </p>
                        <div class="bg-[#152747]/10 rounded-lg p-3 animate-zoomIn" style="animation-delay: 1.4s;">
                            <span class="text-sm font-medium text-[#152747] animate-typing">Référence unique : CVYB0675BC</span>
                        </div>
                    </div>
                </div>
                
                <!-- Étape 2 -->
                <div class="yabara-card p-8 shadow-lg card-hover hover-lift animate-slideInUp" style="animation-delay: 0.4s;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto bg-[#152747]/10 animate-bounceIn" style="animation-delay: 0.7s;">
                        <i class="bi bi-people text-2xl text-[#152747] animate-pulse"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="yabara-h3 mb-4 text-[#152747] animate-fadeInUp" style="animation-delay: 1.0s;">2. Mise en relation</h3>
                        <p class="yabara-body mb-4 text-[#152747]/80 animate-fadeInUp" style="animation-delay: 1.3s;">
                            Notre équipe YABARA analyse et valide les candidatures pour garantir la pertinence des mises en relation
                        </p>
                        <div class="bg-[#f6cd45]/10 rounded-lg p-3 animate-zoomIn" style="animation-delay: 1.6s;">
                            <span class="text-sm font-medium text-[#152747]">Validation manuelle</span>
                        </div>
                    </div>
                </div>
                
                <!-- Étape 3 -->
                <div class="yabara-card p-8 shadow-lg card-hover hover-lift animate-slideInUp" style="animation-delay: 0.6s;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto bg-[#152747]/10 animate-bounceIn" style="animation-delay: 0.9s;">
                        <i class="bi bi-bullseye text-2xl text-[#152747] animate-heartbeat"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="yabara-h3 mb-4 text-[#152747] animate-fadeInUp" style="animation-delay: 1.2s;">3. Recrutement réussi</h3>
                        <p class="yabara-body mb-4 text-[#152747]/80 animate-fadeInUp" style="animation-delay: 1.5s;">
                            Suivi des candidatures en temps réel avec notre système Kanban jusqu'au recrutement final
                        </p>
                        <div class="bg-black/10 rounded-lg p-3 animate-zoomIn" style="animation-delay: 1.8s;">
                            <span class="text-sm font-medium text-[#152747] animate-glow">Suivi complet</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos 5 Pôles Métiers -->
    <section id="poles" class="py-20 section-hidden" style="background-color: #f6cd45;" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="yabara-h1 mb-4 text-[#152747]">Nos 5 Pôles d'Activité</h2>
                <p class="yabara-body max-w-3xl mx-auto text-[#152747]/80">
                    Une organisation complète des métiers pour faciliter vos recherches
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Pôle 1: Tertiaire -->
                <div class="yabara-card p-6 card-hover bg-white flex items-start">
                     <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-[#152747]/10 flex-shrink-0"><i class="bi bi-laptop text-4xl text-[#152747]"></i></div>
                     <div>
                         <h3 class="yabara-h3 mb-3 text-[#152747]">TERTIAIRE</h3>
                    <p class="yabara-body mb-4 text-[#152747]/80">Services & Fonctions support</p>
                    <div class="yabara-small text-[#152747]/80 space-y-1">
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Finance, Comptabilité</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Ressources Humaines</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Banque & Assurance</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Santé & Médical</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Enseignement...</div>
                     </div>
                     </div>
                 </div>
                
                <!-- Pôle 2: Secondaire -->
                <div class="yabara-card p-6 card-hover bg-white flex items-start">
                     <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-[#152747]/10 flex-shrink-0"><i class="bi bi-tools text-4xl text-[#152747]"></i></div>
                     <div>
                         <h3 class="yabara-h3 mb-3 text-[#152747]">SECONDAIRE</h3>
                    <p class="yabara-body mb-4 text-[#152747]/80">Industrie, Construction & Production</p>
                    <div class="yabara-small text-[#152747]/80 space-y-1">
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>BTP & Architecture</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Industrie & Énergie</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Logistique & Transport</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Environnement & HSE</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Agriculture...</div>
                     </div>
                     </div>
                 </div>
                
                <!-- Pôle 3: Numérique -->
                <div class="yabara-card p-6 card-hover bg-white flex items-start">
                     <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-[#152747]/10 flex-shrink-0"><i class="bi bi-code-slash text-4xl text-[#152747]"></i></div>
                     <div>
                         <h3 class="yabara-h3 mb-3 text-[#152747]">NUMÉRIQUE</h3>
                    <p class="yabara-body mb-4 text-[#152747]/80">Innovation & Technologies</p>
                    <div class="yabara-small text-[#152747]/80 space-y-1">
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Informatique & IT</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Télécommunications</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Audiovisuel & Médias</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Jeux Vidéo & Design</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>R&D...</div>
                     </div>
                     </div>
                 </div>
                
                <!-- Pôle 4: Commercial -->
                <div class="yabara-card p-6 card-hover bg-white flex items-start">
                     <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-[#152747]/10 flex-shrink-0"><i class="bi bi-graph-up-arrow text-4xl text-[#152747]"></i></div>
                     <div>
                         <h3 class="yabara-h3 mb-3 text-[#152747]">COMMERCIAL</h3>
                    <p class="yabara-body mb-4 text-[#152747]/80">Relation Client & Ventes</p>
                    <div class="yabara-small text-[#152747]/80 space-y-1">
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Marketing & Communication</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Commerces & Ventes</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Immobilier</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Relation Client</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>E-commerce...</div>
                     </div>
                     </div>
                 </div>
                
                <!-- Pôle 5: Métiers Pratiques -->
                <div class="yabara-card p-6 card-hover md:col-span-2 lg:col-span-1 bg-white flex items-start">
                     <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-[#152747]/10 flex-shrink-0"><i class="bi bi-hammer text-4xl text-[#152747]"></i></div>
                     <div>
                         <h3 class="yabara-h3 mb-3 text-[#152747]">MÉTIERS PRATIQUES</h3>
                    <p class="yabara-body mb-4 text-[#152747]/80">Économie Informelle</p>
                    <div class="yabara-small text-[#152747]/80 space-y-1">
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Artisanat & Métiers Manuels</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Sécurité & Gardiennage</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Bien-être & Esthétique</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Tourisme & Hôtellerie</div>
                        <div class="flex items-center"><i class="bi bi-check-circle-fill text-yabara-primary mr-2"></i>Arts & Culture...</div>
                     </div>
                     </div>
                 </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités par Type Section -->
    <section id="fonctionnalites" class="py-20 bg-white section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="yabara-h1 mb-4 text-[#152747]">Fonctionnalités par Profil</h2>
                <p class="yabara-body text-[#152747]/80">Des outils adaptés à chaque utilisateur</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Talents -->
                <div class="yabara-card p-8 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-person-workspace text-3xl text-[#152747]"></i>
                        </div>
                        <h3 class="yabara-h2 text-[#152747]">Talents</h3>
                    </div>
                    <ul class="space-y-3 text-[#152747]/80">
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            CV anonyme avec référence unique
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Recherche d'offres par secteur
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Suivi candidatures 4 étapes
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Dashboard avec badges <i class="bi bi-trophy"></i>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Système de parrainage
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Avatar personnalisé
                        </li>
                    </ul>
                </div>
                
                <!-- Entreprises -->
                <div class="yabara-card p-8 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-building text-3xl text-[#152747]"></i>
                        </div>
                        <h3 class="yabara-h2 text-[#152747]">Entreprises</h3>
                    </div>
                    <ul class="space-y-3 text-[#152747]/80">
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Publication d'offres 3 étapes
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Recherche de talents anonymes
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Kanban candidatures 4 colonnes
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Dashboard statistiques <i class="bi bi-bar-chart"></i>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Badges entreprise <i class="bi bi-trophy"></i>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Système de parrainage
                        </li>
                    </ul>
                </div>
                
                <!-- Admins -->
                <div class="yabara-card p-8 shadow-lg">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-gear text-3xl text-[#152747]"></i>
                        </div>
                        <h3 class="yabara-h2 text-[#152747]">Administrateurs</h3>
                    </div>
                    <ul class="space-y-3 text-[#152747]/80">
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Validation candidatures Kanban
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Recherche talents & offres
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Dashboard cockpit de pilotage
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Analytics temps réel <i class="bi bi-graph-up"></i>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Gestion paramètres avancés
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-check-circle-fill text-[#f6cd45] mr-3"></i>
                            Suggestions IA intelligentes
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gamification Section -->
    <section class="py-20 bg-gradient-to-br from-[#152747] to-[#0c192d] text-white section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">🏆 Système de Badges et Récompenses</h2>
                <p class="text-xl text-white/80 max-w-3xl mx-auto">
                    Engagez-vous davantage avec notre système de gamification unique
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold mb-6">Débloquez des badges exclusifs</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-[#f6cd45] rounded-full flex items-center justify-center">
                                <i class="bi bi-person-check text-xl text-[#152747]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Profil Complet</h4>
                                <p class="text-white/70 text-sm">Complétez votre CV à 100%</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-[#f6cd45] rounded-full flex items-center justify-center">
                                <i class="bi bi-rocket-takeoff text-xl text-[#152747]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Recruteur Express</h4>
                                <p class="text-white/70 text-sm">Recrutement en moins de 14 jours</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-[#f6cd45] rounded-full flex items-center justify-center">
                                <i class="bi bi-people text-xl text-[#152747]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Parrain Or</h4>
                                <p class="text-white/70 text-sm">Parrainez 3 talents actifs</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-[#f6cd45] rounded-full flex items-center justify-center">
                                <i class="bi bi-star-fill text-xl text-[#152747]"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Talent Légendaire</h4>
                                <p class="text-white/70 text-sm">Retenu par 3 entreprises différentes</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                        <div class="text-center">
                            <div class="text-6xl mb-4"><i class="bi bi-trophy text-[#f6cd45]"></i></div>
                            <h4 class="text-xl font-bold mb-2">Salle des Trophées</h4>
                            <p class="text-white/70 mb-6">Suivez votre progression</p>
                            <div class="bg-white/20 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm">Progression</span>
                                    <span class="text-sm font-semibold">7/15 badges</span>
                                </div>
                                <div class="w-full bg-white/20 rounded-full h-2">
                                    <div class="bg-[#f6cd45] h-2 rounded-full" style="width: 47%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating badges -->
                    <div class="absolute -top-4 -right-4 w-8 h-8 bg-[#f6cd45] rounded-full flex items-center justify-center text-sm animate-pulse">
                        <i class="bi bi-award text-[#152747] text-xs"></i>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-[#f6cd45] rounded-full flex items-center justify-center text-sm animate-pulse">
                        <i class="bi bi-bullseye text-[#152747] text-xs"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section class="py-20 bg-white section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-[#152747] mb-4">Workflow Intelligent</h2>
                <p class="text-xl text-[#152747]/80">Suivi des candidatures en temps réel avec notre système Kanban</p>
            </div>
            
            <div class="bg-gray-50 rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Étape 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-mortarboard text-2xl text-[#152747]"></i>
                        </div>
                        <h3 class="font-bold text-[#152747] mb-2">Candidatures reçues</h3>
                        <p class="text-sm text-[#152747]/80">Validation par YABARA</p>
                        <div class="mt-4 bg-[#152747]/10 rounded-lg p-3">
                            <div class="text-xs text-[#152747] font-medium">En cours de validation</div>
                        </div>
                    </div>
                    
                    <!-- Flèche -->
                    <div class="flex items-center justify-center">
                        <div class="text-2xl text-[#152747]/40">→</div>
                    </div>
                    
                    <!-- Étape 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-star text-2xl text-[#152747]"></i>
                        </div>
                        <h3 class="font-bold text-[#152747] mb-2">Présélectionnés</h3>
                        <p class="text-sm text-[#152747]/80">Validé par l'entreprise</p>
                        <div class="mt-4 bg-[#f6cd45]/20 rounded-lg p-3">
                            <div class="text-xs text-[#152747] font-medium">Profil retenu</div>
                        </div>
                    </div>
                    
                    <!-- Flèche -->
                    <div class="flex items-center justify-center">
                        <div class="text-2xl text-[#152747]/40">→</div>
                    </div>
                    
                    <!-- Étape 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-mic text-2xl text-[#152747]"></i>
                        </div>
                        <h3 class="font-bold text-[#152747] mb-2">En entretien</h3>
                        <p class="text-sm text-[#152747]/80">Coordonnées partagées</p>
                        <div class="mt-4 bg-[#152747]/20 rounded-lg p-3">
                            <div class="text-xs text-[#152747] font-medium">Entretien prévu</div>
                        </div>
                    </div>
                    
                    <!-- Flèche -->
                    <div class="flex items-center justify-center">
                        <div class="text-2xl text-[#152747]/40">→</div>
                    </div>
                    
                    <!-- Étape 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 bg-[#152747]/10">
                            <i class="bi bi-party-popper text-2xl text-[#152747]"></i>
                        </div>
                        <h3 class="font-bold text-[#152747] mb-2">Recruté</h3>
                        <p class="text-sm text-[#152747]/80">Candidature retenue</p>
                        <div class="mt-4 bg-black/10 rounded-lg p-3">
                            <div class="text-xs text-[#152747] font-medium">Félicitations !</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Entreprises Partenaires Section -->
    <section id="entreprises" class="py-20 section-hidden" style="background-color: #f6cd45;" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom text-center">
            <h2 class="text-4xl font-bold text-[#152747] mb-5">Entreprises Partenaires</h2>
            <p class="text-xl text-[#152747]/80 mb-16 max-w-4xl mx-auto">
                Que vous soyez une startup innovante, une PME en croissance ou une grande entreprise, 
                YABARA vous aide à trouver les meilleurs talents de Côte d'Ivoire
            </p>
            
            <!-- Types d'entreprises -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="yabara-card p-6 shadow-lg">
                    <div class="text-4xl mb-4"><i class="bi bi-rocket-takeoff text-[#152747]"></i></div>
                    <h3 class="text-xl font-bold text-[#152747] mb-2">Startups</h3>
                    <p class="text-[#152747]/80">Trouvez rapidement les talents qui partageront votre vision</p>
                </div>
                <div class="yabara-card p-6 shadow-lg">
                    <div class="text-4xl mb-4"><i class="bi bi-building text-[#152747]"></i></div>
                    <h3 class="text-xl font-bold text-[#152747] mb-2">PME</h3>
                    <p class="text-[#152747]/80">Développez votre équipe avec des profils qualifiés</p>
                </div>
                <div class="yabara-card p-6 shadow-lg">
                    <div class="text-4xl mb-4"><i class="bi bi-buildings text-[#152747]"></i></div>
                    <h3 class="text-xl font-bold text-[#152747] mb-2">Grandes Entreprises</h3>
                    <p class="text-[#152747]/80">Optimisez vos recrutements à grande échelle</p>
                </div>
            </div>

            <!-- Logos des entreprises -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-12">
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Orange CI</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">MTN</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Bolloré</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">NSIA</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Nestlé</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Ecobank</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Total</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Société Générale</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Lafarge</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Unilever</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">Dangote</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 flex items-center justify-center h-20 group">
                    <div class="text-[#152747] font-semibold group-hover:text-[#f6cd45] transition-colors">SGBCI</div>
                </div>
            </div>
            
            <div class="text-center">
                <button class="bg-[#f6cd45] text-[#152747] px-10 py-4 rounded-xl font-semibold text-lg transition transform hover:scale-105 duration-200">
                    <i class="bi bi-handshake mr-2"></i>Rejoindre nos partenaires
                </button>
            </div>
        </div>
    </section>

    <!-- Témoignages Section -->
    <section class="py-20 bg-white section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-[#152747] mb-4">Ils nous font confiance</h2>
                <p class="text-xl text-[#152747]/80">Découvrez les témoignages de nos utilisateurs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Témoignage Talent -->
                <div class="bg-[#152747]/5 rounded-2xl p-8 border border-[#152747]/10">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#152747] rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">A</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#152747]">Aminata K.</h4>
                            <p class="text-sm text-[#152747]/70">Développeuse Web</p>
                        </div>
                    </div>
                    <p class="text-[#152747]/80 italic">
                        "Grâce à YABARA, j'ai pu décrocher mon premier emploi dans le numérique sans discrimination. 
                        Le système de CV anonyme m'a permis d'être jugée sur mes compétences uniquement."
                    </p>
                    <div class="flex text-[#f6cd45] mt-4">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                </div>
                
                <!-- Témoignage Entreprise -->
                <div class="bg-[#f6cd45]/5 rounded-2xl p-8 border border-[#f6cd45]/10">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#f6cd45] rounded-full flex items-center justify-center mr-4">
                            <span class="text-[#152747] font-bold">K</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#152747]">Koffi M.</h4>
                            <p class="text-sm text-[#152747]/70">DRH Tech Solutions</p>
                        </div>
                    </div>
                    <p class="text-[#152747]/80 italic">
                        "YABARA a révolutionné notre processus de recrutement. 
                        Nous trouvons maintenant des talents exceptionnels que nous n'aurions jamais découverts autrement."
                    </p>
                    <div class="flex text-[#f6cd45] mt-4">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                </div>
                
                <!-- Témoignage Parrainage -->
                <div class="bg-[#152747]/5 rounded-2xl p-8 border border-[#152747]/10">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#152747] rounded-full flex items-center justify-center mr-4">
                            <span class="text-white font-bold">Y</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#152747]">Yao S.</h4>
                            <p class="text-sm text-[#152747]/70">Parrain 5 talents</p>
                        </div>
                    </div>
                    <p class="text-[#152747]/80 italic">
                        "J'ai parrainé plusieurs de mes amis sur YABARA. 
                        Le système de badges et récompenses est très motivant, et j'ai pu les aider à trouver du travail !"
                    </p>
                    <div class="flex text-[#f6cd45] mt-4">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gradient-to-br from-[#152747] to-[#0c192d] text-white section-hidden" x-intersect:enter="$el.classList.add('animate-fadeInUp'); $el.classList.remove('section-hidden')">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Questions Fréquentes</h2>
                <p class="text-xl text-white/80 max-w-2xl mx-auto">
                    Tout ce que vous devez savoir sur YABARA
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-6" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-white/5 transition">
                        <h3 class="text-xl font-semibold">Comment fonctionne l'anonymisation des CV ?</h3>
                        <i class="bi bi-chevron-down text-2xl transform transition-transform duration-200" :class="{ 'rotate-180': openFaq === 1 }"></i>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="px-8 pb-6">
                        <p class="text-white/80">
                            Vos informations personnelles (nom, photo, email, téléphone) sont automatiquement masquées. 
                            Seuls vos compétences, expériences et formations sont visibles avec une référence unique comme CVYB0675BC. 
                            Cela garantit un recrutement basé uniquement sur le mérite.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 2 -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-white/5 transition">
                        <h3 class="text-xl font-semibold">Qu'est-ce que le système de badges ?</h3>
                        <i class="bi bi-chevron-down text-2xl transform transition-transform duration-200" :class="{ 'rotate-180': openFaq === 2 }"></i>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="px-8 pb-6">
                        <p class="text-white/80">
                            Notre système de gamification vous récompense pour votre activité sur la plateforme. 
                            Talents et entreprises peuvent débloquer des badges en complétant leur profil, 
                            en étant actifs, ou en réussissant des recrutements. Cela inclut des récompenses tangibles !
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 3 -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-white/5 transition">
                        <h3 class="text-xl font-semibold">Comment fonctionne le parrainage ?</h3>
                        <i class="bi bi-chevron-down text-2xl transform transition-transform duration-200" :class="{ 'rotate-180': openFaq === 3 }"></i>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="px-8 pb-6">
                        <p class="text-white/80">
                            Invitez vos amis avec votre référence unique ! Quand ils s'inscrivent et deviennent actifs, 
                            vous gagnez des badges spéciaux et des récompenses. C'est un moyen de faire grandir 
                            la communauté YABARA tout en étant récompensé.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ 4 -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                    <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-white/5 transition">
                        <h3 class="text-xl font-semibold">Quels sont les 5 pôles d'activité ?</h3>
                        <i class="bi bi-chevron-down text-2xl transform transition-transform duration-200" :class="{ 'rotate-180': openFaq === 4 }"></i>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="px-8 pb-6">
                        <p class="text-white/80">
                            Nous couvrons : 1) TERTIAIRE (RH, Finance, Santé...), 2) SECONDAIRE (BTP, Industrie, Logistique...), 
                            3) NUMÉRIQUE (IT, Télécoms, Design...), 4) COMMERCIAL (Marketing, Ventes, Immobilier...), 
                            5) MÉTIERS PRATIQUES (Artisanat, Tourisme, Arts...). Chaque pôle contient de nombreuses familles de métiers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final Section -->
    <section class="py-20 bg-white text-black">
        <div class="container-custom text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Prêt à révolutionner votre carrière ?
            </h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto text-black/80">
                Rejoignez des milliers de talents et d'entreprises qui ont déjà fait confiance à YABARA 
                pour un recrutement plus équitable et efficace.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                <button class="bg-[#f6cd45] text-[#152747] px-12 py-5 rounded-2xl font-bold text-xl hover:bg-[#f7d463] transition transform hover:scale-105 duration-200 shadow-2xl">
                    <i class="bi bi-rocket-takeoff mr-2"></i>Créer mon compte Talent
                </button>
                <button class="bg-[#152747] text-white px-12 py-5 rounded-2xl font-bold text-xl hover:bg-[#0c192d] transition border border-white/30 transform hover:scale-105 duration-200">
                    <i class="bi bi-building mr-2"></i>Publier une offre
                </button>
            </div>
            
            <div class="flex justify-center items-center space-x-8 text-black/80">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-check-circle-fill text-[#f6cd45] text-2xl"></i>
                    <span>Inscription gratuite</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="bi bi-check-circle-fill text-[#f6cd45] text-2xl"></i>
                    <span>CV anonyme</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="bi bi-check-circle-fill text-[#f6cd45] text-2xl"></i>
                    <span>Recrutement équitable</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-[#152747] text-white py-16">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- YABARA Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="text-4xl font-bold text-[#f6cd45]">YABARA</div>
                        <div class="text-sm text-white/60">Forcément, tu vas trouver</div>
                    </div>
                    <p class="text-white/80 leading-relaxed mb-6 max-w-md">
                        La première plateforme de recrutement équitable en Côte d'Ivoire. 
                        Nous connectons talents et entreprises à travers des CV anonymes 
                        pour un recrutement basé uniquement sur les compétences.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-[#0c192d] p-3 rounded-full hover:bg-[#f6cd45] hover:text-[#152747] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-[#0c192d] p-3 rounded-full hover:bg-[#f6cd45] hover:text-[#152747] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21.12 8.12 21.12c9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-[#0c192d] p-3 rounded-full hover:bg-[#f6cd45] hover:text-[#152747] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-[#0c192d] p-3 rounded-full hover:bg-[#f6cd45] hover:text-[#152747] transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.120.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.163-1.507-.7-2.448-2.893-2.448-4.658 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.357-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-[#f6cd45]">Navigation</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Accueil</a></li>
                        <li><a href="#fonctionnalites" class="text-white/70 hover:text-[#f6cd45] transition">Fonctionnalités</a></li>
                        <li><a href="#poles" class="text-white/70 hover:text-[#f6cd45] transition">Pôles Métiers</a></li>
                        <li><a href="#entreprises" class="text-white/70 hover:text-[#f6cd45] transition">Entreprises</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">À propos</a></li>
                        <li><a href="#contact" class="text-white/70 hover:text-[#f6cd45] transition">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h3 class="text-lg font-semibold mb-6 text-[#f6cd45]">Services</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Pour les Talents</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Pour les Entreprises</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">CV Anonymes</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Système de Badges</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Parrainage</a></li>
                        <li><a href="#" class="text-white/70 hover:text-[#f6cd45] transition">Support</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="border-t border-white/10 pt-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-[#f6cd45]">
                            <i class="bi bi-geo-alt-fill text-[#152747] text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-white">Abidjan, Côte d'Ivoire</div>
                            <div class="text-sm text-white/60">Cocody, Riviera</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-[#f6cd45]">
                            <i class="bi bi-envelope-fill text-[#152747] text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-white">contact@yabara.ci</div>
                            <div class="text-sm text-white/60">Support 24/7</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center bg-[#f6cd45]">
                            <i class="bi bi-telephone-fill text-[#152747] text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-white">+225 01 02 03 04 05</div>
                            <div class="text-sm text-white/60">Lun-Ven 8h-18h</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Applications Mobile -->
            <div class="border-t border-white/10 pt-8 mb-8">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-6 text-[#f6cd45]">Téléchargez l'application</h3>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#" class="bg-[#0c192d] hover:bg-[#f6cd45] hover:text-[#152747] transition px-6 py-3 rounded-lg flex items-center space-x-3">
                            <i class="bi bi-apple text-3xl"></i>
                            <div class="text-left">
                                <div class="text-xs text-white/60">Télécharger sur</div>
                                <div class="text-sm font-semibold">App Store</div>
                            </div>
                        </a>
                        
                        <a href="#" class="bg-[#0c192d] hover:bg-[#f6cd45] hover:text-[#152747] transition px-6 py-3 rounded-lg flex items-center space-x-3">
                            <i class="bi bi-google-play text-3xl"></i>
                            <div class="text-left">
                                <div class="text-xs text-white/60">Disponible sur</div>
                                <div class="text-sm font-semibold">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="border-t border-white/10 pt-8 mb-8">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4 text-[#f6cd45]">Restez informé</h3>
                    <p class="text-white/60 mb-6">Recevez les dernières offres d'emploi et actualités YABARA</p>
                    <div class="max-w-md mx-auto flex gap-3">
                        <input type="email" placeholder="Votre adresse email" class="flex-1 px-4 py-3 bg-[#0c192d] border border-white/10 rounded-lg text-white placeholder-white/40 focus:outline-none focus:border-[#f6cd45]">
                        <button class="bg-[#f6cd45] text-[#152747] px-6 py-3 rounded-lg font-semibold transition hover:bg-white">
                            S'abonner
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center text-white/60 text-sm">
                <div class="mb-4 md:mb-0">
                    <p>&copy; 2025 YABARA. Tous droits réservés.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="transition hover:text-[#f6cd45]">Mentions légales</a>
                    <a href="#" class="transition hover:text-[#f6cd45]">Politique de confidentialité</a>
                    <a href="#" class="transition hover:text-[#f6cd45]">CGU</a>
                    <a href="#" class="transition hover:text-[#f6cd45]">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script JavaScript pour les interactions -->
    <script>
        // Animation smooth scroll pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animation de compteur pour les stats
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target + '+';
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start) + '+';
                }
            }, 16);
        }

        // Observer pour déclencher les animations de compteur
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('[data-counter]');
                    counters.forEach(counter => {
                        const target = parseInt(counter.getAttribute('data-counter'));
                        animateCounter(counter, target);
                    });
                    observer.unobserve(entry.target);
                }
            });
        });

        // Observe les éléments stats si ils existent
        document.querySelectorAll('.stats-section').forEach(el => {
            observer.observe(el);
        });

        // Parallax effect pour les éléments flottants
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.parallax');
            const speed = 0.5;

            parallax.forEach((element) => {
                const yPos = -(scrolled * speed);
                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });
        });

        // Animation d'apparition progressive des éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const appearObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                    entry.target.classList.remove('section-hidden');
                }
            });
        }, observerOptions);

        // Observer tous les éléments avec la classe section-hidden
        document.querySelectorAll('.section-hidden').forEach(el => {
            appearObserver.observe(el);
        });

        // Effet de typing pour le slogan
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Active le typing effect au chargement
        window.addEventListener('load', () => {
            const sloganElement = document.querySelector('.typing-effect');
            if (sloganElement) {
                typeWriter(sloganElement, 'Forcément, tu vas trouver', 150);
            }
        });
    </script>
</body>
</html>