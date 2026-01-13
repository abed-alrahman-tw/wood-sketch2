@extends('admin.layout')

@section('title', 'Quote #'.$quoteRequest->id)
@section('heading', 'Quote #'.$quoteRequest->id)

@section('content')
<div class="grid gap-8 lg:grid-cols-[2fr,1fr]">
    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Quote details</h2>
            <dl class="mt-4 grid gap-4 text-sm text-gray-700 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Customer</dt>
                    <dd class="mt-1 font-semibold text-gray-900">{{ $quoteRequest->full_name }}</dd>
                    <dd class="text-xs text-gray-500">{{ $quoteRequest->phone }}</dd>
                    @if ($quoteRequest->email)
                        <dd class="text-xs text-gray-500">{{ $quoteRequest->email }}</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Service</dt>
                    <dd class="mt-1">{{ $quoteRequest->service?->name ?? 'General inquiry' }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Status</dt>
                    <dd class="mt-1 font-semibold">{{ str_replace('_', ' ', ucfirst($quoteRequest->status)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Submitted</dt>
                    <dd class="mt-1">{{ $quoteRequest->created_at->format('M j, Y g:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Location</dt>
                    <dd class="mt-1">{{ $quoteRequest->address_text ?? 'Not provided' }}</dd>
                    <dd class="text-xs text-gray-500">{{ $quoteRequest->postcode }}</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-gray-400">Estimate range</dt>
                    <dd class="mt-1">
                        @if ($quoteRequest->estimated_range_min || $quoteRequest->estimated_range_max)
                            £{{ number_format($quoteRequest->estimated_range_min ?? 0, 2) }} - £{{ number_format($quoteRequest->estimated_range_max ?? 0, 2) }}
                        @else
                            Not set
                        @endif
                    </dd>
                </div>
            </dl>

            @if ($quoteRequest->message)
                <div class="mt-4 rounded-lg bg-gray-50 p-4 text-sm text-gray-700">
                    {{ $quoteRequest->message }}
                </div>
            @endif

            @if (!empty($quoteRequest->photos))
                <div class="mt-4">
                    <p class="text-sm font-semibold text-gray-900">Photos</p>
                    <ul class="mt-2 space-y-2 text-sm">
                        @foreach ($quoteRequest->photos as $photo)
                            <li>
                                <a href="{{ asset('storage/'.$photo) }}" class="font-semibold text-indigo-600">View photo</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">CRM links</h2>
            <div class="mt-4 text-sm text-gray-700 space-y-2">
                @if ($quoteRequest->job)
                    <p>
                        Job #{{ $quoteRequest->job->id }} —
                        <a href="{{ route('admin.customers.show', $quoteRequest->job->customer) }}" class="font-semibold text-indigo-600">View customer</a>
                    </p>
                    @if ($quoteRequest->job->booking)
                        <p>Booking #{{ $quoteRequest->job->booking->id }}</p>
                    @endif
                @else
                    <p>No job created yet.</p>
                @endif
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Update status</h2>
            <form method="POST" action="{{ route('admin.quote-requests.update', $quoteRequest) }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <option value="new" @selected(old('status', $quoteRequest->status) === 'new')>New</option>
                        <option value="in_progress" @selected(old('status', $quoteRequest->status) === 'in_progress')>In progress</option>
                        <option value="closed" @selected(old('status', $quoteRequest->status) === 'closed')>Closed</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Estimate range min (£)</label>
                    <input type="number" step="0.01" name="estimated_range_min" value="{{ old('estimated_range_min', $quoteRequest->estimated_range_min) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Estimate range max (£)</label>
                    <input type="number" step="0.01" name="estimated_range_max" value="{{ old('estimated_range_max', $quoteRequest->estimated_range_max) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Admin notes</label>
                    <textarea name="admin_notes" rows="4" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">{{ old('admin_notes', $quoteRequest->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="w-full rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save changes</button>
            </form>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Convert to customer</h2>
            @if ($quoteRequest->job)
                <p class="mt-4 text-sm text-gray-600">This quote is already linked to a job.</p>
            @else
                <form method="POST" action="{{ route('admin.quote-requests.convert', $quoteRequest) }}" class="mt-4 space-y-4">
                    @csrf
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="create_booking" value="1" class="h-4 w-4 rounded border-gray-300">
                        <label class="text-sm text-gray-700">Create booking request</label>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Preferred date</label>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Preferred time range</label>
                        <input name="preferred_time_range" value="{{ old('preferred_time_range') }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Address text</label>
                        <input name="address_text" value="{{ old('address_text', $quoteRequest->address_text) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Postcode</label>
                        <input name="postcode" value="{{ old('postcode', $quoteRequest->postcode) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Latitude</label>
                        <input name="latitude" value="{{ old('latitude', $quoteRequest->latitude) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Longitude</label>
                        <input name="longitude" value="{{ old('longitude', $quoteRequest->longitude) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    </div>
                    <button type="submit" class="w-full rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Create customer &amp; job</button>
                </form>
            @endif
        </div>
    </aside>
</div>
@endsection
