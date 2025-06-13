<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formations';

    protected $fillable = [
        'talent_id',
        'etablissement',
        'diplome',
        'domaine_etude',
        'niveau_diplome',
        'date_debut',
        'date_fin',
        'mention',
        'ville',
        'pays',
        'en_cours',
        'description'
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
        
        if (!$fin) {
            return null;
        }
        
        $diff = $debut->diff($fin);
        $years = $diff->y;
        
        return $years . ' an' . ($years > 1 ? 's' : '');
    }

    public function getFormationCompleteAttribute()
    {
        return $this->diplome . ' en ' . $this->domaine_etude . 
               ' - ' . $this->etablissement;
    }
}