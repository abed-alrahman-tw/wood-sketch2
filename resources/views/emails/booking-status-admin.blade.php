<p>The booking status has been updated.</p>

<p><strong>Booking:</strong> #{{ $booking->id }} ({{ $booking->full_name }})</p>
<p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

@if ($booking->approved_start_at && $booking->approved_end_at)
    <p><strong>Approved window:</strong> {{ $booking->approved_start_at->format('M j, Y g:ia') }} - {{ $booking->approved_end_at->format('M j, Y g:ia') }}</p>
@endif

@if ($booking->proposed_date || $booking->proposed_time_range)
    <p><strong>Proposed:</strong> {{ $booking->proposed_date?->format('M j, Y') }} {{ $booking->proposed_time_range }}</p>
@endif

@if ($booking->admin_notes)
    <p><strong>Notes:</strong> {{ $booking->admin_notes }}</p>
@endif

<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
