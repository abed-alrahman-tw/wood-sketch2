<p>Hi {{ $booking->full_name }},</p>

<p>Your booking request status is now <strong>{{ ucfirst($booking->status) }}</strong>.</p>

@if ($booking->approved_start_at && $booking->approved_end_at)
    <p><strong>Approved window:</strong> {{ $booking->approved_start_at->format('M j, Y g:ia') }} - {{ $booking->approved_end_at->format('M j, Y g:ia') }}</p>
@endif

@if ($booking->proposed_date || $booking->proposed_time_range)
    <p><strong>Proposed schedule:</strong> {{ $booking->proposed_date?->format('M j, Y') }} {{ $booking->proposed_time_range }}</p>
@endif

@if ($booking->admin_notes)
    <p><strong>Notes:</strong> {{ $booking->admin_notes }}</p>
@endif

<p>Please reply to this email if you have questions.</p>

<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
