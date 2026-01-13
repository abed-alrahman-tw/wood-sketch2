@extends('public.layout')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="grid gap-10 lg:grid-cols-[3fr,2fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-amber-300">Booking Request</p>
            <h1 class="mt-2 text-4xl font-semibold">Book your consultation</h1>
            <p class="mt-4 text-lg text-slate-300">Share your details and choose a location for your project visit.</p>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-400/30 bg-rose-500/10 px-5 py-4 text-rose-100">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-200">Full name *</label>
                        <input name="full_name" value="{{ old('full_name') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Phone *</label>
                        <input name="phone" value="{{ old('phone') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Service</label>
                        <select name="service_id" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100">
                            <option value="">Select a service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Service type (optional)</label>
                        <input name="service_type" value="{{ old('service_type') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Preferred date *</label>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Preferred time range *</label>
                        <input name="preferred_time_range" value="{{ old('preferred_time_range') }}" required placeholder="e.g. 9am - 12pm" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Address</label>
                        <input name="address_text" value="{{ old('address_text') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-200">Postcode</label>
                        <input name="postcode" value="{{ old('postcode') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100" />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-200">Project notes</label>
                    <textarea name="message" rows="4" class="mt-2 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-slate-100">{{ old('message') }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-200">Attachment (optional)</label>
                    <input type="file" name="attachment" class="mt-2 w-full text-sm text-slate-200" />
                </div>

                <input type="hidden" name="latitude" id="booking-latitude" value="{{ old('latitude') }}" required />
                <input type="hidden" name="longitude" id="booking-longitude" value="{{ old('longitude') }}" required />
                <input type="hidden" name="is_outside_service_area" id="booking-outside" value="{{ old('is_outside_service_area') }}" />

                <button type="submit" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900">Submit booking request</button>
            </form>
        </div>

        <aside class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Pick your location</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <input id="location-search" type="text" placeholder="Search an address" class="flex-1 rounded-xl border border-white/10 bg-slate-900/60 px-4 py-2 text-sm text-slate-100" />
                    <button type="button" id="search-button" class="rounded-full border border-white/10 px-4 py-2 text-xs font-semibold">Search</button>
                    <button type="button" id="location-button" class="rounded-full border border-white/10 px-4 py-2 text-xs font-semibold">Use my location</button>
                </div>
                <div id="search-results" class="mt-4 space-y-2 text-sm text-slate-200"></div>
                <div id="map" class="mt-4 h-64 w-full rounded-2xl"></div>
                <p class="mt-4 text-xs text-slate-400">Service area is {{ $settings?->service_radius_miles ?? 20 }} miles from Steyning.</p>
                <div id="service-warning" class="mt-3 hidden rounded-xl border border-amber-400/40 bg-amber-400/10 px-4 py-3 text-xs text-amber-100">
                    This location is outside our usual service area. We will review your request.
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">What happens next</p>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>We confirm your preferred time window.</li>
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>We review the location and project notes.</li>
                    <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>We send a follow-up with next steps.</li>
                </ul>
            </div>
        </aside>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const defaultCenter = {
        lat: {{ $defaultCenter['lat'] }},
        lng: {{ $defaultCenter['lng'] }},
    };
    const serviceRadiusMiles = {{ $settings?->service_radius_miles ?? 20 }};
    const map = L.map('map').setView([defaultCenter.lat, defaultCenter.lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    L.circle([defaultCenter.lat, defaultCenter.lng], {
        radius: serviceRadiusMiles * 1609.34,
        color: '#fbbf24',
        fillColor: '#fbbf24',
        fillOpacity: 0.15,
    }).addTo(map);

    const marker = L.marker([defaultCenter.lat, defaultCenter.lng], { draggable: true }).addTo(map);

    const latitudeInput = document.getElementById('booking-latitude');
    const longitudeInput = document.getElementById('booking-longitude');
    const outsideInput = document.getElementById('booking-outside');
    const warningEl = document.getElementById('service-warning');
    const resultsEl = document.getElementById('search-results');

    function toRad(value) {
        return value * Math.PI / 180;
    }

    function updateLocation(lat, lng) {
        marker.setLatLng([lat, lng]);
        latitudeInput.value = lat.toFixed(7);
        longitudeInput.value = lng.toFixed(7);

        const earthRadius = 3959;
        const dLat = toRad(lat - defaultCenter.lat);
        const dLng = toRad(lng - defaultCenter.lng);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2)
            + Math.cos(toRad(defaultCenter.lat)) * Math.cos(toRad(lat))
            * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = earthRadius * c;

        if (distance > serviceRadiusMiles) {
            outsideInput.value = '1';
            warningEl.classList.remove('hidden');
        } else {
            outsideInput.value = '0';
            warningEl.classList.add('hidden');
        }
    }

    updateLocation(defaultCenter.lat, defaultCenter.lng);

    map.on('click', (event) => {
        updateLocation(event.latlng.lat, event.latlng.lng);
    });

    marker.on('dragend', () => {
        const position = marker.getLatLng();
        updateLocation(position.lat, position.lng);
    });

    document.getElementById('location-button').addEventListener('click', () => {
        if (!navigator.geolocation) {
            return;
        }

        navigator.geolocation.getCurrentPosition((position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            updateLocation(lat, lng);
            map.setView([lat, lng], 14);
        });
    });

    document.getElementById('search-button').addEventListener('click', async () => {
        const query = document.getElementById('location-search').value.trim();
        resultsEl.innerHTML = '';
        if (!query) {
            return;
        }

        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`;
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
            },
        });
        const data = await response.json();

        if (!data.length) {
            resultsEl.innerHTML = '<p class="text-xs text-slate-400">No results found.</p>';
            return;
        }

        data.forEach((result) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'w-full rounded-xl border border-white/10 px-3 py-2 text-left text-xs hover:border-amber-300';
            button.textContent = result.display_name;
            button.addEventListener('click', () => {
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);
                updateLocation(lat, lng);
                map.setView([lat, lng], 14);
            });
            resultsEl.appendChild(button);
        });
    });
</script>
@endsection
