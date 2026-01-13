@extends('admin.layout')

@section('title', $customer->name)
@section('heading', 'Customer: '.$customer->name)

@section('content')
<div class="space-y-6">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Customer details</h2>
        <dl class="mt-4 grid gap-4 text-sm text-gray-700 sm:grid-cols-2">
            <div>
                <dt class="text-xs uppercase tracking-widest text-gray-400">Name</dt>
                <dd class="mt-1 font-semibold text-gray-900">{{ $customer->name }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-widest text-gray-400">Contact</dt>
                <dd class="mt-1">{{ $customer->phone }}</dd>
                <dd class="text-xs text-gray-500">{{ $customer->email ?? 'No email on file' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-widest text-gray-400">Default address</dt>
                <dd class="mt-1">{{ $customer->default_address_text ?? 'Not provided' }}</dd>
                <dd class="text-xs text-gray-500">{{ $customer->postcode }}</dd>
            </div>
        </dl>
        @if ($customer->notes)
            <div class="mt-4 rounded-lg bg-gray-50 p-4 text-sm text-gray-700">
                {{ $customer->notes }}
            </div>
        @endif
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Jobs</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Job</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Quote</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Booking</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($customer->jobs as $job)
                        <tr>
                            <td class="px-4 py-4 font-semibold text-gray-900">#{{ $job->id }}</td>
                            <td class="px-4 py-4 text-gray-700">{{ ucfirst($job->status) }}</td>
                            <td class="px-4 py-4 text-gray-700">
                                @if ($job->quoteRequest)
                                    <a href="{{ route('admin.quote-requests.show', $job->quoteRequest) }}" class="font-semibold text-indigo-600">Quote #{{ $job->quoteRequest->id }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-4 text-gray-700">
                                @if ($job->booking)
                                    <a href="{{ route('admin.bookings.show', $job->booking) }}" class="font-semibold text-indigo-600">Booking #{{ $job->booking->id }}</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No jobs yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Quotes</h2>
            <div class="mt-4 space-y-3 text-sm text-gray-700">
                @forelse ($customer->quoteRequests->unique('id') as $quote)
                    <div class="flex items-center justify-between rounded-lg border border-gray-100 px-3 py-2">
                        <div>
                            <p class="font-semibold text-gray-900">Quote #{{ $quote->id }}</p>
                            <p class="text-xs text-gray-500">{{ $quote->created_at->format('M j, Y') }}</p>
                        </div>
                        <a href="{{ route('admin.quote-requests.show', $quote) }}" class="font-semibold text-indigo-600">View</a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No quotes linked yet.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Bookings</h2>
            <div class="mt-4 space-y-3 text-sm text-gray-700">
                @forelse ($customer->bookings->unique('id') as $booking)
                    <div class="flex items-center justify-between rounded-lg border border-gray-100 px-3 py-2">
                        <div>
                            <p class="font-semibold text-gray-900">Booking #{{ $booking->id }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->preferred_date?->format('M j, Y') }} · {{ $booking->preferred_time_range }}</p>
                        </div>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="font-semibold text-indigo-600">View</a>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No bookings linked yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
