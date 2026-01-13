@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Services</p>
            <h1 class="mt-2 text-4xl font-semibold">Crafted solutions for every brief</h1>
            <p class="mt-4 text-lg text-slate-300">From single-room upgrades to full custom builds, we orchestrate the process end to end.</p>
        </div>
        <a href="{{ route('contact.show') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900">Request a quote</a>
    </div>

    <div class="mt-10 grid gap-6 md:grid-cols-2">
        @forelse($services as $service)
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">{{ $service->name }}</h2>
                    <span class="rounded-full bg-slate-900 px-3 py-1 text-xs text-amber-300">From £{{ number_format($service->starting_price ?? 0, 2) }}</span>
                </div>
                <p class="mt-4 text-sm text-slate-300">{{ $service->description }}</p>
                <div class="mt-6 flex items-center justify-between">
                    <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Tailored installs</span>
                    <a href="{{ route('services.show', $service->slug) }}" class="text-sm font-semibold text-amber-300">View details</a>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 text-sm text-slate-300">No services added yet.</div>
        @endforelse
    </div>
</section>
@endsection
