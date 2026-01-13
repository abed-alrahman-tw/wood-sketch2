@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="grid gap-10 lg:grid-cols-[2fr,1fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">About</p>
            <h1 class="mt-2 text-4xl font-semibold">Design-led craftsmanship for modern spaces</h1>
            <p class="mt-4 text-lg text-slate-300">We partner with homeowners, architects, and boutique studios to deliver bespoke woodwork. From the first sketch to the final installation, we handle the entire journey with a focus on quality, transparency, and detail.</p>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Experience</p>
                    <p class="mt-3 text-sm text-slate-300">Decades of combined joinery and interior build expertise.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Materials</p>
                    <p class="mt-3 text-sm text-slate-300">Premium hardwoods sourced with sustainability in mind.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Process</p>
                    <p class="mt-3 text-sm text-slate-300">Clear timelines, collaborative design, and meticulous installation.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Coverage</p>
                    <p class="mt-3 text-sm text-slate-300">Serving {{ $settings?->city ?? 'your area' }} and nearby communities.</p>
                </div>
            </div>
        </div>
        <aside class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-amber-400 p-6 text-slate-900">
                <h2 class="text-xl font-semibold">Meet the team</h2>
                <p class="mt-2 text-sm">{{ $settings?->owner_name ?? 'Our artisan team' }} brings design, build, and project management together under one roof.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Client testimonials</p>
                <div class="mt-4 space-y-4 text-sm text-slate-300">
                    @forelse($testimonials as $testimonial)
                        <div>
                            <p>“{{ $testimonial->content }}”</p>
                            <p class="mt-2 text-xs text-slate-500">{{ $testimonial->customer_name }} — {{ $testimonial->area }}</p>
                        </div>
                    @empty
                        <p>No testimonials yet.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</section>
@endsection
