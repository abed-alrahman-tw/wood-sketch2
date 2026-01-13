<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\StripeClient;

class DepositController extends Controller
{
    public function show(Job $job, string $token): View
    {
        $this->assertTokenMatches($job, $token);

        $job->load('customer');

        return view('public.deposit', [
            'job' => $job,
            'customer' => $job->customer,
            'depositAmount' => $job->depositAmount(),
        ]);
    }

    public function checkout(Request $request, Job $job, string $token): RedirectResponse
    {
        $this->assertTokenMatches($job, $token);

        if ($job->deposit_paid) {
            return back()->with('error', 'This deposit has already been paid.');
        }

        $depositAmount = $job->depositAmount();
        if (! $depositAmount || $depositAmount <= 0) {
            return back()->with('error', 'Deposit amount is not configured.');
        }

        $stripeSecret = env('STRIPE_SECRET');
        if (! $stripeSecret) {
            return back()->with('error', 'Stripe is not configured.');
        }

        $stripe = new StripeClient($stripeSecret);
        $currency = env('STRIPE_CURRENCY', 'gbp');
        $successUrl = route('deposit.show', ['job' => $job->id, 'token' => $token]).'?success=1';
        $cancelUrl = route('deposit.show', ['job' => $job->id, 'token' => $token]).'?canceled=1';

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'client_reference_id' => (string) $job->id,
            'customer_email' => $job->customer?->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => (int) round($depositAmount * 100),
                    'product_data' => [
                        'name' => 'Job #'.$job->id.' deposit',
                    ],
                ],
            ]],
            'payment_intent_data' => [
                'metadata' => [
                    'job_id' => $job->id,
                    'deposit_amount' => number_format($depositAmount, 2, '.', ''),
                    'deposit_type' => $job->deposit_type,
                ],
            ],
            'metadata' => [
                'job_id' => $job->id,
            ],
        ]);

        return redirect()->away($session->url);
    }

    private function assertTokenMatches(Job $job, string $token): void
    {
        if (! $job->deposit_link_token || ! hash_equals($job->deposit_link_token, $token)) {
            abort(403);
        }
    }
}
