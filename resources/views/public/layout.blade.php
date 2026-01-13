<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('public.partials.seo')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .smooth-transitions * { transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease; }
        .media-frame.is-loading::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(30,41,59,0.3) 0%, rgba(51,65,85,0.6) 50%, rgba(30,41,59,0.3) 100%);
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</head>
@php($isLowData = request()->cookie('low_data') === '1')
<body class="bg-slate-950 text-slate-100 antialiased smooth-transitions" data-low-data="{{ $isLowData ? 'true' : 'false' }}">
    @include('public.partials.nav')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('public.partials.footer')

    @php
        $whatsAppNumber = preg_replace('/\D+/', '', $settings?->whatsapp ?? '');
        $callNumber = preg_replace('/\D+/', '', $settings?->phone ?? '');
    @endphp
    @if($whatsAppNumber || $callNumber)
        <div class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">
            @if($whatsAppNumber)
                <a href="https://wa.me/{{ $whatsAppNumber }}" class="flex items-center gap-2 rounded-full bg-green-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-green-500/30 hover:-translate-y-0.5" aria-label="Chat on WhatsApp">
                    <span aria-hidden="true">💬</span> WhatsApp
                </a>
            @endif
            @if($callNumber)
                <a href="tel:{{ $callNumber }}" class="flex items-center gap-2 rounded-full bg-amber-400 px-4 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-amber-500/30 hover:-translate-y-0.5" aria-label="Call now">
                    <span aria-hidden="true">📞</span> Call
                </a>
            @endif
        </div>
    @endif

    <script>
        const lowDataToggle = document.querySelector('[data-low-data-toggle]');
        const applyLowDataState = (enabled) => {
            document.body.dataset.lowData = enabled ? 'true' : 'false';
            if (lowDataToggle) {
                lowDataToggle.setAttribute('aria-pressed', enabled ? 'true' : 'false');
                lowDataToggle.textContent = enabled ? 'Low data: On' : 'Low data: Off';
            }
        };

        if (lowDataToggle) {
            const isEnabled = document.body.dataset.lowData === 'true';
            applyLowDataState(isEnabled);
            lowDataToggle.addEventListener('click', () => {
                const next = document.body.dataset.lowData !== 'true';
                document.cookie = `low_data=${next ? '1' : '0'}; path=/`;
                applyLowDataState(next);
            });
        }

        document.querySelectorAll('.media-frame.is-loading img').forEach((img) => {
            if (img.complete) {
                img.parentElement?.classList.remove('is-loading');
                return;
            }
            img.addEventListener('load', () => img.parentElement?.classList.remove('is-loading'));
        });

        document.querySelectorAll('[data-video-placeholder]').forEach((button) => {
            button.addEventListener('click', () => {
                const wrapper = button.closest('[data-video-wrapper]');
                if (!wrapper) return;
                const source = wrapper.dataset.videoSource;
                if (!source) return;
                const video = document.createElement('video');
                video.className = 'w-full rounded-lg';
                video.controls = true;
                const src = document.createElement('source');
                src.src = source;
                src.type = 'video/mp4';
                video.appendChild(src);
                wrapper.innerHTML = '';
                wrapper.appendChild(video);
            });
        });
    </script>
</body>
</html>
