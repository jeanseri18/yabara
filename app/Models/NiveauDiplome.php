<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiveauDiplome extends Model
{
    use HasFactory;

    protected $table = 'niveaux_diplomes';

    protected $fillable = [
        'nom',
        'niveau',
        'description',
        'is_active'
    ];

    protected $casts = [
        'niveau' => 'integer',
        'is_active' => 'boolean'
    ];

    public function talents()
    {
        return $this->hasMany(Talent::class, 'niveau_etude');
    }

    public function offresEmploi()
    {
        return $this->hasMany(OffreEmploi::class, 'niveau_diplome_requis');
    }

    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParNiveau($query)
    {
        return $query->orderBy('niveau');
    }
}