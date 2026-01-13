<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'service_id',
        'service_type',
        'preferred_date',
        'preferred_time_range',
        'message',
        'attachment',
        'address_text',
        'postcode',
        'latitude',
        'longitude',
        'is_outside_service_area',
        'status',
        'proposed_date',
        'proposed_time_range',
        'admin_notes',
        'approved_start_at',
        'approved_end_at',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'proposed_date' => 'date',
        'approved_start_at' => 'datetime',
        'approved_end_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_outside_service_area' => 'boolean',
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
