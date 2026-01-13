@extends('public.layout')

@section('content')
@php($isLowData = request()->cookie('low_data') === '1')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Videos</p>
            <h1 class="mt-2 text-4xl font-semibold">Project walkthroughs and studio highlights</h1>
        </div>
        <a href="{{ route('portfolio.index') }}" class="text-sm font-semibold text-amber-300">Explore the portfolio</a>
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-2">
        @forelse($projects as $project)
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-amber-300">{{ $project->category?->name }}</p>
                        <h2 class="mt-2 text-2xl font-semibold">{{ $project->title }}</h2>
                    </div>
                    <a href="{{ route('portfolio.show', $project->slug) }}" class="text-xs font-semibold text-slate-300 hover:text-amber-300">View project</a>
                </div>
                <p class="mt-4 text-sm text-slate-300">{{ $project->short_description }}</p>

                <div class="mt-4 rounded-xl border border-white/10 bg-slate-950/60 p-4">
                    @if($project->video_file)
                        @if($isLowData)
                            <div data-video-wrapper data-video-source="{{ asset('storage/'.$project->video_file) }}" class="space-y-3 text-sm text-slate-300">
                                <p>Low data mode is on. Tap to load the video.</p>
                                <button type="button" data-video-placeholder class="rounded-full border border-white/20 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:border-amber-300 hover:text-amber-300">
                                    Load video
                                </button>
                            </div>
                        @else
                            <video class="w-full rounded-lg" controls preload="metadata" playsinline>
                                <source src="{{ asset('storage/'.$project->video_file) }}" type="video/mp4">
                            </video>
                        @endif
                    @elseif($project->video_url)
                        <p class="text-sm text-slate-300">Watch the video walkthrough:</p>
                        <a href="{{ $project->video_url }}" class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-amber-300" target="_blank" rel="noopener">
                            View video
                            <span aria-hidden="true">↗</span>
                        </a>
                    @else
                        <p class="text-sm text-slate-400">Video coming soon.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">
                Video features will appear here once projects include walkthrough clips.
            </div>
        @endforelse
    </div>
</section>
@endsection
