@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="grid gap-10 lg:grid-cols-[2fr,1fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-amber-300">Service Detail</p>
            <h1 class="mt-2 text-4xl font-semibold">{{ $service->name }}</h1>
            <p class="mt-4 text-lg text-slate-300">{{ $service->description }}</p>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Typical Timeline</p>
                    <p class="mt-3 text-sm text-slate-300">4-8 weeks depending on scope, materials, and approvals.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Design Process</p>
                    <p class="mt-3 text-sm text-slate-300">Discovery, concept design, material selection, and on-site installation.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Coverage Area</p>
                    <p class="mt-3 text-sm text-slate-300">Serving {{ $settings?->city ?? 'your area' }} within {{ $settings?->service_radius_miles ?? 20 }} miles.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Starting Investment</p>
                    <p class="mt-3 text-sm text-slate-300">From £{{ number_format($service->starting_price ?? 0, 2) }} with tailored project scopes.</p>
                </div>
            </div>
        </div>
        <aside class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-amber-400 p-6 text-slate-900">
                <h2 class="text-xl font-semibold">Ready for {{ $service->name }}?</h2>
                <p class="mt-2 text-sm">We craft every detail to align with your lifestyle and space.</p>
                <a href="{{ route('bookings.create') }}" class="mt-4 inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Schedule a consult</a>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">What’s included</p>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Material sourcing & fabrication</li>
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>On-site measurements & install</li>
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Care & maintenance guidance</li>
                </ul>
            </div>
        </aside>
    </div>
</section>
@endsection
