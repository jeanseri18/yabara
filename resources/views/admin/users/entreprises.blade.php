@extends('layouts.admin')

@section('title', 'Liste des Entreprises')
@section('page-title', 'Entreprises')

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
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
</style>
@endpush

@section('content')
<div class="p-6">
    <!-- Messages de succès -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <div class="flex">
                <div class="py-1">
                    <i class="bi bi-check-circle mr-2"></i>
                </div>
                <div>
                    <p class="font-bold">Succès!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Liste des Entreprises</h1>
        <p class="text-gray-600 mt-2">Gérez les comptes entreprises de la plateforme</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Entreprises ({{ $entreprises->total() }})</h2>
                <div class="flex space-x-2">
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="bi bi-download mr-2"></i>Exporter
                    </button>
                    <a href="{{ route('admin.users.entreprises.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="bi bi-plus mr-2"></i>Nouvelle Entreprise
                    </a>
                </div>
            </div>
            
            @if($entreprises->count() > 0)
                <div class="grid gap-4">
                    @foreach($entreprises as $entreprise)
                    <div class="user-card">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-building text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $entreprise->name }}</h3>
                                    <p class="text-gray-600">{{ $entreprise->email }}</p>
                                    @if($entreprise->entreprise)
                                        <p class="text-sm text-gray-500">{{ $entreprise->entreprise->nom_entreprise ?? 'Nom non renseigné' }}</p>
                                        <p class="text-sm text-gray-500">{{ $entreprise->entreprise->secteur_activite ?? 'Secteur non renseigné' }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500">Inscrit le {{ $entreprise->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($entreprise->entreprise && $entreprise->entreprise->statut_validation == 'validé')
                                    <span class="status-badge status-active">
                                        <i class="bi bi-check-circle mr-1"></i>Validé
                                    </span>
                                @elseif($entreprise->entreprise && $entreprise->entreprise->statut_validation == 'en_attente')
                                    <span class="status-badge status-pending">
                                        <i class="bi bi-clock mr-1"></i>En attente
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="bi bi-x-circle mr-1"></i>Non validé
                                    </span>
                                @endif
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800" title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.users.entreprises.edit', $entreprise->id) }}" class="text-green-600 hover:text-green-800" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.entreprises.delete', $entreprise->id) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?')" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
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
                    {{ $entreprises->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-building text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune entreprise trouvée</h3>
                    <p class="text-gray-600">Il n'y a actuellement aucune entreprise enregistrée.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection