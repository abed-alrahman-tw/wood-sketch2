@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Reviews</p>
            <h1 class="mt-2 text-4xl font-semibold">What clients say about our work</h1>
        </div>
        <div class="text-sm text-slate-300">
            {{ $settings?->city ? 'Serving '.$settings->city.' and surrounding areas.' : 'Serving clients across our service region.' }}
        </div>
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($testimonials as $testimonial)
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-100">{{ $testimonial->customer_name }}</p>
                    <div class="text-xs text-amber-300">
                        {{ str_repeat('★', $testimonial->rating) }}
                    </div>
                </div>
                <p class="mt-2 text-xs text-slate-400">{{ $testimonial->area }}</p>
                <p class="mt-4 text-sm text-slate-200">“{{ $testimonial->content }}”</p>
            </div>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">
                Reviews will appear here once clients submit feedback.
            </div>
        @endforelse
    </div>

    <div class="mt-12 rounded-2xl border border-white/10 bg-slate-900/60 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Ready to start?</p>
                <h2 class="mt-2 text-2xl font-semibold">Request your custom quote or book a consultation.</h2>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('contact.show') }}" class="rounded-full bg-amber-400 px-5 py-2 text-sm font-semibold text-slate-900">Quick Quote</a>
                <a href="{{ route('bookings.create') }}" class="rounded-full border border-white/20 px-5 py-2 text-sm font-semibold text-white">Book a visit</a>
            </div>
        </div>
    </div>
</section>
@endsection
