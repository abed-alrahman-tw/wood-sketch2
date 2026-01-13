<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $secret = env('STRIPE_WEBHOOK_SECRET');
        if (! $secret) {
            return response('Stripe webhook secret not configured.', 500);
        }

        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $signature, $secret);
        } catch (SignatureVerificationException $exception) {
            return response('Invalid signature.', 400);
        } catch (\UnexpectedValueException $exception) {
            return response('Invalid payload.', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $jobId = $session->metadata->job_id ?? $session->client_reference_id ?? null;

            if ($jobId) {
                $job = Job::query()->find($jobId);
                if ($job && ! $job->deposit_paid) {
                    $job->update([
                        'deposit_paid' => true,
                        'stripe_payment_intent_id' => $session->payment_intent,
                    ]);
                }
            }
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $jobId = $intent->metadata->job_id ?? null;

            if ($jobId) {
                $job = Job::query()->find($jobId);
                if ($job && ! $job->deposit_paid) {
                    $job->update([
                        'deposit_paid' => true,
                        'stripe_payment_intent_id' => $intent->id,
                    ]);
                }
            }
        }

        return response('Webhook handled.', 200);
    }
}
