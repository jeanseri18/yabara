<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    protected $table = 'langues';

    protected $fillable = [
        'talent_id',
        'langue',
        'niveau',
        'certifie',
        'nom_certification',
        'date_certification',
        'description'
    ];

    protected $casts = [
        'certifie' => 'boolean',
        'date_certification' => 'date'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getNiveauLabelAttribute()
    {
        $niveaux = [
            'A1' => 'A1 - Débutant',
            'A2' => 'A2 - Élémentaire',
            'B1' => 'B1 - Intermédiaire',
            'B2' => 'B2 - Intermédiaire supérieur',
            'C1' => 'C1 - Avancé',
            'C2' => 'C2 - Maîtrise',
            'natif' => 'Langue maternelle'
        ];

        return $niveaux[$this->niveau] ?? $this->niveau;
    }

    public function getLangueCompleteAttribute()
    {
        return $this->langue . ' (' . $this->getNiveauLabelAttribute() . ')';
    }
}