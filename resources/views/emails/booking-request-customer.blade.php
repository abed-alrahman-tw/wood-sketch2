<p>Hi {{ $booking->full_name }},</p>

<p>Thanks for your booking request. We have received the following details:</p>
<ul>
    <li><strong>Preferred date:</strong> {{ $booking->preferred_date?->format('M j, Y') }}</li>
    <li><strong>Preferred time:</strong> {{ $booking->preferred_time_range }}</li>
    <li><strong>Service:</strong> {{ $booking->service?->name ?? $booking->service_type ?? 'General' }}</li>
</ul>

<p>We will review your request and get back to you shortly.</p>

<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
