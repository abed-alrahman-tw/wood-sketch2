<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Support\Seo;

class AboutController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::query()->first();
        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->orderByDesc('rating')
            ->take(4)
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'About | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Learn about our craftsmanship, process, and dedication to bespoke woodworking.',
        ]);

        return view('public.about', compact('settings', 'testimonials', 'seo'));
    }
}
