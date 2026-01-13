<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function __invoke(Request $request)
    {
        $settings = SiteSetting::query()->first();
        $cacheTtl = now()->addMinutes(5);
        $categories = Cache::remember('portfolio.categories', $cacheTtl, function () {
            return Category::query()->orderBy('name')->get();
        });

        $projectsQuery = Project::query()
            ->with('category')
            ->where('status', 'published');

        if ($request->filled('category')) {
            $category = $request->string('category')->toString();
            $projectsQuery->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $projectsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $categoryKey = $request->filled('category') ? $request->string('category')->toString() : 'all';
        $searchKey = $request->filled('search') ? $request->string('search')->toString() : '';
        $page = $request->integer('page', 1);
        $projectsVersion = Cache::get('portfolio.projects.version', 1);
        $projectsCacheKey = sprintf(
            'portfolio.projects.v%s.%s.%s.page%s',
            $projectsVersion,
            $categoryKey,
            md5($searchKey),
            $page
        );

        $projects = Cache::remember($projectsCacheKey, $cacheTtl, function () use ($projectsQuery) {
            return $projectsQuery
                ->latest()
                ->paginate(9)
                ->withQueryString();
        });

        $seo = Seo::baseMeta($settings, [
            'title' => 'Portfolio | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Explore featured woodworking projects, renovations, and custom builds.',
        ]);

        return view('public.portfolio.index', compact(
            'settings',
            'categories',
            'projects',
            'seo'
        ));
    }
}
