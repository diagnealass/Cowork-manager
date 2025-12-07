<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'slug',
        'category',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Une amenity peut être dans PLUSIEURS espaces (N:N)
     * Table pivot : amenity_space
     */
    public function spaces()
    {
        return $this->belongsToMany(Space::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Filtrer par catégorie
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
