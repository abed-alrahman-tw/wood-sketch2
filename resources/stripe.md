# Stripe deposit payments

## Environment variables

Add the following entries to your `.env` file:

```dotenv
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_CURRENCY=gbp
```

## Local testing with Stripe CLI

1. Install and log in to the Stripe CLI.
2. Start your Laravel server (for example, `php artisan serve`).
3. Run the webhook listener and forward events to the app:

```bash
stripe listen --forward-to http://localhost:8000/stripe/webhook
```

4. Trigger a test event after creating a Checkout Session through the deposit page:

```bash
stripe trigger checkout.session.completed
```

5. Confirm the job updates in the admin customer view (deposit paid + payment intent ID).
