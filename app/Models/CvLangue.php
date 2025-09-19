<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvLangue extends Model
{
    use HasFactory;

    protected $table = 'cv_langues';

    protected $fillable = [
        'talent_id',
        'nom',
        'niveau',
        'ordre'
    ];

    const NIVEAUX = [
        'debutant' => 'Débutant (A1-A2)',
        'intermediaire' => 'Intermédiaire (B1-B2)',
        'avance' => 'Avancé (C1-C2)',
        'natif' => 'Natif'
    ];

    const NIVEAUX_CECR = [
        'a1' => 'A1 - Débutant',
        'a2' => 'A2 - Élémentaire',
        'b1' => 'B1 - Intermédiaire',
        'b2' => 'B2 - Intermédiaire avancé',
        'c1' => 'C1 - Avancé',
        'c2' => 'C2 - Maîtrise',
        'natif' => 'Natif'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getNiveauLibelleAttribute()
    {
        return self::NIVEAUX[$this->niveau] ?? $this->niveau;
    }

    public function getNiveauPourcentageAttribute()
    {
        $niveaux = [
            'debutant' => 25,
            'intermediaire' => 50,
            'avance' => 75,
            'natif' => 100
        ];
        
        return $niveaux[$this->niveau] ?? 0;
    }

    public function getColorClassAttribute()
    {
        $colors = [
            'debutant' => 'bg-red-100 text-red-800',
            'intermediaire' => 'bg-yellow-100 text-yellow-800',
            'avance' => 'bg-green-100 text-green-800',
            'natif' => 'bg-blue-100 text-blue-800'
        ];
        
        return $colors[$this->niveau] ?? 'bg-gray-100 text-gray-800';
    }

    public function getLangueCompleteAttribute()
    {
        return $this->nom . ' (' . $this->niveau_libelle . ')';
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('niveau', 'desc');
    }

    public function scopeByNiveau($query, $niveau)
    {
        return $query->where('niveau', $niveau);
    }

    public function scopeNatif($query)
    {
        return $query->where('niveau', 'natif');
    }

    public function scopeNonNatif($query)
    {
        return $query->where('niveau', '!=', 'natif');
    }
}