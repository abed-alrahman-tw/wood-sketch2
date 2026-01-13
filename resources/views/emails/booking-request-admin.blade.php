<p>New booking request received.</p>

<p><strong>Name:</strong> {{ $booking->full_name }}</p>
<p><strong>Phone:</strong> {{ $booking->phone }}</p>
@if ($booking->email)
    <p><strong>Email:</strong> {{ $booking->email }}</p>
@endif
<p><strong>Service:</strong> {{ $booking->service?->name ?? $booking->service_type ?? 'General' }}</p>
<p><strong>Preferred:</strong> {{ $booking->preferred_date?->format('M j, Y') }} ({{ $booking->preferred_time_range }})</p>
<p><strong>Address:</strong> {{ $booking->address_text ?? 'Not provided' }} {{ $booking->postcode }}</p>
<p><strong>Coordinates:</strong> {{ $booking->latitude }}, {{ $booking->longitude }}</p>
<p><strong>Outside service area:</strong> {{ $booking->is_outside_service_area ? 'Yes' : 'No' }}</p>

@if ($booking->message)
    <p><strong>Notes:</strong> {{ $booking->message }}</p>
@endif

<p>View booking in the admin panel for approval.</p>
<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
