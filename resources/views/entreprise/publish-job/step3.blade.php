@extends('layouts.entreprise')

@section('title', 'Publier une offre - Étape 3/3')

@section('content')
<div class="container-fluid px-4">
    <!-- Indicateur de progression -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="progress-steps">
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-title">Informations générales</div>
                </div>
                <div class="step completed">
                    <div class="step-number"><i class="fas fa-check"></i></div>
                    <div class="step-title">Spécificités du poste</div>
                </div>
                <div class="step active">
                    <div class="step-number">3</div>
                    <div class="step-title">Résumé & Publication</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Prévisualisation de l'offre -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-eye text-primary me-2"></i>Prévisualisation de votre offre</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Aperçu de l'offre -->
                    <div class="job-preview">
                        <!-- En-tête de l'offre -->
                        <div class="preview-header p-4 bg-gradient-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    @if($offre->entreprise->logo_url)
                                        <img src="{{ $offre->entreprise->logo_url }}" alt="Logo" class="rounded-circle bg-white p-2" width="60" height="60">
                                    @else
                                        <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-building fa-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <h4 class="mb-1">{{ $offre->titre }}</h4>
                                    <p class="mb-0"><i class="fas fa-building me-2"></i>{{ $offre->entreprise->nom_entreprise }}</p>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-white text-primary fs-6">{{ $offre->typeContrat->nom }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Détails de l'offre -->
                        <div class="preview-content p-4">
                            <!-- Informations clés -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <strong>Lieu:</strong> {{ $offre->lieu_poste }}
                                    </div>
                                    <div class="info-item mb-3">
                                        <i class="fas fa-briefcase text-primary me-2"></i>
                                        <strong>Domaine:</strong> {{ $offre->familleMetier->nom }}
                                    </div>
                                    <div class="info-item mb-3">
                                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                                        <strong>Diplôme:</strong> {{ $offre->niveauDiplome->nom }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <strong>Expérience:</strong> 
                                        @if($offre->experience_minimum == 0)
                                            Débutant accepté
                                        @else
                                            {{ $offre->experience_minimum }}+ ans
                                        @endif
                                    </div>
                                    @if($offre->remuneration)
                                    <div class="info-item mb-3">
                                        <i class="fas fa-money-bill-wave text-primary me-2"></i>
                                        <strong>Salaire:</strong> {{ number_format($offre->remuneration, 0, ',', ' ') }} FCFA/mois
                                    </div>
                                    @endif
                                    <div class="info-item mb-3">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <strong>Type:</strong> {{ $offre->typeContrat->nom }}
                                    </div>
                                </div>
                            </div>

                            <!-- Options de travail -->
                            @if($offre->teletravail || $offre->mobilite_requise)
                            <div class="work-options mb-4">
                                <h6 class="fw-bold mb-3">Options de travail</h6>
                                <div class="d-flex gap-3">
                                    @if($offre->teletravail)
                                    <span class="badge bg-success-subtle text-success border border-success">
                                        <i class="fas fa-home me-1"></i>Télétravail possible
                                    </span>
                                    @endif
                                    @if($offre->mobilite_requise)
                                    <span class="badge bg-warning-subtle text-warning border border-warning">
                                        <i class="fas fa-plane me-1"></i>Mobilité requise
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Description -->
                            <div class="job-description">
                                <h6 class="fw-bold mb-3">Description du poste</h6>
                                <div class="description-content">
                                    {!! nl2br(e($offre->descriptif)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions de publication -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-rocket text-primary me-2"></i>Publication</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Référence de l'offre -->
                    <div class="reference-section mb-4">
                        <label class="form-label fw-bold">Référence de l'offre</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">YB</span>
                            <input type="text" class="form-control" id="reference-display" value="{{ $offre->reference_offre ?? '-----' }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="generateRef" 
                                    {{ $offre->reference_offre ? 'disabled' : '' }}>
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="form-text">Référence unique générée automatiquement</div>
                    </div>

                    <!-- Statut actuel -->
                    <div class="status-section mb-4">
                        <label class="form-label fw-bold">Statut actuel</label>
                        <div class="status-badge">
                            @if($offre->statut === 'publiee')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Publiée
                                </span>
                            @else
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-edit me-1"></i>Brouillon
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="action-buttons">
                        @if($offre->statut !== 'publiee')
                        <button type="button" class="btn btn-success btn-lg w-100 mb-3" id="publishBtn">
                            <i class="fas fa-rocket me-2"></i>Publier l'offre
                        </button>
                        @endif
                        
                        <button type="button" class="btn btn-outline-primary w-100 mb-3" id="saveDraftBtn">
                            <i class="fas fa-save me-2"></i>Sauvegarder en brouillon
                        </button>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('entreprise.offres.publier.step2', $offre->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Modifier
                            </a>
                            <a href="{{ route('entreprise.dashboard') }}" class="btn btn-outline-dark">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="info-section mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Après publication</h6>
                        <ul class="list-unstyled small text-muted">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Votre offre sera visible par tous les talents</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Vous recevrez les candidatures dans votre tableau de bord</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Badge "Recruteur actif" débloqué</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="publishModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fas fa-rocket text-primary me-2"></i>Publier l'offre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="mb-4">
                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                    <h6>Êtes-vous prêt à publier cette offre ?</h6>
                    <p class="text-muted">Une fois publiée, votre offre sera visible par tous les talents de la plateforme.</p>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" id="confirmPublish">
                    <i class="fas fa-rocket me-2"></i>Publier maintenant
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de succès -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-animation mb-4">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <h4 class="text-success mb-3">🎉 Félicitations !</h4>
                <p class="mb-4">Votre offre a été publiée avec succès !</p>
                <div class="badge-notification mb-4">
                    <span class="badge bg-primary fs-6">
                        <i class="fas fa-award me-2"></i>Badge "Recruteur actif" débloqué
                    </span>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('entreprise.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Aller au dashboard
                    </a>
                    <a href="{{ route('entreprise.offres.publier.step1') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Publier une nouvelle offre
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.progress-steps {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 2rem;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    max-width: 200px;
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    left: 60%;
    width: 100%;
    height: 2px;
    background: #dee2e6;
    z-index: 1;
}

.step.active:not(:last-child)::after,
.step.completed:not(:last-child)::after {
    background: #0d6efd;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #dee2e6;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.step.active .step-number {
    background: #0d6efd;
    color: white;
}

.step.completed .step-number {
    background: #198754;
    color: white;
}

.step-title {
    font-size: 0.875rem;
    text-align: center;
    color: #6c757d;
}

.step.active .step-title,
.step.completed .step-title {
    color: #0d6efd;
    font-weight: 600;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
}

.job-preview {
    border-radius: 8px;
    overflow: hidden;
}

.preview-header {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
}

.info-item {
    display: flex;
    align-items: center;
}

.description-content {
    line-height: 1.6;
    color: #495057;
}

.reference-section .input-group-text {
    font-weight: bold;
}

.status-badge .badge {
    padding: 8px 12px;
}

.success-animation {
    animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.badge-notification {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Confetti animation */
.confetti {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 9999;
}

.confetti-piece {
    position: absolute;
    width: 10px;
    height: 10px;
    background: #f39c12;
    animation: confetti-fall 3s linear infinite;
}

@keyframes confetti-fall {
    0% {
        transform: translateY(-100vh) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Génération de référence
    $('#generateRef').on('click', function() {
        const randomRef = Math.random().toString(36).substring(2, 7).toUpperCase();
        $('#reference-display').val(randomRef);
    });
    
    // Publication de l'offre
    $('#publishBtn').on('click', function() {
        $('#publishModal').modal('show');
    });
    
    $('#confirmPublish').on('click', function() {
        publishJob('publier');
    });
    
    // Sauvegarde en brouillon
    $('#saveDraftBtn').on('click', function() {
        publishJob('brouillon');
    });
    
    function publishJob(action) {
        const btn = action === 'publier' ? $('#confirmPublish') : $('#saveDraftBtn');
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Traitement...');
        
        $.post('{{ route("entreprise.offres.publish", $offre->id) }}', {
            _token: '{{ csrf_token() }}',
            action: action
        })
        .done(function(response) {
            if (response.success) {
                if (action === 'publier') {
                    $('#publishModal').modal('hide');
                    showConfetti();
                    setTimeout(function() {
                        $('#successModal').modal('show');
                    }, 500);
                } else {
                    // Notification de sauvegarde
                    showToast('Offre sauvegardée en brouillon', 'success');
                }
            }
        })
        .fail(function(xhr) {
            showToast('Erreur lors de la publication', 'error');
        })
        .always(function() {
            btn.prop('disabled', false).html(originalText);
        });
    }
    
    function showConfetti() {
        const confettiContainer = $('<div class="confetti"></div>');
        $('body').append(confettiContainer);
        
        const colors = ['#f39c12', '#e74c3c', '#3498db', '#2ecc71', '#9b59b6', '#f1c40f'];
        
        for (let i = 0; i < 50; i++) {
            const confettiPiece = $('<div class="confetti-piece"></div>');
            confettiPiece.css({
                left: Math.random() * 100 + '%',
                backgroundColor: colors[Math.floor(Math.random() * colors.length)],
                animationDelay: Math.random() * 3 + 's',
                animationDuration: (Math.random() * 3 + 2) + 's'
            });
            confettiContainer.append(confettiPiece);
        }
        
        setTimeout(function() {
            confettiContainer.remove();
        }, 5000);
    }
    
    function showToast(message, type) {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastContainer = $('.toast-container');
        if (toastContainer.length === 0) {
            $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }
        
        const toast = $(toastHtml);
        $('.toast-container').append(toast);
        
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        
        toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
});
</script>
@endpush