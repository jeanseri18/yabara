<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YABARA - Connexion Talents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-purple: #7c3aed;
            --primary-orange: #f59e0b;
            --dark-text: #1f2937;
            --light-text: #6b7280;
            --white: #ffffff;
            --light-gray: #f9fafb;
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', 'Roboto', sans-serif;
        }

        body {
            color: var(--dark-text);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 30px;
            background-color: #000;
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-black {
            background-color: #000;
        }

        .section {
            padding: 80px 0;
        }

        /* Header Section */
        .header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, #1e3a8a 100%);
    color: var(--white);
    padding: 60px 0;
    position: relative;
    overflow: hidden;
    min-height: 100vh;
}

        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.3;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .header-text {
            max-width: 50%;
        }

        .header-text h1 {
            font-size: 42px;
            margin-bottom: 24px;
            font-weight: 700;
            line-height: 1.2;
        }

        .header-text p {
            margin-bottom: 32px;
            line-height: 1.7;
            font-size: 18px;
            opacity: 0.95;
        }

        .app-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .app-btn {
            display: flex;
            align-items: center;
            background-color: transparent;
            color: white;
            padding: 5px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .app-btn img {
            border-radius: 5px;
        }

        .qr-code {
            width: 350px;
            height: 350px;
            /* background-color: var(--white); */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qr-code img {
            width: 1000%;
            height: 100%;
        }

        /* Tools Section */
        .tools-section {
            background-color: var(--white);
            padding: 80px 0;
        }

        .tools-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .tools-header h2 {
            font-size: 50px;
            margin-bottom: 16px;
            font-weight: 700;
            color: var(--dark-text);
        }

        .metrics-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .metric-card {
            width: calc(25% - 30px);
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            text-align: center;
        }

        .metric-value {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-blue);
            margin-bottom: 5px;
        }

        .metric-title {
            font-size: 14px;
            color: var(--light-text);
        }

        .chart-container {
            width: 100%;
            height: 300px;
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            position: relative;
        }

        .chart {
            width: 100%;
            height: 200px;
            background: linear-gradient(180deg, rgba(138, 69, 255, 0.2) 0%, rgba(138, 69, 255, 0) 100%);
            position: relative;
            margin-top: 50px;
        }

        .chart:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--light-gray);
        }

        .chart:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--light-gray);
        }

        .chart-line {
            position: absolute;
            top: 30%;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-purple);
            opacity: 0.5;
        }

        .chart-path {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            stroke: var(--primary-purple);
            stroke-width: 3;
            fill: none;
        }

        .talent-list {
            width: 25%;
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .talent-list h3 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .talent-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .talent-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            margin-right: 10px;
        }

        .talent-name {
            font-size: 14px;
            font-weight: bold;
        }

        /* Why Choose Section */
        .why-choose-section {
            background-color: var(--primary-purple);
            color: var(--white);
            padding: 80px 0;
        }

        .why-choose-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .why-choose-header h2 {
            font-size: 50px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .why-choose-header p {
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .benefits {
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        .benefit-card {
            display: flex;
            align-items: center;
          
            border-radius: var(--border-radius);
            overflow: hidden;
       
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-height: 300px;
            color: white;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .benefit-card:nth-child(even) {
            flex-direction: row-reverse;
        }

        .benefit-img {
            width: 50%;
            height: 500px;
        
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .benefit-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 20px;
        }

        .benefit-content {
            width: 50%;
            padding: 40px;
            color:  white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .benefit-content h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: white;
            font-weight: 600;
        }

        .benefit-content p {
            line-height: 1.7;
            color:  white;
            font-size: 18px;
        }

        /* Partners Section */
        .partners-section {
            background-color: var(--white);
            padding: 80px 0;
        }

        .partners-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .partners-header h2 {
            font-size: 50px;
            margin-bottom: 16px;
            font-weight: 700;
            color: var(--dark-text);
        }

        .partners-header p {
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
            color: var(--light-text);
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .partner-logo {
            background-color: var(--light-gray);
            border-radius: 8px;
            height: 90px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            color: var(--light-text);
            text-align: center;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .partner-logo:hover {
            background-color: var(--primary-blue);
            color: var(--white);
            transform: translateY(-2px);
        }

        .partners-cta {
            text-align: center;
            margin-top: 30px;
        }

        /* FAQ Section */
        .faq-section {
            background-color: #320D3B;
            color: var(--white);
            padding: 80px 0;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .faq-header h2 {
            font-size: 50px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .faq-section iframe {
            width: 100%;
            height: 500px;
            margin: 40px 0;
            border: none;
            border-radius: 12px;
         
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 25px;
            padding: 20px 30px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .faq-answer {
            display: none;
            padding: 15px 0 0 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            line-height: 1.6;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active {
            background-color: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .faq-item p {
            margin: 0;
        }

        .faq-cta {
            text-align: center;
            margin-top: 30px;
        }

        .faq-cta .btn {
            background-color: var(--white);
            color: var(--primary-purple);
            font-weight: 600;
        }

        .faq-cta .btn:hover {
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        /* Application Section */
        .application-section {
            padding: 60px 0;
            position: relative;
        }

        .application-img {
            width: 300px;
            height: 400px;
            background-color: var(--primary-blue);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin: 0 auto;
            margin-bottom: 30px;
        }

        .application-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .application-content {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .application-content h2 {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .application-content p {
            margin-bottom: 30px;
            line-height: 1.6;
            color: var(--light-text);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-orange);
            color: var(--white);
            padding: 40px 0;
            border-radius: 20px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer-info {
            width: 30%;
        }

        .footer-info p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .footer-links {
            width: 20%;
        }

        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--white);
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer-social {
            width: 20%;
        }

        .footer-social h3 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--white);
            color: var(--primary-orange);
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-5px);
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .header-text {
                max-width: 100%;
                margin-bottom: 30px;
            }

            .app-buttons {
                justify-content: center;
            }

            .metric-card {
                width: calc(50% - 20px);
            }

            .benefit-card {
                flex-direction: column !important;
                min-height: auto;
            }

            .benefit-img, .benefit-content {
                width: 100%;
            }

            .benefit-img {
                height: 250px;
            }

            .benefit-content {
                padding: 30px;
            }

            .partners-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-info, .footer-links, .footer-social {
                width: 100%;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 576px) {
            .metric-card {
                width: 100%;
            }

            .benefit-card {
                flex-direction: column !important;
                min-height: auto;
            }

            .benefit-img, .benefit-content {
                width: 100%;
            }

            .benefit-img {
                height: 200px;
            }

            .benefit-content {
                padding: 25px;
            }

            .benefit-content h3 {
                font-size: 24px;
            }

            .benefit-content p {
                font-size: 16px;
            }

            .partners-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        /* Navbar Styles */
        .navbar {
            background-color: var(--white);
            padding: 10px 0;
            /* margin: 40px; */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* position: fixed; */
            border-radius: 10px   20px;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar-logo {
            font-size: 28px;
            font-weight: bold;
            color: black;
            text-decoration: none;
        }

        .navbar-auth {
            display: flex;
            gap: 15px;
        }

        .auth-btn {
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-btn.login {
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            background-color: transparent;
        }

        .auth-btn.login:hover {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .auth-btn.register {
            background-color: var(--primary-blue);
            color: var(--white);
            border: 2px solid var(--primary-blue);
        }

        .auth-btn.register:hover {
            background-color: transparent;
            color: var(--primary-blue);
        }

        /* Adjust header to account for fixed navbar */
        .header {
            margin-top: 0px;
        }

        @media (max-width: 768px) {
            .navbar-content {
                padding: 0 15px;
            }

            .navbar-logo {
                font-size: 24px;
            }

            .auth-btn {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
 
    <!-- Header Section -->
    <header class="header">
    <div class="video-container">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('images/square-chips-falling-in-place.mp4') }}" type="video/mp4">
            Votre navigateur ne supporte pas la lecture de vidéos.
        </video>
    </div>
        <div class="container">
             <nav class="navbar">
        <div class="navbar-content">
            <a href="#" class="navbar-logo">YABARA</a>
            <div class="navbar-auth">
                <a href="{{ route('login') }}" class="auth-btn login">Connexion</a>
                <a href="{{ route('register') }}" class="auth-btn register">Inscription</a>
            </div>
        </div>
    </nav></div>

    <br>
    <br>
    <br>
    <br>

        <div class="container header-content">
            
            <div class="header-text">
                
                <h1>Nous vous connectons avec les meilleurs talents</h1>
                <p>Grâce à l'intelligence artificielle et à une forte expertise professionnelle, YABARA vous aide à trouver les meilleurs talents pour opportunités d'emploi.</p>
                <br>
    <br>
  
 <div class="app-buttons">
                    <a href="#" class="app-btn">
                        <img src="{{ asset('images/appstore.png') }}" alt="App Store" style="width: 230px; height: auto;">
                    </a>
                    <a href="#" class="app-btn">
                        <img src="{{ asset('images/playstore.png') }}" alt="Google Play" style="width: 230px; height: auto;">
                    </a>
                </div>
            </div>
            <div class="qr-code">
                <img src="{{ asset('images/qrcode.png') }}" alt="QR Code">
            </div>
        </div>
    </header>

    <!-- Tools Section -->
    <section class="tools-section">
        <div class="container">
            <div class="tools-header">
                <h2>Outils performants</h2>
                <p>Accédez à des fonctionnalités avancées pour gérer vos collaborations et recrutements.</p>
            </div>
            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Analytics" style="width: 100%; height: 100%; object-fit: contain; border-radius: 10px;">

        
        </div>
    </section>

    <!-- Why Choose Section -->
    <section class="why-choose-section">
        <div class="container">
            <div class="why-choose-header ">
                <h2>Pourquoi choisir YABARA ?</h2>
                <p>Mise en relation transparente. Trouvez l'association idéale des professionnels et des entreprises correspondant à vos besoins.</p>
            </div>
            <div class="benefits">
                <div class="benefit-card">
                    <div class="benefit-img">
                        <img src="{{ asset('images/reseau.png') }}" alt="Réseautage efficace">
                    </div>
                    <div class="benefit-content text-white">
                        <h3>Réseautage efficace</h3>
                        <p>Rencontrez vos clients ou vos employeurs idéaux grâce à notre algorithme de mise en relation.</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-img">
                        <img src="{{ asset('images/fiabilite.png') }}" alt="Fiabilité et sécurité">
                    </div>
                    <div class="benefit-content text-white">
                        <h3>Fiabilité et sécurité</h3>
                        <p>Plateforme sécurisée pour gérer vos candidatures et assurer la protection des données.</p>
                    </div>
                </div>
                <div class="benefit-card">
                    <div class="benefit-img">
                        <img src="{{ asset('images/outils.png') }}" alt="Outils performants">
                    </div>
                    <div class="benefit-content text-white">
                        <h3>Outils performants</h3>
                        <p>Accédez à des fonctionnalités avancées pour optimiser votre processus de recrutement.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container">
            <div class="partners-header">
                <h2>Entreprise partenaire</h2>
                <p>Que vous soyez entrepreneur, artisan, consultant ou une entreprise en quête de nouveaux talents, YABARA est le portail idéal pour trouver les compétences dont vous avez besoin.</p>
                <p class="mt-4">Nos partenaires incluent des entreprises de tous secteurs en Côte d'Ivoire, des startups innovantes aux grandes multinationales.</p>
            </div>
            <div class="partners-grid">
                <!-- 12 entreprises partenaires -->
                <div class="partner-logo">Orange CI</div>
                <div class="partner-logo">MTN</div>
                <div class="partner-logo">Bolloré</div>
                <div class="partner-logo">NSIA</div>
                <div class="partner-logo">Nestlé</div>
                <div class="partner-logo">Ecobank</div>
                <div class="partner-logo">Total</div>
                <div class="partner-logo">Société Générale</div>
                <div class="partner-logo">Lafarge</div>
                <div class="partner-logo">Unilever</div>
                <div class="partner-logo">Dangote</div>
                <div class="partner-logo">SGBCI</div>
                <div class="partner-logo">Total Energies</div>
                <div class="partner-logo">Canal+</div>
                <div class="partner-logo">Wave</div>
                <div class="partner-logo">Moov</div>
                <div class="partner-logo">CIE</div>
                <div class="partner-logo">Jumia</div>
                <div class="partner-logo">UBA</div>
                <div class="partner-logo">Advans</div>
                <div class="partner-logo">SIFCA</div>
                <div class="partner-logo">BNI</div>
                <div class="partner-logo">BICICI</div>
                <div class="partner-logo">Bernabé</div>
            </div>
            <div class="partners-cta">
                <a href="#" class="btn btn-black">Voir plus</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="faq-header">
                <h2>FAQs</h2>
                <p>Avez vous des questions concernant yabara ?</p>
            </div>

<iframe src='https://my.spline.design/robotfollowcursorforlandingpage-pbTQ1XKHEoMyalQKMQPnlfMa/' frameborder='0' width='100%' height='100%'></iframe>            <div class="faq-container">
                <div class="faq-item">
                    <p>Comment fonctionne l'anonymisation des CV ?</p>
                    <div class="faq-answer">
                        <p>Vos informations personnelles (nom, photo, email, téléphone) sont automatiquement masquées. Seuls vos compétences, expériences et formations sont visibles avec une référence unique comme CVYB0675BC. Cela garantit un recrutement basé uniquement sur le mérite.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <p>Qu'est-ce que le système de badges ?</p>
                    <div class="faq-answer">
                        <p>Notre système de gamification vous récompense pour votre activité sur la plateforme. Talents et entreprises peuvent débloquer des badges en complétant leur profil, en étant actifs, ou en réussissant des recrutements. Cela inclut des récompenses tangibles !</p>
                    </div>
                </div>
                <div class="faq-item">
                    <p>Comment fonctionne le parrainage ?</p>
                    <div class="faq-answer">
                        <p>Invitez vos amis avec votre référence unique ! Quand ils s'inscrivent et deviennent actifs, vous gagnez des badges spéciaux et des récompenses. C'est un moyen de faire grandir la communauté YABARA tout en étant récompensé.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <p>Quels sont les 5 pôles d'activité ?</p>
                    <div class="faq-answer">
                        <p>Nous couvrons :<br> 1) TERTIAIRE (RH, Finance, Santé...), <br>2) SECONDAIRE (BTP, Industrie, Logistique...),<br> 3) NUMÉRIQUE (IT, Télécoms, Design...), <br>4) COMMERCIAL (Marketing, Ventes, Immobilier...),<br> 5) MÉTIERS PRATIQUES (Artisanat, Tourisme, Arts...).<br> Chaque pôle contient de nombreuses familles de métiers.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <p>La plateforme est-elle gratuite ?</p>
                    <div class="faq-answer">
                        <p>L'inscription sur YABARA est entièrement gratuite pour les talents. Les entreprises bénéficient également d'une offre de base gratuite, avec des options premium pour des fonctionnalités avancées.</p>
                    </div>
                </div>
            </div>
            <div class="faq-cta">
                <a href="#" class="btn">Commencer</a>
            </div>
        </div>
    </section>

    <!-- Application Section -->
    <section class="application-section">
        <div class="container">
            <div class="application-img">
                <img src="{{ asset('images/candidat smplifie.png') }}" alt="Candidature simplifié">
            </div>
            <div class="application-content">
                <h2>Candidature simplifié</h2>
                <p>Envoyez directement votre dossier depuis la plateforme</p>
                <a href="#" class="btn btn-black">Commencer</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer container">
        <div class="container footer-content">
            <div class="footer-info">
                <div class="footer-logo">YABARA</div>
                <p>Plateforme innovante de mise en relation entre professionnels et entreprises.</p>
            </div>
            <div class="footer-links">
                <h3>Pages</h3>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">À propos</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h3>Restez social</h3>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Simple chart animation
        document.addEventListener('DOMContentLoaded', function() {
            const chartPath = document.querySelector('.chart-path');
            if (chartPath) {
                chartPath.style.strokeDasharray = '1000';
                chartPath.style.strokeDashoffset = '1000';
                setTimeout(() => {
                    chartPath.style.transition = 'stroke-dashoffset 2s ease-in-out';
                    chartPath.style.strokeDashoffset = '0';
                }, 500);
            }


            
            // FAQ items toggle
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                item.addEventListener('click', function() {
                    this.classList.toggle('active');
                    const faqAnswer = this.querySelector('.faq-answer');
                    if (faqAnswer) {
                        if (this.classList.contains('active')) {
                            faqAnswer.style.display = 'block';
                        } else {
                            faqAnswer.style.display = 'none';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>