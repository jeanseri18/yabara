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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #0066FF;
            --secondary-color: #f6cd45;
        }

        .bg-primary{
            background-color: #0066FF!important;
        }
        
/* Styles DataTables personnalisés */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 1rem;
}

/* Styles pour tous les boutons de pagination */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 0.375rem !important;
    background: #0066FF !important;
            border: 1px solid #0066FF !important;
    color: white !important;
    /* padding: 0.375rem 0.75rem !important; */
    /* margin: 0 0.125rem !important; */
}

/* État normal des boutons */
.dataTables_wrapper .dataTables_paginate .paginate_button a {
    background: #0066FF !important;
            border-color: #0066FF !important;
    color: white !important;
    text-decoration: none !important;
}

/* Bouton actuel/sélectionné */
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current a {
    background: #0f1a3d !important;
    border-color: #0f1a3d !important;
    color: white !important;
}

/* État hover */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button:hover a {
    background: #0f1a3d !important;
    border-color: #0f1a3d !important;
    color: white !important;
}

/* Boutons désactivés */
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled a {
    background: #6c757d !important;
    border-color: #6c757d !important;
    color: white !important;
    opacity: 0.6 !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover a {
    background: #6c757d !important;
    border-color: #6c757d !important;
    color: white !important;
}
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .brand-link {
            text-decoration: none;
        }
        
        .brand-text {
            color: #0066FF !important;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .sidebar-user {
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
        }
        
        .user-details {
            margin-left: 12px;
            flex: 1;
        }
        
        .user-name {
            display: block;
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.2;
        }
        
        .user-role {
            display: block;
            color: #6b7280;
            font-size: 12px;
        }
        
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 0;
        }
        
        .nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-item {
            margin: 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #62646A !important;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        
        .nav-link:hover {
            background: rgba(0, 102, 255, 0.1) !important;
            color: #0066FF !important;
            text-decoration: none;
        }
        
        .nav-link.active {
            background: #0066FF !important;
            color: #ffffff !important;
            font-weight: 600;
        }
        
        .nav-icon {
            width: 20px;
            font-size: 16px;
            text-align: center;
            margin-right: 12px;
        }
        
        .nav-text {
            flex: 1;
        }
        
        .submenu-arrow {
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        
        .nav-link[aria-expanded="true"] .submenu-arrow {
            transform: rotate(180deg);
        }
        
        .submenu {
            background: #f8fafc;
        }
        
        .submenu-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .submenu-link {
            display: flex;
            align-items: center;
            padding: 10px 24px 10px 56px;
            color: #62646A;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }
        
        .submenu-link:hover {
            background: rgba(0, 102, 255, 0.1);
            color: #0066FF;
            text-decoration: none;
        }
        
        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }
        
        /* Mobile Header */
        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1001;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }
        
        .sidebar-toggle {
            background: none;
            border: none;
            color: #62646A;
            font-size: 18px;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .sidebar-toggle:hover {
            background: rgba(0, 102, 255, 0.1);
            color: #0066FF;
        }
        
        .mobile-brand {
            color: #0066FF;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .mobile-actions {
            display: flex;
            align-items: center;
        }
        
        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            body {
                padding-top: 60px;
            }
        }
        
        @media (min-width: 992px) {
            .mobile-header {
                display: none;
            }
            
            .sidebar-overlay {
                display: none;
            }
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
        
/* Redéfinition des styles btn-primary avec la nouvelle couleur */
.btn-primary {
    background-color: #0066FF !important;
            border-color: #0066FF !important;
    color: white !important;
}

.btn-primary:hover {
    background-color: #0f1a3d !important;
    border-color: #0f1a3d !important;
    color: white !important;
}

.btn-primary:focus,
.btn-primary.focus {
    background-color: #0f1a3d !important;
    border-color: #0f1a3d !important;
    box-shadow: 0 0 0 0.2rem rgba(20, 34, 79, 0.5) !important;
}

.btn-primary:active,
.btn-primary.active {
    background-color: #0d1533 !important;
    border-color: #0d1533 !important;
}

/* Styles pour btn-outline-primary avec la couleur #0066FF */
        .btn-outline-primary {
            color: #0066FF !important;
            border-color: #0066FF !important;
    background-color: transparent !important;
}

.btn-outline-primary:hover {
    color: white !important;
    background-color: #0066FF !important;
            border-color: #0066FF !important;
}

.btn-outline-primary:focus,
.btn-outline-primary.focus {
    color: white !important;
    background-color: #0066FF !important;
            border-color: #0066FF !important;
    box-shadow: 0 0 0 0.2rem rgba(20, 34, 79, 0.5) !important;
}

.btn-outline-primary:active,
.btn-outline-primary.active {
    color: white !important;
    background-color: #0d1533 !important;
    border-color: #0d1533 !important;
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
            background: #0066FF;
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
            background: #0066FF;
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
            min-height: 100vh;
            margin-left: 280px;
            padding: 24px;
        }
        
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding-top: 84px;
            }
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
            color: #0066FF;
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
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('entreprise.dashboard') }}" class="brand-link">
                <span class="brand-text">YABARA</span>
            </a>
        </div>
        
        <!-- User Info -->
        <div class="sidebar-user">
            <div class="user-avatar">
                @if(Auth::user()->entreprise && Auth::user()->entreprise->logo_url)
                    <img src="{{ Auth::user()->entreprise->logo_url }}" alt="Logo {{ Auth::user()->entreprise->nom_entreprise }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <i class="fas fa-building text-white"></i>
                @endif
            </div>
            <div class="user-details">
                <span class="user-name">{{ Auth::user()->entreprise->nom_entreprise ?? 'Mon Entreprise' }}</span>
                <span class="user-role">Entreprise</span>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <!-- Accueil -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('entreprise.accueil') ? 'active' : '' }}" href="{{ route('entreprise.accueil') }}">
                        <i class="fas fa-home nav-icon"></i>
                        <span class="nav-text">Accueil</span>
                    </a>
                </li>
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('entreprise.dashboard') ? 'active' : '' }}" href="{{ route('entreprise.dashboard') }}">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Tableau de bord</span>
                    </a>
                </li>
                
                <!-- Offres d'emploi -->
                <li class="nav-item has-submenu">
                    <a class="nav-link {{ request()->routeIs('entreprise.offres.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#offresSubmenu" aria-expanded="false">
                        <i class="fas fa-briefcase nav-icon"></i>
                        <span class="nav-text">Offres d'emploi</span>
                        @if(isset($offres_actives_count) && $offres_actives_count > 0)
                            <span class="badge bg-warning text-dark ms-auto">{{ $offres_actives_count }}</span>
                        @endif
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <div class="collapse submenu" id="offresSubmenu">
                        <ul class="submenu-list">
                            <li><a class="submenu-link" href="{{ route('entreprise.offres.create') }}">
                                <i class="fas fa-plus-circle me-2"></i>Publier une offre
                            </a></li>
                            <li><a class="submenu-link" href="{{ route('entreprise.offres.index') }}">
                                <i class="fas fa-list me-2"></i>Mes offres
                            </a></li>
                        </ul>
                    </div>
                </li>
                
                <!-- Candidatures -->
                <li class="nav-item">
                    <a class="nav-link position-relative {{ request()->routeIs('entreprise.candidatures.*') || request()->routeIs('entreprise.offres.selection') ? 'active' : '' }}" href="{{ route('entreprise.offres.selection') }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-text">Suivi candidatures</span>
                        @if(isset($nouvelles_candidatures_count) && $nouvelles_candidatures_count > 0)
                            <span class="notification-badge">{{ $nouvelles_candidatures_count }}</span>
                        @endif
                    </a>
                </li>
                
                <!-- Talents -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('entreprise.talent-search') ? 'active' : '' }}" href="{{ route('entreprise.talent-search') }}">
                        <i class="fas fa-search nav-icon"></i>
                        <span class="nav-text">Recherche talents</span>
                    </a>
                </li>
                
                <!-- Badges & Parrainage -->
                <li class="nav-item has-submenu">
                    <a class="nav-link {{ request()->routeIs('entreprise.badges.*') || request()->routeIs('entreprise.parrainage.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#badgesSubmenu" aria-expanded="false">
                        <i class="fas fa-trophy nav-icon"></i>
                        <span class="nav-text">Badges & Parrainage</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <div class="collapse submenu" id="badgesSubmenu">
                        <ul class="submenu-list">
                            <li><a class="submenu-link" href="{{ route('entreprise.badges.index') }}">
                                <i class="fas fa-trophy me-2"></i>Mes badges
                            </a></li>
                            <li><a class="submenu-link" href="{{ route('entreprise.parrainage.index') }}">
                                <i class="fas fa-handshake me-2"></i>Parrainage
                            </a></li>
                        </ul>
                    </div>
                </li>
                
                <!-- Mon profil -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('entreprise.profile.*') ? 'active' : '' }}" href="{{ route('entreprise.profile.index') }}">
                        <i class="fas fa-user nav-icon"></i>
                        <span class="nav-text">Mon profil</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <!-- Notifications -->
            <div class="d-flex flex-column align-items-center me-3">
                <button class="btn-action position-relative">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">0</span>
                </button>
                <span class="small text-black mt-1">Notifications</span>
            </div>
            
            <!-- Logout -->
            <div class="d-flex flex-column align-items-center">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-action btn-logout" title="Déconnexion">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
                <span class="small text-black mt-1">Déconnexion</span>
            </div>
        </div>
    </div>
    
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Top Header for Mobile -->
    <div class="mobile-header d-lg-none">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="mobile-brand">YABARA</span>
        <div class="mobile-actions">
            <button class="btn-action position-relative">
                <i class="bi bi-bell"></i>
                <span class="notification-badge">2</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Management
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Toggle sidebar on mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }
            
            // Close sidebar on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
            
            // Active navigation management
            const navLinks = document.querySelectorAll('.nav-link:not([data-bs-toggle])');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Close mobile sidebar if open
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
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
    </script>
    
    @stack('scripts')
</body>
</html>