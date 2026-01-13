@extends('admin.layout')

@section('title', 'Bookings')
@section('heading', 'Bookings')

@section('content')
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Service</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Preferred</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Status</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-widest text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($bookings as $booking)
                <tr>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        <p class="font-semibold">{{ $booking->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->phone }}</p>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        {{ $booking->service?->name ?? $booking->service_type ?? 'General' }}
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        {{ $booking->preferred_date?->format('M j, Y') }}<br>
                        <span class="text-xs text-gray-500">{{ $booking->preferred_time_range }}</span>
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $booking->status === 'approved' ? 'bg-green-100 text-green-700' : ($booking->status === 'declined' ? 'bg-red-100 text-red-700' : ($booking->status === 'rescheduled' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-right text-sm">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="font-semibold text-indigo-600 hover:text-indigo-800">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">No bookings yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $bookings->links() }}
</div>
@endsection
