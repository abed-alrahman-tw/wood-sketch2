@extends('admin.layout')

@section('title', 'Quote Requests')
@section('heading', 'Quote Requests')

@section('content')
<div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Service</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-widest text-gray-500">Submitted</th>
                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-widest text-gray-500">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($quoteRequests as $quoteRequest)
                <tr>
                    <td class="px-4 py-4 text-sm font-medium text-gray-900">#{{ $quoteRequest->id }}</td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        <p class="font-semibold">{{ $quoteRequest->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $quoteRequest->phone }}</p>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">
                        {{ $quoteRequest->service?->name ?? 'General inquiry' }}
                    </td>
                    <td class="px-4 py-4 text-sm">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $quoteRequest->status === 'closed' ? 'bg-gray-200 text-gray-700' : ($quoteRequest->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                            {{ str_replace('_', ' ', ucfirst($quoteRequest->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-700">{{ $quoteRequest->created_at->format('M j, Y') }}</td>
                    <td class="px-4 py-4 text-right text-sm">
                        <a href="{{ route('admin.quote-requests.show', $quoteRequest) }}" class="font-semibold text-indigo-600 hover:text-indigo-800">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">No quote requests yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $quoteRequests->links() }}
</div>
@endsection
