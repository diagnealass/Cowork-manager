<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'company_name',
        'avatar',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un user peut avoir UN profil manager (1:1)
     */
    public function managerProfile()
    {
        return $this->hasOne(ManagerProfile::class);
    }

    /**
     * Un user peut faire PLUSIEURS réservations (1:N)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    /**
     * Un user peut écrire PLUSIEURS avis (1:N)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ========================================
    // SCOPES (Requêtes réutilisables)
    // ========================================

    /**
     * Seulement les utilisateurs actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Seulement les managers
     */
    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    /**
     * Seulement les clients
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Seulement les admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est manager
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    /**
     * Vérifier si l'utilisateur est client
     */
    public function isClient()
    {
        return $this->role === 'client';
    }

    /**
     * Obtenir l'URL de l'avatar
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
}
