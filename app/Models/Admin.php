<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'role',
        'permissions',
        'avatar',
        'mode_affichage',
        'mode_nuit'
    ];

    protected $casts = [
        'permissions' => 'array',
        'mode_nuit' => 'boolean'
    ];

    /**
     * Get the user that owns the admin profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Get the admin's avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        return null;
    }
}
