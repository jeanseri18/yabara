<div class="parrainage-details">
    <div class="row">
        <!-- Informations générales -->
        <div class="col-md-6">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5"><strong>Code de parrainage :</strong></div>
                        <div class="col-sm-7">
                            <code>{{ $parrainage->code_parrainage }}</code>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-2" 
                                    onclick="copyToClipboard('{{ $parrainage->code_parrainage }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5"><strong>Email invité :</strong></div>
                        <div class="col-sm-7">{{ $parrainage->email_entreprise }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5"><strong>Nom entreprise :</strong></div>
                        <div class="col-sm-7">{{ $parrainage->nom_entreprise ?: 'Non spécifié' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5"><strong>Statut :</strong></div>
                        <div class="col-sm-7">
                            <span class="badge bg-{{ $parrainage->statut_badge['class'] }}">
                                {{ $parrainage->statut_badge['text'] }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5"><strong>Date d'invitation :</strong></div>
                        <div class="col-sm-7">{{ $parrainage->date_invitation->format('d/m/Y à H:i') }}</div>
                    </div>
                    @if($parrainage->date_inscription)
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Date d'inscription :</strong></div>
                            <div class="col-sm-7">{{ $parrainage->date_inscription->format('d/m/Y à H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Informations sur la récompense -->
        <div class="col-md-6">
            <div class="card border-0 bg-light mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-gift me-2"></i>Récompense</h6>
                </div>
                <div class="card-body">
                    @if($parrainage->recompense_accordee)
                        <div class="text-center mb-3">
                            <div class="reward-amount text-success">
                                <i class="fas fa-trophy fa-2x mb-2"></i>
                                <h4 class="mb-0">{{ number_format($parrainage->montant_recompense, 0, ',', ' ') }}€</h4>
                                <small class="text-muted">Récompense accordée</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-5"><strong>Date d'attribution :</strong></div>
                            <div class="col-sm-7">{{ $parrainage->date_recompense->format('d/m/Y') }}</div>
                        </div>
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            Récompense créditée sur votre compte
                        </div>
                    @else
                        <div class="text-center mb-3">
                            <div class="reward-pending text-warning">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <h5 class="mb-0">En attente</h5>
                                <small class="text-muted">Récompense en cours de traitement</small>
                            </div>
                        </div>
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            La récompense sera accordée une fois l'entreprise active sur la plateforme
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Message personnel -->
    @if($parrainage->message_personnel)
        <div class="card border-0 bg-light mb-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-comment me-2"></i>Message personnel</h6>
            </div>
            <div class="card-body">
                <div class="message-content">
                    {{ $parrainage->message_personnel }}
                </div>
            </div>
        </div>
    @endif
    
    <!-- Informations sur l'entreprise parrainée -->
    @if($parrainage->entrepriseParrainee)
        <div class="card border-0 bg-light mb-3">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Entreprise parrainée</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        @if($parrainage->entrepriseParrainee->logo)
                            <img src="{{ $parrainage->entrepriseParrainee->logo }}" 
                                 alt="Logo" class="img-fluid rounded mb-2" style="max-height: 80px;">
                        @else
                            <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mb-2" 
                                 style="height: 80px;">
                                <i class="fas fa-building fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h5 class="mb-2">{{ $parrainage->entrepriseParrainee->nom_entreprise }}</h5>
                        <div class="row mb-1">
                            <div class="col-sm-4"><strong>RCCM :</strong></div>
                            <div class="col-sm-8">{{ $parrainage->entrepriseParrainee->rccm ?: 'Non renseigné' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4"><strong>Effectif :</strong></div>
                            <div class="col-sm-8">{{ $parrainage->entrepriseParrainee->effectif ?: 'Non renseigné' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4"><strong>Secteur :</strong></div>
                            <div class="col-sm-8">{{ $parrainage->entrepriseParrainee->poleActivite->nom ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4"><strong>Inscription :</strong></div>
                            <div class="col-sm-8">{{ $parrainage->entrepriseParrainee->created_at->format('d/m/Y') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"><strong>Statut :</strong></div>
                            <div class="col-sm-8">
                                <span class="badge bg-{{ $parrainage->entrepriseParrainee->is_active ? 'success' : 'secondary' }}">
                                    {{ $parrainage->entrepriseParrainee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Statistiques d'activité -->
    @if($parrainage->entrepriseParrainee)
        <div class="card border-0 bg-light">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Activité de l'entreprise</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h4 class="text-primary mb-1">{{ $parrainage->entrepriseParrainee->total_offres_publiees ?? 0 }}</h4>
                            <small class="text-muted">Offres publiées</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h4 class="text-success mb-1">{{ $parrainage->entrepriseParrainee->total_recrutements_finalises ?? 0 }}</h4>
                            <small class="text-muted">Recrutements</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h4 class="text-info mb-1">{{ $parrainage->entrepriseParrainee->total_parrainages_reussis ?? 0 }}</h4>
                            <small class="text-muted">Parrainages</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-item">
                            <h4 class="text-warning mb-1">
                                {{ $parrainage->entrepriseParrainee->created_at->diffInDays(now()) }}
                            </h4>
                            <small class="text-muted">Jours d'activité</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Actions disponibles -->
    @if($parrainage->statut === 'en_attente' && $parrainage->peutEtreRenvoye())
        <div class="mt-3 text-center">
            <button type="button" class="btn btn-primary" 
                    onclick="resendInvitation({{ $parrainage->id }})">
                <i class="fas fa-redo me-2"></i>Renvoyer l'invitation
            </button>
        </div>
    @endif
</div>

<style>
.parrainage-details .card {
    transition: all 0.3s ease;
}

.parrainage-details .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.reward-amount, .reward-pending {
    padding: 1rem;
    border-radius: 10px;
    background: rgba(255,255,255,0.8);
}

.stat-item {
    padding: 0.5rem;
}

.message-content {
    background: rgba(255,255,255,0.8);
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #17a2b8;
    font-style: italic;
}

@media (max-width: 768px) {
    .parrainage-details .row .col-sm-5,
    .parrainage-details .row .col-sm-7,
    .parrainage-details .row .col-sm-4,
    .parrainage-details .row .col-sm-8 {
        margin-bottom: 0.5rem;
    }
    
    .stat-item {
        margin-bottom: 1rem;
    }
}
</style>