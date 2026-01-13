<?php

namespace App\Support;

use App\Models\SiteSetting;

class Seo
{
    public static function baseMeta(?SiteSetting $settings = null, array $overrides = []): array
    {
        $settings ??= SiteSetting::query()->first();

        $siteName = $settings?->site_name ?? config('app.name');
        $city = $settings?->city;
        $title = $overrides['title'] ?? $siteName;
        $description = $overrides['description']
            ?? ($settings?->hero_subtitle ?? 'Bespoke woodworking, design, and build services.');

        $meta = [
            'title' => $title,
            'description' => $description,
            'url' => $overrides['url'] ?? url()->current(),
            'image' => $overrides['image'] ?? null,
            'site_name' => $siteName,
            'city' => $city,
        ];

        return array_merge($meta, $overrides);
    }
}
