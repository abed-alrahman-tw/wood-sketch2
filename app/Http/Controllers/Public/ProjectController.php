<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Support\Seo;

class ProjectController extends Controller
{
    public function __invoke(string $slug)
    {
        $settings = SiteSetting::query()->first();
        $project = Project::query()
            ->with('category')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();

        $title = $project->title.' | '.($settings?->site_name ?? config('app.name'));
        $description = $project->short_description;
        $image = $project->cover_image ? asset('storage/'.$project->cover_image) : null;

        $seo = Seo::baseMeta($settings, [
            'title' => $title,
            'description' => $description,
            'image' => $image,
        ]);

        return view('public.projects.show', compact('settings', 'project', 'seo'));
    }
}
