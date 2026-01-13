<p>Hello,</p>
<p>You have received a new contact request.</p>
<ul>
    <li><strong>Name:</strong> {{ $quoteRequest->full_name }}</li>
    <li><strong>Email:</strong> {{ $quoteRequest->email ?? 'Not provided' }}</li>
    <li><strong>Phone:</strong> {{ $quoteRequest->phone }}</li>
    <li><strong>Service:</strong> {{ $quoteRequest->service?->name ?? 'General inquiry' }}</li>
    <li><strong>Location:</strong> {{ $quoteRequest->address_text ?? 'Not provided' }}</li>
    <li><strong>Postcode:</strong> {{ $quoteRequest->postcode ?? 'Not provided' }}</li>
</ul>
<p><strong>Message:</strong></p>
<p>{{ $quoteRequest->message ?? 'No additional details provided.' }}</p>

@if (!empty($quoteRequest->photos))
    <p><strong>Photos:</strong></p>
    <ul>
        @foreach ($quoteRequest->photos as $photo)
            <li><a href="{{ asset('storage/'.$photo) }}">View photo</a></li>
        @endforeach
    </ul>
@endif
<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
