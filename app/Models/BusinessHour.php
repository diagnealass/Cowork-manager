<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_id',
        'day_of_week',
        'open_time',
        'close_time',
        'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un horaire APPARTIENT À un espace (N:1)
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    // ========================================
    // CONSTANTES
    // ========================================

    /**
     * Noms des jours (0 = Dimanche, 6 = Samedi)
     */
    const DAYS = [
        0 => 'Dimanche',
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
    ];

    // ========================================
    // ACCESSORS
    // ========================================

    /**
     * Obtenir le nom du jour
     */
    public function getDayNameAttribute()
    {
        return self::DAYS[$this->day_of_week] ?? 'Inconnu';
    }
}
