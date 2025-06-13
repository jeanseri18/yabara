<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pole extends Model
{
    use HasFactory;

    protected $table = 'poles';

    protected $fillable = [
        'nom',
        'icone',
        'ordre_affichage'
    ];

    protected $casts = [
        'ordre_affichage' => 'integer'
    ];

    public function famillesMetiers()
    {
        return $this->hasMany(FamilleMetier::class)->orderBy('ordre_affichage');
    }

    public function talents()
    {
        return $this->hasMany(Talent::class);
    }

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class, 'pole_activite_id');
    }
}