<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class JobDepositController extends Controller
{
    public function update(Request $request, Job $job): RedirectResponse
    {
        $data = $request->validate([
            'deposit_type' => ['required', 'in:fixed,percent'],
            'deposit_amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        if ($data['deposit_type'] === 'percent') {
            $request->validate([
                'deposit_amount' => ['numeric', 'min:1', 'max:100'],
            ]);

            if (! $job->price_final) {
                return back()->with('error', 'Set a final price before using a percentage deposit.');
            }
        }

        $job->update([
            'deposit_type' => $data['deposit_type'],
            'deposit_amount' => $data['deposit_amount'],
        ]);

        return back()->with('success', 'Deposit settings updated.');
    }

    public function sendLink(Request $request, Job $job): RedirectResponse
    {
        $job->load('customer');

        if (! $job->customer?->email) {
            return back()->with('error', 'Customer email is required to send a deposit link.');
        }

        if (! $job->deposit_type || ! $job->deposit_amount) {
            return back()->with('error', 'Set a deposit amount before generating a link.');
        }

        $depositTotal = $job->depositAmount();
        if (! $depositTotal || $depositTotal <= 0) {
            return back()->with('error', 'Deposit amount is invalid.');
        }

        $job->forceFill([
            'deposit_link_token' => Str::random(40),
            'deposit_link_sent_at' => now(),
        ])->save();

        $depositUrl = route('deposit.show', ['job' => $job->id, 'token' => $job->deposit_link_token]);

        Mail::send('emails.deposit-link', [
            'job' => $job,
            'customer' => $job->customer,
            'depositAmount' => $depositTotal,
            'depositUrl' => $depositUrl,
        ], function ($message) use ($job) {
            $message->to($job->customer->email, $job->customer->name)
                ->subject('Deposit payment link for Job #'.$job->id);
        });

        return back()->with('success', 'Deposit link sent to the customer.');
    }
}
