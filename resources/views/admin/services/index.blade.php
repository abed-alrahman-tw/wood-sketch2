@extends('admin.layout')

@section('title', 'Services')
@section('heading', 'Services')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-600">Manage services offered to customers.</p>
        <a class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500" href="{{ route('admin.services.create') }}">
            New Service
        </a>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Starting Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($services as $service)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $service->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $service->starting_price ? '$'.number_format($service->starting_price, 2) : '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $service->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <div class="inline-flex items-center gap-2">
                                <a class="text-indigo-600 hover:text-indigo-900" href="{{ route('admin.services.edit', $service) }}">Edit</a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-8 text-center text-sm text-gray-500" colspan="4">No services yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
@endsection
