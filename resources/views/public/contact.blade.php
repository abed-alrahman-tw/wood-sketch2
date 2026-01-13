@extends('public.layout')

@section('content')
<section class="mx-auto w-full max-w-6xl px-6 py-16">
    <div class="grid gap-10 lg:grid-cols-[2fr,1fr]">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Get a Quick Quote</p>
            <h1 class="mt-2 text-4xl font-semibold">Tell us about your project</h1>
            <p class="mt-4 text-lg text-slate-300">Share your vision, timeline, and photos. We'll respond with next steps and a tailored estimate.</p>

            @if(session('status'))
                <div class="mt-6 rounded-2xl border border-emerald-400/40 bg-emerald-400/10 p-4 text-sm text-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" class="mt-8 space-y-4">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">
                        @error('full_name')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">
                        @error('phone')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">
                    @error('email')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Service</label>
                    <select name="service_id" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">
                        <option value="">Select a service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Message</label>
                    <textarea name="message" rows="5" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Project photos</label>
                    <input type="file" name="photos[]" multiple class="mt-2 w-full text-sm text-slate-200">
                    <p class="mt-1 text-xs text-slate-400">Upload up to a few inspiration shots or existing space photos.</p>
                    @error('photos.*')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Location (optional)</label>
                        <input type="text" name="address_text" value="{{ old('address_text') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white" placeholder="Neighborhood or street">
                        @error('address_text')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Postcode</label>
                        <input type="text" name="postcode" value="{{ old('postcode') }}" class="mt-2 w-full rounded-xl border border-white/10 bg-slate-950 px-4 py-3 text-sm text-white">
                        @error('postcode')<p class="mt-1 text-xs text-red-300">{{ $message }}</p>@enderror
                    </div>
                </div>
                <button type="submit" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-900">Request Quote</button>
            </form>
        </div>
        <aside class="space-y-6">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Studio</p>
                <p class="mt-3 text-sm text-slate-300">{{ $settings?->city ?? 'Local area' }}</p>
                <p class="text-sm text-slate-300">{{ $settings?->phone ?? '' }}</p>
                <p class="text-sm text-slate-300">{{ $settings?->email ?? '' }}</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Response time</p>
                <p class="mt-3 text-sm text-slate-300">We typically reply within 1-2 business days with next steps and availability.</p>
            </div>
        </aside>
    </div>
</section>
@endsection
