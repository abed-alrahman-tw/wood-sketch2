@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Portfolio</p>
            <h1 class="mt-2 text-4xl font-semibold">Signature projects and transformations</h1>
        </div>
        <form method="GET" class="flex w-full flex-col gap-4 md:w-auto md:flex-row md:items-center">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search projects"
                class="w-full rounded-full border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white placeholder:text-slate-500 md:w-60"
            >
            <select
                name="category"
                class="w-full rounded-full border border-white/10 bg-slate-950 px-4 py-2 text-sm text-white md:w-48"
            >
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="rounded-full bg-amber-400 px-5 py-2 text-sm font-semibold text-slate-900">Filter</button>
        </form>
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($projects as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="group rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-1">
                <div class="aspect-[4/3] overflow-hidden rounded-xl bg-slate-800">
                    @if($project->cover_image)
                        <img src="{{ asset('storage/'.$project->cover_image) }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                </div>
                <div class="mt-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-amber-300">{{ $project->category?->name }}</p>
                    <h3 class="mt-2 text-lg font-semibold">{{ $project->title }}</h3>
                    <p class="mt-2 text-sm text-slate-300">{{ $project->short_description }}</p>
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">No projects found yet. Add published projects to display them here.</div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $projects->links() }}
    </div>
</section>
@endsection
