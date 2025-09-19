@extends('layouts.admin')

@section('title', 'Liste des Administrateurs')
@section('page-title', 'Administrateurs')

@push('styles')
<style>
    .user-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .status-inactive {
        background-color: #fef2f2;
        color: #991b1b;
    }
</style>
@endpush

@section('content')
<div class="p-6">
    <!-- Messages de succès -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Liste des Administrateurs</h1>
        <p class="text-gray-600 mt-2">Gérez les comptes administrateurs de la plateforme</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Administrateurs ({{ $admins->total() }})</h2>
                <a href="{{ route('admin.users.admins.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="bi bi-plus mr-2"></i>Nouvel Admin
                </a>
            </div>
            
            @if($admins->count() > 0)
                <div class="grid gap-4">
                    @foreach($admins as $admin)
                    <div class="user-card">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-person-gear text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $admin->name }}</h3>
                                    <p class="text-gray-600">{{ $admin->email }}</p>
                                    <p class="text-sm text-gray-500">Inscrit le {{ $admin->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="status-badge status-active">
                                    <i class="bi bi-check-circle mr-1"></i>Actif
                                </span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.admins.edit', $admin->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.admins.delete', $admin->id) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $admins->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-people text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun administrateur trouvé</h3>
                    <p class="text-gray-600">Il n'y a actuellement aucun administrateur enregistré.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection