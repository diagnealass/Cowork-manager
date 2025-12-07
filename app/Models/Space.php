<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'name',
        'slug',
        'description',
        'address',
        'city',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'capacity',
        'space_type',
        'price_per_hour',
        'price_per_day',
        'price_per_month',
        'currency',
        'min_booking_hours',
        'max_booking_days',
        'is_active',
        'is_featured',
        'rating_average',
        'total_reviews',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'price_per_month' => 'decimal:2',
        'rating_average' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un espace APPARTIENT À un manager (N:1)
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Un espace peut avoir PLUSIEURS réservations (1:N)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Un espace peut avoir PLUSIEURS images (1:N)
     */
    public function images()
    {
        return $this->hasMany(SpaceImage::class)->orderBy('order');
    }

    /**
     * Un espace a UNE image principale (1:1)
     */
    public function primaryImage()
    {
        return $this->hasOne(SpaceImage::class)->where('is_primary', true);
    }

    /**
     * Un espace peut avoir PLUSIEURS amenities (N:N)
     * Table pivot : amenity_space
     */
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Un espace a PLUSIEURS horaires d'ouverture (1:N)
     */
    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class);
    }

    /**
     * Un espace peut avoir PLUSIEURS avis (1:N)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Seulement les espaces actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Seulement les espaces mis en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Rechercher par ville
     */
    public function scopeInCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    /**
     * Filtrer par type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('space_type', $type);
    }

    /**
     * Filtrer par fourchette de prix
     */
    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price_per_day', [$min, $max]);
    }

    // ========================================
    // BOOT (Événements automatiques)
    // ========================================

    /**
     * Générer automatiquement le slug lors de la création
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($space) {
            if (empty($space->slug)) {
                $space->slug = Str::slug($space->name);
            }
        });
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Mettre à jour le rating moyen
     */
    public function updateRating()
    {
        $this->rating_average = $this->reviews()->avg('rating') ?? 0;
        $this->total_reviews = $this->reviews()->count();
        $this->save();
    }

    /**
     * Vérifier si l'espace est disponible
     */
    public function isAvailableOn($startDate, $endDate)
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_datetime', [$startDate, $endDate])
                    ->orWhereBetween('end_datetime', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_datetime', '<=', $startDate)
                          ->where('end_datetime', '>=', $endDate);
                    });
            })
            ->exists();
    }

    /**
     * Obtenir l'URL de l'image principale
     */
    public function getPrimaryImageUrlAttribute()
    {
        $image = $this->primaryImage;
        return $image
            ? asset('storage/' . $image->image_path)
            : asset('images/placeholder-space.jpg');
    }
}
