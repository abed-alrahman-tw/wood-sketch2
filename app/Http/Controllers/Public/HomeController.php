<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Support\Seo;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::query()->first();
        $cacheTtl = now()->addMinutes(5);

        $featuredProjects = Cache::remember('home.featuredProjects', $cacheTtl, function () {
            return Project::query()
                ->with('category')
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest()
                ->take(6)
                ->get();
        });

        $services = Cache::remember('home.services', $cacheTtl, function () {
            return Service::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->take(6)
                ->get();
        });

        $testimonials = Cache::remember('home.testimonials', $cacheTtl, function () {
            return Testimonial::query()
                ->where('is_published', true)
                ->orderByDesc('rating')
                ->take(6)
                ->get();
        });

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
