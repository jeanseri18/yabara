<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilleMetier extends Model
{
    use HasFactory;

    protected $table = 'familles_metiers';

    protected $fillable = [
        'nom',
        'description',
        'pole_id',
        'ordre_affichage'
    ];

    protected $casts = [
        'ordre_affichage' => 'integer'
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function talents()
    {
        return $this->hasMany(Talent::class);
    }
}