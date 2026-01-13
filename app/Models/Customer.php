<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'default_address_text',
        'postcode',
        'latitude',
        'longitude',
        'notes',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class, Job::class, 'customer_id', 'id', 'id', 'booking_id');
    }

    public function quoteRequests(): HasManyThrough
    {
        return $this->hasManyThrough(QuoteRequest::class, Job::class, 'customer_id', 'id', 'id', 'quote_request_id');
    }
}
