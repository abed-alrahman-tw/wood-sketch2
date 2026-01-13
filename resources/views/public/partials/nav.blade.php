<header class="border-b border-white/10 bg-slate-950/80 backdrop-blur">
    <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide">
            {{ $settings?->site_name ?? config('app.name') }}
        </a>
        <nav class="hidden items-center gap-6 text-sm md:flex">
            <a class="hover:text-amber-300" href="{{ route('portfolio.index') }}">Portfolio</a>
            <a class="hover:text-amber-300" href="{{ route('services.index') }}">Services</a>
            <a class="hover:text-amber-300" href="{{ route('about') }}">About</a>
            <a class="hover:text-amber-300" href="{{ route('contact.show') }}">Contact</a>
        </nav>
        <a href="{{ route('contact.show') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-900">
            Request a Quote
        </a>
    </div>
</header>
