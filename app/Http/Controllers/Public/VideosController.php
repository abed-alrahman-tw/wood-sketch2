<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Support\Seo;

class VideosController extends Controller
{
    public function __invoke()
    {
        $settings = SiteSetting::query()->first();
        $projects = Project::query()
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNotNull('video_url')
                    ->orWhereNotNull('video_file');
            })
            ->latest()
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'Videos | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Watch walkthroughs and behind-the-scenes videos from recent woodworking projects.',
        ]);

        return view('public.videos', compact('settings', 'projects', 'seo'));
    }
}
