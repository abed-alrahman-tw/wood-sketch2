@extends('public.layout')

@section('content')
@php($isLowData = request()->cookie('low_data') === '1')
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-400/20 via-slate-900/40 to-slate-950"></div>
    <div class="relative mx-auto grid w-full max-w-6xl items-center gap-10 px-6 py-20 md:grid-cols-2">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-amber-300">Custom Woodwork Studio</p>
            <h1 class="mt-4 text-4xl font-semibold leading-tight md:text-5xl">
                {{ $settings?->hero_title ?? 'Handcrafted spaces for modern living.' }}
            </h1>
            <p class="mt-4 text-lg text-slate-300">
                {{ $settings?->hero_subtitle ?? 'We design, build, and install bespoke woodwork across kitchens, offices, and boutique interiors.' }}
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('portfolio.index') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900">View Portfolio</a>
                <a href="{{ route('services.index') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white hover:border-amber-400 hover:text-amber-300">Explore Services</a>
            </div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl">
            <div class="space-y-4">
                <div class="flex items-center justify-between text-sm text-slate-300">
                    <span>Service Radius</span>
                    <span>{{ $settings?->service_radius_miles ?? 25 }} miles</span>
                </div>
                <div class="rounded-2xl bg-slate-950/60 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Highlights</p>
                    <ul class="mt-4 space-y-3 text-sm text-slate-200">
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Design-to-install project management</li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Premium hardwoods & sustainable finishes</li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Commercial & residential specialists</li>
                    </ul>
                </div>
                <a href="{{ route('contact.show') }}" class="block rounded-full bg-white/10 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-amber-400 hover:text-slate-900">Start a Project</a>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Featured Projects</p>
            <h2 class="mt-2 text-3xl font-semibold">Crafted to elevate every space</h2>
        </div>
        <a href="{{ route('portfolio.index') }}" class="hidden text-sm font-semibold text-amber-300 md:inline">View all</a>
    </div>
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($featuredProjects as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="group rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:-translate-y-1">
                <div class="media-frame relative aspect-[4/3] overflow-hidden rounded-xl bg-slate-800 is-loading">
                    @if($project->cover_image)
                        @php($thumbnail = $project->coverThumbnailPath())
                        <img
                            src="{{ asset('storage/'.(($isLowData && $thumbnail) ? $thumbnail : $project->cover_image)) }}"
                            @if($thumbnail)
                                srcset="{{ asset('storage/'.$thumbnail) }} 480w, {{ asset('storage/'.$project->cover_image) }} 960w"
                            @endif
                            sizes="(min-width: 1024px) 30vw, (min-width: 768px) 45vw, 100vw"
                            loading="lazy"
                            decoding="async"
                            alt="{{ $project->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                    @endif
                </div>
                <div class="mt-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-amber-300">{{ $project->category?->name }}</p>
                    <h3 class="mt-2 text-lg font-semibold">{{ $project->title }}</h3>
                    <p class="mt-2 text-sm text-slate-300">{{ $project->short_description }}</p>
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">Add featured projects in the admin panel to showcase them here.</div>
        @endforelse
    </div>
</section>

<section class="bg-slate-900/50">
    <div class="mx-auto w-full max-w-6xl px-6 py-16">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Services</p>
                <h2 class="mt-2 text-3xl font-semibold">Tailored craftsmanship for every brief</h2>
            </div>
            <a href="{{ route('services.index') }}" class="text-sm font-semibold text-amber-300">Browse services</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-6">
                    <h3 class="text-lg font-semibold">{{ $service->name }}</h3>
                    <p class="mt-3 text-sm text-slate-300">{{ $service->description }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm text-amber-300">From £{{ number_format($service->starting_price ?? 0, 2) }}</span>
                        <a href="{{ route('services.show', $service->slug) }}" class="text-sm font-semibold text-white hover:text-amber-300">Details</a>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-white/10 bg-slate-950/60 p-6 text-sm text-slate-300">No services added yet. Create them in the admin panel.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Testimonials</p>
            <h2 class="mt-2 text-3xl font-semibold">Trusted by homeowners and studios</h2>
        </div>
        @if($settings?->google_reviews_url)
            <a href="{{ $settings->google_reviews_url }}" class="text-sm font-semibold text-amber-300">Read more reviews</a>
        @endif
    </div>
    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($testimonials as $testimonial)
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm text-slate-200">“{{ $testimonial->content }}”</p>
                <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                    <span>{{ $testimonial->customer_name }}</span>
                    <span>{{ $testimonial->area }}</span>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">No testimonials yet.</div>
        @endforelse
    </div>
</section>

<section class="bg-amber-400 text-slate-900">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-start justify-between gap-6 px-6 py-16 md:flex-row md:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em]">Ready to build?</p>
            <h2 class="mt-2 text-3xl font-semibold">Let’s craft something timeless together.</h2>
        </div>
        <a href="{{ route('contact.show') }}" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white">Book a consultation</a>
    </div>
</section>
@endsection
