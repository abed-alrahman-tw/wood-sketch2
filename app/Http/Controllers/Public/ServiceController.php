<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\Seo;

class ServiceController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::query()->first();
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'Services | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Handcrafted services tailored to your space, from custom furniture to full renovations.',
        ]);

        return view('public.services.index', compact('settings', 'services', 'seo'));
    }

    public function show(string $slug)
    {
        $settings = SiteSetting::query()->first();
        $service = Service::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $city = $settings?->city ? ' in '.$settings->city : '';
        $title = $service->name.$city.' | '.($settings?->site_name ?? config('app.name'));

        $seo = Seo::baseMeta($settings, [
            'title' => $title,
            'description' => $service->description,
        ]);

        return view('public.services.show', compact('settings', 'service', 'seo'));
    }
}
