<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Entreprise Dashboard') - YABARA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }
        .sidebar-collapsed {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-[#152747] text-white sidebar" id="sidebar">
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <h2 class="text-xl font-bold text-[#f6cd45]">YABARA</h2>
            <button onclick="toggleSidebar()" class="lg:hidden">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="mt-8">
            <a href="{{ route('entreprise.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-speedometer2 mr-3"></i>
                Tableau de bord
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-building mr-3"></i>
                Profil entreprise
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-briefcase mr-3"></i>
                Mes offres
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-plus-circle mr-3"></i>
                Publier une offre
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-people mr-3"></i>
                Base de talents
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-envelope mr-3"></i>
                Candidatures reçues
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-300 hover:bg-[#f6cd45]/20 hover:text-white border-r-2 border-transparent hover:border-[#f6cd45]">
                <i class="bi bi-chat-dots mr-3"></i>
                Messages
            </a>
        </nav>
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
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>
</html>