<p>Hello,</p>
<p>You have received a new contact request.</p>
<ul>
    <li><strong>Name:</strong> {{ $quoteRequest->full_name }}</li>
    <li><strong>Email:</strong> {{ $quoteRequest->email ?? 'Not provided' }}</li>
    <li><strong>Phone:</strong> {{ $quoteRequest->phone }}</li>
    <li><strong>Service:</strong> {{ $quoteRequest->service?->name ?? 'General inquiry' }}</li>
</ul>
<p><strong>Message:</strong></p>
<p>{{ $quoteRequest->message ?? 'No additional details provided.' }}</p>
<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
