<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'owner_name',
        'city',
        'email',
        'phone',
        'whatsapp',
        'hero_title',
        'hero_subtitle',
        'service_radius_miles',
        'social_links',
        'google_reviews_url',
    ];

    protected $casts = [
        'service_radius_miles' => 'integer',
        'social_links' => 'array',
    ];
}
