<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $projects = Project::query()
            ->where('status', 'published')
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        $services = Service::query()
            ->where('is_active', true)
            ->latest('updated_at')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('public.sitemap', compact('projects', 'services'))
            ->header('Content-Type', 'application/xml');
    }
}
