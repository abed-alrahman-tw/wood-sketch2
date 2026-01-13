<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Support\Seo;

class ReviewsController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::query()->first();
        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->orderByDesc('rating')
            ->latest()
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'Reviews | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Read verified client reviews and feedback on our bespoke woodworking services.',
        ]);

        return view('public.reviews', compact('settings', 'testimonials', 'seo'));
    }
}
