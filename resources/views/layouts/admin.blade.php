<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - YABARA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }
        .sidebar-collapsed {
            transform: translateX(-100%);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white text-[#0066FF] sidebar border-r border-gray-200" id="sidebar">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-[#0066FF]">YABARA Admin</h2>
            <button onclick="toggleSidebar()" class="lg:hidden">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <nav class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-speedometer2 mr-3"></i>
                Tableau de bord
            </a>
            <a href="{{ route('admin.users.admins') }}" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-people mr-3"></i>
                Administrateurs
            </a>
            <a href="{{ route('admin.users.entreprises') }}" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-building mr-3"></i>
                Entreprises
            </a>
            <a href="{{ route('admin.users.talents') }}" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-person-badge mr-3"></i>
                Talents
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-briefcase mr-3"></i>
                Offres d'emploi
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-black hover:bg-gray-100 hover:text-black">
                <i class="bi bi-gear mr-3"></i>
                Paramètres
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen">
        @hasSection('full-page')
            @yield('content')
        @else
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
                        <div class="relative">
                            <button class="flex items-center text-gray-700 hover:text-gray-900">
                                @php
                                    $admin = App\Models\Admin::where('user_id', Auth::id())->first();
                                @endphp
                                @if($admin && $admin->avatar)
                                    <img src="{{ asset('storage/avatars/' . $admin->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-gray-300">
                                @else
                                    <i class="bi bi-person-circle text-2xl"></i>
                                @endif
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                                <i class="bi bi-chevron-down ml-1"></i>
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
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
        }
    </script>
</body>
</html>