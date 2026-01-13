<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'service_id',
        'message',
        'photos',
        'address_text',
        'postcode',
        'latitude',
        'longitude',
        'status',
        'estimated_range_min',
        'estimated_range_max',
        'admin_notes',
    ];

    protected $casts = [
        'photos' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'estimated_range_min' => 'decimal:2',
        'estimated_range_max' => 'decimal:2',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function job(): HasOne
    {
        return $this->hasOne(Job::class);
    }
}
