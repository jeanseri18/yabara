<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Entreprise Dashboard') - YABARA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #152747;
            --secondary-color: #f6cd45;
            --sidebar-width: 280px;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            transition: transform 0.3s ease;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #f6cd45 #152747;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #152747;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #f6cd45;
            border-radius: 3px;
        }
        
        .sidebar-collapsed {
            transform: translateX(-100%);
        }
        
        .nav-link {
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 2px 8px;
            position: relative;
        }
        
        .nav-link:hover {
            background: rgba(246, 205, 69, 0.15);
            transform: translateX(4px);
            color: #f6cd45 !important;
        }
        
        .nav-link.active {
            background: var(--secondary-color);
            color: var(--primary-color) !important;
            font-weight: 600;
            border-left: 3px solid #f6cd45;
        }
        
        .nav-link.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-right: 8px solid #f5f5f5;
        }
        
        .nav-section {
            margin: 16px 0;
        }
        
        .nav-section p {
            margin-bottom: 8px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #152747 0%, #1e3a5f 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
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
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Dropdown */
        .dropdown-menu {
            background: white;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            animation: fadeInDown 0.3s ease;
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
        
        /* Cards and Components */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #152747 0%, #1e3a5f 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(21, 39, 71, 0.3);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f6cd45 0%, #f39c12 100%);
            border: none;
            color: #152747;
            font-weight: 600;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
            }
            .sidebar {
                position: fixed;
                z-index: 1000;
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 bg-[#152747] text-white sidebar" id="sidebar">
        <!-- Logo & Brand -->
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-[#f6cd45] rounded-lg flex items-center justify-content-center mr-3">
                    <i class="fas fa-briefcase text-[#152747] text-sm"></i>
                </div>
                <h2 class="text-xl font-bold text-[#f6cd45]">YABARA</h2>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-300 hover:text-white">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <!-- User Info -->
        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-[#f6cd45] rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-building text-[#152747]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">
                        {{ Auth::user()->entreprise->nom_entreprise ?? 'Entreprise' }}
                    </p>
                    <p class="text-xs text-gray-400 truncate">
                        {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-4 px-2">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('entreprise.dashboard') }}" 
                   class="nav-link flex items-center px-4 py-3 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                    <span>Tableau de bord</span>
                </a>
                
                <!-- Offres d'emploi -->
                <div class="nav-section">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Offres d'emploi</p>
                    <a href="{{ route('entreprise.offres.create') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.offres.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle mr-3 w-5"></i>
                        <span>Publier une offre</span>
                    </a>
                    <a href="{{ route('entreprise.offres.index') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.offres.*') && !request()->routeIs('entreprise.offres.create') ? 'active' : '' }}">
                        <i class="fas fa-briefcase mr-3 w-5"></i>
                        <span>Mes offres</span>
                        @if(isset($offres_actives_count) && $offres_actives_count > 0)
                            <span class="ml-auto bg-[#f6cd45] text-[#152747] text-xs px-2 py-1 rounded-full">{{ $offres_actives_count }}</span>
                        @endif
                    </a>
                </div>
                
                <!-- Candidatures -->
                <div class="nav-section">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidatures</p>
                    <a href="{{ route('entreprise.candidatures.kanban') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.candidatures.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks mr-3 w-5"></i>
                        <span>Suivi candidatures</span>
                        @if(isset($nouvelles_candidatures_count) && $nouvelles_candidatures_count > 0)
                            <span class="notification-badge">{{ $nouvelles_candidatures_count }}</span>
                        @endif
                    </a>
                </div>
                
                <!-- Talents -->
                <div class="nav-section">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Talents</p>
                    <a href="{{ route('entreprise.talent-search') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.talent-search') ? 'active' : '' }}">
                        <i class="fas fa-search mr-3 w-5"></i>
                        <span>Rechercher talents</span>
                    </a>
                </div>
                
                <!-- Récompenses -->
                <div class="nav-section">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Récompenses</p>
                    <a href="{{ route('entreprise.badges.index') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.badges.*') ? 'active' : '' }}">
                        <i class="fas fa-trophy mr-3 w-5"></i>
                        <span>Mes badges</span>
                    </a>
                    <a href="{{ route('entreprise.parrainage.index') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.parrainage*') ? 'active' : '' }}">
                        <i class="fas fa-handshake mr-3 w-5"></i>
                        <span>Parrainage</span>
                    </a>
                </div>
                
                <!-- Paramètres -->
                <div class="nav-section">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Paramètres</p>
                    <a href="{{ route('entreprise.profile.index') }}" 
                       class="nav-link flex items-center px-4 py-2 text-gray-300 hover:text-white {{ request()->routeIs('entreprise.profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-cog mr-3 w-5"></i>
                        <span>Mon profil</span>
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
            <div class="flex items-center justify-between text-xs text-gray-400">
                <span>Version 1.0</span>
                <a href="#" class="hover:text-white">
                    <i class="fas fa-question-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button onclick="toggleSidebar()" class="lg:hidden mr-4">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-[#f6cd45] rounded-full flex items-center justify-center">
                            <i class="bi bi-building text-[#152747]"></i>
                        </div>
                        <span class="text-gray-700">{{ Auth::user()->entreprise->nom_entreprise ?? 'Entreprise' }}</span>
                    </div>
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-gray-900">
                            <i class="bi bi-bell text-xl"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <script>
        // Sidebar Management
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth <= 1024) {
                sidebar.classList.toggle('show');
                if (overlay) {
                    overlay.classList.toggle('show');
                }
            } else {
                sidebar.classList.toggle('sidebar-collapsed');
            }
        }
        
        // Initialize sidebar overlay for mobile
        function initSidebarOverlay() {
            if (!document.getElementById('sidebar-overlay')) {
                const overlay = document.createElement('div');
                overlay.id = 'sidebar-overlay';
                overlay.className = 'sidebar-overlay';
                overlay.addEventListener('click', closeSidebar);
                document.body.appendChild(overlay);
            }
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar) sidebar.classList.remove('show');
            if (overlay) overlay.classList.remove('show');
        }
        
        // Auto-hide sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('[onclick="toggleSidebar()"]');
            
            if (window.innerWidth <= 1024 && 
                sidebar && 
                !sidebar.contains(event.target) && 
                toggleBtn && 
                !toggleBtn.contains(event.target)) {
                closeSidebar();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (window.innerWidth > 1024) {
                if (sidebar) sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
            }
        });
        
        // Smooth scrolling for navigation links
        document.addEventListener('DOMContentLoaded', function() {
            initSidebarOverlay();
            
            // Add loading states to navigation links
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.href && this.href !== '#') {
                        // Add loading state
                        const icon = this.querySelector('i');
                        if (icon) {
                            const originalClass = icon.className;
                            icon.className = 'fas fa-spinner fa-spin mr-3 w-5';
                            
                            // Restore original icon after navigation
                            setTimeout(() => {
                                icon.className = originalClass;
                            }, 1000);
                        }
                    }
                });
            });
            
            // Initialize tooltips if Bootstrap is available
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });
        
        // Notification management
        function markNotificationAsRead(notificationId) {
            // Implementation for marking notifications as read
            fetch(`/notifications/${notificationId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    // Update notification badge
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        const count = parseInt(badge.textContent) - 1;
                        if (count <= 0) {
                            badge.style.display = 'none';
                        } else {
                            badge.textContent = count;
                        }
                    }
                }
            }).catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
        
        // Theme management (for future dark mode implementation)
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle('dark-theme');
            localStorage.setItem('theme', body.classList.contains('dark-theme') ? 'dark' : 'light');
        }
        
        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-theme');
            }
        });
    </script>
</body>
</html>