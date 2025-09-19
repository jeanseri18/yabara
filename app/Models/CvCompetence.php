<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvCompetence extends Model
{
    use HasFactory;

    protected $table = 'cv_competences';

    protected $fillable = [
        'talent_id',
        'nom',
        'niveau',
        'type',
        'ordre'
    ];

    const NIVEAUX = [
        'debutant' => 'Débutant',
        'intermediaire' => 'Intermédiaire',
        'avance' => 'Avancé',
        'expert' => 'Expert'
    ];

    const TYPES = [
        'technique' => 'Technique',
        'soft_skill' => 'Soft Skill',
        'logiciel' => 'Logiciel'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getNiveauLibelleAttribute()
    {
        return self::NIVEAUX[$this->niveau] ?? $this->niveau;
    }

    public function getTypeLibelleAttribute()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getNiveauPourcentageAttribute()
    {
        $niveaux = [
            'debutant' => 25,
            'intermediaire' => 50,
            'avance' => 75,
            'expert' => 100
        ];
        
        return $niveaux[$this->niveau] ?? 0;
    }

    public function getColorClassAttribute()
    {
        $colors = [
            'technique' => 'bg-blue-100 text-blue-800',
            'soft_skill' => 'bg-green-100 text-green-800',
            'logiciel' => 'bg-purple-100 text-purple-800'
        ];
        
        return $colors[$this->type] ?? 'bg-gray-100 text-gray-800';
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('niveau', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByNiveau($query, $niveau)
    {
        return $query->where('niveau', $niveau);
    }
}