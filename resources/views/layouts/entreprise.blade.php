<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Entreprise Dashboard - YABARA</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/publish-job-steps.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #283C5A;
            --secondary-color: #f6cd45;
        }
        
        /* Navbar Styles */
        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e5e7eb;
            min-height: 70px;
        }
        
        .navbar-brand {
            color: #283C5A !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 4px;
            position: relative;
            color: #62646A !important;
            padding: 12px 16px !important;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .nav-link:hover {
            background: rgba(40, 60, 90, 0.1) !important;
            color: #283C5A !important;
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .nav-link.active {
            background: #283C5A !important;
            color: #ffffff !important;
            font-weight: 600;
        }
        
        .nav-link i {
            font-size: 14px;
            width: 16px;
            text-align: center;
        }
        
        .navbar-toggler {
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(40, 60, 90, 0.2);
        }
        
        .dropdown-menu {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px 0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            animation: fadeInDown 0.3s ease;
        }
        
        .dropdown-item {
            color: #62646A;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(40, 60, 90, 0.1);
            color: #283C5A;
        }
        
        .dropdown-item i {
            width: 16px;
            text-align: center;
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
            min-width: 18px;
            text-align: center;
            font-weight: 600;
        }
        
        .badge {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 12px;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Company Logo */
        .company-logo {
            width: 32px;
            height: 32px;
            background: #283C5A;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            margin-right: 16px;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background: #283C5A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        
        /* Page Header */
        .page-header {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 0;
        }
        
        /* Mobile responsive */
        @media (max-width: 991.98px) {
            .navbar-nav {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid #e5e7eb;
            }
            
            .nav-link {
                margin: 4px 0;
                justify-content: flex-start;
            }
            
            .user-info {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid #e5e7eb;
            }
        }
        
        /* Ensure navbar items are visible */
        .navbar-collapse {
            flex-grow: 1;
        }
        
        .navbar-nav {
            flex-direction: row;
            flex-wrap: wrap;
        }
        
        @media (max-width: 991.98px) {
            .navbar-nav {
                flex-direction: column;
            }
        }
        
        /* Main content */
        .main-content {
            background: #f8fafc;
            min-height: calc(100vh - 140px);
            padding: 24px 0;
        }
        
        .btn-action {
            border: none;
            background: transparent;
            color: #62646A;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            background: rgba(40, 60, 90, 0.1);
            color: #283C5A;
        }
        
        .btn-logout {
            color: #dc3545 !important;
        }
        
        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.1) !important;
            color: #dc3545 !important;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid px-4">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('entreprise.dashboard') }}">
            
                <span>YABARA</span>
            </a>
            
            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('entreprise.dashboard') ? 'active' : '' }}" href="{{ route('entreprise.dashboard') }}">
                            Tableau de bord
                        </a>
                    </li>
                    
                    <!-- Offres d'emploi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('entreprise.offres.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Offres d'emploi
                            @if(isset($offres_actives_count) && $offres_actives_count > 0)
                                <span class="badge bg-warning text-dark ms-1">{{ $offres_actives_count }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('entreprise.offres.create') }}">
                                <i class="fas fa-plus-circle me-2"></i>Publier une offre
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('entreprise.offres.index') }}">
                                <i class="fas fa-list me-2"></i>Mes offres
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Candidatures -->
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->routeIs('entreprise.candidatures.*') ? 'active' : '' }}" href="{{ route('entreprise.candidatures.kanban') }}">
                            Candidatures
                            @if(isset($nouvelles_candidatures_count) && $nouvelles_candidatures_count > 0)
                                <span class="notification-badge">{{ $nouvelles_candidatures_count }}</span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Talents -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('entreprise.talent-search') ? 'active' : '' }}" href="{{ route('entreprise.talent-search') }}">
                            Rechercher talents
                        </a>
                    </li>
                    
                    <!-- Récompenses -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('entreprise.badges.*') || request()->routeIs('entreprise.parrainage.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Récompenses
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('entreprise.badges.index') }}">
                                <i class="fas fa-trophy me-2"></i>Mes badges
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('entreprise.parrainage.index') }}">
                                <i class="fas fa-handshake me-2"></i>
                                Parrainage
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Paramètres -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('entreprise.profile.*') ? 'active' : '' }}" href="{{ route('entreprise.profile.index') }}">
                            Mon profil
                        </a>
                    </li>
                </ul>
                
                <!-- User Info & Actions -->
                <div class="d-flex align-items-center">
                    <div class="user-info d-none d-lg-flex">
                        <div class="user-avatar">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        <span class="text-dark small">
                            {{ Auth::user()->entreprise->nom_entreprise ?? 'Mon Entreprise' }}
                        </span>
                    </div>
                    
                    <!-- Notifications -->
                    <button class="btn-action me-2 position-relative">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge" style="top: 0; right: 0;">2</span>
                    </button>
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-action btn-logout">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
 
<div style="padding-top: 50px;"></div>
      <main class="p-6">
            @yield('content')
        </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navigation Management
        document.addEventListener('DOMContentLoaded', function() {
            // Active navigation management
            const navLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Close mobile menu if open
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                });
            });
            
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Notification management
            const notificationBtns = document.querySelectorAll('.btn-action');
            notificationBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.querySelector('.bi-bell')) {
                        // Handle notification click
                        console.log('Notifications clicked');
                    } else if (this.querySelector('.bi-box-arrow-right')) {
                        // Handle logout
                        if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                            console.log('Logout confirmed');
                            // Here you would handle the actual logout
                        }
                    }
                });
            });
        });
        
        // Responsive navigation helper
        function updateNavigation() {
            const navbar = document.querySelector('.navbar');
            const isExpanded = window.innerWidth >= 992;
            
            if (isExpanded) {
                navbar.classList.remove('navbar-mobile');
            } else {
                navbar.classList.add('navbar-mobile');
            }
        }
        
        // Update on load and resize
        window.addEventListener('load', updateNavigation);
        window.addEventListener('resize', updateNavigation);
    </script>
    
    @stack('scripts')
</body>
</html>