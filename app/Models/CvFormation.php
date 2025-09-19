<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvFormation extends Model
{
    use HasFactory;

    protected $table = 'cv_formations';

    protected $fillable = [
        'talent_id',
        'diplome',
        'etablissement',
        'annee_obtention',
        'mention',
        'ordre'
    ];

    protected $casts = [
        'annee_obtention' => 'integer'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getFormationCompleteAttribute()
    {
        $formation = $this->diplome;
        if ($this->etablissement) {
            $formation .= ' - ' . $this->etablissement;
        }
        if ($this->annee_obtention) {
            $formation .= ' (' . $this->annee_obtention . ')';
        }
        if ($this->mention) {
            $formation .= ' - ' . $this->mention;
        }
        return $formation;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('annee_obtention', 'desc');
    }

    public function scopeRecent($query, $years = 10)
    {
        return $query->where('annee_obtention', '>=', now()->year - $years);
    }
}