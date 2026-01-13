@extends('admin.layout')

@section('title', 'Booking #'.$booking->id)
@section('heading', 'Booking #'.$booking->id)

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Booking details</h2>
            <dl class="mt-4 grid gap-4 text-sm text-gray-700 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Customer</dt>
                    <dd class="mt-1 font-semibold text-gray-900">{{ $booking->full_name }}</dd>
                    <dd class="text-xs text-gray-500">{{ $booking->phone }}</dd>
                    @if ($booking->email)
                        <dd class="text-xs text-gray-500">{{ $booking->email }}</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Service</dt>
                    <dd class="mt-1">{{ $booking->service?->name ?? $booking->service_type ?? 'General' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Preferred</dt>
                    <dd class="mt-1">{{ $booking->preferred_date?->format('M j, Y') }}</dd>
                    <dd class="text-xs text-gray-500">{{ $booking->preferred_time_range }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Status</dt>
                    <dd class="mt-1 font-semibold">{{ ucfirst($booking->status) }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Address</dt>
                    <dd class="mt-1">{{ $booking->address_text ?? 'Not provided' }}</dd>
                    <dd class="text-xs text-gray-500">{{ $booking->postcode }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Service area</dt>
                    <dd class="mt-1">{{ $booking->is_outside_service_area ? 'Outside radius' : 'Inside radius' }}</dd>
                </div>
            </dl>

            @if ($booking->message)
                <div class="mt-4 rounded-lg bg-gray-50 p-4 text-sm text-gray-700">
                    {{ $booking->message }}
                </div>
            @endif

            @if ($booking->attachment)
                <div class="mt-4 text-sm">
                    <a href="{{ asset('storage/'.$booking->attachment) }}" class="font-semibold text-indigo-600">View attachment</a>
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Location map</h2>
                <a href="https://maps.google.com/?q={{ $booking->latitude }},{{ $booking->longitude }}" target="_blank" rel="noopener" class="text-sm font-semibold text-indigo-600">Open in Google Maps</a>
            </div>
            <div id="booking-map" class="mt-4 h-72 w-full rounded-xl"></div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Update status</h2>
            <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <option value="approved" @selected(old('status', $booking->status) === 'approved')>Approved</option>
                        <option value="declined" @selected(old('status', $booking->status) === 'declined')>Declined</option>
                        <option value="rescheduled" @selected(old('status', $booking->status) === 'rescheduled')>Rescheduled</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Approved start</label>
                    <input type="datetime-local" name="approved_start_at" value="{{ old('approved_start_at', optional($booking->approved_start_at)->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Approved end</label>
                    <input type="datetime-local" name="approved_end_at" value="{{ old('approved_end_at', optional($booking->approved_end_at)->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Proposed date (reschedule)</label>
                    <input type="date" name="proposed_date" value="{{ old('proposed_date', optional($booking->proposed_date)->format('Y-m-d')) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Proposed time range</label>
                    <input name="proposed_time_range" value="{{ old('proposed_time_range', $booking->proposed_time_range) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Admin notes</label>
                    <textarea name="admin_notes" rows="4" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="w-full rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save changes</button>
            </form>
        </div>
    </aside>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const map = L.map('booking-map').setView([{{ $booking->latitude }}, {{ $booking->longitude }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    L.marker([{{ $booking->latitude }}, {{ $booking->longitude }}]).addTo(map);

    L.circle([50.887, -0.327], {
        radius: {{ $settings?->service_radius_miles ?? 20 }} * 1609.34,
        color: '#6366f1',
        fillColor: '#6366f1',
        fillOpacity: 0.1,
    }).addTo(map);
</script>
@endsection
