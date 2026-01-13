<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        $settings = SiteSetting::query()->first();
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $seo = Seo::baseMeta($settings, [
            'title' => 'Contact | '.($settings?->site_name ?? config('app.name')),
            'description' => 'Request a quote or start a custom project with our woodworking team.',
        ]);

        return view('public.contact', compact('settings', 'services', 'seo'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'service_id' => ['nullable', 'exists:services,id'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $quoteRequest = QuoteRequest::query()->create($data);
        $quoteRequest->load('service');
        $settings = SiteSetting::query()->first();
        $adminEmail = $settings?->email ?? config('mail.from.address');

        if ($adminEmail) {
            Mail::send('emails.contact-request', [
                'quoteRequest' => $quoteRequest,
                'settings' => $settings,
            ], function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('New Contact Request');
            });
        }

        return redirect()
            ->route('contact.show')
            ->with('status', 'Thanks for reaching out! We will be in touch shortly.');
    }
}
