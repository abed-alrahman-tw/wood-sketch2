<footer class="border-t border-white/10 bg-slate-950">
    <div class="mx-auto w-full max-w-6xl px-6 py-12">
        <div class="grid gap-8 md:grid-cols-3">
            <div>
                <p class="text-lg font-semibold">{{ $settings?->site_name ?? config('app.name') }}</p>
                <p class="mt-2 text-sm text-slate-400">{{ $settings?->hero_subtitle ?? 'Crafting bespoke spaces and heirloom woodwork.' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Studio</p>
                <p class="mt-3 text-sm text-slate-300">{{ $settings?->city ?? 'Local service area' }}</p>
                <p class="text-sm text-slate-300">{{ $settings?->phone ?? 'Phone available on request' }}</p>
                <p class="text-sm text-slate-300">{{ $settings?->email ?? '' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Quick Links</p>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a class="hover:text-amber-300" href="{{ route('portfolio.index') }}">Portfolio</a></li>
                    <li><a class="hover:text-amber-300" href="{{ route('services.index') }}">Services</a></li>
                    <li><a class="hover:text-amber-300" href="{{ route('about') }}">About</a></li>
                    <li><a class="hover:text-amber-300" href="{{ route('contact.show') }}">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-10 flex flex-col items-start justify-between gap-4 border-t border-white/10 pt-6 text-xs text-slate-500 md:flex-row">
            <p>&copy; {{ now()->year }} {{ $settings?->site_name ?? config('app.name') }}. All rights reserved.</p>
            <p>Serving {{ $settings?->city ?? 'your area' }} and surrounding regions.</p>
        </div>
    </div>
</footer>
