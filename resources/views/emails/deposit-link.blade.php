<p>Hi {{ $customer->name }},</p>

<p>Your deposit for Job #{{ $job->id }} is ready. The amount due is <strong>£{{ number_format($depositAmount, 2) }}</strong>.</p>

<p><a href="{{ $depositUrl }}">Pay your deposit securely</a></p>

<p>If you have any questions, just reply to this email.</p>

<p>— {{ $settings?->site_name ?? config('app.name') }}</p>
