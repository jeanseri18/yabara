<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreEmploi extends Model
{
    use HasFactory;

    protected $table = 'offres_emploi';

    protected $fillable = [
        'entreprise_id',
        'titre',
        'descriptif',
        'type_contrat_id',
        'pole_id',
        'famille_metier_id',
        'niveau_diplome_requis',
        'experience_minimum',
        'remuneration',
        'lieu_poste',
        'teletravail',
        'mobilite_requise',
        'statut',
        'date_publication',
        'reference_offre',
        'nb_recrutes',
        'nb_vues'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'teletravail' => 'boolean',
        'mobilite_requise' => 'boolean',
        'remuneration' => 'decimal:2',
        'nb_recrutes' => 'integer',
        'nb_vues' => 'integer'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function typeContrat()
    {
        return $this->belongsTo(TypeContrat::class);
    }

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function familleMetier()
    {
        return $this->belongsTo(FamilleMetier::class);
    }

    public function niveauDiplome()
    {
        return $this->belongsTo(NiveauDiplome::class, 'niveau_diplome_requis');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }

    public function scopePubliees($query)
    {
        return $query->where('statut', 'publiee');
    }

    public function scopeActives($query)
    {
        return $query->where('statut', 'publiee')
                    ->where('date_publication', '<=', now());
    }
}