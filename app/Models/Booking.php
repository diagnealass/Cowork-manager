<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'space_id',
        'booking_number',
        'start_datetime',
        'end_datetime',
        'total_hours',
        'price_per_unit',
        'total_price',
        'status',
        'payment_status',
        'cancellation_reason',
        'cancelled_at',
        'check_in_at',
        'check_out_at',
        'notes',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'cancelled_at' => 'datetime',
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
        'total_hours' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Une réservation APPARTIENT À un user (N:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Une réservation APPARTIENT À un espace (N:1)
     */
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    /**
     * Une réservation a UN paiement (1:1)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Une réservation a UNE facture (1:1)
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Une réservation peut avoir UN avis (1:1)
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Réservations en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Réservations confirmées
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Réservations terminées
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Réservations payées
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // ========================================
    // BOOT - Événements automatiques
    // ========================================

    /**
     * Générer automatiquement le booking_number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'BK-' . date('Y') . '-' . str_pad(
                    static::whereYear('created_at', date('Y'))->count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Calculer le prix total automatiquement
     */
    public function calculateTotalPrice()
    {
        $hours = $this->start_datetime->diffInHours($this->end_datetime);
        $this->total_hours = $hours;

        if ($this->space->price_per_hour && $hours < 24) {
            $this->total_price = $hours * $this->space->price_per_hour;
        } else {
            $days = ceil($hours / 24);
            $this->total_price = $days * $this->space->price_per_day;
        }

        return $this->total_price;
    }

    /**
     * Vérifier si la réservation peut être annulée
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed'])
            && $this->start_datetime->isFuture();
    }

    /**
     * Vérifier si un avis peut être laissé
     */
    public function canBeReviewed()
    {
        return $this->status === 'completed'
            && is_null($this->review);
    }
}
