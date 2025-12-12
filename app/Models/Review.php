<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'space_id',
        'booking_id',
        'rating',
        'title',
        'comment',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un avis APPARTIENT À un user (N:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un avis APPARTIENT À un espace (N:1)
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    /**
     * Un avis APPARTIENT À une réservation (N:1)
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Avis vérifiés seulement
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Avis avec note minimum
     */
    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    // ========================================
    // BOOT - Mettre à jour le rating du space
    // ========================================

    /**
     * Recalculer automatiquement le rating de l'espace
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            $review->space->updateRating();
        });

        static::updated(function ($review) {
            $review->space->updateRating();
        });

        static::deleted(function ($review) {
            $review->space->updateRating();
        });
    }
}
