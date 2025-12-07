<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'space_id',
        'image_path',
        'is_primary',
        'order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Une image APPARTIENT À un espace (N:1)
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    // ========================================
    // ACCESSORS
    // ========================================

    /**
     * Obtenir l'URL complète de l'image
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
