<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'company_registration',
        'tax_id',
        'bank_account',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un profil manager APPARTIENT À un user (N:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un manager peut gérer PLUSIEURS espaces (1:N)
     * Via la relation user → manager_id dans spaces
     */
    public function spaces()
    {
        return $this->hasMany(Space::class, 'manager_id', 'user_id');
    }

    // ========================================
    // ACCESSORS (Lire des données modifiées)
    // ========================================

    /**
     * Décrypter le compte bancaire lors de la lecture
     */
    public function getBankAccountAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // ========================================
    // MUTATORS (Modifier des données avant sauvegarde)
    // ========================================

    /**
     * Crypter le compte bancaire avant sauvegarde
     */
    public function setBankAccountAttribute($value)
    {
        $this->attributes['bank_account'] = $value ? encrypt($value) : null;
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Vérifier si le profil est vérifié
     */
    public function isVerified()
    {
        return !is_null($this->verified_at);
    }

    /**
     * Marquer le profil comme vérifié
     */
    public function verify()
    {
        $this->update(['verified_at' => now()]);
    }
}
