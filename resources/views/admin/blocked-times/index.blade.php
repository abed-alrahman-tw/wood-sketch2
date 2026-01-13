@extends('admin.layout')

@section('title', 'Blocked Times')
@section('heading', 'Blocked Times')

@section('content')
<div class="grid gap-8 lg:grid-cols-[1fr,2fr]">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Add blocked time</h2>
        <form method="POST" action="{{ route('admin.blocked-times.store') }}" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-medium text-gray-700">Start</label>
                <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required />
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">End</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required />
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700">Reason</label>
                <input name="reason" value="{{ old('reason') }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
            </div>
            <button type="submit" class="w-full rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Block time</button>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-900">Current blocked times</h2>
        <div class="mt-4 space-y-3">
            @forelse ($blockedTimes as $blockedTime)
                <div class="flex flex-wrap items-center justify-between gap-4 rounded-lg border border-gray-100 px-4 py-3 text-sm">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $blockedTime->start_at->format('M j, Y g:ia') }} - {{ $blockedTime->end_at->format('M j, Y g:ia') }}</p>
                        @if ($blockedTime->reason)
                            <p class="text-xs text-gray-500">{{ $blockedTime->reason }}</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.blocked-times.destroy', $blockedTime) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs font-semibold text-red-600">Remove</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500">No blocked times yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
