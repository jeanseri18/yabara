<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}