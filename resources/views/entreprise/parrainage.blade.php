@extends('layouts.entreprise')

@section('title', 'Parrainage Entreprise')

@section('content')
<div class="container-fluid px-3" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- En-tête -->
    <div class="row mb-4 pt-3">
        <div class="col-12">
            <div class="d-flex align-items-center mb-2">
                <a href="{{ route('entreprise.dashboard') }}" class="btn btn-link p-0 me-3" style="color: #666;">
                    <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                </a>
                <div>
                    <h5 class="mb-0" style="color: #333; font-weight: 600;">Parrainage Entreprise</h5>
                    <small class="text-muted">Invitez d'autres entreprises et gagnez des récompenses</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de parrainage -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-white" style="background-color: #0066FF; border-radius: 12px;">
                <div class="card-body text-center p-4">
                    <i class="fas fa-paper-plane mb-3" style="font-size: 2rem;"></i>
                    <div class="fw-bold h4 mb-1">{{ $stats['invitations_envoyees'] }}</div>
                    <small style="font-size: 14px;">Invitations envoyées</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm text-white" style="background-color: #0066FF; border-radius: 12px;">
                <div class="card-body text-center p-4">
                    <i class="fas fa-user-check mb-3" style="font-size: 2rem;"></i>
                    <div class="fw-bold h4 mb-1">{{ $stats['inscriptions_reussies'] }}</div>
                    <small style="font-size: 14px;">Inscriptions réussies</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm" style="background-color: #ff6b35; color: white; border-radius: 12px;">
                <div class="card-body text-center p-4">
                    <i class="fas fa-chart-line mb-3" style="font-size: 2rem;"></i>
                    <div class="fw-bold h4 mb-1">{{ $stats['entreprises_actives'] }}</div>
                    <small style="font-size: 14px;">Entreprises actives</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm" style="background-color: #ff6b35; color: white; border-radius: 12px;">
                <div class="card-body text-center p-4">
                    <i class="fas fa-gift mb-3" style="font-size: 2rem;"></i>
                    <div class="fw-bold h4 mb-1">{{ $stats['recompenses_gagnees'] }}</div>
                    <small style="font-size: 14px;">Récompenses gagnées</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Formulaire d'invitation -->
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-plus-circle me-2" style="color: #ff6b35;"></i>Inviter une entreprise</h6>
                    <form id="invitationForm">
                        @csrf
                        <div class="mb-4">
                            <label for="email_entreprise" class="form-label fw-bold">Email de l'entreprise</label>
                            <input type="email" class="form-control" id="email_entreprise" name="email_entreprise" 
                                   placeholder="contact@entreprise.com" required>
                            <div class="form-text">L'entreprise recevra un email d'invitation avec votre code de parrainage</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="nom_entreprise" class="form-label fw-bold">Nom de l'entreprise (optionnel)</label>
                            <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" 
                                   placeholder="Nom de l'entreprise">
                            <div class="form-text">Pour personnaliser l'invitation</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message_personnel" class="form-label fw-bold">Message personnel (optionnel)</label>
                            <textarea class="form-control" id="message_personnel" name="message_personnel" 
                                      rows="3" placeholder="Ajoutez un message personnel à votre invitation..."></textarea>
                            <div class="form-text">Maximum 500 caractères</div>
                        </div>
                        
                        <!-- Aperçu du code de parrainage -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Votre code de parrainage :</strong>
                                    <code class="ms-2">{{ $code_parrainage }}</code>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-2" 
                                            onclick="copyToClipboard('{{ $code_parrainage }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer l'invitation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Programme de récompenses -->
        <div class="col-lg-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="color: #333; font-weight: 600;"><i class="fas fa-trophy me-2" style="color: #ff6b35;"></i>Programme de récompenses</h6>
                    <div class="reward-levels">
                        <div class="mb-3 p-3 {{ $stats['inscriptions_reussies'] >= 1 ? 'bg-light border-success' : 'bg-light' }}" style="border: 1px solid #e9ecef; border-radius: 12px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="fas fa-medal" style="color: #cd7f32; font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold" style="color: #333;">Bronze</h6>
                                    <small class="text-muted" style="font-size: 14px;">1 entreprise inscrite</small>
                                </div>
                                @if($stats['inscriptions_reussies'] >= 1)
                                    <i class="fas fa-check-circle text-success"></i>
                                @endif
                            </div>
                            <div class="reward-benefits">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>+500 points de fidélité</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Badge "Ambassadeur Bronze"</li>
                                    <li><i class="fas fa-check text-success me-2"></i>5% de réduction sur les services</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-3 p-3 {{ $stats['inscriptions_reussies'] >= 3 ? 'bg-light border-success' : 'bg-light' }}" style="border: 1px solid #e9ecef; border-radius: 12px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="fas fa-medal" style="color: #c0c0c0; font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold" style="color: #333;">Argent</h6>
                                    <small class="text-muted" style="font-size: 14px;">3 entreprises inscrites</small>
                                </div>
                                @if($stats['inscriptions_reussies'] >= 3)
                                    <i class="fas fa-check-circle text-success"></i>
                                @endif
                            </div>
                            <div class="reward-benefits">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>+1500 points de fidélité</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Badge "Ambassadeur Argent"</li>
                                    <li><i class="fas fa-check text-success me-2"></i>10% de réduction sur les services</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Accès prioritaire aux nouveautés</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mb-3 p-3 {{ $stats['inscriptions_reussies'] >= 5 ? 'bg-light border-success' : 'bg-light' }}" style="border: 1px solid #e9ecef; border-radius: 12px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="fas fa-crown" style="color: #ffd700; font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold" style="color: #333;">Or</h6>
                                    <small class="text-muted" style="font-size: 14px;">5 entreprises inscrites</small>
                                </div>
                                @if($stats['inscriptions_reussies'] >= 5)
                                    <i class="fas fa-check-circle text-success"></i>
                                @endif
                            </div>
                            <div class="reward-benefits">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>+3000 points de fidélité</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Badge "Ambassadeur Or"</li>
                                    <li><i class="fas fa-check text-success me-2"></i>15% de réduction sur les services</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Support client prioritaire</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Consultation gratuite RH</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Historique des parrainages -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="mb-0" style="color: #333; font-weight: 600;"><i class="fas fa-history me-2" style="color: #ff6b35;"></i>Historique des parrainages</h6>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="status-filter" id="all-status" value="all" checked>
                            <label class="btn btn-outline-secondary btn-sm" for="all-status" style="border-radius: 6px 0 0 6px;">Tous</label>
                            
                            <input type="radio" class="btn-check" name="status-filter" id="pending-status" value="en_attente">
                            <label class="btn btn-outline-secondary btn-sm" for="pending-status">En attente</label>
                            
                            <input type="radio" class="btn-check" name="status-filter" id="accepted-status" value="accepte">
                            <label class="btn btn-outline-secondary btn-sm" for="accepted-status">Acceptés</label>
                            
                            <input type="radio" class="btn-check" name="status-filter" id="active-status" value="actif">
                            <label class="btn btn-outline-secondary btn-sm" for="active-status" style="border-radius: 0 6px 6px 0;">Actifs</label>
                        </div>
                    </div>
                     <div class="table-responsive" style="border-radius: 8px; overflow: hidden;">
                         <table class="table table-hover mb-0">
                             <thead class="table-light">
                                 <tr>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Entreprise</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Email</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Date d'invitation</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Statut</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Date d'inscription</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Activité</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Récompense</th>
                                     <th style="border: none; font-weight: 600; color: #333; padding: 16px;">Actions</th>
                                 </tr>
                             </thead>
                            <tbody id="parrainages-table">
                                @foreach($parrainages as $parrainage)
                                    <tr class="parrainage-row" data-status="{{ $parrainage->statut }}" style="border-bottom: 1px solid #f1f3f4;">
                                        <td style="padding: 16px; border: none;">
                                            <div class="d-flex align-items-center">
                                                <div class="company-avatar me-3">
                                                    @if($parrainage->entreprise_parrainee && $parrainage->entreprise_parrainee->logo)
                                                        <img src="{{ $parrainage->entreprise_parrainee->logo }}" 
                                                             alt="Logo" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                                    @else
                                                        <div class="text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                            <i class="fas fa-building"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="color: #333; font-size: 14px;">{{ $parrainage->nom_entreprise ?: 'Non spécifié' }}</div>
                                                    <small class="text-muted" style="font-size: 12px;">Code: {{ $parrainage->code_parrainage }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 16px; border: none; color: #666; font-size: 14px;">{{ $parrainage->email_entreprise }}</td>
                                        <td style="padding: 16px; border: none; color: #666; font-size: 14px;">{{ $parrainage->created_at->format('d/m/Y H:i') }}</td>
                                        <td style="padding: 16px; border: none;">
                                            <span class="badge" style="background-color: {{ $parrainage->statut === 'en_attente' ? '#ffc107' : ($parrainage->statut === 'accepte' ? '#28a745' : '#17a2b8') }}; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px;">
                                                {{ ucfirst(str_replace('_', ' ', $parrainage->statut)) }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px; border: none; color: #666; font-size: 14px;">
                                            @if($parrainage->date_inscription)
                                                {{ $parrainage->date_inscription->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px; border: none;">
                                            @if($parrainage->entreprise_parrainee)
                                                <span class="badge" style="background-color: {{ $parrainage->entreprise_parrainee->is_active ? '#28a745' : '#6c757d' }}; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px;">
                                                    {{ $parrainage->entreprise_parrainee->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px; border: none;">
                                            @if($parrainage->recompense_accordee)
                                                <span class="text-success fw-bold" style="font-size: 14px;">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ $parrainage->montant_recompense }}€
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-size: 14px;">En attente</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px; border: none;">
                                            <div class="btn-group btn-group-sm">
                                                @if($parrainage->statut === 'en_attente')
                                                    <button class="btn btn-outline-secondary btn-sm" style="border-radius: 6px; margin-right: 4px;" 
                                                            onclick="resendInvitation({{ $parrainage->id }})">
                                                        <i class="fas fa-redo"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;" 
                                                        onclick="viewDetails({{ $parrainage->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($parrainages->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun parrainage pour le moment</h5>
                            <p class="text-muted">Commencez à inviter des entreprises pour gagner des récompenses !</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de détails -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle text-primary me-2"></i>Détails du parrainage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="details-content">
                <!-- Contenu chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd, #6610f2);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.reward-level {
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

.reward-level.achieved {
    border-color: #28a745;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e8 100%);
}

.reward-level:not(.achieved) {
    opacity: 0.7;
}

.reward-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.bg-bronze {
    background: linear-gradient(135deg, #cd7f32, #b8860b);
}

.bg-silver {
    background: linear-gradient(135deg, #c0c0c0, #a8a8a8);
}

.bg-gold {
    background: linear-gradient(135deg, #ffd700, #ffb347);
}

.reward-benefits {
    background: rgba(255,255,255,0.8);
    border-radius: 8px;
    padding: 1rem;
}

.reward-benefits ul li {
    padding: 0.25rem 0;
    font-size: 0.875rem;
}

.company-avatar img {
    object-fit: cover;
}

.activity-indicator {
    display: flex;
    align-items: center;
}

.parrainage-row {
    transition: all 0.3s ease;
}

.parrainage-row.hidden {
    display: none;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .reward-level {
        padding: 1rem;
    }
    
    .reward-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Soumission du formulaire d'invitation
    $('#invitationForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...');
        
        $.post('{{ route("entreprise.parrainage.invite") }}', $(this).serialize())
            .done(function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    $('#invitationForm')[0].reset();
                    
                    // Recharger la page après 2 secondes pour voir la nouvelle invitation
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            })
            .fail(function(xhr) {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.values(errors).forEach(function(errorArray) {
                        errorArray.forEach(function(error) {
                            showToast(error, 'error');
                        });
                    });
                } else {
                    showToast('Erreur lors de l\'envoi de l\'invitation', 'error');
                }
            })
            .always(function() {
                submitBtn.prop('disabled', false).html(originalText);
            });
    });
    
    // Filtrage par statut
    $('input[name="status-filter"]').on('change', function() {
        const selectedStatus = $(this).val();
        
        $('.parrainage-row').each(function() {
            const rowStatus = $(this).data('status');
            
            if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                $(this).removeClass('hidden').show();
            } else {
                $(this).addClass('hidden').hide();
            }
        });
    });
    
    // Compteur de caractères pour le message personnel
    $('#message_personnel').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        let counterElement = $(this).siblings('.char-counter');
        if (counterElement.length === 0) {
            counterElement = $('<div class="char-counter text-muted small mt-1"></div>');
            $(this).after(counterElement);
        }
        
        counterElement.text(`${currentLength}/${maxLength} caractères`);
        
        if (remaining < 50) {
            counterElement.removeClass('text-muted').addClass('text-warning');
        } else {
            counterElement.removeClass('text-warning').addClass('text-muted');
        }
        
        if (remaining < 0) {
            counterElement.removeClass('text-warning').addClass('text-danger');
            $(this).addClass('is-invalid');
        } else {
            counterElement.removeClass('text-danger');
            $(this).removeClass('is-invalid');
        }
    });
});

// Fonctions globales
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('Code copié dans le presse-papiers !', 'success');
    }).catch(function() {
        // Fallback pour les navigateurs plus anciens
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('Code copié dans le presse-papiers !', 'success');
    });
}

function resendInvitation(parrainageId) {
    if (confirm('Êtes-vous sûr de vouloir renvoyer cette invitation ?')) {
        $.post(`{{ route('entreprise.parrainage.resend', ':id') }}`.replace(':id', parrainageId), {
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            if (response.success) {
                showToast(response.message, 'success');
            }
        })
        .fail(function() {
            showToast('Erreur lors du renvoi de l\'invitation', 'error');
        });
    }
}

function viewDetails(parrainageId) {
    $('#details-content').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2">Chargement des détails...</p>
        </div>
    `);
    
    $('#detailsModal').modal('show');
    
    $.get(`{{ route('entreprise.parrainage.details', ':id') }}`.replace(':id', parrainageId))
        .done(function(response) {
            $('#details-content').html(response.html);
        })
        .fail(function() {
            $('#details-content').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Erreur lors du chargement des détails
                </div>
            `);
        });
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
</script>
@endpush