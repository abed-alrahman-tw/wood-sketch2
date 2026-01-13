<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Project extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(function () {
            static::flushHomeCaches();
            static::bumpPortfolioCacheVersion();
        });

        static::deleted(function () {
            static::flushHomeCaches();
            static::bumpPortfolioCacheVersion();
        });
    }

    protected static function flushHomeCaches(): void
    {
        Cache::forget('home.featuredProjects');
    }

    protected static function bumpPortfolioCacheVersion(): void
    {
        $current = Cache::get('portfolio.projects.version', 1);
        Cache::put('portfolio.projects.version', $current + 1);
    }

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

    public function coverThumbnailPath(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }

        $extension = pathinfo($this->cover_image, PATHINFO_EXTENSION);
        $base = substr($this->cover_image, 0, -strlen($extension) - 1);

        return $base.'_thumb.'.$extension;
    }
}
