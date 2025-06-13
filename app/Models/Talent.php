<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'pole_id',
        'famille_metier_id',
        'niveau_etude',
        'cv_reference',
        'profile_completion_percentage',
        'parrain_cv_reference',
        'avatar_type',
        'total_applications',
        'total_interviews',
        'total_offers_viewed'
    ];

    protected $casts = [
        'profile_completion_percentage' => 'decimal:2',
        'total_applications' => 'integer',
        'total_interviews' => 'integer',
        'total_offers_viewed' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function familleMetier()
    {
        return $this->belongsTo(FamilleMetier::class);
    }

    public function parrain()
    {
        return $this->belongsTo(Talent::class, 'parrain_cv_reference', 'cv_reference');
    }

    public function filleuls()
    {
        return $this->hasMany(Talent::class, 'parrain_cv_reference', 'cv_reference');
    }

    public function experiencesProfessionnelles()
    {
        return $this->hasMany(ExperienceProfessionnelle::class);
    }

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    public function competences()
    {
        return $this->hasMany(Competence::class);
    }

    public function langues()
    {
        return $this->hasMany(Langue::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}