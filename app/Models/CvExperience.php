<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvExperience extends Model
{
    use HasFactory;

    protected $table = 'cv_experiences';

    protected $fillable = [
        'talent_id',
        'poste',
        'entreprise',
        'date_debut',
        'date_fin',
        'en_cours',
        'description',
        'ordre'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'en_cours' => 'boolean'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getDureeAttribute()
    {
        $debut = $this->date_debut;
        $fin = $this->en_cours ? now() : $this->date_fin;
        
        if (!$debut || !$fin) {
            return null;
        }
        
        $diff = $debut->diff($fin);
        $years = $diff->y;
        $months = $diff->m;
        
        if ($years > 0 && $months > 0) {
            return "{$years} an" . ($years > 1 ? 's' : '') . " et {$months} mois";
        } elseif ($years > 0) {
            return "{$years} an" . ($years > 1 ? 's' : '');
        } elseif ($months > 0) {
            return "{$months} mois";
        } else {
            return "Moins d'un mois";
        }
    }

    public function getDateFinFormatteeAttribute()
    {
        return $this->en_cours ? 'Présent' : ($this->date_fin ? $this->date_fin->format('m/Y') : '');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('date_debut', 'desc');
    }
}