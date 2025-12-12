<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'stripe_payment_intent_id',
        'refund_amount',
        'refunded_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'refunded_at' => 'datetime',
        'metadata' => 'array',
    ];

    // ========================================
    // RELATIONS
    // ========================================

    /**
     * Un paiement APPARTIENT À une réservation (N:1)
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Paiements complétés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Paiements échoués
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Paiements remboursés
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    // ========================================
    // MÉTHODES UTILES
    // ========================================

    /**
     * Vérifier si le paiement est complété
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Vérifier si le paiement est remboursé
     */
    public function isRefunded()
    {
        return $this->status === 'refunded';
    }
}
