<header class="border-b border-white/10 bg-slate-950/80 backdrop-blur">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide">
            {{ $settings?->site_name ?? config('app.name') }}
        </a>
        <nav class="hidden items-center gap-6 text-sm md:flex">
            <a class="hover:text-amber-300" href="{{ route('portfolio.index') }}">Portfolio</a>
            <a class="hover:text-amber-300" href="{{ route('services.index') }}">Services</a>
            <a class="hover:text-amber-300" href="{{ route('about') }}">About</a>
            <a class="hover:text-amber-300" href="{{ route('reviews') }}">Reviews</a>
            <a class="hover:text-amber-300" href="{{ route('videos') }}">Videos</a>
            <a class="hover:text-amber-300" href="{{ route('bookings.create') }}">Book</a>
            <a class="hover:text-amber-300" href="{{ route('contact.show') }}">Quick Quote</a>
            <button type="button" data-low-data-toggle class="rounded-full border border-white/20 px-3 py-1 text-xs font-semibold text-slate-200 hover:border-amber-300 hover:text-amber-300" aria-pressed="false">
                Low data: Off
            </button>
        </nav>
        <a href="{{ route('bookings.create') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900">
            Book a Consultation
        </a>
    </div>
</header>
