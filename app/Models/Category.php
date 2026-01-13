<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('portfolio.categories');
            static::bumpPortfolioCacheVersion();
        });

        static::deleted(function () {
            Cache::forget('portfolio.categories');
            static::bumpPortfolioCacheVersion();
        });
    }

    protected static function bumpPortfolioCacheVersion(): void
    {
        $current = Cache::get('portfolio.projects.version', 1);
        Cache::put('portfolio.projects.version', $current + 1);
    }

    protected $fillable = [
        'name',
        'slug',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
