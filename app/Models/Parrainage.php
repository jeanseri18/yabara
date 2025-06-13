<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Parrainage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parrainages';

    protected $fillable = [
        'entreprise_parrain_id',
        'talent_parrain_id',
        'email_entreprise',
        'nom_entreprise',
        'message_personnel',
        'code_parrainage',
        'statut',
        'date_invitation',
        'date_inscription',
        'entreprise_parrainee_id',
        'talent_parraine_id',
        'recompense_accordee',
        'montant_recompense',
        'date_recompense',
        'parrain_type',
        'ip_invitation',
        'user_agent_invitation'
    ];

    protected $casts = [
        'date_invitation' => 'datetime',
        'date_inscription' => 'datetime',
        'date_recompense' => 'datetime',
        'recompense_accordee' => 'boolean',
        'montant_recompense' => 'decimal:2'
    ];

    protected $dates = [
        'date_invitation',
        'date_inscription',
        'date_recompense',
        'deleted_at'
    ];

    // Relations
    public function entrepriseParrain()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_parrain_id');
    }

    public function talentParrain()
    {
        return $this->belongsTo(Talent::class, 'talent_parrain_id');
    }

    public function entrepriseParrainee()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_parrainee_id');
    }

    public function talentParraine()
    {
        return $this->belongsTo(Talent::class, 'talent_parraine_id');
    }

    // Scopes
    public function scopeParEntreprise($query, $entrepriseId)
    {
        return $query->where('entreprise_parrain_id', $entrepriseId);
    }

    public function scopeParTalent($query, $talentId)
    {
        return $query->where('talent_parrain_id', $talentId);
    }

    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('parrain_type', $type);
    }

    public function scopeRecompenseAccordee($query)
    {
        return $query->where('recompense_accordee', true);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAccepte($query)
    {
        return $query->where('statut', 'accepte');
    }

    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    // Méthodes
    public static function genererCodeParrainage($type = 'entreprise', $id = null)
    {
        $prefix = $type === 'entreprise' ? 'ENT' : 'TAL';
        $code = $prefix . strtoupper(Str::random(6));
        
        // Vérifier l'unicité
        while (self::where('code_parrainage', $code)->exists()) {
            $code = $prefix . strtoupper(Str::random(6));
        }
        
        return $code;
    }

    public function marquerCommeAccepte($entrepriseId = null, $talentId = null)
    {
        $this->update([
            'statut' => 'accepte',
            'date_inscription' => now(),
            'entreprise_parrainee_id' => $entrepriseId,
            'talent_parraine_id' => $talentId
        ]);

        return $this;
    }

    public function marquerCommeActif()
    {
        $this->update([
            'statut' => 'actif'
        ]);

        // Accorder la récompense si pas encore fait
        if (!$this->recompense_accordee) {
            $this->accorderRecompense();
        }

        return $this;
    }

    public function accorderRecompense()
    {
        $montant = $this->calculerMontantRecompense();
        
        $this->update([
            'recompense_accordee' => true,
            'montant_recompense' => $montant,
            'date_recompense' => now()
        ]);

        // Mettre à jour les statistiques du parrain
        if ($this->parrain_type === 'entreprise' && $this->entrepriseParrain) {
            $this->entrepriseParrain->increment('total_parrainages_reussis');
            $this->entrepriseParrain->increment('points_fidelite', $montant * 10); // 10 points par euro
        } elseif ($this->parrain_type === 'talent' && $this->talentParrain) {
            $this->talentParrain->increment('total_parrainages_reussis');
            $this->talentParrain->increment('points_fidelite', $montant * 10);
        }

        return $this;
    }

    private function calculerMontantRecompense()
    {
        // Calcul basé sur le type de parrain et le niveau
        $montantBase = 50; // 50€ de base
        
        if ($this->parrain_type === 'entreprise' && $this->entrepriseParrain) {
            $nbParrainages = $this->entrepriseParrain->parrainagesReussis()->count();
            
            // Bonus progressif
            if ($nbParrainages >= 5) {
                $montantBase = 100; // Niveau Or
            } elseif ($nbParrainages >= 3) {
                $montantBase = 75;  // Niveau Argent
            } elseif ($nbParrainages >= 1) {
                $montantBase = 60;  // Niveau Bronze
            }
        }
        
        return $montantBase;
    }

    public function getStatutBadgeAttribute()
    {
        $badges = [
            'en_attente' => ['class' => 'warning', 'text' => 'En attente'],
            'accepte' => ['class' => 'success', 'text' => 'Accepté'],
            'actif' => ['class' => 'info', 'text' => 'Actif'],
            'expire' => ['class' => 'secondary', 'text' => 'Expiré'],
            'refuse' => ['class' => 'danger', 'text' => 'Refusé']
        ];

        return $badges[$this->statut] ?? ['class' => 'secondary', 'text' => 'Inconnu'];
    }

    public function getParrainNomAttribute()
    {
        if ($this->parrain_type === 'entreprise' && $this->entrepriseParrain) {
            return $this->entrepriseParrain->nom_entreprise;
        } elseif ($this->parrain_type === 'talent' && $this->talentParrain) {
            return $this->talentParrain->user->prenom . ' ' . $this->talentParrain->user->nom;
        }
        
        return 'Parrain inconnu';
    }

    public function getParraineeNomAttribute()
    {
        if ($this->entreprise_parrainee_id && $this->entrepriseParrainee) {
            return $this->entrepriseParrainee->nom_entreprise;
        } elseif ($this->talent_parraine_id && $this->talentParraine) {
            return $this->talentParraine->user->prenom . ' ' . $this->talentParraine->user->nom;
        }
        
        return $this->nom_entreprise ?: 'Non spécifié';
    }

    public function estExpire()
    {
        // Un parrainage expire après 30 jours s'il n'est pas accepté
        if ($this->statut === 'en_attente') {
            return $this->date_invitation->addDays(30)->isPast();
        }
        
        return false;
    }

    public function peutEtreRenvoye()
    {
        return $this->statut === 'en_attente' && !$this->estExpire();
    }

    // Boot method pour les événements
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($parrainage) {
            if (empty($parrainage->code_parrainage)) {
                $parrainage->code_parrainage = self::genererCodeParrainage(
                    $parrainage->parrain_type,
                    $parrainage->entreprise_parrain_id ?: $parrainage->talent_parrain_id
                );
            }
            
            if (empty($parrainage->date_invitation)) {
                $parrainage->date_invitation = now();
            }
            
            if (empty($parrainage->statut)) {
                $parrainage->statut = 'en_attente';
            }
        });

        static::updating(function ($parrainage) {
            // Vérifier si le statut change vers 'actif'
            if ($parrainage->isDirty('statut') && $parrainage->statut === 'actif') {
                // Déclencher les actions de récompense
                $parrainage->accorderRecompense();
            }
        });
    }
}