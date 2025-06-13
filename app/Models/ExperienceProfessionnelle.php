<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceProfessionnelle extends Model
{
    use HasFactory;

    protected $table = 'experiences_professionnelles';

    protected $fillable = [
        'talent_id',
        'entreprise',
        'poste',
        'description',
        'date_debut',
        'date_fin',
        'est_poste_actuel',
        'secteur_activite',
        'type_contrat',
        'ville',
        'pays'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'est_poste_actuel' => 'boolean'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getDureeAttribute()
    {
        $debut = $this->date_debut;
        $fin = $this->est_poste_actuel ? now() : $this->date_fin;
        
        if (!$fin) {
            return null;
        }
        
        $diff = $debut->diff($fin);
        $years = $diff->y;
        $months = $diff->m;
        
        if ($years > 0) {
            return $years . ' an' . ($years > 1 ? 's' : '') . 
                   ($months > 0 ? ' et ' . $months . ' mois' : '');
        }
        
        return $months . ' mois';
    }
}