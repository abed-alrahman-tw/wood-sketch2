<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Support\Seo;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::query()->first();
        $featuredProjects = Project::query()
            ->with('category')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->take(6)
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => ($settings?->site_name ?? config('app.name')).' | Custom Woodwork & Design',
            'description' => $settings?->hero_subtitle
                ?? 'Custom woodwork projects, handcrafted furniture, and bespoke design services.',
        ]);

        return view('public.home', compact(
            'settings',
            'featuredProjects',
            'services',
            'testimonials',
            'seo'
        ));
    }
}
