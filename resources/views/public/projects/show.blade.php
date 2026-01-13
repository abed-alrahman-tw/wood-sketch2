@extends('public.layout')

@section('content')
@php
    $gallery = collect([$project->cover_image])
        ->merge($project->gallery_images ?? [])
        ->merge([$project->before_image, $project->after_image])
        ->filter()
        ->unique()
        ->values();
@endphp
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="grid gap-10 lg:grid-cols-[2fr,1fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ $project->category?->name }}</p>
            <h1 class="mt-2 text-4xl font-semibold">{{ $project->title }}</h1>
            <p class="mt-4 text-lg text-slate-300">{{ $project->short_description }}</p>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                @foreach($gallery as $index => $image)
                    <button
                        class="group relative overflow-hidden rounded-2xl border border-white/10 bg-slate-900"
                        type="button"
                        data-gallery-trigger
                        data-index="{{ $index }}"
                    >
                        <img src="{{ asset('storage/'.$image) }}" alt="{{ $project->title }} image" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></span>
                    </button>
                @endforeach
            </div>

            <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-6">
                <h2 class="text-2xl font-semibold">Project Overview</h2>
                <p class="mt-4 text-sm leading-relaxed text-slate-300">{{ $project->description }}</p>
            </div>
        </div>
        <aside class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Project Details</p>
                <div class="mt-4 space-y-3 text-sm text-slate-300">
                    <div class="flex items-center justify-between">
                        <span>Location</span>
                        <span>{{ $project->location_text ?? 'By request' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Completion</span>
                        <span>{{ $project->completion_date?->format('F Y') ?? 'Ongoing' }}</span>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tags</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($project->tags ?? [] as $tag)
                        <span class="rounded-full border border-white/10 bg-slate-900 px-3 py-1 text-xs text-slate-300">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-amber-400 p-6 text-slate-900">
                <h3 class="text-xl font-semibold">Inspired by this project?</h3>
                <p class="mt-2 text-sm">Let’s discuss timelines, budgets, and your space.</p>
                <a href="{{ route('contact.show') }}" class="mt-4 inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Book a consultation</a>
            </div>
        </aside>
    </div>
</section>

<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 px-6">
    <button id="lightbox-close" class="absolute right-6 top-6 rounded-full border border-white/20 px-3 py-2 text-xs uppercase tracking-widest text-white">Close</button>
    <button id="lightbox-prev" class="absolute left-6 top-1/2 -translate-y-1/2 rounded-full border border-white/20 px-3 py-2 text-xs uppercase tracking-widest text-white">Prev</button>
    <button id="lightbox-next" class="absolute right-6 top-1/2 -translate-y-1/2 rounded-full border border-white/20 px-3 py-2 text-xs uppercase tracking-widest text-white">Next</button>
    <img id="lightbox-image" src="" alt="Project image" class="max-h-[80vh] w-auto rounded-2xl">
</div>

<script>
    const galleryImages = @json($gallery->map(fn ($image) => asset('storage/'.$image)));
    const triggers = document.querySelectorAll('[data-gallery-trigger]');
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const closeBtn = document.getElementById('lightbox-close');
    const prevBtn = document.getElementById('lightbox-prev');
    const nextBtn = document.getElementById('lightbox-next');
    let currentIndex = 0;

    const openLightbox = (index) => {
        currentIndex = index;
        lightboxImage.src = galleryImages[currentIndex];
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
    };

    const closeLightbox = () => {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
    };

    const showNext = () => {
        currentIndex = (currentIndex + 1) % galleryImages.length;
        lightboxImage.src = galleryImages[currentIndex];
    };

    const showPrev = () => {
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        lightboxImage.src = galleryImages[currentIndex];
    };

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => openLightbox(Number(trigger.dataset.index)));
    });

    closeBtn?.addEventListener('click', closeLightbox);
    prevBtn?.addEventListener('click', showPrev);
    nextBtn?.addEventListener('click', showNext);

    lightbox?.addEventListener('click', (event) => {
        if (event.target === lightbox) {
            closeLightbox();
        }
    });
</script>
@endsection
