<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'short_description',
        'description',
        'cover_image',
        'gallery_images',
        'video_url',
        'video_file',
        'before_image',
        'after_image',
        'location_text',
        'completion_date',
        'tags',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'tags' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
