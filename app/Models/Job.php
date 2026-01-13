<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'project_id',
        'booking_id',
        'quote_request_id',
        'status',
        'price_final',
        'deposit_type',
        'deposit_amount',
        'deposit_paid',
        'deposit_link_token',
        'deposit_link_sent_at',
        'stripe_payment_intent_id',
        'notes',
    ];

    protected $casts = [
        'price_final' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'deposit_link_sent_at' => 'datetime',
    ];

    public function depositAmount(): ?float
    {
        if (! $this->deposit_type || ! $this->deposit_amount) {
            return null;
        }

        if ($this->deposit_type === 'percent') {
            if (! $this->price_final) {
                return null;
            }

            return round((float) $this->price_final * ((float) $this->deposit_amount / 100), 2);
        }

        return (float) $this->deposit_amount;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function quoteRequest(): BelongsTo
    {
        return $this->belongsTo(QuoteRequest::class);
    }
}
