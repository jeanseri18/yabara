<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $table = 'candidatures';

    protected $fillable = [
        'talent_id',
        'offre_emploi_id',
        'type',
        'statut_entreprise',
        'statut_talent',
        'date_candidature',
        'date_derniere_modification',
        'notes_entreprise',
        'score_matching'
    ];

    protected $casts = [
        'date_candidature' => 'datetime',
        'date_derniere_modification' => 'datetime',
        'score_matching' => 'decimal:2'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function offreEmploi()
    {
        return $this->belongsTo(OffreEmploi::class);
    }

    public function scopeParStatutEntreprise($query, $statut)
    {
        return $query->where('statut_entreprise', $statut);
    }

    public function scopeParStatutTalent($query, $statut)
    {
        return $query->where('statut_talent', $statut);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Méthodes pour les transitions de statut
    public function preselectioner()
    {
        $this->update([
            'statut_entreprise' => 'preselctionnee',
            'statut_talent' => 'validee_entreprise',
            'date_derniere_modification' => now()
        ]);
    }

    public function programmerEntretien()
    {
        $this->update([
            'statut_entreprise' => 'entretien',
            'statut_talent' => 'entretien_cours',
            'date_derniere_modification' => now()
        ]);
    }

    public function retenir()
    {
        $this->update([
            'statut_entreprise' => 'retenue',
            'statut_talent' => 'retenue',
            'date_derniere_modification' => now()
        ]);
    }
}