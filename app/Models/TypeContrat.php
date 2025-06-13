<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContrat extends Model
{
    use HasFactory;

    protected $table = 'types_contrats';

    protected $fillable = [
        'nom',
        'description',
        'duree_type',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function offresEmploi()
    {
        return $this->hasMany(OffreEmploi::class);
    }

    public function scopeActifs($query)
    {
        return $query->where('is_active', true);
    }
}