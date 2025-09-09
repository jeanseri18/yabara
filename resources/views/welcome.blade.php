<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YABARA - Connexion Talents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    background: #f2f7ff;
    color: var(--black);
    /* padding: 60px 0; */
    /* position: relative; */
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
            font-size: 72px;
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
            width: 600px;
            height: 600px;
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
            background-color: #f2f7ff;
            color: var(--black);
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

        .why-choose-section .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .why-choose-section .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 15px;
            margin-bottom: 30px;
        }

        .why-choose-section .col-md-4 > div {
            text-align: center;
            padding: 30px 20px;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .why-choose-section .col-md-4 > div:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .why-choose-section .col-md-4 h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-text);
        }

        .why-choose-section .col-md-4 p {
            font-size: 16px;
            line-height: 1.6;
            color: var(--light-text);
            margin: 0;
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

        /* Partners Comments Section */
        .partners-comments {
            margin: 60px 0 40px 0;
        }

        .comments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .comment-card {
            background-color: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid var(--primary-blue);
            transition: all 0.3s ease;
            position: relative;
        }

        .comment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .comment-card::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 60px;
            color: var(--primary-blue);
            opacity: 0.3;
            font-family: serif;
        }

        .comment-content {
            margin-bottom: 20px;
        }

        .comment-content p {
            font-size: 16px;
            line-height: 1.6;
            color: var(--dark-text);
            font-style: italic;
            margin: 0;
        }

        .comment-author {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .comment-author strong {
            color: var(--primary-blue);
            font-size: 16px;
            font-weight: 600;
        }

        .comment-author span {
            color: var(--light-text);
            font-size: 14px;
            font-weight: 400;
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
            background-color: #e5e7eb;
            color: var(--dark-text);
            padding: 60px 0 0 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding-bottom: 40px;
        }

        .footer-logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #0066FF;
        }

        .footer-info {
            width: 35%;
        }

        .footer-info p {
            line-height: 1.6;
            margin-bottom: 20px;
            color: var(--light-text);
        }

        .footer-follow p {
            margin-bottom: 10px;
            color: var(--dark-text);
        }

        .footer-links {
            width: 25%;
        }

        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--dark-text);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--light-text);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--dark-text);
        }

        .footer-newsletter {
            width: 35%;
        }

        .footer-newsletter h3 {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--dark-text);
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
        }

        .newsletter-input:focus {
            border-color: #0066FF;
        }

        .newsletter-btn {
            padding: 12px 24px;
            background-color: #0066FF;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter-btn:hover {
            background-color: #0052cc;
        }

        .social-icons {
            display: flex;
            gap: 10px;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .social-icon.facebook {
            background-color: #1877f2;
            color: white;
        }

        .social-icon.linkedin {
            background-color: #0077b5;
            color: white;
        }

        .social-icon.twitter {
            background-color: #1da1f2;
            color: white;
        }

        .social-icon:hover {
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid #d1d5db;
            padding: 20px 0;
            text-align: center;
        }

        .footer-bottom p {
            margin: 0;
            color: var(--light-text);
            font-size: 14px;
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

            .footer-info, .footer-links, .footer-newsletter {
                width: 100%;
                margin-bottom: 30px;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-input {
                margin-bottom: 10px;
            }

            .why-choose-section .col-md-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .comments-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
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

            .why-choose-section .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .comments-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .comment-card {
                padding: 20px;
            }
        }
        /* Navbar Styles */
        .navbar {
            background-color: var(--white);
            padding: 10px 0;
            /* margin: 40px; */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* position: fixed; */
            /* border-radius: 10px   20px; */
            top: 0;
            left: 0;
            right: 0;
            /* z-index: 1000; */
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* max-width: 1200px; */
            margin: 0 auto;
            padding: 0 20px;
            gap: 600px;
        }

        .navbar-logo {
            font-size: 28px;
            font-weight: bold;
            color: #0066FF;
            text-decoration: none;
        }

        .navbar-auth {
            display: flex;
            gap: 15px;
        }

        .auth-btn {
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-btn.login {
            color: #0066FF ;
            border: 2px solid #0066FF ;
            background-color: transparent;
        }

        .auth-btn.login:hover {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .auth-btn.register {
            background-color: #0066FF;
            color: var(--white);
            border: 2px solid #0066FF;
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
    <div class="video-container" style="background-color: #f2f7ff;">
    </div>
        <div class="container-fluid">
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
                
                <h1>Votre passerelle 
vers l’emploi et 
les talents.</h1>
                <p>
Nous connectons les chercheurs d’emploi et les 
recruteurs sur une même plateforme simple, 
rapide et efficace.                </p>
                <br>
    <br>
  
 <div class="app-buttons">
                    <a href="{{ route('register.talent') }}" class="app-btn" style="background-color: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; font-weight: bold; width: 230px; text-align: center;">
                        Je cherche un travail
                    </a>
                    <a href="{{ route('register.entreprise') }}" class="app-btn" style="background-color: white; color: #0066FF; padding: 15px 30px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 10px; font-weight: bold; width: 230px; text-align: center;">
                        Je recrute des talents
                    </a>
                </div>
            </div>
            <div class="qr-code">
                <img src="{{ asset('images/OD15EW.png') }}" alt="QR Code">
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
            <div class="row">
                <div class="col-md-4">
              
                    <div class=" ">
                        <h3>Réseautage efficace</h3>
                        <p>Rencontrez vos clients ou vos employeurs idéaux grâce à notre algorithme de mise en relation.</p>
                    </div>
                </div>
                <div class="col-md-4">
                  
                    <div class=" ">
                        <h3>Fiabilité et sécurité</h3>
                        <p>Plateforme sécurisée pour gérer vos candidatures et assurer la protection des données.</p>
                    </div>
                </div>
                <div class="col-md-4">
       
                    <div class=" ">
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
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#FF6600"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="16" font-weight="bold">orange</text>
                        <text x="105" y="20" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="8">TM</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#FFCC00"/>
                        <ellipse cx="60" cy="30" rx="45" ry="20" fill="none" stroke="#000" stroke-width="3"/>
                        <text x="60" y="38" text-anchor="middle" fill="black" font-family="Arial, sans-serif" font-size="20" font-weight="bold">MTN</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#4CAF50"/>
                        <rect x="10" y="10" width="30" height="40" fill="#66BB6A" stroke="white" stroke-width="2"/>
                        <path d="M15 15 L35 15 L35 45 L15 45 Z" fill="none" stroke="white" stroke-width="1"/>
                        <text x="85" y="25" text-anchor="middle" fill="black" font-family="Arial, sans-serif" font-size="14" font-weight="bold">BICICI</text>
                        <text x="85" y="40" text-anchor="middle" fill="black" font-family="Arial, sans-serif" font-size="8">La banque en toute confiance</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#1E3A8A"/>
                        <ellipse cx="60" cy="20" rx="25" ry="12" fill="white"/>
                        <path d="M35 20 Q60 35 85 20" fill="white"/>
                        <text x="60" y="45" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="12" font-weight="bold">AGL</text>
                        <text x="60" y="55" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="6">AFRICA GLOBAL LOGISTICS</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="white"/>
                        <text x="20" y="25" fill="#666" font-family="Arial, sans-serif" font-size="14" font-weight="bold">ADV</text>
                        <text x="50" y="25" fill="#4CAF50" font-family="Arial, sans-serif" font-size="14" font-weight="bold">ANS</text>
                        <text x="20" y="45" fill="#666" font-family="Arial, sans-serif" font-size="8">Growing together</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#E3F2FD"/>
                        <text x="60" y="35" text-anchor="middle" fill="#1976D2" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Ecobank</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#FF0000"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Total</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#000080"/>
                        <text x="60" y="30" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="10" font-weight="bold">Société</text>
                        <text x="60" y="42" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="10" font-weight="bold">Générale</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#0066CC"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Lafarge</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#0066CC"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="12" font-weight="bold">Unilever</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#FF6600"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Dangote</text>
                    </svg>
                </div>
                <div class="partner-logo">
                    <svg width="120" height="60" viewBox="0 0 120 60" xmlns="http://www.w3.org/2000/svg">
                        <rect width="120" height="60" fill="#000080"/>
                        <text x="60" y="35" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="14" font-weight="bold">SGBCI</text>
                    </svg>
                </div>
            </div>
            
            <!-- Commentaires des partenaires -->
            <div class="partners-comments">
                <div class="comments-grid">
                    <div class="comment-card">
                        <div class="comment-content">
                            <p>"YABARA nous a permis de recruter des talents exceptionnels en un temps record. Une plateforme innovante et efficace."</p>
                        </div>
                        <div class="comment-author">
                            <strong>Orange CI</strong>
                            <span>Directeur RH</span>
                        </div>
                    </div>
                    
                    <div class="comment-card">
                        <div class="comment-content">
                            <p>"Grâce à YABARA, nous avons trouvé des profils qualifiés qui correspondent parfaitement à nos besoins. Excellent service !"</p>
                        </div>
                        <div class="comment-author">
                            <strong>MTN Côte d'Ivoire</strong>
                            <span>Responsable Recrutement</span>
                        </div>
                    </div>
                    
                    <div class="comment-card">
                        <div class="comment-content">
                            <p>"Une plateforme qui révolutionne le recrutement en Côte d'Ivoire. Interface intuitive et résultats concrets."</p>
                        </div>
                        <div class="comment-author">
                            <strong>BICICI</strong>
                            <span>Chef de Projet RH</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="partners-cta">
                <a href="{{ route('login') }}" class="btn btn-black">Voir plus</a>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer ">
        <div class="container footer-content">
            <div class="footer-info">
                <div class="footer-logo">YABARA</div>
                <p>Une plateforme pour connecter talents et entreprises.</p>
                <div class="footer-follow">
                    <p><strong>Suivez-nous !</strong></p>
                    <div class="social-icons">
                        <a href="https://facebook.com/yabara" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://linkedin.com/company/yabara" class="social-icon linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://twitter.com/yabara" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-links">
                <h3>Page</h3>
                <ul>
                    <li><a href="{{ route('welcome') }}">Accueil</a></li>
                    <li><a href="#about">À propos</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#privacy">Politique et confidentialité</a></li>
                    <li><a href="#terms">Condition général d'utilisation</a></li>
                </ul>
            </div>
            <div class="footer-newsletter">
                <h3>Newsletter</h3>
                <div class="newsletter-form">
                    <input type="email" placeholder="Abonnez-vous à la newsletter de Yabara" class="newsletter-input">
                    <button type="submit" class="newsletter-btn">Envoyer</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>Copyright 2025 © Yabara</p>
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