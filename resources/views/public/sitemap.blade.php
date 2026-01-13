<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('portfolio.index') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('services.index') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('reviews') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('videos') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('contact.show') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('bookings.create') }}</loc>
        <changefreq>monthly</changefreq>
    </url>
    @foreach($projects as $project)
        <url>
            <loc>{{ route('portfolio.show', $project->slug) }}</loc>
            <lastmod>{{ $project->updated_at->toDateString() }}</lastmod>
            <changefreq>monthly</changefreq>
        </url>
    @endforeach
    @foreach($services as $service)
        <url>
            <loc>{{ route('services.show', $service->slug) }}</loc>
            <lastmod>{{ $service->updated_at->toDateString() }}</lastmod>
            <changefreq>monthly</changefreq>
        </url>
    @endforeach
</urlset>
