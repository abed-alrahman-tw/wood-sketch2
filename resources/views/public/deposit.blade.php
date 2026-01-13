@extends('public.layout')

@section('content')
<section class="mx-auto max-w-3xl px-6 py-16">
    <div class="rounded-3xl border border-slate-800 bg-slate-900/60 p-8 shadow-xl">
        <h1 class="text-3xl font-semibold text-white">Pay your deposit</h1>
        <p class="mt-2 text-sm text-slate-300">Secure checkout powered by Stripe.</p>

        @if (request()->boolean('success'))
            <div class="mt-6 rounded-2xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-emerald-200">
                Deposit received! Thank you for completing your payment.
            </div>
        @endif

        @if (request()->boolean('canceled'))
            <div class="mt-6 rounded-2xl border border-amber-500/40 bg-amber-500/10 px-4 py-3 text-amber-200">
                Your checkout session was canceled. You can try again when ready.
            </div>
        @endif

        <div class="mt-8 space-y-4 text-slate-200">
            <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                <span class="uppercase tracking-[0.2em] text-slate-400">Job</span>
                <span class="font-semibold">#{{ $job->id }}</span>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                <span class="uppercase tracking-[0.2em] text-slate-400">Customer</span>
                <span class="font-semibold">{{ $customer?->name ?? 'Customer' }}</span>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                <span class="uppercase tracking-[0.2em] text-slate-400">Deposit due</span>
                <span class="text-2xl font-semibold text-white">£{{ number_format($depositAmount ?? 0, 2) }}</span>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                <span class="uppercase tracking-[0.2em] text-slate-400">Status</span>
                <span class="font-semibold {{ $job->deposit_paid ? 'text-emerald-300' : 'text-amber-200' }}">
                    {{ $job->deposit_paid ? 'Paid' : 'Awaiting payment' }}
                </span>
            </div>
        </div>

        @if (! $job->deposit_paid)
            <form method="POST" action="{{ route('deposit.checkout', ['job' => $job->id, 'token' => $job->deposit_link_token]) }}" class="mt-8">
                @csrf
                <button type="submit" class="w-full rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-400">
                    Pay deposit securely
                </button>
            </form>
        @endif

        <p class="mt-6 text-xs text-slate-500">If you have any questions, reply to the email with your deposit link.</p>
    </div>
</section>
@endsection
