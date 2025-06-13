<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $table = 'competences';

    protected $fillable = [
        'talent_id',
        'nom_competence',
        'niveau',
        'type_competence',
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
            'debutant' => 'Débutant',
            'intermediaire' => 'Intermédiaire',
            'avance' => 'Avancé',
            'expert' => 'Expert'
        ];

        return $niveaux[$this->niveau] ?? $this->niveau;
    }

    public function getTypeCompetenceLabelAttribute()
    {
        $types = [
            'technique' => 'Technique',
            'soft_skill' => 'Soft Skill',
            'langue' => 'Langue',
            'logiciel' => 'Logiciel',
            'autre' => 'Autre'
        ];

        return $types[$this->type_competence] ?? $this->type_competence;
    }
}