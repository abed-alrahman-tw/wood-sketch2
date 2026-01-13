<?php

use App\Http\Controllers\Admin\JobDepositController;
use App\Http\Controllers\Public\DepositController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/deposit/{job}/{token}', [DepositController::class, 'show'])->name('deposit.show');
Route::post('/deposit/{job}/{token}/checkout', [DepositController::class, 'checkout'])->name('deposit.checkout');
Route::post('/stripe/webhook', StripeWebhookController::class)->name('stripe.webhook');

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        Route::patch('jobs/{job}/deposit', [JobDepositController::class, 'update'])
            ->name('admin.jobs.deposit.update');
        Route::post('jobs/{job}/deposit/send', [JobDepositController::class, 'sendLink'])
            ->name('admin.jobs.deposit.send');
    });
