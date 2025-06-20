<div class="candidature-details">
    <div class="row">
        <!-- Informations du talent -->
        <div class="col-md-6">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informations du talent</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Nom :</strong></div>
                        <div class="col-sm-8">{{ $candidature->talent->first_name }} {{ $candidature->talent->last_name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Email :</strong></div>
                        <div class="col-sm-8">{{ $candidature->talent->user->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Téléphone :</strong></div>
                        <div class="col-sm-8">{{ $candidature->talent->phone ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Niveau d'étude :</strong></div>
                        <div class="col-sm-8">{{ $candidature->talent->niveau_etude ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4"><strong>Date de candidature :</strong></div>
                        <div class="col-sm-8">{{ $candidature->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statut et actions -->
        <div class="col-md-6">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>Statut et actions</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Statut actuel :</strong></div>
                        <div class="col-sm-8">
                            @switch($candidature->statut_entreprise)
                                @case('candidature_recue')
                                    <span class="badge bg-primary">Candidature reçue</span>
                                    @break
                                @case('preselctionnee')
                                    <span class="badge bg-warning">Présélectionnée</span>
                                    @break
                                @case('entretien')
                                    <span class="badge bg-info">Entretien</span>
                                    @break
                                @case('retenue')
                                    <span class="badge bg-success">Retenue</span>
                                    @break
                                @case('refusee')
                                    <span class="badge bg-danger">Refusée</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $candidature->statut_entreprise }}</span>
                            @endswitch
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Actions rapides :</strong>
                            <div class="btn-group-vertical w-100 mt-2" role="group">
                                @if($candidature->statut_entreprise === 'candidature_recue')
                                    <button type="button" class="btn btn-warning btn-sm mb-1" onclick="updateStatutFromModal({{ $candidature->id }}, 'preselctionnee')">
                                        <i class="fas fa-star me-2"></i>Présélectionner
                                    </button>
                                @endif
                                @if(in_array($candidature->statut_entreprise, ['candidature_recue', 'preselctionnee']))
                                    <button type="button" class="btn btn-info btn-sm mb-1" onclick="updateStatutFromModal({{ $candidature->id }}, 'entretien')">
                                        <i class="fas fa-calendar me-2"></i>Programmer entretien
                                    </button>
                                @endif
                                @if(in_array($candidature->statut_entreprise, ['candidature_recue', 'preselctionnee', 'entretien']))
                                    <button type="button" class="btn btn-success btn-sm mb-1" onclick="updateStatutFromModal({{ $candidature->id }}, 'retenue')">
                                        <i class="fas fa-check me-2"></i>Retenir
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm mb-1" onclick="updateStatutFromModal({{ $candidature->id }}, 'refusee')">
                                        <i class="fas fa-times me-2"></i>Refuser
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Expériences professionnelles -->
    @if($candidature->talent->experiencesProfessionnelles && $candidature->talent->experiencesProfessionnelles->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Expériences professionnelles</h6>
                </div>
                <div class="card-body">
                    @foreach($candidature->talent->experiencesProfessionnelles as $experience)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-1">{{ $experience->poste }}</h6>
                                <p class="mb-1 text-muted">{{ $experience->entreprise }}</p>
                                <small class="text-muted">{{ $experience->duree_mois }} mois</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">{{ $experience->date_debut ? \Carbon\Carbon::parse($experience->date_debut)->format('m/Y') : '' }} - {{ $experience->date_fin ? \Carbon\Carbon::parse($experience->date_fin)->format('m/Y') : 'En cours' }}</small>
                            </div>
                        </div>
                        @if($experience->description)
                        <p class="small mt-2 mb-0">{{ $experience->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formations -->
    @if($candidature->talent->formations && $candidature->talent->formations->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Formations</h6>
                </div>
                <div class="card-body">
                    @foreach($candidature->talent->formations as $formation)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="mb-1">{{ $formation->diplome }}</h6>
                                <p class="mb-1 text-muted">{{ $formation->etablissement }}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">{{ $formation->annee_obtention }}</small>
                            </div>
                        </div>
                        @if($formation->description)
                        <p class="small mt-2 mb-0">{{ $formation->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informations sur l'offre -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Offre concernée</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Titre :</strong></div>
                        <div class="col-sm-9">{{ $candidature->offreEmploi->titre }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Référence :</strong></div>
                        <div class="col-sm-9">{{ $candidature->offreEmploi->reference_offre ?? 'Non assignée' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Famille métier :</strong></div>
                        <div class="col-sm-9">{{ $candidature->offreEmploi->familleMetier->nom ?? 'Non renseignée' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3"><strong>Localisation :</strong></div>
                        <div class="col-sm-9">{{ $candidature->offreEmploi->ville }}, {{ $candidature->offreEmploi->pays }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatutFromModal(candidatureId, nouveauStatut) {
    const messages = {
        'preselctionnee': 'présélectionner cette candidature',
        'entretien': 'programmer un entretien pour cette candidature',
        'retenue': 'retenir cette candidature',
        'refusee': 'refuser cette candidature'
    };
    
    if (confirm(`Êtes-vous sûr de vouloir ${messages[nouveauStatut]} ?`)) {
        fetch(`/entreprise/candidatures/${candidatureId}/statut`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ statut: nouveauStatut })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                // Fermer le modal
                bootstrap.Modal.getInstance(document.getElementById('candidatureModal')).hide();
                // Recharger la page après un délai
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showToast('Une erreur est survenue', 'error');
        });
    }
}
</script>