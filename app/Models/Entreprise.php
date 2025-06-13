<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprises';

    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'logo_url',
        'pole_activite_id',
        'numero_legal',
        'effectif',
        'responsable_rh_nom',
        'responsable_rh_prenom',
        'is_verified',
        'total_offres_publiees',
        'total_candidatures_recues',
        'notif_nouvelle_candidature',
        'notif_deplacement_kanban'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'total_offres_publiees' => 'integer',
        'total_candidatures_recues' => 'integer',
        'notif_nouvelle_candidature' => 'boolean',
        'notif_deplacement_kanban' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poleActivite()
    {
        return $this->belongsTo(Pole::class, 'pole_activite_id');
    }

    public function pole()
    {
        return $this->belongsTo(Pole::class, 'pole_activite_id');
    }

    public function getResponsableRhFullNameAttribute()
    {
        if ($this->responsable_rh_prenom && $this->responsable_rh_nom) {
            return $this->responsable_rh_prenom . ' ' . $this->responsable_rh_nom;
        }
        return $this->responsable_rh_nom;
    }
    
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class, 'entreprise_parrain_id');
    }
    
    public function parrainagesReussis()
    {
        return $this->hasMany(Parrainage::class, 'entreprise_parrain_id')
                    ->where('recompense_accordee', true);
    }
    
    public function offresEmploi()
    {
        return $this->hasMany(OffreEmploi::class);
    }
    
    public function candidatures()
    {
        return $this->hasManyThrough(Candidature::class, OffreEmploi::class, 'entreprise_id', 'offre_emploi_id', 'id', 'id');
    }
    
    public function badges()
    {
        return $this->hasMany(UserBadge::class, 'user_id', 'user_id');
    }
    
    public function parrainagesRecus()
    {
        return $this->hasMany(Parrainage::class, 'entreprise_parrainee_id');
    }
}